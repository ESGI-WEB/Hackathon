import {Typemedia} from "./typemedia";

export interface Media {
  id: number;
  name: string;
  description: string;
  path: string;
  url: string;
  content: string;
  type: Typemedia;
}

export interface PostMedia {
  name: string;
  description: string;
  content: number;
  file: File;
}

