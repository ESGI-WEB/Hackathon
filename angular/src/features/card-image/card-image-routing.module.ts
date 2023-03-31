import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CardImageComponent } from './components/card-image.component';

const routes: Routes = [
  { path: '', pathMatch: 'full', component: CardImageComponent },
  { path: '**', redirectTo: '' },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CardImageRoutingModule { }
