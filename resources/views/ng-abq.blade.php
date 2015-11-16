<!DOCTYPE html>
<html ng-app="NgAbq">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- CSS stylesheets -->
		<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/ng-abq.css" />

		<!-- CDN derived JavaScript -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>

		<!-- Site specific JavaScript -->
		<script type="text/javascript" src="/js/angular-password.min.js"></script>
		<script type="text/javascript" src="/js/ng-abq.js"></script>
		<script type="text/javascript" src="/js/services/alert-service.js"></script>
		<script type="text/javascript" src="/js/services/signin-service.js"></script>
		<script type="text/javascript" src="/js/services/signup-service.js"></script>
		<script type="text/javascript" src="/js/controllers/alert-controller.js"></script>
		<script type="text/javascript" src="/js/controllers/nav-controller.js"></script>
		<script type="text/javascript" src="/js/controllers/signin-controller.js"></script>
		<script type="text/javascript" src="/js/controllers/signin-modal.js"></script>
		<script type="text/javascript" src="/js/controllers/signup-controller.js"></script>
		<script type="text/javascript" src="/js/controllers/signup-modal.js"></script>
		<title>ng-abq | Albuquerque AngularJS Meetup Group</title>
	</head>
	<body class="sfooter">
		<header class="navbar navbar-default navbar-fixed-top navbar-inner" ng-controller="NavController">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" ng-click="isCollapsed = !isCollapsed">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand visible-xs" href="/">ng-abq</a>
				</div>
				<nav id="navbar-collapse" class="collapse hidden-xs navbar-collapse">
					<ul class="nav navbar-nav">
						<a href="/" role="button" class="navbar-brand">
							<img src="/images/ng-abq-logo.svg" alt="" />
							ng-abq
						</a>
						<li><a href="/about">About Us</a></li>
						<li><a href="/events">Upcoming Events</a></li>
						<?php
						if(Auth::check()) {
						?>
						<li><a href="/auth/signout"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a></li>
						<?php
						} else {
						?>
						<li class="dropdown" uib-dropdown>
							<a role="button" class="dropdown-toggle" uib-dropdown-toggle>
								Sign In <b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li ng-controller="SigninController"><a ng-click="openSigninModal();"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In Now</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="/github/authorize"><i class="fa fa-github" aria-hidden="true"></i> Login with GitHub</a></li>
								<li><a href="/google/authorize"><i class="fa fa-google" aria-hidden="true"></i> Login with Google</a></li>
								<li><a href="/facebook/authorize"><i class="fa fa-facebook" aria-hidden="true"></i> Login with Facebook</a></li>
							</ul>
						</li>
						<?php
							}
						?>
					</ul>
				</nav>
				<nav class="visible-xs" uib-collapse="!isCollapsed" ng-show="isCollapsed">
					<ul class="nav navbar-nav">
						<li><a href="/about" ng-click="isCollapsed = !isCollapsed">About Us</a></li>
						<li><a href="/events" ng-click="isCollapsed = !isCollapsed">Upcoming Events</a></li>
					</ul>
				</nav>
			</div>
		</header>
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