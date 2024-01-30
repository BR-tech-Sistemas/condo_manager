import {defineConfig, loadEnv} from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

const host = 'condo-manager.test'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [{
                paths: [
                    ...refreshPaths,
                    'resources/**',
                    'routes/**',
                    'app/**',
                    'config/**'
                ],
                config: {delay: 1000}
            }],
        }),
    ],
    server: {
        host: 'node',
        hmr: { host}
    },
});
