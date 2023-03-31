import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {ContentRequestListComponent} from './components/content-request-list.component';

const routes: Routes = [
  { path: '', pathMatch: 'full', component: ContentRequestListComponent },
  { path: '**', redirectTo: '' },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ContentRequestListRoutingModule { }
