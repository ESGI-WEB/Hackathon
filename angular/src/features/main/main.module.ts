import { NgModule } from '@angular/core';

import { MainRoutingModule } from './main-routing.module';
import { MainComponent } from './components/main.component';
import {MatSidenavModule} from "@angular/material/sidenav";
import {MatToolbarModule} from "@angular/material/toolbar";
import {MatIconModule} from "@angular/material/icon";
import {MatDividerModule} from "@angular/material/divider";
import {MatButtonModule} from "@angular/material/button";
import {CommonModule} from "@angular/common";
import {MatListModule} from "@angular/material/list";

@NgModule({
  declarations: [
    MainComponent,
  ],
    imports: [
        CommonModule,
        MainRoutingModule,
        MatToolbarModule,
        MatSidenavModule,
        MatButtonModule,
        MatIconModule,
        MatDividerModule,
        MatListModule
    ],
  providers: [],
})
export class MainModule {}

