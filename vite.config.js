import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");
    const envViteServerPort = parseInt(env.VITE_SERVER_PORT || "5175", 10);
    const envViteServerHmrPort = parseInt(env.VITE_SERVER_HMR_PORT || "5175", 10);
    return {
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
            host: '0.0.0.0',
            port: envViteServerPort,
            strictPort: true,
            hmr: {
                host: env.VITE_SERVER_HMR_HOST || "127.0.0.1",
                clientPort: envViteServerHmrPort,
            },
            watch: {
                usePolling: true,
                ignored: ['**/vendor/**', '**/node_modules/**'],
            },
        },
    };
});
