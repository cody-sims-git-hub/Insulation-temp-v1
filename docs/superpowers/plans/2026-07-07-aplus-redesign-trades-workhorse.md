# A Plus Insulation Redesign — "Trades Workhorse" Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Re-skin the A Plus Insulation demo to the Warmed-up Flat "Trades Workhorse" direction and triple the content depth per the approved spec (`docs/superpowers/specs/2026-07-07-aplus-redesign-trades-workhorse-design.md`).

**Architecture:** Classic PHP WordPress theme (`theme/`), Tailwind v4 tokens in `theme/src/app.css` `@theme` block, Alpine.js, content seeded by `bin/seed.sh`. Templates own layout AND marketing copy (existing pattern); CMS holds NAP/services/testimonials. All visual identity flows from the token block; all new deep content is hardcoded in templates with copy given verbatim in this plan.

**Tech Stack:** WordPress php8.3-apache + mysql:8 via docker compose (port 8090), Tailwind CSS v4 CLI + esbuild (`bin/build.sh` → `theme/dist/`), WP-CLI container for seeding.

## Global Constraints

- Branch: `feat/redesign`. Commit after every task. Never touch `main`.
- Fonts: exactly two families — **Archivo** (display, incl. weight 900) and **Public Sans** (body). IBM Plex must be fully gone.
- Palette roles: paper `#faf7f0` bg · charcoal `#20241f` ink · pine `#245032` solid bands · safety amber `#f7a800` accent (CTAs, numerals, marker underlines ONLY). Flat 2.0: solid fills, **2px borders, zero box-shadows, zero gradients**.
- Copy rules (spec §3): every claim traces to the business profile, ENERGY STAR (~15% avg heating/cooling savings), or FL code (attic R-30–R-38, R-38 anchor). **Zero tax-credit references.** No invented owner names, review counts, or lender partnerships.
- SEO: titles/meta/H1s in this plan are from the 2026-07-07 keyword plan — use them verbatim. One `h1` per page.
- A11y: AA contrast, `:focus-visible` preserved, reduced-motion block preserved, 44px tap targets, alt text on all images.
- Build after every template/CSS change: `bash bin/build.sh` (regenerates `theme/dist/`). Site runs at `http://localhost:8090` (`docker compose up -d`, `bash bin/setup.sh`, `bash bin/seed.sh`).

---

### Task 1: Design tokens + fonts

**Files:**
- Modify: `theme/src/app.css` (full rewrite of `@theme` + `@layer components`)
- Modify: `theme/functions.php:31-61` (font enqueue + preconnect)

**Interfaces — Produces (classes every later task uses):**
`.eyebrow` (Archivo caps, amber), `.stat` (Archivo 900 numerals), `.btn`, `.btn-primary` (amber bg / charcoal ink), `.btn-ghost` (2px ink border), `.btn-onaccent` (paper bg, for dark bands), `.card` (flat: 2px line border, no shadow/hover-lift), `.marker::after` (amber underline block for section headings), `.prose-sdp`, `[data-reveal]` unchanged.

- [ ] **Step 1: Replace the `@theme` and components layers in `theme/src/app.css`:**

```css
@theme {
	--font-sans: 'Public Sans', ui-sans-serif, system-ui, sans-serif;
	--font-display: 'Archivo', ui-sans-serif, system-ui, sans-serif;

	--color-bg: #faf7f0;          /* warm paper */
	--color-surface: #f1ecdf;
	--color-surface-2: #e8e1cf;
	--color-ink: #20241f;         /* charcoal */
	--color-muted: #575e53;
	--color-line: #d9d2c0;

	--color-accent: #245032;      /* pine green — solid section bands */
	--color-accent-hover: #1c4028;
	--color-accent-ink: #f6f3ea;

	--color-cta: #f7a800;         /* safety amber — actions & key numerals only */
	--color-cta-hover: #e29700;
	--color-cta-ink: #20241f;     /* dark-on-amber: AA for large text & buttons */

	--radius: 0.125rem;
	--ease-out-cubic: cubic-bezier(0.22, 1, 0.36, 1);
}
```

