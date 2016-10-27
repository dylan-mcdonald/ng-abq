import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../services/post.service";
import {CommentService} from "../services/comment.service";
import {Post} from "../classes/post";
import {Comment} from "../classes/comment";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/post-or-comment.php"
})

export class PostOrCommentComponent implements OnInit {
	@ViewChild("addPostForm") addPostForm;
	deleted: boolean = false;
	edited: boolean = false;
	posts: Post[] = [];
	post: Post = new Post(0, "", "", "");
	comments: Comment[] = [];
	comment: Comment = new Comment(0, "", 0, "", "");
	status: Status = null;

	constructor(private postService: PostService, private commentService: CommentService, private router: Router) {}

	ngOnInit() : void {
		this.reloadPosts();
		// this.reloadComments();
	}

	reloadPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
		console.log(this.posts);
	}
	// reloadComments() : void {
	// 	this.commentService.getAllComments()
	// 		.subscribe(comments => this.comments = comments);
	// }

	switchPost(post: Post): void {
		this.edited = true;
		console.log("edit postId",post.postId);
		this.postService.getPost(post.postId)
			.subscribe(post => this.post = post);
	}

	changePost(post: Post): void {
		this.edited = true;
		console.log(this.post);
		this.postService.editPost(this.post)
			.subscribe(status => {
				this.status = status;
				console.log(status.status);
				if(status.status === 200) {
					this.edited = false;
					this.ngOnInit();
					this.addPostForm.reset();
				}
			});
	}

	createPost(): void {
		this.post.postId = null;
		this.post.postProfileUserName = "billybob";
		this.postService.createPost(this.post)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadPosts();
					// this.reloadComments();
					this.addPostForm.reset();
				}
			});
	}

	deletePost(post: Post): void {
		console.log("delete postId", post.postId);
		this.postService.deletePost(post.postId)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadPosts();
					// this.reloadComments();
					this.addPostForm.reset();
				}
			});
	}
}