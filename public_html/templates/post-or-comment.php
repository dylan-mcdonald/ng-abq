<form *ngIf="edited === false" #addPostForm="ngForm" name="addPostForm" id="addPostForm" class="form-horizontal well" (ngSubmit)="createPost();" novalidate>
	<h2>Create Post</h2>

	<div class="form-group" [ngClass]="{ 'has-error': postUserName.touched && postUserName.invalid }">
		<label for="name">Post UserName</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="name" id="name" class="form-control" maxlength="50" required [(ngModel)]="post.postProfileUserName" #postUserName="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': postUserName.touched && postContent.invalid }">
		<label for="content">What do you want to say?</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="content" id="content" class="form-control" maxlength="50" required [(ngModel)]="post.postSubmission" #postContent="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addPostForm.invalid"><i class="fa fa-share"></i> Post</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<form *ngIf="edited === true" #addPostForm="ngForm" name="addPostForm" id="addPostForm" class="form-horizontal well" (ngSubmit)="changePost();" novalidate>
	<h2>Edit Post</h2>

	<div class="form-group" [ngClass]="{ 'has-error': postUserName.touched && postUserName.invalid }">
		<label for="name">Post UserName</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="name" id="name" class="form-control" maxlength="50" required [(ngModel)]="post.postProfileUserName" #postUserName="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': postUserName.touched && postContent.invalid }">
		<label for="content">What do you want to say?</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="content" id="content" class="form-control" maxlength="50" required [(ngModel)]="post.postSubmission" #postContent="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addPostForm.invalid"><i class="fa fa-share"></i> Post</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>All Posts by Member {{ post.postPostUserName }}</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Id</th><th>Submitter</th><th>UserName</th><th>Submitted</th><th>Edit</th><th>Delete</th></tr>
	<tr *ngFor="let post of posts">
		<td>{{ post.postId }}</td>
		<td>{{ post.postProfileUserName }}</td>
		<td>{{ post.postSubmission }}</td>
		<td>{{ post.postTime.date | date: 'MM-dd-yyyy @ HH:mm' }}</td>
		<td><a class="btn btn-warning" (click)="switchPost(post)"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		<td><a class="btn btn-warning" (click)="deletePost(post);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>