<?php
/**
 * WooCommerce integration: styles off, checkout fields, currency, fragments, gateways.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/class-gateway-ewallet.php';

/** We ship our own CSS. */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'loop_shop_per_page', static fn() => 8 );
add_filter( 'loop_shop_columns', static fn() => 4 );
add_filter( 'woocommerce_cart_redirect_after_add', '__return_true' );
add_filter( 'woocommerce_add_to_cart_redirect', static fn() => wc_get_cart_url() );

/** Our checkout builds its own coupon box inside the summary column. */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
/** Payment is rendered inside the main checkout column, not inside #order_review. */
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

/** Register the e-wallet gateway. */
add_filter(
	'woocommerce_payment_gateways',
	static function ( $gateways ) {
		$gateways[] = 'WC_Gateway_Hala_Ewallet';
		return $gateways;
	}
);

/** Currency label: "جنيه مصري" in Arabic, "EGP" in English. */
add_filter(
	'woocommerce_currency_symbol',
	static function ( $symbol, $currency ) {
		if ( 'EGP' === $currency ) {
			return 'ar' === hala_lang() ? 'جنيه مصري' : 'EGP';
		}
		return $symbol;
	},
	10,
	2
);
add_filter(
	'pre_option_woocommerce_currency_pos',
	static fn() => 'ar' === hala_lang() ? 'right_space' : 'left_space'
);

/** Live cart count in the header pill. */
add_filter(
	'woocommerce_add_to_cart_fragments',
	static function ( $fragments ) {
		$fragments['a.cart-pill'] = hala_cart_pill();
		return $fragments;
	}
);

/** Bilingual gateway labels (admin-edited titles are left alone when not default). */
add_filter(
	'woocommerce_gateway_title',
	static function ( $title, $id ) {
		if ( 'cod' === $id ) {
			return hala_s( 'Cash on delivery' );
		}
		return $title;
	},
	10,
	2
);
add_filter(
	'woocommerce_gateway_description',
	static function ( $desc, $id ) {
		if ( 'cod' === $id ) {
			return hala_s( 'Pay in cash when your order is delivered.' );
		}
		return $desc;
	},
	10,
	2
);
add_filter( 'woocommerce_order_button_text', static fn() => hala_s( 'Continue to payment' ) );

/** Checkout: Egypt only, simple field set (first/last name, email, phone, governorate, address, notes). */
add_filter(
	'woocommerce_checkout_fields',
	static function ( $fields ) {
		unset( $fields['billing']['billing_company'], $fields['billing']['billing_address_2'], $fields['billing']['billing_postcode'], $fields['billing']['billing_city'], $fields['billing']['billing_country'] );
		unset( $fields['shipping'], $fields['account'] );

		$b = &$fields['billing'];
		$b['billing_first_name'] = array_merge( $b['billing_first_name'], array( 'label' => hala_s( 'First name' ), 'placeholder' => hala_s( 'Type your first name here' ), 'class' => array( 'form-row-first' ), 'priority' => 10 ) );
		$b['billing_last_name']  = array_merge( $b['billing_last_name'], array( 'label' => hala_s( 'Last name' ), 'placeholder' => hala_s( 'Type your last name here' ), 'class' => array( 'form-row-last' ), 'priority' => 20 ) );
		$b['billing_email']      = array_merge( $b['billing_email'], array( 'label' => hala_s( 'Email' ), 'placeholder' => hala_s( 'Type your email here' ), 'class' => array( 'form-row-first' ), 'priority' => 30 ) );
		$b['billing_phone']      = array_merge( $b['billing_phone'], array( 'label' => hala_s( 'Phone number' ), 'placeholder' => '01xxxxxxxxx', 'class' => array( 'form-row-last' ), 'required' => true, 'priority' => 40, 'custom_attributes' => array( 'dir' => 'ltr' ) ) );
		$b['billing_state']      = array_merge( $b['billing_state'], array( 'label' => hala_s( 'Governorate' ), 'class' => array( 'form-row-wide' ), 'priority' => 50 ) );
		$b['billing_address_1']  = array_merge( $b['billing_address_1'], array( 'type' => 'textarea', 'label' => hala_s( 'Detailed address' ), 'placeholder' => hala_s( 'Type the address and a landmark here' ), 'class' => array( 'form-row-wide' ), 'priority' => 60 ) );

		if ( isset( $fields['order']['order_comments'] ) ) {
			$fields['order']['order_comments']['label']       = hala_s( 'Order notes (optional)' );
			$fields['order']['order_comments']['placeholder'] = hala_s( 'Any notes about your order or delivery' );
		}
		return $fields;
	}
);
add_filter( 'default_checkout_billing_country', static fn() => 'EG' );
add_filter( 'woocommerce_cart_needs_shipping', '__return_false' );

/** Cart / checkout page titles. */
add_filter(
	'the_title',
	static function ( $title, $id = 0 ) {
		if ( ! in_the_loop() || ! is_main_query() || ! $id ) {
			return $title;
		}
		if ( function_exists( 'is_checkout' ) && is_checkout() && ! is_wc_endpoint_url( 'order-received' ) && (int) wc_get_page_id( 'checkout' ) === (int) $id ) {
			return hala_s( 'Checkout' );
		}
		return $title;
	},
	10,
	2
);

/** Archive helpers used by templates/woocommerce/archive-product.php */
function hala_shop_terms(): array {
	$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Translate WooCommerce core page IDs through Polylang (what Polylang for WooCommerce does for pages),
 * so English visitors get /en/cart/, /en/checkout/ and the English account page.
 */
foreach ( array( 'cart', 'checkout', 'myaccount', 'terms' ) as $hala_wc_page ) {
	add_filter(
		'woocommerce_get_' . $hala_wc_page . '_page_id',
		static function ( $id ) {
			if ( $id && function_exists( 'pll_get_post' ) ) {
				$tr = pll_get_post( (int) $id );
				return $tr ? $tr : $id;
			}
			return $id;
		}
	);
}

/** Native selects (styled by the theme) instead of Select2 on checkout. */
add_action( 'wp_enqueue_scripts', static function () {
	wp_dequeue_script( 'selectWoo' );
	wp_deregister_script( 'selectWoo' );
	wp_dequeue_style( 'select2' );
}, 100 );

add_filter( 'woocommerce_get_privacy_policy_text', static fn( $text, $type ) => 'checkout' === $type ? hala_s( 'Your personal data will be used to process your order and improve your experience on this site, as described in our [privacy_policy].' ) : $text, 10, 2 );
