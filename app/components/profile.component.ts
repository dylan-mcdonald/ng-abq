import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/profile.php"
})

export class ProfileComponent implements OnInit {
	deleted: boolean = false;
	profiles: Profile[] = [];
	profile: Profile = new Profile(0, 0, "", "", "", "", "", "", "");
	status: Status = null;

	constructor(private profileService: ProfileService, private router: Router, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params : Params) => {
			let profileId = +params["profileId"];
			this.profileService.getProfile(profileId)
				.subscribe(profile => this.profile = profile);
		});
		this.reloadProfiles();
	}

	createProfile() : void {
		this.profileService.createProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadProfiles();
				}
			});
	}

	deleteProfile() : void {
		this.profileService.deleteProfile(this.profile.profileId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.profile = new Profile(0, 0, "", "", "", "", "", "", "");
			});
	}

	editProfile() : void {
		this.profileService.editProfile(this.profile)
			.subscribe(status => this.status = status);
	}

	reloadProfiles() : void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);
	}

	switchProfile(profile : Profile) : void {
		this.router.navigate(["/profile/", profile.profileId]);
	}
}
