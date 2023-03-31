import {Theme} from "./theme";
import {Media} from "./media";
import {Opinion} from "./opinion";

export interface Content {
  '@id': number;
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'rejected';
  media: Media[];
  likes: string[];
  opinions: Opinion[];
  author: string;
  themes: Theme[];
}

export interface PostContent {
  name: string;
  description: string;
  themes: string[];
}
