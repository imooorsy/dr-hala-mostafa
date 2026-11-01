<?php
/**
 * Overlay article tile (blog grid).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
?>
<a class="post-tile" href="<?php the_permalink(); ?>">
	<span class="post-tile__bg"><?php echo hala_post_image( get_the_ID(), 'hala-card' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
	<span class="post-tile__date"><?php echo esc_html( hala_post_date() ); ?></span>
	<h3 class="post-tile__title"><?php the_title(); ?></h3>
	<p class="post-tile__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
</a>
