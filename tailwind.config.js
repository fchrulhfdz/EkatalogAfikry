/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'afikry': {
                    primary: '#3B82F6',
                    secondary: '#1E40AF',
                }
            }
        },
    },
    plugins: [],
}