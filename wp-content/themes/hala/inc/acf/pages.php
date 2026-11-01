<?php
/**
 * Field groups: About, FAQ, Policy (privacy / terms / refund), Contact page templates.
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

		/* ---------- About ---------- */
		$g = 'about';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_about',
				'title'    => 'About page',
				'fields'   => array(
					hala_tab( $g, 'intro', 'Intro' ),
					hala_fld( $g, 'text', 'eyebrow', 'Eyebrow' ),
					hala_fld( $g, 'textarea', 'title', 'Title', array( 'rows' => 2, 'instructions' => 'Wrap a word in *asterisks* to highlight it.' ) ),
					hala_fld( $g, 'textarea', 'intro', 'Introduction', array( 'rows' => 4 ) ),
					hala_img_fld( $g, 'image', 'Portrait' ),
					hala_tab( $g, 'timeline', 'Career timeline' ),
					hala_fld( $g, 'text', 'timeline_heading', 'Section title' ),
					hala_rep(
						$g,
						'timeline',
						'Milestones',
						array(
							hala_sub( 'text', 'year', 'Year / period' ),
							hala_sub( 'text', 'title', 'Title' ),
							hala_sub( 'textarea', 'text', 'Text', array( 'rows' => 3 ) ),
						)
					),
					hala_tab( $g, 'spec', 'Specialties' ),
					hala_fld( $g, 'text', 'spec_heading', 'Section title' ),
					hala_rep(
						$g,
						'specialties',
						'Specialties',
						array(
							hala_sub( 'text', 'title', 'Title' ),
							hala_sub( 'textarea', 'text', 'Text', array( 'rows' => 3 ) ),
						)
					),
				),
				'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ) ) ),
			)
		);

		/* ---------- FAQ ---------- */
		$g = 'faq';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_faq',
				'title'    => 'FAQ page',
				'fields'   => array(
					hala_fld( $g, 'text', 'hero_title', 'Hero title' ),
					hala_fld( $g, 'textarea', 'hero_text', 'Hero text', array( 'rows' => 3 ) ),
					hala_img_fld( $g, 'hero_art', 'Hero illustration' ),
					hala_fld( $g, 'text', 'heading', 'List heading' ),
					hala_rep(
						$g,
						'items',
						'Questions',
						array(
							hala_sub( 'text', 'q', 'Question' ),
							hala_sub( 'wysiwyg', 'a', 'Answer', array( 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ) ),
						),
						array( 'layout' => 'row' )
					),
				),
				'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php' ) ) ),
			)
		);

		/* ---------- Policy ---------- */
		$g = 'policy';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_policy',
				'title'    => 'Policy page (privacy / terms / refund)',
				'fields'   => array(
					hala_fld( $g, 'text', 'hero_title', 'Page title (hero)' ),
					hala_fld( $g, 'text', 'updated', 'Last updated (free text)', array( 'instructions' => 'e.g. "26 October 2026".' ) ),
					hala_rep(
						$g,
						'sections',
						'Sections',
						array(
							hala_sub( 'text', 'heading', 'Heading (shown in the sticky side column)' ),
							hala_sub( 'wysiwyg', 'body', 'Content', array( 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ) ),
						),
						array( 'layout' => 'row' )
					),
					hala_fld( $g, 'textarea', 'closing', 'Closing statement', array( 'rows' => 2 ) ),
				),
				'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-policy.php' ) ) ),
			)
		);

		/* ---------- Contact ---------- */
		$g = 'contact';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_contact',
				'title'    => 'Contact page',
				'fields'   => array(
					hala_fld( $g, 'text', 'title', 'Title' ),
					hala_fld( $g, 'textarea', 'text', 'Intro text', array( 'rows' => 3 ) ),
					hala_fld( $g, 'text', 'side_title', 'Side column heading' ),
					hala_fld( $g, 'text', 'follow_eyebrow', 'Follow section — eyebrow' ),
					hala_fld( $g, 'text', 'follow_title', 'Follow section — title', array( 'instructions' => 'Wrap a word in *asterisks* to highlight it.' ) ),
					hala_fld( $g, 'textarea', 'follow_text', 'Follow section — text', array( 'rows' => 3 ) ),
					hala_rep(
						$g,
						'follow_cards',
						'Extra follow cards',
						array(
							hala_sub( 'text', 'title', 'Title' ),
							hala_sub( 'textarea', 'text', 'Text', array( 'rows' => 3 ) ),
							hala_sub( 'url', 'url', 'Link' ),
							hala_sub( 'text', 'button', 'Button label' ),
						),
						array( 'instructions' => 'LinkedIn / ORCID / ResearchGate / Cairo University cards come from Site settings. Add any extra cards here.' )
					),
				),
				'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ) ),
			)
		);
	}
);
