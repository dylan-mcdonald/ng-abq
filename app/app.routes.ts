import {RouterModule, Routes} from "@angular/router";
import {CalendarComponent} from "./components/calendar.component";
import {HeaderComponent} from "./components/header.component";
import {IntroComponent} from "./components/intro.component";
import {LoginComponent} from "./components/login.component";
import {NewsComponent} from "./components/news.component";
import {SignupComponent} from "./components/signup.component";
import {SplashComponent} from "./components/splash.component";


export const allAppComponents = [CalendarComponent, HeaderComponent, IntroComponent, LoginComponent, NewsComponent, SignupComponent, SplashComponent];

export const routes: Routes = [
	{path: "calendar", component: CalendarComponent},
	{path: "header", component: HeaderComponent},
	{path: "login", component: LoginComponent},
	{path: "news", component: NewsComponent},
	{path: "signup", component: SignupComponent},
	{path: "intro", component: IntroComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
