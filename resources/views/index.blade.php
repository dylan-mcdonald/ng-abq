@extends("ng-abq")
@section("content")
	<section>
		<div class="jumbotron">
			<div class="row">
				<div class="col-md-3">
					<img id="ng-abq-logo" class="img-responsive" src="/images/ng-abq-logo.svg" />
				</div>
				<div class="col-md-9">
					<h1>ng-abq</h1>
					<p class="lead">Albuquerque AngularJS Meetup Group</p>
					<p>A Casual Angular Discussion Group for the Land of Enchantment. Ready to join the fun?</p>
					<?php
					if(Auth::check()) {
					?>
					<p>Welcome Back, [[[ Auth::user()->name ]]]!</p>
					<?php
					} else {
					?>
					<ul class="list-inline">
						<li ng-controller="SignupController"><a class="btn btn-info btn-lg" ng-click="openSignupModal();"><i class="fa fa-check" aria-hidden="true"></i> Join Now</a></li>
						<li><a class="btn btn-lg btn-info github-color" href="/github/authorize"><i class="fa fa-github" aria-hidden="true"></i> Join with GitHub</a></li>
						<li><a class="btn btn-lg btn-info google-color" href="/google/authorize"><i class="fa fa-google" aria-hidden="true"></i> Join with Google</a></li>
						<li><a class="btn btn-lg btn-info facebook-color" href="/facebook/authorize"><i class="fa fa-facebook" aria-hidden="true"></i> Join with Facebook</a></li>
					</ul>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div ng-controller="AlertController">
			<uib-alert ng-repeat="alert in alerts" type="{{alert.type}}" close="alerts.length = 0;">{{alert.msg}}</uib-alert>
		</div>
		<p>Join us for discussions on Angular JS in the Land of Enchantment! We will meet the first Monday of each month at <a href="http://getplowed.com/site/our-locations/wells-park/">Tractor Brewery, Wells Park</a> at 6:00 pm. All are welcome.</p>
	</section>
@endsection