import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ContentDetailComponent} from "./components/content-detail.component";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {ContentDetailRoutingModule} from "./content-detail-routing.module";
import {MatListModule} from "@angular/material/list";
import {MatButtonModule} from "@angular/material/button";
import {MatIconModule} from "@angular/material/icon";
import {MatSnackBarModule} from "@angular/material/snack-bar";

@NgModule({
  declarations: [
    ContentDetailComponent
  ],
    imports: [
        ContentDetailRoutingModule,
        CommonModule,
        MatProgressSpinnerModule,
        MatListModule,
        MatButtonModule,
        MatIconModule,
        MatSnackBarModule,
    ]
})
export class ContentDetailModule { }
