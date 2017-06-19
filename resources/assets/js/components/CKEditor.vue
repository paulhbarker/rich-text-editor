<template>
	<div class="ckeditor">
		<textarea :id="id" :name="name" :value="value"></textarea>
	</div>
</template>

<script>
	import scriptjs from 'scriptjs'

	export default {

		data() {
			return {
				instance: {},
				options: {
					height: '60vh'
				},
				ready: false,
			}
		},

		props: {
			name: {
				type: String,
				default: () => `editor-${++inc}`
			},
			value: {
				type: String
			},
			id: {
				type: String,
				default: () => `editor-${inc}`
			},
		},

		beforeUpdate () {
			if (this.value !== this.instance.getData()) {
				this.instance.setData(this.value)
			}
		},

		mounted() {
			scriptjs('/js/vendor/ckeditor/ckeditor.js', () => {
				this.instance = CKEDITOR.replace('editor', this.options);

				this.instance.on('fileUploadRequest', (evt) => this.uploadFile(evt));
				this.instance.on('change', () => this.emitChangedEvent());

				this.$emit('ready');
			});
		},

		methods: {
			getToken() {
				let token = document.head.querySelector('meta[name="csrf-token"]');

				return token ? token.content : '';
			},

			uploadFile(evt) {
				const { xhr, file } = evt.data.fileLoader;
				xhr.setRequestHeader('X-CSRF-TOKEN', this.getToken());

				const formData = new FormData();
				formData.append('file', file);

				xhr.send( formData );

				evt.stop();
			},

			emitChangedEvent() {
				let html = this.instance.getData();
				if (html !== this.value) {
					this.$emit('input', html);
				}
			}
		},

		beforeDestroy () {
			if (this.instance) {
				this.instance.focusManager.blur(true)
				this.instance.removeAllListeners()
				this.instance.destroy()
				this.instance = null
			}
		}
	}
</script>