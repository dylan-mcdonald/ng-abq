import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";

@Injectable()
export class EventService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private eventUrl = "api/event/";

	deleteEvent(eventId: number) : Observable<Status> {
		return(this.http.delete(this.eventUrl + eventId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllEvents() : Observable<Event[]> {
		return(this.http.get(this.eventUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getEvent(eventId: number) : Observable<Event> {
		return(this.http.get(this.eventUrl + eventId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createEvent(event: Event) : Observable<Status> {
		return(this.http.post(this.eventUrl, event)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editEvent(event: Event) : Observable<Status> {
		return(this.http.put(this.eventUrl + event.eventId, event)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
