import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";
import {Media} from "../../../app/models/media";
import {map} from "rxjs";

@Component({
  selector: 'app-main',
  templateUrl: './content-detail.component.html',
  styleUrls: ['./content-detail.component.scss'],
})
export class ContentDetailComponent implements OnInit {

  public loading = true;
  public content: Content|null = null;
  public mainMedia: Media|null = null;

  constructor(
    private route: ActivatedRoute,
    private contentService: ContentService
  ) {
  }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    this.contentService.getContent(Number(id))
      .pipe(map((content) => {
        const mainMediaIndex = content.media.findIndex((media) => ['image', 'video'].includes(media.type.slug));
        this.mainMedia = content.media[mainMediaIndex];
        content.media.splice(mainMediaIndex, 1);
        return content;
      }))
      .subscribe({
        next: (content) => {
          this.content = content;
        },
        error: (error) => {
          console.log(error);
        },
        complete: () => {
          this.loading = false;
        }
      });
  }
}
