<?php
/**
 * Seed demo content (Arabic + English). Idempotent: safe to run more than once.
 *
 *   bin\wp eval-file bin/seed.php
 *
 * All text is placeholder content for the client to replace (marked "[نص تجريبي]" / "[Placeholder text]").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Run with: wp eval-file bin/seed.php\n" );
}
if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'update_field' ) ) {
	WP_CLI::error( 'Polylang and Secure Custom Fields / ACF must be active, and the "hala" theme activated.' );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$data = require __DIR__ . '/seed-data.php';
$S    = hala_strings(); // English => Arabic UI strings (reused for ACF defaults).
$GLOBALS['S'] = $S; // eval-file runs inside a function scope; helpers use the global.
$langs = array( 'ar', 'en' );

/* ---------- helpers ---------- */
function seed_log( $m ) { WP_CLI::log( $m ); }

/** Import a placeholder image into the media library once. */
function seed_media( string $file, string $title ): int {
	$found = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'meta_key' => '_hala_seed_file', 'meta_value' => $file, 'numberposts' => 1, 'fields' => 'ids' ) ); // phpcs:ignore
	if ( $found ) {
		return (int) $found[0];
	}
	$src = HALA_DIR . '/assets/images/placeholders/' . $file;
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	$tmp = wp_tempnam( $file );
	copy( $src, $tmp );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0, $title );
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( 'Media: ' . $id->get_error_message() );
		return 0;
	}
	update_post_meta( $id, '_hala_seed_file', $file );
	update_post_meta( $id, '_wp_attachment_image_alt', $title );
	return (int) $id;
}

/** Find a seeded post by key + language. */
function seed_find( string $key, string $lang ): int {
	$q = get_posts( array( 'post_type' => 'any', 'post_status' => 'any', 'meta_key' => '_hala_seed', 'meta_value' => $key . '|' . $lang, 'numberposts' => 1, 'fields' => 'ids', 'suppress_filters' => true ) ); // phpcs:ignore
	return $q ? (int) $q[0] : 0;
}

/** Create or update a post and set its Polylang language. */
function seed_post( string $key, string $lang, array $args ): int {
	$id   = seed_find( $key, $lang );
	$slug = $args['post_name'] ?? '';
	$args += array( 'post_status' => 'publish', 'post_type' => 'page' );
	if ( $id ) {
		$args['ID'] = $id;
		wp_update_post( $args );
	} else {
		$id = wp_insert_post( $args );
		update_post_meta( $id, '_hala_seed', $key . '|' . $lang );
	}
	pll_set_post_language( $id, $lang );
	if ( $slug ) {
		wp_update_post( array( 'ID' => $id, 'post_name' => $slug ) ); // Re-apply once the language is known so slugs may repeat across languages.
	}
	return (int) $id;
}

function seed_link( array $ids ): void {
	pll_save_post_translations( $ids );
}

/** Update an ACF field by key (works without relying on name lookup). */
function seed_acf( string $group, string $name, $value, $post_id ): void {
	update_field( "field_{$group}_{$name}", $value, $post_id );
}

/** Translate a UI string for a language using the theme map. */
function seed_t( string $en, string $lang ): string {
	global $S;
	return 'ar' === $lang && isset( $S[ $en ] ) ? $S[ $en ] : $en;
}

