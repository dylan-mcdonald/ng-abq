app.controller("LoginController", ["$scope", "$uibModal", "SignupService", function($scope, $uibModal, SignupService) {
	$scope.alerts = [];
	$scope.loginData = {};
	$scope.signupData = {};

	$scope.openSignupModal = function () {
		var signupModalInstance = $uibModal.open({
			templateUrl: "/js/templates/signup-modal.php",
			controller: "SignupModal",
			resolve: {
				signupData: function() {
					return($scope.signupData);
				}
			}
			});
			signupModalInstance.result.then(function (signupData) {
				$scope.signupData = signupData;
				SignupService.signup(signupData)
						.then(function(reply) {
							if(reply.status === 200) {
								$scope.alerts[0] = {type: "success", msg: reply.message};
							} else {
								$scope.alerts[0] = {type: "danger", msg: reply.message};
							}
						});
			}, function() {
				$scope.signupData = {};
			});
	};
}]);