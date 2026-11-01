<?php
/**
 * Carousel controls: prev / progress bar / next.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="carousel__controls">
	<button class="carousel__btn" type="button" data-carousel-prev aria-label="<?php echo esc_attr( hala_s( 'Previous' ) ); ?>"><?php echo hala_icon( 'arrow', 'icon--rev' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
	<div class="carousel__bar" aria-hidden="true"><span class="carousel__thumb"></span></div>
	<button class="carousel__btn" type="button" data-carousel-next aria-label="<?php echo esc_attr( hala_s( 'Next' ) ); ?>"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
</div>
