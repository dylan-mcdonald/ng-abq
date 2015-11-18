@extends("ng-abq")
@section("content")
	<h1>Contact Us</h1>
	<p>Use this form to contact the Albuquerque Angular Team.</p>
	<form class="form-horizontal well" name="contactForm" ng-submit="contactUs(contactData, contactForm.$valid);" novalidate>
		<h2>Get In Touch</h2>
		<div class="form-group" ng-class="{ 'has-error': contactForm.name.$touched && contactForm.name.$invalid }">
			<label for="name">Name</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<input type="text" name="name" class="form-control" placeholder="How may we address you?" maxlength="256" ng-model="contactData.name" ng-maxlength="256" ng-required="true" />
			</div>
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.name.$error" ng-if="contactForm.name.$touched" ng-hide="contactForm.name.$valid">
			<p ng-message="maxlength">Name is too long.</p>
			<p ng-message="required">Name is required.</p>
		</div>
		<div class="form-group" ng-class="{ 'has-error': contactForm.email.$touched && contactForm.email.$invalid }">
			<label for="email">Email</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-envelope" aria-hidden="true"></i>
				</div>
				<input type="email" name="email" class="form-control" placeholder="How can we get back to you?" maxlength="256" ng-model="contcactData.email" ng-maxlength="256" ng-required="true" />
			</div>
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.email.$error" ng-if="contactForm.email.$touched" ng-hide="contactForm.email.$valid">
			<p ng-message="email">Email is not a valid Email address.</p>
			<p ng-message="maxlength">Email is too long.</p>
			<p ng-message="required">Email is required.</p>
		</div>
		<div class="form-group" ng-class="{ 'has-error': contactForm.subject.$touched && contactForm.subject.$invalid }">
			<label for="subject">Subject</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</div>
				<input type="text" name="subject" class="form-control" placeholder="What is this about?" maxlength="256" ng-model="contactData.subject" ng-maxlength="256" ng-required="true" />
			</div>
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.subject.$error" ng-if="contactForm.subject.$touched" ng-hide="contactForm.subject.$valid">
			<p ng-message="maxlength">Subject is too long.</p>
			<p ng-message="required">Subject is required.</p>
		</div>
		<div class="form-group" ng-class="{ 'has-error': contactForm.message.$touched && contactForm.message.$invalid }">
			<label for="message">Message</label>
			<textarea class="form-control" rows="5" maxlength="1024" placeholder="What is on your mind?" ng-model="contactData.message" ng-maxlength="1024" ng-required="true"></textarea>
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.message.$error" ng-if="contactForm.message.$touched" ng-hide="contactForm.message.$valid">
			<p ng-message="maxlength">Message is too long.</p>
			<p ng-message="required">Message is required.</p>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-lg btn-info" ng-disabled="contactForm.$invalid"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
			<button type="reset" class="btn btn-lg btn-warning"><i class="fa fa-ban" aria-hidden="true"></i> Clear</button>
		</div>
	</form>
	<div ng-controller="AlertController">
		<uib-alert ng-repeat="alert in alerts" type="{{alert.type}}" close="alerts.length = 0;">{{alert.msg}}</uib-alert>
	</div>
@endsection