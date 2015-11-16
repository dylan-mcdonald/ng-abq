<ul class="nav navbar-nav">
	<div class="navbar-header hidden-xs">
		<a href="/" role="button" class="navbar-brand">
			<img src="/images/ng-abq-logo.svg" alt="" />
			ng-abq
		</a>
	</div>
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
			<li><a href="/github/authorize"><i class="fa fa-github" aria-hidden="true"></i> Sign In with GitHub</a></li>
			<li><a href="/google/authorize"><i class="fa fa-google" aria-hidden="true"></i> Sign In with Google</a></li>
			<li><a href="/facebook/authorize"><i class="fa fa-facebook" aria-hidden="true"></i> Sign In with Facebook</a></li>
		</ul>
	</li>
	<?php
	}
	?>
</ul>