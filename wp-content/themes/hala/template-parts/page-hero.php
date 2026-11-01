<?php
/**
 * Burgundy hero band for listing pages.
 *
 * Args: eyebrow, title (supports *highlight*), text, search (['post_type'=>..]), art (url), class.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$a = wp_parse_args( $args ?? array(), array( 'eyebrow' => '', 'title' => '', 'text' => '', 'search' => null, 'art' => '', 'class' => '', 'h' => 'h1' ) );
?>
<section class="page-hero <?php echo esc_attr( $a['class'] ); ?>">
	<?php if ( $a['art'] ) : ?><div class="page-hero__art" aria-hidden="true"><img src="<?php echo esc_url( $a['art'] ); ?>" alt="" loading="lazy"></div><?php endif; ?>
	<div class="container">
		<?php if ( $a['eyebrow'] ) : ?><span class="eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></span><?php endif; ?>
		<<?php echo esc_attr( $a['h'] ); ?>><?php echo hala_hl( $a['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></<?php echo esc_attr( $a['h'] ); ?>>
		<?php if ( $a['text'] ) : ?><p><?php echo esc_html( $a['text'] ); ?></p><?php endif; ?>
		<?php if ( $a['search'] ) : ?>
			<form class="search-bar" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="hero-search"><?php hala_e( 'Search' ); ?></label>
				<input id="hero-search" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( hala_s( 'Search' ) ); ?>">
				<?php if ( ! empty( $a['search']['post_type'] ) ) : ?><input type="hidden" name="post_type" value="<?php echo esc_attr( $a['search']['post_type'] ); ?>"><?php endif; ?>
				<button type="submit" aria-label="<?php echo esc_attr( hala_s( 'Search' ) ); ?>"><?php echo hala_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
			</form>
		<?php endif; ?>
	</div>
</section>
