<?php
/**
 * Template Name: About
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$pid      = get_the_ID();
$timeline = hala_f( 'timeline', $pid, array() );
$specs    = hala_f( 'specialties', $pid, array() );
?>

<section class="home-hero about-hero" aria-labelledby="about-title">
	<div class="container home-hero__grid">
		<div class="home-hero__text">
			<span class="eyebrow"><?php echo esc_html( hala_f( 'eyebrow', $pid, hala_s( 'About the doctor' ) ) ); ?></span>
			<h1 id="about-title"><?php echo hala_hl( hala_f( 'title', $pid, get_the_title() ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
			<p class="home-hero__lead"><?php echo esc_html( hala_f( 'intro', $pid, '' ) ); ?></p>
			<div class="btn-row">
				<?php echo hala_btn( hala_s( 'Scientific & literary books' ), hala_url( 'shop' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php echo hala_link_arrow( hala_s( 'Scientific research' ), hala_url( 'research' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
		<figure class="home-hero__portrait">
			<?php echo hala_img( hala_f( 'image', $pid ), 'hala-portrait', 'portrait.jpg', array( 'alt' => '', 'loading' => 'eager' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<figcaption><span class="dot" aria-hidden="true"></span><?php echo esc_html( hala_s( 'Dr. Hala Mostafa Gomaa' ) ); ?></figcaption>
		</figure>
	</div>
</section>

<?php if ( trim( get_the_content() ) ) : ?>
<section class="section section--tight">
	<div class="container container--narrow prose"><?php the_content(); ?></div>
</section>
<?php endif; ?>

<?php if ( $timeline ) : ?>
<section class="section" aria-labelledby="tl-title">
	<div class="container">
		<div class="section-head"><h2 id="tl-title" class="section-title"><?php echo hala_hl( hala_f( 'timeline_heading', $pid, hala_s( 'Career *timeline*' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2></div>
		<ol class="timeline">
			<?php foreach ( $timeline as $t ) : ?>
				<li class="timeline__item">
					<span class="timeline__year"><?php echo esc_html( $t['year'] ); ?></span>
					<div class="timeline__body"><h3><?php echo esc_html( $t['title'] ); ?></h3><p><?php echo esc_html( $t['text'] ); ?></p></div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<?php if ( $specs ) : ?>
<section class="section section--tight" aria-labelledby="sp-title">
	<div class="container">
		<div class="section-head"><h2 id="sp-title" class="section-title"><?php echo hala_hl( hala_f( 'spec_heading', $pid, hala_s( 'Fields of *specialty*' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2></div>
		<div class="grid grid--3">
			<?php foreach ( $specs as $s ) : ?>
				<article class="exp-card exp-card--burgundy"><h3><?php echo esc_html( $s['title'] ); ?></h3><p><?php echo esc_html( $s['text'] ); ?></p></article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section section--tight follow-section" aria-labelledby="ac-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'Academic profiles' ); ?></span>
			<h2 id="ac-title" class="section-title"><?php echo hala_hl( hala_s( 'Where to *find* my work' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>
		<?php get_template_part( 'template-parts/follow-cards' ); ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/book-cta' );
get_template_part( 'template-parts/newsletter-cta' );
get_footer();
