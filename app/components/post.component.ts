import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../services/post.service";
import {CommentService} from "../services/comment.service";
import {Post} from "../classes/post";
import {Comment} from "../classes/comment";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/post.php"
})

export class PostComponent implements OnInit {
	deleted: boolean = false;
	comments: Comment[] = [];
	comment: Comment = new Comment(0, "", 0, "", "");
	posts: Post[] = [];
	post: Post = new Post(0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private commentService: CommentService, private router: Router, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.reloadPosts();
		this.reloadComments();
	}

	reloadPosts() : void {
		console.log("testing1");
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	reloadComments() : void {
		console.log("testing2");
		this.commentService.getAllComments()
			.subscribe(comments => this.comments = comments);
	}

	createPost() : void {
		this.postService.createPost(this.post)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadPosts();
				}
			});
	}

	deletePost() : void {
		this.postService.deletePost(this.post.postId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.post = new Post(0, "" , "", "");
			});
	}

	editPost() : void {
		this.postService.editPost(this.post)
			.subscribe(status => this.status = status);
	}

	switchPost(post : Post) : void {
		this.router.navigate(["/post/", post.postId]);
	}
}
