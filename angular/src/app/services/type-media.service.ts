import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";
import {Typemedia} from "../models/typemedia";

@Injectable({
  providedIn: 'root'
})
export class TypeMediaService {

  constructor(private http: HttpClient) {
  }

  getTypeMedias(): Observable<Typemedia[]> {
    return this.http.get<Typemedia[]>('https://localhost/type_media').pipe(
      map((response: any) => {
        return response['hydra:member'];
      })
    );
  }
}
