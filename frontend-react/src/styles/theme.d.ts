import 'styled-components';

declare module 'styled-components' {
  export interface DefaultTheme {
    boxShadow: {
      sm: string;
      md: string;
      lg: string;
      focus: string;
    },
    colors: {
      bgColor: string,
      textColor: string,
      textPlaceholderColor: string,
      bgInput: string,
      linkColor: string,
      accentColor: string,
      primaryButton: string,
      secondaryButton: string,
      chips: {
        inProgress: {
          backgroundColor: string,
          color: string,
        },
        completed: {
          backgroundColor: string,
          color: string,
        },
        empty: {
          backgroundColor: string;
          color: string;
        }
      }
    },
  }
}
