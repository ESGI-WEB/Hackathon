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

export function hasModeratorRole(roles: string[]): boolean {
  return roles.includes('ROLE_ADMIN') || roles.includes('ROLE_MODERATOR');
}
