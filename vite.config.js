import { defineConfig, loadEnv } from "vite";
import vituum from "vituum";
import eslint from "vite-plugin-eslint";
import fetch from "node-fetch";

export default defineConfig(async ({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    let contributors = [];
    try {
        const res = await fetch(
            `https://api.github.com/repos/${env.VITE_GITHUB_REPO}/collaborators`,
            {
                headers: {
                    Authorization: `token ${env.VITE_GITHUB_TOKEN}`,
                    Accept: "application/vnd.github.v3+json",
                }
            }
        );
        contributors = await res.json();
        console.log("Contributors:", contributors);
    } catch (_e) {
        console.error("Erreur GitHub API:", _e);
        contributors = [];
    }

    return {
        base: "./",
        plugins: [
            vituum({
                pages: {
                    dir: "./src",
                    root: "./",
                    normalizeBasePath: true
                },
            }),
            eslint({
                include: "./src/**/*.js",
                failOnError: false,
            }),
        ],
        build: {
            target: "esnext",
            rollupOptions: {
                input: ["src/index.html"],
            },
        },
        define: {
            "import.meta.env.VERSION": JSON.stringify(
                process.env.npm_package_version
            ),
            "__CONTRIBUTORS__": JSON.stringify(contributors),
        },
        server: {
            host: true,
            open: true,
            proxy: {
                '/tyradex-proxy': {
                    target: 'https://tyradex.app',
                    changeOrigin: true,
                    rewrite: (path) => path.replace(/^\/tyradex-proxy/, ''),
                }
            }
        },
        test: {
            exclude: [
                "**/node_modules/**",
                "**/dist/**",
                "**/cypress/**",
                "**/worklets/**",
                "**/.{idea,git,cache,output,temp}/**",
                "**/e2e/**",
            ],
            environment: 'happy-dom',
            css: false,
            setupFiles: ['./tests/setup.js'],
            reporters: ['html'],
            outputFile: './vitest-report/index.html'
        },
    };
});