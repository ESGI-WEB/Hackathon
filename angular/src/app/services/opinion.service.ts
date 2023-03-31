import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Content, PostContent} from "../models/content";
import {AuthService} from "./auth.service";
import {Opinion, PostOpinion} from "../models/opinion";

@Injectable({
  providedIn: 'root'
})
export class OpinionService {

  constructor(private http: HttpClient, private authService: AuthService) { }

  postOpinion(opinion: PostOpinion): Observable<Opinion> {
    return this.http.post<Opinion>('https://localhost/opinions', opinion, {
      headers: {
        'Authorization': 'Bearer ' + this.authService.getToken()
      }
    });
  }
}
