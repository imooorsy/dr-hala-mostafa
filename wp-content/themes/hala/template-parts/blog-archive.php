<?php
/**
 * Blog listing (posts page + category archives): hero, tabs, grid, pagination, newsletter.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

$hala_cats    = get_categories( array( 'hide_empty' => true ) );
$hala_current = is_category() ? get_queried_object_id() : 0;
$hala_blog    = hala_url( 'blog' );

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'class'  => 'page-hero--blog',
		'title'  => hala_s( 'Articles and reflections in the realm of medicine, thought and history' ),
		'search' => array( 'post_type' => 'post' ),
		'art'    => hala_ph( 'tv.png' ),
	)
);
?>
<section class="section blog-section" aria-labelledby="blog-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'The blog' ); ?></span>
			<h2 id="blog-title" class="section-title"><?php echo hala_hl( hala_s( 'Literary and medical *articles*' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php hala_e( 'A window onto the latest developments in critical care, and a voyage through literary and historical narrative: to offer humane content that inspires minds and touches hearts.' ); ?></p>
		</div>

		<?php if ( $hala_cats ) : ?>
		<div class="tabs" role="tablist" aria-label="<?php echo esc_attr( hala_s( 'Filter articles' ) ); ?>" data-filter-tabs data-filter-type="post">
			<a class="tabs__item<?php echo ! $hala_current ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo ! $hala_current ? 'true' : 'false'; ?>" href="<?php echo esc_url( $hala_blog ); ?>" data-term=""><?php hala_e( 'All' ); ?></a>
			<?php foreach ( $hala_cats as $hala_c ) : ?>
				<a class="tabs__item<?php echo $hala_current === $hala_c->term_id ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $hala_current === $hala_c->term_id ? 'true' : 'false'; ?>" href="<?php echo esc_url( get_category_link( $hala_c ) ); ?>" data-term="<?php echo esc_attr( $hala_c->slug ); ?>"><?php echo esc_html( $hala_c->name ); ?></a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<div class="grid grid--3" data-filter-grid>
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="grid-item"><?php get_template_part( 'template-parts/card', 'post-tile' ); ?></div>
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
