<?php
/**
 * Empty cart.
 *
 * @package hala
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();
?>
<div class="cart-empty-state woocommerce-info-free">
	<div class="cart-empty-state__art" aria-hidden="true"><?php echo hala_img( '', 'large', 'cart.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	<h2><?php hala_e( 'You have not added any books' ); ?></h2>
	<p><?php hala_e( 'Add books to your cart to enjoy the knowledge of Dr. Hala Mostafa' ); ?></p>
	<?php echo hala_btn( hala_s( 'Browse the doctor\'s books' ), hala_url( 'shop' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
</div>
