<?php
/**
 * Baseline SEO head — a real meta description + Open Graph/Twitter on every page,
 * derived from content. Closes the "document has no meta description" finding.
 *
 * A dedicated SEO plugin (Rank Math / Yoast) is still the production choice; when one
 * is active this bows out so it doesn't double up.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Best available description for the current view, trimmed to ~30 words.
 */
function sdp_meta_description_text() {
	if ( is_front_page() ) {
		$d = sdp_setting( 'intro', get_bloginfo( 'description' ) );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		$d    = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( $post->post_content ?? '' );
	} elseif ( is_archive() ) {
		$d = wp_strip_all_tags( get_the_archive_description() );
	} else {
		$d = get_bloginfo( 'description' );
	}
	$d = trim( preg_replace( '/\s+/', ' ', (string) $d ) );
	if ( '' === $d ) {
		$d = get_bloginfo( 'description' );
	}
	return wp_trim_words( $d, 30, '…' );
}

/**
 * Exact keyword-plan titles per page (2026-07-07 keyword plan). A configured
 * SEO plugin takes over in production; this keeps the demo's titles precise.
 */
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return $title;
	}
	if ( is_front_page() ) {
		return 'Insulation Contractor in Marianna, FL | A Plus Insulation';
	}
	if ( is_page() ) {
		$map = array(
			'services'     => 'Insulation Services in Marianna, FL | Spray Foam & More',
			'about'        => 'About A Plus Insulation | Marianna, FL Insulation Pros',
			'service-area' => 'Service Area | Insulation in Jackson County & NW Florida',
			'contact'      => 'Free Insulation Estimate | A Plus Insulation Marianna FL',
		);
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( isset( $map[ $slug ] ) ) {
			return $map[ $slug ];
		}
	}
	return $title;
} );

add_action( 'wp_head', function () {
	// Defer to a real SEO plugin if present.
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return;
	}

	$desc  = sdp_meta_description_text();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( '/' );

	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:type\" content=\"%s\">\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
	printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	if ( is_singular() && has_post_thumbnail() ) {
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( get_the_post_thumbnail_url( null, 'large' ) ) );
	}
	echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
}, 1 );
