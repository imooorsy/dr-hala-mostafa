<?php
/**
 * Theme setup: supports, menus, image sizes, cleanup, query tweaks.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	static function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'automatic-feed-links' );

		register_nav_menus(
			array(
				'primary'       => 'Primary menu',
				'footer_pages'  => 'Footer — Pages',
				'footer_more'   => 'Footer — More',
				'footer_legal'  => 'Footer bar — legal links',
			)
		);

		add_image_size( 'hala-cover', 640, 720, true );
		add_image_size( 'hala-card', 720, 450, true );
		add_image_size( 'hala-wide', 1280, 640, true );
		add_image_size( 'hala-portrait', 800, 900, true );
		add_image_size( 'hala-thumb', 160, 180, true );
	}
);

/** Classic theme: drop block-editor front-end CSS and emoji/embed bloat. */
add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'wc-blocks-vendors-style' );
	},
	100
);
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

add_filter( 'excerpt_length', static fn() => 26 );
add_filter( 'excerpt_more', static fn() => '…' );

/** Body classes: language + hide cart pill on cart/checkout. */
add_filter(
	'body_class',
	static function ( $classes ) {
		$classes[] = 'lang-' . hala_lang();
		if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() ) ) {
			$classes[] = 'hide-on-cart';
		}
		return $classes;
	}
);

/** Mark JS-enabled early so CSS can hide no-JS fallbacks. */
add_action(
	'wp_head',
	static function () {
		echo "<script>document.documentElement.classList.add('js');</script>\n"; // phpcs:ignore
		foreach ( array( 'el-messiri-arabic', 'cairo-arabic' ) as $f ) {
			printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( HALA_URI . '/assets/fonts/' . $f . '.woff2' ) );
		}
	},
	1
);

/** Query tweaks: research page size, search scoping. */
add_action(
	'pre_get_posts',
	static function ( WP_Query $q ) {
		if ( is_admin() || ! $q->is_main_query() ) {
			return;
		}
		if ( $q->is_post_type_archive( 'hala_research' ) ) {
			$q->set( 'posts_per_page', 8 );
		}
		if ( $q->is_home() ) {
			$q->set( 'posts_per_page', 9 );
		}
		if ( $q->is_search() && ! $q->get( 'post_type' ) ) {
			$q->set( 'post_type', array( 'post', 'hala_research', 'product' ) );
		}
		if ( function_exists( 'is_shop' ) && ( $q->is_post_type_archive( 'product' ) || $q->is_tax( 'product_cat' ) ) ) {
			$q->set( 'posts_per_page', 8 );
		}
	}
);

/** Prefix for archive titles etc. */
add_filter(
	'get_the_archive_title_prefix',
	static fn() => ''
);

/** Lightweight breadcrumb-free reading time helper. */
function hala_reading_time( int $post_id = 0 ): int {
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ?: get_the_ID() ) ) );
	return max( 1, (int) ceil( $words / 180 ) );
}

/** Always print dir="ltr|rtl" on <html> (WordPress omits it for LTR; our CSS mirrors icons via [dir]). */
add_filter(
	'language_attributes',
	static function ( $out ) {
		return false === strpos( $out, 'dir=' ) ? $out . ' dir="ltr"' : $out;
	}
);
