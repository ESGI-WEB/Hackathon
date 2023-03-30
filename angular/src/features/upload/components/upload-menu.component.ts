import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA} from "@angular/material/dialog";
import {mapMediaToIcon, Typemedia} from "../../../app/models/typemedia";

@Component({
  selector: 'app-main',
  templateUrl: './upload-menu.component.html',
  styleUrls: ['./upload-menu.component.scss']
})
export class UploadMenuComponent implements OnInit {
  public typeMedias: Typemedia[] = [];
  constructor(
    @Inject(MAT_DIALOG_DATA) public data: UploadMenuData
  ) { }

  ngOnInit(): void {
    this.typeMedias = this.data.typeMedias;
  }

  mapMediaToIcon(type: Typemedia) {
    return mapMediaToIcon(type);
  }
}

export interface UploadMenuData {
  typeMedias: Typemedia[];
}
