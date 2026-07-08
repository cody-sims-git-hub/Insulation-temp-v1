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
# Rank Math is installed (ready for production: sitemaps, config wizard) but left
# DEACTIVATED for the demo. Un-configured Rank Math renders no frontend meta and
# suppresses the theme's inc/seo.php; deactivating lets the theme baseline emit a
# real meta description + OpenGraph on every page. Activate + run the wizard for prod.
wp plugin is-installed seo-by-rank-math >/dev/null 2>&1 || wp plugin install seo-by-rank-math >/dev/null
wp plugin deactivate seo-by-rank-math >/dev/null 2>&1
wp theme activate aplus-insulation >/dev/null 2>&1

echo "==> Pages (home + 4 interior)"
page() { # slug title
  local id; id=$(wp post list --post_type=page --name="$1" --field=ID 2>/dev/null | head -1)
  [ -z "$id" ] && id=$(wp post create --post_type=page --post_title="$2" --post_name="$1" --post_status=publish --porcelain)
  echo "$id"
}
HOME_ID=$(page home "Home")
SERVICES_ID=$(page services "Services")
ABOUT_ID=$(page about "About")
AREA_ID=$(page service-area "Service Area")
CONTACT_ID=$(page contact "Contact")
wp post update "$ABOUT_ID" --post_status=publish --post_content='<p>A Plus Insulation is a family-owned insulation contractor based in Marianna, Florida. Since 2006 we have helped homeowners and builders across Jackson County and the Panhandle make their homes more comfortable and far more efficient.</p><p>We install every major type of insulation — spray foam, blown-in, batt and roll, and radiant barrier — and we handle removal and replacement of old or damaged material. Whatever the project, we show up on time, do clean work, and stand behind it.</p>' >/dev/null
wp option update show_on_front page >/dev/null
wp option update page_on_front "$HOME_ID" >/dev/null
wp option update page_for_posts 0 >/dev/null
wp option update blogname "A Plus Insulation" >/dev/null
wp option update blogdescription "Insulation Contractor in Marianna, FL" >/dev/null

echo "==> Keep only the 5 target pages (drop WP defaults: sample page, privacy policy)"
wp option update wp_page_for_privacy_policy 0 >/dev/null 2>&1
for pid in $(wp post list --post_type=page --post_status=any --field=ID 2>/dev/null); do
  nm=$(wp post get "$pid" --field=post_name 2>/dev/null)
  case "$nm" in
    home|services|about|service-area|contact) : ;;
    *) wp post delete "$pid" --force >/dev/null 2>&1 ;;
  esac
done

echo "==> Reset CPT content"
for pt in team service testimonial sitesettings; do
  ids=$(wp post list --post_type=$pt --format=ids --posts_per_page=-1 2>/dev/null)
  [ -n "$ids" ] && wp post delete $ids --force >/dev/null
done

echo "==> Site Settings"
SS=$(wp post create --post_type=sitesettings --post_title="Site Settings" --post_status=publish --porcelain)
acf "$SS" tagline    field_ss_tagline    "A warmer, cooler, more efficient home"
acf "$SS" intro      field_ss_intro      "Spray foam, blown-in & batt insulation for Jackson County homes. A Plus Insulation in Marianna, FL — free estimates. Call (850) 209-2636."
acf "$SS" cta_url    field_ss_cta_url    "/contact/"
acf "$SS" cta_label  field_ss_cta_label  "Get My Free Estimate"
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

echo "==> Per-page SEO excerpts (theme inc/seo.php uses these for meta description + OG)"
wp post update "$SERVICES_ID" --post_excerpt="Attic insulation services in Marianna, FL: spray foam, blown-in, batt & roll, radiant barrier, removal & replacement. Free estimates in Jackson County." >/dev/null 2>&1
wp post update "$ABOUT_ID"    --post_excerpt="Local, family-run insulation contractor in Marianna, FL. Licensed & insured, serving Jackson County homeowners with honest work and fair prices." >/dev/null 2>&1
wp post update "$AREA_ID"     --post_excerpt="A Plus Insulation serves Marianna, Sneads, Graceville, Chipley, Bonifay, Cottondale, Grand Ridge, Malone & the NW Florida Panhandle. Free estimates." >/dev/null 2>&1
wp post update "$CONTACT_ID"  --post_excerpt="Get a free insulation estimate in Marianna, FL. Call A Plus Insulation at (850) 209-2636 or send a message — we serve all of Jackson County." >/dev/null 2>&1

echo "==> Flush + summary"
wp rewrite structure "/%postname%/" --hard >/dev/null 2>&1
wp rewrite flush --hard >/dev/null 2>&1
echo "Pages:        $(wp post list --post_type=page --format=count)"
echo "Services:     $(wp post list --post_type=service --format=count)"
echo "Testimonials: $(wp post list --post_type=testimonial --format=count)"
echo "Settings:     $(wp post list --post_type=sitesettings --format=count)"
