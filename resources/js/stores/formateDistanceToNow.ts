// utils/formatDate.ts
import { formatDistanceToNow } from 'date-fns';

// Function to format the date
export function formatDate(timestamp: string): string {
  const date = new Date(timestamp);
  return formatDistanceToNow(date, { addSuffix: true });
}