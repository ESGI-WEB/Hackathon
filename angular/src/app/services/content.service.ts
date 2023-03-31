import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";
import {Content, PostContent} from "../models/content";

export interface SearchContent {
  name: string;
  status: Array<string>;
  themes: Array<string>;
}

@Injectable({
  providedIn: 'root'
})
export class ContentService {

  constructor(private http: HttpClient) { }

  postContent(content: PostContent): Observable<Content> {
    return this.http.post<Content>('https://localhost/contents', content, {
      headers: {
        'Authorization': 'Bearer TODO'
      }
    });
  }

  getContents(): Observable<Content[]> {
    return this.http.get<Content[]>('https://localhost/contents').pipe(
      map((response: any) => {
        return response['hydra:member'];
      })
    );
  }

  getContent(id: number): Observable<Content> {
    return this.http.get<Content>(`https://localhost/contents/${id}`);
  }

  searchContents(search: SearchContent): Observable<Content[]> {
    return this.http.post<Content[]>('https://localhost/contents/search', search)
  }
}
