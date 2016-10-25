import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/event-ced.php"
})

export class EventCedComponent implements OnInit {
	@ViewChild("addEventForm") addEventForm;

	deleted: boolean = false;
	edited: boolean = false;
	events: Event[] = [];
	event: Event = new Event(0, 0, "", "");
	status: Status = null;

	constructor(private eventService: EventService, private router: Router) {}

	ngOnInit() : void {
		this.reloadEvents();
	}

	reloadEvents() : void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}

	switchEvent(event: Event): void {
		this.edited = true;
		console.log("edit eventId",event.eventId);
		this.eventService.getEvent(event.eventId)
			.subscribe(event => this.event = event);
	}

	changeEvent(event: Event): void {
		this.edited = true;
		console.log(this.event);
		this.eventService.editEvent(this.event)
			.subscribe(status => {
				this.status = status;
				console.log(status.status);
				if(status.status === 200) {
					this.edited = false;
					this.reloadEvents();
					this.addEventForm.reset();
				}
			});
	}

	createEvent(): void {
		this.event.eventId = null;
		this.event.eventProfileId = 1;
		this.eventService.createEvent(this.event)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadEvents();
					this.addEventForm.reset();
				}
			});
	}

	deleteEvent(event: Event): void {
		console.log("delete eventId", event.eventId);
		this.eventService.deleteEvent(event.eventId)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadEvents();
					this.addEventForm.reset();
				}
			});
	}

}

