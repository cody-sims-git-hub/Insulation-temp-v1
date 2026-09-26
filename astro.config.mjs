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
  // where the site is actually served: the insulation-demo portfolio subdomain
  // on Cloudflare (wrangler.jsonc). Repoint both if it moves to its own domain.
  site: 'https://insulation-demo.simsdigitalpartners.com',
  output: 'static',
  // Hide the Astro dev toolbar (the floating pill in dev).
  devToolbar: { enabled: false },
  integrations: [react(), sitemap()],
  vite: {
    plugins: [tailwindcss()],
  },
});
