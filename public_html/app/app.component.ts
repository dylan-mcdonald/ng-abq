import {Component} from "@angular/core";

@Component({
	selector: 'deepdivedylan-app',
	templateUrl: './templates/deepdivedylan-app.html'
})

export class AppComponent {
	navCollapse = true;

	toggleCollapse() {
		this.navCollapse = !this.navCollapse;
	}
}
