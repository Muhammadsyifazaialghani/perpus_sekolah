import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
    content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
            keyframes: {
              fadeIn: {
                '0%': { 
                    opacity: '0',
                    transform: 'translateY(15px)' 
                },
                '100%': { 
                    opacity: '1',
                    transform: 'translateY(0)'
                },
              }
            },
            animation: {
              fadeIn: 'fadeIn 0.8s ease-out forwards',
            }
        },
    },
    plugins: [forms, typography],
}