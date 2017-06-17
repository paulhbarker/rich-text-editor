<template>
	<div class="forms">
		<div class="form-wrapper">
			<form action="/submissions" ref="form">
				<input ref="title" class="input" type="text" name="title" id="title" placeholder="Article Title">
				<editor ref="editor"></editor>
				<input type="submit" value="Submit" @click.prevent="submit()">
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
			}
		}
	}
</script>

<style lang="scss">
	h1 {
		letter-spacing: -2px;
	}

	.forms {
		display: flex;
	}

	.input {
		width: 50%;
		margin-bottom: 1rem;
		padding: 1rem;
		border: 1px solid #ccc;
	}

	.form-wrapper, .output-wrapper {
		width: 50%;
		padding: 2rem;
		height: 100vh;
	}

	.form-wrapper {
		background: #fff;
	}

	.output-wrapper {
		border-left: 1px solid #ccc;
		overflow-y: auto;

		.output {
			width: 80%;
			margin: 0 auto;
		}

		h2 {
			font-size: 1.5rem;
			font-family: 'Droid Serif', serif;
			font-weight: 700;
		}
	}

	input[type=submit] {
		background: transparent;
		border: 1px solid #ccc;
		padding: 1rem 2rem;
		font-size: 1.2rem;
		margin-top: 1rem;
		float: right;
	}

</style>