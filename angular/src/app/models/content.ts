import {Theme} from "./theme";
import {Media} from "./media";
import {User} from "./user";
import {Opinion} from "./opinion";

export interface Content {
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'rejected';
  media: Media[];
  likes: string[];
  opinions: Opinion[];
  author: User;
  themes: Theme[];
}

export interface PostContent {
  name: string;
  description: string;
  themes: string[];
}