/* ---------- 0. WooCommerce pages ---------- */
if ( class_exists( 'WC_Install' ) && ! wc_get_page_id( 'cart' ) ) {
	WC_Install::create_pages();
}
$wc = array(
	'shop'      => (int) get_option( 'woocommerce_shop_page_id' ),
	'cart'      => (int) get_option( 'woocommerce_cart_page_id' ),
	'checkout'  => (int) get_option( 'woocommerce_checkout_page_id' ),
	'myaccount' => (int) get_option( 'woocommerce_myaccount_page_id' ),
);
$wc_titles = array(
	'shop'      => array( 'الكتب', 'Books' ),
	'cart'      => array( 'السلة', 'Cart' ),
	'checkout'  => array( 'الدفع', 'Checkout' ),
	'myaccount' => array( 'حسابي', 'My account' ),
);
foreach ( $wc as $k => $pid ) {
	if ( ! $pid ) {
		continue;
	}
	$upd = array( 'ID' => $pid, 'post_title' => $wc_titles[ $k ][0] );
	// Classic shortcodes (not blocks) so the theme's WooCommerce templates are used.
	if ( 'cart' === $k ) { $upd['post_content'] = '[woocommerce_cart]'; }
	if ( 'checkout' === $k ) { $upd['post_content'] = '[woocommerce_checkout]'; }
	wp_update_post( $upd );
	pll_set_post_language( $pid, 'ar' );
}
// English versions of cart / checkout / account (shop archive is the product archive, no page needed).
$wc_en = array();
foreach ( array( 'cart', 'checkout', 'myaccount' ) as $k ) {
	if ( empty( $wc[ $k ] ) ) {
		continue;
	}
	$content = get_post_field( 'post_content', $wc[ $k ] );
	$wc_en[ $k ] = seed_post( "wc-{$k}", 'en', array( 'post_title' => $wc_titles[ $k ][1], 'post_name' => $wc[ $k ] ? get_post_field( 'post_name', $wc[ $k ] ) : $k, 'post_content' => $content ) );
	seed_link( array( 'ar' => $wc[ $k ], 'en' => $wc_en[ $k ] ) );
}
seed_log( 'WooCommerce pages ready.' );

/* ---------- 1. Core pages ---------- */
$page_ids = array();
$pages    = array(
	'home'    => array( 'slug' => 'home', 'tpl' => 'front-page.php', 'title' => array( 'الرئيسية', 'Home' ) ),
	'about'   => array( 'slug' => 'about', 'tpl' => 'page-about.php', 'title' => array( 'عن الدكتورة', 'About the doctor' ) ),
	'blog'    => array( 'slug' => 'blog', 'tpl' => '', 'title' => array( 'المدونة', 'Blog' ) ),
	'contact' => array( 'slug' => 'contact', 'tpl' => 'page-contact.php', 'title' => array( 'تواصل معي', 'Contact me' ) ),
	'faq'     => array( 'slug' => 'faq', 'tpl' => 'page-faq.php', 'title' => array( 'الأسئلة الشائعة', 'FAQ' ) ),
);
foreach ( $pages as $key => $p ) {
	$ids = array();
	foreach ( $langs as $i => $lang ) {
		$content = '';
		if ( 'about' === $key ) {
			$content = $data['about'][ $lang ]['content'];
		}
		$ids[ $lang ] = seed_post( "page-{$key}", $lang, array( 'post_title' => $p['title'][ $i ], 'post_name' => $p['slug'], 'post_content' => $content, 'meta_input' => $p['tpl'] ? array( '_wp_page_template' => $p['tpl'] ) : array() ) );
	}
	seed_link( $ids );
	$page_ids[ $key ] = $ids;
}
// Policies.
foreach ( $data['policies'] as $key => $pol ) {
	$ids = array();
	foreach ( $langs as $lang ) {
		$d    = $pol[ $lang ];
		$ids[ $lang ] = seed_post( "page-{$key}", $lang, array( 'post_title' => $d['title'], 'post_name' => $pol['slug'], 'meta_input' => array( '_wp_page_template' => 'page-policy.php' ) ) );
		seed_acf( 'policy', 'hero_title', $d['title'], $ids[ $lang ] );
		seed_acf( 'policy', 'updated', $d['updated'], $ids[ $lang ] );
		seed_acf( 'policy', 'closing', $d['closing'], $ids[ $lang ] );
		$rows = array();
		foreach ( $d['sections'] as $s ) {
			$rows[] = array( 'heading' => $s[0], 'body' => $s[1] );
		}
		seed_acf( 'policy', 'sections', $rows, $ids[ $lang ] );
	}
	seed_link( $ids );
	$page_ids[ $key ] = $ids;
}
update_option(
	'hala_pages',
	array(
		'about'   => $page_ids['about']['ar'],
		'contact' => $page_ids['contact']['ar'],
		'faq'     => $page_ids['faq']['ar'],
		'privacy' => $page_ids['privacy']['ar'],
		'terms'   => $page_ids['terms']['ar'],
	)
);
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_ids['home']['ar'] );
update_option( 'page_for_posts', $page_ids['blog']['ar'] );
update_option( 'wp_page_for_privacy_policy', $page_ids['privacy']['ar'] );
seed_log( 'Pages created and linked.' );

