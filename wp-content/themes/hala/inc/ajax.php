<?php
/**
 * AJAX: category filter + pagination for books (product) and blog (post).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

function hala_ajax_filter(): void {
	check_ajax_referer( 'hala_ajax', 'nonce' );

	$type  = isset( $_POST['type'] ) && 'post' === $_POST['type'] ? 'post' : 'product';
	$term  = isset( $_POST['term'] ) ? sanitize_title( wp_unslash( $_POST['term'] ) ) : '';
	$paged = isset( $_POST['paged'] ) ? max( 1, (int) $_POST['paged'] ) : 1;
	$lang  = isset( $_POST['lang'] ) ? sanitize_key( wp_unslash( $_POST['lang'] ) ) : '';
	$s     = isset( $_POST['s'] ) ? sanitize_text_field( wp_unslash( $_POST['s'] ) ) : '';

	$args = array(
		'post_type'      => $type,
		'post_status'    => 'publish',
		'posts_per_page' => 'product' === $type ? 8 : 9,
		'paged'          => $paged,
	);
	if ( $lang && function_exists( 'pll_languages_list' ) && in_array( $lang, pll_languages_list(), true ) ) {
		$args['lang'] = $lang;
	}
	if ( $s ) {
		$args['s'] = $s;
	}
	if ( $term ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'product' === $type ? 'product_cat' : 'category', 'field' => 'slug', 'terms' => $term ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	}

	$q = new WP_Query( $args );
	ob_start();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			echo '<div class="grid-item">';
			get_template_part( 'template-parts/card', 'product' === $type ? 'book' : 'post-tile' );
			echo '</div>';
		}
	} else {
		echo '<p class="empty-note">' . esc_html( hala_s( 'Nothing found here yet.' ) ) . '</p>';
	}
	wp_reset_postdata();
	$html = ob_get_clean();

	ob_start();
	hala_pagination( $q, array( 'base' => '#page-%#%', 'format' => '' ) );
	$pagination = ob_get_clean();

	wp_send_json_success( array( 'html' => $html, 'pagination' => $pagination, 'found' => (int) $q->found_posts ) );
}
add_action( 'wp_ajax_hala_filter', 'hala_ajax_filter' );
add_action( 'wp_ajax_nopriv_hala_filter', 'hala_ajax_filter' );
