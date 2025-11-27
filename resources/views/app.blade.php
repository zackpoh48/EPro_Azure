<!DOCTYPE html>
<html
data-bs-theme="light"
data-layout-mode="detached"
data-topbar-color="dark"
data-sidenav-user="true"
data-layout-position="fixed"
data-menu-color="light">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
	<title>E-Procurement</title>

	@vite('resources/css/app.css')
</head>
<body data-siteKey='{{config("services.recaptcha.key")}}' data-appName='{{config("app.name")}}'>
	<div id="app"></div>

	@vite('resources/js/app.js')
</body>
</html>
