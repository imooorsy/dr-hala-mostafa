<?php
/**
 * Translation layer.
 *
 * Source strings are English (gettext-ready, text domain "hala", see languages/hala.pot).
 * Arabic equivalents live in inc/strings.php, so a fresh clone renders fully Arabic before any
 * Polylang string translation is saved. Editors can override any string under
 * Languages > Translations (Polylang): a saved translation always wins.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

/** English => Arabic map. */
function hala_strings(): array {
	static $map = null;
	if ( null === $map ) {
		$map = require HALA_DIR . '/inc/strings.php';
	}
	return $map;
}

/** Translate a UI string. */
function hala_s( string $s ): string {
	if ( function_exists( 'pll__' ) ) {
		$t = pll__( $s );
		if ( $t !== $s ) {
			return $t;
		}
	}
	if ( 'ar' === hala_lang() ) {
		$map = hala_strings();
		if ( isset( $map[ $s ] ) ) {
			return $map[ $s ];
		}
	}
	// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
	return __( $s, 'hala' );
}

/** Echo a translated, escaped UI string. */
function hala_e( string $s ): void {
	echo esc_html( hala_s( $s ) );
}

/** Register every string with Polylang so it shows under Languages > Translations. */
add_action(
	'init',
	static function () {
		if ( ! function_exists( 'pll_register_string' ) ) {
			return;
		}
		foreach ( array_keys( hala_strings() ) as $s ) {
			pll_register_string( md5( $s ), $s, 'Hala Theme', strlen( $s ) > 70 );
		}
	},
	20
);

/** Let Polylang translate our CPT (research) and taxonomies. */
add_filter(
	'pll_get_post_types',
	static function ( $types, $is_settings ) {
		$types['hala_research'] = 'hala_research';
		if ( post_type_exists( 'product' ) ) {
			$types['product'] = 'product'; // Mirrors what Polylang for WooCommerce does.
		}
		return $types;
	},
	10,
	2
);
add_filter(
	'pll_get_taxonomies',
	static function ( $taxes ) {
		$taxes['product_cat'] = 'product_cat';
		return $taxes;
	},
	10
);

/** Theme textdomain (gettext fallback). */
add_action(
	'after_setup_theme',
	static function () {
		load_theme_textdomain( 'hala', HALA_DIR . '/languages' );
	}
);
