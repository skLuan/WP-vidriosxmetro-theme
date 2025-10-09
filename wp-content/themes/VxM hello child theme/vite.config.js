import { defineConfig } from 'vite';

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
    {
      name: 'php',
      handleHotUpdate({ file, server }) {
        if (file.endsWith('.php')) {
          server.ws.send({ type: 'full-reload' });
        }
      },
    },
  ],
});