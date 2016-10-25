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
	deleted: boolean = false;
	edited: boolean = false;
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

	switchProfile(profile: Profile): void {
		this.edited = true;
		console.log("edit profileId",profile.profileId);
		this.profileService.getProfile(profile.profileId)
			.subscribe(profile => this.profile = profile);
	}

	changeProfile(profile: Profile): void {
		this.edited = true;
		console.log(this.profile);
		this.profileService.editProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				console.log(status.status);
				if(status.status === 200) {
					this.edited = false;
					this.ngOnInit();
					this.addProfileForm.reset();
				}
			});
	}

	createProfile(): void {
		console.log("create");
		this.profile.profileId = null;
		this.profileService.createProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadProfiles();
					this.addProfileForm.reset();
				}
			});
	}

	deleteProfile(profile: Profile): void {
		console.log("delete profileId", profile.profileId);
		this.profileService.deleteProfile(profile.profileId)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadProfiles();
					this.addProfileForm.reset();
				}
			});
	}
}