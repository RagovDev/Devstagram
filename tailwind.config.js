/** @type {import('tailwindcss').Config} */
export default {
  // asignamos recursivamente las rutas de los archivos donde se debe configurar el uso de tailwind
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

