<?php
/**
 * "Follow us" cards: profiles from Site settings + newsletter + extra ACF cards.
 *
 * @package hala
 */

defined( 'ABSPATH' ) || exit;

$hala_cards = array();
$hala_defs  = array(
	'researchgate' => array( 'title' => hala_s( 'Scientific research portal' ), 'sub' => 'ResearchGate', 'text' => hala_s( 'Join our community to receive every new publication and notification of new works and research straight to your inbox.' ) ),
	'orcid'        => array( 'title' => hala_s( 'Academic identifier' ), 'sub' => 'ORCID', 'text' => hala_s( 'Find my internationally verified academic record covering all my scientific and literary work.' ) ),
	'linkedin'     => array( 'title' => hala_s( 'LinkedIn' ), 'sub' => 'LinkedIn', 'text' => hala_s( 'Glad to connect professionally and follow the latest academic and research stations through LinkedIn.' ) ),
	'cairo'        => array( 'title' => hala_s( 'Cairo University' ), 'sub' => 'Cairo University', 'text' => hala_s( 'Follow my academic and institutional journey at Kasr Al Ainy through the official faculty page.' ) ),
);
$hala_links = hala_social_links();
foreach ( array( 'researchgate', 'orcid', 'linkedin' ) as $k ) {
	if ( isset( $hala_links[ $k ] ) ) {
		$hala_cards[] = $hala_defs[ $k ] + array( 'url' => $hala_links[ $k ]['url'], 'button' => hala_s( 'Follow & browse my profile' ) );
	}
}
$hala_cards[] = array( 'title' => hala_s( 'Subscribe to the newsletter' ), 'sub' => '', 'text' => hala_s( 'Join our knowledge community to receive the latest medical and literary articles, and be notified of new books and releases directly in your inbox.' ), 'url' => '#subscribe-form', 'button' => hala_s( 'Subscribe' ) );
if ( isset( $hala_links['cairo'] ) ) {
	$hala_cards[] = $hala_defs['cairo'] + array( 'url' => $hala_links['cairo']['url'], 'button' => hala_s( 'Follow & browse my profile' ) );
}
$hala_extra = hala_f( 'follow_cards', $args['post_id'] ?? null, array() );
foreach ( (array) $hala_extra as $e ) {
	$hala_cards[] = array( 'title' => $e['title'], 'sub' => '', 'text' => $e['text'], 'url' => $e['url'], 'button' => $e['button'] ? $e['button'] : hala_s( 'Follow & browse my profile' ) );
}
?>
<div class="follow-grid">
	<?php foreach ( $hala_cards as $c ) : ?>
		<article class="follow-card">
			<h3><?php echo esc_html( $c['title'] ); ?><?php if ( $c['sub'] && $c['sub'] !== $c['title'] ) : ?><br><span class="follow-card__sub"><?php echo esc_html( $c['sub'] ); ?></span><?php endif; ?></h3>
			<p><?php echo esc_html( $c['text'] ); ?></p>
			<?php
			$hala_ext = 0 !== strpos( $c['url'], '#' );
			echo hala_btn( $c['button'], $c['url'], array( 'size' => 'sm', 'attrs' => $hala_ext ? array( 'target' => '_blank', 'rel' => 'noopener noreferrer' ) : array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput
			?>
		</article>
	<?php endforeach; ?>
</div>
