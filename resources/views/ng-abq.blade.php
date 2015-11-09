<!DOCTYPE html>
<html ng-app="NgAbq">
	<head>
		<!-- CSS stylesheets -->
		<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/ng-abq.css" />

		<!-- CDN derived JavaScript -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>

		<!-- Site specific JavaScript -->
		<script type="text/javascript" src="/js/angular-password.min.js"></script>
		<script type="text/javascript" src="/js/ng-abq.js"></script>
		<script type="text/javascript" src="/js/controllers/login-controller.js"></script>
		<title>ng-abq | Albuquerque AngularJS Meetup Group</title>
	</head>
	<body>
		<main class="container">
			@yield("content")
		</main>
	</body>
</html>