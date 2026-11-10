
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brown: {
          50: '#fdf8f3',
          100: '#f9ede0',
          200: '#f2d9c0',
          300: '#e8be96',
          400: '#dc9f6a',
          500: '#d4844a',
          600: '#c46b3a',
          700: '#a35230',
          800: '#85402b',
          900: '#6d3526',
          950: '#3d1a12',
        },
        brand: {
          50: '#F5F1E8',
          100: '#E8DDCE',
          200: '#D6C2A8',
          300: '#C4A47E',
          400: '#A98A62',
          500: '#8B6F47',
          600: '#6B4423',
          700: '#5A3920',
          800: '#4A2F1A',
          900: '#2C1810',
          light: '#8B6F47',
          DEFAULT: '#6B4423',
          dark: '#4A2F1A',
          darker: '#2C1810',
          cream: '#F5F1E8',
          gold: '#C9A961',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Playfair Display', 'serif'],
        serif: ['Playfair Display', 'Georgia', 'serif'],
      },
      backgroundImage: {
        'gradient-brown': 'linear-gradient(135deg, #6B4423 0%, #4A2F1A 50%, #2C1810 100%)',
        'gradient-brown-light': 'linear-gradient(135deg, #8B6F47 0%, #6B4423 100%)',
        'gradient-brown-gold': 'linear-gradient(135deg, #C9A961 0%, #8B6F47 100%)',
        'gradient-brown-vertical': 'linear-gradient(180deg, #6B4423 0%, #2C1810 100%)',
        bookshelf: "url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')",
      },
      boxShadow: {
        brown: '0 4px 6px -1px rgba(107, 68, 35, 0.1), 0 2px 4px -1px rgba(107, 68, 35, 0.06)',
        'brown-lg': '0 10px 15px -3px rgba(107, 68, 35, 0.15), 0 4px 6px -2px rgba(107, 68, 35, 0.05)',
        'brown-xl': '0 20px 25px -5px rgba(107, 68, 35, 0.2), 0 10px 10px -5px rgba(107, 68, 35, 0.04)',
        'brown-2xl': '0 25px 50px -12px rgba(44, 24, 16, 0.4)',
        'inner-brown': 'inset 0 2px 4px 0 rgba(107, 68, 35, 0.1)',
      },
      animation: {
        float: 'float 6s ease-in-out infinite',
        'fade-in': 'fadeIn 0.5s ease-out',
        'slide-up': 'slideUp 0.5s ease-out',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
    },
  },
  plugins: [],
}
