@extends("ng-abq")
@section("content")
	<h1>ng-abq: Albuquerque AngularJS Meetup Group</h1>
	<section class="row" ng-controller="LoginController">
		<div class="col-md-3">
			<img id="ng-abq-logo" class="img-responsive" src="/images/ng-abq-logo.svg" />
		</div>
		<div class="col-md-9">
			<p>Join us for discussions on Angular JS in the Land of Enchantment!</p>
			<form id="signupForm" name="signupForm" class="form-horizontal well">
				<h2>Join the Fun!</h2>
				<hr />
				<div class="form-group" ng-class="{ 'has-error': signupForm.name.$touched && signupForm.name.$invalid }">
					<label class="control-label" for="name">Name</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-user" aria-hidden="true"></i>
						</div>
						<input type="text" class="form-control" id="name" name="name" placeholder="What's your name?" ng-model="signupData.name" ng-required="true" />
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': signupForm.email.$touched && signupForm.email.$invalid }">
					<label class="control-label" for="email">Email</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</div>
						<input type="email" class="form-control" id="email" name="email" placeholder="What's your Email?" ng-model="signupData.email" ng-required="true" />
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': signupForm.password.$touched && signupForm.password.$invalid }">
					<label class="control-label" for="password">Password</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key" aria-hidden="true"></i>
						</div>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password&hellip;" ng-model="signupData.password" ng-minlength="8" ng-required="true" />
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': signupForm.confirmPassword.$touched && signupForm.confirmPassword.$invalid }">
					<label class="control-label">Confirm Password</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-key" aria-hidden="true"></i>
						</div>
						<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password&hellip;" ng-model="signupData.confirmPassword" ng-minlength="8" ng-required="true" />
					</div>
				</div>
				<hr />
				<button type="submit" class="btn btn-lg btn-info"><i class="fa fa-check" aria-hidden="true"></i> Join</button>
				<button type="reset" class="btn btn-lg btn-warning"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
			</form>
			<p>Or, join us with one of the following social networks:</p>
			<ul class="list-inline">
				<li><a class="btn btn-lg btn-info github-color" href="/github/authorize"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a></li>
				<li><a class="btn btn-lg btn-info google-color" href="/google/authorize"><i class="fa fa-google" aria-hidden="true"></i> Google</a></li>
				<li><a class="btn btn-lg btn-info facebook-color" href="/facebook/authorize"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
			</ul>
		</div>
	</section>
@endsection