app.controller("SigninController", ["$scope", "$uibModal", "$window", "AlertService", "SigninService", function($scope, $uibModal, $window, AlertService, SigninService) {
	$scope.signinData = {};

	$scope.openSigninModal = function () {
		var signinModalInstance = $uibModal.open({
			templateUrl: "/js/templates/signin-modal.php",
			controller: "SigninModal",
			resolve: {
				signinData: function() {
					return($scope.signinData);
				}
			}
		});
		signinModalInstance.result.then(function (signinData) {
			$scope.signinData = signinData;
			SigninService.signin(signinData)
				.then(function(reply) {
					if(reply.status === 200) {
						AlertService.addAlert({type: "success", msg: reply.message});
						$window.location.reload();
					} else {
						AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.signinData = {};
		});
	};
}]);