/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.js',
	],
	theme: {
		extend: {
			colors: {
				primary: '#C5502C',
				secondary: '#F6EFE7',
				dark: '#1A1A1A',
				accent: '#8C3B28',
			},
			fontFamily: {
				display: ['"Playfair Display"', 'serif'],
				body: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
			},
			letterSpacing: {
				tighter: '-0.02em',
				wider: '0.06em',
			},
			boxShadow: {
				soft: '0 10px 30px -10px rgba(0,0,0,0.2)',
			}
		},
	},
	plugins: [],
}


