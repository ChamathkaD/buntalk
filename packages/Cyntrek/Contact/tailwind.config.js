/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],
    plugins: [
        require('@tailwindcss/forms'),
    ],
    safelist: [
        {
            pattern: /icon-/,
        }
    ]
};
