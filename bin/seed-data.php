<?php
/**
 * Demo content (Arabic + English). Everything here is PLACEHOLDER content for the client to replace;
 * body texts end with a clearly marked placeholder note where noted.
 *
 * Returns an array keyed by content type.
 */

$ar_note = '<p><em>[نص تجريبي — يُستبدل بالمحتوى الحقيقي]</em></p>';
$en_note = '<p><em>[Placeholder text — replace with the real content]</em></p>';

return array(

	/* ------------------------------------------------------------ BOOKS */
	'books' => array(
		array(
			'key'   => 'book-1',
			'cat'   => 'med',
			'price' => 600,
			'img'   => 'book-1.png',
			'ar'    => array(
				'title'   => 'احتراف الـ ECMO: دراسات حالات سريرية وبنك أسئلة تخصصية',
				'excerpt' => 'مرجعٌ تخصصي متقدم يجمع بين دقة المعايير السريرية واحترافية أسئلة البورد الدولي في مكان واحد. سيناريوهات ومحاكاة عملية تُثري عقلك الطبي وتضمن أعلى معايير أمان المرضى، ونظام مراجعة يضمن إتقانك لأدق تفاصيل الحالات الحرجة قبل اختبارات البورد أو الممارسة الفعلية. الأستاذة الدكتورة هالة مصطفى جمعة بخبرة أكاديمية وطبية يمتد أثرها لعقود في كلية طب قصر العيني بجامعة القاهرة. نالت درجة الأستاذية عام 2010، وقدمت خلال مسيرتها أبحاثاً تخصصية ومراجع عالمية تُعنى بتطوير رعاية المرضى وتخدير الحالات الحرجة وجراحات النساء والتوليد، إلى جانب نتاجها الفكري والأدبي الزاخر.',
				'content' => '<ul><li><strong>الجزء الأول (التأسيس السريري والمفاهيم المتقدمة):</strong><br>يضع بين يديك فهماً عميقاً لآليات عمل الإقنعة القلبية الرئوية، مؤشرات الاستخدام، وكيفية التعامل الفوري مع المضاعفات الحرجة في غرف العناية المركزة.</li><li><strong>الجزء الثاني (بنك الأسئلة والمحاكاة الاحترافية - Board-Style Questions):</strong><br>يمنحك مجموعة واسعة من الأسئلة التخصصية المحاكاة لاختبارات البورد مع الشروحات التفصيلية: لضمان سرعة اتخاذ القرار السليم تحت الضغط.</li></ul><p><strong>معاً، يغلق هذا الكتاب دائرة التدريب المتقدم لديكِ: ماذا تفعلين سريرياً، وكيف تطبقين المعايير العالمية بدقة متناهية.</strong></p>',
				'eyebrow' => 'احصلي على الدليل الشامل لتقنيات الإقنعة القلبية الرئوية (ECMO).',
				'inc_t'   => 'ماذا ستجدين بداخل المرجع الشامل:',
				'inc'     => '<ul><li>أسئلة اختبارات بورد متقدمة تغطي كافة جوانب تقنيات الدعم القلبي الرئوي (ECMO).</li><li>سيناريوهات سريرية واقعية لحالات حرجة مع تحليلات دقيقة لطرق التعامل معها.</li><li>دليل عملي ومبسط لإدارة المضاعفات الطارئة وتجنب المخاطر السريرية.</li><li>مراجعة شاملة لبروتوكولات الأكسدة الغشائية خارج الجسم المعتمدة عالمياً.</li><li>إرشادات دقيقة مدعومة بأحدث الأدلة والأبحاث الطبية المحكّمة.</li><li>ملخصات تنظيمية تسهل استرجاع المعلومات الأساسية قبل الاختبارات.</li></ul>',
				'why_t'   => 'لماذا هذا الكتاب لكِ؟',
				'why'     => "ملّت من تشتت البحث بين مصادر متعددة ومتباينة للحصول على إجابات معتمدة.\nتهدفين إلى الارتقاء بمستواك المهني وضمان أعلى معايير أمان وسلامة المرضى.\nتبحثين عن أفضل وأوثق قيمة علمية موثقة مقابل وقتك وجهدك.",
				'faqs'    => array(
					array( 'هل الكتاب مفيد لمن يستعدون لامتحانات البورد فقط، أم للعمل اليومي؟', 'يكمل الطرفين: فهو مصمم خصيصاً بنمط أسئلة البورد لتدريب العقل على اجتياز الاختبارات، وفي الوقت ذاته يُعتبر دليلاً عملياً لا يُقدّر بثمن للتعامل مع الحالات الواقعية في العناية المركزة.' ),
					array( 'هل الكتاب متاح بنسخة مطبوعة ورقمية؟', 'تتوفر النسخة المطبوعة حالياً، ويمكنكم متابعة صفحة الكتاب لمعرفة موعد توفر النسخة الرقمية.' ),
					array( 'كيف يتم توصيل الكتاب؟', 'يتم الشحن داخل جمهورية مصر العربية. اختر الدفع عند الاستلام أو بالمحفظة الإلكترونية عند إتمام الطلب.' ),
				),
			),
			'en'    => array(
				'title'   => 'Mastering ECMO: Clinical Case Studies and a Specialty Question Bank',
				'excerpt' => 'An advanced specialist reference that brings together clinical precision and professional board-style questions in one place. Hands-on scenarios and simulations that enrich your medical mind and uphold the highest standards of patient safety, plus a review system that makes sure you master the finest details of critical cases before the boards or real practice. Prof. Dr. Hala Mostafa Gomaa brings decades of academic and clinical experience at Kasr Al Ainy Faculty of Medicine, Cairo University. She was promoted to professor in 2010 and has produced specialist research and international references on patient care, critical-care anaesthesia and obstetric surgery, alongside a rich body of intellectual and literary work.',
				'content' => '<ul><li><strong>Part One (clinical foundations and advanced concepts):</strong><br>Gives you a deep understanding of how extracorporeal cardiopulmonary support works, its indications, and how to respond immediately to critical complications in intensive care.</li><li><strong>Part Two (question bank and professional simulation — board-style questions):</strong><br>A wide set of specialty questions simulating board exams, with detailed explanations, to build quick, sound decision-making under pressure.</li></ul><p><strong>Together, this book closes your advanced-training loop: what to do clinically, and how to apply global standards with great precision.</strong></p>',
				'eyebrow' => 'Get the complete guide to extracorporeal membrane oxygenation (ECMO).',
				'inc_t'   => 'What you will find inside the complete reference:',
				'inc'     => '<ul><li>Advanced board-style questions covering every aspect of ECMO support.</li><li>Realistic clinical scenarios of critical cases with precise analysis of how to manage them.</li><li>A practical, simplified guide to managing emergency complications and avoiding clinical risk.</li><li>A comprehensive review of internationally accepted extracorporeal oxygenation protocols.</li><li>Precise guidance backed by the latest evidence and peer-reviewed research.</li><li>Organised summaries that make revision of the essentials easy before exams.</li></ul>',
				'why_t'   => 'Why is this book for you?',
				'why'     => "You are tired of searching across many inconsistent sources for reliable answers.\nYou aim to raise your professional level and the safety standards of your patients.\nYou are looking for the best documented scientific value for your time and effort.",
				'faqs'    => array(
					array( 'Is the book useful only for board preparation, or for daily practice too?', 'Both: it is designed with a board-question format to train the mind for exams, and at the same time serves as an invaluable practical guide for real cases in intensive care.' ),
					array( 'Is the book available in print and digital?', 'The printed edition is available now; follow the book page to learn when the digital edition is released.' ),
					array( 'How is the book delivered?', 'We ship within Egypt. Choose cash on delivery or e-wallet payment at checkout.' ),
				),
			),
		),
		array(
			'key'   => 'book-2',
			'cat'   => 'lit',
			'price' => 500,
			'img'   => 'book-2.png',
			'ar'    => array(
				'title'   => 'ومضات فكرية: بين دقة العلوم ولمسات السرد التاريخي',
				'excerpt' => 'مجموعة نصوص أدبية وفكرية تضيء جوانب الصبر والأمل والمكابدة الإنسانية من زاوية طبيبة وكاتبة مبدعة.',
				'content' => '<p>تأملاتٌ تجمع بين عين الطبيبة التي رأت الألم عن قرب، وقلم الكاتبة التي تحوّل التجربة إلى حكاية. فصول قصيرة تنتقل بين غرفة العمليات وصفحات التاريخ، بلغة أدبية رشيقة تناسب القارئ المتخصص وغير المتخصص.</p>' . $ar_note,
				'eyebrow' => 'أدب وتأملات فكرية',
				'inc_t'   => 'ماذا ستجدين بين الدفتين:',
				'inc'     => '<ul><li>نصوص قصيرة عن الصبر والأمل والمكابدة الإنسانية.</li><li>حكايات من تاريخ الطب المصري القديم.</li><li>تأملات في العلاقة بين العلم والكلمة.</li></ul>',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array( array( 'هل الكتاب مناسب لغير الأطباء؟', 'نعم، فهو مكتوب بلغة أدبية قريبة من كل قارئ.' ) ),
			),
			'en'    => array(
				'title'   => 'Flashes of Thought: Between the Precision of Science and the Touch of Historical Narrative',
				'excerpt' => 'A collection of literary and reflective texts that shed light on patience, hope and human struggle from the angle of a physician and gifted writer.',
				'content' => '<p>Reflections that join the eye of a physician who has seen pain up close with the pen of a writer who turns experience into story. Short chapters move between the operating theatre and the pages of history, in a graceful literary language for specialist and general reader alike.</p>' . $en_note,
				'eyebrow' => 'Literature and reflective thought',
				'inc_t'   => 'What you will find between the covers:',
				'inc'     => '<ul><li>Short texts on patience, hope and human struggle.</li><li>Tales from the history of ancient Egyptian medicine.</li><li>Reflections on the relationship between science and the written word.</li></ul>',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array( array( 'Is the book suitable for non-physicians?', 'Yes, it is written in a literary language close to every reader.' ) ),
			),
		),
		array(
			'key'   => 'book-3',
			'cat'   => 'med',
			'price' => 400,
			'img'   => 'book-3.png',
			'ar'    => array(
				'title'   => 'الدعم المتقدم للحياة وتقنيات الإقنعة القلبية الرئوية في العناية الحرجة',
				'excerpt' => 'دليل عملي شامل يرافق الأطباء خطوة بخطوة في إدارة ورعاية مرضى الإقنعة القلبية الرئوية، بدءاً من اللحظات الأولى وحتى التعافي والفطام.',
				'content' => '<p>يقدم هذا المرجع خلاصة الخبرة السريرية في دعم الحياة المتقدم داخل وحدات العناية المركزة، مع بروتوكولات عملية ومخططات توضيحية تساعد الفريق الطبي على اتخاذ القرار السريع والآمن.</p>' . $ar_note,
				'eyebrow' => 'دليل الممارس في العناية الحرجة',
				'inc_t'   => 'محتويات المرجع:',
				'inc'     => '<ul><li>مبادئ الدعم المتقدم للحياة.</li><li>إدارة المريض على جهاز الإقنعة القلبية الرئوية.</li><li>الفطام والتعافي.</li></ul>',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array( array( 'لمن هذا الكتاب؟', 'لأطباء التخدير والعناية المركزة وطلاب الدراسات العليا.' ) ),
			),
			'en'    => array(
				'title'   => 'Advanced Life Support and Extracorporeal Cardiopulmonary Techniques in Critical Care',
				'excerpt' => 'A comprehensive practical guide that accompanies physicians step by step in managing and caring for ECMO patients, from the first moments through recovery and weaning.',
				'content' => '<p>This reference offers the distilled clinical experience of advanced life support in intensive care units, with practical protocols and illustrative charts that help the medical team make quick, safe decisions.</p>' . $en_note,
				'eyebrow' => 'The practitioner\'s guide to critical care',
				'inc_t'   => 'Contents of the reference:',
				'inc'     => '<ul><li>Principles of advanced life support.</li><li>Managing the patient on ECMO.</li><li>Weaning and recovery.</li></ul>',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array( array( 'Who is this book for?', 'Anaesthesia and intensive-care physicians and postgraduate students.' ) ),
			),
		),
		array(
			'key'   => 'book-4',
			'cat'   => 'lit',
			'price' => 450,
			'img'   => 'book-4.png',
			'ar'    => array(
				'title'   => 'حكايات من قصر العيني: ذكريات طبيب وكاتب',
				'excerpt' => 'مجموعة واسعة من الحكايات والمواقف الإنسانية بين جدران أعرق المستشفيات الجامعية في مصر، بقلم طبيبة وكاتبة. (عنوان ومحتوى تجريبيان)',
				'content' => '<p>ذكريات ومواقف إنسانية من مسيرة طويلة بين مدرجات قصر العيني وغرف عملياته.</p>' . $ar_note,
				'eyebrow' => 'أدب وتاريخ',
				'inc_t'   => '',
				'inc'     => '',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array(),
			),
			'en'    => array(
				'title'   => 'Tales from Kasr Al Ainy: Memoirs of a Physician and Writer',
				'excerpt' => 'A wide set of stories and human moments within the walls of one of Egypt\'s oldest university hospitals, by a physician and writer. (Placeholder title and content)',
				'content' => '<p>Memories and human moments from a long career between the lecture halls and operating theatres of Kasr Al Ainy.</p>' . $en_note,
				'eyebrow' => 'Literature and history',
				'inc_t'   => '',
				'inc'     => '',
				'why_t'   => '',
				'why'     => '',
				'faqs'    => array(),
			),
		),
	),

	/* ------------------------------------------------------------ RESEARCH */
	'research' => array(
		array( 'year' => 2023, 'issue' => array( 'المجلد 39، العدد 1', 'Vol. 39, No. 1' ),
			'ar' => array( 'فعالية أحجام مختلفة من المخدر الموضعي أثناء كتل العضلة الخاضعة للشوكة (Erector Spinae Block)', 'بحث الملاحظة السريرية المتقدمة لتقليص الحاجة للمسكنات الأفيونية المنهجية وتحسين مستويات الراحة والأمان للمرضى بعد جراحات العظام والمفاصل.' ),
			'en' => array( 'Effectiveness of different volumes of local anaesthetic in erector spinae plane block', 'Advanced clinical observation research on reducing the need for systemic opioids and improving comfort and safety for patients after orthopaedic and joint surgery.' ) ),
		array( 'year' => 2022, 'issue' => array( 'المجلد 38، العدد 2', 'Vol. 38, No. 2' ),
			'ar' => array( 'مقارنة بين الديكساميديتوميدين والفنتانيل كمساعدين للتخدير النصفي في الولادة القيصرية', 'دراسة عشوائية مضبوطة تقيّم جودة التخدير والاستقرار الدموي ورضا الأمهات.' ),
			'en' => array( 'Dexmedetomidine versus fentanyl as adjuvants to spinal anaesthesia in caesarean section', 'A randomised controlled study evaluating anaesthetic quality, haemodynamic stability and maternal satisfaction.' ) ),
		array( 'year' => 2022, 'issue' => array( 'المجلد 38، العدد 1', 'Vol. 38, No. 1' ),
			'ar' => array( 'تأثير الإقنعة القلبية الرئوية على نتائج المرضى في حالات الفشل التنفسي الحاد', 'مراجعة منهجية لنتائج البقاء والمضاعفات في وحدات العناية المركزة.' ),
			'en' => array( 'Impact of ECMO on outcomes in acute respiratory failure', 'A systematic review of survival outcomes and complications in intensive care units.' ) ),
		array( 'year' => 2021, 'issue' => array( 'المجلد 37، العدد 3', 'Vol. 37, No. 3' ),
			'ar' => array( 'بروتوكولات تسكين الألم متعدد الوسائط بعد جراحات البطن الكبرى', 'تقييم فعالية الحزم التسكينية متعددة الوسائط في تقليل مدة الإقامة بالمستشفى.' ),
			'en' => array( 'Multimodal analgesia protocols after major abdominal surgery', 'Evaluating multimodal analgesic bundles in reducing hospital length of stay.' ) ),
		array( 'year' => 2021, 'issue' => array( 'المجلد 37، العدد 1', 'Vol. 37, No. 1' ),
			'ar' => array( 'التخدير الموضعي الموجه بالموجات فوق الصوتية في جراحات الأطراف العلوية', 'دراسة مقارنة لتقنيات الحصار العصبي الموجه بالسونار ودرجة نجاحها.' ),
			'en' => array( 'Ultrasound-guided regional anaesthesia in upper-limb surgery', 'A comparative study of ultrasound-guided nerve block techniques and their success rates.' ) ),
		array( 'year' => 2020, 'issue' => array( 'المجلد 36، العدد 4', 'Vol. 36, No. 4' ),
			'ar' => array( 'إدارة مجرى الهواء الصعب في المرضى ذوي السمنة المفرطة', 'مقارنة بين أدوات التنبيب بالمنظار المرن والمنظار المرئي.' ),
			'en' => array( 'Difficult airway management in morbidly obese patients', 'A comparison of flexible bronchoscope and video-laryngoscope intubation tools.' ) ),
		array( 'year' => 2020, 'issue' => array( 'المجلد 36، العدد 2', 'Vol. 36, No. 2' ),
			'ar' => array( 'تقييم مؤشرات الاستجابة للسوائل في مرضى الصدمة الإنتانية', 'دراسة سريرية للمؤشرات الديناميكية الدموية الأقل تدخلاً.' ),
			'en' => array( 'Assessing fluid responsiveness indices in septic shock', 'A clinical study of less-invasive haemodynamic indices.' ) ),
		array( 'year' => 2019, 'issue' => array( 'المجلد 35، العدد 1', 'Vol. 35, No. 1' ),
			'ar' => array( 'سلامة التخدير الشوكي في الحوامل المصابات بتسمم الحمل', 'دراسة رصدية لسلامة التخدير النصفي والاستقرار الدموي لدى الأمهات.' ),
			'en' => array( 'Safety of spinal anaesthesia in pre-eclamptic parturients', 'An observational study of spinal anaesthesia safety and maternal haemodynamic stability.' ) ),
	),

	/* ------------------------------------------------------------ POSTS */
	'posts' => array(
		array( 'cat' => 'lit', 'img' => 'post-lit.jpg',
			'ar' => array( 'طب أجدادنا الفراعنة: أدلة تاريخية على جراحة القلب والأوعية في مصر القديمة', 'قراءة استكشافية في البرديات الطبية القديمة تسلط الضوء على شغف المصريين القدماء بإنقاذ الحياة ورعايتهم الاستثنائية لصحة الإنسان.',
				'<h2>أجدادنا الفراعنة: أدلة تاريخية على جراحة القلب والأوعية في مصر القديمة</h2><p>تُمثّل الحضارة المصرية القديمة منارةً خالدة لم تنطفئ شعلتها بمرور القرون، ولم تقتصر أسرار هذه الحضارة العريقة على الأهرامات الشامخة والفنون البصرية الساحرة، بل امتدت لتشمل عوالم الطب والتشريح التي سبقت عصرها بآلاف السنين. وحين نتأمل جذور العلوم الطبية الحديثة، نجد أن أجدادنا الفراعنة وضعوا حجر الأساس لأدق العلوم وأعقدها، وعلى رأسها جراحة القلب والأوعية الدموية.</p><h2>نبض الحياة.. كيف نظر الفراعنة إلى القلب؟</h2><p>لم يكن القلب عند قدماء المصريين لمجرد عضلة ضخمة لتحريك الدورة الدموية، بل اعتبروه مركز الوعي، ومستقر الروح، ومحور الحكمة والمشاعر. وفي النصوص الطبية الفرعونية القديمة، وتحديداً في "بردية إيبرس" و"بردية إدوين سميث"، نجد إشارات مذهلة ودقيقة تعكس فهماً عميقاً لما أسموه بـ "أوعية القلب" (ميتو - Metu)؛ وهي شبكة الأنابيب الحية التي تربط أعضاء الجسم بالقلب.</p><h2>إرثٌ يتجدد في أروقة العناية الحديثة</h2><p>إن استجلاء صفحات التاريخ الطبي المصري القديم يذكرنا دائماً بأن الشغف بالعلم ورعاية الإنسان وحماية الحياة هي رسالة ممتدة عبر التاريخ. فمن دقة المشرط الفرعوني وفهمهم لأوعية الحياة، إلى التقنيات الطبية المعاصرة المتقدمة مثل الإقنعة القلبية الرئوية (ECMO) ودعم الحياة المتقدم، تظل الروح المصرية تسعى دوماً نحو إتقان فنون الشفاء وصنع الأمل.</p>' . $ar_note ),
			'en' => array( 'The Medicine of Our Pharaonic Ancestors: Historical Evidence of Cardiovascular Surgery in Ancient Egypt', 'An exploratory reading of the ancient medical papyri that highlights the ancient Egyptians\' passion for saving life and their exceptional care for human health.',
				'<h2>Our Pharaonic ancestors: historical evidence of heart and vascular surgery in ancient Egypt</h2><p>Ancient Egyptian civilisation is an eternal beacon whose flame has not dimmed with the centuries. Its secrets are not limited to the towering pyramids and enchanting visual arts; they extend to the worlds of medicine and anatomy that preceded their time by thousands of years. When we trace the roots of modern medical science, we find that our Pharaonic ancestors laid the foundation stone of its most delicate and complex disciplines, foremost among them cardiovascular surgery.</p><h2>The pulse of life: how did the Pharaohs see the heart?</h2><p>To the ancient Egyptians the heart was never merely a large muscle driving circulation; they regarded it as the seat of consciousness, the dwelling of the soul and the axis of wisdom and emotion. In the ancient medical texts, notably the Ebers Papyrus and the Edwin Smith Papyrus, we find astonishing and precise references reflecting a deep understanding of what they called the "vessels of the heart" (Metu) — the living network that links the body\'s organs to the heart.</p><h2>A legacy renewed in modern care</h2><p>Revisiting the pages of ancient Egyptian medical history reminds us that passion for knowledge, care for people and the protection of life is a mission running through history. From the precision of the Pharaonic scalpel to modern techniques such as ECMO and advanced life support, the Egyptian spirit keeps striving to master the arts of healing and making hope.</p>' . $en_note ) ),
		array( 'cat' => 'med', 'img' => 'post-med.jpg',
			'ar' => array( 'التطورات الحديثة في تقنيات الإقنعة القلبية الرئوية (ECMO) ومستقبل الحياة المتقدم', 'مراجعة شاملة لأحدث الممارسات والبروتوكولات العالمية في إدارة الحالات الحرجة، وتقليل المخاطر لضمان تعافي أسرع للمرضى.',
				'<h2>ما الذي تغيّر في ممارسة ECMO؟</h2><p>شهدت السنوات الأخيرة تطوراً لافتاً في أجهزة الإقنعة القلبية الرئوية ومضخاتها وأغشيتها، مما رفع من مستوى الأمان وقلّل مضاعفات النزف والتجلط.</p><h2>نحو بروتوكولات أكثر أماناً</h2><p>تركّز الإرشادات الحديثة على الاختيار الدقيق للمرضى والمتابعة الدائمة بالموجات فوق الصوتية والفطام المبكر، لتحقيق أفضل النتائج.</p>' . $ar_note ),
			'en' => array( 'Recent Advances in ECMO Technology and the Future of Advanced Life Support', 'A comprehensive review of the latest global practices and protocols in managing critical cases and reducing risk for faster patient recovery.',
				'<h2>What has changed in ECMO practice?</h2><p>Recent years have seen striking progress in ECMO consoles, pumps and membranes, raising safety and reducing bleeding and clotting complications.</p><h2>Towards safer protocols</h2><p>Modern guidance focuses on careful patient selection, continuous ultrasound monitoring and early weaning for the best outcomes.</p>' . $en_note ) ),
		array( 'cat' => 'lit', 'img' => 'post-lit.jpg',
			'ar' => array( 'برديات إدوين سميث وإيبرس: حين كتب المصريون القدماء الطب', 'رحلة بين أقدم النصوص الطبية في التاريخ وما تحمله من ملاحظات سريرية مذهلة.',
				'<h2>أقدم كتب الطب</h2><p>تُعد بردية إدوين سميث أقدم نص جراحي معروف، فيما تضم بردية إيبرس وصفات ورؤى عن القلب والأوعية.</p>' . $ar_note ),
			'en' => array( 'The Edwin Smith and Ebers Papyri: When Ancient Egyptians Wrote Medicine', 'A journey through the oldest medical texts in history and their astonishing clinical observations.',
				'<h2>The oldest medical books</h2><p>The Edwin Smith Papyrus is the oldest known surgical text, while the Ebers Papyrus holds prescriptions and insights on the heart and vessels.</p>' . $en_note ) ),
		array( 'cat' => 'med', 'img' => 'post-med.jpg',
			'ar' => array( 'حاجز عضلة الشوكة (Erector Spinae Block): ثورة هادئة في تسكين الألم', 'كيف غيّر هذا الحصار العصبي البسيط ممارسة التخدير والتسكين بعد الجراحة.',
				'<h2>تقنية بسيطة وأثر كبير</h2><p>يُعد الحصار الموجه بالموجات فوق الصوتية لعضلة الشوكة من أكثر الطرق أماناً لتخفيف الألم، مع تقليل الحاجة للمسكنات الأفيونية.</p>' . $ar_note ),
			'en' => array( 'The Erector Spinae Block: A Quiet Revolution in Pain Relief', 'How this simple nerve block has changed anaesthesia and post-operative analgesia.',
				'<h2>A simple technique with a large effect</h2><p>The ultrasound-guided erector spinae block is among the safest ways to relieve pain while reducing the need for opioids.</p>' . $en_note ) ),
		array( 'cat' => 'lit', 'img' => 'post-lit.jpg',
			'ar' => array( 'قصر العيني: قرنان من الحكايات بين جدران المستشفى', 'عن الذاكرة المشتركة لأجيال من الأطباء والمرضى في أعرق صروح الطب بمصر.',
				'<h2>ذاكرة المكان</h2><p>لكل ممر في قصر العيني حكاية، ولكل مدرج قصة جيلٍ تعلّم فيه ثم علّم.</p>' . $ar_note ),
			'en' => array( 'Kasr Al Ainy: Two Centuries of Stories Within the Hospital Walls', 'On the shared memory of generations of doctors and patients in Egypt\'s most venerable medical institution.',
				'<h2>The memory of a place</h2><p>Every corridor at Kasr Al Ainy has a story, every lecture hall the tale of a generation that learned there and then taught.</p>' . $en_note ) ),
		array( 'cat' => 'med', 'img' => 'post-med.jpg',
			'ar' => array( 'أمان المريض أولاً: بروتوكولات تخدير الحوامل في الجراحات الطارئة', 'قراءة في أحدث التوصيات لضمان سلامة الأم والجنين.',
				'<h2>سلامة الأم والجنين</h2><p>يتطلب تخدير الحوامل في الحالات الطارئة تقييماً سريعاً لمجرى الهواء واختيار التقنية الأنسب للحالة.</p>' . $ar_note ),
			'en' => array( 'Patient Safety First: Anaesthesia Protocols for Pregnant Women in Emergency Surgery', 'A look at the latest recommendations for the safety of mother and baby.',
				'<h2>Safety of mother and baby</h2><p>Anaesthesia for pregnant women in emergencies needs rapid airway assessment and choosing the most suitable technique for the case.</p>' . $en_note ) ),
		array( 'cat' => 'lit', 'img' => 'post-lit.jpg',
			'ar' => array( 'الكلمة التي تشفي: عن الأدب والطب', 'لماذا يحتاج الطبيب إلى الأدب كما يحتاج المريض إلى الكلمة الطيبة؟',
				'<h2>حين يلتقي القلم بالمشرط</h2><p>الأدب يمنح الطبيب بصيرةً إنسانية، والطب يمنح الأدب عمقاً من التجربة.</p>' . $ar_note ),
			'en' => array( 'The Word That Heals: On Literature and Medicine', 'Why does the doctor need literature as much as the patient needs a kind word?',
				'<h2>When the pen meets the scalpel</h2><p>Literature gives the physician human insight, and medicine gives literature depth of experience.</p>' . $en_note ) ),
		array( 'cat' => 'med', 'img' => 'post-med.jpg',
			'ar' => array( 'الرعاية الحرجة بعد الجراحة: ما الجديد في تخدير الحالات عالية الخطورة؟', 'أبرز مستجدات التقييم قبل الجراحة وتخطيط الإفاقة للمرضى عاليي الخطورة.',
				'<h2>تخطيط الإفاقة</h2><p>تبدأ الرعاية الحرجة بعد الجراحة من غرفة التقييم قبل العملية، بخطة واضحة للإفاقة والمتابعة.</p>' . $ar_note ),
			'en' => array( 'Post-operative Critical Care: What\'s New in Anaesthesia for High-Risk Patients?', 'Highlights of pre-operative assessment and recovery planning for high-risk patients.',
				'<h2>Recovery planning</h2><p>Post-operative critical care starts in the pre-assessment room with a clear plan for recovery and follow-up.</p>' . $en_note ) ),
	),

	/* ------------------------------------------------------------ FAQ */
	'faq' => array(
		'ar' => array(
			array( 'ما هي أبرز التخصصات الطبية والأكاديمية التي تتميز بها الدكتورة هالة مصطفى جمعة؟', 'تتمتع الأستاذة الدكتورة هالة مصطفى جمعة بخبرة أكاديمية وسريرية عميقة وممتدة في كلية طب قصر العيني بجامعة القاهرة. وتتخصص بشكل أساسي في تخدير الحالات الحرجة، جراحات النساء والتوليد، وتقنيات الدعم المتقدم للحياة.' ),
			array( 'هل تقتصر المؤلفات والمقالات المتاحة على التخصصات الأكاديمية الطبية، أم تشمل مجالات أخرى؟', 'تشمل المؤلفات والمقالات المجالات الطبية الأكاديمية، كما تضم أعمالاً أدبية وفكرية وتاريخية تجمع بين البعد الإنساني للطب والرؤية التاريخية.' ),
			array( 'كيف يمكن للباحثين وطلاب الطب الاستفادة من المراجع والأبحاث المنشورة في الموقع؟', 'يمكنكم تصفح قسم الأبحاث العلمية للاطلاع على الملخصات وروابط الأوراق الكاملة، وشراء الكتب المرجعية المتخصصة من المكتبة.' ),
			array( 'هل تُعقد لقاءات دورية أو ندوات فكرية وثقافية تناقش الإصدارات الجديدة للدكتورة؟', 'يتم الإعلان عن اللقاءات والندوات عبر النشرة البريدية وصفحات المتابعة؛ اشتركوا في النشرة ليصلكم كل جديد.' ),
			array( 'ما هي الطريقة المثلى لمتابعة أحدث المقالات التاريخية والطبية فور نشرها؟', 'الاشتراك في النشرة البريدية ومتابعة الصفحات الرسمية على لينكدإن و ResearchGate هما أفضل وسيلة لمتابعة كل جديد.' ),
			array( 'كيف يمكنني شراء الكتب، وما هي طرق الدفع المتاحة؟', 'يمكنكم إضافة الكتب إلى السلة وإتمام الطلب داخل جمهورية مصر العربية، مع خيارين للدفع: الدفع عند الاستلام أو الدفع بالمحفظة الإلكترونية (فودافون كاش / إنستا باي).' ),
		),
		'en' => array(
			array( 'What are the main medical and academic specialities of Dr. Hala Mostafa Gomaa?', 'Prof. Dr. Hala Mostafa Gomaa has deep, long-standing academic and clinical experience at Kasr Al Ainy Faculty of Medicine, Cairo University. Her main specialities are critical-care anaesthesia, obstetric surgery and advanced life-support techniques.' ),
			array( 'Are the books and articles limited to academic medical specialities, or do they cover other fields?', 'They cover academic medicine and also literary, intellectual and historical works that combine the human side of medicine with a historical outlook.' ),
			array( 'How can researchers and medical students benefit from the references and research on the site?', 'Browse the research section for abstracts and links to full papers, and buy the specialist reference books from the library.' ),
			array( 'Are regular meetings or cultural seminars held to discuss the doctor\'s new releases?', 'Meetings and seminars are announced through the newsletter and follow pages; subscribe to receive every update.' ),
			array( 'What is the best way to follow the latest historical and medical articles as soon as they are published?', 'Subscribing to the newsletter and following the official LinkedIn and ResearchGate pages is the best way to stay up to date.' ),
			array( 'How can I buy the books, and what payment methods are available?', 'Add books to your cart and check out within Egypt, with two payment options: cash on delivery or e-wallet payment (Vodafone Cash / InstaPay).' ),
		),
	),

	/* ------------------------------------------------------------ POLICIES */
	'policies' => array(
		'terms' => array(
			'slug' => 'refund-policy',
			'ar'   => array(
				'title'   => 'سياسة الاسترجاع والإستبدال',
				'updated' => '26 أكتوبر 2026',
				'sections' => array(
					array( 'استرجاع واستبدال الكتب المطبوعة', '<ul><li>يحق للعميل طلب استبدال أو استرجاع الكتاب المطبوع في حال وجود عيب طباعي أو تلف في النسخة خلال 7 أيام من تاريخ الاستلام.</li><li>يُشترط أن يكون الكتاب بحالته الأصلية تماماً، وغير مستخدم، وبغلافه الأصلي.</li><li>في حال كان التلف ناتجاً عن خطأ من قِبلنا أو شركة الشحن، يتحمل الموقع تكلفة الاستبدال والشحن بالكامل.</li></ul>' ),
					array( 'الكتب الرقمية والنسخ الإلكترونية', '<ul><li>نظراً لطبيعة الكتب والملفات الرقمية (النسخ الإلكترونية أو روابط التحميل)، لا يمكن استرجاعها أو استبدالها بعد إتمام عملية الشراء وتفعيل التحميل، حرصاً على حقوق الملكية الفكرية.</li></ul>' ),
				),
				'closing' => '',
			),
			'en'   => array(
				'title'   => 'Refund & Exchange Policy',
				'updated' => '26 October 2026',
				'sections' => array(
					array( 'Returns and exchanges of printed books', '<ul><li>Customers may request an exchange or return of a printed book if it has a printing defect or is damaged within 7 days of receipt.</li><li>The book must be in its original condition, unused and in its original cover.</li><li>If the damage was caused by our error or the courier, the site bears the full cost of exchange and shipping.</li></ul>' ),
					array( 'Digital books and electronic copies', '<ul><li>Due to the nature of digital books and files (electronic copies or download links), they cannot be returned or exchanged once the purchase is complete and the download is activated, to protect intellectual property rights.</li></ul>' ),
				),
				'closing' => '',
			),
		),
		'privacy' => array(
			'slug' => 'privacy-policy',
			'ar'   => array(
				'title'   => 'سياسة الخصوصية',
				'updated' => '26 أكتوبر 2026',
				'sections' => array(
					array( 'المعلومات التي نقوم بجمعها', '<p><strong>نقوم بجمع المعلومات التالية عند تفاعلك مع الموقع:</strong></p><ul><li>الاسم الكامل</li><li>بيانات التواصل مثل البريد الإلكتروني ورقم الهاتف (عند الاشتراك في النشرة البريدية أو التواصل للاستفسارات).</li><li>المعلومات المقدمة عبر نماذج التواصل أو طلبات اقتناء الكتب والمقالات.</li><li>موقع الزائر الجغرافي وتقنيات التصفح العامة لتحسين جودة محتوى الموقع.</li></ul>' ),
					array( 'استخدام المعلومات', '<p><strong>يتم استخدام المعلومات الشخصية التي نجمعها للأغراض التالية:</strong></p><ul><li>إرسال الإشعارات والتحديثات عند صدور كتب أو مقالات جديدة.</li><li>التواصل مع الزوار للرد على الاستفسارات والمراسلات الأكاديمية أو المهنية.</li><li>تحسين مستوى الخدمات المعرفية وتطوير محتوى الموقع بناءً على اهتمامات الزوار.</li><li>إرسال النشرة البريدية الإخبارية (للراغبين في متابعة كل جديد).</li></ul>' ),
					array( 'ملفات تعريف الارتباط (Cookies)', '<ul><li>قد يستخدم موقعنا ملفات تعريف الارتباط لتحسين تجربة التصفح وتخصيص المحتوى. يمكنكم تعطيل هذه الملفات في أي وقت من إعدادات المتصفح الخاص بكم.</li></ul>' ),
				),
				'closing' => 'بتصفحك لموقع د. هالة مصطفى جمعة أو استخدامك لخدماتنا، فإنك توافق على سياسة الخصوصية هذه وتقر بأنك قرأتها وفهمتها.',
			),
			'en'   => array(
				'title'   => 'Privacy Policy',
				'updated' => '26 October 2026',
				'sections' => array(
					array( 'Information we collect', '<p><strong>We collect the following information when you interact with the site:</strong></p><ul><li>Full name</li><li>Contact details such as email and phone number (when subscribing to the newsletter or contacting us with enquiries).</li><li>Information provided through contact forms or requests for books and articles.</li><li>Visitor geographic location and general browsing technologies to improve the quality of site content.</li></ul>' ),
					array( 'How we use information', '<p><strong>The personal information we collect is used for the following purposes:</strong></p><ul><li>Sending notifications and updates when new books or articles are published.</li><li>Communicating with visitors to answer academic or professional enquiries.</li><li>Improving knowledge services and developing site content based on visitors\' interests.</li><li>Sending the email newsletter (for those who wish to follow every update).</li></ul>' ),
					array( 'Cookies', '<ul><li>Our site may use cookies to improve your browsing experience and personalise content. You can disable them at any time in your browser settings.</li></ul>' ),
				),
				'closing' => 'By browsing Dr. Hala Mostafa Gomaa\'s site or using our services, you agree to this privacy policy and acknowledge that you have read and understood it.',
			),
		),
	),

	/* ------------------------------------------------------------ ABOUT */
	'about' => array(
		'ar' => array(
			'title'  => '*مسيرة* في علم التخدير وإبداع الأدب',
			'intro'  => 'أستاذة التخدير بكلية طب قصر العيني – جامعة القاهرة، طبيبة، باحثة ومؤلفة تجمع بين الرعاية الطبية الدقيقة في تخدير الحالات الحرجة والإثراء المعرفي والأدبي المعاصر.',
			'timeline' => array(
				array( '2010', 'درجة الأستاذية', 'نالت درجة الأستاذية في التخدير والرعاية المركزة بكلية طب قصر العيني، جامعة القاهرة.' ),
				array( '2000 – 2010', 'التدريس والإشراف الأكاديمي', 'إشراف على رسائل الماجستير والدكتوراه وتدريس تخصصي لطلاب الدراسات العليا. (نص تجريبي)' ),
				array( '1990s', 'البدايات الأكاديمية', 'بداية المسيرة بين مدرجات قصر العيني وغرف عملياته. (نص تجريبي)' ),
			),
			'specs'  => array(
				array( 'تخدير الحالات الحرجة', 'إدارة المرضى عاليي الخطورة في غرف العمليات والعناية المركزة. (نص تجريبي)' ),
				array( 'جراحات النساء والتوليد', 'تخدير الحوامل وضمان سلامة الأم والجنين. (نص تجريبي)' ),
				array( 'الدعم المتقدم للحياة', 'تقنيات الإقنعة القلبية الرئوية (ECMO) والعناية المتقدمة. (نص تجريبي)' ),
			),
			'content' => '<p>نبذة تفصيلية عن مسيرة الأستاذة الدكتورة هالة مصطفى جمعة. <em>[نص تجريبي — يُستبدل بالسيرة الذاتية الحقيقية]</em></p>',
		),
		'en' => array(
			'title'  => 'A *journey* in anaesthesia and literary creativity',
			'intro'  => 'Professor of Anaesthesia at Kasr Al Ainy Faculty of Medicine, Cairo University; physician, researcher and author, combining precise clinical care in critically ill patients with scientific enrichment and contemporary literature.',
			'timeline' => array(
				array( '2010', 'Professorship', 'Awarded the professorship in anaesthesia and intensive care at Kasr Al Ainy Faculty of Medicine, Cairo University.' ),
				array( '2000 – 2010', 'Teaching and academic supervision', 'Supervision of MSc and MD theses and specialist teaching for postgraduate students. (Placeholder text)' ),
				array( '1990s', 'Academic beginnings', 'The start of the journey between the lecture halls and operating theatres of Kasr Al Ainy. (Placeholder text)' ),
			),
			'specs'  => array(
				array( 'Critical-care anaesthesia', 'Managing high-risk patients in theatre and intensive care. (Placeholder text)' ),
				array( 'Obstetric surgery', 'Anaesthesia for pregnant women and safeguarding mother and baby. (Placeholder text)' ),
				array( 'Advanced life support', 'ECMO techniques and advanced critical care. (Placeholder text)' ),
			),
			'content' => '<p>A detailed profile of Prof. Dr. Hala Mostafa Gomaa\'s career. <em>[Placeholder text — replace with the real biography]</em></p>',
		),
	),
);
