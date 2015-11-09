@extends("ng-abq")
@section("content")
	<h1>ng-abq: Albuquerque AngularJS Meetup Group</h1>
	<section class="row" ng-controller="LoginController">
		<div class="col-md-3">
			<img id="ng-abq-logo" class="img-responsive" src="/images/ng-abq-logo.svg" />
		</div>
		<div class="col-md-9">
			<p>Join us for discussions on Angular JS in the Land of Enchantment!</p>
			<p><button class="btn btn-info btn-lg" ng-click="openSignupModal();">Sign Up</button></p>
			<p>Or, join us with one of the following social networks:</p>
			<ul class="list-inline">
				<li><a class="btn btn-lg btn-info github-color" href="/github/authorize"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a></li>
				<li><a class="btn btn-lg btn-info google-color" href="/google/authorize"><i class="fa fa-google" aria-hidden="true"></i> Google</a></li>
				<li><a class="btn btn-lg btn-info facebook-color" href="/facebook/authorize"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
			</ul>
		</div>
	</section>
@endsection