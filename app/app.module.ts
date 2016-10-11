import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {ReCaptchaModule} from 'angular2-recaptcha/angular2-recaptcha';
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {EventService} from "./services/event.service";
import {ImageService} from "./services/image.service";
import {LinkService} from "./services/link.service";
import {PostService} from "./services/post.service";
import {ProfileService} from "./services/profile.service";
import {Profile} from "./classes/profile";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, ReCaptchaModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, EventService, ImageService, LinkService, PostService, ProfileService]
})
export class AppModule {}
