app.service("EventService", function($http, EVENT_ENDPOINT) {
	this.EVENT_ENDPOINT = "/event/";

	function getUrl() {
		return(this.EVENT_ENDPOINT);
	}

	function getUrlForId(eventId) {
		return(getUrl() + eventId);
	}

	this.all = function() {
		return($http.get(getUrl())
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.fetch = function(eventId) {
		return($http.get(getUrlForId(eventId))
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.create = function(event) {
		return($http.post(getUrl(), event)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.update = function(eventId, event) {
		return($http.put(getUrlForId(eventId), event)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.destroy = function(eventId) {
		return($http.delete(getUrlForId(eventId))
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.attend = function(eventId) {
		return($http.post(getUrl() + "/attend/" + eventId)
			.then(function(reply) {
				return(reply.data);
			}));
	};

	this.miss = function(eventId) {
		return($http.delete(getUrl() + "/attend/" + eventId)
			.then(function(reply) {
				return(reply.data);
			}));
	};
});