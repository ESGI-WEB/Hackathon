import {AfterViewInit, ChangeDetectorRef, Component, OnChanges, ViewChild} from '@angular/core';
import { BreakpointObserver } from '@angular/cdk/layout';
import { MatSidenav } from '@angular/material/sidenav';
import { delay, filter } from 'rxjs/operators';
import { NavigationEnd, Router } from '@angular/router';
import { UntilDestroy, untilDestroyed } from '@ngneat/until-destroy';
import {AuthService} from "../../../app/services/auth.service";

@UntilDestroy()
@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})
export class MainComponent implements AfterViewInit {

  @ViewChild(MatSidenav)
  public sidenav!: MatSidenav;
  public token: any;

  constructor(
    private observer: BreakpointObserver,
    private router: Router,
    private authService : AuthService,
    private chref: ChangeDetectorRef
  ) {}

  logout() {
    this.authService.logout();
    this.token = '';
    this.router.navigate(['/login']);
  }

  login() {
    this.router.navigate(['/login']);
  }

  ngAfterViewInit() {
    this.observer
      .observe(['(max-width: 800px)'])
      .pipe(delay(1), untilDestroyed(this))
      .subscribe((res) => {
        if (res.matches) {
          this.sidenav.mode = 'over';
          this.sidenav.close();
        } else {
          this.sidenav.mode = 'side';
          this.sidenav.open();
        }
      });

    this.router.events
      .pipe(
        untilDestroyed(this),
        filter((e) => e instanceof NavigationEnd)
      )
      .subscribe(() => {
        if (this.sidenav.mode === 'over') {
          this.sidenav.close();
        }
        this.token = this.authService.getDecodeToken();
      });

    this.token = this.authService.getDecodeToken();
  }
}

