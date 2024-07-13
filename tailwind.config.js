import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        // './vendor/laravel/jetstream/**/*.blade.php',
        // './storage/framework/views/*.php',
        './resources/js/Pages/*.vue',
        './resources/js/**/*.vue',
        // './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                sm: '1rem',
                base: '1.200rem',
                xl: '1.500rem',
                '2xl': '1.800rem',
                '3xl': '2.300rem',
                '4xl': '2.800rem',
                '5xl': '3.300rem',
            }
        },
    },

    plugins: [forms, typography],
};
