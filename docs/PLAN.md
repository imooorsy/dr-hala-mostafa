# Build plan & checklist

## Assumptions
- No `docs/plugins/*.zip` present → **Secure Custom Fields** (not ACF PRO) and **no Polylang for WooCommerce**; products stay Arabic, shop UI strings are bilingual (documented in README).
- Host LiteSpeed unknown → LiteSpeed Cache skipped (documented).
- Heading font chosen after comparing against frames (see `assets/css/tokens.css`).
- Cart badge from the video is static; ours is live via WooCommerce fragments.

## Checklist
- [x] Read all frames, `docs/DESIGN_NOTES.md`
- [x] Environment: services, WP-CLI, DB, junction, install, Arabic pack, settings
- [x] Plugins installed (`bin/setup.*`)
- [x] Theme skeleton, tokens, fonts, header/footer
- [x] Home, About, Books/shop, Single book, Cart, Empty cart, Checkout
- [x] Research CPT, Blog, Single post, Contact, FAQ, Privacy/Terms, 404/search/account
- [x] Polylang / i18n
- [x] Seed content
- [x] QA screenshots → `docs/QA.md`
- [x] README, .gitignore, DB export, git push

## Notes / assumptions made while building
- `bin/wp.bat` could not be created (the filename was blocked on this machine) → wrapper is `bin/wp.cmd`, and `bin/setup.cmd` replaces `setup.bat`.
- Products are made translatable in Polylang core (separate linked English copies) because *Polylang for WooCommerce* is not available.
- PHP `gd`, `intl`, `zip` extensions were enabled in `C:\xampp\php\php.ini`; an Avast SSL-scanning root certificate was exported to `bin/cacert.pem` (git-ignored) so WP-CLI could download.
- Cart/checkout pages use the classic shortcodes (not WooCommerce blocks) so theme templates apply.
