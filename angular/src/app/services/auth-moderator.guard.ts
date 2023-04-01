import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot} from '@angular/router';
import {AuthService} from "./auth.service";
import jwt_decode from "jwt-decode";
import {hasModeratorRole} from "../models/user";

@Injectable({
  providedIn: 'root'
})
export class AuthModeratorGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): boolean {

    const token = this.authService.getToken();
    const decodedToken = jwt_decode(token) as any;

    if (!decodedToken || !hasModeratorRole(decodedToken.roles)) {
      this.router.navigate(['/']);
      return false;
    }
    else {
      return true;
    }
  }

}
