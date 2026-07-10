// @ts-check
import { defineConfig } from 'astro/config';
import react from '@astrojs/react';
import sitemap from '@astrojs/sitemap';
import tailwindcss from '@tailwindcss/vite';

// Static-first per the "static pages unless it requires a db" directive.
// WordPress is the headless content source; pages render at build time.
// The one dynamic path (lead capture) posts to an endpoint, not a rendered page.
export default defineConfig({
  site: 'https://aplusinsulationllc.com',
  output: 'static',
  // Hide the Astro dev toolbar (the floating pill in dev).
  devToolbar: { enabled: false },
  integrations: [react(), sitemap()],
  vite: {
    plugins: [tailwindcss()],
  },
});
