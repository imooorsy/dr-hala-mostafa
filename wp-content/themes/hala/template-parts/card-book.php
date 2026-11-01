<?php
/**
 * Book card (WooCommerce product in a loop).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$hala_kind = hala_book_kind( get_the_ID() );
?>
<article class="book-card">
	<a class="book-card__cover" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo hala_cover( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
	<div class="book-card__body">
		<?php if ( $hala_kind['name'] ) : ?>
			<span class="badge<?php echo 'lit' === $hala_kind['kind'] ? ' badge--lit' : ''; ?>"><?php echo esc_html( $hala_kind['name'] ); ?></span>
		<?php endif; ?>
		<h3 class="book-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="book-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
		<div class="book-card__more"><?php echo hala_link_arrow( hala_s( 'More details' ), get_permalink() ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	</div>
</article>
