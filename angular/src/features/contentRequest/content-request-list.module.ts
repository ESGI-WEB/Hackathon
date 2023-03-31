import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ContentRequestListRoutingModule } from './content-request-list-routing.module';
import {ContentRequestListComponent} from "./components/content-request-list.component";
import {MatChipsModule} from "@angular/material/chips";
import {CardImageModule} from "../card-image/card-image.module";


@NgModule({
  declarations: [
    ContentRequestListComponent
  ],
    imports: [
        CommonModule,
        ContentRequestListRoutingModule,
        MatChipsModule,
        CardImageModule
    ]
})
export class ContentRequestListModule { }
