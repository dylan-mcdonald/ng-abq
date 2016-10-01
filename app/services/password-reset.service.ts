import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {PasswordReset} from "../classes/password-reset";
import {Status} from "../classes/status";

@Injectable()
export class PasswordResetService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private passwordResetUrl = "api/passwordReset/";

	deletePasswordReset(passwordResetId: number) : Observable<Status> {
		return(this.http.delete(this.passwordResetUrl + passwordResetId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllPasswordResets() : Observable<PasswordReset[]> {
		return(this.http.get(this.passwordResetUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPasswordReset(passwordResetId: number) : Observable<PasswordReset> {
		return(this.http.get(this.passwordResetUrl + passwordResetId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createPasswordReset(passwordReset: PasswordReset) : Observable<Status> {
		return(this.http.post(this.passwordResetUrl, passwordReset)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editPasswordReset(passwordReset: PasswordReset) : Observable<Status> {
		return(this.http.put(this.passwordResetUrl + passwordReset.passwordResetId, passwordReset)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
