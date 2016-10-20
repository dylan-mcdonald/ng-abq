import {RouterModule, Routes} from "@angular/router";
import {EventComponent} from "./components/event.component";
import {EventCedComponent} from "./components/event-ced.component";
import {HeaderComponent} from "./components/header.component";
import {ImageComponent} from "./components/image.component";
import {IntroComponent} from "./components/intro.component";
import {LinkComponent} from "./components/link.component";
import {LoginComponent} from "./components/login.component";
import {NewsComponent} from "./components/news.component";
import {PostComponent} from "./components/post.component";
import {ProfileComponent} from "./components/profile.component";
import {SignupComponent} from "./components/signup.component";
import {SplashComponent} from "./components/splash.component";


export const allAppComponents = [EventComponent, EventCedComponent, HeaderComponent, ImageComponent, IntroComponent, LinkComponent, LoginComponent, NewsComponent, PostComponent, ProfileComponent, SignupComponent, SplashComponent];

export const routes: Routes = [
	{path: "events", component: EventComponent},
	{path: "event-ced", component: EventCedComponent},
	{path: "discussions", component: PostComponent},
	{path: "photos", component: ImageComponent},
	{path: "links", component: LinkComponent},
	{path: "members", component: ProfileComponent},

	//{path: "header", component: HeaderComponent},
	//{path: "login", component: LoginComponent},
	//{path: "news", component: NewsComponent},
	//{path: "signup", component: SignupComponent},
	//{path: "intro", component: IntroComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
