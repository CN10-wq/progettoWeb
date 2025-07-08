import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        

    ],

    theme: {
        extend: {
            fontFamily: {
                testo: ['Lora', 'serif'],
                corsivo: ['Parisienne', 'cursive'],
                titolo: ['Lobster', 'cursive'],
                tit: ['Playfair Display', 'serif'],
                cor: ['Cookie', 'cursive'],
                corpo: ['Mulish', 'sans-serif'], 
                elegante: ['Cormorant Garamond', 'serif'], 
                sans: ['DM Sans', 'sans-serif'], 
                citazione: ['Italianno', 'cursive'],
            },

            colors: {
                'sfondo': '#2b2b2b',
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: 0, transform: 'translateY(20px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                  },
                  'arrow-slide': {
                        '0%, 100%': { transform: 'translateX(0)' },
                        '50%': { transform: 'translateX(6px)' },
                    },
            },
            animation: {
                'fade-in-up': 'fade-in-up 1.5s ease-out both',
                'arrow-slide': 'arrow-slide 1.2s ease-in-out infinite',
            }
        },

    },

    plugins: [forms, typography],
};
