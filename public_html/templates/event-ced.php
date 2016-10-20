<form #addEventForm="ngForm" name="addEventForm" id="addEventForm" class="form-horizontal well" (ngSubmit)="createEvent();" novalidate>
	<h2>Create Event</h2>

	<div class="form-group" [ngClass]="{ 'has-error': eventName.touched && eventName.invalid }">
		<label for="event">Event Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="name" id="name" class="form-control" maxlength="50" required [(ngModel)]="event.eventName" #eventName="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': eventDate.touched && eventDate.invalid }">
		<label for="date">Event Date</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="date" id="date" class="form-control" maxlength="50" required [(ngModel)]="event.eventDate" #eventDate="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addEventForm.invalid"><i class="fa fa-share"></i> Event</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>All Events</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Event ID</th><th>Event Creator</th><th>Event</th><th>Date @ Time</th><th>Edit</th><th>Delete</th></tr>
	<tr *ngFor="let event of events">
		<td>{{ event.eventId }}</td>
		<td>{{ event.eventProfileId }}</td>
		<td>{{ event.eventName }}</td>
		<td>{{ event.eventDate.date | date: 'MMM-dd-y @ HH:mm' }}</td>
		<td><a class="btn btn-warning" (click)="switchEvent(event)"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		<td><a class="btn btn-warning" (click)="deleteEvent(event);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>