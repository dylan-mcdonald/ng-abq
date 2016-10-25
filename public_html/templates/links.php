<h1>Links</h1>
<p>Check out what we've been doing in the ABQ Angular community.</p>
<p></p>
<h3>All Links</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Id</th>
		<th>Submitter</th>
		<th>Url</th>
		<th>Submitted</th>
	</tr>

	<tr *ngFor="let link of links">
		<td>{{ link.linkId }}</td>
		<td>{{ link.linkProfileUserName }}</td>
		<td>{{ link.linkUrl }}</td>
		<td>{{ link.linkDate.date | date: 'MM-dd-yyyy' }}</td>
	</tr>

</table>