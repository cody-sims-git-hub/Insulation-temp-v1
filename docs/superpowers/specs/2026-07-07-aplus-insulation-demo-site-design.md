# A Plus Insulation — Demo Website Design Spec

- **Date:** 2026-07-07
- **Status:** Approved (design), pending spec review
- **Repo:** `aplusinsulation`
- **Branch:** `feat/demo-site`
- **Type:** SDP client demo (cold-outreach target)

---

## 1. Purpose

Build a polished, professional demo WordPress website for **A Plus Insulation, LLC** — a
real insulation contractor in Marianna, FL — to use as a cold-outreach pitch. The demo must
feel like *their* site (grounded in real business details) and show a clear, premium step up
from their current Facebook/Instagram-only presence. On a "yes," this same build deploys to
Hostinger with no re-architecture.

This build follows the SDP starter-kit rails: it is scaffolded from
`sdp-starter-kit/templates/wordpress-cms` and re-skinned via design tokens. It does **not**
copy any other client demo (osaka-hibachi, bo-barbershop).

## 2. Business profile (real data)

Sourced from Yelp, BBB, HomeAdvisor, and the client's social profiles (2026-07-07).

| Field | Value |
|---|---|
| Name | A Plus Insulation, LLC |
| Established | 2006 (~20 years; "over 14 years of experience" per HomeAdvisor) |
| Address | 5319 Hwy 90, Marianna, FL 32446 |
| Phone (marketing) | (850) 209-2636 |
| Hours | Mon–Fri 8:00 AM – 5:00 PM; Sat–Sun closed |
| Service area | Marianna + Jackson County / NW Florida Panhandle (Sneads, Graceville, Chipley, Alford, Bonifay, Chipola region) |
| Tagline (from their photos) | "No job too big or too small!" |
| Payment | Cash, credit cards, cryptocurrency; ASL proficient; free estimates |

**Services (Yelp-verified):**
- **Install** — attic, ceiling, interior/exterior/foundation walls, floor, crawlspace, garage, roof, basement
- **Types** — spray foam, batt & roll, blown-in / loose-fill, radiant barrier, reflective / foil
- **Removal** and **Replacement**

**Data caveats (confirm before launch, not blocking for demo):**
- Directories list conflicting addresses (5319 Hwy 90 [Yelp/BBB] vs 4654 Hwy 90 [MapQuest] vs
  4372 Pooser Rd [HomeAdvisor]). Using the Yelp/BBB address; flag for client confirmation.
- BBB lists a second phone (850) 526-2622. Using (850) 209-2636 as the primary marketing number.
- One IG caption says "Southwest Florida" — this is incorrect (Marianna is the NW Panhandle);
  we use NW Florida / Jackson County.

## 3. Goals & success criteria

- A homeowner landing on the site can, within seconds, understand what A Plus does, that they're
  local and established (2006), and how to get a **free estimate** (call or form).
- Primary conversion actions visible on every page: **call (850) 209-2636** and **Request a Free Estimate**.
- Reads as professional, trustworthy, and *engineered* — appropriate to a building-science trade.
- All 5 pages render correctly, mobile-first, with valid `LocalBusiness` schema.
- Runs locally end-to-end with `docker compose up` + `bin/seed.sh`.

## 4. Scope

**In scope:** 5-page marketing site (Home, Services, About, Service Area, Contact); real seeded
content; custom eco/Swiss theme; quote form with demo-only success state; local SEO + schema;
local Docker run.

**Out of scope (this build):** live form email/CRM delivery (wired later via n8n → Command
Center), production deployment to Hostinger, real photography (placeholders used), blog/content
marketing, online booking/payments, multi-language.

## 5. Tech stack & architecture

Base scaffold copied from `sdp-starter-kit/templates/wordpress-cms`, with these changes:

- **Theme** renamed `sdp-starter` → **`aplus-insulation`** (style.css header, docker-compose
  volume mounts, `wp theme activate` in seed).
- **Database:** override the template default `mariadb:11` → **`mysql:8`** (swap image,
  `MARIADB_*` → `MYSQL_*` env vars, healthcheck → `mysqladmin ping`). Mirrors the Hostinger
  production target.
- **Port:** WordPress on **8090** (avoids colliding with other local demos on 8081).
- **Runtime:** `wordpress:php8.3-apache`, `wordpress:cli-php8.3`, `mysql:8`.
- **Theme build:** classic PHP theme + **Tailwind CSS v4** (`@tailwindcss/cli`) + **Alpine.js 3**
  + **esbuild**, compiled to `theme/dist/`.
- **Plugins (seeded):** Advanced Custom Fields (content fields) + Rank Math (SEO, sitemaps, schema).

Scripts (`bin/`): `setup.sh` (bring stack up + install WP), `seed.sh` (create pages, menu,
CPT content, Site Settings with real A Plus data), `build.sh` (compile assets).

## 6. Design system

