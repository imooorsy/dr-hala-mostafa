<?php
/**
 * Menu rendering with sensible fallbacks (so the site works before menus are built).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

/** Fallback items per location: [ label, url ]. */
function hala_default_menu_items( string $location ): array {
	switch ( $location ) {
		case 'primary':
			return array(
				array( hala_s( 'About the doctor' ), hala_url( 'about' ) ),
				array( hala_s( 'Scientific & literary books' ), hala_url( 'shop' ) ),
				array( hala_s( 'Blog' ), hala_url( 'blog' ) ),
				array( hala_s( 'Contact me' ), hala_url( 'contact' ) ),
			);
		case 'footer_pages':
			return array(
				array( hala_s( 'Home' ), home_url( '/' ) ),
				array( hala_s( 'Medical & literary books' ), hala_url( 'shop' ) ),
				array( hala_s( 'Scientific research' ), hala_url( 'research' ) ),
				array( hala_s( 'Blog' ), hala_url( 'blog' ) ),
				array( hala_s( 'Contact' ), hala_url( 'contact' ) ),
			);
		case 'footer_more':
			return array(
				array( hala_s( 'Refund & exchange policy' ), hala_url( 'terms' ) ),
				array( hala_s( 'Privacy policy' ), hala_url( 'privacy' ) ),
				array( hala_s( 'FAQ' ), hala_url( 'faq' ) ),
			);
		case 'footer_legal':
			return array(
				array( hala_s( 'Privacy policy' ), hala_url( 'privacy' ) ),
				array( hala_s( 'Refund & exchange policy' ), hala_url( 'terms' ) ),
			);
	}
	return array();
}

/**
 * Print a menu: the assigned WP menu if present, otherwise defaults.
 *
 * @param string $location Registered location.
 * @param string $class    <ul> class.
 */
function hala_menu( string $location, string $class = '' ): void {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => $class,
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		return;
	}
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( hala_default_menu_items( $location ) as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item[1] ), esc_html( $item[0] ) );
	}
	echo '</ul>';
}

/** Cart pill markup (also used as a WooCommerce fragment). */
function hala_cart_pill(): string {
	$n = hala_cart_count();
	return sprintf(
		'<a class="cart-pill" href="%1$s" aria-label="%2$s">%3$s<span class="cart-pill__label">%4$s</span><span class="cart-count" data-count="%5$d">%5$d</span></a>',
		esc_url( hala_url( 'cart' ) ),
		esc_attr( hala_s( 'Cart' ) ),
		hala_icon( 'cart' ),
		esc_html( hala_s( 'Cart' ) ),
		$n
	);
}
