import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {OauthIdentity} from "../classes/oauth-identity";
import {Status} from "../classes/status";

@Injectable()
export class OauthIdentityService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private oauthIdentityUrl = "./lib/apis/oauthIdentity/";

	deleteOauthIdentity(oauthIdentityId: number) : Observable<Status> {
		return(this.http.delete(this.oauthIdentityUrl + oauthIdentityId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllOauthIdentitys() : Observable<OauthIdentity[]> {
		return(this.http.get(this.oauthIdentityUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getOauthIdentity(oauthIdentityId: number) : Observable<OauthIdentity> {
		return(this.http.get(this.oauthIdentityUrl + oauthIdentityId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createOauthIdentity(oauthIdentity: OauthIdentity) : Observable<Status> {
		return(this.http.post(this.oauthIdentityUrl, oauthIdentity)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editOauthIdentity(oauthIdentity: OauthIdentity) : Observable<Status> {
		return(this.http.put(this.oauthIdentityUrl + oauthIdentity.oauthIdentityId, oauthIdentity)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
