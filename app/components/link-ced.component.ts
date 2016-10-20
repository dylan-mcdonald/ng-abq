import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {LinkService} from "../services/link.service";
import {Link} from "../classes/link";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/link-ced.php"
})

export class LinkCedComponent implements OnInit {
	@ViewChild("addLinkForm") addLinkForm;

	links: Link[] = [];
	link: Link = new Link(0, 0, "", "", "");
	status: Status = null;

	constructor(private linkService: LinkService, private router: Router) {}

	ngOnInit() : void {
		this.reloadLinks();
	}

	reloadLinks() : void {
		this.linkService.getAllLinks()
			.subscribe(links => this.links = links);
	}

	switchLink(link : Link) : void {
		console.log(link.linkId);
		this.router.navigate(["/link"], link.linkId);
	}
//, link.linkId
	createLink() : void {
		this.link.linkId = null;
		this.link.linkProfileId = 1;

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