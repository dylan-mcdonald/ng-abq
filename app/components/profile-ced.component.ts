import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/profile-ced.php"
})

export class ProfileCedComponent implements OnInit {
	@ViewChild("addProfileForm") addProfileForm;

	profiles: Profile[] = [];
	profile: Profile = new Profile(0, 0, "", "", "", "", "", "", "");
	status: Status = null;

	constructor(private profileService: ProfileService, private router: Router) {}

	ngOnInit() : void {
		this.reloadProfiles();
	}

	reloadProfiles() : void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);
	}

	switchProfile(profile : Profile) : void {
		console.log(profile.profileId);
		this.router.navigate(["/profile"], profile.profileId);
	}
//, profile.profileId
	createProfile() : void {
		this.profile.profileId = null;
		this.profile.profileId = 1;

		this.profileService.createProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadProfiles();
					this.addProfileForm.reset();
				}
			});
	}
}