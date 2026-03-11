import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                burgundy: {
                    DEFAULT: '#8F161C',
                    dark: '#5E0F14',
                    soft: '#C56A6E',
                },
                gold: '#E5C68D',
                ivory: '#F6F2EA',
                charcoal: '#2B2B2B',
                navy: '#1F2A44',
                archgray: '#D9D9D9',
            },
        },
    },

    plugins: [forms],
};
