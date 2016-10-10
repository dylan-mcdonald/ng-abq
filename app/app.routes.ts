import {RouterModule, Routes} from "@angular/router";
import {CalendarComponent} from "./components/calendar.component";
import {HeaderComponent} from "./components/header.component";
import {IntroComponent} from "./components/intro.component";
import {LinkComponent} from "./components/link.component";
import {LoginComponent} from "./components/login.component";
import {NewsComponent} from "./components/news.component";
import {PostComponent} from "./components/post.component";
import {SignupComponent} from "./components/signup.component";
import {SplashComponent} from "./components/splash.component";


export const allAppComponents = [CalendarComponent, HeaderComponent, IntroComponent, LinkComponent, LoginComponent, NewsComponent, PostComponent, SignupComponent, SplashComponent];

export const routes: Routes = [
	{path: "calendar", component: CalendarComponent},
	//{path: "header", component: HeaderComponent},
	{path: "links", component: LinkComponent},
	{path: "discuss", component: PostComponent},
	//{path: "login", component: LoginComponent},
	//{path: "news", component: NewsComponent},
	//{path: "signup", component: SignupComponent},
	//{path: "intro", component: IntroComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
