/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class', // This is our star player for the dark mode!
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./node_modules/preline/dist/*.js",
    "./node_modules/tw-elements/js/**/*.js"
  ],
  theme: {
    extend: {
      zIndex: {
        '100000': '100000',
      },
      screens: {
        xs: '320px', // Replace '320px' with your desired breakpoint value
      },
    },
    keyframes: {
        'fade-in-left': {
            '0%': { opacity: 0, transform: 'translateX(-20px)' },
            '100%': { opacity: 1, transform: 'translateX(0)' }
        },
        'fade-in-down': {
          '0%': { opacity: 0, transform: 'translateY(-20px)' }, // เริ่มต้น: จาง และ เลื่อนขึ้น
          '100%': { opacity: 1, transform: 'translateY(0)' } // จบ: ชัด และอยู่ตำแหน่งเดิม
        }
    },
    animation: {
    'fade-in-left': 'fade-in-left 0.2s ease-out',
    'fade-in-down': 'fade-in-down 0.3s ease-out', // ตั้งค่า Animation 0.3 วินาที
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('preline/plugin'),
    require('tw-elements/plugin.cjs'),
    require('tailwind-scrollbar')
  ],
}

