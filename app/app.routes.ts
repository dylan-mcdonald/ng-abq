import {RouterModule, Routes} from "@angular/router";
import {EventComponent} from "./components/event.component";
import {EventCedComponent} from "./components/event-ced.component";
import {HeaderComponent} from "./components/header.component";
import {ImageComponent} from "./components/image.component";
import {ImageCdComponent} from "./components/image-cd.component";
import {IntroComponent} from "./components/intro.component";
import {LinkComponent} from "./components/link.component";
import {LinkCedComponent} from "./components/link-ced.component";
import {LoginComponent} from "./components/login.component";
import {NewsComponent} from "./components/news.component";
import {PostComponent} from "./components/post.component";
import {PostOrCommentComponent} from "./components/post-or-comment.component";
import {ProfileComponent} from "./components/profile.component";
import {ProfileCedComponent} from "./components/profile-ced.component";
import {SignupComponent} from "./components/signup.component";
import {SplashComponent} from "./components/splash.component";


export const allAppComponents = [EventComponent, EventCedComponent, HeaderComponent, ImageComponent, ImageCdComponent, IntroComponent, LinkComponent, LinkCedComponent, LoginComponent, NewsComponent, PostComponent, PostOrCommentComponent,ProfileComponent, ProfileCedComponent, SignupComponent, SplashComponent];

export const routes: Routes = [
	{path: "events", component: EventComponent},
	{path: "event-ced", component: EventCedComponent},
	{path: "discussions", component: PostComponent},
	{path: "post-or-comment", component: PostOrCommentComponent},
	{path: "photos", component: ImageComponent},
	{path: "photo-cd", component: ImageCdComponent},
	{path: "links", component: LinkComponent},
	{path: "link-ced", component: LinkCedComponent},
	{path: "members", component: ProfileComponent},
	{path: "profile-ced", component: ProfileCedComponent},

	//{path: "header", component: HeaderComponent},
	//{path: "login", component: LoginComponent},
	//{path: "news", component: NewsComponent},
	//{path: "signup", component: SignupComponent},
	//{path: "intro", component: IntroComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
