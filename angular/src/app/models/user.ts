export interface User {
  id: number;
  email: string;
  roles: string[];
  password: string;
  opinions: string[];
  token : string;
}
