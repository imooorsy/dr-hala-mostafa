# Design notes — extracted from `docs/reference/frame_01…49.jpg`

Viewport in the video: ~1234×800 tablet frame, RTL Arabic. Content container ≈ 1020px wide (x 88 → 1108), outer page radius ~28px. Frame numbers below are `frame_NN.jpg`.

## Global components

| Component | Layout / details | Frames |
|---|---|---|
| **Header** (sticky, translucent cream blur, 1px bottom border) | RTL: logo at the far right (round portrait avatar + "هالة مصطفى" in burgundy over "Hala Mostafa" serif), then menu: عن الدكتورة · الكتب العلمية والأدبية · المدونة · تواصل معي. Far left: primary pill CTA "شراء كتب الدكتورة" (burgundy fill, circular pink-tint arrow chip on the inline-start side) and a bordered pill cart "السلة" with a small burgundy count badge + cart icon. On cart/checkout pages the cart pill is hidden. | all |
| **Footer** | Gold/brown (#9C8462-ish, `~#977F5C`) panel, top corners ~48px radius, full width. Big light serif title "معاً لرعاية أفضل وفكر أعمق" centred. Three columns with a thin underline under each heading: الصفحات (الرئيسية, الكتب الطبية و الأدبية, الأبحاث العلمية, المدونة, التواصل) · المزيد (سياسة الاسترجاع والإستبدال, سياسة الخصوصية, الأسئلة الشائعة) · المتابعة (لينكدان - LinkedIn, بوابة الأبحاث العلمية - ResearchGate, جامعة القاهرة - Cairo University, المُعرّف الأكاديمي - ORCID). Bottom translucent rounded bar: copyright "جميع الحقوق محفوظة للدكتورة هالة مصطفى جمعة © 2026" (inline-start/right), privacy + refund links and language switcher "عربي ⌄" (left). | 6, 10, 15-17, 20, 25, 28, 30-33, 36, 41, 43-44 |
| **Newsletter CTA** | Burgundy rounded (≈28px) panel with swirl texture, 3D burgundy bell illustration on the left, eyebrow "حصرياً ومباشرةً إليك", headline "كن أول من يطلع على أحدث الإصدارات والمقالات", paragraph, and a pill email input (cream) with the submit pill button "اشترك ليصلك كل جديد" inset on the left. | 10, 19, 24, 34, 40 |
| **Book-CTA panel** | Burgundy panel with 3D round glasses on a stack of books (left), eyebrow "مكتبة الأستاذة الدكتورة هالة مصطفى جمعة", headline "امتلك نسختك من أحدث المؤلفات والمراجع الطبية والأدبية", paragraph and white pill button "تصفح كتب الدكتورة هالة مصطفى". | 22, 38 |
| **Pill button** | Fully rounded; burgundy fill with cream text; circular light-pink chip containing a ← arrow at the inline-start. Variants: light (white fill, burgundy chip), text-link ("← الكتب العلمية و الأدبية"), small "المزيد من التفاصيل ←". | all |
| **Eyebrow label** | Tiny burgundy/muted text above section titles; titles are large Naskh-serif black with ONE highlighted burgundy word ("دقة **الطب**", "**المقالات** الأدبية والطبية"). | 1, 2, 11, 18, 23, 33 |
| **Carousel controls** | Two white circular arrow buttons either side of a long pill progress bar (pink track, burgundy thumb). | 3, 5, 24 |
| **Pagination** | Small pill container with circular buttons: ‹ 1(active burgundy) 2 3 (4) ›. Prev/next are white circles. | 8, 9, 19, 34, 35 |
| **FAQ accordion** | Cards on card-beige (#EAE4DA-ish, 16px radius), bold question, round +/− chip at the inline-end (burgundy "−" filled when open, white "+" when closed). Answer is muted text below. Title "الأسئلة الشائعة:" in burgundy. | 14, 26, 27 |
| **Page hero (listing pages)** | Full-width burgundy band with a curved/wavy bottom edge, 3D illustration silhouette in the middle/background (stack of books, podcast-microphone + chat bubble for FAQ, retro TV for blog), eyebrow + big title + paragraph + big cream rounded search bar ("البحث" placeholder, search icon). | 7, 18, 26, 33 |
| **Gold title bar** | Cart/checkout pages: rounded gold bar with white title ("السلة" / "الدفع") at the inline-start (right). | 44-49 |
| **Sticky add-to-cart bar** | Single book: fixed bottom bar in pink tint (#E9D6D4), thumbnail + title + "600 جنيه مصري" at the right, burgundy pill "أضف الى السلة" with white arrow chip at the left. | 12-17 |

## Pages

### Home — frames 1-5 (+ footer 6)
1. **Hero** (f1): left a rounded portrait card (doctor in burgundy suit on beige armchair, bottom overlay pill "دكتورة هالة مصطفى جمعة" with dot); right: eyebrow "عن الدكتورة", H1 "بين **دقة الطب** وجلال الكلمة / مسيرة في علم التخدير وإبداع الأدب", paragraph, buttons: primary "المزيد عن الدكتورة", text link "الكتب العلمية و الأدبية". Soft cream swirl background.
2. **Expertise (محاور التخصص والخبرات)** (f2): right column intro + buttons ("شراء كتب الدكتورة هالة مصطفى", link "الأبحاث العلمية"); left column stacked cards with card-beige bg and a coloured (burgundy / brown) vertical strip on the inline-end edge: الطب والأكاديميا, المؤلفات والنشر الدولي, القلم والإبداع الأدبي — each with bullet lists (pink bullet dots).
3. **Books** (f3, f7?): book-card carousel — card: square cover (burgundy `#8B4A48` or gold-brown `#8F7650` alternating), category badge (طبي burgundy / أدبي gold), bold title, excerpt, "المزيد من التفاصيل ←"; arrows + progress bar below. Category tabs live on the shop page.
4. **Research highlights** (f4): intro line + pill "مشاهدة المزيد من الأبحاث"; 2-column cards (title, abstract, meta row: المجلد 39، العدد 1 · *Egyptian Journal of Anaesthesia* (burgundy serif) · 2023; button "المزيد من التفاصيل عن البحث" with dark burgundy circle chip on a white pill). Syringe 3D icon sits between columns.
5. **Vision/CTA** (f5-6): burgundy block half portrait (doctor in floral hijab) — eyebrow "إبداع أدبي يتجاوز حدود الطب", headline, white pill button.
6. **Latest articles slider** (f5): cards with image (3D hieroglyph tablet / ECMO device), date "20 Sep . 2026" + category chip, title, excerpt, circular burgundy arrow; carousel controls.
7. Newsletter + footer.

### Books archive — frames 7-10
Burgundy hero w/ wavy bottom; paragraph "مكتبة متكاملة من الإصدارات التي توثق مسيرة عطاء…"; search bar; 4 covers fanned with slight rotation (alternating burgundy and gold). Below: eyebrow "الكتب", title, filter tabs, 4-column card grid (cover, badge, title, excerpt, "المزيد من التفاصيل ←"), pagination ‹ 1 2 3 ›, newsletter, footer.

### Single book — frames 11-17
Pink-tint section: left cover (burgundy, with spine edge), right eyebrow link "احصلي على الدليل الشامل…", H1 title, description paragraph, price "600 جنيه مصري" (burgundy serif), qty stepper (− 1 +) and "أضف الى السلة" pill. Below: description with bullets ("الجزء الأول… الجزء الثاني…"), burgundy highlighted line, H2 "ماذا ستجدين بداخل المرجع الشامل:" with bullet list; burgundy "why" panel with 3D shape and bullet list; FAQ accordion "الأسئلة الشائعة:"; related books (3-card row); sticky bar; newsletter; footer.

### Blog — frames 18-20
Hero (retro TV illustration), eyebrow "المدونة", title "المقالات الأدبية والطبية", tabs inside a burgundy rounded bar (الكل / مقالات طبية [active cream pill] / أدب وتاريخ); 3-col image-overlay cards (illustration bg, white title, excerpt); pagination; newsletter; footer.

### Single post — frames 21-23
Wide rounded hero image (hieroglyph tablet); H1 burgundy; content with burgundy H2s; book-CTA panel (glasses on books); related articles "إضاءات بين رحاب الطب وعمق التاريخ" with eyebrow "مقالات مشابهة", pill "مشاهدة المزيد", slider with overlay cards.

### FAQ — frames 26-28
Burgundy hero with mic/chat illustration, title "الأسئلة الأكثر تكراراً", paragraph, search; section "الأسئلة الشائعة:" accordion; newsletter; footer.

### Privacy / Refund policy — frames 29-30, 42-44
Burgundy hero band with "تاريخ آخر تحديث: 26 أكتوبر 2026"; bordered cream box with rows: left-side (visually right) sticky heading in burgundy serif ("استرجاع واستبدال الكتب المطبوعة", "الكتب الرقمية والنسخ الالكترونية", "المعلومات التي نقوم بجمعها", "استخدام المعلومات", "ملفات تعريف الارتباط (Cookies)") and bullets on the other side; final consent statement row.

### Research archive — frames 31-37
Hero, eyebrow "الإنتاج العلمي المحكم", title "**البحث** والنشر العلمي", 2-col card grid (same card as home), pagination ‹ 1 2 3 4 ›.

### Contact — frames 38-40
Burgundy form panel (right) + contact cards left (البريد الإلكتروني contact@dr-halamostafa.com; واتس اب +20111585883253 — each with icon square + circular arrow). Message textarea "اكتب هنا إستفسارك", send pill "ارسل الرسالة للتواصل". Then "كما يمكنكم **متابعتنا**" + 5 cards (LinkedIn, ORCID, ResearchGate, Cairo University, Newsletter) with pill "المتابعة وتصفح ملفي". Book CTA, newsletter, footer.

### Cart — frames 44-45
Gold title bar "السلة"; big soft card: left sidebar "إجمالي سلة المشتريات" (collapsible "إضافة قسيمة", "الإجمالي المقدر", pill "المتابعة لإتمام الطلب"); right table headers المنتج / الإجمالي, rows: thumbnail, title, unit price, qty pill stepper, trash circle, line total.

### Checkout — frames 46-47
Title bar "الدفع". Form (right): الاسم الأول, الاسم الثاني, البريد الإلكتروني, رقم الهاتف (+20 flag), عنوان الفاتورة select (المحافظة e.g. الجيزة), العنوان بالتفصيل textarea, "خيارات الدفع" radio rows (الدفع عند الإستلام · الدفع بالفيزا أو محفظة الكترونية), pill "المتابعة للدفع". Left: "ملخص الطلب" with item thumbnails, coupon, total.

### Empty cart — frame 48
Gold bar "السلة", 3D grey cart illustration, "لم تقم بإضافة اي كتب", subtitle "قم بإضافة كتب إلى السلة لتمتع بعلم الدكتورة هالة مصطفى", pill "تصفح كتب الدكتورة".

## Design tokens (sampled)
| Token | Value |
|---|---|
| burgundy | `#7A2A2E` (cards `#8B4A48`, deep panel `#5E1E22` → `#6B2226`) |
| gold/brown | `#977F5C` footer, `#8F7650` book covers, title bar `#8F7A57` |
| cream bg | `#F3EFE8`; header translucent `#EFEAE0` |
| card beige | `#EAE4DA` |
| pink tint | `#E9D6D4` |
| text | `#2B2B2B`; muted `#6B6460` |
| Heading font | Naskh/Kufi-like geometric Arabic serif — **Reem Kufi** is not it; frames look closest to **Amiri / Noto Naskh display**; final pick made in `tokens.css` after render comparison |
| Radii | cards 24-32px, pills 999px, page frame 28px |

## Assumptions / gaps
- Frames never show the About page or the blog category tabs for أدب وتاريخ results; designed from the home sections and sitemap in the brief.
- Cart badge shows `3` in the video (static mock); it will be live.
- Images in the video are 3D renders; placeholders are cropped from frames (documented in README).
