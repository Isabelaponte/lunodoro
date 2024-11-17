import { create } from "zustand";

interface User {
  id: number;
  name: string;
  email: string;
}

interface AuthState {
  token: string | null;
  user: User | null;
  setToken: (token: string | null) => void;
  setUser: (user: User | null) => void;
  isAuthenticated: () => boolean;
}

const useAuthStore = create<AuthState & { logout: () => void }>((set) => ({
  token: localStorage.getItem("token"),
  user: JSON.parse(localStorage.getItem("user") || "null"),
  setToken: (token: string | null) => {
    set({ token });
    if (token) {
      localStorage.setItem("token", token);
    } else {
      localStorage.removeItem("token");
    }
  },
  setUser: (user: User | null) => {
    set({ user });
    if (user) {
      localStorage.setItem("user", JSON.stringify(user));
    } else {
      localStorage.removeItem("user");
    }
  },
  isAuthenticated: () => !!localStorage.getItem("token"),
  logout: () => {
    set({ token: null, user: null });
    localStorage.removeItem("token");
    localStorage.removeItem("user");
  },
}));


export default useAuthStore;
