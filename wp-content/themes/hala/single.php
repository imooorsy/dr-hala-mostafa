<?php
/**
 * Single article.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$hala_kind = hala_post_kind( get_the_ID() );
	?>
<article <?php post_class( 'single-post' ); ?>>
	<header class="post-hero container">
		<div class="post-hero__media">
			<?php echo hala_post_image( get_the_ID(), 'hala-wide' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<div class="post-hero__overlay">
				<div class="post-hero__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( hala_post_date() ); ?></time>
					<?php if ( $hala_kind['name'] ) : ?><span class="badge<?php echo 'lit' === $hala_kind['kind'] ? ' badge--lit' : ''; ?>"><?php echo esc_html( $hala_kind['name'] ); ?></span><?php endif; ?>
				</div>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			</div>
		</div>
	</header>

	<div class="container container--narrow prose post-content">
		<?php the_content(); ?>
	</div>
</article>

	<?php
	get_template_part( 'template-parts/book-cta' );

	$hala_related = new WP_Query(
		array(
			'lang' => hala_lang(), 'post_type'           => 'post',
			'posts_per_page'      => 6,
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'category__in'        => wp_get_post_categories( get_the_ID() ),
		)
	);
	if ( ! $hala_related->have_posts() ) {
		$hala_related = new WP_Query( array( 'lang' => hala_lang(), 'post_type' => 'post', 'posts_per_page' => 6, 'post__not_in' => array( get_the_ID() ), 'no_found_rows' => true ) );
	}
	if ( $hala_related->have_posts() ) :
		?>
<section class="section related-posts" aria-labelledby="rel-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'Related articles' ); ?></span>
			<h2 id="rel-title" class="section-title"><?php echo hala_hl( hala_s( 'Insights between the realm of medicine and the depth of *history*' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php hala_e( 'An intellectual space where medical precision, advances in care and the charm of historical tales meet.' ); ?></p>
			<?php echo hala_btn( hala_s( 'View more' ), hala_url( 'blog' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
		<div class="carousel" data-carousel>
			<div class="carousel__track" tabindex="0" aria-label="<?php echo esc_attr( hala_s( 'Related articles' ) ); ?>">
				<?php
				while ( $hala_related->have_posts() ) :
					$hala_related->the_post();
					?>
					<div class="carousel__item"><?php get_template_part( 'template-parts/card', 'post-tile' ); ?></div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php get_template_part( 'template-parts/carousel-controls' ); ?>
		</div>
	</div>
</section>
	<?php endif; ?>
	<?php
	get_template_part( 'template-parts/newsletter-cta' );
endwhile;

get_footer();
