import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";
import {Theme} from "../models/theme";

@Injectable({
  providedIn: 'root'
})
export class ThemeService {

  constructor(private http: HttpClient) { }

  getThemes(): Observable<Theme[]> {
    return this.http.get<Theme[]>('https://localhost/themes').pipe(
      map((response: any) => {
        return response['hydra:member'];
      })
    );
  }
}
