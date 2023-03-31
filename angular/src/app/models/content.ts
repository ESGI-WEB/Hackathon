import {Theme} from "./theme";
import {Media} from "./media";
import {User} from "./user";

export interface Content {
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'rejected';
  media: Media[];
  likes: string[];
  opinions: string[];
  author: User;
  themes: Theme[];
}

export interface PostContent {
  name: string;
  description: string;
  themes: string[];
}
