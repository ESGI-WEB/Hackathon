import {Theme} from "./theme";

export interface Content {
  id: number;
  name: string;
  status: string;
  media: string;
  likes: string[];
  opinions: string[];
  author: string;
  themes: Theme[];
  description: string;
}
