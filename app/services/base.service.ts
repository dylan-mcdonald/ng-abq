import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

export abstract class BaseService {
	constructor(protected http: Http) {}

	protected extractData(response: Response) : any {
		if(response.status < 200 || response.status >= 300) {
			throw(new Error("Bad response status: " + response.status))
		}
		let json = response.json();
		if(json.status !== 200) {
			throw(new Error("Bad API status: " + json.status));
		}
		console.log(json.status);
		return(json.data);
	}

	protected extractMessage(response: Response) : Status {
		if(response.status < 200 || response.status >= 300) {
			throw(new Error("Bad response status: " + response.status))
		}
		console.log("test1");
		let json = response.json();
		let jsonStatus = "alert-success";
		if(json.status !== 200) {
			jsonStatus = "alert-danger";
		}
		let status = new Status(json.status, json.message, jsonStatus);
		return(status);
	}

	protected handleError(error:any) {
		console.log("test2");
		let message = error.message;
		return(Observable.throw(message));
	}
}
