export interface Typemedia {
  name: string;
  extension: string[];
  media: string[];
  slug: string;
}
export function mapMediaToIcon(type: Typemedia) {
  switch (type.slug) {
    case 'text':
      return 'text_fields';
    case 'image':
      return 'image';
    case 'video':
      return 'movie';
    case 'podcast':
      return 'mic';
    case 'file':
      return 'insert_drive_file';
    default:
      return 'add_circle';
  }
}
