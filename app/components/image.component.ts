import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {ImageService} from "../services/image.service";
import {Image} from "../classes/image";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/image.php"
})

export class ImageComponent implements OnInit {
	deleted: boolean = false;
	images: Image[] = [];
	image: Image = new Image(0, 0, "", "");
	status: Status = null;

	constructor(private imageService: ImageService, private router: Router, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params : Params) => {
			let imageId = +params["imageId"];
			this.imageService.getImage(imageId)
				.subscribe(image => this.image = image);
		});
		this.reloadImages();
	}

	createImage() : void {
		this.imageService.createImage(this.image)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadImages();
				}
			});
	}

	deleteImage() : void {
		this.imageService.deleteImage(this.image.imageId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.image = new Image(0, 0, "", "");
			});
	}

	editImage() : void {
		this.imageService.editImage(this.image)
			.subscribe(status => this.status = status);
	}

	reloadImages() : void {
		this.imageService.getAllImages()
			.subscribe(images => this.images = images);
	}

	switchImage(image : Image) : void {
		this.router.navigate(["/image/", image.imageId]);
	}
}