Base layer: keep html/body/::selection/:focus-visible rules; change heading rule to
`h1,h2,h3,h4 { font-family: var(--font-display); font-weight: 800; line-height: 1.02; letter-spacing: -0.01em; }`.
Components layer (replaces Swiss versions — flat 2.0, no shadows/lifts):

```css
.eyebrow { font-family: var(--font-display); font-size: 0.78rem; font-weight: 700;
	letter-spacing: 0.14em; text-transform: uppercase; color: var(--color-accent); }
.stat { font-family: var(--font-display); font-weight: 900; letter-spacing: -0.02em;
	font-variant-numeric: tabular-nums; }
.marker::after { content: ''; display: block; width: 3.5rem; height: 0.4rem;
	margin-top: 0.9rem; background: var(--color-cta); }
.btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
	padding: 0.85rem 1.7rem; border-radius: var(--radius); font-family: var(--font-display);
	font-weight: 700; font-size: 0.95rem; letter-spacing: 0.01em;
	transition: background-color 0.15s var(--ease-out-cubic), border-color 0.15s var(--ease-out-cubic); }
.btn-primary { background: var(--color-cta); color: var(--color-cta-ink); }
.btn-primary:hover { background: var(--color-cta-hover); }
.btn-ghost { border: 2px solid var(--color-ink); color: var(--color-ink); }
.btn-ghost:hover { background: var(--color-ink); color: var(--color-bg); }
.btn-onaccent { background: var(--color-bg); color: var(--color-ink); }
.btn-onaccent:hover { background: var(--color-surface-2); }
.card { background: var(--color-bg); border: 2px solid var(--color-line); border-radius: var(--radius); }
```

Keep `.prose-sdp` (update link color to accent — unchanged value role) and the `[data-reveal]` + reduced-motion blocks verbatim.

- [ ] **Step 2: Swap fonts in `theme/functions.php`** — replace the Google Fonts URL with
`https://fonts.googleapis.com/css2?family=Archivo:wght@500;700;800;900&family=Public+Sans:wght@400;500;600;700&display=swap` (preconnect hints stay).

- [ ] **Step 3: Build and verify** — Run `bash bin/build.sh`; expect a compiled `theme/dist/app.css` with no errors. Run `grep -ri "IBM Plex" theme/src theme/functions.php` → no matches.

- [ ] **Step 4: Commit** — `git commit -m "feat: Trades Workhorse tokens — Archivo/Public Sans, paper/charcoal/pine/amber, flat 2.0"`

---

### Task 2: Shared chrome — header, footer, page-hero, cta-band

**Files:** Modify `theme/header.php`, `theme/footer.php`, `theme/template-parts/page-hero.php`, `theme/template-parts/cta-band.php`.

**Interfaces — Consumes:** Task 1 classes. **Produces:** `page-hero` accepts existing `hero` query var (`eyebrow`,`title`,`lead`) — signature unchanged so page templates keep working mid-build.

- [ ] **Step 1: Header** — solid flat treatment: scrolled state uses `bg-bg border-line` with **no** backdrop-blur (`bg-bg/90 backdrop-blur` → `bg-bg`); CTA button already `.btn-primary` (now amber). Desktop nav link hover → `hover:text-accent`. Everything else (Alpine menu, skip link, click-to-call) stays.
- [ ] **Step 2: Page hero** — condensed-caps display treatment: `h1` gets classes `marker mt-4 text-4xl font-black uppercase tracking-tight sm:text-5xl`; section keeps borders. Lead paragraph unchanged.
- [ ] **Step 3: CTA band** — charcoal band instead of green: section classes → `bg-ink px-5 py-16 text-bg lg:px-8 lg:py-20`; heading gets `uppercase tracking-tight font-black`; primary button → `class="btn btn-primary"` (amber pops on charcoal); phone button → `btn border-2 border-bg/40 text-bg`. Copy: heading `Stop paying to cool the outdoors.` / sub `Free estimates across Marianna and Jackson County. No job too big or too small.`
- [ ] **Step 4: Footer** — read `theme/footer.php` first; apply flat tokens (2px top border, surface bg), no structural change to NAP/hours model.
- [ ] **Step 5: Build + eyeball** — `bash bin/build.sh`; load `http://localhost:8090` — header/hero/band show new skin on old content.
- [ ] **Step 6: Commit** — `git commit -m "feat: flat chrome — header, footer, caps+marker hero, charcoal CTA band"`

