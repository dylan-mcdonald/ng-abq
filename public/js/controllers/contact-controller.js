app.controller("ContactController", ["$scope", "AlertService", "ContactService", function($scope, AlertService, ContactService) {
	$scope.contactData = {};

	$scope.contact = function(contactData, validated) {
		if(validated === true) {
			ContactService.contact(contactData).then(function(reply) {
				if(reply.status === 200) {
					AlertService.addAlert({type: "success", msg: reply.message});
				} else {
					AlertService.addAlert({type: "danger", msg: reply.message});
				}
			});
		}
	};
}]);