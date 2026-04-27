// tailwind.config.js
import PrimeUI from 'tailwindcss-primeui';

export default {
    darkMode: ['selector', '[class~="dark-mode"]'],           //dark mode configuration
    plugins: [PrimeUI]
};