---

### Task 3: FAQ data + FAQPage schema

**Files:** Modify `theme/inc/template-helpers.php` (append), `theme/inc/schema.php` (append).

**Interfaces — Produces:** `sdp_home_faqs(): array` — list of `array( 'q' => string, 'a' => string )`, used by Task 4 (render) and the schema hook (JSON-LD). Single source of truth.

- [ ] **Step 1: Add `sdp_home_faqs()`** with these 8 Q&As verbatim (questions are real autocomplete queries):

1. **Why is my electric bill so high?** — "In the Panhandle, the number-one culprit is attic heat. An under-insulated attic can top 130°F on a summer afternoon, and your AC fights it all day long. Air leaks and thin insulation let that heat pour into the house. A free assessment tells you in about twenty minutes whether your attic is the problem."
2. **How much does attic insulation cost?** — "Typical installed ranges in our area: blown-in runs about $1.00–$2.50 per square foot and spray foam about $3.00–$7.00. A typical Jackson County attic lands roughly $1,500–$3,500 with blown-in. Every home is different — your written estimate is free and itemized."
3. **Is spray foam insulation worth it?** — "For attics and new construction, usually yes: it air-seals and insulates in one step, and the comfort difference is immediate. It costs more up front. We'll tell you honestly when blown-in gets you most of the benefit for less."
4. **Is spray foam insulation good in Florida?** — "Yes — humidity is the reason. Foam is an air barrier, so it keeps muggy outdoor air out of your attic and off your ductwork. Installed right, with venting and inspection access handled, it's one of the best upgrades a Panhandle home can get."
5. **What R-value is required in Florida?** — "Florida code calls for R-30 to R-38 in attics, and R-38 is the sweet spot for most homes in our climate zone. Many older Jackson County homes measure R-11 or less — that gap is where the savings are."
6. **Does attic insulation help in summer?** — "Summer is when it works hardest. Insulation slows the heat radiating down from a hot roof into your living space, so the AC cycles less and rooms stay evener. Air sealing plus insulation can save around 15% on heating and cooling costs, per ENERGY STAR."
7. **How often should insulation be replaced?** — "Good insulation can last decades — but not if it's been wet, compressed, or visited by pests. If your home is 20+ years old and the bills keep climbing, it's worth having the attic measured. We check depth and condition for free."
8. **Is blown-in insulation better than batts?** — "In attics, usually — loose fill flows around joists, wires, and odd framing, so there are no gaps. Batts shine in open walls during construction or a remodel. We'll recommend whichever fits your house, not whichever we feel like selling."

- [ ] **Step 2: FAQPage JSON-LD** — in `schema.php`, second `wp_head` hook, front page only, mapping `sdp_home_faqs()` to `{"@type":"FAQPage","mainEntity":[{"@type":"Question","name":q,"acceptedAnswer":{"@type":"Answer","text":a}}...]}` via `wp_json_encode`.
- [ ] **Step 3: Verify** — `curl -s http://localhost:8090/ | grep -c 'FAQPage'` → 1.
- [ ] **Step 4: Commit** — `git commit -m "feat: home FAQ data helper + FAQPage JSON-LD"`

---

### Task 4: Home page rebuild (`theme/front-page.php`)

**Files:** Modify `theme/front-page.php` (full rewrite, ~11 sections). Photos available: `fleet.jpg`, `attic.jpg`, `worker.jpg`, `materials.jpg`, `jobsite.jpg` under `theme/assets/photos/`.

**Interfaces — Consumes:** Task 1 classes, `sdp_setting()`, `sdp_icon()` (icons available: shield, wind, layers, sun, recycle, home, check, star, phone, arrow, bolt, leaf, pin, menu, close, arrow-up-right), `sdp_home_faqs()`.

Sections in order (copy verbatim; layout = flat bands alternating paper → charcoal → paper → surface → pine …):

