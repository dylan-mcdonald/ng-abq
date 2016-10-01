import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Link} from "../classes/link";
import {Status} from "../classes/status";

@Injectable()
export class LinkService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private linkUrl = "api/link/";

	deleteLink(linkId: number) : Observable<Status> {
		return(this.http.delete(this.linkUrl + linkId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllLinks() : Observable<Link[]> {
		return(this.http.get(this.linkUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getLink(linkId: number) : Observable<Link> {
		return(this.http.get(this.linkUrl + linkId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createLink(link: Link) : Observable<Status> {
		return(this.http.post(this.linkUrl, link)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editLink(link: Link) : Observable<Status> {
		return(this.http.put(this.linkUrl + link.linkId, link)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
