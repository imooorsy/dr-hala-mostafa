<?php
/**
 * Sanitise a raw `wp db export` dump: replace the admin user row (e-mail + password hash)
 * and any personal e-mail. Usage: php bin/sanitize-sql.php database/dr_hala.raw.sql database/dr_hala.sql
 */
$in  = $argv[1] ?? 'database/dr_hala.raw.sql';
$out = $argv[2] ?? 'database/dr_hala.sql';
$s   = file_get_contents( $in );

$s = preg_replace_callback(
	'/INSERT INTO `wp_users` VALUES \(.*?\);/s',
	static function () {
		return "INSERT INTO `wp_users` VALUES (1,'hala_admin','\$P\$B_SANITIZED_RESET_PASSWORD_AFTER_IMPORT','hala_admin','admin@example.com','','2026-01-01 00:00:00','',0,'hala_admin');";
	},
	$s
);
$s = str_replace( 'almaster.it@gmail.com', 'admin@example.com', $s );
file_put_contents( $out, $s );
unlink( $in );
echo "$out written (" . strlen( $s ) . " bytes)\n";
