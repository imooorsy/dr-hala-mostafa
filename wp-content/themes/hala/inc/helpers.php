<?php
/**
 * Small helpers used across templates.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

/** Current language slug ('ar' | 'en'). */
function hala_lang(): string {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
		if ( $lang ) {
			return $lang;
		}
	}
	return 0 === strpos( determine_locale(), 'ar' ) ? 'ar' : 'en';
}

function hala_is_rtl(): bool {
	return is_rtl();
}

/** Inline SVG icons (stroke icons, currentColor). */
function hala_icon( string $name, string $class = '' ): string {
	static $paths = null;
	if ( null === $paths ) {
		$paths = array(
			'arrow'    => '<path d="M19 12H5"/><path d="m11 6-6 6 6 6"/>',
			'chevron'  => '<path d="m6 9 6 6 6-6"/>',
			'chev-l'   => '<path d="m15 6-6 6 6 6"/>',
			'chev-r'   => '<path d="m9 6 6 6-6 6"/>',
			'search'   => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
			'cart'     => '<path d="M3 4h2l2.4 11.2a1 1 0 0 0 1 .8h8.7a1 1 0 0 0 1-.8L20 8H6"/><circle cx="9.5" cy="20" r="1.3"/><circle cx="17" cy="20" r="1.3"/>',
			'mail'     => '<rect x="3" y="5" width="18" height="14" rx="3"/><path d="m4 7 8 6 8-6"/>',
			'whatsapp' => '<path d="M20 11.5a8 8 0 0 1-11.8 7L4 20l1.5-4.1A8 8 0 1 1 20 11.5Z"/><path d="M9 9.2c.3 2.4 2.4 4.5 5 5.3l1.2-1.4-1.9-.9-.8.6a4.5 4.5 0 0 1-1.9-1.9l.6-.8-.9-1.9Z"/>',
			'phone'    => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/>',
			'trash'    => '<path d="M4 7h16"/><path d="M10 11v6M14 11v6"/><path d="M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12"/><path d="M9 7V4h6v3"/>',
			'plus'     => '<path d="M12 5v14M5 12h14"/>',
			'minus'    => '<path d="M5 12h14"/>',
			'external' => '<path d="M14 4h6v6"/><path d="M20 4 10 14"/><path d="M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
			'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
			'check'    => '<path d="m5 12 5 5 9-10"/>',
			'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
		);
	}
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	$flip = in_array( $name, array( 'arrow', 'chev-l', 'chev-r' ), true ) ? ' icon--flip' : '';
	return '<svg class="icon icon-' . esc_attr( $name . $flip . ( $class ? ' ' . $class : '' ) ) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Pill button with the circular arrow chip.
 *
 * @param string $label Visible label (already translated).
 * @param string $url   Link.
 * @param array  $o     variant (light|chip|outline), size (sm), class, attrs (array).
 */
function hala_btn( string $label, string $url, array $o = array() ): string {
	$o       = $o + array( 'variant' => '', 'size' => '', 'class' => '', 'attrs' => array(), 'icon' => 'arrow' );
	$classes = trim( 'btn ' . ( $o['variant'] ? 'btn--' . $o['variant'] . ' ' : '' ) . ( $o['size'] ? 'btn--' . $o['size'] . ' ' : '' ) . $o['class'] );
	$attrs   = '';
	foreach ( (array) $o['attrs'] as $k => $v ) {
		$attrs .= ' ' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
	return '<a class="' . esc_attr( $classes ) . '" href="' . esc_url( $url ) . '"' . $attrs . '><span class="btn__label">' . esc_html( $label ) . '</span><span class="btn__icon" aria-hidden="true">' . hala_icon( $o['icon'] ) . '</span></a>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/** Plain text link with arrow. */
function hala_link_arrow( string $label, string $url, string $class = '' ): string {
	return '<a class="link-arrow ' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '"><span>' . esc_html( $label ) . '</span>' . hala_icon( 'arrow' ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Turn "text with *highlight*" into escaped HTML with a burgundy span, newlines to <br>.
 */
function hala_hl( string $text ): string {
	$text = esc_html( $text );
	$text = preg_replace( '/\*(.+?)\*/u', '<span class="hl">$1</span>', $text );
	return nl2br( $text );
}

/** ACF field from a post (safe when ACF is inactive). */
function hala_f( string $name, $post_id = null, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$v = get_field( $name, $post_id );
	return ( null === $v || '' === $v || false === $v ) ? $default : $v;
}

/** Option stored per language (see inc/acf/loader.php). */
function hala_opt( string $name, $default = '' ) {
	return hala_f( $name, 'options', $default );
}

/** Is a section toggle on? Defaults to on when the field has never been saved. */
function hala_on( string $name, $post_id = null ): bool {
	if ( ! function_exists( 'get_field' ) ) {
		return true;
	}
	$v = get_field( $name, $post_id );
	return null === $v ? true : (bool) $v;
}

/** URL of a bundled placeholder image. */
function hala_ph( string $file ): string {
	return HALA_URI . '/assets/images/placeholders/' . ltrim( $file, '/' );
}

/**
 * Render an image from an ACF image (array|ID|URL) or fall back to a placeholder file.
 */
function hala_img( $img, string $size = 'large', string $fallback = '', array $attr = array() ): string {
	$attr = $attr + array( 'loading' => 'lazy', 'decoding' => 'async' );
	if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
		$img = (int) $img['ID'];
	}
	if ( is_numeric( $img ) && (int) $img > 0 ) {
		return wp_get_attachment_image( (int) $img, $size, false, $attr );
	}
	$src = is_string( $img ) && $img ? $img : ( $fallback ? hala_ph( $fallback ) : '' );
	if ( ! $src ) {
		return '';
	}
	$out = '<img src="' . esc_url( $src ) . '"';
	$attr += array( 'alt' => '' );
	foreach ( $attr as $k => $v ) {
		$out .= ' ' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
	return $out . '>';
}

/** Permalink of a "role" page (shop, blog, contact, faq, privacy, terms, about) in the current language. */
function hala_url( string $role ): string {
	switch ( $role ) {
		case 'shop':
			$link = post_type_exists( 'product' ) ? get_post_type_archive_link( 'product' ) : '';
			return $link ? $link : home_url( '/' );
		case 'blog':
			$id = (int) get_option( 'page_for_posts' );
			break;
		case 'research':
			$link = get_post_type_archive_link( 'hala_research' );
			return $link ? $link : home_url( '/' );
		case 'cart':
			$id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'cart' ) : 0;
			break;
		default:
			$map = (array) get_option( 'hala_pages', array() );
			$id  = isset( $map[ $role ] ) ? (int) $map[ $role ] : 0;
	}
	if ( $id && function_exists( 'pll_get_post' ) ) {
		$tr = pll_get_post( $id );
		$id = $tr ? $tr : $id;
	}
	return $id ? get_permalink( $id ) : home_url( '/' );
}

/** Live cart count. */
function hala_cart_count(): int {
	return function_exists( 'WC' ) && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
}

/** Social / profile links from the per-language options page. */
function hala_social_links(): array {
	return array_filter(
		array(
			'linkedin'     => array( 'label' => hala_s( 'LinkedIn' ), 'url' => hala_opt( 'social_linkedin' ) ),
			'researchgate' => array( 'label' => hala_s( 'ResearchGate' ), 'url' => hala_opt( 'social_researchgate' ) ),
			'cairo'        => array( 'label' => hala_s( 'Cairo University' ), 'url' => hala_opt( 'social_cairo' ) ),
			'orcid'        => array( 'label' => hala_s( 'ORCID' ), 'url' => hala_opt( 'social_orcid' ) ),
		),
		static function ( $l ) {
			return ! empty( $l['url'] );
		}
	);
}

/** Category badge for a book (medical or literary) from product_cat. */
function hala_book_kind( int $post_id ): array {
	$terms = get_the_terms( $post_id, 'product_cat' );
	$name  = '';
	$kind  = 'med';
	if ( $terms && ! is_wp_error( $terms ) ) {
		$badge = (string) get_term_meta( $terms[0]->term_id, 'hala_badge', true );
		$name  = $badge ? $badge : $terms[0]->name;
		$kind  = (string) get_term_meta( $terms[0]->term_id, 'hala_kind', true );
		$kind = 'lit' === $kind ? 'lit' : 'med';
	}
	return array( 'name' => $name, 'kind' => $kind );
}

/** Styled pagination (array of links wrapped in <nav><ul>). */
function hala_pagination( ?WP_Query $query = null, array $args = array() ): void {
	global $wp_query;
	$q     = $query ? $query : $wp_query;
	$total = (int) $q->max_num_pages;
	if ( $total < 2 ) {
		return;
	}
	$links = paginate_links(
		$args + array(
			'total'     => $total,
			'current'   => max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) ),
			'type'      => 'array',
			'prev_text' => hala_icon( 'chev-l' ) . '<span class="screen-reader-text">' . esc_html( hala_s( 'Previous' ) ) . '</span>',
			'next_text' => hala_icon( 'chev-r' ) . '<span class="screen-reader-text">' . esc_html( hala_s( 'Next' ) ) . '</span>',
			'mid_size'  => 1,
		)
	);
	if ( ! $links ) {
		return;
	}
	echo '<nav class="pagination" aria-label="' . esc_attr( hala_s( 'Pagination' ) ) . '"><ul>';
	foreach ( $links as $l ) {
		echo '<li>' . $l . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- core-generated links.
	}
	echo '</ul></nav>';
}

/** Language switcher markup. $mode: 'dropdown' | 'toggle'. */
function hala_lang_switcher( string $mode = 'dropdown' ): void {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}
	$langs = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) );
	if ( ! $langs ) {
		return;
	}
	$current = null;
	$other   = null;
	foreach ( $langs as $l ) {
		if ( ! empty( $l['current_lang'] ) ) {
			$current = $l;
		} else {
			$other = $other ? $other : $l;
		}
	}
	if ( 'toggle' === $mode ) {
		if ( $other ) {
			printf(
				'<a class="header-lang" href="%1$s" hreflang="%2$s" lang="%2$s" aria-label="%3$s">%4$s</a>',
				esc_url( $other['url'] ),
				esc_attr( $other['slug'] ),
				esc_attr( $other['name'] ),
				esc_html( 'ar' === $other['slug'] ? 'عربي' : strtoupper( $other['slug'] ) )
			);
		}
		return;
	}
	echo '<details class="lang-switch"><summary aria-label="' . esc_attr( hala_s( 'Language' ) ) . '"><span>' . esc_html( $current ? $current['name'] : '' ) . '</span>' . hala_icon( 'chevron' ) . '</summary><ul>'; // phpcs:ignore WordPress.Security.EscapeOutput
	foreach ( $langs as $l ) {
		printf(
			'<li class="%1$s"><a href="%2$s" hreflang="%3$s" lang="%3$s">%4$s</a></li>',
			! empty( $l['current_lang'] ) ? 'is-current' : '',
			esc_url( $l['url'] ),
			esc_attr( $l['slug'] ),
			esc_html( $l['name'] )
		);
	}
	echo '</ul></details>';
}

