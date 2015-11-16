app.service("SigninService", function($http) {
	this.SIGNUP_ENDPOINT = "/auth/signin";

	this.signin = function(loginData) {
		return($http.post(this.SIGNUP_ENDPOINT, loginData)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});