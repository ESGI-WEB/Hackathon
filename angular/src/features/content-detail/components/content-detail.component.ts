import {Component, OnDestroy, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";
import {Media} from "../../../app/models/media";
import {map} from "rxjs";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormControl, Validators} from "@angular/forms";
import {Opinion, PostOpinion} from "../../../app/models/opinion";
import {OpinionService} from "../../../app/services/opinion.service";

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
  public commentControl: FormControl;

  constructor(
    private route: ActivatedRoute,
    private contentService: ContentService,
    private opinionService: OpinionService,
    private snackBar: MatSnackBar,
  ) {
    this.commentControl = new FormControl('', [Validators.required, Validators.minLength(100), Validators.maxLength(5000)]);
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
}
