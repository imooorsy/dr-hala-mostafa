<?php
/**
 * Template Name: FAQ
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$pid   = get_the_ID();
$items = array();
foreach ( (array) hala_f( 'items', $pid, array() ) as $row ) {
	$items[] = array( 'q' => $row['q'], 'a' => $row['a'] );
}

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'class' => 'page-hero--faq',
		'title' => hala_f( 'hero_title', $pid, hala_s( 'Frequently asked questions' ) ),
		'text'  => hala_f( 'hero_text', $pid, hala_s( 'We have gathered comprehensive answers to the most common enquiries about the scientific and literary content, the books of Prof. Dr. Hala Mostafa Gomaa, how to get in touch and how to buy the publications.' ) ),
		'art'   => hala_f( 'hero_art', $pid ) ? wp_get_attachment_image_url( hala_f( 'hero_art', $pid )['ID'], 'large' ) : '',
	)
);
?>
<section class="section faq-section" aria-labelledby="faq-title">
	<div class="container container--narrow">
		<div class="faq-search">
			<label class="screen-reader-text" for="faq-filter"><?php hala_e( 'Search' ); ?></label>
			<div class="search-bar search-bar--light"><input id="faq-filter" type="search" data-faq-filter placeholder="<?php echo esc_attr( hala_s( 'Search' ) ); ?>" autocomplete="off"><span class="faq-search__icon"><?php echo hala_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></div>
		</div>
		<h2 id="faq-title" class="faq-title"><?php echo esc_html( hala_f( 'heading', $pid, hala_s( 'Frequently asked questions:' ) ) ); ?></h2>
		<?php get_template_part( 'template-parts/accordion', null, array( 'items' => $items, 'id' => 'faq' ) ); ?>
		<p class="empty-note" data-faq-empty hidden><?php hala_e( 'No matching questions.' ); ?></p>
	</div>
</section>
<?php
get_template_part( 'template-parts/newsletter-cta' );
get_footer();
