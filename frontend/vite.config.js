import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  // Relative base so the build works under the GitHub Pages sub-path.
  base: './',
  build: {
    outDir: '../docs/wedding-guest-test',
    // emptyOutDir wipes outDir on every build; never point it at ../docs itself.
    emptyOutDir: true,
  },
})
