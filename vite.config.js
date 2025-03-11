import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/app.jsx'
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js', 
        },
    },
    server: {
        port: process.env.MODE === 'testing' ? 5174 : 5173, 
    },
    build: {
        outDir: 'public/build', 
        manifest: true, 
        chunkSizeWarningLimit: 500, 
    },
});
