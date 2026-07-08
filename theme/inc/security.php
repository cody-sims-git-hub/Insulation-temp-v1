<?php
/**
 * Baseline security response headers.
 *
 * Sent from the theme so the protection travels with the site regardless of host
 * (Hostinger shared, VPS, etc.). This closes the common "missing hardening headers"
 * findings from securityheaders.com / Mozilla Observatory.
 *
 * Deliberately NOT set here:
 *  - **HSTS** (`Strict-Transport-Security`) belongs at the TLS-terminating layer
 *    (Caddy/host), where the certificate lives.
 *  - **CSP** (`Content-Security-Policy`) needs per-site tuning (a wrong CSP breaks the
 *    site). Add it per client at the proxy once the asset origins are known.
 * Set both at the server layer for defense in depth.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'send_headers', function () {
	if ( headers_sent() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: geolocation=(), camera=(), microphone=(), browsing-topics=()' );
} );

/**
 * Trim WordPress fingerprinting that aids automated attacks.
 */
remove_action( 'wp_head', 'wp_generator' );          // hide WP version
add_filter( 'the_generator', '__return_empty_string' );
