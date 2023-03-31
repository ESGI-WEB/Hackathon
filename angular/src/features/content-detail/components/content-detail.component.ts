import {Component, OnDestroy, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";
import {Media} from "../../../app/models/media";
import {map} from "rxjs";
import {MatSnackBar} from "@angular/material/snack-bar";
import {AuthService} from "../../../app/services/auth.service";
import jwt_decode from 'jwt-decode';

@Component({
  selector: 'app-main',
  templateUrl: './content-detail.component.html',
  styleUrls: ['./content-detail.component.scss'],
})
export class ContentDetailComponent implements OnInit, OnDestroy {

  public loading = true;
  public content: Content|null = null;
  public mainMedia: Media|null = null;
  public email_me: string;

  constructor(
    private route: ActivatedRoute,
    private contentService: ContentService,
    private snackBar: MatSnackBar,
    private authService: AuthService,
  ) {
    this.email_me = '';
  }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    this.contentService.getContent(Number(id))
      .pipe(map((content) => {
        const mainMediaIndex = content.media.findIndex((media) => ['image', 'video'].includes(media.type.slug));
        if (mainMediaIndex >= 0) {
          this.mainMedia = content.media[mainMediaIndex];
          content.media.splice(mainMediaIndex, 1);
        }
        return content;
      }))
      .subscribe({
        next: (content) => {
          this.content = content;
          this.openSnackBar();
        },
        error: (error) => {
          console.log(error);
        },
        complete: () => {
          this.loading = false;
        }
      });
    const token = jwt_decode(this.authService.getToken()) as any;
    this.email_me = token.email
  }

  openSnackBar() {
    if (this.content?.status === 'pending') {
      this.snackBar.open("Ce contenu est en attente de validation, afin d'être disponible pour tous", "Ok", {
        verticalPosition: 'top',
      });
    }
  }

  ngOnDestroy(): void {
    this.snackBar.dismiss();
  }

  public getRole(roles: Array<string>): string {
    if(roles.includes('ROLE_MODERATOR')) {
      return 'Pro'
    } else {
      return 'Client'
    }
  }
}
