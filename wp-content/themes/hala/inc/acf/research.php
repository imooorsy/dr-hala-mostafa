<?php
/**
 * Field group: research paper details.
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
		$g = 'res';
		acf_add_local_field_group(
			array(
				'key'        => 'group_hala_research',
				'title'      => 'Research details',
				'menu_order' => 0,
				'fields'     => array(
					hala_fld( $g, 'text', 'journal', 'Journal', array( 'placeholder' => 'Egyptian Journal of Anaesthesia' ) ),
					hala_fld( $g, 'text', 'issue', 'Volume / issue', array( 'placeholder' => 'Vol. 39, No. 1' ) ),
					hala_fld( $g, 'number', 'year', 'Year', array( 'min' => 1980, 'max' => 2100, 'step' => 1 ) ),
					hala_fld( $g, 'text', 'authors', 'Authors' ),
					hala_fld( $g, 'url', 'link', 'Paper link / DOI URL' ),
				),
				'location'   => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'hala_research' ) ) ),
				'position'   => 'side',
			)
		);
	}
);
