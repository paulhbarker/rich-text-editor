<template>
	<div class="quill-editor">
		<slot name="toolbar"></slot>
		<div ref="editor"></div>
	</div>
</template>

<script>
	import Quill from 'quill'
	import 'quill/dist/quill.snow.css'

	export default {
		name: 'editor',

		data() {
			return {
				content: '',
				quill: {},

				defaultModules: {
					toolbar: [
						['bold', 'italic', 'underline'],
						['blockquote', { 'header': 2 }],
						[{ 'list': 'ordered' }, { 'list': 'bullet' }],
						[{ 'indent': '-1' }, { 'indent': '+1' }],
						[{ 'color': [] }, { 'background': [] }],
						[{ 'align': [] }],
						['link', 'image', 'video'],
						['clean'],
					]
				},
			}
		},

		props: {
			value: String,
			disabled: Boolean,
			options: {
				type: Object,
				required: false,
				default() {
					return {}
				}
			}
		},

		mounted() {
			this.initialize()
		},

		beforeDestroy() {
			this.quill = null
		},

		methods: {
			initialize() {
				if ( this.$el ) {

					// Set options
					this.options.theme = this.options.theme || 'snow';
					this.options.boundary = this.options.boundary || document.body;
					this.options.modules = this.options.modules || this.defaultModules;
					this.options.modules.toolbar = this.options.modules.toolbar !== undefined
						? this.options.modules.toolbar
						: this.defaultModules.toolbar;
					this.options.placeholder = this.options.placeholder || 'Insert text here...';
					this.options.readOnly = this.options.readOnly !== undefined ? this.options.readOnly : false;

					// Create quill instance
					this.quill = new Quill(this.$refs.editor, this.options);
					this.addImageHandler();

					// Set editor content
					if ( this.value ) {
						this.quill.pasteHTML(this.value)
					}

					// Mark model as touched if editor lost focus
					this.quill.on('selection-change', (range) => {
						if ( ! range ) {
							this.$emit('blur', this.quill)
						} else {
							this.$emit('focus', this.quill)
						}
					});

					// update model if text changes
					this.quill.on('text-change', (delta, oldDelta, source) => {
						const html = this.$refs.editor.children[0].innerHTML;
						const text = this.quill.getText();

						this.content = html;

						this.$emit('input', this.content);
						this.$emit('change', {
							editor: this.quill,
							html: html,
							text: text
						});
					});

					// emit ready
					this.$emit('ready', this.quill)
				}
			},

			addImageHandler() {
				const toolbar = this.quill.getModule('toolbar');

				toolbar.addHandler('image', function () {
					const response = {
						data: {
							id: 1,
							path: 'https://www.w3schools.com/css/trolltunga.jpg',
							caption: 'This is a caption'
						},
						success: true,
						status: 200
					};
					this.quill.pasteHTML(
						this.quill.selection.savedRange.index,
						`<img src='${ response.data.path }'>`
					);
				});
			}
		},

		watch: {
			content: (newVal) => {
				if ( this.quill ) {
					if ( !! newVal && newVal !== this.content ) {
						this.content = newVal;
						this.quill.pasteHTML(newVal);
					} else if ( ! newVal ) {
						this.quill.setText('');
					}
				}
			},

			disabled: (newVal) => {
				if ( this.quill ) {
					this.quill.enable(!newVal);
				}
			}
		},
	}
</script>

<style lang="scss">

	.quill-editor {
		width: 50rem;

		img {
			max-width: 100%;
		}
	}

	.ql-editor {
		p {
			margin-bottom: 1rem !important;
		}
	}

</style>