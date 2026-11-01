<?php
/**
 * Hala theme bootstrap.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

define( 'HALA_VERSION', '1.0.0' );
define( 'HALA_DIR', get_template_directory() );
define( 'HALA_URI', get_template_directory_uri() );

$hala_includes = array(
	'helpers',
	'i18n',
	'setup',
	'menus',
	'enqueue',
	'cpt',
	'forms',
	'ajax',
	'acf/loader',
);
foreach ( $hala_includes as $hala_file ) {
	require_once HALA_DIR . '/inc/' . $hala_file . '.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	require_once HALA_DIR . '/inc/woocommerce/setup.php';
}
