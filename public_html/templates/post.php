<h1>Posts</h1>
<p>All the discussions in the ABQ Angular community.</p>
<p></p>
<h3>All Posts</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Id</th>
		<th>Post</th>
		<th>Submitter</th>
		<th>Time & Date</th>
	</tr>

	<tr *ngFor="let post of posts">
		<td>{{ post.postId }}</td>
		<td>{{ post.postSubmission }}</td>
		<td>{{ post.postProfileUserName }}</td>
		<td>{{ post.postTime.date | date: 'HH:mm on MMM-dd-y' }}</td>
	</tr>

</table>