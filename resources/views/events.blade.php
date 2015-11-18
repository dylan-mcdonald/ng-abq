@extends("ng-abq")
@section("content")
	<h1>Upcoming Events</h1>
	<h4 class="alert alert-info" role="alert">
		We regularly meet the first Monday of each month at <a href="http://getplowed.com/site/our-locations/wells-park/">Tractor Brewery, Wells Park</a> at 6:00 pm.
	</h4>
	<p>
		Angular is excited to host the following events. Join us for fun, beer, and Angular conversation!
	</p>
	<hr />
	<div ng-controller="EventController">
		<div ng-repeat="event in events">
			<abq-events></abq-events>
		</div>
	</div>
	<div ng-controller="AlertController">
		<uib-alert ng-repeat="alert in alerts" type="{{alert.type}}" close="alerts.length = 0;">{{alert.msg}}</uib-alert>
	</div>
@endsection