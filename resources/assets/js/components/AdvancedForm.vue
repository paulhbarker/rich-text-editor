<template>
	<div class="columns">
		<div class="form-wrapper">
			<form action="/submissions" ref="form">
				<input ref="title" class="input" type="text" name="title" id="title" placeholder="Article Title">
				<editor @change="enableButton()" ref="editor"></editor>
				<button class="btn" @click.prevent="email()" :disabled="disabled">{{ this.sending ? 'Sending...' : this.button }}</button>
				<input type="submit" value="Preview" @click.prevent="submit()">
			</form>
		</div>
		<div class="output-wrapper">
			<div class="output" ref="output"></div>
		</div>
	</div>
</template>

<script>
	import Editor from './Editor.vue'
	export default {
		name: 'advanced-form',
		components: { Editor },
		data() {
			return {
				sending: false,
				button: 'Send Report',
				disabled: false
			}
		},
		methods: {
			submit() {
				axios.post('/submissions', {
					title: this.$refs.title.value,
					body: this.$refs.editor.content

				}).then( (res) => {

					console.log(res);
					const { title, body } = res.data.data;
					const output = `<h1>${title}</h1>${body}`;

					this.$refs.output.innerHTML = output;

				}).catch( (err) => console.log(err) );
			},

			email() {
				this.sending = true;
				const before = this.$refs.editor.content;
				axios.post('/submissions', {
					title: this.$refs.title.value,
					body: this.$refs.editor.content

				}).then( (res) => {
					const after = res.data.data.body;
					axios.post('/mail', {

						before: before,
						after: after

					}).then( (res) => {
						this.button = 'Sent!';
						this.sending = false;
						this.disabled = true;

					}).catch( (err) => console.log(err) )
				}).catch( (err) => console.log(err) )
			},

			enableButton() {
				this.button = 'Send Report';
				this.disabled = false;
			}
		}
	}
</script>

<style lang="scss">


</style>