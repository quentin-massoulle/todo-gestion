import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',  // écoute toutes les interfaces réseau
        port: 5173,       // port par défaut de Vite
        strictPort: true, // ne change pas de port automatiquement
    },
});
