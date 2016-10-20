import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/events.php"
})

export class EventComponent implements OnInit {
	delete: boolean = false;
	events: Event[] = [];
	event: Event = new Event(0, 0, "", "");
	status: Status = null;

	constructor(private eventService: EventService, private router: Router, private route: ActivatedRoute) {
	}

	ngOnInit(): void {

		// this.route.params.forEach((params : Params) => {
		// 	// let id = 2;
		// 		let id = +params["eventId"];
		// 	console.log(this.route.params);
		// });
		// 	let id = event["eventId"];
		// 	let id = 2;
		// console.log(id);
		// this.eventService.getEvent(id)
		// 	.subscribe(event => this.event = event);
		// });
		this.reloadEvents();

	}

	// createEvent() : void {
	// 	this.eventService.createEvent(this.event)
	// 		.subscribe(status => {
	// 			this.status = status;
	// 			if(status.status === 200) {
	// 				this.reloadEvents();
	// 			}
	// 		});
	// }

	// deleteEvent() : void {
	// 	this.eventService.deleteEvent(this.event.eventId)
	// 		.subscribe(status => {
	// 			this.deleted = true;
	// 			this.status = status;
	// 			this.event = new Event(0, 0, "", "");
	// 		});
	// }

	// editEvent() : void {
	// 	this.eventService.editEvent(this.event)
	// 		.subscribe(status => this.status = status);
	// }

	reloadEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}
}

// 	switchEvent(event : Event) : void {
// 		this.router.navigate(["/event/", event.eventId]);
// 	}
// }
