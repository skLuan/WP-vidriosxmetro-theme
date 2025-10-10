import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  root: './',
  build: {
    outDir: 'assets/build',
    manifest: true, // Generate manifest.json file (for caching)
    emptyOutDir: true, // Empty the dist folder before building
    rollupOptions: {
      input: 'src/main.js',
    },
  },
  plugins: [
    tailwindcss()
    ],
});