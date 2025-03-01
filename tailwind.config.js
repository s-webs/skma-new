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
            colors: {
                custom: {
                    dark: '#1E1E1E',
                    halftone: '#F5EFFF',
                    main: '#853BFF',
                    secondary: '#9392B6',
                    primary: '#EADDFF',
                    heading: '#11111B',
                },
                primary: {
                    main: '#302C76',
                    secondary: '#64649A',
                    light: '#C3C1D6',
                }
            },
            fontFamily: {
                'openSans': ['Open Sans', 'sans-serif'],
            },
            transitionProperty: {
                'width': 'width',
                'opacity': 'opacity',
            },
        },
    },

    plugins: [forms],
};
