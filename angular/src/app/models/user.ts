export interface User {
  id: number;
  firstname: string;
  lastname: string;
  email: string;
  roles: string[];
  password: string;
  opinions: string[];
  token : string;
}
