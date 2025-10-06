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
                primary: "#30abe8",
                "background-light": "#f6f7f8",
                "background-dark": "#0D1A21",
                "primary": "#8B5CF6",
                "secondary": "#EC4899",
                "accent": "#34D399",
                "text-light": "#111827",
                "text-dark": "#9FB3C8", 
                "card-light": "#ffffff",
                "card-dark": "#172A3A",
                "border-dark": "#2A4454",
                "pastel-pink": "#fde4e4",
                "pastel-blue": "#daeaf6",
                "pastel-green": "#e4f6e9",                
            },
            fontFamily: {
                sans: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                DEFAULT: "0.75rem",
                lg: "1rem",
                xl: "1.5rem",
                full: "9999px"
            },
            keyframes: {
                'fade-in-up': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(20px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                },
                'slow-pulse': {
                    '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                    '50%': { transform: 'scale(1.03)', opacity: '0.95' }
                },
                'blob-move-1': {
                    '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                    '25%': { transform: 'translate(20px, -30px) scale(1.1)'},
                    '50%': { transform: 'translate(-10px, 15px) scale(0.9)'},
                    '75%': { transform: 'translate(15px, 25px) scale(1.05)'}
                },
                'blob-move-2': {
                    '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                    '25%': { transform: 'translate(-15px, 25px) scale(0.95)'},
                    '50%': { transform: 'translate(25px, -10px) scale(1.1)'},
                    '75%': { transform: 'translate(-20px, -20px) scale(1)'}
                }
            },
            animation: {
                'fade-in-up': 'fade-in-up 1s ease-out forwards',
                'slow-pulse': 'slow-pulse 4s ease-in-out infinite',
                'blob-1': 'blob-move-1 20s ease-in-out infinite',
                'blob-2': 'blob-move-2 25s ease-in-out infinite alternate'                
            }
        },
    },

    plugins: [forms],
};
