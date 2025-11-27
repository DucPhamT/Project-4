import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: 'blog_cms.duc', // domain bạn dùng
        port: 5173,
        hmr: {
            host: 'blog_cms.duc', // domain bạn dùng
        },
    },
});
