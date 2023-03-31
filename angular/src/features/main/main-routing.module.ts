import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MainComponent } from './components/main.component';
import {AuthGuard, UserisConnected} from "../../app/services/auth.guard";

const routes: Routes = [
  {
    path:"", component: MainComponent,
    children : [
      {
        path: 'accueil',
        loadChildren: () => import('../../features/home/home.module').then(mod => mod.HomeModule),
      },
      {
        path: 'upload',
        canActivate:[UserisConnected],
        loadChildren: () => import('../../features/upload/upload.module').then(mod => mod.UploadModule),
      },
      {
        path: 'login',
        canActivate:[AuthGuard],
        loadChildren: () => import('../../features/login/login.module').then(mod => mod.LoginModule),
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
