<?php
/**
 * Checkout: billing + payment in the main column, order summary beside it.
 *
 * @package hala
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>
<div class="checkout-layout">
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr( hala_s( 'Checkout' ) ); ?>">
		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<div class="checkout-fields" id="customer_details">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
		<h3 class="checkout-pay-title" id="order_review_heading"><?php hala_e( 'Payment options' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		<?php woocommerce_checkout_payment(); ?>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</form>

	<aside class="checkout-summary">
		<h2 class="cart-summary__title"><?php hala_e( 'Order summary' ); ?></h2>
		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php woocommerce_order_review(); ?>
		</div>
		<?php if ( wc_coupons_enabled() ) : ?>
			<div class="coupon-box" data-collapsible>
				<button type="button" class="coupon-box__toggle" aria-expanded="false" aria-controls="coupon-panel">
					<span><?php hala_e( 'Add a coupon' ); ?></span>
					<span class="circle-icon"><?php echo hala_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</button>
				<form class="checkout_coupon woocommerce-form-coupon coupon-box__panel" id="coupon-panel" method="post" hidden>
					<label class="screen-reader-text" for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
					<input type="text" name="coupon_code" class="input" id="coupon_code" value="" placeholder="<?php echo esc_attr( hala_s( 'Coupon code' ) ); ?>">
					<button type="submit" class="btn btn--sm" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><span class="btn__label"><?php hala_e( 'Apply' ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
				</form>
			</div>
		<?php endif; ?>
	</aside>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
