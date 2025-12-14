/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/views/**/*.{html,js}',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/cleopatra/views/**/*.html',
    './resources/cleopatra/js/**/*.js',
  ],
  theme: {
    screens: {
      sm: { max: "639px" },

      md: { max: "767px" },

      lg: { max: "1023px" },

      xl: { max: "1279px" },
    },
    extend: {
            // SALIN KONFIGURASI TEMA DARI tailwind.config.js CLEOPATRA DI SINI
            colors: {
                'dark': '#202942',
                'primary': '#606c88',
                'secondary': '#36405c',
                'info': '#4a60da',
                'success': '#38c172',
                'warning': '#f6993f',
                'danger': '#e3342f',
                'light': '#dae1e7',
                'bg-gray': '#f2f5f9'
            },
            fontFamily: {
                sans: [
                    'Nunito',
                    // ... font lainnya
                ],
            },
        },
  },
  plugins: [],
};
