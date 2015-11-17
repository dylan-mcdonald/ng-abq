app.service("SigninService", function($http) {
	this.SIGNUP_ENDPOINT = "/auth/signin";

	this.signin = function(signinData) {
		return($http.post(this.SIGNUP_ENDPOINT, signinData)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});