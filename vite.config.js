import { defineConfig } from "vite";
import { fileURLToPath, URL } from "node:url";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { glob } from "glob";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                "resources/css/app.css",
                ...glob.sync("resources/js/pages/**/*.js"),
            ],
            refresh: true,
        })
    ],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./resources", import.meta.url))
        }
    }
});
