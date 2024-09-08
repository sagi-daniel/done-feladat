/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    fontFamily: {
      custom: ['Montserrat', 'sans-serif'],
    },
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      'primary': '#1a1a1a',
      'secondary': '#f1f1f1',
      'action': '#f63900',
      'action-h': '#c32d00',
      'action-d': '#ff5b2a',
      'btn-t': '#ffffff',

      'cancel': '#d9d9d9',
      'text-cancel': '#7e7e7e',
      'delete': '#f60000',
      'text-delete': '#ffffff',

      'input-disabled': '#d9d9d9',
      'input-text-disabled': '#7e7e7e',
    },
    extend: {},
  },
  plugins: [],
}
