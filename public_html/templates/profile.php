<h1>Members</h1>
<p>All the members in the ABQ Angular community.</p>
<p></p>
<h3>All Members</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Id</th>
		<th>Name</th>
	</tr>

	<tr *ngFor="let profile of profiles">
		<td>{{ profile.profileId }}</td>
		<td>{{ profile.profileUserName }}</td>
	</tr>

</table>