/* ---------- 2. Page fields ---------- */
foreach ( $langs as $lang ) {
	$h = $page_ids['home'][ $lang ];
	foreach ( array( 'hero', 'exp', 'books', 'ann', 'res', 'art', 'vis' ) as $sec ) {
		seed_acf( 'home', "{$sec}_on", 1, $h );
	}
	seed_acf( 'home', 'bcta_on', 1, $h );
	seed_acf( 'home', 'nl_on', 1, $h );
	seed_acf( 'home', 'hero_image', seed_media( 'portrait.jpg', 'Portrait' ), $h );
	seed_acf( 'home', 'vis_image', seed_media( 'portrait-2.jpg', 'Portrait' ), $h );
	seed_acf( 'home', 'vis_art', seed_media( 'tablet.png', 'Hieroglyph tablet' ), $h );
	seed_acf( 'home', 'ann_art', seed_media( 'ecmo.png', 'Illustration' ), $h );
	seed_acf( 'home', 'hero_title', seed_t( "Between the precision of *medicine* and the majesty of the word\nA journey in anaesthesia and literary creativity", $lang ), $h );

	$a = $page_ids['about'][ $lang ];
	$ab = $data['about'][ $lang ];
	seed_acf( 'about', 'title', $ab['title'], $a );
	seed_acf( 'about', 'intro', $ab['intro'], $a );
	seed_acf( 'about', 'image', seed_media( 'portrait.jpg', 'Portrait' ), $a );
	seed_acf( 'about', 'timeline_heading', 'ar' === $lang ? 'المسيرة *المهنية*' : 'Career *timeline*', $a );
	seed_acf( 'about', 'timeline', array_map( static fn( $r ) => array( 'year' => $r[0], 'title' => $r[1], 'text' => $r[2] ), $ab['timeline'] ), $a );
	seed_acf( 'about', 'spec_heading', 'ar' === $lang ? 'مجالات *التخصص*' : 'Fields of *specialty*', $a );
	seed_acf( 'about', 'specialties', array_map( static fn( $r ) => array( 'title' => $r[0], 'text' => $r[1] ), $ab['specs'] ), $a );

	$f = $page_ids['faq'][ $lang ];
	seed_acf( 'faq', 'hero_title', seed_t( 'Frequently asked questions', $lang ), $f );
	seed_acf( 'faq', 'heading', seed_t( 'Frequently asked questions:', $lang ), $f );
	seed_acf( 'faq', 'items', array_map( static fn( $r ) => array( 'q' => $r[0], 'a' => $r[1] ), $data['faq'][ $lang ] ), $f );

	$c = $page_ids['contact'][ $lang ];
	seed_acf( 'contact', 'title', seed_t( 'We welcome *hearing* from you', $lang ), $c );
}
seed_log( 'Page fields filled.' );

