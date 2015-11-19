app.service("ContactService", function($http) {
	this.CONTACT_ENDPOINT = "/contact/";

	this.getUrl = function() {
		return(this.CONTACT_ENDPOINT);
	};

	this.contact = function(contactData) {
		return($http.post(this.getUrl(), contactData)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});