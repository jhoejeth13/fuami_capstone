import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/sweetalert2.js',
                'resources/css/sweetalert2.css'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~sweetalert2': 'node_modules/sweetalert2/dist/sweetalert2.js',
            '~sweetalert2-css': 'node_modules/sweetalert2/dist/sweetalert2.min.css'
        }
    }
});
