import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Image} from "../classes/image";
import {Status} from "../classes/status";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private imageUrl = "./lib/apis/image/";

	deleteImage(imageId: number) : Observable<Status> {
		return(this.http.delete(this.imageUrl + imageId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllImages() : Observable<Image[]> {
		return(this.http.get(this.imageUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getImage(imageId: number) : Observable<Image> {
		return(this.http.get(this.imageUrl + imageId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createImage(image: Image) : Observable<Status> {
		return(this.http.post(this.imageUrl, image)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editImage(image: Image) : Observable<Status> {
		return(this.http.put(this.imageUrl + image.imageId, image)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
