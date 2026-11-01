<?php
/**
 * 404.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="section not-found">
	<div class="container container--narrow center-text">
		<span class="eyebrow">404</span>
		<h1><?php echo hala_hl( hala_s( 'This page could not be *found*' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
		<p><?php hala_e( 'The link may be broken or the page may have moved. Try the main pages below.' ); ?></p>
		<div class="btn-row btn-row--center">
			<?php echo hala_btn( hala_s( 'Back to home' ), home_url( '/' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo hala_link_arrow( hala_s( 'Browse the doctor\'s books' ), hala_url( 'shop' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>
<?php
get_footer();
