import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "./lib/apis/profile/";

	deleteProfile(profileId: number) : Observable<Status> {
		return(this.http.delete(this.profileUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllProfiles() : Observable<Profile[]> {
		return(this.http.get(this.profileUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfile(profileId: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createProfile(profile: Profile) : Observable<Status> {
		return(this.http.post(this.profileUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put(this.profileUrl + profile.profileId, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
