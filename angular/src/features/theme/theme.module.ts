import { NgModule } from '@angular/core';
import { ThemeRoutingModule } from './theme-routing.module';

import { ThemeComponent } from './components/theme.component';
import {MatTabsModule} from "@angular/material/tabs";
import {MatCardModule} from "@angular/material/card";
import {MatChipsModule} from "@angular/material/chips";
import {MatIconModule} from "@angular/material/icon";
import {CommonModule} from "@angular/common";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatInputModule} from "@angular/material/input";
import {MatButtonModule} from "@angular/material/button";
import {ReactiveFormsModule} from "@angular/forms";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {CardImageModule} from "../card-image/card-image.module";

@NgModule({
  declarations: [
    ThemeComponent,
  ],
    imports: [
        ThemeRoutingModule,
        MatTabsModule,
        MatCardModule,
        MatChipsModule,
        MatIconModule,
        CommonModule,
        MatFormFieldModule,
        MatInputModule,
        MatButtonModule,
        ReactiveFormsModule,
        MatProgressSpinnerModule,
        CardImageModule
    ]
})
export class ThemeModule { }
