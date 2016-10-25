import {Component} from "@angular/core";

@Component({
	templateUrl: "./templates/signup.php"
})
//Trying to create a signup component not even close to being finished.
export class SignupComponent {}
@ViewChild("addSignupForm") addSignupForm;

signup: Profile[] = [];
profile: Profile = new Profile(0, 0, "", "", "", "", "", "", "");
status: Status = null;

constructor(){}
