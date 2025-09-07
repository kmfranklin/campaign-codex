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
        host: 'campaign-codex.local',
        port: 5173,
        cors: true,
        hmr: {
            host: 'campaign-codex.local',
        },
    },
});
