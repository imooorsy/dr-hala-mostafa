<?php
/**
 * Product quantity inputs — pill stepper (− 1 +).
 *
 * @package hala
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

/* translators: %s: Quantity. */
$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
	return;
}
?>
<div class="quantity qty-stepper">
	<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
	<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $label ); ?></label>
	<button type="button" class="qty-btn" data-qty-dir="1" aria-label="<?php echo esc_attr( hala_s( 'Increase quantity' ) ); ?>"><?php echo hala_icon( 'plus' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
	<input
		type="<?php echo esc_attr( $type ); ?>"
		<?php echo $readonly ? 'readonly="readonly"' : ''; ?>
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		<?php if ( 0 < $max_value ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?>
		<?php if ( ! $readonly ) : ?>
			step="<?php echo esc_attr( $step ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
			autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
		<?php endif; ?>
	/>
	<button type="button" class="qty-btn" data-qty-dir="-1" aria-label="<?php echo esc_attr( hala_s( 'Decrease quantity' ) ); ?>"><?php echo hala_icon( 'minus' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
	<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
</div>
