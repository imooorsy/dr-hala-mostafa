#!/usr/bin/env bash
# Export a sanitised database dump to database/dr_hala.sql (admin e-mail and password hash replaced).
# Usage:  WP=bin/wp.cmd PHP_BIN=/c/xampp/php/php.exe bash bin/export-db.sh     (XAMPP / Git Bash)
#         bash bin/export-db.sh                                                (Linux/macOS with wp + php on PATH)
set -euo pipefail
WP="${WP:-wp}"
PHP_BIN="${PHP_BIN:-php}"
[ -d /c/xampp/mysql/bin ] && export PATH="$PATH:/c/xampp/mysql/bin"   # mysqldump on XAMPP/Windows
mkdir -p database
$WP db query "TRUNCATE TABLE wp_woocommerce_sessions" >/dev/null 2>&1 || true
$WP transient delete --all >/dev/null 2>&1 || true
$WP db export database/dr_hala.raw.sql --default-character-set=utf8mb4
"$PHP_BIN" bin/sanitize-sql.php database/dr_hala.raw.sql database/dr_hala.sql
