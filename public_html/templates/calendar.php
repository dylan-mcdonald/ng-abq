<h1>Calendar</h1>
<p>All the happenings in the ABQ Angular community.</p>
<p></p>
<h3>All Events</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Id</th>
		<th>Event</th>
		<th>Date & Time</th>
	</tr>

	<tr *ngFor="let event of events">
		<td>{{ event.eventId }}</td>
		<td>{{ event.eventName }}</td>
		<td>{{ event.eventDate.date | date: 'MMM-dd-y @ HH:mm' }}</td>
	</tr>

</table>