- [ ] **Step 1: Hero** — two-column on lg: left = eyebrow `Insulation Contractor · Marianna, FL`, `h1` (`marker uppercase font-black tracking-tight`): **Insulation Contractor Serving Marianna & Jackson County, FL**; lead: "Family-run since 2006. Spray foam, blown-in, batt & roll, radiant barrier, removal and replacement — free estimates, honest numbers, no job too big or too small."; trust chips row (flat bordered pills): `★ Est. 2006` · `Licensed & Insured` · `Free Estimates`; dual CTA (`.btn-primary` "Get My Free Estimate" → /contact/, `.btn-ghost` phone). Right = `fleet.jpg` in 2px-border frame.
- [ ] **Step 2: Stat band** (charcoal `bg-ink text-bg`, amber `.stat` numerals): `20` years insulating the Panhandle · `~15%` avg. heating & cooling savings from air sealing + insulation (ENERGY STAR) · `R-38` recommended attic target for NW Florida · `$0` for an estimate — free, no obligation.
- [ ] **Step 3: Problem section** ("Why Panhandle power bills run high") — two-col: copy explaining 130°F attics, leaky ducts, thin insulation; checklist (lower cooling bills, even rooms, less AC strain, quieter/less humid home) reused from current build; photo `attic.jpg`.
- [ ] **Step 4: Services blocks** — keep the CPT loop; flat solid-fill blocks (surface bg, 2px border, icon, title, summary, "Learn more →" linking to `/services/#anchor` — anchors: spray-foam, blown-in, batt-roll, radiant-barrier, removal, replacement, mapped by `menu_order`).
- [ ] **Step 5: Process** ("What happens when you call") — 4 numbered steps (big amber Archivo numerals 01–04): **Call or send the form** "You reach us, not a call center. Same or next business day, we set a time." / **Free attic assessment** "We measure what you have — depth, condition, air leaks — and show you photos of what we find." / **A written, honest number** "Flat pricing, material options explained, no pressure. The estimate is yours either way." / **Install day** "Most attics are done in a day. We clean up, haul off the mess, and you feel the difference the first hot afternoon."
- [ ] **Step 6: Money section** ("Straight talk about cost" — pine band `bg-accent text-accent-ink`): table of typical installed ranges — Blown-in attic $1.00–$2.50/sq ft · Batt & roll $1.00–$3.00/sq ft · Spray foam $3.00–$7.00/sq ft · Radiant barrier $1.00–$2.00/sq ft · Removal $1.00–$2.00/sq ft; footnote "Typical ranges for our area — every home differs. Your written estimate is free."; phased-work note: "Bigger job than the budget? We'll scope it in phases — attic first, where the payback is fastest. We take cash and all major cards."
- [ ] **Step 7: Jobs gallery** — existing 3 photos + `jobsite.jpg`, town-labeled captions (e.g. "Spray foam attic — Marianna", "Blown-in top-up — Jackson County").
- [ ] **Step 8: Reviews** — existing testimonial CPT loop, flat cards.
- [ ] **Step 9: Service-area strip** — existing towns array, flat chips, link to /service-area/.
- [ ] **Step 10: FAQ** — Alpine accordion over `sdp_home_faqs()` (`<details>`-style disclosure, keyboard operable), h2 "Questions homeowners actually ask".
- [ ] **Step 11: CTA band include + verify + commit** — `bash bin/build.sh`; check all sections at 360px and desktop; `git commit -m "feat: rebuild home — trust hero, stats, process, cost table, FAQ"`

---

### Task 5: Services page rebuild (`theme/page-services.php`)

**Files:** Modify `theme/page-services.php` (full rewrite). Static content sections (not CPT-driven — depth lives here; CPT cards remain the Home teaser).

