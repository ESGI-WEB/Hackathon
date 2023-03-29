import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MainComponent } from './components/main.component';

const routes: Routes = [
  {
    path:"", component: MainComponent,
    children : [
      {
        path: 'accueil',
        loadChildren: () => import('../../features/home/home.module').then(mod => mod.HomeModule),
      },
      {
        path: '**', redirectTo: 'accueil'
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MainRoutingModule { }
