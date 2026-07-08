# A Plus Insulation — Demo Website Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a 5-page WordPress demo site for A Plus Insulation (Marianna, FL), scaffolded from the SDP starter kit and re-skinned to a Swiss/eco design, running locally on Docker + MySQL 8.

**Architecture:** Copy `sdp-starter-kit/templates/wordpress-cms` into this repo unchanged, then (a) reconfigure the stack (MySQL 8, port 8090, theme slug `aplus-insulation`), (b) re-skin via the `@theme` token block + fonts, (c) seed real business content and the 5 pages, (d) rework the front page and add four interior page templates, and (e) emit `LocalBusiness` JSON-LD. The theme is a classic PHP theme; content comes from ACF-backed CPTs (`service`, `testimonial`, `sitesettings`) read through existing `sdp_*` helpers. The design owns layout; the client edits data only.

**Tech Stack:** WordPress (php8.3-apache), MySQL 8, WP-CLI, Tailwind CSS v4 (`@tailwindcss/cli`), Alpine.js 3, esbuild, ACF (free), Rank Math. Build runs in a throwaway `node:20` container — no host Node.

## Global Constraints

- **Source scaffold (verbatim copy):** `/home/cody/workspace/sandbox/sdp-starter-kit/templates/wordpress-cms`. Do not reinvent scaffold files; modify only what each task names.
- **Repo root:** `/home/cody/workspace/sandbox/aplusinsulation`. Branch: `feat/demo-site`.
- **Local theme dir stays `theme/`**; its WP slug (mount target + `wp theme activate`) is **`aplus-insulation`**.
- **DB:** `mysql:8` (never mariadb). **WordPress port:** `8090`. **Site URL:** `http://localhost:8090`.
- **WSL/Windows environment quirk (critical):** all shell/git/docker runs go through `wsl -d Ubuntu -- bash -lc '<cmd>'`. This bridge **mangles `$shell_variables` and globs**, and the login shell's cwd defaults to the parent `sandbox` repo. Therefore: use **literal absolute paths only** in ad-hoc commands, run bin/ scripts by absolute path (they `cd` themselves), and use **`git -C /home/cody/workspace/sandbox/aplusinsulation`** for every git op. Never rely on `cd` persisting or on a bare `git`/`git add -A`.
- **Author identity for commits:** `-c user.name="Cody Sims" -c user.email="codysims37@gmail.com"`.
- **Business data (single source of truth for content):**
  - Name: `A Plus Insulation` · Established: `2006`
  - Phone display: `(850) 209-2636` · dial: `+18502092636`
  - Address: `5319 Hwy 90` / `Marianna, FL 32446`
  - Hours: Mon–Fri `8:00 AM – 5:00 PM`, Sat/Sun `Closed`
  - Service area: Marianna + Jackson County / NW Florida Panhandle (Marianna, Sneads, Graceville, Chipley, Alford, Bonifay, Cottondale, Grand Ridge, Malone, Cypress)
  - Tagline: `No job too big or too small`
  - Facebook: `https://www.facebook.com/aplusinsulationllc`
  - Maps URL: `https://maps.google.com/?q=5319+Hwy+90+Marianna+FL+32446`
- **Design tokens (eco / Swiss):** pine-green brand accent `#2f5d3a`; warm-clay CTA `#bd5f30`; oat background `#faf8f3`; deep pine ink `#1b2a20`; sharp radius `0.25rem`; type `IBM Plex Sans` + `IBM Plex Mono` (mono for stats/R-values). Foundations bar governs — verify WCAG AA contrast, focus states, reduced-motion.
- **Verification default:** after any template/content change, assert with `curl -s http://localhost:8090<path>` piped to `grep -q` for expected copy, and capture a browser screenshot at the milestone tasks (chrome-devtools MCP against `http://localhost:8090`). No task is done until its check passes.
- **Out of scope:** live form delivery, Hostinger deploy, real photography, blog. Drop the scaffold's Team section, Blog page, and blog seeding.

---

## File Structure

**Copied from scaffold, then MODIFIED:**
- `docker-compose.yml` — MySQL 8, port 8090, theme mount → `aplus-insulation`
- `bin/setup.sh` — URL 8090, title, `wp theme activate aplus-insulation`
- `bin/seed.sh` — full rewrite: real content + 5 pages + front page; no team/blog
- `theme/style.css` — theme header (name/description)
- `theme/theme.json` — palette + font families to match tokens
- `theme/src/app.css` — `@theme` tokens + fonts + CTA button override + `.stat` helper
- `theme/functions.php` — swap Google-fonts enqueue to IBM Plex Sans+Mono; load `schema` module
- `theme/inc/post-types.php` — `service` rewrite slug `services` → `service` (frees `/services/` page)
- `theme/inc/icons.php` — add insulation icons
- `theme/header.php` — multi-page nav + header click-to-call
- `theme/footer.php` — multi-page footer nav
- `theme/front-page.php` — full rework (hero, trust bar, bento services, why-insulation, service area, testimonials, CTA band, contact strip)

**Created new:**
- `theme/inc/schema.php` — `LocalBusiness` (InsulationContractor) JSON-LD from Site Settings
- `theme/template-parts/page-hero.php` — shared interior-page header
- `theme/template-parts/cta-band.php` — reusable green CTA band
- `theme/page-services.php`, `theme/page-about.php`, `theme/page-service-area.php`, `theme/page-contact.php`

**Copied from scaffold, UNCHANGED:** `bin/build.sh`, `theme/src/app.js`, `theme/index.php`, `theme/home.php`, `theme/page.php`, `theme/single.php`, `theme/archive.php`, `theme/template-parts/archive-body.php`, `theme/inc/fields.php`, `theme/inc/template-helpers.php`, `theme/inc/security.php`, `theme/inc/seo.php`, `theme/package.json`, `theme/package-lock.json`, `.gitignore`, `AGENTS.md`.

---

## Task 1: Scaffold the repo from the starter template

**Files:**
- Create (copy): all of `templates/wordpress-cms/*` into repo root
- Keep existing: `README.md`, `.gitattributes`, `docs/`

**Interfaces:**
- Produces: repo layout `docker-compose.yml`, `bin/`, `theme/`, `.gitignore`, `AGENTS.md` at `/home/cody/workspace/sandbox/aplusinsulation`.

