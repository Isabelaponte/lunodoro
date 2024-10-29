import { DefaultTheme } from 'styled-components';

const theme: DefaultTheme = {
  boxShadow: {
    sm: '0px 1px 2px rgba(0, 0, 0, 0.05)',
    md: '0px 4px 6px rgba(0, 0, 0, 0.1)',
    lg: '0px 10px 15px rgba(0, 0, 0, 0.1)',
    focus: '0px 0px 0px 2px #0CF'
  },
  colors: {
    bgColor: '#321c46',
    textColor: '#f5f5f5',
    textColorSecondary: '#321c46',
    textPlaceholderColor: '#6c757d',
    bgInput: '#d9d9d9',
    linkColor: '#633ce0',
    accentColor: '#633ce0',
    primaryButton: '#633ce0',
    secondaryButton: '#321c46',
    chips: {
      inProgress: {
        backgroundColor: '#e0c48f',
        color: '#974a02',
      },
      completed: {
        backgroundColor: '#95ea76',
        color: '#235d0e',
      },
      empty: {
        backgroundColor: '#d9d9d9',
        color: '#6c757d',
      }
    }
  },
};

export default theme;
