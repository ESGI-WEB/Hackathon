export interface User {
  id: number;
  firstName: string;
  lastName: string;
  email: string;
  roles: string[];
  password: string;
  opinions: string[];
  token : string;
}
