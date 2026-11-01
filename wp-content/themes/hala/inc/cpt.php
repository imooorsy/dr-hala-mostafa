<?php
/**
 * Custom post types: research (public), messages and subscribers (admin only).
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		register_post_type(
			'hala_research',
			array(
				'labels'       => array(
					'name'          => 'Research',
					'singular_name' => 'Research paper',
					'add_new_item'  => 'Add research paper',
					'edit_item'     => 'Edit research paper',
					'all_items'     => 'All research',
					'menu_name'     => 'Research',
					'search_items'  => 'Search research',
				),
				'public'       => true,
				'has_archive'  => 'research',
				'rewrite'      => array( 'slug' => 'research', 'with_front' => false ),
				'menu_icon'    => 'dashicons-book-alt',
				'menu_position' => 21,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
				'show_in_rest' => false,
			)
		);

		$private = array(
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title', 'editor' ),
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
		);
		register_post_type(
			'hala_message',
			$private + array(
				'labels'        => array( 'name' => 'Messages', 'singular_name' => 'Message', 'menu_name' => 'Messages', 'all_items' => 'All messages' ),
				'menu_icon'     => 'dashicons-email-alt',
				'menu_position' => 25,
			)
		);
		register_post_type(
			'hala_subscriber',
			$private + array(
				'labels'        => array( 'name' => 'Subscribers', 'singular_name' => 'Subscriber', 'menu_name' => 'Subscribers', 'all_items' => 'All subscribers' ),
				'menu_icon'     => 'dashicons-groups',
				'menu_position' => 26,
				'supports'      => array( 'title' ),
			)
		);

		// Book kind (medical/literary) drives the badge + cover colour.
		register_term_meta(
			'',
			'hala_kind',
			array( 'type' => 'string', 'single' => true, 'show_in_rest' => false, 'sanitize_callback' => 'sanitize_key' )
		);
	}
);

/* Admin columns -------------------------------------------------------- */
add_filter(
	'manage_hala_message_posts_columns',
	static fn( $c ) => array( 'cb' => $c['cb'], 'title' => 'Name', 'hala_email' => 'Email', 'hala_phone' => 'Phone', 'hala_lang' => 'Lang', 'date' => 'Date' )
);
add_filter(
	'manage_hala_subscriber_posts_columns',
	static fn( $c ) => array( 'cb' => $c['cb'], 'title' => 'Email', 'hala_lang' => 'Lang', 'hala_source' => 'Source', 'date' => 'Date' )
);
add_action(
	'manage_posts_custom_column',
	static function ( $col, $id ) {
		$map = array( 'hala_email' => '_email', 'hala_phone' => '_phone', 'hala_lang' => '_lang', 'hala_source' => '_source' );
		if ( isset( $map[ $col ] ) ) {
			echo esc_html( (string) get_post_meta( $id, $map[ $col ], true ) );
		}
	},
	10,
	2
);

/** Research meta box fallback is provided by ACF (inc/acf/research.php). */
