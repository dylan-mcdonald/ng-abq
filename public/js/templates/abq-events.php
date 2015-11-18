<h2>{{ event.event_name }}</h2>
<p>{{ event.event_description }}</p>
<p>Join us on {{ event.event_date | date }}</p>
<p>{{ event.attendees }} attendees are already joining us! <span ng-show="event.attending === true">You're already signed up! Awesome!</span></p>
<p ng-show="event.attending === true"><button class="btn btn-lg btn-danger" ng-click="miss(event.id);"><i class="fa fa-frown-o" aria-hidden="true"></i> Cancel RSVP</button></p>
<p ng-show="event.attending === false"><button class="btn btn-lg btn-info" ng-click="attend(event.id);"><i class="fa fa-user-plus" aria-hidden="true"></i> Join Us!</button></p>
<h4 ng-show="event.attending === null"><span ng-controller="SigninController"><a href="#" ng-click="openSigninModal();">Sign in</a></span> or <span ng-controller="SignupController"><a href="#" ng-click="openSignupModal();">sign up</a></span> to join us! We'd love to have you!</h4>
<hr />