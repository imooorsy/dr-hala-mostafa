<?php
/**
 * Field group: Site settings (stored per language).
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
		$g = 'opt';
		acf_add_local_field_group(
			array(
				'key'      => 'group_hala_options',
				'title'    => 'Site settings',
				'fields'   => array(
					hala_tab( $g, 'general', 'General' ),
					hala_fld( $g, 'message', 'note', 'Language', array( 'message' => 'These settings are stored separately for each language. Use the language switcher in the admin bar to edit the other language.', 'esc_html' => 0 ) ),
					hala_img_fld( $g, 'brand_avatar', 'Header avatar', 'Round portrait next to the logo text.' ),
					hala_fld( $g, 'text', 'brand_name', 'Brand name (top line)' ),
					hala_fld( $g, 'text', 'brand_name_en', 'Brand name (second line)' ),
					hala_fld( $g, 'text', 'contact_email', 'Contact email', array( 'instructions' => 'Receives contact-form messages and is shown on the contact page.' ) ),
					hala_fld( $g, 'text', 'whatsapp', 'WhatsApp number (international, digits only)', array( 'placeholder' => '201115858 83253' ) ),
					hala_fld( $g, 'text', 'phone', 'Phone (optional)' ),
					hala_fld( $g, 'text', 'footer_title', 'Footer title' ),
					hala_fld( $g, 'text', 'copyright', 'Copyright line' ),
					hala_tab( $g, 'social', 'Social & academic profiles' ),
					hala_fld( $g, 'url', 'social_linkedin', 'LinkedIn URL' ),
					hala_fld( $g, 'url', 'social_researchgate', 'ResearchGate URL' ),
					hala_fld( $g, 'url', 'social_cairo', 'Cairo University profile URL' ),
					hala_fld( $g, 'url', 'social_orcid', 'ORCID URL' ),
					hala_tab( $g, 'newsletter', 'Newsletter call-to-action' ),
					hala_fld( $g, 'text', 'nl_eyebrow', 'Eyebrow' ),
					hala_fld( $g, 'textarea', 'nl_title', 'Title', array( 'rows' => 2 ) ),
					hala_fld( $g, 'textarea', 'nl_text', 'Text', array( 'rows' => 3 ) ),
					hala_fld( $g, 'text', 'nl_placeholder', 'Email placeholder' ),
					hala_fld( $g, 'text', 'nl_button', 'Button label' ),
					hala_img_fld( $g, 'nl_art', 'Illustration (3D bell)' ),
					hala_tab( $g, 'bookcta', 'Book call-to-action' ),
					hala_fld( $g, 'text', 'bc_eyebrow', 'Eyebrow' ),
					hala_fld( $g, 'textarea', 'bc_title', 'Title', array( 'rows' => 2 ) ),
					hala_fld( $g, 'textarea', 'bc_text', 'Text', array( 'rows' => 3 ) ),
					hala_fld( $g, 'text', 'bc_button', 'Button label' ),
					hala_fld( $g, 'url', 'bc_url', 'Button link (blank = shop page)' ),
					hala_img_fld( $g, 'bc_art', 'Illustration (glasses on books)' ),
				),
				'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'hala-settings' ) ) ),
			)
		);
	}
);
