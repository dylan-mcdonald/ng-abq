@extends("ng-abq")
@section("content")
	<h1>Upcoming Events</h1>
	<p>
		Angular Albuquerque was founded in 2015 in ravenous anticipation of the release of Angular 2.0, and to establish a friendly, supportive community of individuals who:
	</p>
	<div ng-controller="EventController">
		<div ng-repeat="event in events">
			<abq-events></abq-events>
		</div>
	</div>
@endsection