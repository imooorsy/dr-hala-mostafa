<?php
/**
 * Template Name: Policy (privacy / terms / refund)
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$pid      = get_the_ID();
$sections = (array) hala_f( 'sections', $pid, array() );
$updated  = hala_f( 'updated', $pid, '' );
?>
<section class="policy-hero">
	<div class="container">
		<h1><?php echo esc_html( hala_f( 'hero_title', $pid, get_the_title() ) ); ?></h1>
		<?php if ( $updated ) : ?><p class="policy-hero__updated"><?php echo esc_html( sprintf( hala_s( 'Last updated: %s' ), $updated ) ); ?></p><?php endif; ?>
	</div>
</section>

<section class="section policy-section">
	<div class="container">
		<div class="policy-box">
			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="policy-row policy-row--intro"><div class="prose"><?php the_content(); ?></div></div>
			<?php endif; ?>
			<?php foreach ( $sections as $s ) : ?>
				<div class="policy-row">
					<h2 class="policy-row__title"><?php echo esc_html( $s['heading'] ); ?></h2>
					<div class="policy-row__body prose"><?php echo wp_kses_post( $s['body'] ); ?></div>
				</div>
			<?php endforeach; ?>
			<?php if ( hala_f( 'closing', $pid ) ) : ?>
				<div class="policy-row policy-row--closing"><p><?php echo esc_html( hala_f( 'closing', $pid ) ); ?></p></div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
get_footer();
