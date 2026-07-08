#!/usr/bin/env bash
# Install WordPress + activate the A Plus Insulation theme. Safe to re-run.
# Run from the template root (the folder containing docker-compose.yml).
set -uo pipefail
cd "$(dirname "$0")/.."

wp() { docker compose exec -T -e HTTP_HOST=localhost -e WP_CLI_CACHE_DIR=/tmp/.wp-cli cli wp "$@" </dev/null; }

echo "==> waiting for core files"
for i in $(seq 1 30); do
  if docker compose exec -T cli test -f /var/www/html/wp-load.php </dev/null 2>/dev/null; then echo "    core present"; break; fi
  sleep 2
done

if wp core is-installed 2>/dev/null; then
  echo "==> already installed"
else
  wp core install \
    --url="http://localhost:8090" \
    --title="A Plus Insulation" \
    --admin_user="admin" \
    --admin_password="admin" \
    --admin_email="dev@simsdigitalpartners.com" \
    --skip-email
fi

wp theme activate aplus-insulation
wp rewrite structure "/%postname%/" --hard >/dev/null
echo "==> done — http://localhost:8090  (admin/admin)"
