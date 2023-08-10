import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                shadowbold: [
                    "0px 2px 4px rgba(0, 0, 0, 0.4)",
                    "0px 7px 13px -3px rgba(0, 0, 0, 0.3)",
                    "0px -3px 0px inset rgba(0, 0, 0, 0.2)",
                ],
            },
        },
    },

    plugins: [forms],
};
