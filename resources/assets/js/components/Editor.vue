<template>
	<div class="top">
		<div class="loader"></div>
		<div id="ck-container" ref="container" :class="ready ? 'slideIn' : 'loading'">
			<c-k-editor v-model="value"
			            :name="name"
			            :value="initialValue"
			            @input="updateField"
			            @ready="showEditor()"
			            id="editor">
			</c-k-editor>
		</div>
	</div>
</template>

<script>
	import CKEditor from './CKEditor.vue'

	export default {
		name: 'editor',
		components: { CKEditor },

		data() {
			return {
				ready: false,
				value: this.initialValue,
			}
		},

		props: [ 'name','initialValue' ],

		methods: {
			showEditor() {
				this.ready = true;
			},

			updateField: function() {
				this.$emit('input', this.value);
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