/* ---------- 3. Categories ---------- */
function seed_term( string $tax, string $slug, string $name, string $lang, string $kind, string $badge ): int {
	$t = term_exists( $slug, $tax );
	if ( ! $t ) {
		$t = wp_insert_term( $name, $tax, array( 'slug' => $slug ) );
	}
	$id = is_array( $t ) ? (int) $t['term_id'] : (int) $t;
	pll_set_term_language( $id, $lang );
	update_term_meta( $id, 'hala_kind', $kind );
	update_term_meta( $id, 'hala_badge', $badge );
	return $id;
}
$cat = array();
$cat['post']['med']['ar'] = seed_term( 'category', 'medical-articles', 'مقالات طبية', 'ar', 'med', 'طبي' );
$cat['post']['med']['en'] = seed_term( 'category', 'medical-articles-en', 'Medical articles', 'en', 'med', 'Medical' );
$cat['post']['lit']['ar'] = seed_term( 'category', 'literature-history', 'أدب وتاريخ', 'ar', 'lit', 'أدبي' );
$cat['post']['lit']['en'] = seed_term( 'category', 'literature-history-en', 'Literature & history', 'en', 'lit', 'Literary' );
$cat['prod']['med']['ar'] = seed_term( 'product_cat', 'medical-books', 'مقالات طبية', 'ar', 'med', 'طبي' );
$cat['prod']['med']['en'] = seed_term( 'product_cat', 'medical-books-en', 'Medical', 'en', 'med', 'Medical' );
$cat['prod']['lit']['ar'] = seed_term( 'product_cat', 'literary-books', 'أدب وتاريخ', 'ar', 'lit', 'أدبي' );
$cat['prod']['lit']['en'] = seed_term( 'product_cat', 'literary-books-en', 'Literary', 'en', 'lit', 'Literary' );
foreach ( array( 'post', 'prod' ) as $g ) {
	foreach ( array( 'med', 'lit' ) as $k ) {
		pll_save_term_translations( $cat[ $g ][ $k ] );
	}
}
// The default "Uncategorised" category stays Arabic-only and unused.
seed_log( 'Categories created.' );

/* ---------- 4. Books (WooCommerce) ---------- */
foreach ( $data['books'] as $b ) {
	$ids = array();
	foreach ( $langs as $lang ) {
		$d    = $b[ $lang ];
		$key  = $b['key'];
		$pid  = seed_find( $key, $lang );
		$p    = $pid ? wc_get_product( $pid ) : new WC_Product_Simple();
		$p->set_name( $d['title'] );
		$p->set_status( 'publish' );
		$p->set_catalog_visibility( 'visible' );
		$p->set_regular_price( (string) $b['price'] );
		$p->set_price( (string) $b['price'] );
		$p->set_short_description( $d['excerpt'] );
		$p->set_description( $d['content'] );
		$p->set_manage_stock( false );
		$p->set_stock_status( 'instock' );
		$p->set_category_ids( array( $cat['prod'][ $b['cat'] ][ $lang ] ) );
		$p->set_image_id( seed_media( $b['img'], $d['title'] ) );
		$p->set_slug( 'ar' === $lang ? $key : $key . '-en' );
		$pid = $p->save();
		update_post_meta( $pid, '_hala_seed', $key . '|' . $lang );
		pll_set_post_language( $pid, $lang );
		wp_update_post( array( 'ID' => $pid, 'post_name' => $key ) ); // Same slug per language is fine under Polylang.
		seed_acf( 'book', 'eyebrow', $d['eyebrow'], $pid );
		seed_acf( 'book', 'includes_title', $d['inc_t'], $pid );
		seed_acf( 'book', 'includes', $d['inc'], $pid );
		seed_acf( 'book', 'why_title', $d['why_t'], $pid );
		seed_acf( 'book', 'why_items', $d['why'], $pid );
		seed_acf( 'book', 'faqs', array_map( static fn( $r ) => array( 'q' => $r[0], 'a' => $r[1] ), $d['faqs'] ), $pid );
		$ids[ $lang ] = $pid;
	}
	seed_link( $ids );
}
seed_log( 'Books created.' );

