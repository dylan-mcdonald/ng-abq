import {Injectable} from "@angular/core";
import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";

@injectable()

export class Post{
    constructor (private http: Http ){}

    private PostUrl = "/lib/classes/Post";


    getPost(): Observable<Post[]>{
        return(this.http.get(this.PostUrl)
            .map(this.extractData)
            .catch(this.handleError));

    }


    private extractData(response: Response) {
        if(response.status < 200 || response.status >= 300) {
            throw(new Error("Bad response status: " + response.status))
        }
        return(response.json());
    }


    protected handleError(error:any) {
        let message = error.message;
        console.log(message);
        return(Observable.throw(message));

    }


}