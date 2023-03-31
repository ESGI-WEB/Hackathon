import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MainComponent } from './components/main.component';
import {AuthGuard, UserisConnected} from "../../app/services/auth.guard";
import {ContentDetailComponent} from "../content-detail/components/content-detail.component";

const routes: Routes = [
  {
    path:"",
    component: MainComponent,
    children : [
      {
        path: 'accueil',
        loadChildren: () => import('../../features/home/home.module').then(mod => mod.HomeModule),
      },
      {
        path: 'theme',
        loadChildren: () => import('../../features/theme/theme.module').then(mod => mod.ThemeModule),
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
        path: 'content/:id',
        loadChildren: () => import('../../features/content-detail/content-detail.module').then(mod => mod.ContentDetailModule),
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
