<template>
	<div class="top">
		<div class="loader"></div>
		<div id="ck-container" ref="container" :class="ready ? 'slideIn' : 'loading'">
			<textarea id='editor'></textarea>
		</div>
	</div>
</template>

<script>
	import scriptjs from 'scriptjs'

	export default {
		name: 'editor',

		data() {
			return {
				editor: {},
				options: {
					height: '60vh'
				},
				ready: false,
			}
		},

		created() {
			scriptjs('/js/vendor/ckeditor/ckeditor.js', () => {
				this.editor = CKEDITOR.replace('editor', this.options);

				this.editor.on('fileUploadRequest', (evt) => this.uploadFile(evt));

				this.ready = true;
			});
		},

		methods: {
			getToken() {
				let token = document.head.querySelector('meta[name="csrf-token"]');

				return token ? token.content : '';
			},

			uploadFile(evt) {
				const xhr = evt.data.fileLoader.xhr;

				xhr.setRequestHeader('X-CSRF-TOKEN', this.getToken());

				xhr.send( evt.data.fileLoader.file );

//				evt.stop();
			}
		}
	}
</script>

<style lang="scss">
	$editor-height: 611px;

	#ck-container {
		background: #fff;
		transition: all .4s ease;
	}

	.loader {
		position: absolute;
		height: $editor-height;
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: #F5F5F5;
	}

	.top {
		position: relative;
	}

	.loading {
		transform: scale(0);
		opacity: 0;
	}

	.slideIn {
		transform: scale(1);
		opacity: 1;
	}

	textarea {
		height: $editor-height;
	}

	.cke_bottom {
		display: none !important;
	}

	.cke_top {
		background-color: #fff !important;
	}

</style>