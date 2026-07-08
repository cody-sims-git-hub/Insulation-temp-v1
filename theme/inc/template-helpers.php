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

/**
 * Home-page FAQ — single source of truth for the rendered accordion AND the
 * FAQPage JSON-LD in inc/schema.php. Questions are real search queries
 * (2026-07-07 keyword plan); answers follow the content-quality claim rules.
 */
function sdp_home_faqs() {
	return array(
		array(
			'q' => 'Why is my electric bill so high?',
			'a' => 'In the Panhandle, the number-one culprit is attic heat. An under-insulated attic can top 130°F on a summer afternoon, and your AC fights it all day long. Air leaks and thin insulation let that heat pour into the house. A free assessment tells you in about twenty minutes whether your attic is the problem.',
		),
		array(
			'q' => 'How much does attic insulation cost?',
			'a' => 'Typical installed ranges in our area: blown-in runs about $1.00–$2.50 per square foot and spray foam about $3.00–$7.00. A typical Jackson County attic lands roughly $1,500–$3,500 with blown-in. Every home is different — your written estimate is free and itemized.',
		),
		array(
			'q' => 'Is spray foam insulation worth it?',
			'a' => 'For attics and new construction, usually yes: it air-seals and insulates in one step, and the comfort difference is immediate. It costs more up front. We\'ll tell you honestly when blown-in gets you most of the benefit for less.',
		),
		array(
			'q' => 'Is spray foam insulation good in Florida?',
			'a' => 'Yes — humidity is the reason. Foam is an air barrier, so it keeps muggy outdoor air out of your attic and off your ductwork. Installed right, with venting and inspection access handled, it\'s one of the best upgrades a Panhandle home can get.',
		),
		array(
			'q' => 'What R-value is required in Florida?',
			'a' => 'Florida code calls for R-30 to R-38 in attics, and R-38 is the sweet spot for most homes in our climate zone. Many older Jackson County homes measure R-11 or less — that gap is where the savings are.',
		),
		array(
			'q' => 'Does attic insulation help in summer?',
			'a' => 'Summer is when it works hardest. Insulation slows the heat radiating down from a hot roof into your living space, so the AC cycles less and rooms stay evener. Air sealing plus insulation can save around 15% on heating and cooling costs, per ENERGY STAR.',
		),
		array(
			'q' => 'How often should insulation be replaced?',
			'a' => 'Good insulation can last decades — but not if it\'s been wet, compressed, or visited by pests. If your home is 20+ years old and the bills keep climbing, it\'s worth having the attic measured. We check depth and condition for free.',
		),
		array(
			'q' => 'Is blown-in insulation better than batts?',
			'a' => 'In attics, usually — loose fill flows around joists, wires, and odd framing, so there are no gaps. Batts shine in open walls during construction or a remodel. We\'ll recommend whichever fits your house, not whichever we feel like selling.',
		),
	);
}
