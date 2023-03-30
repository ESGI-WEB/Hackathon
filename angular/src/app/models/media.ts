export interface Media {
  id: number;
  name: string;
  description: string;
  path: string;
  content: string;
  type: string;
}

export interface PostMedia {
  name: string;
  description: string;
  content: number;
  file: File;
}

