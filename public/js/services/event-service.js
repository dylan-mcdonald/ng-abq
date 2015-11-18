app.service("EventService", function($http) {
	this.EVENT_ENDPOINT = "/event/";

	this.getUrl = function() {
		return(this.EVENT_ENDPOINT);
	};

	this.getUrlForId = function(eventId) {
		return(this.getUrl() + eventId);
	};

	this.all = function() {
		return($http.get(this.getUrl())
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.fetch = function(eventId) {
		return($http.get(this.getUrlForId(eventId))
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.create = function(event) {
		return($http.post(this.getUrl(), event)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.update = function(eventId, event) {
		return($http.put(this.getUrlForId(eventId), event)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.destroy = function(eventId) {
		return($http.delete(this.getUrlForId(eventId))
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.attend = function(eventId) {
		return($http.post(this.getUrl() + "/attend/" + eventId)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.miss = function(eventId) {
		return($http.delete(this.getUrl() + "/attend/" + eventId)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});