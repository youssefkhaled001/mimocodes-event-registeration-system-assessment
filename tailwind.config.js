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
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                borderAnimation: {
                    '0%': { borderBottom: '2px solid transparent' },
                    '100%': { borderBottom: '2px solid #06b6d4' },
                },
            },
            animation: {
                'fade-in-up': 'fadeIn 0.5s ease-out forwards',
                'border-animation': 'borderAnimation 0.5s ease-in-out forwards',
            },
        },
    },

    plugins: [forms],
};
