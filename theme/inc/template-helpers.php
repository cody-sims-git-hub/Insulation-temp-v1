<?php
/**
 * Accessors so templates stay clean and never query the DB inline.
 *
 * These wrap get_field(); if you swap the fields layer (see inc/fields.php),
 * this is the other place that reads it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ID of the singleton Site Settings entry (most recent published).
 */
function sdp_settings_id() {
	static $id = null;
	if ( null !== $id ) {
		return $id;
	}
	$posts = get_posts( array(
		'post_type'      => 'sitesettings',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
	) );
	$id = $posts ? (int) $posts[0] : 0;
	return $id;
}

/**
 * Read a Site Settings field with an optional fallback.
 */
function sdp_setting( $field, $default = '' ) {
	$id = sdp_settings_id();
	if ( ! $id || ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$val = get_field( $field, $id );
	return ( null === $val || '' === $val ) ? $default : $val;
}

/**
 * Hours as an ordered list (Mon first).
 */
function sdp_hours() {
	$days = array(
		'mon' => 'Monday',
		'tue' => 'Tuesday',
		'wed' => 'Wednesday',
		'thu' => 'Thursday',
		'fri' => 'Friday',
		'sat' => 'Saturday',
		'sun' => 'Sunday',
	);
	$out = array();
	foreach ( $days as $key => $label ) {
		$time = sdp_setting( "hours_{$key}", '' );
		$out[] = array(
			'day'    => $label,
			'time'   => $time !== '' ? $time : 'Closed',
			'closed' => ( $time === '' || strtolower( trim( $time ) ) === 'closed' ),
		);
	}
	return $out;
}

/**
 * Whether any hours are configured (so the block can hide when empty).
 */
function sdp_has_hours() {
	foreach ( array( 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) as $d ) {
		if ( sdp_setting( "hours_{$d}", '' ) !== '' ) {
			return true;
		}
	}
	return false;
}

/**
 * Up to two initials from a name, for avatar fallbacks.
 */
function sdp_initials( $name ) {
	$parts = preg_split( '/\s+/', trim( $name ) );
	$first = isset( $parts[0][0] ) ? $parts[0][0] : '';
	$last  = ( count( $parts ) > 1 ) ? substr( end( $parts ), 0, 1 ) : '';
	return strtoupper( $first . $last );
}

/**
 * Social links present in settings, as [name => url].
 */
function sdp_socials() {
	$out = array();
	foreach ( array( 'instagram', 'facebook', 'linkedin' ) as $net ) {
		$url = sdp_setting( $net, '' );
		if ( $url ) {
			$out[ $net ] = $url;
		}
	}
	return $out;
}
