# A Plus Insulation — Redesign Spec: "Trades Workhorse"

- **Date:** 2026-07-07
- **Status:** Approved
- **Repo:** `aplusinsulation`
- **Branch:** `feat/redesign` (off `feat/demo-site`)
- **Supersedes:** visual + content sections of `2026-07-07-aplus-insulation-demo-site-design.md`.
  Business profile (§2), tech stack (§5), content model (§8), and verification rails (§10) of the
  original spec remain in force unless amended below.

---

## 1. Why this revision

The first build shipped clean but thin: short sections, two-line service cards, no persuasive
depth. A homeowner comparing quotes gets nothing to build confidence on — no process, no FAQs,
no money talk, no proof. Competitor research (2026-07-07) confirms the market opening:

- **Insulation 4 All** (NC): ~150 words of body copy, template artifacts in production.
- **Winston-Salem Spray Foam** (NC): rank-and-rent template; Mississippi photos, `noindex`, typos.
- **Blue Line Insulation** (Panama City — the real Panhandle competitor): strongest site, but a
  cloned GoHighLevel template with leftover Texas content, a borrowed Lowe's YouTube video, and
  thin inland coverage (Marianna/Jackson County is an open lane).

**No competitor covers:** honest pricing ranges, financing, energy-savings math, before/after
outcomes. Those plus provable local authenticity are the differentiators of this redesign.

**Factual guardrail:** the federal 25C Energy Efficient Home Improvement Credit was terminated
for property placed in service after 2025-12-31. Do **not** build tax-credit content. Verify any
Florida utility rebate claims at build time before publishing them; omit if unverifiable.

## 2. Visual direction — Warmed-up Flat ("Trades Workhorse")

From `sdp-starter-kit/engineering/design/landscape/visual-styles.md`: Flat is the catalog's
blessed local-business baseline ("clarity and speed"), with the warning that it goes generic
unless type carries the personality. So type does the heavy lifting.

Rotation rule (theming-playbook): direction changes (Swiss → Flat) and type pairing changes
(IBM Plex → Archivo/Public Sans) = 2 of 3. Palette may stay in the green family.

**Tokens** (all in `theme/src/app.css` `@theme`; no raw values outside it):

| Role | Value |
|---|---|
| Display type | Archivo (Expanded/Black, caps, tight tracking) — section headers, stats, hero |
| Body type | Public Sans |
| Background | Warm paper off-white |
| Ink | Charcoal |
| Primary blocks | Deep pine green (solid section bands) |
| Accent | Safety amber (truck-livery nod) — CTAs, key numerals, marker underlines ONLY |
| Depth | Flat 2.0: solid fills, hard 2px borders, no gradients/shadows |
| Radius | Small |
| Motion | Minimal, calm; reduced-motion honored |

**Signature moves:** condensed-caps headers with amber marker underline; big Archivo numerals
for stats; photos in solid-bordered frames; alternating paper/green/charcoal section bands;
flat geometric icons.

**Foundations bar** (`engineering/design/foundations.md`) unchanged and gating: AA contrast
(body ≥ 4.5:1), focus-visible states, one h1/page, token-scale type only, 44px tap targets,
mobile-first at 360/768/1024/1440, Lighthouse ≥ 90 all categories on production build.

## 3. Content architecture — same 5 pages, ~3× depth

Copy standards for every page (from `engineering/seo/content-quality.md`):
people-first, original and specific to A Plus, every claim sourced or attributed to the
business, no invented review counts/stats, real NAP everywhere, no generic filler.
Savings claims cite ENERGY STAR (~15% avg heating/cooling savings from air sealing +
insulation). R-value guidance uses FL Climate Zone 2 targets (attic R-38 as the anchor).

### Home (`front-page.php`, long-scroll)
1. **Hero** — real crew/truck photo; condensed-caps headline; trust chips (Est. 2006 ·
   Licensed & Insured · Free Estimates); dual CTA (call + Free Estimate).
