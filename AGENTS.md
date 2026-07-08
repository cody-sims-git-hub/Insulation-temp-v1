# AGENTS.md — WordPress CMS starter template

An **agnostic baseline** for building a client WordPress site where the design is
owned in code and the client edits **content only** — never layout. Copy this
folder, re-skin the tokens, swap the content, ship.

This is the reusable structure extracted from a real build (Black Oak Barbershop).
It is intentionally **style-neutral**: a clean, professional default you replace
with the client's brand.

> Policy note: **WordPress on Hostinger is SDP's default CMS for client content sites**
> (see [`../../engineering/architecture/architecture.md`](../../engineering/architecture/architecture.md#4-cms-policy) §4).
> It ships as a managed service with a maintenance retainer. **Statamic** remains the
> Laravel-coupled alternative. This template *is* that default.

## What you get

- `theme/` — **SDP Starter**, a classic PHP theme (Tailwind v4 + Alpine), built to
  `theme/dist/` with a throwaway Node container (no host Node needed).
- `docker-compose.yml` + `bin/` — a local WordPress harness (WordPress + MariaDB +
  wp-cli) and reproducible **setup/seed** scripts.

## Content model (all defined in code)

| Type | What the client edits | Where |
|------|----------------------|-------|
| **Blog** | Native posts | Posts |
| **Team** | name / role / photo / bio (CPT `team`) | `theme/inc/post-types.php` |
| **Services** | title / summary / price / highlight (CPT `service`) | same |
| **Testimonials** | author / role / rating / quote (CPT `testimonial`) | same |
| **Site Settings** | contact, hours, social, tagline (singleton `sitesettings`) | same |

Fields are ACF **local field groups** in `theme/inc/fields.php`. Ordering uses the
post "Order" attribute. The design has no page-builder; sections are theme code and
each hides itself when it has no content.

## Fields layer

Standardized on **ACF free** (or **SCF**, the WordPress.org fork — drop-in
compatible). `theme/inc/fields.php` + the `get_field()` reads in
`theme/inc/template-helpers.php` are the **only** places that know about the fields
plugin — swap them to move to **ACF Pro** (repeaters, galleries, options page) or
**Carbon Fields** (same, free, code-first) without touching templates.

## Run it locally (inside WSL, where Docker lives)

```bash
cd templates/wordpress-cms

# 1. build theme assets (Tailwind + Alpine → theme/dist)
bash bin/build.sh

# 2. start the stack, install WP, seed demo content
docker compose up -d
bash bin/setup.sh      # installs WP + activates the theme
bash bin/seed.sh       # ACF + neutral placeholder content

# → http://localhost:8081   admin: /wp-admin  (admin / admin)
```

Stop with `docker compose down` (add `-v` to wipe the database).

> The scripts call `docker compose exec` per wp-cli command with `</dev/null` so
> the exec doesn't swallow the script's own stdin. Run them from this folder.

## Re-skin for a client

**Start with the design bible** — [`../../engineering/design/`](../../engineering/design/design-foundations.md).
Pick a **style direction** from the [theming playbook](../../engineering/design/theming-playbook.md)
(deliberately different from recent clients), then express it through the theme's tokens.
This theme *is* the website implementation of those foundations: its `@theme` block is
the [token contract](../../engineering/design/tokens.md), its template-parts are the
[atomic organisms](../../engineering/design/atomic-method.md), and it must clear the
[quality bar](../../engineering/design/foundations.md) before shipping.

1. **Tokens** — edit the `@theme` block at the top of `theme/src/app.css` (colors,
   fonts, radius) and the font `<link>` in `theme/functions.php`. Rebuild.
2. **Content** — edit `bin/seed.sh` (or just enter real content in wp-admin).
3. **Sections** — add/remove/reorder sections in `theme/front-page.php`; add CPTs
   in `theme/inc/post-types.php` + fields in `theme/inc/fields.php`.
4. **Theme name** — rename in `theme/style.css` and the `sdp-starter` slug in
   `docker-compose.yml` if you want a client-specific slug.

## Baked-in hardening (every site inherits this)

Shipped in the theme so new client sites start clean against the [audit
tooling](../../engineering/seo/tooling.md):

- **Security headers** (`inc/security.php`) — `X-Content-Type-Options`,
  `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, and WP version hiding.
  **CSP and HSTS are intentionally left to the proxy/host** (Caddy/Hostinger) — set
  them there per client for defense in depth.
- **SEO head** (`inc/seo.php`) — a real meta description + Open Graph/Twitter on every
  page; steps aside if Rank Math/Yoast is active.
- **Accessibility** — real content text meets WCAG AA contrast; decorative placeholders
  are `aria-hidden`.
- **Performance** — font preconnect + `display=swap` to minimise layout shift (CLS).

Verify with a Lighthouse pass (`http://localhost:8081`) and a header check
(`curl -sI`) before handing a site over.

## Forms & spam protection

Every public form on an SDP site is abuse-protected with **Cloudflare Turnstile + a
honeypot field + rate limiting** — the standard in
[`../../engineering/security/security.md`](../../engineering/security/security.md).
Two ways to wire a form on a WordPress site:

- **Lead capture (standard)** — a form plugin (Fluent Forms or Contact Form 7) with its
  official **Cloudflare Turnstile** integration enabled + a honeypot, writing submissions
  **natively into the site's own co-located Hostinger DB**. A scheduled read-only n8n
  sync aggregates those leads into Command Center for reporting (see
  [`../../operations/automation.md`](../../operations/automation.md)) — no live POST to the
  platform.
- **Headless / Managed-App builds (exception)** — the form carries a Turnstile widget +
  honeypot and **POSTs to the platform's client-integration contract endpoint**, which
  verifies Turnstile server-side, enforces CORS + throttling, stores the submission in the
  client's VPS database, and sends a Resend confirmation. (This is the same flow shown in
  `sdp-docs` → `automations/contact-to-proposal.md`.) Use it for headless-WP or Managed-App
  builds, and for SDP's own marketing site.

The Turnstile **site key is public** (rendered in the page); the **secret key stays
server-side** (platform or plugin config) — **never** in this theme or the repo. Add
the widget wherever a client form lives; a bare form without Turnstile does not ship.

## Deploy

This is vanilla WordPress. Version-control **theme code only** — never content,
uploads, or the database. Install on Hostinger per
`../../operations/wordpress-hostinger.md`; the theme folder + ACF (free) is all that
ships. Content is entered in wp-admin. Attach a maintenance retainer.
