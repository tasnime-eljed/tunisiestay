/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./src/Twig/**/*.php",
  ],
  safelist: [
    'from-[#1E3A5F]',
    'to-[#2E86AB]',
    'bg-[#1E3A5F]',
    'bg-[#2E86AB]',
    'text-[#1E3A5F]',
    'text-[#2E86AB]',
    'border-[#2E86AB]',
    'ring-[#2E86AB]',
  ],
  theme: {
    extend: {
      colors: {
        primary:   '#1E3A5F',
        secondary: '#2E86AB',
        accent:    '#F0A500',
      },
    },
  },
  plugins: [],
}