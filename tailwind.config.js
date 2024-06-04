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
      }
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('preline/plugin'),
    require("tw-elements/plugin.cjs")
  ],
}

