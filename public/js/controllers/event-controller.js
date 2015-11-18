app.controller("EventController", ["$scope", "AlertService", "EventService", function($scope, AlertService, EventService) {
	$scope.events = [];

	$scope.getEvents = function() {
		EventService.all()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.events = reply.data;
				}
			});
	};

	$scope.attend = function(eventId) {
		EventService.attend(eventId).then(function(reply) {
			if(reply.status === 200) {
				AlertService.addAlert({type: "success", msg: reply.message});
			} else {
				AlertService.addAlert({type: "danger", msg: reply.message});
			}
			$scope.getEvents();
		});
	};

	$scope.miss = function(eventId) {
		EventService.miss(eventId).then(function(reply) {
			if(reply.status === 200) {
				AlertService.addAlert({type: "success", msg: reply.message});
			} else {
				AlertService.addAlert({type: "danger", msg: reply.message});
			}
			$scope.getEvents();
		});
	};

	$scope.getEvents();
}]);