import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/post-or-comment.php"
})

export class PostOrCommentComponent implements OnInit {
	@ViewChild("addPostForm") addPostForm;

	posts: Post[] = [];
	post: Post = new Post(0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private router: Router) {}

	ngOnInit() : void {
		this.reloadPosts();
	}

	reloadPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	switchPost(post : Post) : void {
		console.log(post.postId);
		this.router.navigate(["/post"], post.postId);
	}
//, post.postId
	createPost() : void {
		this.post.postId = null;
		this.post.postProfileUserName = "billybob";

		this.postService.createPost(this.post)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadPosts();
					this.addPostForm.reset();
				}
			});
	}
}