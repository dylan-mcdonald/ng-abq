app.controller("LoginController", ["$scope", "$uibModal", function($scope, $uibModal) {
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
				console.log($scope.signupData);
			}, function() {
				$scope.signupData = {};
			});
	};
}]);