2. **Stat band** — big amber numerals on charcoal: 20 yrs in business · ~15% avg cooling-bill
   savings (ENERGY STAR) · R-38 FL attic target · Free estimates.
3. **Problem section** — "Why Panhandle power bills run high": heat + humidity framing,
   under-insulated attic as the culprit, what sealing + insulating changes.
4. **Services blocks** — 6 solid-fill blocks → anchored sections on Services page.
5. **4-step process** — Call/request → free attic assessment → install day (what to expect) →
   what you'll notice (comfort, bills).
6. **Money section** — honest cost-range teaser table by method + financing framing
   ("spread the cost" language; no fake lender claims). No tax-credit content (§1).
7. **Real jobs gallery** — existing Facebook photos with town labels.
8. **Reviews** — the seeded real testimonials.
9. **Service-area strip** — towns + "not sure? call."
10. **FAQ** — 8 questions (cost, best insulation for FL humidity, savings, how long install
    takes, removal, spray foam safety, licensing, service area) with FAQPage JSON-LD.
11. **CTA band** + footer (unchanged NAP/hours model).

### Services (`page-services.php`)
- Intro + sticky/jump anchor nav chips.
- **One full section per service** (spray foam, blown-in, batt & roll, radiant barrier,
  removal, replacement): what it is → best-for applications (attic/walls/crawlspace/garage/
  roof) → R-value guidance for Zone 2 → honest tradeoffs → typical cost range → 2-question
  mini-FAQ → section CTA.
- Where-we-insulate matrix; process recap; CTA band.

### About (`page-about.php`) — the E-E-A-T page
2006 origin story, family-run framing, licensed & insured, "no job too big or too small,"
service commitment, payment options + ASL proficiency, real photos. No fabricated owner
names/bios — attribute to "the A Plus crew/family" until the client provides names.

### Service Area (`page-service-area.php`)
Every real town named (Marianna, Sneads, Graceville, Chipley, Alford, Bonifay, Cottondale,
Grand Ridge, Malone, Cypress + Jackson County framing), map embed, drive-time framing,
"not sure if we reach you? call" CTA. No spun per-town pages.

### Contact (`page-contact.php`)
Form (name, phone, email, service, message; demo success state) + full NAP/hours + map +
**"what happens after you submit"** expectations strip (we call back within one business day →
free assessment → written estimate).

## 4. SEO plan

1. **Keyword planning first** — run the `keyword-planning` global skill (free-tools workflow)
   for Home, Services (per service section), About, Service Area, Contact before writing final
   copy; titles/H1s/meta written from the resulting plan.
2. Rank Math stays installed-but-deactivated per the earlier decision; theme `inc/seo.php`
   baseline provides titles/meta (per-page fields).
3. Structured data: existing `LocalBusiness` JSON-LD (keep) + **FAQPage** JSON-LD on Home
   (and Services mini-FAQs if marked up); validate with Rich Results Test.
4. One h1 per page; heading hierarchy from the token scale; descriptive alt text on all photos
   (real towns/jobs where known).

## 5. Out of scope (unchanged from original)

Live form delivery, Hostinger deploy, per-town pages, blog, booking/payments, video content.

## 6. Verification (definition of done)

1. `docker compose up -d` + `bin/setup.sh` + `bin/seed.sh` run clean and idempotently.
2. All 5 pages render the new design at `http://localhost:8090`; screenshots captured
   desktop + mobile.
3. No IBM Plex / old Swiss tokens remain; all styling flows from the new `@theme` block.
4. FAQPage + LocalBusiness JSON-LD present and valid; per-page titles/meta from keyword plan.
5. Contrast spot-checks pass AA (amber-on-charcoal and amber-on-green combos verified).
6. No console errors; reduced-motion honored; mobile layout verified at 360px.
7. Every factual claim in the copy traces to the business profile, ENERGY STAR, or FL Climate
   Zone 2 guidance; zero tax-credit references.