/* ---------- 5. Research ---------- */
foreach ( $data['research'] as $i => $r ) {
	$ids = array();
	foreach ( $langs as $li => $lang ) {
		$id = seed_post(
			'research-' . $i,
			$lang,
			array(
				'post_type'    => 'hala_research',
				'post_title'   => $r[ $lang ][0],
				'post_excerpt' => $r[ $lang ][1],
				'post_content' => '<p>' . $r[ $lang ][1] . '</p><p><em>' . ( 'ar' === $lang ? '[نص تجريبي — يُستبدل بملخص البحث الحقيقي]' : '[Placeholder text — replace with the real abstract]' ) . '</em></p>',
				'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $i * 20 ) . ' days' ) ),
			)
		);
		seed_acf( 'res', 'journal', 'Egyptian Journal of Anaesthesia', $id );
		seed_acf( 'res', 'issue', $r['issue'][ $li ], $id );
		seed_acf( 'res', 'year', $r['year'], $id );
		seed_acf( 'res', 'authors', 'ar' === $lang ? 'هالة مصطفى جمعة وآخرون' : 'Hala Mostafa Gomaa et al.', $id );
		seed_acf( 'res', 'link', 'https://journals.lww.com/', $id );
		$ids[ $lang ] = $id;
	}
	seed_link( $ids );
}
seed_log( 'Research entries created.' );

/* ---------- 6. Blog posts ---------- */
foreach ( $data['posts'] as $i => $p ) {
	$ids = array();
	foreach ( $langs as $lang ) {
		$d  = $p[ $lang ];
		$id = seed_post(
			'post-' . $i,
			$lang,
			array(
				'post_type'     => 'post',
				'post_title'    => $d[0],
				'post_excerpt'  => $d[1],
				'post_content'  => $d[2],
				'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $i * 9 + 1 ) . ' days' ) ),
				'post_category' => array( $cat['post'][ $p['cat'] ][ $lang ] ),
			)
		);
		set_post_thumbnail( $id, seed_media( $p['img'], $d[0] ) );
		$ids[ $lang ] = $id;
	}
	seed_link( $ids );
}
seed_log( 'Articles created.' );

/* ---------- 7. Site settings (per language) ---------- */
$avatar = seed_media( 'avatar.jpg', 'Avatar' );
foreach ( $langs as $lang ) {
	$pid = 'options_' . $lang;
	seed_acf( 'opt', 'brand_avatar', $avatar, $pid );
	seed_acf( 'opt', 'brand_name', seed_t( 'Hala Mostafa', $lang ), $pid );
	seed_acf( 'opt', 'brand_name_en', 'Hala Mostafa', $pid );
	seed_acf( 'opt', 'contact_email', 'contact@dr-halamostafa.com', $pid );
	seed_acf( 'opt', 'whatsapp', '201115858 83253', $pid );
	seed_acf( 'opt', 'footer_title', seed_t( 'Together for better care and deeper thought', $lang ), $pid );
	seed_acf( 'opt', 'copyright', sprintf( seed_t( 'All rights reserved to Dr. Hala Mostafa Gomaa © %s', $lang ), gmdate( 'Y' ) ), $pid );
	// Placeholder profile links — replace with the real ones.
	seed_acf( 'opt', 'social_linkedin', 'https://www.linkedin.com/', $pid );
	seed_acf( 'opt', 'social_researchgate', 'https://www.researchgate.net/', $pid );
	seed_acf( 'opt', 'social_cairo', 'https://cu.edu.eg/', $pid );
	seed_acf( 'opt', 'social_orcid', 'https://orcid.org/', $pid );
	seed_acf( 'opt', 'nl_art', seed_media( 'bell.png', 'Bell' ), $pid );
	seed_acf( 'opt', 'bc_art', seed_media( 'glasses.png', 'Glasses on books' ), $pid );
}
seed_log( 'Site settings filled.' );

