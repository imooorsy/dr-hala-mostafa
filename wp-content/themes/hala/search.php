<?php
/**
 * Search results (books / articles / research).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

// phpcs:ignore WordPress.Security.NonceVerification
$hala_pt = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : '';
$hala_scope = array( 'post' => array( 'post-tile', 3 ), 'hala_research' => array( 'research', 2 ), 'product' => array( 'book', 4 ) );
$hala_tpl   = $hala_scope[ $hala_pt ] ?? null;

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'class'  => 'page-hero--search',
		'title'  => hala_s( 'Search results' ),
		'text'   => sprintf( hala_s( 'Results for “%s”' ), get_search_query() ),
		'search' => array( 'post_type' => $hala_pt ),
	)
);
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid--<?php echo esc_attr( $hala_tpl ? $hala_tpl[1] : 3 ); ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					$hala_card = $hala_tpl ? $hala_tpl[0] : ( 'hala_research' === get_post_type() ? 'research' : ( 'product' === get_post_type() ? 'book' : 'post-tile' ) );
					?>
					<div class="grid-item"><?php get_template_part( 'template-parts/card', $hala_card ); ?></div>
				<?php endwhile; ?>
			</div>
			<?php hala_pagination(); ?>
		<?php else : ?>
			<p class="empty-note"><?php hala_e( 'No results found. Try different words.' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
