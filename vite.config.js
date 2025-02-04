import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/admin/products.js',
                'resources/js/admin/image-actions.js',
                'resources/js/payments/paypal.js'
            ],
            refresh: true,
        }),
    ],
});
