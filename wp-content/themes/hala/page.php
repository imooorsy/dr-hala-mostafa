<?php
/**
 * Default page (also used for WooCommerce cart, checkout and account shortcodes).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$hala_woo   = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
$hala_empty = function_exists( 'is_cart' ) && is_cart() && WC()->cart && WC()->cart->is_empty();

while ( have_posts() ) :
	the_post();
	if ( $hala_woo ) :
		?>
<section class="section shop-flow">
	<div class="container">
		<div class="gold-bar"><h1><?php the_title(); ?></h1></div>
		<div class="shop-card<?php echo $hala_empty ? ' shop-card--empty' : ''; ?>"><?php the_content(); ?></div>
	</div>
</section>
	<?php else : ?>
<section class="section">
	<div class="container container--narrow">
		<h1><?php the_title(); ?></h1>
		<div class="prose"><?php the_content(); ?></div>
	</div>
</section>
		<?php
	endif;
endwhile;

get_footer();
