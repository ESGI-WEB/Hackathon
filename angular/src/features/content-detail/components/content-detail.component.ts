import {Component, OnDestroy, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";
import {Media} from "../../../app/models/media";
import {map} from "rxjs";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormControl, Validators} from "@angular/forms";
import {Opinion, PostOpinion} from "../../../app/models/opinion";
import {OpinionService} from "../../../app/services/opinion.service";
import {AuthService} from "../../../app/services/auth.service";
import jwt_decode from 'jwt-decode';

@Component({
  selector: 'app-main',
  templateUrl: './content-detail.component.html',
  styleUrls: ['./content-detail.component.scss'],
})
export class ContentDetailComponent implements OnInit, OnDestroy {

  public loading = true;
  public submitting = false;
  public content: Content|null = null;
  public mainMedia: Media|null = null;
  public email_me: string;
  public commentControl: FormControl;
  public role: Array<string>;

  constructor(
    private route: ActivatedRoute,
    private contentService: ContentService,
    private opinionService: OpinionService,
    private snackBar: MatSnackBar,
    public router: Router,
    private authService: AuthService,
  ) {
    this.commentControl = new FormControl('', [Validators.required, Validators.minLength(100), Validators.maxLength(5000)]);
    this.email_me = '';
    this.role = [];
  }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if(id != null){
      this._getContent(Number(id))
    }
  }

  validateContent() {
    this.contentService.validateContent(this.content?.id as number).subscribe({
      next: (content) => {
        this.content = content;
        this.router.navigate(['/content-request-list']);
      },
      error: (error) => {
        console.log(error);
      },
      complete: () => {
        this.loading = false;
      }
    });
  }

  private _getContent(id: number): void {
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
    if (this.authService.getToken()) {
      const token = jwt_decode(this.authService.getToken()) as any;
      this.email_me = token.email;
      this.role = token.roles;
    }
  }

  rejectContent() {
    this.contentService.rejectContent(this.content?.id as number).subscribe({
      next: (content) => {
        this.content = content;
        this.router.navigate(['/content-request-list']);
      },
      error: (error) => {
        console.log(error);
      },
      complete: () => {
        this.loading = false;
      }
    });
  }

  onSubmit() {
    if (!this.commentControl.value || !this.content) {
      this.commentControl.markAllAsTouched();
      return;
    }

    this.submitting = true;
    this.snackBar.open("Ajout en cours ...");

    const opinion: PostOpinion = {
      content: this.content.id,
      text: this.commentControl.value,
    }

    this.opinionService.postOpinion(opinion).subscribe({
      next: (opinion) => {
        this.content?.opinions.push(opinion);
        this.commentControl.reset();
        this.snackBar.dismiss();
        this.snackBar.open("Commentaire ajouté avec succes", "Ok", {
          duration: 5000,
        });
      },
      error: (error) => {
        console.log(error);
      },
      complete: () => {
        this.submitting = false;
      }
    });
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

  public isArleadyLiked(): boolean {
    if(this.content != null) {
      return this.content.likes.some((like: any) => like.email === this.email_me)
    }
    return false;
  }

  public addOrUnlike(): void {
    if(this.content != null){
      document.getElementById('goutte')?.classList.add('goutte-animation')
      setTimeout(() => {
        document.getElementById('goutte')?.classList.add('goutte-animation-out')
      }, 400)
      setTimeout(() => {
        document.getElementById('goutte')?.classList.remove('goutte-animation')
        document.getElementById('goutte')?.classList.remove('goutte-animation-out')
      }, 400)
      if(!this.isArleadyLiked()){
        this.contentService.likeContent(this.content.id as number).subscribe((content) => {
          this.content = content
        })
      } else {
        this.contentService.unlikeContent(this.content.id as number).subscribe((content) => {
          this.content = content
        })
      }
    }
  }

  goToLogin() {
    this.router.navigate(['/login'], { queryParams: { returnUrl: this.router.url } });
  }
}
