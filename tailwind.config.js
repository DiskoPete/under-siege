const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
      './resources/views/**/*.blade.php'
  ],
  theme: {
    extend: {
        colors: {
            primary: {
                500: '#ff7f11'
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
