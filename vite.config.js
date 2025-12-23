import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css','resources/css/custom-sidebar.css', 'resources/css/hillholding.css'],
            refresh: true,
        }),
    ],
});
