import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";
//superflous comment
@Component({
	templateUrl: "/templates/event-ced.php"
})

export class EventCedComponent implements OnInit {
	@ViewChild("addEventForm") addEventForm;

	deleted: boolean = false;
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

	switchEvent(event : Event) : void {
		console.log(event.eventId);
		this.router.navigate(["/event"], event.eventId);
	}
//, event.eventId
	createEvent() : void {
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

	deleteEvent() : void {
		this.eventService.deleteEvent(this.event.eventId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.event = new Event(0, 0, "", "");
			});
	}
}