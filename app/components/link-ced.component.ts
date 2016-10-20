import {Component, OnInit, ViewChild} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {LinkService} from "../services/link.service";
import {Link} from "../classes/link";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/link-ced.php"
})

export class LinkCedComponent implements OnInit {
	@ViewChild("addLinkForm") addLinkForm;
	deleted: boolean = false;
	edited: boolean = false;
	links: Link[] = [];
	link: Link = new Link(0, 0, "", "", "");
	status: Status = null;

	constructor(private linkService: LinkService, private router: Router, private route: ActivatedRoute) {}

	// ngOnInit() : void {
	// 	this.reloadLinks();
	// }

	ngOnInit(): void {

			let id = this.link.linkId;
			console.log(id);
			this.linkService.getLink(id)
				.subscribe(link => this.link = link);

		this.reloadLinks();
	}

	reloadLinks() : void {
		this.linkService.getAllLinks()
			.subscribe(links => this.links = links);
	}

	changeLink(link : Link) : void {
		this.edited = true;
		console.log(link.linkId);
		this.linkService.getLink(link.linkId)
			.subscribe(link => this.link = link);
		// this.router.navigate(["/link-ced"], link.linkId);
	}

	createLink() : void {
		this.link.linkId = null;
		this.link.linkProfileId = 1;
		this.link.linkProfileUserName = "hannahsue";
		this.link.linkDate = null;
		this.linkService.createLink(this.link)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadLinks();
					this.addLinkForm.reset();
				}
			});
	}


}