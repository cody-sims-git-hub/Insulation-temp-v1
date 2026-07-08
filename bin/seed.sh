#!/usr/bin/env bash
# Seed neutral placeholder content so the starter renders end-to-end.
# Reproducible: CPT content is reset each run. Replace this data per client.
# Run from the template root (folder containing docker-compose.yml).
set -uo pipefail
cd "$(dirname "$0")/.."

wp() { docker compose exec -T -e HTTP_HOST=localhost -e WP_CLI_CACHE_DIR=/tmp/.wp-cli cli wp "$@" </dev/null; }
acf() { local id="$1" name="$2" key="$3" val="$4"; wp post meta update "$id" "$name" "$val" >/dev/null; wp post meta update "$id" "_$name" "$key" >/dev/null; }

echo "==> Plugins: ACF (fields) + Rank Math (SEO)"
wp plugin is-installed advanced-custom-fields >/dev/null 2>&1 || wp plugin install advanced-custom-fields >/dev/null
wp plugin activate advanced-custom-fields >/dev/null 2>&1
# Rank Math = the standard SEO plugin (schema, sitemaps, editor guidance). Our
# inc/seo.php auto-defers to it. Per client, run Rank Math's setup wizard in wp-admin.
wp plugin is-installed seo-by-rank-math >/dev/null 2>&1 || wp plugin install seo-by-rank-math >/dev/null
wp plugin activate seo-by-rank-math >/dev/null 2>&1
wp theme activate sdp-starter >/dev/null 2>&1

echo "==> Front + Blog pages"
HOME_ID=$(wp post list --post_type=page --name=home --field=ID 2>/dev/null | head -1)
[ -z "$HOME_ID" ] && HOME_ID=$(wp post create --post_type=page --post_title=Home --post_name=home --post_status=publish --porcelain)
BLOG_ID=$(wp post list --post_type=page --name=blog --field=ID 2>/dev/null | head -1)
[ -z "$BLOG_ID" ] && BLOG_ID=$(wp post create --post_type=page --post_title=Blog --post_name=blog --post_status=publish --porcelain)
wp option update show_on_front page >/dev/null
wp option update page_on_front "$HOME_ID" >/dev/null
wp option update page_for_posts "$BLOG_ID" >/dev/null

echo "==> Reset CPT content"
for pt in team service testimonial sitesettings; do
  ids=$(wp post list --post_type=$pt --format=ids --posts_per_page=-1 2>/dev/null)
  [ -n "$ids" ] && wp post delete $ids --force >/dev/null
done

echo "==> Site Settings"
SS=$(wp post create --post_type=sitesettings --post_title="Site Settings" --post_status=publish --porcelain)
acf "$SS" tagline    field_ss_tagline    "Modern solutions for growing businesses"
acf "$SS" intro      field_ss_intro      "We help small businesses build a professional online presence — clean design, easy-to-edit content, and the tools to keep it running."
acf "$SS" cta_label  field_ss_cta_label  "Get in touch"
acf "$SS" phone      field_ss_phone      "(555) 123-4567"
acf "$SS" phone_href field_ss_phone_href "+15551234567"
acf "$SS" email      field_ss_email      "hello@example.com"
acf "$SS" address    field_ss_address    $'123 Main Street\nAnytown, ST 00000'
acf "$SS" maps_url   field_ss_maps_url   "https://maps.google.com/?q=123+Main+Street"
acf "$SS" instagram  field_ss_instagram  "https://instagram.com/"
acf "$SS" linkedin   field_ss_linkedin   "https://linkedin.com/"
acf "$SS" hours_mon  field_ss_mon        "9:00 AM – 5:00 PM"
acf "$SS" hours_tue  field_ss_tue        "9:00 AM – 5:00 PM"
acf "$SS" hours_wed  field_ss_wed        "9:00 AM – 5:00 PM"
acf "$SS" hours_thu  field_ss_thu        "9:00 AM – 5:00 PM"
acf "$SS" hours_fri  field_ss_fri        "9:00 AM – 5:00 PM"
acf "$SS" hours_sat  field_ss_sat        "10:00 AM – 2:00 PM"
acf "$SS" hours_sun  field_ss_sun        "Closed"

