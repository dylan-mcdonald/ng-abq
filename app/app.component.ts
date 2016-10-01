import {Component} from "@angular/core";

@Component({
	selector: 'ng-abq-app',
	templateUrl: './templates/app.php'
})

export class AppComponent {
	navCollapse = true;

	toggleCollapse() {
		this.navCollapse = !this.navCollapse;
	}
}
