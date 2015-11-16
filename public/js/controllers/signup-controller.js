app.controller("SignupController", ["$scope", "$uibModal", "AlertService", "SignupService", function($scope, $uibModal, AlertService, SignupService) {
	$scope.signinData = {};

	$scope.openSignupModal = function () {
		var signupModalInstance = $uibModal.open({
			templateUrl: "/js/templates/signup-modal.php",
			controller: "SignupModal",
			resolve: {
				signinData: function() {
					return($scope.signinData);
				}
			}
			});
			signupModalInstance.result.then(function (signupData) {
				$scope.signinData = signinData;
				SignupService.signup(signinData)
						.then(function(reply) {
							if(reply.status === 200) {
								AlertService.addAlert({type: "success", msg: reply.message});
							} else {
								AlertService.addAlert({type: "danger", msg: reply.message});
							}
						});
			}, function() {
				$scope.signinData = {};
			});
	};
}]);