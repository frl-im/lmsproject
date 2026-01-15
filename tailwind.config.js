import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/**/*.html',
        './app/View/Components/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Kita ganti font bawaan jadi Nunito yang lebih bulat
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Palet Warna Gamifikasi Kita
                'game-primary': '#4A90E2',   // Biru Utama
                'game-secondary': '#F5A623', // Kuning/Emas
                'game-success': '#7ED321',   // Hijau XP
                'game-bg': '#F4F8FC',        // Background
                'game-card': '#FFFFFF',      // Putih Kartu
            }
        },
    },

    plugins: [forms],
};