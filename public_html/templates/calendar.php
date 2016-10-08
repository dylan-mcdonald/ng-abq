<h1>Calendar</h1>
<p>All the happenings in the ABQ Angular community.</p>
<p></p>
<h1>All Events</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Id</th><th>Event</th><th>Date</th></tr>
	<tr *ngFor="let event of events">
		<td>{{ event.eventId }}</td>
		<td>{{ event.eventName }}</td>
		<td>{{ event.eventDate }}</td>
	</tr>

</table>