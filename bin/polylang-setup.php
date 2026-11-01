<?php
/**
 * Create Polylang languages (Arabic default RTL + English) and configure options.
 * Run: bin\wp eval-file bin/polylang-setup.php   (after the hala theme is active)
 */
if ( ! function_exists( 'PLL' ) ) {
	WP_CLI::error( 'Polylang is not active.' );
}
$model = PLL()->model;
$langs = array(
	'ar' => array( 'name' => 'العربية', 'slug' => 'ar', 'locale' => 'ar', 'rtl' => 1, 'term_group' => 0, 'flag' => 'eg' ),
	'en' => array( 'name' => 'English', 'slug' => 'en', 'locale' => 'en_US', 'rtl' => 0, 'term_group' => 1, 'flag' => 'gb' ),
);
foreach ( $langs as $slug => $args ) {
	if ( $model->get_language( $slug ) ) {
		WP_CLI::log( "Language $slug exists." );
		continue;
	}
	$r = $model->add_language( $args );
	WP_CLI::log( is_wp_error( $r ) ? "Error $slug: " . $r->get_error_message() : "Created $slug" );
}
$opts                  = get_option( 'polylang' );
$opts['default_lang']  = 'ar';
$opts['force_lang']    = 1; // Language as a directory: /en/...
$opts['hide_default']  = 1; // Arabic has no prefix.
$opts['rewrite']       = 1;
$opts['redirect_lang'] = 0;
$opts['browser']       = 0;
$opts['media_support'] = 0;
$opts['post_types']    = array_values( array_filter( array( post_type_exists( 'hala_research' ) ? 'hala_research' : '', post_type_exists( 'product' ) ? 'product' : '' ) ) );
$opts['taxonomies']    = taxonomy_exists( 'product_cat' ) ? array( 'product_cat' ) : array();
update_option( 'polylang', $opts );
flush_rewrite_rules();
WP_CLI::success( 'Polylang configured.' );
