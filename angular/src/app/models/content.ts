import {Theme} from "./theme";
import {Media} from "./media";

export interface Content {
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'rejected';
  media: Media[];
  likes: string[];
  opinions: string[];
  author: string;
  themes: Theme[];
}

export interface PostContent {
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'rejected';
  author: string;
  themes: string[];
}
