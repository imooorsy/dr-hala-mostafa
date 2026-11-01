<?php
/**
 * Field group: extra book (WooCommerce product) content.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}
		$g = 'book';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_book',
				'title'    => 'Book details',
				'fields'   => array(
					hala_fld( $g, 'text', 'eyebrow', 'Eyebrow line above the title', array( 'instructions' => 'Short line shown above the book title (optional).' ) ),
					hala_fld( $g, 'text', 'includes_title', 'Contents heading', array( 'instructions' => 'e.g. "What you will find inside".' ) ),
					hala_fld( $g, 'wysiwyg', 'includes', 'Contents list', array( 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'instructions' => 'Use a bulleted list.' ) ),
					hala_fld( $g, 'text', 'why_title', 'Highlight panel title (optional)' ),
					hala_fld( $g, 'textarea', 'why_items', 'Highlight panel bullet points (one per line)', array( 'rows' => 4 ) ),
					hala_img_fld( $g, 'why_art', 'Highlight panel illustration' ),
					hala_rep(
						$g,
						'faqs',
						'Frequently asked questions',
						array(
							hala_sub( 'text', 'q', 'Question' ),
							hala_sub( 'textarea', 'a', 'Answer', array( 'rows' => 3 ) ),
						),
						array( 'layout' => 'row' )
					),
				),
				'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'product' ) ) ),
			)
		);
	}
);

/** Category kind: medical (burgundy) or literary (gold) — drives badge + cover colour. */
add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_term_kind',
				'title'    => 'Colour',
				'fields'   => array(
					hala_fld( 'term', 'text', 'hala_badge', 'Short badge text', array( 'instructions' => 'Shown on cards (e.g. Medical). Leave empty to use the category name.' ) ),
					hala_fld( 'term', 'select', 'hala_kind', 'Kind', array( 'choices' => array( 'med' => 'Medical (burgundy)', 'lit' => 'Literary (gold)' ), 'default_value' => 'med' ) ),
				),
				'location' => array(
					array( array( 'param' => 'taxonomy', 'operator' => '==', 'value' => 'product_cat' ) ),
					array( array( 'param' => 'taxonomy', 'operator' => '==', 'value' => 'category' ) ),
				),
			)
		);
	}
);