**Direction:** **Swiss / International Typographic** (from `engineering/design/landscape/visual-styles.md`),
warmed with an eco palette. Rationale: insulation is building engineering (R-values, air-sealing,
measured energy performance); Swiss grid discipline + type-as-structure communicates competence
and trust. Genuinely new for the portfolio (barbershop/restaurant are Boutique/Warm; starter is
Soft Modern) — satisfies the rotation rule in `theming-playbook.md`.

**Accent pattern:** a **Bento-grid** services / "why-us" section (landscape-approved accent for
local-business services grids).

**Tokens** (set in `theme/src/app.css` `@theme` block — the whole re-skin lives here):

| Role | Value |
|---|---|
| Primary | Deep pine / forest green |
| Background / surfaces | Warm oat / sand neutrals |
| Ink | Charcoal |
| Accent (CTAs) | Warm clay / honey (pops against green + sand) |
| Display type | IBM Plex Sans |
| Text type | IBM Plex Sans |
| Mono (stats / R-values) | IBM Plex Mono |
| Radius | Sharp / small (Swiss) |
| Motion | Minimal, calm (template's built-in scroll-reveal) |

The **foundations bar** (`engineering/design/foundations.md`) governs: WCAG contrast holds
(clay accent on green/sand verified), real type scale, keyboard focus states, reduced-motion honored.

**Components:** sticky header with click-to-call, hero, trust/stat tiles (Plex Mono numerals),
Bento service grid with icons, energy-savings feature block, testimonial cards, service-area
chips, CTA band, quote form, footer with NAP + hours.

## 7. Sitemap & page content

Primary nav: Home · Services · About · Service Area · Contact. Persistent header CTA (call + estimate).

1. **Home** (`front-page.php`, long-scroll)
   - Hero: comfort / energy-savings headline + "Free Estimate" CTA + phone
   - Trust bar: Established 2006 · Licensed & Insured · Free Estimates · "No job too big or too small"
   - Services grid (Bento): spray foam, blown-in, batt & roll, radiant barrier, removal/replacement
   - "Why insulation matters" energy-savings feature (Panhandle summer cooling-cost angle)
   - Service-area strip (Marianna + Jackson County towns)
   - Testimonials
   - CTA band → estimate
   - Footer: NAP, hours, map
2. **Services** — all offerings grouped by type, each with where-it's-used (attic, walls,
   crawlspace, floor, garage, roof) and a short benefit line.
3. **About** — established 2006, local family-run story, "no job too big or too small," licensed
   & insured, service commitment, payment/accessibility notes.
4. **Service Area** — Marianna + Jackson County / NW Panhandle town list, map embed, "not sure if
   we reach you? call" CTA.
5. **Contact** — quote request form (name, phone, email, service, message), click-to-call,
   address, hours, map. Form shows a success state; no live delivery this build.

## 8. Content model

Reuse the scaffold's existing CPTs and ACF fields, seeded with real data:

- **`sitesettings`** (single record): tagline, intro, CTA label, phone + `phone_href`, email,
  address, maps URL, social links, per-day hours — populated with A Plus data.
- **`service`**: one entry per service type (spray foam, blown-in, batt & roll, radiant barrier,
  removal, replacement) — title, summary, icon, application areas.
- **`testimonial`**: a few representative reviews.
- **`team`**: omit or minimize (small owner-operator business) — decide during build; default to
  omitting from nav.

All real business constants (NAP, hours) live in the `sitesettings` record so they're edited in
one place.

## 9. SEO

- Rank Math active; per-page titles + meta descriptions targeting local intent, e.g.
  "Spray Foam Insulation in Marianna, FL", "Attic Insulation — Jackson County".
- `LocalBusiness` (Insulation Contractor) JSON-LD with real NAP, geo, hours, service area.
- Semantic headings, descriptive alt text on placeholders, clean permalinks, mobile-first.
- Target Lighthouse SEO 100 / strong performance (static-ish theme, minified assets).

## 10. Verification (definition of done for the build)

1. `docker compose up -d` brings up mysql:8 + wordpress + cli healthy.
2. `bin/setup.sh` installs WP; `bin/seed.sh` runs clean and idempotently.
3. All 5 pages load at `http://localhost:8090` with correct nav, content, and CTAs.
4. Header/footer show real NAP; phone is click-to-call; quote form submits to a success state.
5. `LocalBusiness` JSON-LD present and valid; titles/meta set per page.
6. Mobile layout verified in a browser; no console errors; reduced-motion respected.

## 11. Later (post-approval, not this build)

- Wire the quote form to email / n8n → Command Center CRM.
- Deploy to Hostinger (WordPress-on-Hostinger playbook); DB stays on Hostinger per hosting standard.
- Real photography, Google Business Profile alignment, review widgets, blog for topical SEO.

## 12. Open assumptions

- Address = 5319 Hwy 90 (Yelp/BBB) until client confirms.
- Owner name / team not shown unless provided.
- Placeholder imagery until the client supplies real job photos.