echo "==> Team"
team() { local id; id=$(wp post create --post_type=team --post_title="$1" --post_status=publish --menu_order="$4" --porcelain); acf "$id" role field_team_role "$2"; acf "$id" bio field_team_bio "$3"; }
team "Alex Morgan"  "Founder & Principal" "Sets the direction and works directly with every client from first call to launch." 1
team "Sam Rivera"   "Design Lead"         "Turns brand and goals into clean, usable interfaces people actually enjoy." 2
team "Jordan Lee"   "Developer"           "Builds fast, reliable sites and the integrations that keep them humming." 3
team "Casey Kim"    "Client Success"      "Keeps projects on track and makes sure every site keeps performing after launch." 4

echo "==> Services"
svc() { local id; id=$(wp post create --post_type=service --post_title="$1" --post_status=publish --menu_order="$5" --porcelain); acf "$id" summary field_service_summary "$2"; acf "$id" price field_service_price "$3"; acf "$id" featured field_service_featured "$4"; }
svc "Web Design"       "Distinctive, responsive design tailored to your brand — not a template." "From \$1,500"  1 1
svc "Development"      "Fast, secure, custom-built sites and web apps on a modern stack."          "From \$2,500"  1 2
svc "SEO & Content"    "Technical SEO and helpful content that earns rankings and trust."          "From \$500/mo" 0 3
svc "Care & Hosting"   "Managed updates, backups, security and monitoring so you never worry."     "From \$99/mo"  0 4

echo "==> Testimonials"
tst() { local id; id=$(wp post create --post_type=testimonial --post_title="$1" --post_status=publish --menu_order="$5" --porcelain); acf "$id" author_name field_t_author "$1"; acf "$id" author_role field_t_role "$2"; acf "$id" rating field_t_rating "$3"; acf "$id" quote field_t_quote "$4"; }
tst "Taylor B."  "Owner, Bright Co."      5 "They rebuilt our site in weeks and we can finally update it ourselves. Leads are up and it just looks professional now." 1
tst "Morgan P."  "Director, NorthStar"    5 "Clear communication, sharp design, and no surprises. The handoff was painless — our team edits content without any help." 2
tst "Jamie R."   "Founder, Lumen Studio"  5 "Exactly the balance we wanted: a custom look with a simple CMS. Highly recommend for any small business." 3

echo "==> Blog posts"
wp term get category insights >/dev/null 2>&1 || wp term create category "Insights" >/dev/null 2>&1
post() { local existing; existing=$(wp post list --post_type=post --s="$1" --field=ID 2>/dev/null | head -1); [ -n "$existing" ] && return; local id; id=$(wp post create --post_type=post --post_title="$1" --post_excerpt="$2" --post_content="$3" --post_status=publish --porcelain); wp post term set "$id" category insights >/dev/null 2>&1; }
post "Why your small business needs a real content strategy" "A website is only as good as what's on it. Here's where to start." "<p>Most small-business sites launch strong then go stale. A light content rhythm — one useful post a month — keeps you visible and builds trust.</p><h2>Start with questions you already answer</h2><p>Every question a customer asks by phone is a potential page. Write it down once, publish it, and let it work for you around the clock.</p>"
post "Own your website: why a CMS beats a locked-down build" "Editing your own content shouldn't require a developer." "<p>A good CMS puts you in control of the words and images without touching the design. You update; the layout stays intact.</p><h2>Structure beats a blank canvas</h2><p>Instead of a page builder you can accidentally break, structured fields keep edits safe and the design consistent.</p>"

echo "==> Flush + done"
wp rewrite flush --hard >/dev/null 2>&1
echo "Team:         $(wp post list --post_type=team --format=count)"
echo "Services:     $(wp post list --post_type=service --format=count)"
echo "Testimonials: $(wp post list --post_type=testimonial --format=count)"
echo "Posts:        $(wp post list --post_type=post --format=count)"
echo "Settings:     $(wp post list --post_type=sitesettings --format=count)"
