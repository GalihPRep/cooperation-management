import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5175,
        strictPort: true,
        hmr: {
            host: '127.0.0.1',
            port: 5175,
        },
        watch: {
            usePolling: true,
            ignored: ['**/vendor/**', '**/node_modules/**'],
        },
    },
});
