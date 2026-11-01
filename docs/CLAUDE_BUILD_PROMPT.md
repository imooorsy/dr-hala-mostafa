# Build prompt — Dr. Hala Mostafa Gomaa website

> **Before you paste this:**
>
> 1. Close any Claude Code session open on this folder, then rename the folder
>    `D:\Programming\Projects\Wordpress\dr-site` → `D:\Programming\Projects\Wordpress\dr-hala-mostafa`
>    (Windows locks a folder while a session is running inside it, so do this yourself first).
> 2. Create an **empty** GitHub repo named `dr-hala-mostafa` (no README, no .gitignore) and paste its URL below where it says `https://github.com/imooorsy/dr-hala-mostafa.git`.
> 3. If you own licences for **ACF PRO** or **Polylang for WooCommerce**, put the plugin `.zip` files in `docs/plugins/` before starting.
> 4. Open Claude Code in `D:\Programming\Projects\Wordpress\dr-hala-mostafa` and paste everything below the line.

---

You are building a complete, production-ready WordPress website for **Dr. Hala Mostafa Gomaa (د. هالة مصطفى جمعة)**, Professor of Anesthesia at Cairo University, medical author (ECMO, critical care) and writer on literature and medical history. The site must match the design shown in the reference video **as closely as possible**.

## 0. Reference material — study this first

- Video: `docs/WhatsApp Video 2026-10-27 at 12.40.46.mp4` (98 s, tablet viewport ~1234×800, RTL Arabic).
- Screenshots: `docs/reference/frame_01.jpg … frame_49.jpg` (one every 2 seconds, in order).
- **Read every screenshot before writing any code.** Make a page and section inventory in `docs/DESIGN_NOTES.md` that names each section, its layout, its components and the frames it appears in.
- If you need a closer look at a moment, extract more frames with ffmpeg (it is installed), e.g. `ffmpeg -ss 00:00:41 -i "<video>" -frames:v 1 docs/reference/extra_41s.jpg`.

## 1. Architecture decision (already made — do not use a page builder)

- **Custom classic PHP theme** named `hala` (folder `wp-content/themes/hala`), **no Elementor, no page builders**, no Gutenberg-heavy layouts. Each template is hand-written PHP + CSS + vanilla JS.
- **Custom fields:** ACF PRO if the zip is in `docs/plugins/`, otherwise **Secure Custom Fields** (free on wordpress.org, includes Repeater, Flexible Content and Options Pages). Register all field groups **in PHP** (`acf_add_local_field_group`) inside `inc/acf/`, so they are version-controlled; also enable ACF JSON sync to `hala/acf-json/`.
- **Multilingual:** **Polylang**, with **Arabic (default, RTL)** and **English (LTR)**.
  - Every hard-coded UI string goes through `pll__()` / `pll_e()`, registered with `pll_register_string()` in `inc/i18n.php`, and the theme is also gettext-ready (text domain `hala`, `.pot` file in `languages/`).
  - Page content and ACF fields are translated per page or per post (each translated page has its own field values). Global settings (social links, phone, WhatsApp, email, footer text) live in an ACF Options Page, stored **per language** (append the Polylang language slug to the options `post_id`).
  - Language switcher in the header and footer (the footer shows "عربي ⌄" in the video).
  - WooCommerce products: use **Polylang for WooCommerce** if its zip is in `docs/plugins/`. Otherwise keep the products in Arabic, make the shop UI strings bilingual, and **write in the README that product translation needs that add-on**.
- **E-commerce:** WooCommerce for the books shop. Override the templates in `hala/woocommerce/` so they match the design.
- Must support `dir="rtl"` / `dir="ltr"` automatically: use CSS logical properties (`margin-inline-start`, `padding-inline`, `inset-inline-end`, etc.) so a single stylesheet works in both directions. Mirror the arrow icons in LTR.

## 2. Environment setup (Windows, XAMPP already installed)

