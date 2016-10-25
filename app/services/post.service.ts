import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "./lib/apis/post/";

	deletePost(postId: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + postId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllPosts() : Observable<Post[]> {
		return(this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPost(postId: number) : Observable<Post> {
		return(this.http.get(this.postUrl + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createPost(post: Post) : Observable<Status> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editPost(post: Post) : Observable<Status> {
		return(this.http.put(this.postUrl + post.postId, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
