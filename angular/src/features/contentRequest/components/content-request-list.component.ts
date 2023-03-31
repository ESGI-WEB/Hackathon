import {Component, OnInit} from '@angular/core';
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";

@Component({
  selector: 'app-components',
  templateUrl: './content-request-list.component.html',
  styleUrls: ['./content-request-list.component.scss']
})
export class ContentRequestListComponent implements OnInit {

  private static readonly STATUS_PENDING = "pending";
  public requestContents: Array<Content>;
  constructor(
    private contentService: ContentService,
  ) {
    this.requestContents = [];
  }

  ngOnInit(): void {
    const searchObject = {
      name: "",
      status: [ContentRequestListComponent.STATUS_PENDING],
      themes: []
    }
    this.contentService.searchContents(searchObject).subscribe({
      next: (contentService) => {
        this.requestContents = contentService;
      },
      error: (error) => {
        console.log(error);
      },
      complete: () => {
        console.log("Complete");
      }
    });
  }

}
