import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: { host: 'localhost' },
        watch: { usePolling: true },
    },

    plugins: [
        laravel({
            input: [
                // Principales
                'resources/css/app.css',
                'resources/js/app.js',

                // Públicos
                'resources/css/public.css',
                'resources/css/public/destacados.css',
                'resources/js/public/destacados.js',

                // Administrativos
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/admin/roles.css',
                'resources/js/admin/roles.js',

                // JS base
                'resources/js/bootstrap.js',

                // SECCIÓN PROMOCIONES
                'resources/css/public/promociones.css',
                'resources/js/public/promociones.js',
            ],
            refresh: true,
        }),
    ],

    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true,

        rollupOptions: {
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        return 'css/[name].[ext]';
                    }
                    return 'assets/[name].[ext]';
                },
            },
        },
    },
});