/** Wrapper that prints the CSS book cover when a product/book has no image. */
function hala_cover( int $post_id, string $size = 'hala-cover', string $loading = 'lazy' ): string {
	$kind = hala_book_kind( $post_id )['kind'];
	$cls  = 'book-cover' . ( 'lit' === $kind ? ' book-cover--lit' : '' );
	if ( has_post_thumbnail( $post_id ) ) {
		return '<span class="' . esc_attr( $cls ) . '">' . get_the_post_thumbnail( $post_id, $size, array( 'loading' => $loading, 'alt' => esc_attr( get_the_title( $post_id ) ) ) ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	return '<span class="' . esc_attr( $cls ) . '"><img src="' . esc_url( hala_ph( 'lit' === $kind ? 'cover-gold.png' : 'cover-burgundy.png' ) ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '" loading="' . esc_attr( $loading ) . '"></span>';
}

/** Kind (med|lit) + name of an article's primary category. */
function hala_post_kind( int $post_id ): array {
	$terms = get_the_terms( $post_id, 'category' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return array( 'name' => '', 'kind' => 'med' );
	}
	$t     = $terms[0];
	$kind  = (string) get_term_meta( $t->term_id, 'hala_kind', true );
	$badge = (string) get_term_meta( $t->term_id, 'hala_badge', true );
	return array( 'name' => $badge ? $badge : $t->name, 'kind' => 'lit' === $kind ? 'lit' : 'med' );
}

/** Article image (thumbnail or a kind-based placeholder). */
function hala_post_image( int $post_id, string $size = 'hala-card' ): string {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail( $post_id, $size, array( 'loading' => 'lazy', 'alt' => '' ) );
	}
	$kind = hala_post_kind( $post_id )['kind'];
	return hala_img( '', $size, 'lit' === $kind ? 'post-lit.jpg' : 'post-med.jpg', array( 'alt' => '' ) );
}

/** "20 Sep . 2026" (Latin digits and month, like the reference design). */
function hala_post_date( int $post_id = 0 ): string {
	$ts = get_post_timestamp( $post_id ?: get_the_ID() );
	return ( new DateTime( '@' . $ts ) )->setTimezone( wp_timezone() )->format( 'd M . Y' );
}
