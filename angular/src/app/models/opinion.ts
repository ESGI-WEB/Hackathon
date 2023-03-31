import {User} from "./user";

export interface Opinion {
  id: number;
  author: User;
  text: string;
  createdAt: string;
  likes: string[];
  content: string;

}
