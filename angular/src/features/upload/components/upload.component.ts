import {Component, OnInit} from '@angular/core';
import {AbstractControl, FormArray, FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {ThemeService} from "../../../app/services/theme.service";
import {zip} from "rxjs";
import {Theme} from "../../../app/models/theme";
import {TypeMediaService} from "../../../app/services/type-media.service";
import {Typemedia} from "../../../app/models/typemedia";

@Component({
  selector: 'app-main',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {
  public form?: FormGroup;
  public loading = true;
  public themes: Theme[] = [];
  public typeMedias: Typemedia[] = [];

  constructor(
    private themeService: ThemeService,
    private typeMediaService: TypeMediaService,
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
    })
  }

  addMedia(type: Typemedia) {
    const fb = new FormBuilder();
    const control = this.form?.get('medias') as FormArray;
    control.push(fb.group({
      type: type, // used to display the right upload component
      file: [null, []],
      name: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(100)]],
      description: ['', [Validators.required, Validators.minLength(5), Validators.maxLength(5000)]],
    }));
  }

  onFileSelected(event: any, control: AbstractControl) {
    const file: File = event.target?.files[0];

    if (file) {
      control.patchValue({file: file});
    }
  }

  mapMediaToIcon(type: Typemedia) {
    switch (type.slug) {
      case 'text':
        return 'text_fields';
      case 'image':
        return 'image';
      case 'video':
        return 'local_movies';
      case 'podcast':
        return 'mic';
      case 'file':
        return 'insert_drive_file';
      default:
        return 'add_circle';
    }
  }

  asFormControl(control: any): FormControl {
    return control as FormControl;
  }

  asFormArray(control: any): FormArray {
    return control as FormArray;
  }
}
