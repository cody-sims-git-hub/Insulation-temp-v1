# A Plus Insulation — website

Static, brand-forward lead-generation site for **A Plus Insulation** (Marianna, FL).
Built with **Astro + Tailwind v4**, deployed static; WordPress is intended as the
headless content source (content currently lives in `src/data/site.ts`, which is
the seam to swap for WP REST/GraphQL reads at build time).

## Stack

- **Astro** (static output) + **React islands** for the FAQ accordion, before/after
  slider, quote form, and mobile nav.
- **Tailwind v4** (CSS-first tokens in `src/styles/global.css`).
- **Fonts:** Bebas Neue (display), Inter (body) — via Fontsource.
- **Icons:** Lucide. **Components:** shadcn-style (Radix accordion).

## Brand

Real A Plus Insulation identity: **green + yellow + black**, elevated. Logo art in
`public/photos/logo-wide.png` (auto-trimmed from `logo.jpg`).

## Develop

```bash
npm install
npm run dev      # http://localhost:4321
npm run build    # -> dist/
npm run preview
```

## Content

Everything customer-facing (copy, NAP, services, FAQ, service area, SEO titles/meta)
is in `src/data/site.ts`. SEO carried over from the prior build's 2026-07-07 keyword
plan; LocalBusiness + FAQPage JSON-LD emitted from `src/layouts/Base.astro`.

## Lead capture

The quote form POSTs to `PUBLIC_LEAD_ENDPOINT` (a Cloudflare Worker / form endpoint)
when set; otherwise it fails gracefully to a call-us prompt. This is the only
dynamic ("requires a db") path — everything else is static.
