app.service("LoginService", function($http) {
	this.SIGNUP_ENDPOINT = "/auth/login";

	this.login = function(loginData) {
		return($http.post(this.SIGNUP_ENDPOINT, loginData)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});