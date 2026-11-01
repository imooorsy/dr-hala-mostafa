<?php
/**
 * Newsletter call-to-action (subscribers saved to hala_subscriber).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
list( $hala_cls, $hala_msg ) = hala_form_notice( 'subscribe' );
?>
<section class="section section--tight cta-section" aria-labelledby="nl-title">
	<div class="container">
		<div class="cta-panel cta-panel--newsletter">
			<div class="cta-panel__body">
				<span class="eyebrow"><?php echo esc_html( hala_opt( 'nl_eyebrow', hala_s( 'Exclusively for you' ) ) ); ?></span>
				<h2 id="nl-title"><?php echo hala_hl( hala_opt( 'nl_title', hala_s( 'Be the first to know about the latest releases and articles' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p><?php echo esc_html( hala_opt( 'nl_text', hala_s( 'Stay close to the latest clinical research, advanced medical works and new literary novels: subscribe and receive every new idea and insight from Dr. Hala Mostafa Gomaa as soon as it is out.' ) ) ); ?></p>
				<form class="newsletter-form" id="subscribe-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-hala-form="hala_subscribe" novalidate>
					<input type="hidden" name="action" value="hala_subscribe">
					<input type="hidden" name="source" value="<?php echo esc_attr( is_front_page() ? 'home' : 'page' ); ?>">
					<?php hala_form_guard( 'hala_subscribe' ); ?>
					<label class="screen-reader-text" for="nl-email"><?php hala_e( 'Email address' ); ?></label>
					<input id="nl-email" type="email" name="email" required autocomplete="email" placeholder="<?php echo esc_attr( hala_opt( 'nl_placeholder', hala_s( 'Type your email here' ) ) ); ?>">
					<button class="btn" type="submit"><span class="btn__label"><?php echo esc_html( hala_opt( 'nl_button', hala_s( 'Subscribe for every update' ) ) ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
				</form>
				<p class="form-note <?php echo esc_attr( $hala_cls ); ?>" role="status" aria-live="polite"><?php echo esc_html( $hala_msg ); ?></p>
			</div>
			<div class="cta-panel__art" aria-hidden="true"><?php echo hala_img( hala_opt( 'nl_art' ), 'large', 'bell.png', array( 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</div>
</section>
