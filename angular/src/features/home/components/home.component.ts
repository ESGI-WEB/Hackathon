import {Component, OnInit, ViewEncapsulation} from '@angular/core';
import {ContentService} from "../../../app/services/content.service";
import {Content} from "../../../app/models/content";
import {FormBuilder, FormControl} from "@angular/forms";
import {ThemeService} from "../../../app/services/theme.service";
import {map} from "rxjs";
import {Router} from "@angular/router";

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

  private static readonly STATUS_VALIDATED = "validated";
  private static readonly THEME_NAISSANCE = "Naissance";

  searchControl = new FormControl();

  public questions: Array<Question>
  public contents: Array<Content>
  public naissanceThemeId: string

  constructor(
    private formBuilder: FormBuilder,
    private contentService: ContentService,
    private themeService: ThemeService,
    private router: Router
  ) {
    this.questions = [];
    this.contents = [];
    this.naissanceThemeId = '';
  }

  ngOnInit(): void {
    this._getNaissanceTheme()
    this._setQuestions()
  }

  private _setQuestions(): void {
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

  private _getContents(themeId: string): void {
    const searchObject = {
      name: "",
      status: [HomeComponent.STATUS_VALIDATED],
      themes: [themeId]
    }
    this.contentService.searchContents(searchObject).subscribe((contents) => {
      this.contents = contents
    })
  }

  public onSubmit(): void {
    const searchObject = {
      name: this.searchControl.value,
      status: [HomeComponent.STATUS_VALIDATED],
      themes: [this.naissanceThemeId]
    }
    this.contentService.searchContents(searchObject).subscribe((contents) => {
      this.contents = contents
    })
  }

  private _getNaissanceTheme(): void {
    this.themeService.getThemes()
      .pipe(
        map((themes) => themes.filter((theme) => theme.name === HomeComponent.THEME_NAISSANCE)),
      )
      .subscribe((theme) => {
        this.naissanceThemeId = theme[0].id.toString()
        this._getContents(this.naissanceThemeId)
      })
  }

  public openNaissancePage(): void {
    this.router.navigate(['theme']);
  }

}
