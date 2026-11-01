<?php
/**
 * Article card: image, date + category chip, title, excerpt, circle arrow.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$hala_kind = hala_post_kind( get_the_ID() );
?>
<article class="post-card">
	<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php echo hala_post_image( get_the_ID(), 'hala-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</a>
	<div class="post-card__body">
		<div class="post-card__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( hala_post_date() ); ?></time>
			<?php if ( $hala_kind['name'] ) : ?>
				<span class="badge<?php echo 'lit' === $hala_kind['kind'] ? ' badge--lit' : ''; ?>"><?php echo esc_html( $hala_kind['name'] ); ?></span>
			<?php endif; ?>
		</div>
		<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<a class="circle-btn" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( hala_s( 'Read: %s' ), get_the_title() ) ); ?>"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
	</div>
</article>
