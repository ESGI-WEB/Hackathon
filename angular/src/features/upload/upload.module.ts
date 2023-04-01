import { NgModule } from '@angular/core';
import { UploadRoutingModule } from './upload-routing.module';

import { UploadComponent } from './components/upload.component';
import {MatInputModule} from "@angular/material/input";
import {MatIconModule} from "@angular/material/icon";
import {MatSelectModule} from "@angular/material/select";
import {ReactiveFormsModule} from "@angular/forms";
import {CommonModule} from "@angular/common";
import {MatButtonModule} from "@angular/material/button";
import {AngularEditorModule} from "@kolkov/angular-editor";
import {UploadMenuComponent} from "./components/upload-menu.component";
import {MatDialogModule} from "@angular/material/dialog";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {MatSnackBarModule} from "@angular/material/snack-bar";

@NgModule({
  declarations: [
    UploadComponent,
    UploadMenuComponent,
  ],
  imports: [
    UploadRoutingModule,
    MatInputModule,
    MatIconModule,
    MatSelectModule,
    ReactiveFormsModule,
    CommonModule,
    MatButtonModule,
    AngularEditorModule,
    MatDialogModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
  ]
})
export class UploadModule { }
