/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
    './node_modules/tw-elements/dist/js/**/*.js'
  ],
  theme: {
    extend: {
      animation: {
        'spin-slow': 'spin 5s linear infinite',
      },
      fontFamily: {
        'kalam': ['Kalam', 'Roboto', 'sans-serif']
      },
    }
  },
  plugins: [
    require('tw-elements/dist/plugin')
  ],
}
