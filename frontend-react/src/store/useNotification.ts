import { create } from "zustand";

export enum Severety {
    SUCCESS = 'success',
    WARNING = 'warning',
    ERROR = 'error',
}

interface Notification {
  message: string;
  severety: Severety;
}

interface NotificationState {
  notification: Notification | null;
  notify: (notification: Notification, duration?: number) => void;
}

export const useNotificationStore = create<NotificationState>((set) => ({
  notification: null,
  notify: (notification: Notification, duration = 5000) => {
    set({ notification });
    setTimeout(() => {
      set({ notification: null });
    }, duration);
  },
}));