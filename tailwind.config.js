import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const institutionalBlue = {
    50: '#F2F6FC',
    100: '#E4ECF8',
    200: '#C4D4EE',
    300: '#94B2DF',
    400: '#5B88CC',
    500: '#3565B1',
    600: '#234B91',
    700: '#12377B',
    800: '#122F65',
    900: '#112951',
    950: '#0A1934',
};

const institutionalGold = {
    50: '#FFFAE7',
    100: '#FFF2BC',
    200: '#FFE580',
    300: '#FBD14A',
    400: '#F2BC20',
    500: '#E6AD09',
    600: '#BB8103',
    700: '#955D07',
    800: '#7A490D',
    900: '#673D10',
    950: '#3C2003',
};

const institutionalGreen = {
    50: '#EFFAF3',
    100: '#D9F3E2',
    200: '#B6E6C8',
    300: '#84D2A3',
    400: '#4AB675',
    500: '#219854',
    600: '#0C8F3D',
    700: '#0B6B31',
    800: '#0B552A',
    900: '#094624',
    950: '#042713',
};

const institutionalRed = {
    50: '#FFF2F0',
    100: '#FFE1DD',
    200: '#FFC7C0',
    300: '#FFA096',
    400: '#F96B5D',
    500: '#EA4335',
    600: '#D8261A',
    700: '#AE1D14',
    800: '#901C15',
    900: '#781D18',
    950: '#410B08',
};

const institutionalGray = {
    50: '#F8F8F7',
    100: '#F1F1EF',
    200: '#E3E2DF',
    300: '#CAC8C4',
    400: '#9D9A97',
    500: '#716E6C',
    600: '#565251',
    700: '#454142',
    800: '#373435',
    900: '#2A2728',
    950: '#1E1A17',
};

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                institutional: ['Trajan Pro', 'Cinzel', 'Georgia', 'serif'],
            },
            colors: {
                unt: institutionalBlue,
                blue: institutionalBlue,
                indigo: institutionalBlue,
                purple: institutionalBlue,
                cyan: institutionalBlue,
                teal: institutionalBlue,
                gold: institutionalGold,
                yellow: institutionalGold,
                amber: institutionalGold,
                orange: institutionalGold,
                green: institutionalGreen,
                emerald: institutionalGreen,
                red: institutionalRed,
                gray: institutionalGray,
                slate: institutionalGray,
            },
            boxShadow: {
                panel: '0 1px 2px rgb(30 26 23 / 0.04), 0 10px 28px rgb(18 55 123 / 0.06)',
                raised: '0 14px 36px rgb(18 55 123 / 0.12)',
            },
            borderRadius: {
                '2.5xl': '1.25rem',
            },
        },
    },

    plugins: [
        forms
    ],
};
