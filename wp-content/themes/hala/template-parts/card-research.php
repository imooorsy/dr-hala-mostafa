<?php
/**
 * Research card.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
$hala_journal = hala_f( 'journal', get_the_ID() );
$hala_issue   = hala_f( 'issue', get_the_ID() );
$hala_year    = hala_f( 'year', get_the_ID() );
?>
<article class="research-card">
	<h3 class="research-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="research-card__abstract"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
	<p class="research-card__meta">
		<?php if ( $hala_issue ) : ?><span><?php echo esc_html( $hala_issue ); ?></span><?php endif; ?>
		<?php if ( $hala_journal ) : ?><span class="research-card__journal"><?php echo esc_html( $hala_journal ); ?></span><?php endif; ?>
		<?php if ( $hala_year ) : ?><span class="research-card__year"><?php echo esc_html( $hala_year ); ?></span><?php endif; ?>
	</p>
	<?php echo hala_btn( hala_s( 'More details about the research' ), get_permalink(), array( 'variant' => 'chip' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
</article>