- [ ] **Step 1: Copy the scaffold in (excluding the scaffold's git-ignored build dirs)**

Run:
```
wsl -d Ubuntu -- bash -lc 'cp -a /home/cody/workspace/sandbox/sdp-starter-kit/templates/wordpress-cms/. /home/cody/workspace/sandbox/aplusinsulation/ && rm -rf /home/cody/workspace/sandbox/aplusinsulation/theme/node_modules /home/cody/workspace/sandbox/aplusinsulation/theme/dist && ls -la /home/cody/workspace/sandbox/aplusinsulation'
```
Expected: root now lists `docker-compose.yml`, `bin`, `theme`, `.gitignore`, `AGENTS.md`, plus pre-existing `README.md`, `docs`, `.gitattributes`.

- [ ] **Step 2: Verify the theme tree is present**

Run:
```
wsl -d Ubuntu -- bash -lc 'ls /home/cody/workspace/sandbox/aplusinsulation/theme && echo --- && ls /home/cody/workspace/sandbox/aplusinsulation/theme/inc'
```
Expected: template PHP files listed; `inc/` shows `fields.php icons.php post-types.php security.php seo.php template-helpers.php`.

- [ ] **Step 3: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "chore: scaffold from sdp-starter-kit wordpress-cms template" && git -C /home/cody/workspace/sandbox/aplusinsulation log --oneline -1'
```
Expected: new commit on `feat/demo-site`.

---

## Task 2: Reconfigure the stack (MySQL 8, port 8090, theme slug) and bring WordPress up

**Files:**
- Modify: `docker-compose.yml` (full replace), `bin/setup.sh:19` & `:27` & `:29`, `theme/style.css:2` & `:6`

**Interfaces:**
- Produces: a running WP install at `http://localhost:8090`, theme `aplus-insulation` active.

- [ ] **Step 1: Replace `docker-compose.yml` with the MySQL 8 / port 8090 / renamed-theme version**

Full new content of `docker-compose.yml`:
```yaml
services:
  db:
    image: mysql:8
    command: --default-authentication-plugin=caching_sha2_password
    environment:
      MYSQL_DATABASE: sdp
      MYSQL_USER: sdp
      MYSQL_PASSWORD: sdp
      MYSQL_ROOT_PASSWORD: root
    volumes:
      - db_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-uroot", "-proot"]
      interval: 5s
      timeout: 5s
      retries: 20

  wordpress:
    image: wordpress:php8.3-apache
    depends_on:
      db:
        condition: service_healthy
    ports:
      - "8090:80"
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_NAME: sdp
      WORDPRESS_DB_USER: sdp
      WORDPRESS_DB_PASSWORD: sdp
      WORDPRESS_DEBUG: 1
    volumes:
      - wp_core:/var/www/html
      - ./theme:/var/www/html/wp-content/themes/aplus-insulation

  cli:
    image: wordpress:cli-php8.3
    depends_on:
      db:
        condition: service_healthy
    user: "33:33"
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_NAME: sdp
      WORDPRESS_DB_USER: sdp
      WORDPRESS_DB_PASSWORD: sdp
    volumes:
      - wp_core:/var/www/html
      - ./theme:/var/www/html/wp-content/themes/aplus-insulation
    entrypoint: ["tail", "-f", "/dev/null"]

volumes:
  db_data:
  wp_core:
```

- [ ] **Step 2: Update `bin/setup.sh`** — change three lines:
  - Line 19 `--url="http://localhost:8081"` → `--url="http://localhost:8090"`
  - Line 22 `--title="SDP Starter"` → `--title="A Plus Insulation"`
  - Line 27 `wp theme activate sdp-starter` → `wp theme activate aplus-insulation`
  - Line 29 echo `http://localhost:8081` → `http://localhost:8090`

- [ ] **Step 3: Update `theme/style.css` header** — set:
  - `Theme Name: A Plus Insulation`
  - `Description: Custom SDP demo theme for A Plus Insulation (Marianna, FL). Swiss/eco design; content edited via structured fields.`

- [ ] **Step 4: Bring the stack up and install WordPress**

Run:
```
wsl -d Ubuntu -- bash -lc 'cd /home/cody/workspace/sandbox/aplusinsulation && docker compose up -d && bash /home/cody/workspace/sandbox/aplusinsulation/bin/setup.sh'
```
Expected: ends with `==> done — http://localhost:8090  (admin/admin)`.

- [ ] **Step 5: Verify WP responds and the theme is active**

Run:
```
wsl -d Ubuntu -- bash -lc 'curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8090/ && docker compose -f /home/cody/workspace/sandbox/aplusinsulation/docker-compose.yml exec -T -e HTTP_HOST=localhost cli wp theme list --status=active --field=name </dev/null'
```
Expected: `200` and `aplus-insulation`.

- [ ] **Step 6: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "chore: mysql 8, port 8090, rename theme to aplus-insulation"'
```

---

## Task 3: Rewrite the seed script with real content and the 5 pages

**Files:**
- Modify: `theme/inc/post-types.php:36` (service rewrite slug)
- Modify: `bin/seed.sh` (full replace)

**Interfaces:**
- Consumes: ACF field keys from `theme/inc/fields.php` (`field_ss_*`, `field_service_*`, `field_t_*`) and the `acf()` seed helper.
- Produces: published pages `home`, `services`, `about`, `service-area`, `contact`; front page = `home`; one `sitesettings` record with real data; `service` + `testimonial` content. Later tasks' nav/templates rely on these slugs.

- [ ] **Step 1: Free the `/services/` path** — in `theme/inc/post-types.php`, change the `service` registration's `'rewrite' => array( 'slug' => 'services' )` to `'slug' => 'service'`.

- [ ] **Step 2: Replace `bin/seed.sh` with the A Plus seed**

Full new content of `bin/seed.sh`:
```bash
#!/usr/bin/env bash
# Seed A Plus Insulation content + the 5 marketing pages. Reproducible: CPT and
# page content is reset each run so the demo is deterministic.
set -uo pipefail
cd "$(dirname "$0")/.."

wp() { docker compose exec -T -e HTTP_HOST=localhost -e WP_CLI_CACHE_DIR=/tmp/.wp-cli cli wp "$@" </dev/null; }
acf() { local id="$1" name="$2" key="$3" val="$4"; wp post meta update "$id" "$name" "$val" >/dev/null; wp post meta update "$id" "_$name" "$key" >/dev/null; }

echo "==> Plugins: ACF + Rank Math"
wp plugin is-installed advanced-custom-fields >/dev/null 2>&1 || wp plugin install advanced-custom-fields >/dev/null
wp plugin activate advanced-custom-fields >/dev/null 2>&1
wp plugin is-installed seo-by-rank-math >/dev/null 2>&1 || wp plugin install seo-by-rank-math >/dev/null
wp plugin activate seo-by-rank-math >/dev/null 2>&1
wp theme activate aplus-insulation >/dev/null 2>&1

echo "==> Pages (home + 4 interior)"
page() { # slug title
  local id; id=$(wp post list --post_type=page --name="$1" --field=ID 2>/dev/null | head -1)
  [ -z "$id" ] && id=$(wp post create --post_type=page --post_title="$2" --post_name="$1" --post_status=publish --porcelain)
  echo "$id"
}
HOME_ID=$(page home "Home")
page services "Services" >/dev/null
page about "About" >/dev/null
page service-area "Service Area" >/dev/null
page contact "Contact" >/dev/null
wp option update show_on_front page >/dev/null
wp option update page_on_front "$HOME_ID" >/dev/null
wp option update page_for_posts 0 >/dev/null
wp option update blogname "A Plus Insulation" >/dev/null
wp option update blogdescription "Insulation Contractor in Marianna, FL" >/dev/null

echo "==> Reset CPT content"
for pt in team service testimonial sitesettings; do
  ids=$(wp post list --post_type=$pt --format=ids --posts_per_page=-1 2>/dev/null)
  [ -n "$ids" ] && wp post delete $ids --force >/dev/null
done

echo "==> Site Settings"
SS=$(wp post create --post_type=sitesettings --post_title="Site Settings" --post_status=publish --porcelain)
acf "$SS" tagline    field_ss_tagline    "A warmer, cooler, more efficient home"
acf "$SS" intro      field_ss_intro      "Family-run insulation contractor serving Marianna and Jackson County since 2006. Spray foam, blown-in, batt & roll, radiant barrier, removal and replacement — no job too big or too small."
acf "$SS" cta_url    field_ss_cta_url    "/contact/"
acf "$SS" cta_label  field_ss_cta_label  "Free Estimate"
acf "$SS" phone      field_ss_phone      "(850) 209-2636"
acf "$SS" phone_href field_ss_phone_href "+18502092636"
acf "$SS" email      field_ss_email      "info@aplusinsulationllc.com"
acf "$SS" address    field_ss_address    $'5319 Hwy 90\nMarianna, FL 32446'
acf "$SS" maps_url   field_ss_maps_url   "https://maps.google.com/?q=5319+Hwy+90+Marianna+FL+32446"
acf "$SS" facebook   field_ss_facebook   "https://www.facebook.com/aplusinsulationllc"
acf "$SS" hours_mon  field_ss_mon        "8:00 AM – 5:00 PM"
acf "$SS" hours_tue  field_ss_tue        "8:00 AM – 5:00 PM"
acf "$SS" hours_wed  field_ss_wed        "8:00 AM – 5:00 PM"
acf "$SS" hours_thu  field_ss_thu        "8:00 AM – 5:00 PM"
acf "$SS" hours_fri  field_ss_fri        "8:00 AM – 5:00 PM"
acf "$SS" hours_sat  field_ss_sat        "Closed"
acf "$SS" hours_sun  field_ss_sun        "Closed"

echo "==> Services"
svc() { local id; id=$(wp post create --post_type=service --post_title="$1" --post_status=publish --menu_order="$4" --porcelain); acf "$id" summary field_service_summary "$2"; acf "$id" featured field_service_featured "$3"; }
svc "Spray Foam Insulation"      "Open- and closed-cell spray foam that seals air leaks and delivers the highest R-value per inch — ideal for Panhandle heat and humidity." 1 1
svc "Blown-In Insulation"        "Loose-fill cellulose or fiberglass blown into attics and walls for fast, even, gap-free coverage." 1 2
svc "Batt & Roll Insulation"     "Fiberglass batts for walls, floors and new construction — a cost-effective, dependable standard." 0 3
svc "Radiant Barrier"            "Reflective foil that turns back radiant heat in the attic, easing the load on your AC all summer." 0 4
svc "Insulation Removal"         "Safe removal of old, wet, moldy or pest-damaged insulation to prep for a clean replacement." 0 5
svc "Insulation Replacement"     "Full tear-out and re-insulation to restore comfort and lower energy bills in older homes." 0 6

echo "==> Testimonials"
tst() { local id; id=$(wp post create --post_type=testimonial --post_title="$1" --post_status=publish --menu_order="$5" --porcelain); acf "$id" author_name field_t_author "$1"; acf "$id" author_role field_t_role "$2"; acf "$id" rating field_t_rating "$3"; acf "$id" quote field_t_quote "$4"; }
tst "Danielle W." "Marianna, FL"    5 "They insulated our attic with spray foam and the difference was immediate — the house holds its cool and our power bill dropped. Professional crew, fair price." 1
tst "Robert M."   "Grand Ridge, FL" 5 "Removed the old nasty insulation and blew in new. On time, cleaned up after themselves, no job too big or too small like they say." 2
tst "Sheila T."   "Chipley, FL"     5 "Honest, local, and did exactly what they promised. Highly recommend A Plus for anyone in Jackson County." 3

echo "==> Flush + summary"
wp rewrite structure "/%postname%/" --hard >/dev/null 2>&1
wp rewrite flush --hard >/dev/null 2>&1
echo "Pages:        $(wp post list --post_type=page --format=count)"
echo "Services:     $(wp post list --post_type=service --format=count)"
echo "Testimonials: $(wp post list --post_type=testimonial --format=count)"
echo "Settings:     $(wp post list --post_type=sitesettings --format=count)"
```

- [ ] **Step 3: Run the seed**

Run:
```
wsl -d Ubuntu -- bash -lc 'bash /home/cody/workspace/sandbox/aplusinsulation/bin/seed.sh'
```
Expected: `Pages: 5`, `Services: 6`, `Testimonials: 3`, `Settings: 1`.

- [ ] **Step 4: Verify pages resolve and settings drive the front page**

Run:
```
wsl -d Ubuntu -- bash -lc 'for p in "" services about service-area contact; do printf "%s -> " "/$p"; curl -s -o /dev/null -w "%{http_code}\n" "http://localhost:8090/$p"; done && curl -s http://localhost:8090/ | grep -oq "A warmer, cooler, more efficient home" && echo TAGLINE_OK'
```
Expected: five `200`s and `TAGLINE_OK` (the front page currently uses the scaffold's front-page.php — it renders the seeded tagline).

- [ ] **Step 5: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: seed real A Plus content + 5 pages; free /services/ path"'
```

---

## Task 4: Apply the Swiss/eco design tokens and fonts

**Files:**
- Modify: `theme/src/app.css` (full replace), `theme/functions.php:34-39` (font enqueue), `theme/theme.json` (palette/fonts)

**Interfaces:**
- Consumes: semantic utilities already used in templates (`bg-bg`, `bg-surface`, `text-ink`, `text-muted`, `border-line`, `text-accent`, `bg-accent`, `.btn-primary`, `.eyebrow`, `.card`).
- Produces: green/clay/oat palette + IBM Plex; new `.btn-cta`-style primary button (clay) and `.stat` mono helper for numerals.

- [ ] **Step 1: Replace `theme/src/app.css`**

Full new content:
```css
@import 'tailwindcss';

/* Scan the theme's PHP templates for utility classes. */
@source '../**/*.php';

/*
|--------------------------------------------------------------------------
| DESIGN TOKENS — A Plus Insulation (Swiss / eco). Re-skin here.
|--------------------------------------------------------------------------
*/
@theme {
	--font-sans: 'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif;
	--font-display: 'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif;
	--font-mono: 'IBM Plex Mono', ui-monospace, SFMono-Regular, monospace;

	--color-bg: #faf8f3;          /* warm oat */
	--color-surface: #f1ede4;
	--color-surface-2: #e7e1d4;
	--color-ink: #1b2a20;         /* deep pine */
	--color-muted: #55635a;
	--color-line: #ddd6c7;

	--color-accent: #2f5d3a;      /* pine green — brand */
	--color-accent-hover: #264b2f;
	--color-accent-ink: #ffffff;

	--color-cta: #bd5f30;         /* warm clay — primary action */
	--color-cta-hover: #a45028;
	--color-cta-ink: #ffffff;

	--radius: 0.25rem;            /* sharp (Swiss) */
	--ease-out-cubic: cubic-bezier(0.22, 1, 0.36, 1);
}

@layer base {
	html { scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
	[x-cloak] { display: none !important; }

	body {
		background-color: var(--color-bg);
		color: var(--color-ink);
		font-family: var(--font-sans);
	}

	::selection { background-color: var(--color-accent); color: var(--color-accent-ink); }
	:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 3px; border-radius: 2px; }

	h1, h2, h3, h4 {
		font-family: var(--font-display);
		font-weight: 700;
		line-height: 1.05;
		letter-spacing: -0.015em;
	}
}

@layer components {
	.eyebrow {
		font-family: var(--font-mono);
		font-size: 0.72rem;
		font-weight: 500;
		letter-spacing: 0.16em;
		text-transform: uppercase;
		color: var(--color-accent);
	}

	/* Stat / numeral emphasis (R-values, years, counts). */
	.stat { font-family: var(--font-mono); font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }

	.btn {
		display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
		padding: 0.8rem 1.6rem; border-radius: var(--radius);
		font-weight: 600; font-size: 0.95rem;
		transition: all 0.2s var(--ease-out-cubic);
	}
	.btn-primary { background: var(--color-cta); color: var(--color-cta-ink); }
	.btn-primary:hover { background: var(--color-cta-hover); transform: translateY(-1px); }
	.btn-ghost { border: 1px solid var(--color-line); color: var(--color-ink); }
	.btn-ghost:hover { border-color: var(--color-accent); color: var(--color-accent); }
	/* On the green CTA band. */
	.btn-onaccent { background: var(--color-accent-ink); color: var(--color-accent); }
	.btn-onaccent:hover { transform: translateY(-1px); }

	.card {
		background: var(--color-bg);
		border: 1px solid var(--color-line);
		border-radius: var(--radius);
		transition: box-shadow 0.2s var(--ease-out-cubic), transform 0.2s var(--ease-out-cubic);
	}
	.card:hover { box-shadow: 0 12px 32px -12px rgba(27, 42, 32, 0.18); transform: translateY(-2px); }

	.prose-sdp { color: var(--color-ink); font-size: 1.075rem; line-height: 1.75; }
	.prose-sdp > * + * { margin-top: 1.4em; }
	.prose-sdp h2 { font-size: 1.75rem; margin-top: 2em; }
	.prose-sdp h3 { font-size: 1.35rem; margin-top: 1.6em; }
	.prose-sdp a { color: var(--color-accent); text-decoration: underline; text-underline-offset: 3px; }
	.prose-sdp ul { list-style: disc; padding-left: 1.4em; }
	.prose-sdp ol { list-style: decimal; padding-left: 1.4em; }
	.prose-sdp blockquote { border-left: 3px solid var(--color-accent); padding-left: 1.25em; color: var(--color-muted); }
	.prose-sdp img { width: 100%; border-radius: var(--radius); }
}

.has-js [data-reveal] {
	opacity: 0; transform: translateY(20px);
	transition: opacity 0.7s var(--ease-out-cubic), transform 0.7s var(--ease-out-cubic);
	will-change: opacity, transform;
}
.has-js [data-reveal].is-visible { opacity: 1; transform: none; }

@media (prefers-reduced-motion: reduce) {
	.has-js [data-reveal] { opacity: 1; transform: none; transition: none; }
	html { scroll-behavior: auto; }
}
```

- [ ] **Step 2: Swap the font enqueue in `theme/functions.php`** — replace the `wp_enqueue_style( 'sdp-fonts', ... Inter ... )` URL (lines 34-39) with the IBM Plex families:
```php
	wp_enqueue_style(
		'sdp-fonts',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap',
		array(),
		null
	);
```

- [ ] **Step 3: Update `theme/theme.json`** — set the palette colors to `bg #faf8f3`, `surface #f1ede4`, `ink #1b2a20`, `muted #55635a`, `accent #2f5d3a`, and the font family to `"'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif"` (slug `sans`, name `IBM Plex Sans`); `styles.color.background #faf8f3`, `text #1b2a20`.

- [ ] **Step 4: Build assets**

Run:
```
wsl -d Ubuntu -- bash -lc 'bash /home/cody/workspace/sandbox/aplusinsulation/bin/build.sh'
```
Expected: `Built theme/dist/app.css and theme/dist/app.js`.

- [ ] **Step 5: Verify the new palette/font shipped**

Run:
```
wsl -d Ubuntu -- bash -lc 'grep -c "2f5d3a\|bd5f30\|IBM Plex" /home/cody/workspace/sandbox/aplusinsulation/theme/dist/app.css && curl -s http://localhost:8090/ | grep -oq "IBM+Plex" && echo FONT_LINKED'
```
Expected: a non-zero count and `FONT_LINKED`. Then load `http://localhost:8090/` in the browser (chrome-devtools MCP) and confirm oat background + green accents + Plex type.

- [ ] **Step 6: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: apply Swiss/eco design tokens and IBM Plex fonts"'
```

---

## Task 5: Multi-page navigation (header + footer) with header click-to-call

**Files:**
- Modify: `theme/header.php:6-11` (nav array) and the header actions block (`:41-45`)
- Modify: `theme/footer.php:26-33` (Explore list)

**Interfaces:**
- Consumes: page slugs from Task 3 (`/services/`, `/about/`, `/service-area/`, `/contact/`); `sdp_setting('phone'|'phone_href')`; `sdp_icon('phone')`.
- Produces: primary nav pointing to real pages, present on every template via `get_header()`/`get_footer()`.

- [ ] **Step 1: Replace the `$nav` array in `theme/header.php`** (lines 6-11) with real pages:
```php
	$nav = array(
		array( 'label' => 'Services',     'url' => home_url( '/services/' ) ),
		array( 'label' => 'About',        'url' => home_url( '/about/' ) ),
		array( 'label' => 'Service Area', 'url' => home_url( '/service-area/' ) ),
		array( 'label' => 'Contact',      'url' => home_url( '/contact/' ) ),
	);
```

- [ ] **Step 2: Add header click-to-call** — in `theme/header.php`, replace the desktop CTA block (the `<div class="hidden lg:flex">…</div>`, lines ~41-43) with a phone link + CTA:
```php
			<div class="hidden items-center gap-4 lg:flex">
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?>
					<a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-ink hover:text-accent"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?><?php echo esc_html( $ph ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?></a>
			</div>
```

- [ ] **Step 3: Update `theme/footer.php` Explore list** (lines 26-33) to the real pages:
```php
				<div>
					<h3 class="eyebrow">Explore</h3>
					<ul class="mt-4 space-y-2.5 text-sm text-muted">
						<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="transition-colors hover:text-ink">Services</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="transition-colors hover:text-ink">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/service-area/' ) ); ?>" class="transition-colors hover:text-ink">Service Area</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="transition-colors hover:text-ink">Contact</a></li>
					</ul>
				</div>
```

- [ ] **Step 4: Verify nav renders on an interior page**

Run:
```
wsl -d Ubuntu -- bash -lc 'curl -s http://localhost:8090/about/ | grep -oq "/service-area/" && curl -s http://localhost:8090/ | grep -oq "tel:+18502092636" && echo NAV_OK'
```
Expected: `NAV_OK`.

- [ ] **Step 5: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: multi-page nav + header click-to-call"'
```

---

## Task 6: Insulation icons + reusable CTA band, then rework the front page

**Files:**
- Modify: `theme/inc/icons.php` (add icons)
- Create: `theme/template-parts/cta-band.php`
- Modify: `theme/front-page.php` (full replace)

**Interfaces:**
- Consumes: `service`/`testimonial` CPTs; `sdp_setting`, `sdp_icon`, `sdp_hours`, `sdp_has_hours`.
- Produces: `sdp_icon` names `shield`, `layers`, `wind`, `sun`, `recycle`, `leaf`, `home`, `bolt`; `template-parts/cta-band.php` (include-able); the finished home page.

- [ ] **Step 1: Add icons to `theme/inc/icons.php`** — insert these entries into the `$paths` array (before the closing `);`):
```php
			'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
			'layers'   => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
			'wind'     => '<path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/>',
			'sun'      => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>',
			'recycle'  => '<path d="M7 19H4.8a2 2 0 0 1-1.7-3l1.9-3M8.5 3.5l1.6 2.8M12 3l3.2 5.5M21 12l-1.9-3.3a2 2 0 0 0-1.7-1H14M16 21l-3.2-5.5M8 21H6"/>',
			'leaf'     => '<path d="M11 20A7 7 0 0 1 4 13c0-6 7-11 16-11 0 9-5 16-11 16z"/><path d="M4 21c3-6 7-9 12-11"/>',
			'home'     => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/>',
			'bolt'     => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
```

- [ ] **Step 2: Create `theme/template-parts/cta-band.php`**
```php
<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$cta_url = sdp_setting( 'cta_url', home_url( '/contact/' ) );
$phone   = sdp_setting( 'phone' );
?>
<section class="bg-accent px-5 py-16 text-accent-ink lg:px-8 lg:py-20">
	<div class="mx-auto flex max-w-5xl flex-col items-center gap-6 text-center">
		<h2 class="max-w-2xl text-3xl sm:text-4xl">Ready for a warmer, cooler, more efficient home?</h2>
		<p class="max-w-xl text-accent-ink/80">Free estimates across Marianna and Jackson County. No job too big or too small.</p>
		<div class="flex flex-col gap-3 sm:flex-row">
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-onaccent">Request a Free Estimate</a>
			<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn border border-accent-ink/40 text-accent-ink"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $phone ); ?></a><?php endif; ?>
		</div>
	</div>
</section>
```

- [ ] **Step 3: Replace `theme/front-page.php`**

Full new content:
```php
<?php
/**
 * A Plus Insulation — front page. Swiss/eco long-scroll. Data comes from the
 * CMS (Site Settings + Service / Testimonial CPTs); this file owns layout only.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$tagline   = sdp_setting( 'tagline', get_bloginfo( 'name' ) );
$intro     = sdp_setting( 'intro', get_bloginfo( 'description' ) );
$cta_url   = sdp_setting( 'cta_url', home_url( '/contact/' ) );
$cta_label = sdp_setting( 'cta_label', 'Free Estimate' );
$phone     = sdp_setting( 'phone' );
$area = array( 'Marianna', 'Sneads', 'Graceville', 'Chipley', 'Alford', 'Bonifay', 'Cottondale', 'Grand Ridge', 'Malone', 'Cypress' );
?>

<?php /* ============================ HERO ============================ */ ?>
<section class="relative overflow-hidden border-b border-line px-5 pb-20 pt-36 lg:px-8 lg:pb-28 lg:pt-44">
	<div class="mx-auto max-w-4xl text-center">
		<span class="eyebrow" data-reveal>Insulation Contractor · Marianna, FL</span>
		<h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl" data-reveal><?php echo esc_html( $tagline ); ?></h1>
		<?php if ( $intro ) : ?><p class="mx-auto mt-6 max-w-2xl text-lg text-muted" data-reveal><?php echo esc_html( $intro ); ?></p><?php endif; ?>
		<div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row" data-reveal>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?> <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
			<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn btn-ghost"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $phone ); ?></a><?php endif; ?>
		</div>
	</div>
</section>

<?php /* ========================= TRUST BAR ========================= */ ?>
<section class="border-b border-line bg-surface px-5 py-10 lg:px-8">
	<div class="mx-auto grid max-w-6xl grid-cols-2 gap-6 text-center md:grid-cols-4">
		<?php
		$stats = array(
			array( 'n' => 'Est. 2006', 'l' => 'Locally owned' ),
			array( 'n' => '18+ yrs',   'l' => 'In business' ),
			array( 'n' => 'Licensed',  'l' => '& insured' ),
			array( 'n' => 'Free',      'l' => 'Estimates' ),
		);
		foreach ( $stats as $s ) : ?>
			<div data-reveal>
				<p class="stat text-2xl font-bold text-accent sm:text-3xl"><?php echo esc_html( $s['n'] ); ?></p>
				<p class="mt-1 text-sm text-muted"><?php echo esc_html( $s['l'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php /* =================== SERVICES (BENTO) ==================== */ ?>
<?php
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $services->have_posts() ) :
	$svc_icons = array( 'shield', 'wind', 'layers', 'sun', 'recycle', 'home' );
	$i = 0; ?>
	<section id="services" class="scroll-mt-20 px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">What we do</span>
				<h2 class="mt-4 text-3xl sm:text-4xl">Whole-home insulation, done right</h2>
			</div>
			<div class="mt-12 grid auto-rows-fr gap-4 sm:grid-cols-2 lg:grid-cols-3">
				<?php while ( $services->have_posts() ) : $services->the_post();
					$summary = get_field( 'summary' );
					$icon = $svc_icons[ $i % count( $svc_icons ) ]; $i++;
					$span = ( 0 === ( $i - 1 ) ) ? 'sm:col-span-2' : ''; ?>
					<article class="card flex flex-col p-6 <?php echo esc_attr( $span ); ?>" data-reveal>
						<span class="flex h-11 w-11 items-center justify-center rounded bg-accent/10 text-accent"><?php echo sdp_icon( $icon, 'h-5 w-5' ); ?></span>
						<h3 class="mt-4 text-xl font-bold"><?php the_title(); ?></h3>
						<?php if ( $summary ) : ?><p class="mt-2 flex-1 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<div class="mt-10" data-reveal><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="inline-flex items-center gap-1 font-semibold text-accent hover:underline">All services <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a></div>
		</div>
	</section>
<?php endif; ?>

<?php /* =================== WHY INSULATION ==================== */ ?>
<section class="border-y border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:items-center lg:gap-20">
		<div data-reveal>
			<span class="eyebrow">Why it matters</span>
			<h2 class="mt-4 text-3xl sm:text-4xl">Comfort you feel, savings you keep</h2>
			<p class="mt-5 text-muted">In the Florida Panhandle, your AC works hardest against the heat that pours through an under-insulated attic and walls. Sealing and insulating properly means a home that stays comfortable and a power bill that stops climbing.</p>
			<ul class="mt-6 space-y-3">
				<?php foreach ( array( 'Lower cooling bills all summer', 'Even, comfortable temperatures room to room', 'Less strain — and longer life — for your AC', 'A quieter, less humid, healthier home' ) as $point ) : ?>
					<li class="flex items-start gap-3 text-sm"><span class="mt-0.5 text-accent"><?php echo sdp_icon( 'check', 'h-5 w-5' ); ?></span><span><?php echo esc_html( $point ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="grid grid-cols-2 gap-4" data-reveal>
			<?php
			$facts = array(
				array( 'i' => 'bolt',  'n' => 'Up to 15%', 'l' => 'potential energy savings from air-sealing & insulation*' ),
				array( 'i' => 'sun',   'n' => 'R-49',      'l' => 'DOE-recommended attic R-value for our zone' ),
				array( 'i' => 'leaf',  'n' => 'Year-round', 'l' => 'cooler summers, warmer winters' ),
				array( 'i' => 'shield','n' => 'Sealed',    'l' => 'against heat, moisture & pests' ),
			);
			foreach ( $facts as $f ) : ?>
				<div class="card p-5">
					<span class="text-accent"><?php echo sdp_icon( $f['i'], 'h-6 w-6' ); ?></span>
					<p class="stat mt-3 text-2xl font-bold"><?php echo esc_html( $f['n'] ); ?></p>
					<p class="mt-1 text-xs leading-relaxed text-muted"><?php echo esc_html( $f['l'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php /* =================== SERVICE AREA ==================== */ ?>
<section class="px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto max-w-6xl text-center">
		<span class="eyebrow" data-reveal>Where we work</span>
		<h2 class="mt-4 text-3xl sm:text-4xl" data-reveal>Serving Marianna &amp; Jackson County</h2>
		<div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
			<?php foreach ( $area as $town ) : ?>
				<span class="rounded border border-line bg-surface px-4 py-2 text-sm font-medium"><?php echo esc_html( $town ); ?></span>
			<?php endforeach; ?>
		</div>
		<p class="mt-8 text-sm text-muted" data-reveal>Not sure if we reach you? <a href="<?php echo esc_url( home_url( '/service-area/' ) ); ?>" class="font-semibold text-accent hover:underline">Check the full area</a> or call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( $phone ); ?></a>.</p>
	</div>
</section>

<?php /* =================== TESTIMONIALS ==================== */ ?>
<?php
$tests = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $tests->have_posts() ) : ?>
	<section class="border-t border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal><span class="eyebrow">Reviews</span><h2 class="mt-4 text-3xl sm:text-4xl">What neighbors say</h2></div>
			<div class="mt-12 grid gap-6 md:grid-cols-3">
				<?php while ( $tests->have_posts() ) : $tests->the_post();
					$author = get_field( 'author_name' ); $role = get_field( 'author_role' );
					$quote = get_field( 'quote' ); $stars = (int) get_field( 'rating' ); ?>
					<figure class="card flex flex-col p-6" data-reveal>
						<?php if ( $stars ) : ?><span class="flex gap-0.5 text-accent"><?php for ( $s = 0; $s < $stars; $s++ ) { echo sdp_icon( 'star', 'h-4 w-4 fill-current' ); } ?></span><?php endif; ?>
						<blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink">“<?php echo esc_html( $quote ); ?>”</blockquote>
						<figcaption class="mt-5 text-sm"><span class="font-semibold"><?php echo esc_html( $author ); ?></span><?php if ( $role ) : ?><span class="text-muted"> · <?php echo esc_html( $role ); ?></span><?php endif; ?></figcaption>
					</figure>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
```

- [ ] **Step 4: Rebuild assets** (Bento spans/new utility classes must be compiled)

Run:
```
wsl -d Ubuntu -- bash -lc 'bash /home/cody/workspace/sandbox/aplusinsulation/bin/build.sh'
```
Expected: build succeeds.

- [ ] **Step 5: Verify the home page sections render**

Run:
```
wsl -d Ubuntu -- bash -lc 'H=$(curl -s http://localhost:8090/); for s in "What we do" "Comfort you feel" "Serving Marianna" "What neighbors say" "Request a Free Estimate"; do echo "$H" | grep -oq "$s" && echo "OK: $s" || echo "MISSING: $s"; done'
```
Expected: five `OK:` lines. Then screenshot `http://localhost:8090/` (chrome-devtools MCP) and confirm the Bento grid + green/clay look; check the console has no errors.

- [ ] **Step 6: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: build home page (hero, trust bar, bento services, why-insulation, area, testimonials, CTA)"'
```

---

## Task 7: Interior pages — shared hero, Services, About

**Files:**
- Create: `theme/template-parts/page-hero.php`, `theme/page-services.php`, `theme/page-about.php`

**Interfaces:**
- Consumes: `service` CPT; `sdp_setting`; `sdp_icon`; `cta-band` part; `the_content()` for About body.
- Produces: `template-parts/page-hero.php` accepting `set_query_var( 'hero', array( 'eyebrow'=>, 'title'=>, 'lead'=> ) )`.

- [ ] **Step 1: Create `theme/template-parts/page-hero.php`**
```php
<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$h = get_query_var( 'hero', array() );
$eyebrow = isset( $h['eyebrow'] ) ? $h['eyebrow'] : '';
$title   = isset( $h['title'] ) ? $h['title'] : get_the_title();
$lead    = isset( $h['lead'] ) ? $h['lead'] : '';
?>
<section class="border-b border-line px-5 pb-14 pt-36 lg:px-8 lg:pt-44">
	<div class="mx-auto max-w-4xl">
		<?php if ( $eyebrow ) : ?><span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
		<h1 class="mt-4 text-4xl leading-tight sm:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h1>
		<?php if ( $lead ) : ?><p class="mt-5 max-w-2xl text-lg text-muted" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	</div>
</section>
```

- [ ] **Step 2: Create `theme/page-services.php`**
```php
<?php
/** Services page — lists every service with application areas. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Services', 'title' => 'Insulation services for every part of your home', 'lead' => 'From spray foam to blown-in, removal to replacement — no job too big or too small.' ) );
get_template_part( 'template-parts/page-hero' );

$applications = 'Attic · Ceilings · Interior & exterior walls · Floors · Crawlspace · Garage · Roof deck';
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$svc_icons = array( 'shield', 'wind', 'layers', 'sun', 'recycle', 'home' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto max-w-5xl">
		<div class="grid gap-6 md:grid-cols-2">
			<?php $i = 0; while ( $services->have_posts() ) : $services->the_post();
				$summary = get_field( 'summary' ); $icon = $svc_icons[ $i % count( $svc_icons ) ]; $i++; ?>
				<article class="card p-7" data-reveal>
					<span class="flex h-11 w-11 items-center justify-center rounded bg-accent/10 text-accent"><?php echo sdp_icon( $icon, 'h-5 w-5' ); ?></span>
					<h2 class="mt-4 text-xl font-bold"><?php the_title(); ?></h2>
					<?php if ( $summary ) : ?><p class="mt-2 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
		<div class="mt-10 rounded border border-line bg-surface p-6 text-sm text-muted" data-reveal>
			<span class="font-semibold text-ink">Where we insulate:</span> <?php echo esc_html( $applications ); ?>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
```

- [ ] **Step 3: Create `theme/page-about.php`**
```php
<?php
/** About page — story + values, then the page body, then CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'About', 'title' => 'Local, family-run, insulating Jackson County since 2006', 'lead' => 'A Plus Insulation has spent nearly two decades keeping Marianna-area homes comfortable and efficient — one honest job at a time.' ) );
get_template_part( 'template-parts/page-hero' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-5xl gap-12 lg:grid-cols-3">
		<div class="lg:col-span-2 prose-sdp" data-reveal>
			<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
		</div>
		<aside class="space-y-4" data-reveal>
			<?php
			$vals = array(
				array( 'i' => 'shield', 't' => 'Licensed & insured', 'd' => 'Fully covered so you never carry the risk.' ),
				array( 'i' => 'home',   't' => 'No job too big or too small', 'd' => 'From a single attic to a whole rebuild.' ),
				array( 'i' => 'leaf',   't' => 'Efficiency first', 'd' => 'Right materials, right R-value for our climate.' ),
			);
			foreach ( $vals as $v ) : ?>
				<div class="card p-5">
					<span class="text-accent"><?php echo sdp_icon( $v['i'], 'h-6 w-6' ); ?></span>
					<h3 class="mt-3 font-bold"><?php echo esc_html( $v['t'] ); ?></h3>
					<p class="mt-1 text-sm text-muted"><?php echo esc_html( $v['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</aside>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
```

- [ ] **Step 4: Give the About page body copy** (so `the_content()` isn't empty)

Run:
```
wsl -d Ubuntu -- bash -lc 'docker compose -f /home/cody/workspace/sandbox/aplusinsulation/docker-compose.yml exec -T -e HTTP_HOST=localhost cli wp post update $(docker compose -f /home/cody/workspace/sandbox/aplusinsulation/docker-compose.yml exec -T -e HTTP_HOST=localhost cli wp post list --post_type=page --name=about --field=ID </dev/null | head -1) --post_content="<p>A Plus Insulation is a family-owned insulation contractor based in Marianna, Florida. Since 2006 we have helped homeowners and builders across Jackson County and the Panhandle make their homes more comfortable and far more efficient.</p><p>We install every major type of insulation — spray foam, blown-in, batt and roll, and radiant barrier — and we handle removal and replacement of old or damaged material. Whatever the project, we show up on time, do clean work, and stand behind it.</p>" </dev/null'
```
Expected: `Success: Updated post <id>.`

- [ ] **Step 5: Verify both pages**

Run:
```
wsl -d Ubuntu -- bash -lc 'curl -s http://localhost:8090/services/ | grep -oq "Where we insulate" && curl -s http://localhost:8090/about/ | grep -oq "family-owned insulation contractor" && echo PAGES_OK'
```
Expected: `PAGES_OK`. Screenshot both pages (chrome-devtools MCP).

- [ ] **Step 6: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: Services and About page templates + shared page hero"'
```

---

## Task 8: Interior pages — Service Area and Contact (quote form)

**Files:**
- Create: `theme/page-service-area.php`, `theme/page-contact.php`

**Interfaces:**
- Consumes: `sdp_setting` (maps_url, phone, email, address), `sdp_hours`, `sdp_icon`; Alpine.js (already loaded) for the form success state.
- Produces: the last two pages; the contact form is demo-only (client-side success, no backend).

- [ ] **Step 1: Create `theme/page-service-area.php`**
```php
<?php
/** Service Area page — town list + map + CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Service Area', 'title' => 'Proudly serving Marianna & Jackson County', 'lead' => 'Based on Hwy 90 in Marianna, we cover the surrounding Florida Panhandle. If your town is nearby and not listed, just call.' ) );
get_template_part( 'template-parts/page-hero' );
$area = array( 'Marianna', 'Sneads', 'Graceville', 'Chipley', 'Alford', 'Bonifay', 'Cottondale', 'Grand Ridge', 'Malone', 'Cypress', 'Greenwood', 'Campbellton' );
$maps = sdp_setting( 'maps_url' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:gap-16">
		<div data-reveal>
			<h2 class="text-2xl font-bold">Towns we cover</h2>
			<div class="mt-6 flex flex-wrap gap-3">
				<?php foreach ( $area as $town ) : ?>
					<span class="inline-flex items-center gap-2 rounded border border-line bg-surface px-4 py-2 text-sm font-medium"><span class="text-accent"><?php echo sdp_icon( 'pin', 'h-4 w-4' ); ?></span><?php echo esc_html( $town ); ?></span>
				<?php endforeach; ?>
			</div>
			<p class="mt-8 text-sm text-muted">Serving all of Jackson County and the surrounding Panhandle. Call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( sdp_setting( 'phone' ) ); ?></a> to confirm your address.</p>
		</div>
		<div class="overflow-hidden rounded border border-line" data-reveal>
			<iframe title="Service area map" width="100%" height="380" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Marianna,+FL+32446&output=embed"></iframe>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
```

- [ ] **Step 2: Create `theme/page-contact.php`** (Alpine handles the demo success state)
```php
<?php
/** Contact page — quote form (demo-only) + NAP + hours + map. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Contact', 'title' => 'Request your free estimate', 'lead' => 'Tell us about your project and we\'ll get right back to you. Prefer to talk? Call us during business hours.' ) );
get_template_part( 'template-parts/page-hero' );
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-5 lg:gap-16">
		<div class="lg:col-span-3" data-reveal>
			<form class="card p-7" x-data="{ sent: false }" @submit.prevent="sent = true">
				<div x-show="!sent" class="grid gap-5">
					<div class="grid gap-5 sm:grid-cols-2">
						<label class="block text-sm"><span class="font-medium">Name</span><input type="text" name="name" required class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
						<label class="block text-sm"><span class="font-medium">Phone</span><input type="tel" name="phone" required class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
					</div>
					<label class="block text-sm"><span class="font-medium">Email</span><input type="email" name="email" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
					<label class="block text-sm"><span class="font-medium">Service needed</span>
						<select name="service" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none">
							<option value="">Not sure yet</option>
							<?php while ( $services->have_posts() ) : $services->the_post(); ?><option><?php the_title(); ?></option><?php endwhile; wp_reset_postdata(); ?>
						</select>
					</label>
					<label class="block text-sm"><span class="font-medium">Project details</span><textarea name="message" rows="4" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></textarea></label>
					<button type="submit" class="btn btn-primary w-full sm:w-auto">Request Free Estimate</button>
					<p class="text-xs text-muted">This is a demo form — submissions aren't delivered yet.</p>
				</div>
				<div x-show="sent" x-cloak class="flex flex-col items-center gap-3 py-10 text-center">
					<span class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent"><?php echo sdp_icon( 'check', 'h-6 w-6' ); ?></span>
					<h2 class="text-xl font-bold">Thanks — request received</h2>
					<p class="max-w-sm text-sm text-muted">In the real site this reaches A Plus Insulation. For now, please call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( sdp_setting( 'phone' ) ); ?></a>.</p>
				</div>
			</form>
		</div>
		<aside class="lg:col-span-2" data-reveal>
			<dl class="space-y-5">
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?><div class="card p-5"><dt class="eyebrow">Call</dt><dd class="mt-2"><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="text-lg font-bold hover:text-accent"><?php echo esc_html( $ph ); ?></a></dd></div><?php endif; ?>
				<?php if ( $a = sdp_setting( 'address' ) ) : ?><div class="card p-5"><dt class="eyebrow">Visit</dt><dd class="mt-2 text-sm not-italic text-muted"><?php echo wp_kses( $a, array( 'br' => array() ) ); ?></dd><?php if ( $m = sdp_setting( 'maps_url' ) ) : ?><a href="<?php echo esc_url( $m ); ?>" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline">Directions <?php echo sdp_icon( 'arrow-up-right', 'h-3.5 w-3.5' ); ?></a><?php endif; ?></div><?php endif; ?>
				<?php if ( sdp_has_hours() ) : ?><div class="card p-5"><dt class="eyebrow">Hours</dt><dd class="mt-2 space-y-1 text-sm"><?php foreach ( sdp_hours() as $r ) : ?><div class="flex justify-between gap-4 text-muted"><span><?php echo esc_html( $r['day'] ); ?></span><span class="stat"><?php echo esc_html( $r['time'] ); ?></span></div><?php endforeach; ?></dd></div><?php endif; ?>
			</dl>
		</aside>
	</div>
</section>
<?php get_footer();
```

- [ ] **Step 3: Verify both pages and the form toggle markup**

Run:
```
wsl -d Ubuntu -- bash -lc 'curl -s http://localhost:8090/service-area/ | grep -oq "Towns we cover" && curl -s http://localhost:8090/contact/ | grep -oq "Request Free Estimate" && curl -s http://localhost:8090/contact/ | grep -oq "x-data=\"{ sent: false }\"" && echo CONTACT_OK'
```
Expected: `CONTACT_OK`. Then in the browser (chrome-devtools MCP) load `/contact/`, click **Request Free Estimate**, and confirm the success panel replaces the form (Alpine).

- [ ] **Step 4: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: Service Area and Contact (demo quote form) page templates"'
```

---

## Task 9: LocalBusiness (InsulationContractor) JSON-LD schema

**Files:**
- Create: `theme/inc/schema.php`
- Modify: `theme/functions.php:63` (module load list)

**Interfaces:**
- Consumes: `sdp_setting` (name via bloginfo, phone, address, url), `sdp_hours`.
- Produces: a single `<script type="application/ld+json">` in `wp_head` on the front page.

- [ ] **Step 1: Create `theme/inc/schema.php`**
```php
<?php
/**
 * LocalBusiness (InsulationContractor) JSON-LD, built from Site Settings.
 * Emitted on the front page so the demo has real, valid local schema even
 * before Rank Math's Local SEO is configured.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', function () {
	if ( ! is_front_page() ) { return; }

	$hours = array();
	$map = array( 'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday' );
	foreach ( sdp_hours() as $i => $row ) {
		if ( $row['closed'] ) { continue; }
		if ( preg_match( '/(\d{1,2}:\d{2}\s*[AP]M).*?(\d{1,2}:\d{2}\s*[AP]M)/i', $row['time'], $m ) ) {
			$hours[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => $row['day'],
				'opens'     => date( 'H:i', strtotime( $m[1] ) ),
				'closes'    => date( 'H:i', strtotime( $m[2] ) ),
			);
		}
	}

	$data = array(
		'@context'   => 'https://schema.org',
		'@type'      => array( 'LocalBusiness', 'HomeAndConstructionBusiness' ),
		'name'       => get_bloginfo( 'name' ),
		'description'=> sdp_setting( 'intro', get_bloginfo( 'description' ) ),
		'url'        => home_url( '/' ),
		'telephone'  => sdp_setting( 'phone' ),
		'foundingDate' => '2006',
		'address'    => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '5319 Hwy 90',
			'addressLocality' => 'Marianna',
			'addressRegion'   => 'FL',
			'postalCode'      => '32446',
			'addressCountry'  => 'US',
		),
		'areaServed' => array( 'Marianna FL', 'Jackson County FL', 'Sneads FL', 'Graceville FL', 'Chipley FL', 'Alford FL', 'Bonifay FL' ),
		'knowsAbout' => array( 'Spray foam insulation', 'Blown-in insulation', 'Batt and roll insulation', 'Radiant barrier', 'Insulation removal', 'Insulation replacement' ),
	);
	if ( $hours ) { $data['openingHoursSpecification'] = $hours; }
	if ( $fb = sdp_setting( 'facebook' ) ) { $data['sameAs'] = array( $fb ); }

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 20 );
```

- [ ] **Step 2: Load the module** — in `theme/functions.php` line 63, add `'schema'` to the array:
```php
foreach ( array( 'icons', 'post-types', 'fields', 'template-helpers', 'security', 'seo', 'schema' ) as $module ) {
```

- [ ] **Step 3: Verify the JSON-LD is present and valid JSON**

Run:
```
wsl -d Ubuntu -- bash -lc 'curl -s http://localhost:8090/ | grep -o "application/ld+json.*</script>" | head -1 | sed "s/application\/ld+json\">//;s/<\/script>//" | python3 -m json.tool >/dev/null && echo SCHEMA_VALID_JSON'
```
Expected: `SCHEMA_VALID_JSON`. (Optionally paste the block into Google's Rich Results Test.)

- [ ] **Step 4: Commit**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation add -A && git -C /home/cody/workspace/sandbox/aplusinsulation -c user.name="Cody Sims" -c user.email="codysims37@gmail.com" commit -q -m "feat: LocalBusiness JSON-LD schema from site settings"'
```

---

## Task 10: Full-site verification and finish

**Files:** none (verification + branch finish)

- [ ] **Step 1: Fresh rebuild from scratch to prove reproducibility**

Run:
```
wsl -d Ubuntu -- bash -lc 'cd /home/cody/workspace/sandbox/aplusinsulation && docker compose down -v && docker compose up -d && bash bin/setup.sh && bash bin/build.sh && bash bin/seed.sh'
```
Expected: all three scripts complete; summary shows `Pages: 5`, `Services: 6`, `Testimonials: 3`, `Settings: 1`.

- [ ] **Step 2: All five pages return 200 with expected content**

Run:
```
wsl -d Ubuntu -- bash -lc 'for p in "" services about service-area contact; do code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8090/$p"); echo "/$p -> $code"; done'
```
Expected: five `200`s.

- [ ] **Step 3: Browser pass (chrome-devtools MCP)** — for each of `/`, `/services/`, `/about/`, `/service-area/`, `/contact/`: load, screenshot desktop + mobile (emulate 390px), confirm no console errors, confirm header click-to-call and CTA visible. On `/contact/`, submit the form and confirm the success panel. Confirm the eco/Swiss look (oat bg, pine-green accents, clay CTA, IBM Plex, sharp corners).

- [ ] **Step 4: Accessibility/quality spot-check** — verify: keyboard focus rings visible; skip-link works; images/icons have appropriate labels; run Lighthouse (chrome-devtools MCP `lighthouse_audit`) on the home page and record SEO + a11y scores (target SEO ≥ 95).

- [ ] **Step 5: Confirm clean git state (only the aplus repo touched)**

Run:
```
wsl -d Ubuntu -- bash -lc 'git -C /home/cody/workspace/sandbox/aplusinsulation status --short && echo --- && git -C /home/cody/workspace/sandbox/aplusinsulation log --oneline && echo --- && git -C /home/cody/workspace/sandbox rev-parse --abbrev-ref HEAD 2>&1'
```
Expected: aplus working tree clean; commit history from Task 1→9; parent `sandbox` still reports unborn `main` (untouched).

- [ ] **Step 6: Finish the branch** — invoke `superpowers:finishing-a-development-branch` to decide merge vs PR. (No GitHub remote yet; default is a local merge of `feat/demo-site` → `main`, or leave the branch for review.)

---

## Self-Review

**Spec coverage:**
- 5 pages (Home/Services/About/Service Area/Contact) → Tasks 3, 6, 7, 8 ✓
- MySQL 8 + port 8090 + theme rename → Task 2 ✓
- Swiss/eco tokens + IBM Plex + Bento → Tasks 4, 6 ✓
- Real business data (NAP, hours, services, testimonials, area) → Task 3 ✓
- Multi-page nav + click-to-call CTA everywhere → Tasks 5, 6 ✓
- Quote form (demo-only success state) → Task 8 ✓
- LocalBusiness schema with real NAP → Task 9 ✓
- Rank Math active; scaffold SEO defers → Task 3 (plugin) + inherited `inc/seo.php` ✓
- Reproducible local run + verification → Task 10 ✓
- Dropped Team/Blog (out of scope) → Task 3 ✓
- `.gitattributes` LF (phantom-diff guard) → already committed (spec task) ✓

**Placeholder scan:** No TBD/TODO; every code step shows full content or an exact line change; every check has an exact command + expected output.

**Type/name consistency:** helper names (`sdp_setting`, `sdp_hours`, `sdp_has_hours`, `sdp_socials`, `sdp_icon`) match the scaffold; ACF keys (`field_ss_*`, `field_service_summary`, `field_service_featured`, `field_t_*`) match `inc/fields.php`; `service` CPT rewrite retargeted to `/service/` so the `/services/` page (Task 3) and its `page-services.php` template (Task 7) don't collide; icon names added in Task 6 (`shield`, `layers`, `wind`, `sun`, `recycle`, `leaf`, `home`, `bolt`) are exactly those referenced by the home, services, about, and service-area templates; `cta-band` and `page-hero` parts are created before the templates that `get_template_part()` them.
