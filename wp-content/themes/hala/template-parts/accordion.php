<?php
/**
 * Accessible accordion. Args: items => [ [q, a(html)] ], id.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$hala_items = $args['items'] ?? array();
$hala_id    = $args['id'] ?? 'acc';
if ( ! $hala_items ) {
	return;
}
?>
<div class="accordion" data-accordion>
	<?php foreach ( $hala_items as $i => $item ) : ?>
		<div class="accordion__item<?php echo 0 === $i ? ' is-open' : ''; ?>" data-faq-item>
			<h3 class="accordion__h">
				<button class="accordion__q" type="button" id="<?php echo esc_attr( "{$hala_id}-q{$i}" ); ?>" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( "{$hala_id}-a{$i}" ); ?>">
					<span><?php echo esc_html( $item['q'] ); ?></span>
					<span class="acc-icon" aria-hidden="true"></span>
				</button>
			</h3>
			<div class="accordion__panel" id="<?php echo esc_attr( "{$hala_id}-a{$i}" ); ?>" role="region" aria-labelledby="<?php echo esc_attr( "{$hala_id}-q{$i}" ); ?>">
				<div><div class="accordion__a"><?php echo wp_kses_post( wpautop( $item['a'] ) ); ?></div></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
