<?php
/**
 * Field group: Home page (template front-page.php). Every section can be switched on/off.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

/** Standard section-head fields with a prefix: eyebrow, title, text, btn label + url. */
function hala_head_fields( string $g, string $p, bool $btn = true ): array {
	$f = array(
		hala_fld( $g, 'text', "{$p}_eyebrow", 'Eyebrow' ),
		hala_fld( $g, 'textarea', "{$p}_title", 'Title', array( 'rows' => 2, 'instructions' => 'Wrap a word in *asterisks* to highlight it in burgundy.' ) ),
		hala_fld( $g, 'textarea', "{$p}_text", 'Text', array( 'rows' => 3 ) ),
	);
	if ( $btn ) {
		$f[] = hala_fld( $g, 'text', "{$p}_btn_label", 'Button label' );
		$f[] = hala_fld( $g, 'text', "{$p}_btn_url", 'Button link', array( 'instructions' => 'Leave empty to use the default page.' ) );
	}
	return $f;
}

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}
		$g = 'home';

		$fields = array_merge(
			array(
				hala_tab( $g, 'hero', 'Hero' ),
				hala_toggle( $g, 'hero_on', 'Show this section' ),
				hala_img_fld( $g, 'hero_image', 'Portrait' ),
				hala_fld( $g, 'text', 'hero_badge', 'Caption on portrait' ),
			),
			hala_head_fields( $g, 'hero' ),
			array(
				hala_fld( $g, 'text', 'hero_btn2_label', 'Second link label' ),
				hala_fld( $g, 'text', 'hero_btn2_url', 'Second link URL' ),

				hala_tab( $g, 'exp', 'Expertise' ),
				hala_toggle( $g, 'exp_on', 'Show this section' ),
			),
			hala_head_fields( $g, 'exp' ),
			array(
				hala_fld( $g, 'text', 'exp_btn2_label', 'Second link label' ),
				hala_fld( $g, 'text', 'exp_btn2_url', 'Second link URL' ),
				hala_rep(
					$g,
					'exp_cards',
					'Cards',
					array(
						hala_sub( 'text', 'title', 'Title' ),
						hala_sub( 'textarea', 'items', 'Bullet points (one per line)', array( 'rows' => 5 ) ),
						hala_sub( 'select', 'tone', 'Edge colour', array( 'choices' => array( 'burgundy' => 'Burgundy', 'gold' => 'Gold' ), 'default_value' => 'burgundy' ) ),
					)
				),

				hala_tab( $g, 'books', 'Books' ),
				hala_toggle( $g, 'books_on', 'Show this section' ),
			),
			hala_head_fields( $g, 'books' ),
			array(
				hala_fld( $g, 'number', 'books_count', 'How many latest books', array( 'default_value' => 8, 'min' => 2, 'max' => 16 ) ),
				hala_fld( $g, 'relationship', 'books_pick', 'Or pick books manually', array( 'post_type' => array( 'product' ), 'return_format' => 'id', 'filters' => array( 'search' ) ) ),

				hala_tab( $g, 'ann', 'Featured announcement' ),
				hala_toggle( $g, 'ann_on', 'Show this section' ),
				hala_img_fld( $g, 'ann_art', 'Illustration' ),
				hala_fld( $g, 'textarea', 'ann_text', 'Announcement text', array( 'rows' => 3 ) ),
				hala_fld( $g, 'text', 'ann_btn_label', 'Button label' ),
				hala_fld( $g, 'text', 'ann_btn_url', 'Button link' ),

				hala_tab( $g, 'res', 'Research' ),
				hala_toggle( $g, 'res_on', 'Show this section' ),
			),
			hala_head_fields( $g, 'res' ),
			array(
				hala_fld( $g, 'number', 'res_count', 'How many latest papers', array( 'default_value' => 4, 'min' => 2, 'max' => 8 ) ),
				hala_fld( $g, 'relationship', 'res_pick', 'Or pick papers manually', array( 'post_type' => array( 'hala_research' ), 'return_format' => 'id', 'filters' => array( 'search' ) ) ),

				hala_tab( $g, 'art', 'Articles' ),
				hala_toggle( $g, 'art_on', 'Show this section' ),
			),
			hala_head_fields( $g, 'art' ),
			array(
				hala_fld( $g, 'number', 'art_count', 'How many latest articles', array( 'default_value' => 6, 'min' => 3, 'max' => 12 ) ),

				hala_tab( $g, 'vis', 'Vision' ),
				hala_toggle( $g, 'vis_on', 'Show this section' ),
				hala_img_fld( $g, 'vis_image', 'Portrait' ),
				hala_img_fld( $g, 'vis_art', 'Background illustration (hieroglyph tablet)' ),
			),
			hala_head_fields( $g, 'vis' ),
			array(
				hala_tab( $g, 'ctas', 'Calls to action' ),
				hala_toggle( $g, 'bcta_on', 'Show the book call-to-action' ),
				hala_toggle( $g, 'nl_on', 'Show the newsletter call-to-action' ),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_home',
				'title'    => 'Home page sections',
				'fields'   => $fields,
				'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php' ) ) ),
			)
		);
	}
);