- XAMPP is at `C:\xampp` (PHP 8.2 at `C:\xampp\php\php.exe`, MySQL at `C:\xampp\mysql\bin\mysql.exe`). Start Apache and MySQL (`C:\xampp\apache_start.bat`, `C:\xampp\mysql_start.bat`) if they are not running.
- Install **WP-CLI** locally: download `wp-cli.phar` into `bin/` and create a `bin/wp.bat` wrapper that calls XAMPP's PHP. Use WP-CLI for everything you can.
- **WordPress 7.1.4 is already extracted in the project root** (the project root _is_ the WordPress root). **Do not download core again.** Install the Arabic language pack with `wp language core install ar --activate`, and delete `wordpress-7.1.4.zip` from the root once you've confirmed the files are intact.
- Make it reachable at `http://localhost/dr-hala-mostafa` by creating a directory junction: `mklink /J C:\xampp\htdocs\dr-hala-mostafa D:\Programming\Projects\Wordpress\dr-hala-mostafa`. Do not edit the Windows hosts file or anything else that needs admin rights.
- Create the database `dr_hala` (user `root`, empty password — XAMPP's default), run `wp config create` and `wp core install`. Generate a strong admin password and write it **only** to `docs/LOCAL_CREDENTIALS.md` (git-ignored). Do not print it in chat.
- Settings: site language Arabic, timezone Africa/Cairo, permalinks `/%postname%/`, delete the default content, and turn off comments on pages.

## 3. Plugins to install and activate (via WP-CLI)

| Purpose       | Plugin                                                                                                                   |
| ------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Custom fields | ACF PRO (zip) **or** Secure Custom Fields                                                                                |
| Multilingual  | Polylang (+ Polylang for WooCommerce if zip provided)                                                                    |
| Shop          | WooCommerce                                                                                                              |
| Contact form  | **Custom** form in the theme (nonce, honeypot, `wp_mail`, entries saved to a `hala_message` CPT). No form plugin needed  |
| SMTP          | WP Mail SMTP (leave unconfigured, document it)                                                                           |
| SEO           | Rank Math SEO (or Yoast if Rank Math cannot be installed)                                                                |
| Cache / perf  | LiteSpeed Cache **only if** the host is LiteSpeed — otherwise skip and document it. Locally, install nothing for caching |
| Images        | Converter for Media (WebP)                                                                                               |
| Security      | Wordfence (installed, left inactive locally; document activating it on production)                                       |
| Backup        | UpdraftPlus                                                                                                              |

Write the install commands into `bin/setup.sh` / `bin/setup.bat`, so the whole site can be recreated from a fresh clone.

## 4. Design system (extract the exact values from the frames)

- **Colours (approximate — sample the frames to refine):** primary burgundy `#7A2A2E`, deep burgundy `#5E1E22`, gold/brown (footer, cards) `#9C8462`, cream background `#F3EFE8`, card background `#EAE4DA`, text `#2B2B2B`, muted text `#6B6460`, pink tint (sticky cart bar) `#E9D6D4`.
- **Typography:** headings use an elegant Arabic Naskh serif (try _Amiri_, _Noto Naskh Arabic_, _Reem Kufi_ and _El Messiri_ and pick the closest match). Highlighted words in headings are burgundy, e.g. "دقة **الطب**" and "**الكتب** الأدبية والطبية". Body text uses _Cairo_ or _Tajawal_. English uses _Playfair Display_ + _Inter_. **Self-host the fonts** in `hala/assets/fonts/` (no Google Fonts CDN).
- **Components:** pill buttons with a circular arrow icon; large rounded corners (~24–32px) on sections and cards; small eyebrow labels above section titles (e.g. "عن الدكتورة", "المكتبة والإصدارات"); soft cream gradients; burgundy CTA panels with 3D illustrations; FAQ accordions with +/− icons; pagination with circle buttons; carousels with arrow and progress-bar controls (write the carousel yourself in vanilla JS, or use Swiper served locally).
- Put all the tokens in CSS custom properties in `assets/css/tokens.css`. No CSS framework is required. If you use a build step, keep it simple (plain CSS + `@import`, or Vite producing `assets/dist/`) and **commit the built files**.
- **3D illustrations / images** (megaphone/bell, glasses on books, shopping cart, Egyptian hieroglyph tablet, doctor portraits): crop placeholders from the frames for local development and save them in `hala/assets/images/placeholders/`. Every image must be replaceable through ACF fields, and the README must list the images the client needs to send.

## 5. Pages and templates (match each to the frames)

**Global:** sticky header (logo "هالة مصطفى / Hala Mostafa" with portrait; menu: عن الدكتورة · الكتب العلمية والأدبية · المدونة · تواصل معي; cart icon with live count; CTA "شراء كتب الدكتورة"; language switcher; mobile off-canvas menu). Footer on a gold/brown rounded panel: title "معاً لرعاية أفضل وفكر أعمق", three columns (الصفحات / المزيد / المتابعة with LinkedIn, ResearchGate, Cairo University, ORCID), a bottom bar with copyright, privacy and terms links, and the language switcher. A reusable **newsletter CTA** ("كن أول من يطلع على أحدث الإصدارات والمقالات") with an email field that saves subscribers to a `hala_subscriber` CPT (double opt-in is not required).

1. **Home (`front-page.php`)** — hero (portrait card, eyebrow, headline "بين دقة الطب وجلال الكلمة…", intro text, two buttons); books section with category tabs and a book-card carousel; research highlights (cards: title, journal, issue, year, "المزيد من التفاصيل عن البحث"); vision section "رؤيتي: أمانٌ يُطمئن القلوب.. وعلمٌ يُضيء المستقبل" with portrait; CTA "امتلك نسختك من أحدث المؤلفات…"; latest articles slider; newsletter; footer. Every section is editable with ACF (Flexible Content or per-section field groups) and can be toggled on or off.
2. **About (`page-about.php`)** — bio, career timeline, specialties, academic links.
3. **Books archive (WooCommerce shop)** — burgundy hero with the covers fanned out; title "الكتب الأدبية والطبية"; filter tabs (الكل / مقالات طبية / أدب وتاريخ) that filter by `product_cat` with AJAX; card grid (cover, category badge, title, excerpt, "المزيد من التفاصيل"); circle pagination.
4. **Single book** — cover, title, price in EGP, add to cart, "الوصف" section with bullet lists, "ماذا ستجد بداخل المرجع الشامل", an FAQ accordion (ACF repeater per product), related books ("كتب مشابهة"), and a **sticky bottom add-to-cart bar** (thumbnail, title, price "600 جنيه مصري", button "أضف إلى السلة").
5. **Cart** — table (product, price, quantity +/−, remove, subtotal); sidebar "إجمالي سلة المشتريات" with a collapsible coupon field and total; button "المتابعة لإتمام الطلب".
6. **Empty cart** — 3D cart illustration, "لم تقم بإضافة اي كتب", subtitle, button "تصفح كتب الدكتورة".
7. **Checkout** — gold title bar "السلة"/"إتمام الطلب", billing fields, order notes, payment methods: **Cash on Delivery** (الدفع عند الإستلام) and a **custom offline gateway "e-wallet"** (الدفع بالمحفظة الإلكترونية: Vodafone Cash / InstaPay, with the instructions and wallet number set in admin). Write the gateway as a small class in `hala/inc/woocommerce/class-gateway-ewallet.php`. Button "المتابعة للدفع". Currency EGP, Egypt only.
8. **Research (`hala_research` CPT + archive)** — hero "الدراسات والأبحاث العلمية" with a search bar (searches this CPT only); intro section "البحث والنشر العلمي"; 2-column card grid (title, abstract, journal e.g. _Egyptian Journal of Anaesthesia_, issue, year, link/DOI field); pagination; newsletter CTA.
9. **Blog (posts archive)** — hero "مقالات وتأملات في رحاب الطب والفكر والتاريخ" with search; section "المقالات الأدبية والطبية" with category tabs; grid; pagination.
10. **Single post** — full-width hero image with title overlay (e.g. "طب أجدادنا الفراعنة"), content, related articles carousel "إضاءات بين رحاب الطب وعمق التاريخ", newsletter.
11. **Contact (`page-contact.php`)** — "نرحب بالتواصل معكم"; form (first name, last name, email, phone with a +20 country prefix, message); cards for email (contact@dr-halamostafa.com) and WhatsApp; section "كما يمكنكم متابعتنا" with LinkedIn / ORCID / ResearchGate cards.
12. **FAQ (`page-faq.php`)** — accordion list (ACF repeater).
13. **Privacy policy** and **Terms / usage policy** — two-column layout with sticky section titles on one side ("المعلومات التي نقوم بجمعها", "استخدام المعلومات") and content on the other.
14. `404.php`, `search.php`, and the WooCommerce account / thank-you pages styled to match.

## 6. Demo content

Seed realistic **Arabic and English** demo content with a WP-CLI script (`bin/seed.php`, run with `wp eval-file`): 3–4 books priced 400–600 EGP, 6+ research entries, 6+ blog posts in 2 categories, FAQ items, menus for both languages, all pages linked in Polylang, and the options filled in. Mark placeholder text clearly, so the client knows what to replace.

## 7. Quality bar

- Responsive at 375, 768, 1234 (the video's viewport) and 1440px. No horizontal scroll. Check RTL and LTR.
- Accessibility: semantic HTML, alt text, focus states, keyboard-operable accordions, tabs and carousels, colour contrast at AA.
- Performance: enqueue only the CSS and JS each template needs, use `defer` scripts, lazy-load images, use responsive `srcset`, and register image sizes. No jQuery in theme code (WooCommerce may still load it).
- Security: escape all output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`), sanitize input, use nonces on every form/AJAX call, and never commit secrets.
- Run `php -l` on every PHP file. Fix all PHP notices with `WP_DEBUG` on.
- **Visual verification:** open each page in the browser at 1234×800, take screenshots, compare them side by side with the matching `docs/reference` frames, and fix the differences. Write the comparison results in `docs/QA.md`.

## 8. Git and GitHub

- Initialise git in the project root. Write a `.gitignore` that **excludes** WordPress core (`/wp-admin/`, `/wp-includes/`, root `wp-*.php` files, `index.php`, `xmlrpc.php`, `license.txt`, `readme.html`), `wp-config.php`, `wp-content/uploads/`, `wp-content/cache/`, `wp-content/upgrade/`, third-party plugins, `docs/LOCAL_CREDENTIALS.md`, `docs/plugins/*.zip`, `node_modules/`, `bin/wp-cli.phar`, `*.zip` and `.env`.
- The repo **includes**: `wp-content/themes/hala/`, any `wp-content/mu-plugins/`, `bin/` scripts, `docs/` (reference frames, notes, QA), `wp-config-sample.php`, and a `database/` folder with a sanitized SQL export (`wp db export`, with the admin email and password hash replaced).
- `README.md`: overview, the stack and why, local setup from a fresh clone (step by step), plugin list (including which ones are paid), how to translate content, how to deploy to production (upload, import DB, `wp search-replace`, set up SMTP, activate Wordfence/caching), and the list of assets needed from the client.
- Make small, meaningful commits as you go (setup → theme skeleton → design system → each page → WooCommerce → i18n → seed → QA).
- Add the remote and push the `main` branch: `git remote add origin https://github.com/imooorsy/dr-hala-mostafa.git` then `git push -u origin main`. If the push asks for authentication, stop and tell me so I can sign in. Do not try to work around it.

## 9. How to work

1. Read the frames and write `docs/DESIGN_NOTES.md`.
2. Write a short plan in `docs/PLAN.md` and keep a checklist there that you update as you finish items.
3. Set up the environment → theme skeleton → design tokens → header and footer → each page in the order above → WooCommerce → Polylang/i18n → seed → QA → push.
4. Don't stop to ask me about things you can decide sensibly. Note your assumptions in `docs/PLAN.md`. Stop only when you hit a blocker (missing licence, auth, admin rights).
5. When you finish, give me: the local URL, where the admin credentials are saved, what's left for the client (real images, texts, licences), and the GitHub link.
