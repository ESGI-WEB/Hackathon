import { NgModule } from '@angular/core';
import { HomeRoutingModule } from './home-routing.module';

import { HomeComponent } from './components/home.component';
import {MatSlideToggleModule} from "@angular/material/slide-toggle";
import {MatTabsModule} from "@angular/material/tabs";
import {MatCardModule} from "@angular/material/card";
import {MatChipsModule} from "@angular/material/chips";

@NgModule({
  declarations: [
    HomeComponent,
  ],
    imports: [
        HomeRoutingModule,
        MatTabsModule,
        MatCardModule,
        MatChipsModule
    ]
})
export class HomeModule { }
