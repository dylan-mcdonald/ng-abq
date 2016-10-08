import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/calendar.php"
})

export class CalendarComponent implements OnInit {
	deleted: boolean = false;
	events: Event[] = [];
	event: Event = new Event(0, 0, "", "");
	status: Status = null;

	constructor(private eventService: EventService, private router: Router, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params : Params) => {
			let eventId = +params["eventId"];
			this.eventService.getEvent(eventId)
				.subscribe(event => this.event = event);
		});
		this.reloadEvents();
	}

	createEvent() : void {
		this.eventService.createEvent(this.event)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadEvents();
				}
			});
	}

	deleteEvent() : void {
		this.eventService.deleteEvent(this.event.eventId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.event = new Event(0, 0, "", "");
			});
	}

	editEvent() : void {
		this.eventService.editEvent(this.event)
			.subscribe(status => this.status = status);
	}

	reloadEvents() : void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}

	switchEvent(event : Event) : void {
		this.router.navigate(["/event/", event.eventId]);
	}
}
