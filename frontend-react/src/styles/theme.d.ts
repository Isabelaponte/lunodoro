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
          bgInput: string,
          linkColor: string,
          accentColor: string,
          primaryButton: string,
          secondaryButton: string,
        },
      }
}
