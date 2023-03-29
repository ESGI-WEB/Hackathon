import {Component, OnDestroy, OnInit} from '@angular/core';
import {AbstractControl, FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {ThemeService} from "../../../app/services/theme.service";
import {Observable, Subscription} from "rxjs";
import {Theme} from "../../../app/models/theme";

@Component({
  selector: 'app-main',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {
  public form?: FormGroup;
  public loading = true;
  public themes: Theme[] = [];

  constructor(private themeService: ThemeService) { }

  ngOnInit(): void {
    this.themeService.getThemes().subscribe({
      next: (data: any) => {
        this.themes = data['hydra:member'];
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
    })
  }

  asFormControl(control: any): FormControl {
    return control as FormControl;
  }
}
