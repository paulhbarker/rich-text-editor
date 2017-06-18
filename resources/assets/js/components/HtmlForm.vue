<template>
	<div class="columns">
		<div class="form-wrapper">
			<form action="/submissions" ref="form">
				<textarea ref="html" name="html" id="html" rows="10"></textarea>
				<input type="submit" value="Submit" @click.prevent="submit()">
			</form>
		</div>
		<div class="output-wrapper">
			<div class="output" ref="output"></div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'html-form',
		methods: {
			submit() {
				this.$refs.output.innerHTML = this.$refs.html.value;
			},
		}
	}
</script>
s
<style lang="scss">

</style>