/* ---------- 8. Menus ---------- */
$theme = get_stylesheet();
$poly  = get_option( 'polylang' );
function seed_menu( string $name, array $items ): int {
	$menu = wp_get_nav_menu_object( $name );
	$id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );
	foreach ( (array) wp_get_nav_menu_items( $id ) as $old ) {
		wp_delete_post( $old->ID, true );
	}
	foreach ( $items as $pos => $it ) {
		$args = array( 'menu-item-title' => $it[0], 'menu-item-status' => 'publish', 'menu-item-position' => $pos + 1 );
		if ( is_int( $it[1] ) ) {
			$args += array( 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $it[1] );
		} else {
			$args += array( 'menu-item-type' => 'custom', 'menu-item-url' => $it[1] );
		}
		wp_update_nav_menu_item( $id, 0, $args );
	}
	return $id;
}
foreach ( $langs as $li => $lang ) {
	$home  = pll_home_url( $lang );
	$shop  = trailingslashit( $home ) . 'shop/';
	$res   = trailingslashit( $home ) . 'research/';
	$t     = static fn( $en ) => seed_t( $en, $lang );
	$menus = array(
		'primary'      => array( array( $t( 'About the doctor' ), $page_ids['about'][ $lang ] ), array( $t( 'Scientific & literary books' ), $shop ), array( $t( 'Blog' ), $page_ids['blog'][ $lang ] ), array( $t( 'Contact me' ), $page_ids['contact'][ $lang ] ) ),
		'footer_pages' => array( array( $t( 'Home' ), $page_ids['home'][ $lang ] ), array( $t( 'Medical & literary books' ), $shop ), array( $t( 'Scientific research' ), $res ), array( $t( 'Blog' ), $page_ids['blog'][ $lang ] ), array( $t( 'Contact' ), $page_ids['contact'][ $lang ] ) ),
		'footer_more'  => array( array( $t( 'Refund & exchange policy' ), $page_ids['terms'][ $lang ] ), array( $t( 'Privacy policy' ), $page_ids['privacy'][ $lang ] ), array( $t( 'FAQ' ), $page_ids['faq'][ $lang ] ) ),
		'footer_legal' => array( array( $t( 'Privacy policy' ), $page_ids['privacy'][ $lang ] ), array( $t( 'Refund & exchange policy' ), $page_ids['terms'][ $lang ] ) ),
	);
	foreach ( $menus as $loc => $items ) {
		$mid = seed_menu( "{$loc} ({$lang})", $items );
		$poly['nav_menus'][ $theme ][ $loc ][ $lang ] = $mid;
		if ( 'ar' === $lang ) {
			$locs         = (array) get_theme_mod( 'nav_menu_locations', array() );
			$locs[ $loc ] = $mid;
			set_theme_mod( 'nav_menu_locations', $locs );
		}
	}
}
update_option( 'polylang', $poly );
seed_log( 'Menus built for both languages.' );

/* ---------- 9. WooCommerce payment methods ---------- */
update_option(
	'woocommerce_cod_settings',
	array( 'enabled' => 'yes', 'title' => 'Cash on delivery', 'description' => '', 'instructions' => '', 'enable_for_methods' => array(), 'enable_for_virtual' => 'yes' )
);
update_option(
	'woocommerce_hala_ewallet_settings',
	array( 'enabled' => 'yes', 'title' => '', 'wallet_number' => '01000000000 (placeholder)', 'providers' => 'Vodafone Cash / InstaPay', 'instructions' => '' )
);
update_option( 'woocommerce_calc_shipping', 'no' );
update_option( 'woocommerce_enable_signup_and_login_from_checkout', 'no' );
update_option( 'woocommerce_ship_to_countries', 'disabled' );
update_option( 'woocommerce_enable_reviews', 'no' );
update_option( 'woocommerce_manage_stock', 'no' );
update_option( 'woocommerce_onboarding_profile', array( 'skipped' => true ) );
update_option( 'woocommerce_task_list_hidden', 'yes' );
update_option( 'woocommerce_task_list_welcome_modal_dismissed', 'yes' );
update_option( 'blogname', 'د. هالة مصطفى جمعة' );
update_option( 'blogdescription', 'أستاذة التخدير بكلية طب قصر العيني – جامعة القاهرة' );

flush_rewrite_rules();
WP_CLI::success( 'Demo content seeded.' );
