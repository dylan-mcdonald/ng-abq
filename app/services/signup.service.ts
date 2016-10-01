import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class SignupService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signupUrl = "api/signup/";
}
