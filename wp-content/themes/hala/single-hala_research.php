<?php
/**
 * Single research paper.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$pid     = get_the_ID();
	$journal = hala_f( 'journal', $pid );
	$issue   = hala_f( 'issue', $pid );
	$year    = hala_f( 'year', $pid );
	$authors = hala_f( 'authors', $pid );
	$link    = hala_f( 'link', $pid );
	?>
<article class="section single-research">
	<div class="container container--narrow">
		<a class="link-arrow back-link" href="<?php echo esc_url( hala_url( 'research' ) ); ?>"><?php echo hala_icon( 'arrow', 'icon--rev' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php hala_e( 'All research' ); ?></span></a>
		<h1><?php the_title(); ?></h1>
		<dl class="research-meta">
			<?php if ( $journal ) : ?><div><dt><?php hala_e( 'Journal' ); ?></dt><dd class="research-card__journal"><?php echo esc_html( $journal ); ?></dd></div><?php endif; ?>
			<?php if ( $issue ) : ?><div><dt><?php hala_e( 'Issue' ); ?></dt><dd><?php echo esc_html( $issue ); ?></dd></div><?php endif; ?>
			<?php if ( $year ) : ?><div><dt><?php hala_e( 'Year' ); ?></dt><dd><?php echo esc_html( $year ); ?></dd></div><?php endif; ?>
			<?php if ( $authors ) : ?><div><dt><?php hala_e( 'Authors' ); ?></dt><dd><?php echo esc_html( $authors ); ?></dd></div><?php endif; ?>
		</dl>
		<div class="prose">
			<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			<?php the_content(); ?>
		</div>
		<?php if ( $link ) : ?>
			<p><?php echo hala_btn( hala_s( 'Read the paper' ), $link, array( 'attrs' => array( 'target' => '_blank', 'rel' => 'noopener noreferrer' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
	</div>
</article>
	<?php
	get_template_part( 'template-parts/newsletter-cta' );
endwhile;

get_footer();
