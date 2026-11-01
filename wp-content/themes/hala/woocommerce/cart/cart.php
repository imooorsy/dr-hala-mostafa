<?php
/**
 * Cart — items table + summary sidebar.
 *
 * @package hala
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form cart-layout" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="cart-items">
		<div class="cart-head" aria-hidden="true"><span><?php hala_e( 'Product' ); ?></span><span><?php hala_e( 'Total' ); ?></span></div>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				continue;
			}
			$permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			$name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			?>
			<div class="cart-row woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<div class="cart-row__product">
					<a class="cart-row__thumb" href="<?php echo esc_url( $permalink ? $permalink : '#' ); ?>"><?php echo hala_cover( $product_id, 'hala-thumb' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<div class="cart-row__title">
						<a href="<?php echo esc_url( $permalink ? $permalink : '#' ); ?>"><?php echo wp_kses_post( $name ); ?></a>
						<span class="cart-row__unit"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
				</div>
				<div class="cart-row__qty">
					<?php
					if ( $_product->is_sold_individually() ) {
						$min_quantity = 1;
						$max_quantity = 1;
					} else {
						$min_quantity = 0;
						$max_quantity = $_product->get_max_purchase_quantity();
					}
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput
						'woocommerce_cart_item_quantity',
						woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $_product->get_name(),
							),
							$_product,
							false
						),
						$cart_item_key,
						$cart_item
					);
					?>
				</div>
				<div class="cart-row__remove product-remove">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a role="button" href="%s" class="remove circle-icon" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							/* translators: %s is the product name */
							esc_attr( sprintf( hala_s( 'Remove %s from cart' ), wp_strip_all_tags( $_product->get_name() ) ) ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() ),
							hala_icon( 'trash' )
						),
						$cart_item_key
					);
					?>
				</div>
				<div class="cart-row__total"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			</div>
			<?php
		}
		?>
		<?php do_action( 'woocommerce_cart_contents' ); ?>
		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</div>

	<aside class="cart-summary">
		<h2 class="cart-summary__title"><?php hala_e( 'Cart total' ); ?></h2>

		<?php if ( wc_coupons_enabled() ) : ?>
			<div class="coupon-box" data-collapsible>
				<button type="button" class="coupon-box__toggle" aria-expanded="false" aria-controls="coupon-panel">
					<span><?php hala_e( 'Add a coupon' ); ?></span>
					<span class="circle-icon"><?php echo hala_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</button>
				<div class="coupon-box__panel" id="coupon-panel" hidden>
					<label class="screen-reader-text" for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
					<input type="text" name="coupon_code" class="input" id="coupon_code" value="" placeholder="<?php echo esc_attr( hala_s( 'Coupon code' ) ); ?>">
					<button type="submit" class="btn btn--sm" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><span class="btn__label"><?php hala_e( 'Apply' ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<dl class="totals">
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="totals__row totals__row--coupon"><dt><?php wc_cart_totals_coupon_label( $coupon ); ?></dt><dd><?php wc_cart_totals_coupon_html( $coupon ); ?></dd></div>
			<?php endforeach; ?>
			<div class="totals__row totals__row--total"><dt><?php hala_e( 'Estimated total' ); ?></dt><dd><?php wc_cart_totals_order_total_html(); ?></dd></div>
		</dl>

		<button type="submit" class="screen-reader-text" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

		<?php echo hala_btn( hala_s( 'Proceed to checkout' ), wc_get_checkout_url(), array( 'class' => 'btn--checkout' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php do_action( 'woocommerce_after_cart_totals' ); ?>
	</aside>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
