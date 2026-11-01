<?php
/**
 * "Own your copy" call-to-action (glasses on books).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$hala_url = hala_opt( 'bc_url', '' );
?>
<section class="section section--tight cta-section" aria-labelledby="bc-title">
	<div class="container">
		<div class="cta-panel cta-panel--books">
			<div class="cta-panel__body">
				<span class="eyebrow"><?php echo esc_html( hala_opt( 'bc_eyebrow', hala_s( 'The library of Prof. Dr. Hala Mostafa Gomaa' ) ) ); ?></span>
				<h2 id="bc-title"><?php echo hala_hl( hala_opt( 'bc_title', hala_s( 'Own your copy of the latest medical and literary works' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p><?php echo esc_html( hala_opt( 'bc_text', hala_s( 'Discover a selection of the deepest scientific references in critical care and anaesthesia, alongside distinguished literary and historical works. Get your printed or digital copy easily and in top print quality.' ) ) ); ?></p>
				<?php echo hala_btn( hala_opt( 'bc_button', hala_s( "Browse the doctor's books" ) ), $hala_url ? $hala_url : hala_url( 'shop' ), array( 'variant' => 'light' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="cta-panel__art" aria-hidden="true"><?php echo hala_img( hala_opt( 'bc_art' ), 'large', 'glasses.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</div>
</section>
