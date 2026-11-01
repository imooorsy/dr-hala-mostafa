<?php
/**
 * ACF / Secure Custom Fields: JSON sync, per-language options, field-group helpers.
 * Field groups are registered in PHP (version-controlled) and also synced to /acf-json.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'acf/settings/save_json', static fn() => HALA_DIR . '/acf-json' );
add_filter(
	'acf/settings/load_json',
	static function ( $paths ) {
		$paths[] = HALA_DIR . '/acf-json';
		return $paths;
	}
);

/**
 * Options are stored per language: post_id "options" becomes "options_ar" / "options_en".
 */
add_filter(
	'acf/validate_post_id',
	static function ( $post_id, $original = '' ) {
		if ( 'options' === $post_id || 'option' === $post_id || 'options' === $original || 'option' === $original ) {
			$lang = '';
			if ( function_exists( 'pll_current_language' ) ) {
				$lang = (string) pll_current_language();
				if ( ! $lang && function_exists( 'pll_default_language' ) ) {
					$lang = (string) pll_default_language();
				}
			}
			return 'options_' . ( $lang ? $lang : 'ar' );
		}
		return $post_id;
	},
	20,
	2
);

/** Build an ACF field array with a unique key. Sub fields get keys from the parent. */
function hala_fld( string $g, string $type, string $name, string $label, array $x = array() ): array {
	$f = array( 'key' => "field_{$g}_{$name}", 'label' => $label, 'name' => $name, 'type' => $type ) + $x;
	return $f;
}

function hala_tab( string $g, string $name, string $label ): array {
	return array( 'key' => "field_{$g}_tab_{$name}", 'label' => $label, 'name' => '', 'type' => 'tab', 'placement' => 'top' );
}

function hala_toggle( string $g, string $name, string $label ): array {
	return hala_fld( $g, 'true_false', $name, $label, array( 'ui' => 1, 'default_value' => 1, 'ui_on_text' => 'On', 'ui_off_text' => 'Off' ) );
}

function hala_img_fld( string $g, string $name, string $label, string $instr = '' ): array {
	return hala_fld( $g, 'image', $name, $label, array( 'return_format' => 'array', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => $instr ) );
}

/** Repeater with sub fields; sub-field keys are namespaced by the parent field. */
function hala_rep( string $g, string $name, string $label, array $subs, array $x = array() ): array {
	$prefix = "{$g}_{$name}";
	foreach ( $subs as &$s ) {
		$s['key'] = "field_{$prefix}_{$s['name']}";
	}
	unset( $s );
	return hala_fld( $g, 'repeater', $name, $label, array( 'layout' => 'block', 'button_label' => 'Add row', 'sub_fields' => $subs ) + $x );
}

function hala_sub( string $type, string $name, string $label, array $x = array() ): array {
	return array( 'key' => '', 'label' => $label, 'name' => $name, 'type' => $type ) + $x;
}

add_action(
	'acf/init',
	static function () {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => 'Site settings (per language)',
					'menu_title' => 'Site settings',
					'menu_slug'  => 'hala-settings',
					'capability' => 'manage_options',
					'post_id'    => 'options',
					'icon_url'   => 'dashicons-admin-generic',
					'position'   => 59,
					'redirect'   => false,
				)
			);
		}
	},
	5
);

foreach ( array( 'options', 'home', 'pages', 'product', 'research' ) as $hala_acf_file ) {
	require_once HALA_DIR . '/inc/acf/' . $hala_acf_file . '.php';
}
