<?php
/**
 * Order summary (items with thumbnails + totals). Replaced by AJAX on checkout updates.
 *
 * @package hala
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-checkout-review-order-table summary-list">
	<?php
	do_action( 'woocommerce_review_order_before_cart_contents' );
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
			<div class="summary-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<span class="summary-item__thumb"><?php echo hala_cover( (int) $cart_item['product_id'], 'hala-thumb' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<span class="summary-item__text">
					<span class="summary-item__name"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
						<strong class="product-quantity">&times;&nbsp;<?php echo esc_html( $cart_item['quantity'] ); ?></strong></span>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					<span class="summary-item__price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</span>
			</div>
			<?php
		}
	}
	do_action( 'woocommerce_review_order_after_cart_contents' );
	?>
	<dl class="totals">
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="totals__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>"><dt><?php wc_cart_totals_coupon_label( $coupon ); ?></dt><dd><?php wc_cart_totals_coupon_html( $coupon ); ?></dd></div>
		<?php endforeach; ?>
		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
		<div class="totals__row totals__row--total order-total"><dt><?php hala_e( 'Total' ); ?></dt><dd><?php wc_cart_totals_order_total_html(); ?></dd></div>
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</dl>
</div>
