<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Test HTML input</title>
	<style>
		#app {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
			background-color: #f2f6f7;
		}

		.form-wrapper {
			padding: 2rem;
			background: #fff;
		}

		label {
			display: block;
		}

		p {
			margin-bottom: 2rem;
		}
	</style>
</head>
<body>
	<div id="app">

		<advanced-form></advanced-form>

	</div>

	<script src="/js/app.js"></script>
</body>
</html>