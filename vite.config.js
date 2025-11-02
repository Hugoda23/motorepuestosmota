import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    // ⚙️ Servidor local (para npm run dev)
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: { host: 'localhost' },
        watch: { usePolling: true },
    },

    plugins: [
        laravel({
            // Archivos de entrada (todo lo que quieres compilar)
            input: [
                // Principales
                'resources/css/app.css',
                'resources/js/app.js',

                // Públicos
                'resources/css/public.css',

                // Administrativos
                'resources/css/admin.css',
                'resources/js/admin.js',

                // JS base
                'resources/js/bootstrap.js',

                 // SECCIÓN PROMOCIONES
                'resources/css/public/promociones.css',
                'resources/js/public/promociones.js',
            ],
            refresh: true,
        }),
    ],

    // ⚒️ Compilación en carpetas separadas
    build: {
        outDir: 'public/build', 
        manifest: true,
        emptyOutDir: true,

        rollupOptions: {
            output: {
                // Generar archivos separados en css/ y js/
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
