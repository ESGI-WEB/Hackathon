import {Component, OnInit} from '@angular/core';
import {
  AbstractControl,
  FormArray,
  FormBuilder,
  FormControl,
  FormGroup,
  ValidationErrors,
  ValidatorFn,
  Validators
} from "@angular/forms";
import {ThemeService} from "../../../app/services/theme.service";
import {Observable, zip} from "rxjs";
import {Theme} from "../../../app/models/theme";
import {TypeMediaService} from "../../../app/services/type-media.service";
import {mapMediaToIcon, Typemedia} from "../../../app/models/typemedia";
import {AngularEditorConfig} from "@kolkov/angular-editor/lib/config";
import {MatDialog} from "@angular/material/dialog";
import {UploadMenuComponent} from "./upload-menu.component";
import {Content, PostContent} from "../../../app/models/content";
import {Media, PostMedia} from "../../../app/models/media";
import {ContentService} from "../../../app/services/content.service";
import {MediaService} from "../../../app/services/media.service";

@Component({
  selector: 'app-main',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {
  public form?: FormGroup;
  public loading = true;
  public submitting = false;
  public themes: Theme[] = [];
  public typeMedias: Typemedia[] = [];
  public editorConfig: AngularEditorConfig = {
    editable: true,
    spellcheck: true,
    translate: 'yes',
    minHeight: '10rem',
    placeholder: 'Enter text here...',
    fonts: [
      {class: 'arial', name: 'Arial'},
      {class: 'times-new-roman', name: 'Times New Roman'},
      {class: 'calibri', name: 'Calibri'},
      {class: 'comic-sans-ms', name: 'Comic Sans MS'}
    ],
    toolbarHiddenButtons: [
      ['subscript', 'superscript'],
      ['fontSize','insertImage','insertVideo', 'insertHorizontalRule']
    ]
  }

  constructor(
    private themeService: ThemeService,
    private typeMediaService: TypeMediaService,
    private contentService: ContentService,
    private mediaService: MediaService,
    private dialog: MatDialog,
  ) {
  }

  ngOnInit(): void {
    zip(this.themeService.getThemes(), this.typeMediaService.getTypeMedias())
      .subscribe({
        next: ([themes, typeMedias]) => {
          this.themes = themes;
          this.typeMedias = typeMedias;
        },
        error: (error) => {
          console.log(error);
        },
        complete: () => {
          this.loading = false;
        }
      });
    this.loadForm();
  }

  loadForm() {
    const fb = new FormBuilder();

    this.form = fb.group({
      name: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(100)]],
      themes: [[], [Validators.required]],
      medias: fb.array([], [Validators.required]),
      description: ['', [Validators.required, Validators.minLength(100), Validators.maxLength(255)]],
    })
  }

  submit() {
    if (!this.form?.valid) {
      return;
    }

    this.submitting = true;

    const themeIds = this.form?.get('themes')?.value?.map((theme: Theme) => theme['@id']);
    const content: PostContent = {
      name: this.form?.get('name')?.value,
      description: this.form?.get('description')?.value,
      status: 'pending',
      author: '/users/5',
      themes: themeIds,
    }

    const medias: PostMedia[] = [];
    for (const media of this.form?.get('medias')?.value) {
      medias.push({
        name: media.name,
        description: media.description,
        content: 0,
        file: media.file,
      });
    }

    this.contentService.postContent(content)
      .subscribe({
        next: (content: Content) => {
          return this.submitMediasToContent(medias, content);
        },
        error: (error) => {
          console.log(error);
        }
      });
  }

  submitMediasToContent(medias: PostMedia[], content: Content) {
    const subMedias: Observable<Media>[] = [];
    medias.forEach((media: any) => {
      // set right content id
      media.content = content.id;

      // create form data (as we've used multipart/form-data on the api)
      const formData = new FormData();
      for (const key in media) {
        formData.append(key, media[key]);
      }

      subMedias.push(this.mediaService.postMedia(formData));
    });

    zip(...subMedias).subscribe({
      next: (medias: Media[]) => {
        console.log('done');
      }
    });
  }

  addMedia(type: Typemedia) {
    const fb = new FormBuilder();
    const control = this.form?.get('medias') as FormArray;
    control.push(fb.group({
      type: type, // used to display the right upload component
      file: [null, [fileValidator(type)]],
      name: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(100)]],
      description: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(10000)]],
    }));
  }

  deleteMedia(index: number) {
    const control = this.form?.get('medias') as FormArray;
    control.removeAt(index);
  }

  onFileSelected(event: any, control: AbstractControl) {
    const file: File = event.target?.files[0];

    if (file) {
      control.patchValue({file: file});
    }
  }

  openDialog(): void {
    this.dialog.open(UploadMenuComponent, {
      minWidth: '300px',
      data: {typeMedias: this.typeMedias}
    }).afterClosed().subscribe({
      next: (typeMedia: Typemedia) => {
        if (typeMedia) {
          this.addMedia(typeMedia);
        }
      }
    });
  }

  mapMediaToIcon(type: Typemedia) {
    return mapMediaToIcon(type);
  }

  asFormControl(control: any): FormControl {
    return control as FormControl;
  }

  asFormArray(control: any): FormArray {
    return control as FormArray;
  }
}

export function fileValidator(type: Typemedia): ValidatorFn {
  return (control: AbstractControl): ValidationErrors | null => {
    const value = control.value;

    if (!value && type.slug !== 'text') {
      return {fileRequired: true};
    }

    return null;
  }
}