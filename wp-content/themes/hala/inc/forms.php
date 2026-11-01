<?php
/**
 * Contact form + newsletter. Nonce, honeypot, time trap, rate limit. Works with and without JS.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

/** Simple per-IP rate limit (returns true if the call is allowed). */
function hala_rate_ok( string $bucket, int $max = 5, int $window = HOUR_IN_SECONDS ): bool {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x';
	$key = 'hala_rl_' . $bucket . '_' . md5( $ip );
	$n   = (int) get_transient( $key );
	if ( $n >= $max ) {
		return false;
	}
	set_transient( $key, $n + 1, $window );
	return true;
}

/** Shared anti-spam checks. Returns WP_Error on failure. */
function hala_spam_check( string $nonce_action ) {
	$nonce = isset( $_POST['_hala_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_hala_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, $nonce_action ) ) {
		return new WP_Error( 'nonce', hala_s( 'Your session expired. Please reload the page and try again.' ) );
	}
	if ( ! empty( $_POST['hala_website'] ) ) { // Honeypot.
		return new WP_Error( 'spam', hala_s( 'Thank you!' ) );
	}
	$ts = isset( $_POST['_hala_ts'] ) ? (int) $_POST['_hala_ts'] : 0;
	if ( $ts && ( time() - $ts ) < 2 ) { // Submitted impossibly fast.
		return new WP_Error( 'spam', hala_s( 'Thank you!' ) );
	}
	return true;
}

/** Hidden fields printed inside each form. */
function hala_form_guard( string $nonce_action ): void {
	wp_nonce_field( $nonce_action, '_hala_nonce', false );
	echo '<input type="hidden" name="_hala_ts" value="' . esc_attr( (string) time() ) . '">';
	echo '<div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="hala_website" tabindex="-1" autocomplete="off"></label></div>';
}

/* ---------------- Contact ---------------- */
function hala_process_contact(): array {
	$check = hala_spam_check( 'hala_contact' );
	if ( is_wp_error( $check ) ) {
		return array( 'ok' => 'spam' === $check->get_error_code(), 'message' => $check->get_error_message() );
	}
	if ( ! hala_rate_ok( 'contact', 5 ) ) {
		return array( 'ok' => false, 'message' => hala_s( 'Too many messages. Please try again later.' ) );
	}
	$first = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$cc    = isset( $_POST['phone_cc'] ) ? preg_replace( '/[^0-9+]/', '', sanitize_text_field( wp_unslash( $_POST['phone_cc'] ) ) ) : '+20';
	$phone = isset( $_POST['phone'] ) ? preg_replace( '/[^0-9]/', '', sanitize_text_field( wp_unslash( $_POST['phone'] ) ) ) : '';
	$msg   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $first || '' === $last || ! is_email( $email ) || strlen( $msg ) < 5 ) {
		return array( 'ok' => false, 'message' => hala_s( 'Please check the highlighted fields.' ) );
	}
	$full  = trim( $first . ' ' . $last );
	$phone = $phone ? $cc . ltrim( $phone, '0' ) : '';

	$id = wp_insert_post(
		array(
			'post_type'    => 'hala_message',
			'post_status'  => 'publish',
			'post_title'   => $full,
			'post_content' => $msg,
			'meta_input'   => array( '_email' => $email, '_phone' => $phone, '_lang' => hala_lang() ),
		)
	);

	$to      = hala_opt( 'contact_email', get_option( 'admin_email' ) );
	$subject = sprintf( '[%s] %s', wp_specialchars_decode( get_bloginfo( 'name' ) ), $full );
	$body    = "Name: {$full}\nEmail: {$email}\nPhone: {$phone}\nLanguage: " . hala_lang() . "\n\n{$msg}";
	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $full . ' <' . $email . '>' ) );

	return array( 'ok' => (bool) $id, 'message' => hala_s( 'Thank you! Your message has been sent. We will get back to you soon.' ) );
}

/* ---------------- Newsletter ---------------- */
function hala_process_subscribe(): array {
	$check = hala_spam_check( 'hala_subscribe' );
	if ( is_wp_error( $check ) ) {
		return array( 'ok' => 'spam' === $check->get_error_code(), 'message' => $check->get_error_message() );
	}
	if ( ! hala_rate_ok( 'subscribe', 8 ) ) {
		return array( 'ok' => false, 'message' => hala_s( 'Too many attempts. Please try again later.' ) );
	}
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		return array( 'ok' => false, 'message' => hala_s( 'Please enter a valid email address.' ) );
	}
	$exists = get_posts(
		array( 'post_type' => 'hala_subscriber', 'post_status' => 'any', 'title' => $email, 'numberposts' => 1, 'fields' => 'ids', 'suppress_filters' => true )
	);
	if ( ! $exists ) {
		wp_insert_post(
			array(
				'post_type'   => 'hala_subscriber',
				'post_status' => 'publish',
				'post_title'  => $email,
				'meta_input'  => array( '_lang' => hala_lang(), '_source' => isset( $_POST['source'] ) ? sanitize_key( wp_unslash( $_POST['source'] ) ) : 'site' ),
			)
		);
	}
	return array( 'ok' => true, 'message' => hala_s( 'You are subscribed. Thank you!' ) );
}

/* ---------------- Routing (AJAX + no-JS fallback) ---------------- */
foreach ( array( 'contact', 'subscribe' ) as $hala_form ) {
	$hala_cb = static function () use ( $hala_form ) {
		$res = 'contact' === $hala_form ? hala_process_contact() : hala_process_subscribe();
		if ( wp_doing_ajax() ) {
			wp_send_json( $res, $res['ok'] ? 200 : 422 );
		}
		$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
		$back = add_query_arg( array( 'hala_' . $hala_form => $res['ok'] ? 'ok' : 'error', 'hala_msg' => rawurlencode( $res['message'] ) ), remove_query_arg( array( 'hala_contact', 'hala_subscribe', 'hala_msg' ), $back ) );
		wp_safe_redirect( $back . '#' . $hala_form . '-form' );
		exit;
	};
	add_action( 'wp_ajax_nopriv_hala_' . $hala_form, $hala_cb );
	add_action( 'wp_ajax_hala_' . $hala_form, $hala_cb );
	add_action( 'admin_post_nopriv_hala_' . $hala_form, $hala_cb );
	add_action( 'admin_post_hala_' . $hala_form, $hala_cb );
}

/** Notice text for no-JS fallback (read-only query vars, escaped on output). */
function hala_form_notice( string $form ): array {
	// phpcs:ignore WordPress.Security.NonceVerification
	$state = isset( $_GET[ 'hala_' . $form ] ) ? sanitize_key( wp_unslash( $_GET[ 'hala_' . $form ] ) ) : '';
	if ( ! $state ) {
		return array( '', '' );
	}
	// phpcs:ignore WordPress.Security.NonceVerification
	$msg = isset( $_GET['hala_msg'] ) ? sanitize_text_field( rawurldecode( wp_unslash( $_GET['hala_msg'] ) ) ) : '';
	return array( 'ok' === $state ? 'is-ok' : 'is-error', $msg );
}
