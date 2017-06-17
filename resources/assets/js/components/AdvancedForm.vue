<template>
	<div class="form-wrapper">
		<form action="/submissions" ref="form">
			<editor ref="editor"></editor>
			<input type="submit" value="Submit" @click.prevent="submit()">
		</form>
		<div ><pre ref="output"></pre></div>
	</div>
</template>

<script>
	import Editor from './Editor.vue'
	export default {
		name: 'advanced-form',
		components: { Editor },

		methods: {
			submit() {
				axios.post('/submissions', {
					content: this.$refs.editor.content

				}).then( (res) => {

					console.log(res);
					this.$refs.output.innerText = res.data.content;

				}).catch( (err) => console.log(err) );
			}
		}
	}
</script>

<style>

</style>