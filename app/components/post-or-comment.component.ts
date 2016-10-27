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
	createComments: boolean = false;
	posts: Post[] = [];
	post: Post = new Post(0, "", "", "");
	comments: Comment[] = [];
	comment: Comment = new Comment(0, "", 0, "", "");
	status: Status = null;

	constructor(private postService: PostService, private commentService: CommentService, private router: Router) {
	}

	ngOnInit(): void {
		this.reloadPosts();
		this.reloadComments();
	}

	reloadPosts(): void {
		console.log("posts");
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	reloadComments(): void {
		console.log("comments");
		this.commentService.getAllComments()
			.subscribe(comments => this.comments = comments);
	}

	switchPost(post: Post): void {
		this.edited = true;
		this.postService.getPost(post.postId)
			.subscribe(post => this.post = post);
	}

	switchComment(post: Post): void {
		this.edited = true;
		this.createComments = true;
		console.log(post.postId);
		this.postService.getPost(post.postId)
			.subscribe(post => this.post = post);
		this.commentService.getComments(post.postId)
			.subscribe(comments => this.comments = comments);
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

	createComment(): void {
		this.comment.commentId = null;
		this.comment.commentProfileUserName = "billybob";
		this.comment.commentPostId = this.post.postId;
		this.commentService.createComment(this.comment)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.ngOnInit();
					this.addPostForm.reset();
				}
			});
		this.createComments = false;
		this.edited = false;
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