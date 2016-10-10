import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/post.php"
})

export class PostComponent implements OnInit {
	deleted: boolean = false;
	posts: Post[] = [];
	post: Post = new Post(0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private router: Router, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params : Params) => {
			let postId = +params["postId"];
			this.postService.getPost(postId)
				.subscribe(post => this.post = post);
		});
		this.reloadPosts();
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
				this.post = new Post(0, 0, "", "");
			});
	}

	editPost() : void {
		this.postService.editPost(this.post)
			.subscribe(status => this.status = status);
	}

	reloadPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	switchPost(post : Post) : void {
		this.router.navigate(["/post/", post.postId]);
	}
}
