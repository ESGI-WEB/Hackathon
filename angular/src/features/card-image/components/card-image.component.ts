import {Component, Input, OnInit, ViewEncapsulation} from '@angular/core';
import {Content} from "../../../app/models/content";
import {Media} from "../../../app/models/media";

@Component({
  selector: 'app-card-image',
  templateUrl: './card-image.component.html',
  styleUrls: ['./card-image.component.scss'],
})
export class CardImageComponent implements OnInit {

  @Input() content?: Content;
  private defaultMedia: Media = {
    id: 0,
    url: 'https://img.20mn.fr/xaXGIhosRzqELLhafBG-1Sk/1200x768_plusieurs-professionnels-de-sante-racontent-qu-ils-ont-a-de-nombreuses-reprises-etaient-filmes-ou-enregistres-a-leur-insu-par-des-patients-en-pleine-consultation',
    type: {
      name: 'image',
      slug: 'image',
    },
    name: 'default',
    description: 'default',
    path: 'default',
    content: '0',
  };
  public mainMedia = this.defaultMedia;

  constructor(
  ) { }

  ngOnInit(): void {
    if (this.content) {
      const media = this.content.media.find((media) => ['image', 'video'].includes(media.type.slug));
      this.mainMedia = media ? media : this.defaultMedia;
    }
  }
}
