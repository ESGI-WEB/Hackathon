import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Content, PostContent} from "../models/content";
import {Media, PostMedia} from "../models/media";

@Injectable({
  providedIn: 'root'
})
export class MediaService {

  constructor(private http: HttpClient) { }

  postMedia(data: FormData): Observable<Media> {
    return this.http.post<Media>('https://localhost/media', data);
  }
}
