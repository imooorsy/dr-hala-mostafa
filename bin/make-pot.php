<?php
/**
 * Generate languages/hala.pot and languages/ar.po from inc/strings.php.
 * Run: php bin/make-pot.php
 */
$map = require dirname( __DIR__ ) . '/wp-content/themes/hala/inc/strings.php';
$dir = dirname( __DIR__ ) . '/wp-content/themes/hala/languages/';

function po_quote( string $s ): string {
	$s = str_replace( array( '\\', '"', "\n" ), array( '\\\\', '\\"', '\\n' ), $s );
	return '"' . $s . '"';
}
$head = "# Hala theme translations.\nmsgid \"\"\nmsgstr \"\"\n\"Project-Id-Version: Hala 1.0.0\\n\"\n\"MIME-Version: 1.0\\n\"\n\"Content-Type: text/plain; charset=UTF-8\\n\"\n\"Content-Transfer-Encoding: 8bit\\n\"\n";
$pot  = $head . "\"Language: \\n\"\n\"X-Domain: hala\\n\"\n\n";
$po   = $head . "\"Language: ar\\n\"\n\"Plural-Forms: nplurals=6; plural=(n==0 ? 0 : n==1 ? 1 : n==2 ? 2 : n%100>=3 && n%100<=10 ? 3 : n%100>=11 ? 4 : 5);\\n\"\n\"X-Domain: hala\\n\"\n\n";
foreach ( $map as $en => $ar ) {
	$pot .= 'msgid ' . po_quote( $en ) . "\nmsgstr \"\"\n\n";
	$po  .= 'msgid ' . po_quote( $en ) . "\nmsgstr " . po_quote( $ar ) . "\n\n";
}
file_put_contents( $dir . 'hala.pot', $pot );
file_put_contents( $dir . 'ar.po', $po );
echo count( $map ) . " strings written.\n";
