<template>
	<div class="editor-wrapper">
		<div class="placeholder"></div>
		<div id="ck-container":class="ready ? 'zoomIn' : 'loading'">
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