import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#2563EB',
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#1D4ED8',
                    800: '#1E40AF',
                    900: '#1E3A8A',
                },
                secondary: {
                    DEFAULT: '#3B82F6',
                },
                accent: {
                    DEFAULT: '#06B6D4',
                },
                success: {
                    DEFAULT: '#22C55E',
                    50: '#F0FDF4',
                    100: '#DCFCE7',
                    500: '#22C55E',
                    600: '#16A34A',
                    700: '#15803D',
                },
                warning: {
                    DEFAULT: '#F59E0B',
                    50: '#FFFBEB',
                    100: '#FEF3C7',
                    500: '#F59E0B',
                    600: '#D97706',
                    700: '#B45309',
                },
                danger: {
                    DEFAULT: '#EF4444',
                    50: '#FEF2F2',
                    100: '#FEE2E2',
                    500: '#EF4444',
                    600: '#DC2626',
                    700: '#B91C1C',
                },
                surface: {
                    DEFAULT: '#F8FAFC',
                    dark: '#0F172A',
                },
                card: {
                    DEFAULT: '#FFFFFF',
                    dark: '#1E293B',
                },
                sidebar: {
                    DEFAULT: '#FFFFFF',
                    dark: '#1E293B',
                },
                navbar: {
                    DEFAULT: '#FFFFFF',
                    dark: '#1E293B',
                },
                hover: {
                    DEFAULT: '#EFF6FF',
                    dark: '#334155',
                },
                border: {
                    DEFAULT: '#E2E8F0',
                    dark: '#334155',
                },
                text: {
                    heading: '#0F172A',
                    body: '#334155',
                    muted: '#64748B',
                    disabled: '#94A3B8',
                }
            },
            boxShadow: {
                soft: '0 4px 20px -2px rgba(15, 23, 42, 0.05)',
                card: '0 8px 30px -4px rgba(15, 23, 42, 0.06)',
                elevated: '0 20px 40px -8px rgba(15, 23, 42, 0.08)',
                glow: '0 0 15px rgba(37, 99, 235, 0.5)',
            },
            borderRadius: {
                'button': '14px',
                'input': '16px',
                'card': '20px',
                'modal': '24px',
            },
            transitionDuration: {
                DEFAULT: '250ms',
                hover: '150ms',
                click: '120ms',
                card: '250ms',
                modal: '300ms',
                page: '350ms',
            },
            transitionTimingFunction: {
                DEFAULT: 'cubic-bezier(0.4, 0, 0.2, 1)',
                'ease-out': 'cubic-bezier(0, 0, 0.2, 1)',
                'ease-in-out': 'cubic-bezier(0.4, 0, 0.2, 1)',
                'spring': 'cubic-bezier(0.175, 0.885, 0.32, 1.275)',
            },
            keyframes: {
                blob: {
                    '0%': { transform: 'translate(0px, 0px) scale(1)' },
                    '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                    '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                    '100%': { transform: 'translate(0px, 0px) scale(1)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                shake: {
                    '0%, 100%': { transform: 'translateX(0)' },
                    '10%, 30%, 50%, 70%, 90%': { transform: 'translateX(-4px)' },
                    '20%, 40%, 60%, 80%': { transform: 'translateX(4px)' },
                }
            },
            animation: {
                'blob': 'blob 7s infinite',
                'marquee': 'marquee 25s linear infinite',
                'float': 'float 3s ease-in-out infinite',
                'shake': 'shake 0.5s cubic-bezier(.36,.07,.19,.97) both',
                'spin-slow': 'spin 3s linear infinite',
            }
        },
    },

    plugins: [forms, flowbite],
};
