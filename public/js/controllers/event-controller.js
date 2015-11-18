app.controller("EventController", ["$scope", "EventService", function($scope, EventService) {
	$scope.events = [];

	$scope.getEvents = function() {
		EventService.all()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.events = reply.data;
				}
			});
	};

	$scope.getEvents();
}]);