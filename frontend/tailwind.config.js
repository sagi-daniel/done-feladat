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
      primary: 'var(--primary)',
      secondary: 'var(--light-grey)',
      action: 'var(--action)',
    },
    extend: {
      transitionProperty: {
        width: 'width',
      },
      width: {
        hovered: 'calc(100% - 2px)',
      },
    },
  },
  variants: {
    extend: {
      width: ['hover'],
    },
  },
  plugins: [],
}
