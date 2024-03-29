/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',  // support toggling dark mode manually
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      width: {
        '4.5': '1.125rem',
        '128': '32rem',
        '144': '36rem',
      },
      height: {
        '112': '28rem',
        '128': '32rem',
        '144': '36rem',
      },
      screens: {
        '3xl': {'min': '1980px'}
      },
    },
  },
  plugins: [],
}

// screens: {
//   'sm': '640px',
//   // => @media (min-width: 640px) { ... }

//   'md': '768px',
//   // => @media (min-width: 768px) { ... }

//   'lg': '1024px',
//   // => @media (min-width: 1024px) { ... }

//   'xl': '1280px',
//   // => @media (min-width: 1280px) { ... }

//   '2xl': '1536px',
//   // => @media (min-width: 1536px) { ... }