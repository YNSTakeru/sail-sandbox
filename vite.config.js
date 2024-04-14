import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/articles/create.js",
                "resources/js/home/index.js",
                "resources/js/show/index.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                app: "resources/css/app.css",
                index: "resources/js/home/index.js",
                create: "resources/js/articles/create.js",
                show_index: "resources/js/show/index.js",
            },
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`,
            },
        },
    },
});
