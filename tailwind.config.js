import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#e8ecf4',
                    100: '#c5cee3',
                    200: '#9eadd0',
                    300: '#778cbd',
                    400: '#5973ae',
                    500: '#3b5a9f',
                    600: '#2d4a7a',
                    700: '#1f3a5f',
                    800: '#1b2a4a',
                    900: '#0f1b35',
                    950: '#0a1225',
                },
                mustard: {
                    50: '#fef9e7',
                    100: '#fdf0c2',
                    200: '#fbe28a',
                    300: '#f7d04d',
                    400: '#f0c040',
                    500: '#d4a017',
                    600: '#b8860b',
                    700: '#9a6f09',
                    800: '#7d5a0b',
                    900: '#674a0f',
                    950: '#3b2905',
                },
            },
            borderWidth: {
                3: '3px',
            },
        },
    },

    plugins: [forms],
};
