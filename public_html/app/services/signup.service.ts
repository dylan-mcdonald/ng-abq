import {Injectable} from "@angular/core";
import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";

@injectable()
export class Profile{

    constructor(private http: Http) {}


    protected extractData(response: Response) {
        if(response.status < 200 || response.status >= 300) {
            throw(new Error("Bad response status: " + response.status))
        }
        return(response.json());
    }









}