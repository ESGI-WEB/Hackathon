export interface Opinion {
  id: number;
  author: string;
  text: string;
  createdAt: string;
  likes: string[];
  content: string;
}

export interface PostOpinion {
  // author: string;
  text: string;
  // createdAt: string;
  content: number;
}
