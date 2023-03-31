import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ContentRequestDetailsRoutingModule } from './content-request-details-routing.module';
import {ContentRequestDetailsComponent} from "./components/content-request-details.component";


@NgModule({
  declarations: [
    ContentRequestDetailsComponent,
  ],
  imports: [
    CommonModule,
    ContentRequestDetailsRoutingModule
  ]
})
export class ContentRequestDetailsModule { }
