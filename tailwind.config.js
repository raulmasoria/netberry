/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

module.exports = {
  content: ["./resources/**/*.blade.php",
  "./resources/**/*.js",
  "./resources/**/*.vue",],
  theme: {
    extend: {},
    colors: {
      red: '#dc2626',
      gray: colors.gray,
    },
  },
  plugins: [],
}

