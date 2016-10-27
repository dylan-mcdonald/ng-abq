<h1>Discussions</h1>
<p>All the discussions in the ABQ Angular community.</p>
<p></p>
<h3>All Discussions</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Post</th>
		<th>Submitter</th>
		<th>Time & Date</th>
	</tr>

	<tr *ngFor="let post of posts">
		<td>{{ post.postSubmission }}</td>
		<td>{{ post.postProfileUserName }}</td>
		<td>{{ post.postTime.date | date: 'HH:mm on MMM-dd-y' }}</td>
		<p></p><p></p>
		<table class="table table-bordered table-responsive table-striped table-word-wrap">
			<tr>
				<th>Comment</th>
			</tr>
			<tr *ngFor="let comment of comments">
				<td *ngIf="comment.commentPostId === post.postId">{{ comment.commentSubmission }}</td>
			</tr>
			</table>

	</tr>
</table>