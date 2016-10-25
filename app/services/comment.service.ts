import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Comment} from "../classes/comment";
import {Status} from "../classes/status";

@Injectable()
export class CommentService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private commentUrl = "./lib/apis/comment/";

	deleteComment(commentId: number) : Observable<Status> {
		return(this.http.delete(this.commentUrl + commentId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllComments() : Observable<Comment[]> {
		return(this.http.get(this.commentUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getComment(commentId: number) : Observable<Comment> {
		return(this.http.get(this.commentUrl + commentId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createComment(comment: Comment) : Observable<Status> {
		return(this.http.post(this.commentUrl, comment)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editComment(comment: Comment) : Observable<Status> {
		return(this.http.put(this.commentUrl + comment.commentId, comment)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
