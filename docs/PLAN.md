# Build plan & checklist

## Assumptions
- No `docs/plugins/*.zip` present → **Secure Custom Fields** (not ACF PRO) and **no Polylang for WooCommerce**; products stay Arabic, shop UI strings are bilingual (documented in README).
- Host LiteSpeed unknown → LiteSpeed Cache skipped (documented).
- Heading font chosen after comparing against frames (see `assets/css/tokens.css`).
- Cart badge from the video is static; ours is live via WooCommerce fragments.

## Checklist
- [x] Read all frames, `docs/DESIGN_NOTES.md`
- [ ] Environment: services, WP-CLI, DB, junction, install, Arabic pack, settings
- [ ] Plugins installed (`bin/setup.*`)
- [ ] Theme skeleton, tokens, fonts, header/footer
- [ ] Home, About, Books/shop, Single book, Cart, Empty cart, Checkout
- [ ] Research CPT, Blog, Single post, Contact, FAQ, Privacy/Terms, 404/search/account
- [ ] Polylang / i18n
- [ ] Seed content
- [ ] QA screenshots → `docs/QA.md`
- [ ] README, .gitignore, DB export, git push