- [ ] **Step 1: Hero** — h1 **Home Insulation Services in Marianna & the Florida Panhandle**; lead mentions best-insulation-for-Florida framing.
- [ ] **Step 2: Jump nav** — sticky-top anchor chip row: Spray Foam · Blown-In · Batt & Roll · Radiant Barrier · Removal · Replacement.
- [ ] **Step 3: Six service sections**, each `<section id="…" class="scroll-mt-24">` with: h2 (caps+marker), "what it is" paragraph, **Best for** chip list, **R-value guidance** stat line, **Honest tradeoffs** copy, **Typical cost** range, 2-question mini-FAQ, section CTA link. Content verbatim:
  - `#spray-foam` — open + closed cell; seals air leaks and insulates in one step; closed cell ~R-6.5/inch, open ~R-3.7/inch (highest R per inch available). Best for: attic roof decks, new-construction walls, rim joists, metal buildings. Tradeoffs (must include, verbatim): "It's the premium option — $3.00–$7.00 per square foot installed. And one thing most contractors won't mention: when foam covers a roof deck, some lenders and home inspectors ask questions at sale or re-roof time. We walk you through venting and inspection-access choices up front so there are no surprises." Mini-FAQ: *Is spray foam worth it?* / *Is spray foam better than fiberglass?* (honest: better air sealing, higher cost; fiberglass wins on budget).
  - `#blown-in` — loose-fill fiberglass or cellulose; fast, even, gap-free; the most cost-effective attic top-up; can install over existing insulation. Cost $1.00–$2.50/sq ft. Tradeoffs: doesn't air-seal by itself (we seal penetrations first); settles slightly over time (we account for it in depth). Mini-FAQ: *Is blown-in better than batts?* / *Fiberglass or cellulose?* (both work; fiberglass resists moisture, cellulose is denser — we recommend per house).
  - `#batt-roll` — fiberglass batts for open walls, floors, garages, new construction; dependable and budget-friendly, $1.00–$3.00/sq ft. Tradeoff: performance depends entirely on fit — compressed or gapped batts underperform their rating, which is why installation quality is the whole game. Mini-FAQ: *Batt vs roll?* / *Batt vs spray foam?*
  - `#radiant-barrier` — reflective foil under the roof deck turns back radiant heat; meaningful attic-temperature drop in FL summers; complements insulation, never replaces it; $1.00–$2.00/sq ft. Mini-FAQ: *Is radiant barrier worth it?* (in a cooling climate like ours, yes — especially with ductwork in the attic) / *Does it help in winter?* (its job is summer heat; winter effect is modest — honest).
  - `#removal` — safe vacuum-and-bag removal of wet, moldy, pest-damaged, or fire-damaged insulation; when it's needed (water damage, rodents, renovation, prepping for foam); $1.00–$2.00/sq ft.
  - `#replacement` — full tear-out and re-insulation; the biggest single efficiency upgrade for many pre-1990 homes; signs it's time (20+ year old insulation, climbing bills, uneven rooms, past leaks). Mini-FAQ: *How often should insulation be replaced?* / *Does attic insulation go bad?*
- [ ] **Step 4: Where-we-insulate matrix + process recap** — keep photo block; add compact 4-step recap linking home process; CTA band.
- [ ] **Step 5: Build, verify anchors from home cards land correctly, commit** — `git commit -m "feat: services page — six deep sections with costs, tradeoffs, mini-FAQs"`

---

### Task 6: About, Service Area, Contact depth

**Files:** Modify `theme/page-about.php`, `theme/page-service-area.php`, `theme/page-contact.php`; About body content lives in seed (Task 7) — template gains sections.

- [ ] **Step 1: About** — h1 **Your Local Insulation Experts in Marianna, Florida**. Keep prose column + values aside; add: a "20 years, one county" story section (2006 origin, family-run, Hwy 90 home base), a "How we work" commitments list (show up when we say · explain options in plain English · flat written numbers · leave it cleaner than we found it), and a practical-details strip (cash + major cards accepted · ASL-proficient · free estimates). No invented names/bios.
- [ ] **Step 2: Service Area** — h1 **Insulation Services Across Jackson County & the NW Florida Panhandle**. Replace bare chip list with a short unique line per town (Marianna home base; Sneads/Grand Ridge east Jackson County; Graceville/Campbellton north toward the state line; Chipley & Bonifay west into Washington/Holmes counties; Alford/Cottondale along US-231; Malone/Greenwood north county). Keep map; add "not sure? call" CTA.
- [ ] **Step 3: Contact** — h1 **Get Your Free Insulation Estimate**. Keep form + aside; add "What happens after you hit send" strip: 1. We call you back within one business day. 2. We schedule your free attic assessment. 3. You get a written, itemized estimate — no pressure, no obligation.
- [ ] **Step 4: Build, verify, commit** — `git commit -m "feat: deepen about, service-area, contact pages"`

