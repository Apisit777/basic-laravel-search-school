/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class', // This is our star player for the dark mode!
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./node_modules/preline/dist/*.js",
    "./node_modules/tw-elements/js/**/*.js"
  ],
  theme: {
    extend: {
      zIndex: {
        '100000': '100000',
      },
      screens: {
        xs: '320px', // Replace '320px' with your desired breakpoint value
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('preline/plugin'),
    require('tw-elements/plugin.cjs'),
    require('tailwind-scrollbar')
  ],
}

