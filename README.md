# Dr. Hala Mostafa Gomaa — website

Bilingual (Arabic RTL default / English LTR) WordPress site for Prof. Dr. Hala Mostafa Gomaa (Cairo University): author pages, research, blog and an online book shop for Egypt.

## Stack (and why)
| Piece | Choice | Why |
|---|---|---|
| Theme | Custom classic PHP theme `wp-content/themes/hala` — **no page builder** | Light, fast, fully version-controlled; plain CSS + vanilla JS, no jQuery in theme code |
| Fields | **Secure Custom Fields** (free ACF fork; ACF PRO is used automatically if you drop its zip into `docs/plugins/`) | Repeaters/options pages without a licence. Field groups live in PHP (`inc/acf/`), JSON sync folder `acf-json/` |
| Languages | **Polylang** (+ *Polylang for WooCommerce* if you own it) | Arabic default, English `/en/` |
| Shop | WooCommerce, EGP, Egypt only, Cash on delivery + custom e-wallet gateway (`inc/woocommerce/class-gateway-ewallet.php`) | |
| Other | WP Mail SMTP, Rank Math SEO, Converter for Media (WebP), UpdraftPlus, Wordfence (installed, inactive locally) | |

Design tokens are in `assets/css/tokens.css`; fonts (El Messiri, Cairo, Playfair Display, Inter) are self-hosted in `assets/fonts/`.
Design analysis of the reference video: `docs/DESIGN_NOTES.md`; QA results: `docs/QA.md`; plan/assumptions: `docs/PLAN.md`.

## Local setup from a fresh clone (Windows + XAMPP)
1. Start **Apache** and **MySQL** in XAMPP. Create an empty database: `CREATE DATABASE dr_hala CHARACTER SET utf8mb4;`
2. Clone this repo **into** a folder and extract WordPress core into it (download from wordpress.org; the repo ignores core files). Path used here: `D:\Programming\Projects\Wordpress\dr-hala-mostafa`.
3. Make it reachable at `http://localhost/dr-hala-mostafa` (no admin rights needed):
   `mklink /J C:\xampp\htdocs\dr-hala-mostafa D:\Programming\Projects\Wordpress\dr-hala-mostafa`
   Enable `gd`, `intl`, `zip` in `C:\xampp\php\php.ini` and make sure `.htaccess` exists (the file in the repo root is git-ignored; a standard WordPress rewrite block with `RewriteBase /dr-hala-mostafa/` works).
4. Download WP-CLI to `bin/wp-cli.phar` (`https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar`). `bin/wp.cmd` wraps it with XAMPP's PHP. *(Behind an SSL-scanning antivirus, also put its root certificate in `bin/cacert.pem`; see `bin/local-ssl.php`.)*
5. From Git Bash in the project folder: `WP=bin/wp.cmd bash bin/setup.sh` (or `bin\setup.cmd`). It creates `wp-config.php`, installs WordPress + Arabic, installs/activates all plugins, activates the theme, configures Polylang/WooCommerce and seeds demo content (`bin/seed.php`, idempotent). The admin password is generated and written to `docs/LOCAL_CREDENTIALS.md` (git-ignored).
6. Alternative to seeding: import `database/dr_hala.sql` (sanitised; reset the admin password with `wp user update 1 --user_pass=...`), then `wp eval-file bin/seed.php` to restore the placeholder media files.

Useful: `php bin/make-pot.php` regenerates `languages/hala.pot` + `ar.po`; `bin/export-db.sh` re-exports the sanitised dump; `bin/screenshot.sh <url> <png> [w] [h]` takes headless screenshots.

## Plugins
Free: Secure Custom Fields, Polylang, WooCommerce, WP Mail SMTP, Rank Math SEO, Converter for Media, UpdraftPlus, Wordfence. **Paid / optional:** ACF PRO, Polylang for WooCommerce (not included — LiteSpeed Cache is also skipped; install it only if the host runs LiteSpeed).

## Content editing
- **Home**: Pages → Home → "Home page sections" (every section has an on/off switch; headlines accept `*word*` to highlight in burgundy).
- **Site settings** (admin menu, *per language*): brand, contact e-mail, WhatsApp, social/academic links, footer text, newsletter and book CTAs. Switch language in the admin bar to edit the other one.
- **About / FAQ / Policy / Contact** pages use ACF groups bound to page templates; **Books** use product fields (eyebrow, contents list, highlight panel, FAQ); **Research** is its own post type; **Messages** and **Subscribers** appear in the admin menu.
- **Category colour/badge** (term fields): Medical = burgundy, Literary = gold.

## Translating
Theme strings are English source strings with Arabic in `inc/strings.php` (registered with Polylang → *Languages → Translations*, where any value can be overridden; gettext `.pot/.po` are in `languages/`). Page content, posts, research, products and ACF fields are translated per item (Polylang "+" links). **Products:** without *Polylang for WooCommerce* each English product is a separate, linked copy — mirror price/stock edits manually, or install the add-on to sync them.

## Deploy to production
1. Upload the repo files + WordPress core + plugins (or run `bin/setup.sh` via SSH). Import the database: `wp db import database/dr_hala.sql`.
2. `wp search-replace 'http://localhost/dr-hala-mostafa' 'https://YOUR-DOMAIN' --all-tables`, then set a new admin password and e-mail.
3. Set `WP_ENVIRONMENT_TYPE=production`, `WP_DEBUG=false`; add real salts. Re-run `wp eval-file bin/polylang-setup.php` if languages are missing; flush permalinks.
4. Configure **WP Mail SMTP** (contact form and order e-mails need it), enter the real e-wallet number under WooCommerce → Payments, activate **Wordfence**, set up UpdraftPlus backups, finish Rank Math setup, enable caching (LiteSpeed Cache only on LiteSpeed hosts).
5. Replace every placeholder (see below) and set real profile links in *Site settings*.

## Assets needed from the client
Real portrait photos (hero, vision panel, header avatar), book covers (print-ready JPG/PNG), real product text/prices, 3D illustrations or approved replacements (megaphone/bell, glasses on books, shopping cart, ECMO device, hieroglyph tablet, retro TV/microphone for page heroes, syringe), article images, logo (if different), biography/timeline for the About page, LinkedIn / ResearchGate / ORCID / Cairo University URLs, e-wallet number, real policy texts, SMTP credentials. Everything marked "[نص تجريبي]" / "[Placeholder text]" is demo content. The placeholder images are crops of the reference video in `assets/images/placeholders/`.
