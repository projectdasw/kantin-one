import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Global
                'resources/css/app.css',
                'resources/js/app.js',

                // Pages
                // --------------------------------------
                // Login
                'resources/js/pages/auth/login.js',

                // Customer
                'resources/js/customer/cart-order.js',
                'resources/js/customer/order-tracking.js',
                'resources/js/customer/products-order.js',
                'resources/js/customer/tenant-order.js',
                
                // Tenant
                'resources/js/pages/tenants/tenants.js',

                // Canteens
                'resources/js/pages/tenants/canteens.js',

                // Buildings
                'resources/js/pages/buildings/buildings.js',

                // Tables
                'resources/js/pages/tables/tables.js',

                // Products
                'resources/js/pages/products/products.js',
                
                // Tenants
                'resources/js/pages/tenants/tenants.js',

                // Users
                'resources/js/pages/users/users.js',
                'resources/js/pages/users/crud.js',
                'resources/js/pages/users/trash.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
