// @ts-check
import { defineConfig } from 'astro/config';
import react from '@astrojs/react';
import sitemap from '@astrojs/sitemap';
import tailwindcss from '@tailwindcss/vite';

// Static-first per the "static pages unless it requires a db" directive.
// WordPress is the headless content source; pages render at build time.
// The one dynamic path (lead capture) posts to an endpoint, not a rendered page.
export default defineConfig({
  // `site` drives canonical + Open Graph / share previews, so it must match
  // where the site is actually served. It currently lives on the aplus preview
  // subdomain; repoint this when it goes live on its own domain.
  site: 'https://aplus.simsdigitalpartners.com',
  output: 'static',
  // Hide the Astro dev toolbar (the floating pill in dev).
  devToolbar: { enabled: false },
  integrations: [react(), sitemap()],
  vite: {
    plugins: [tailwindcss()],
  },
});
