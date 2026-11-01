<?php
/**
 * Assets: only what each template needs; scripts are deferred; no jQuery in theme code.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

function hala_asset( string $rel ): array {
	$path = HALA_DIR . '/assets/' . $rel;
	return array( HALA_URI . '/assets/' . $rel, file_exists( $path ) ? (string) filemtime( $path ) : HALA_VERSION );
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		$css = array( 'fonts', 'tokens', 'base', 'components', 'extras', 'layout' );
		$prev = array();
		foreach ( $css as $name ) {
			list( $src, $ver ) = hala_asset( "css/{$name}.css" );
			wp_enqueue_style( "hala-{$name}", $src, $prev, $ver );
			$prev = array( "hala-{$name}" );
		}

		$is_woo_flow = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
		$extra       = array();
		if ( is_front_page() || is_page_template( 'page-about.php' ) ) {
			$extra[] = 'home';
		}
		if ( ! is_front_page() ) {
			$extra[] = 'listing';
		}
		if ( is_singular( array( 'product', 'post', 'hala_research' ) ) ) {
			$extra[] = 'single';
		}
		if ( $is_woo_flow ) {
			$extra[] = 'shop';
		}
		foreach ( $extra as $name ) {
			list( $src, $ver ) = hala_asset( "css/{$name}.css" );
			wp_enqueue_style( "hala-{$name}", $src, array( 'hala-layout' ), $ver );
		}

		$js_args = array( 'strategy' => 'defer', 'in_footer' => true );
		list( $src, $ver ) = hala_asset( 'js/main.js' );
		wp_enqueue_script( 'hala-main', $src, array(), $ver, $js_args );
		wp_localize_script(
			'hala-main',
			'halaData',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'hala_ajax' ),
				'rtl'   => is_rtl(),
				'lang'  => hala_lang(),
				'i18n'  => array(
					'sending' => hala_s( 'Sending…' ),
					'error'   => hala_s( 'Something went wrong. Please try again.' ),
					'invalid' => hala_s( 'Please check the highlighted fields.' ),
				),
			)
		);

		if ( is_front_page() || is_singular( array( 'post', 'product' ) ) ) {
			list( $src, $ver ) = hala_asset( 'js/carousel.js' );
			wp_enqueue_script( 'hala-carousel', $src, array(), $ver, $js_args );
		}
		if ( is_home() || ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) ) {
			list( $src, $ver ) = hala_asset( 'js/filter.js' );
			wp_enqueue_script( 'hala-filter', $src, array(), $ver, $js_args );
		}
		if ( $is_woo_flow || is_singular( 'product' ) ) {
			list( $src, $ver ) = hala_asset( 'js/shop.js' );
			wp_enqueue_script( 'hala-shop', $src, array(), $ver, $js_args );
		}
	}
);
