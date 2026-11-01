<?php
// Local-dev helper: make WordPress HTTP calls trust bin/cacert.pem (needed behind SSL-scanning antivirus).
WP_CLI::add_hook( 'after_wp_load', function () {
	add_filter( 'http_request_args', function ( $args ) { $args['sslcertificates'] = __DIR__ . '/cacert.pem'; return $args; }, 99 );
} );
