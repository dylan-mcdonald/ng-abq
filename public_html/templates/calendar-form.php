<form #eventForm="ngForm" name="eventForm" id="eventForm" class="form-horizontal well" (ngSubmit)="createEvent();" novalidate>
	<h2>Create Event</h2>

	<div class="form-group" [ngClass]="{ 'has-error': event.touched && event.invalid }">
		<label for="event">Event Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="event" id="event" class="form-control" maxlength="50" required [(ngModel)]="event.eventName" #eventText="ngModel" />
		</div>
		<div [hidden]="eventText.valid || eventText.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="eventText.errors?.required">Event is required.</p>
			<p *ngIf="eventText.errors?.maxlength">Event is too long. You typed</p>
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': time.touched && time.invalid }">
		<label for="date">Date</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-quote-left" aria-hidden="true"></i>
			</div>
			<input type="text" name="date" id="date" class="form-control" maxlength="20" required [(ngModel)]="event.eventTime" #attribution="ngModel" />
		</div>
		<div [hidden]="time.valid || time.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="time.errors?.required">Time is required.</p>
			<p *ngIf="time.errors?.maxlength">Time is too long.</p>
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="eventForm.invalid"><i class="fa fa-share"></i> Event</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>
<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>
<hr />
<h1>All Events</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Event ID</th><th>Event Creator</th><th>Event</th><th>Date @ Time</th><th>Edit</th></tr>
	<tr *ngFor="let event of events">
		<td>{{ event.eventId }}</td>
		<td>{{ event.eventProfileUserName }}</td>
		<td>{{ event.eventName }}</td>
		<td>{{ event.eventDate.date | date: 'MMM-dd-y @ HH:mm' }}</td>
		<td><a class="btn btn-warning" (click)="switchEvent(event);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
	</tr>
</table>