import { NgModule } from '@angular/core';
import { CardImageRoutingModule } from './card-image-routing.module';
import { CardImageComponent } from './components/card-image.component';
import {CommonModule} from "@angular/common";

@NgModule({
  declarations: [
    CardImageComponent,
  ],
  exports: [
    CardImageComponent
  ],
  imports: [
    CardImageRoutingModule,
    CommonModule,
  ]
})
export class CardImageModule { }
