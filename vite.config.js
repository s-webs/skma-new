import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/filemanager.css',
                'resources/js/app.js',
                'resources/js/fmanager.js',
                'public/assets/js/plugins/slider.js',
                'vendor/s-webs/s-files/resources/js/filemanager.js',
            ],
            refresh: true,
        }),
    ],
});

