<?php
/**
 * Books archive (shop + product_cat).
 *
 * @package hala
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

$hala_terms   = hala_shop_terms();
$hala_current = is_tax( 'product_cat' ) ? get_queried_object_id() : 0;
$hala_shop    = hala_url( 'shop' );

// Covers fanned in the hero.
$hala_fan = new WP_Query( array( 'lang' => hala_lang(), 'post_type' => 'product', 'posts_per_page' => 4, 'no_found_rows' => true, 'orderby' => 'date' ) );
?>
<section class="page-hero page-hero--books">
	<div class="container">
		<h1><?php echo hala_hl( hala_s( 'Literary and medical books' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
		<p><?php hala_e( 'A complete library of publications documenting a career of giving at Kasr Al Ainy, Cairo University. These works distil research and global references in anaesthesia and critical care, alongside literary and intellectual output that blends medical precision with depth of humanity.' ); ?></p>
		<form class="search-bar" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="hero-search"><?php hala_e( 'Search' ); ?></label>
			<input id="hero-search" type="search" name="s" placeholder="<?php echo esc_attr( hala_s( 'Search' ) ); ?>">
			<input type="hidden" name="post_type" value="product">
			<button type="submit" aria-label="<?php echo esc_attr( hala_s( 'Search' ) ); ?>"><?php echo hala_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		</form>
		<?php if ( $hala_fan->have_posts() ) : ?>
			<div class="cover-fan" aria-hidden="true">
				<?php
				while ( $hala_fan->have_posts() ) :
					$hala_fan->the_post();
					?>
					<?php echo hala_cover( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="section shop-section" aria-labelledby="shop-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'Books' ); ?></span>
			<h2 id="shop-title" class="section-title"><?php echo hala_hl( hala_s( 'Publications and *references*' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>

		<?php if ( $hala_terms ) : ?>
		<div class="tabs" role="tablist" aria-label="<?php echo esc_attr( hala_s( 'Filter books' ) ); ?>" data-filter-tabs data-filter-type="product">
			<a class="tabs__item<?php echo ! $hala_current ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo ! $hala_current ? 'true' : 'false'; ?>" href="<?php echo esc_url( $hala_shop ); ?>" data-term=""><?php hala_e( 'All' ); ?></a>
			<?php foreach ( $hala_terms as $hala_t ) : ?>
				<a class="tabs__item<?php echo $hala_current === $hala_t->term_id ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $hala_current === $hala_t->term_id ? 'true' : 'false'; ?>" href="<?php echo esc_url( get_term_link( $hala_t ) ); ?>" data-term="<?php echo esc_attr( $hala_t->slug ); ?>"><?php echo esc_html( $hala_t->name ); ?></a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<?php wc_print_notices(); ?>
		<div class="grid grid--4" data-filter-grid>
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="grid-item"><?php get_template_part( 'template-parts/card', 'book' ); ?></div>
				<?php endwhile; ?>
			<?php else : ?>
				<p class="empty-note"><?php hala_e( 'Nothing found here yet.' ); ?></p>
			<?php endif; ?>
		</div>
		<div data-filter-pagination><?php hala_pagination(); ?></div>
	</div>
</section>
<?php
get_template_part( 'template-parts/newsletter-cta' );
get_footer( 'shop' );
