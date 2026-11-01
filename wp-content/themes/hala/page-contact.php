<?php
/**
 * Template Name: Contact
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;
get_header();

$pid       = get_the_ID();
$email     = hala_opt( 'contact_email', 'contact@dr-halamostafa.com' );
$wa_digits = preg_replace( '/\D/', '', (string) hala_opt( 'whatsapp', '201115858 83253' ) );
$wa_label  = '+' . $wa_digits;
list( $notice_cls, $notice_msg ) = hala_form_notice( 'contact' );
?>

<section class="section contact-section" aria-labelledby="contact-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php hala_e( 'Contact' ); ?></span>
			<h1 id="contact-title" class="section-title"><?php echo hala_hl( hala_f( 'title', $pid, hala_s( 'We welcome *hearing* from you' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
			<p class="section-lead"><?php echo esc_html( hala_f( 'text', $pid, hala_s( 'Write to us with your enquiry, a question about the books, or a suggestion, and we will reply as soon as possible.' ) ) ); ?></p>
		</div>

		<div class="contact-grid">
			<aside class="contact-side">
				<h2 class="contact-side__title"><?php echo esc_html( hala_f( 'side_title', $pid, hala_s( 'Or reach us via WhatsApp or email' ) ) ); ?></h2>
				<a class="contact-card" href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
					<span class="contact-card__icon"><?php echo hala_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<span class="contact-card__text"><strong><?php hala_e( 'Email' ); ?></strong><span dir="ltr"><?php echo esc_html( antispambot( $email ) ); ?></span></span>
					<span class="circle-btn" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>
				<a class="contact-card" href="https://wa.me/<?php echo esc_attr( $wa_digits ); ?>" target="_blank" rel="noopener noreferrer">
					<span class="contact-card__icon"><?php echo hala_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<span class="contact-card__text"><strong><?php hala_e( 'WhatsApp' ); ?></strong><span dir="ltr"><?php echo esc_html( $wa_label ); ?></span></span>
					<span class="circle-btn" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>
			</aside>

			<div class="contact-form-panel">
				<form id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-hala-form="hala_contact" novalidate>
					<input type="hidden" name="action" value="hala_contact">
					<?php hala_form_guard( 'hala_contact' ); ?>
					<div class="form-row">
						<div class="field"><label for="c-first"><?php hala_e( 'First name' ); ?></label><input class="input" id="c-first" name="first_name" type="text" autocomplete="given-name" required placeholder="<?php echo esc_attr( hala_s( 'Type your first name here' ) ); ?>"></div>
						<div class="field"><label for="c-last"><?php hala_e( 'Last name' ); ?></label><input class="input" id="c-last" name="last_name" type="text" autocomplete="family-name" required placeholder="<?php echo esc_attr( hala_s( 'Type your last name here' ) ); ?>"></div>
					</div>
					<div class="form-row">
						<div class="field"><label for="c-email"><?php hala_e( 'Email' ); ?></label><input class="input" id="c-email" name="email" type="email" autocomplete="email" required placeholder="<?php echo esc_attr( hala_s( 'Type your email here' ) ); ?>"></div>
						<div class="field">
							<label for="c-phone"><?php hala_e( 'Phone number' ); ?></label>
							<div class="phone-field" dir="ltr">
								<select name="phone_cc" aria-label="<?php echo esc_attr( hala_s( 'Country code' ) ); ?>">
									<option value="+20">🇪🇬 +20</option><option value="+966">🇸🇦 +966</option><option value="+971">🇦🇪 +971</option><option value="+965">🇰🇼 +965</option><option value="+974">🇶🇦 +974</option><option value="+44">🇬🇧 +44</option><option value="+1">🇺🇸 +1</option>
								</select>
								<input class="input" id="c-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="<?php echo esc_attr( hala_s( 'Type your phone number here' ) ); ?>">
							</div>
						</div>
					</div>
					<div class="field"><label for="c-msg"><?php hala_e( 'Your message' ); ?></label><textarea class="textarea" id="c-msg" name="message" required minlength="5" placeholder="<?php echo esc_attr( hala_s( 'Type your enquiry here' ) ); ?>"></textarea></div>
					<div class="form-actions">
						<button class="btn btn--pinkchip" type="submit"><span class="btn__label"><?php hala_e( 'Send message' ); ?></span><span class="btn__icon" aria-hidden="true"><?php echo hala_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
					</div>
					<p class="form-note <?php echo esc_attr( $notice_cls ); ?>" role="status" aria-live="polite"><?php echo esc_html( $notice_msg ); ?></p>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="section section--tight follow-section" aria-labelledby="follow-title">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow"><?php echo esc_html( hala_f( 'follow_eyebrow', $pid, hala_s( 'Stay connected' ) ) ); ?></span>
			<h2 id="follow-title" class="section-title"><?php echo hala_hl( hala_f( 'follow_title', $pid, hala_s( 'You can also *follow* us' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="section-lead"><?php echo esc_html( hala_f( 'follow_text', $pid, hala_s( 'I am glad to stay in constant touch, sharing my experiences, publications and latest intellectual and medical contributions across different platforms.' ) ) ); ?></p>
		</div>
		<?php get_template_part( 'template-parts/follow-cards', null, array( 'post_id' => $pid ) ); ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/book-cta' );
get_template_part( 'template-parts/newsletter-cta' );
get_footer();
