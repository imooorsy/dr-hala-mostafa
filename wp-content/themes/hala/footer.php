<?php
/**
 * Site footer.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

$social    = hala_social_links();
$copyright = hala_opt( 'copyright', sprintf( hala_s( 'All rights reserved to Dr. Hala Mostafa Gomaa © %s' ), wp_date( 'Y' ) ) );
?>
</main>

<footer class="site-footer">
	<div class="site-footer__panel">
		<h2 class="site-footer__title"><?php echo esc_html( hala_opt( 'footer_title', hala_s( 'Together for better care and deeper thought' ) ) ); ?></h2>

		<div class="footer-cols">
			<div class="footer-col">
				<h3><?php hala_e( 'Pages' ); ?></h3>
				<?php hala_menu( 'footer_pages' ); ?>
			</div>
			<div class="footer-col">
				<h3><?php hala_e( 'More' ); ?></h3>
				<?php hala_menu( 'footer_more' ); ?>
			</div>
			<div class="footer-col">
				<h3><?php hala_e( 'Follow' ); ?></h3>
				<ul>
					<?php foreach ( $social as $s ) : ?>
						<li><a href="<?php echo esc_url( $s['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="footer-bar">
			<span><?php echo esc_html( $copyright ); ?></span>
			<div class="footer-bar__links">
				<?php hala_menu( 'footer_legal', 'footer-legal' ); ?>
				<?php hala_lang_switcher(); ?>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
