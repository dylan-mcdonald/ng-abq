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
		<script type="text/javascript" src="/js/services/login-service.js"></script>
		<script type="text/javascript" src="/js/services/signup-service.js"></script>
		<script type="text/javascript" src="/js/controllers/signup-modal.js"></script>
		<script type="text/javascript" src="/js/controllers/login-controller.js"></script>
		<title>ng-abq | Albuquerque AngularJS Meetup Group</title>
	</head>
	<body class="sfooter">
		<div class="sfooter-content">
			<main class="container">
				@yield("content")
			</main>
		</div>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<p>&copy; 2015 Albuquerque Angular.</p>
					</div>
					<div class="col-sm-8">
						<ul class="list-inline">
							<li>Follow us:</li>
							<li><a class="btn btn-sm btn-info github-color" href="https://github.com/ng-abq/"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a></li>
							<li><a class="btn btn-sm btn-info google-color" href="https://plus.google.com/102721502767657519522"><i class="fa fa-google" aria-hidden="true"></i> Google</a></li>
							<li><a class="btn btn-sm btn-info facebook-color" href="https://www.facebook.com/angularabq"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>