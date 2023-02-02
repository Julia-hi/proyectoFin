import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/scripts/of-lista.js',
        ]),
        /* laravel({ <---- original code
            input: [
                'resources/css/app.css',
                'resources/css/calendar.css',
                'resources/js/app.js',
                'resources/js/of-lista.js',
            ],
            refresh: true,
        }), */
    ],
});
