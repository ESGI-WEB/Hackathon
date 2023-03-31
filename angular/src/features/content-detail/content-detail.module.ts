import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ContentDetailComponent} from "./components/content-detail.component";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {ContentDetailRoutingModule} from "./content-detail-routing.module";
import {MatListModule} from "@angular/material/list";
import {MatButtonModule} from "@angular/material/button";
import {MatIconModule} from "@angular/material/icon";
import {MatSnackBarModule} from "@angular/material/snack-bar";
import {SafeHtmlPipe} from "./SafeHtmlPipe";
import {MatChipsModule} from "@angular/material/chips";

@NgModule({
  declarations: [
    ContentDetailComponent,
    SafeHtmlPipe
  ],
  imports: [
    ContentDetailRoutingModule,
    CommonModule,
    MatProgressSpinnerModule,
    MatListModule,
    MatButtonModule,
    MatIconModule,
    MatSnackBarModule,
    MatChipsModule,
  ]
})
export class ContentDetailModule { }
