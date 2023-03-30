import {Component, OnInit, ViewEncapsulation} from '@angular/core';
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";

export interface Question {
  question: string;
  opinion: number;
  comment: number;
  themes: Array<string>;
}

@Component({
  selector: 'app-main',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class HomeComponent implements OnInit {

  public questions: Array<Question>
  public contents: Array<Content>

  constructor(
    private contentService: ContentService
  ) {
    this.questions = [];
    this.contents = []
  }

  ngOnInit(): void {
    this._getContents()
    this._setQuestions()
  }

  private _setQuestions() {
    this.questions = [
      {
        question: "Bonjour, je viens d'avoir un enfant, comment cela se passe-t-il pour l'ajouter à la mutuelle ? Est-ce payant ?",
        opinion: 2,
        comment: 8,
        themes: ['enfant', 'ajout']
      },
      {
        question: "Bonjour, je souhaiterais savoir jusqu'à quel âge mon enfant peut bénéficier des avantages de ma mutuelle ?",
        opinion: 14,
        comment: 18,
        themes: ['enfant', 'age']
      },
      {
        question: "Bonjour à tous, je souhaiterais connaître les garanties proposées par la mutuelle pour les nouveaux-nés ?",
        opinion: 4,
        comment: 7,
        themes: ['enfant', 'garantie']
      },
      {
        question: "Bonjour, est-ce que la mutuelle propose des services de prévention pour les enfants, tels que des bilans de santé ou des vaccins ? Si oui, comment puis-je en bénéficier ?",
        opinion: 3,
        comment: 5,
        themes: ['enfant', 'prevention']
      },
      {
        question: "Bonjour, quels sont les coûts associés à l'ajout de mon enfant à ma mutuelle ? Est-ce que ces coûts sont pris en charge par ma mutuelle ou dois-je les payer moi-même ?",
        opinion: 10,
        comment: 12,
        themes: ['enfant', 'ajout', 'coût']
      }
    ]
  }

  private _getContents() {
    this.contentService.getContents().subscribe((contents) => {
      this.contents = contents
    })
  }

}
