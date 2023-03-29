import { NgModule } from '@angular/core';
import { UploadRoutingModule } from './upload-routing.module';

import { UploadComponent } from './components/upload.component';
import {MatInputModule} from "@angular/material/input";
import {MatIconModule} from "@angular/material/icon";
import {MatSelectModule} from "@angular/material/select";
import {ReactiveFormsModule} from "@angular/forms";
import {CommonModule} from "@angular/common";
import {MatButtonModule} from "@angular/material/button";

@NgModule({
  declarations: [
    UploadComponent,
  ],
  imports: [
    UploadRoutingModule,
    MatInputModule,
    MatIconModule,
    MatSelectModule,
    ReactiveFormsModule,
    CommonModule,
    MatButtonModule
  ]
})
export class UploadModule { }
