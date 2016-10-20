import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {ImageService} from "../services/image.service";
import {Image} from "../classes/image";
import {Status} from "../classes/status";

@Component({
	templateUrl: "/templates/image-cd.php"
})

export class ImageCdComponent implements OnInit {
	@ViewChild("addImageForm") addImageForm;

	images: Image[] = [];
	image: Image = new Image(0, 0, "", "");
	status: Status = null;

	constructor(private imageService: ImageService, private router: Router) {}

	ngOnInit() : void {
		this.reloadImages();
	}

	reloadImages() : void {
		this.imageService.getAllImages()
			.subscribe(images => this.images = images);
	}

	switchImage(image : Image) : void {
		console.log(image.imageId);
		this.router.navigate(["/image"], image.imageId);
	}
//, image.imageId
	createImage() : void {
		this.image.imageId = null;
		this.image.imageProfileId = 1;

		this.imageService.createImage(this.image)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadImages();
					this.addImageForm.reset();
				}
			});
	}
}