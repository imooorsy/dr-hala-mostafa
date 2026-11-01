#!/usr/bin/env bash
# Recreate the whole site from a fresh clone (WordPress core already extracted in the project root).
# Windows/XAMPP: run from Git Bash:   WP=bin/wp.cmd bash bin/setup.sh
# Linux/macOS:                         WP=wp bash bin/setup.sh
# Pre-requisites: MySQL running, empty database "dr_hala" (utf8mb4), plugin zips optional in docs/plugins/.
set -euo pipefail
WP="${WP:-wp}"
URL="${SITE_URL:-http://localhost/dr-hala-mostafa}"
DB_NAME="${DB_NAME:-dr_hala}"; DB_USER="${DB_USER:-root}"; DB_PASS="${DB_PASS:-}"
ADMIN_USER="${ADMIN_USER:-hala_admin}"; ADMIN_EMAIL="${ADMIN_EMAIL:-admin@example.com}"
ADMIN_PASS="${ADMIN_PASS:-$(head -c 12 /dev/urandom | base64 | tr -d '/+=')}"

[ -f wp-config.php ] || $WP config create --dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" --dbcharset=utf8mb4 --skip-check --extra-php <<'PHP'
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'DISALLOW_FILE_EDIT', true );
PHP
$WP core is-installed 2>/dev/null || {
  $WP core install --url="$URL" --title="Dr. Hala Mostafa" --admin_user="$ADMIN_USER" --admin_password="$ADMIN_PASS" --admin_email="$ADMIN_EMAIL" --skip-email
  mkdir -p docs && printf '# Local credentials (git-ignored)\n\n- URL: %s\n- User: %s\n- Password: %s\n' "$URL" "$ADMIN_USER" "$ADMIN_PASS" > docs/LOCAL_CREDENTIALS.md
}
$WP language core install ar --activate
$WP option update timezone_string Africa/Cairo
$WP rewrite structure '/%postname%/' --hard
$WP option update default_comment_status closed

# --- Plugins -----------------------------------------------------------------
# Custom fields: ACF PRO zip if provided, otherwise Secure Custom Fields (free)
if ls docs/plugins/advanced-custom-fields-pro*.zip >/dev/null 2>&1; then $WP plugin install docs/plugins/advanced-custom-fields-pro*.zip --activate; else $WP plugin install secure-custom-fields --activate; fi
$WP plugin install polylang woocommerce wp-mail-smtp seo-by-rank-math webp-converter-for-media updraftplus --activate
# Polylang for WooCommerce add-on (paid) if the zip is provided
ls docs/plugins/polylang-for-woocommerce*.zip >/dev/null 2>&1 && $WP plugin install docs/plugins/polylang-for-woocommerce*.zip --activate || true
# Wordfence is installed but left inactive locally (activate on production)
$WP plugin install wordfence
# LiteSpeed Cache: only on LiteSpeed hosts -> $WP plugin install litespeed-cache --activate

# --- Theme, languages, content ------------------------------------------------
$WP theme activate hala
$WP eval-file bin/polylang-setup.php
$WP option update woocommerce_currency EGP
$WP option update woocommerce_default_country EG:C
$WP option update woocommerce_allowed_countries specific
$WP option update woocommerce_specific_allowed_countries '["EG"]' --format=json
$WP option update woocommerce_price_num_decimals 0
$WP option update woocommerce_currency_pos right_space
$WP eval-file bin/polylang-setup.php   # second pass registers product CPT/taxonomy after WooCommerce is active
$WP eval-file bin/seed.php
$WP rewrite flush --hard
echo "Done. Open $URL  (credentials in docs/LOCAL_CREDENTIALS.md)"
