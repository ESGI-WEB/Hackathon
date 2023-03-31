import { Injectable } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  CanActivate,
  NavigationExtras,
  Router,
  RouterStateSnapshot,
  UrlTree
} from '@angular/router';
import { Observable } from 'rxjs';
import {AuthService} from "./auth.service";

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}

canActivate(
  next: ActivatedRouteSnapshot,
  state: RouterStateSnapshot): boolean {
  if (this.authService.isAuthenticate()) {
    this.router.navigate(['/accueil']);
    return false;
  } else {
    return true;
  }
}

}
@Injectable({
  providedIn: 'root'
})
export class UserisConnected implements CanActivate{

  constructor(private authService: AuthService, private router: Router) {}
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): boolean {

    const extras: NavigationExtras = {
      state: {
        ...state,
        previousUrl: state.url
      }
    };
    if (!this.authService.isAuthenticate()) {
      this.router.navigate(['/login'], {queryParams:{returnUrl:state.url}});
      return false;
    }
    else {
      return true;
    }
  }
}

