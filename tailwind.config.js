/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    // PENTING: v4 lebih suka 'selector' daripada 'class'
    darkMode: "selector",
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "sans-serif"],
            },
            colors: {
                primary: "#4F46E5",
                secondary: "#64748B",
            },
        },
    },
    plugins: [],
};
