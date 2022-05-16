const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
      './resources/views/**/*.blade.php'
  ],
  theme: {
    extend: {
        colors: {
            primary: {
                500: '#00afb9',
                600: '#008189',
            }
        },
        fontFamily: {
            sans: [
                'Inter',
                ...defaultTheme.fontFamily.sans
            ]
        }
    },
  },
  plugins: [],
}
