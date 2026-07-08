<?php
/**
 * SDP Starter theme bootstrap.
 *
 * Design lives in the theme (code); content structure (CPTs + fields) is also
 * defined in code so every client site is reproducible and version-controlled.
 * Feature modules live in /inc.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SDP_VERSION', '1.0.0' );
define( 'SDP_DIR', get_stylesheet_directory() );
define( 'SDP_URI', get_stylesheet_directory_uri() );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	register_nav_menus( array( 'primary' => __( 'Primary', 'sdp-starter' ) ) );
} );

/**
 * Front-end assets. Built by the theme's build step into /dist; enqueued only
 * when present so a broken build never ships an unstyled page silently.
 */
add_action( 'wp_enqueue_scripts', function () {
	// Swap this for self-hosted fonts in production; kept as a CDN link for the
	// starter so there's zero build config for type. Font family is a token.
	wp_enqueue_style(
		'sdp-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	$css = SDP_DIR . '/dist/app.css';
	if ( file_exists( $css ) ) {
		wp_enqueue_style( 'sdp-starter', SDP_URI . '/dist/app.css', array(), filemtime( $css ) );
	}

	$js = SDP_DIR . '/dist/app.js';
	if ( file_exists( $js ) ) {
		wp_enqueue_script( 'sdp-starter', SDP_URI . '/dist/app.js', array(), filemtime( $js ), true );
	}
} );

/**
 * Preconnect to the font host so webfont swap is fast — reduces layout shift (CLS).
 */
add_filter( 'wp_resource_hints', function ( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = 'https://fonts.googleapis.com';
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}, 10, 2 );

foreach ( array( 'icons', 'post-types', 'fields', 'template-helpers', 'security', 'seo' ) as $module ) {
	$path = SDP_DIR . "/inc/{$module}.php";
	if ( file_exists( $path ) ) {
		require $path;
	}
}
