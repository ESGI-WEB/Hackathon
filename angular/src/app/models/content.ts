import {Theme} from "./theme";
import {Media} from "./media";

export interface Content {
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'refused';
  media: Media[];
  likes: string[];
  opinions: string[];
  author: string;
  themes: Theme[];
}

export interface PostContent {
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'refused';
  author: string;
  themes: string[];
}
