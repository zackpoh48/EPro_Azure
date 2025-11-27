<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title>eProcurement</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
		<meta content="Coderthemes" name="author" />
		<!-- App favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
		@stack('css')

	</head>

	<body class="loading" data-layout="detached" data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>
		<main>
			<div id="app"></div>
		</main>
		@stack('scripts')
	</body>
</html>