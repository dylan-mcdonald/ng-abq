import {Component} from "@angular/core";

@Component({
	selector: 'ng-bq-app',
	templateUrl: './templates/app.php'
})

export class AppComponent {
	navCollapse = true;

	toggleCollapse() {
		this.navCollapse = !this.navCollapse;
	}
}
