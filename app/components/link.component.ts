import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {LinkService} from "../services/link.service";
import {Link} from "../classes/link";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/links.php"
})
export class LinkComponent implements OnInit {
	deleted: boolean = false;
	links: Link[] = [];
	link: Link = new Link(0, 0, "", "", "");
	status: Status = null;

	constructor(private linkService: LinkService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.reloadLinks();
	}

	reloadLinks() : void {
		this.linkService.getAllLinks()
			.subscribe(links => this.links = links);
	}


}
