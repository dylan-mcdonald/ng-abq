import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Attendee} from "../classes/attendee";
import {Status} from "../classes/status";

@Injectable()
export class AttendeeService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private attendeeUrl = "./lib/apis/attendee/";

	deleteAttendee(attendeeId: number) : Observable<Status> {
		return(this.http.delete(this.attendeeUrl + attendeeId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllAttendees() : Observable<Attendee[]> {
		return(this.http.get(this.attendeeUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAttendee(attendeeId: number) : Observable<Attendee> {
		return(this.http.get(this.attendeeUrl + attendeeId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createAttendee(attendee: Attendee) : Observable<Status> {
		return(this.http.post(this.attendeeUrl, attendee)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editAttendee(attendee: Attendee) : Observable<Status> {
		return(this.http.put(this.attendeeUrl + attendee.attendeeId, attendee)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
