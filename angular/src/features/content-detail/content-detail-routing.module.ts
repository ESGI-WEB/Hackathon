import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ContentDetailComponent } from './components/content-detail.component';

const routes: Routes = [
  { path: '', pathMatch: 'full', component: ContentDetailComponent },
  { path: '**', redirectTo: '' },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ContentDetailRoutingModule { }
