export interface Content {
  id: number;
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'refused';
  media: string[];
  likes: string[];
  opinions: string[];
  author: string;
  themes: string[];
}

export interface PostContent {
  name: string;
  description: string;
  status: 'pending' | 'validated' | 'refused';
  author: string;
  themes: string[];
}
