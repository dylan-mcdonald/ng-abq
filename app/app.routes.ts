import {RouterModule, Routes} from "@angular/router";
import {EventComponent} from "./components/event.component";
import {HeaderComponent} from "./components/header.component";
import {IntroComponent} from "./components/intro.component";
import {LoginComponent} from "./components/login.component";
import {NewsComponent} from "./components/news.component";
import {SignupComponent} from "./components/signup.component";


export const allAppComponents = [EventComponent, HeaderComponent, IntroComponent, LoginComponent, NewsComponent, SignupComponent];

export const routes: Routes = [
	{path: "event", component: EventComponent},
	{path: "header", component: HeaderComponent},
	{path: "login", component: LoginComponent},
	{path: "news", component: NewsComponent},
	{path: "signup", component: SignupComponent},
	{path: "", component: IntroComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
