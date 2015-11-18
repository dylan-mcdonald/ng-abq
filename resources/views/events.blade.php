@extends("ng-abq")
@section("content")
	<h1>Upcoming Events</h1>
	<p>
		Angular is excited to host the following events. Join us for fun, beer, and Angular conversation!
	</p>
	<div ng-controller="EventController">
		<div ng-repeat="event in events">
			<abq-events></abq-events>
		</div>
	</div>
	<div ng-controller="AlertController">
		<uib-alert ng-repeat="alert in alerts" type="{{alert.type}}" close="alerts.length = 0;">{{alert.msg}}</uib-alert>
	</div>
@endsection