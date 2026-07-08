<?php
/**
 * LocalBusiness (InsulationContractor) JSON-LD, built from Site Settings.
 * Emitted on the front page so the demo has real, valid local schema even
 * before Rank Math's Local SEO is configured.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', function () {
	if ( ! is_front_page() ) { return; }

	$hours = array();
	foreach ( sdp_hours() as $row ) {
		if ( $row['closed'] ) { continue; }
		if ( preg_match( '/(\d{1,2}:\d{2}\s*[AP]M).*?(\d{1,2}:\d{2}\s*[AP]M)/i', $row['time'], $m ) ) {
			$hours[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => $row['day'],
				'opens'     => date( 'H:i', strtotime( $m[1] ) ),
				'closes'    => date( 'H:i', strtotime( $m[2] ) ),
			);
		}
	}

	$data = array(
		'@context'     => 'https://schema.org',
		'@type'        => array( 'LocalBusiness', 'HomeAndConstructionBusiness' ),
		'name'         => get_bloginfo( 'name' ),
		'description'  => sdp_setting( 'intro', get_bloginfo( 'description' ) ),
		'url'          => home_url( '/' ),
		'telephone'    => sdp_setting( 'phone' ),
		'foundingDate' => '2006',
		'address'      => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '5319 Hwy 90',
			'addressLocality' => 'Marianna',
			'addressRegion'   => 'FL',
			'postalCode'      => '32446',
			'addressCountry'  => 'US',
		),
		'areaServed'   => array( 'Marianna FL', 'Jackson County FL', 'Sneads FL', 'Graceville FL', 'Chipley FL', 'Alford FL', 'Bonifay FL' ),
		'knowsAbout'   => array( 'Spray foam insulation', 'Blown-in insulation', 'Batt and roll insulation', 'Radiant barrier', 'Insulation removal', 'Insulation replacement' ),
	);
	if ( $hours ) { $data['openingHoursSpecification'] = $hours; }
	if ( $fb = sdp_setting( 'facebook' ) ) { $data['sameAs'] = array( $fb ); }

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 20 );

/**
 * FAQPage JSON-LD — mirrors the FAQ accordion rendered on the front page.
 * Same data source (sdp_home_faqs) so markup and schema can never drift.
 */
add_action( 'wp_head', function () {
	if ( ! is_front_page() || ! function_exists( 'sdp_home_faqs' ) ) { return; }

	$entities = array();
	foreach ( sdp_home_faqs() as $faq ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['a'] ),
		);
	}

	$data = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 21 );
