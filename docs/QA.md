# QA report

Method: pages rendered with headless Edge at 1234×800 (the video's viewport) and compared with the matching `docs/reference/frame_NN.jpg`; helper `bin/screenshot.sh`. Responsive/overflow check: every key page loaded in iframes at 375, 768, 1234 and 1440 px (RTL + LTR) and `scrollWidth` compared with the viewport — **no horizontal overflow on any page**. `WP_DEBUG` on: `wp-content/debug.log` stays empty while browsing all pages (PHP lint also clean on every file).

## Frame-by-frame comparison

| Page | Reference frames | Result | Remaining differences |
|---|---|---|---|
| Header / footer | all | Matches: logo + 4-item menu on the right, CTA pill + cart pill (live count) on the left, gold rounded footer, 3 columns with underlines, translucent bottom bar with language switcher | We add a compact "EN" switch in the header |
| Home – hero | 1 | Matches: portrait card with caption pill, eyebrow, 2-line H1 with highlighted words, two actions | Headline weight is El Messiri (closest free font to the video's display face) |
| Home – expertise | 2 | Matches: intro column + stacked cards with coloured edge strip and pink bullets | – |
| Home – books carousel | 3 | Matches: 4 cards, badge, title, excerpt, "المزيد من التفاصيل", arrows + progress bar | Covers are generated placeholders |
| Home – research | 4 | Matches: 2-column cards, journal in serif burgundy, chip button | Syringe illustration omitted (client asset) |
| Home – articles / vision | 5, 6 | Matches structure; vision panel with portrait and white pill | Vision portrait is the hero crop (floral-hijab photo needed) |
| Books archive | 7–10 | Matches: burgundy hero with curved bottom, search, fanned covers, tabs, 4-col grid, pagination, newsletter | Pagination appears only when >8 books |
| Single book | 11–17 | Matches: pink hero, cover, price, stepper, add-to-cart pill, bullets, "ماذا ستجدين…", burgundy "why" panel, FAQ accordion, related carousel, sticky bottom bar | "Why" panel illustration is a placeholder crop |
| Blog | 18–20 | Matches: hero + search, tab bar in burgundy with cream active pill, 3-col image-overlay cards, newsletter | Tile photos are placeholders |
| Single post | 21–23 | Hero image with overlay title, burgundy H2s, glasses CTA, related overlay carousel | – |
| FAQ | 26–28 | Matches: hero with search bar overlapping the curve, accordion with round +/− chip | Hero illustration omitted (client asset) |
| Policies | 29–30, 42–44 | Matches: burgundy band with "last updated", bordered box, sticky burgundy headings beside bullet lists | – |
| Research archive | 31–37 | Matches: hero/search, eyebrow + highlighted title, 2-col cards, pagination | – |
| Contact | 38–40 | Matches: burgundy form panel, email + WhatsApp cards with arrows, "كما يمكنكم متابعتنا" 3+2 cards | Country select uses a native control (flag emoji depends on OS) |
| Cart | 44–45 | Matches closely: gold title bar, product/total table, stepper, trash, sidebar with coupon toggle, total and pill | – |
| Checkout | 46–47 | Matches: gold bar, 2-col fields, governorate select, address, radio payment rows, "المتابعة للدفع" | Phone has no flag prefix (placeholder only) |
| Empty cart | 48 | Matches: gold bar, cart illustration, text, pill | – |

## Functional checks
- Add to cart (single page and `?add-to-cart=`), +/− stepper auto-updates the cart via WooCommerce AJAX, coupon box, checkout with Cash on delivery and the custom e-wallet gateway.
- AJAX category filter + pagination (books, blog) via `admin-ajax` with nonce; links still work without JS.
- Contact form: nonce, honeypot, time trap, per-IP rate limit; message saved to `hala_message` and e-mailed via `wp_mail`. Newsletter saves to `hala_subscriber` (duplicates collapse). Verified with invalid nonce and honeypot.
- Polylang: `/` (Arabic, RTL) and `/en/` (English, LTR, arrows mirrored), menus, cart/checkout/account pages translated, products/research/posts linked as translations.
- Accessibility: skip link, landmarks, focus-visible outlines, keyboard-operable accordion/tabs/carousels (native buttons/links, arrow keys on carousel), `aria-live` form messages, alt text, reduced-motion support.

## Known gaps / assumptions
- 3D illustrations and photos are crops of the video frames (see README → assets needed).
- Without the paid *Polylang for WooCommerce* add-on, English products are separate linked copies; price/stock edits must be mirrored by hand.
- E-mail delivery needs SMTP configured (WP Mail SMTP is installed but unconfigured).
