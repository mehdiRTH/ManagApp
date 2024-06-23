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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                'stroke':'#094067',
                'main':'#fffffe',
                'primary':'#3da9fc',
                'secondary':'#90b4ce',
                'tertiary':'#ef4565',
                'paragraph':'#5f6c7b',
                'danger':'#EF4444',
                'success':'#22c55e',
                'info':'#f97316'
            }
        },
    },

    plugins: [forms],
};
