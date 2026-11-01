<?php
/**
 * Fallback template.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="section">
	<div class="container container--narrow">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="prose"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
			<?php hala_pagination(); ?>
		<?php else : ?>
			<p class="empty-note"><?php hala_e( 'Nothing found here yet.' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
