import {Component} from '@angular/core';

@Component({
	selector: 'calendar',
	templateUrl: 'app/templates/calendar.component.html',
	styleUrls: ['app/app.css']
})

export class CalendarComponent {

	constructor(private http: Http) {}


	getCalendar() :  Observable<CalendarData[]>   {

		return this.http.get('../lib/apis/event/index.php').map(this.extractData).catch(this.handleError);

	}

	extractData (response: Response) {

		if(response.status < 200 || response.status >= 300) {
			throw(new Error("Bad response status: " + response.status));
		}

		let reply = [];
		let body = response.json();
		body.forEach(function(item) {
			let sch = {id: item.FIELD1, time: item.FIELD2, station: item.FIELD4, stop: item.FIELD5};
			reply.push(sch);
		});
		return(reply);

	}

	private handleError(error: any) {
		let message = error.message;
		console.log(message);
		return(Observable.throw(message));
	}
}
