import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";
import {Content, PostContent} from "../models/content";
import {Theme} from "../models/theme";

@Injectable({
  providedIn: 'root'
})
export class ContentService {

  constructor(private http: HttpClient) { }

  postContent(content: PostContent): Observable<Content> {
    return this.http.post<Content>('https://localhost/contents', content, {
      headers: {
        'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2ODAyNTk3NTAsImV4cCI6MTY4MDM0NjE1MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoidXNlckB1c2VyLmZyIn0.X1Bn4AejpXR2H2H1h0jvQhZgmLPmO30LYL1oiu6q8e57EHuaI97tkZFy2DvwyVALEUzIgGuwlGjaL95m3FoZ6LpAp2i6DyFSFpmyXiBK7Eydbi-kRIddwqfeCHzjsTj9AomRDDC-DBi7yIN9TyStjcyg5cTdZj7LWr2J1SUPHBQC7KpKVTJUEZwFndoyAS1SWaDLRRf0dVDlSfBOkmTpWmbsplzsrC7Z4z4e8MhW8lN403K5XMdet6FLZejmjVwYgnEe8QvbFf3tcCNNsFeErKg9Avw0OsWKCfwDh-SODfZDks-5kOChBfdePop45TA59JJYpUJvOgV4fE8BvGDNcw'
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
}
