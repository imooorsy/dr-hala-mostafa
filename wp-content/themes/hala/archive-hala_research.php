<?php
/**
 * Research archive.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'class'  => 'page-hero--research',
		'title'  => hala_s( 'Scientific studies and research' ),
		'text'   => hala_s( 'A selection of the refereed research of Prof. Dr. Hala Mostafa Gomaa in anaesthesia and critical care.' ),
		'search' => array( 'post_type' => 'hala_research' ),
		'art'    => hala_ph( 'tv.png' ),
	)
);
?>
<section class="section research-section" aria-labelledby="research-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'Refereed scientific output' ); ?></span>
			<h2 id="research-title" class="section-title"><?php echo hala_hl( hala_s( '*Research* and scientific publishing' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php hala_e( 'Advanced academic documentation and studies in anaesthesia and critical care, contributing to the medical library and to the development of healthcare protocols.' ); ?></p>
		</div>
		<div class="grid grid--2">
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="grid-item"><?php get_template_part( 'template-parts/card', 'research' ); ?></div>
				<?php endwhile; ?>
			<?php else : ?>
				<p class="empty-note"><?php hala_e( 'Nothing found here yet.' ); ?></p>
			<?php endif; ?>
		</div>
		<?php hala_pagination(); ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/newsletter-cta' );
get_footer();