---

### Task 7: SEO titles + seed content

**Files:** Modify `theme/inc/seo.php` (title map), `bin/seed.sh` (excerpts, settings).

- [ ] **Step 1: Exact titles** — add `pre_get_document_title` filter in `seo.php` mapping (front page + page slugs `services`, `about`, `service-area`, `contact`) to these exact strings:
  - Home: `Insulation Contractor in Marianna, FL | A Plus Insulation`
  - Services: `Insulation Services in Marianna, FL | Spray Foam & More`
  - About: `About A Plus Insulation | Marianna, FL Insulation Pros`
  - Service Area: `Service Area | Insulation in Jackson County & NW Florida`
  - Contact: `Free Insulation Estimate | A Plus Insulation Marianna FL`
- [ ] **Step 2: Meta descriptions** — seed page **excerpts** (consumed by `sdp_meta_description_text()`) with the keyword-plan metas verbatim:
  - Home (via Site Settings `intro`): `Spray foam, blown-in & batt insulation for Jackson County homes. A Plus Insulation in Marianna, FL — free estimates. Call (850) 209-2636.`
  - Services: `Attic insulation services in Marianna, FL: spray foam, blown-in, batt & roll, radiant barrier, removal & replacement. Free estimates in Jackson County.`
  - About: `Local, family-run insulation contractor in Marianna, FL. Licensed & insured, serving Jackson County homeowners with honest work and fair prices.`
  - Service Area: `A Plus Insulation serves Marianna, Sneads, Graceville, Chipley, Bonifay, Cottondale, Grand Ridge, Malone & the NW Florida Panhandle. Free estimates.`
  - Contact: `Get a free insulation estimate in Marianna, FL. Call A Plus Insulation at (850) 209-2636 or send a message — we serve all of Jackson County.`
- [ ] **Step 3: Settings copy** — seed `cta_label` → `Get My Free Estimate`; tagline stays brand-level ("A warmer, cooler, more efficient home" is fine as brand line — h1s are now hardcoded).
- [ ] **Step 4: Re-seed + verify idempotency** — `bash bin/seed.sh` twice; `curl -s localhost:8090 | grep '<title>'` shows the exact Home title; each page's meta description matches.
- [ ] **Step 5: Commit** — `git commit -m "feat: keyword-plan titles + meta descriptions"`

---

### Task 8: Full verification + screenshots

- [ ] **Step 1:** `bash bin/build.sh && docker compose up -d && bash bin/seed.sh` — clean run.
- [ ] **Step 2:** Browser pass (chrome-devtools/Playwright MCP): all 5 pages, desktop 1440 + mobile 360; zero console errors; nav/anchors/FAQ accordion/form success state work; reduced-motion honored.
- [ ] **Step 3:** Schema: front page emits valid LocalBusiness + FAQPage JSON-LD (paste into validator or lint JSON structure).
- [ ] **Step 4:** Contrast spot-checks: amber `#f7a800` w/ charcoal `#20241f` text (buttons) ≥ 4.5:1; amber numerals on charcoal (large text) ≥ 3:1; paper on pine ≥ 4.5:1.
- [ ] **Step 5:** `grep -ri "tax credit\|25C" theme/` → no matches. `grep -ri "IBM Plex" theme/ --include="*.php" --include="*.css" -l` (exclude dist? no — dist rebuilt) → no matches in src/php.
- [ ] **Step 6:** Screenshots → repo root (`aplus-redesign-home.png`, `-services.png`, `-about.png`, `-area.png`, `-contact.png`). Commit: `git commit -m "chore: redesign verification screenshots"`

## Self-review notes

- Spec coverage: §2 tokens → Task 1-2; §3 Home → Task 4 (11 sections all present); Services → Task 5; About/Area/Contact → Task 6; §4 SEO → Tasks 3, 7 (keyword plan ran first ✓); §6 verification → Task 8. Money section has no financing-lender claims (phases + payment methods only) ✓; no 25C ✓.
- Type consistency: `sdp_home_faqs()` defined Task 3, consumed Task 4; `hero` query-var signature unchanged; anchor ids identical in Tasks 4 & 5.
