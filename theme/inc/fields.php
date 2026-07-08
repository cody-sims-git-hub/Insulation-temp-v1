<?php
/**
 * ACF field definitions, registered in code (ACF free / SCF supports local
 * field groups). Defining fields here — not by clicking in the admin — is what
 * makes every client site reproducible and version-controlled.
 *
 * FIELDS-LAYER SEAM: this is the ONLY file that knows about ACF. To switch the
 * baseline to Carbon Fields, ACF Pro, or native meta boxes, replace this file
 * and the get_field() reads in inc/template-helpers.php + templates. Nothing
 * else depends on the fields plugin.
 *
 * Uses only free field types (no repeater/gallery/options page). Hours are seven
 * fixed day fields. Upgrade to ACF Pro (or Carbon Fields) for repeaters/galleries.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* ------------------------------------------------------------------- Team */
	acf_add_local_field_group( array(
		'key'      => 'group_team',
		'title'    => 'Team member details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'team' ) ) ),
		'fields'   => array(
			array( 'key' => 'field_team_role', 'label' => 'Role / title', 'name' => 'role', 'type' => 'text', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_team_link', 'label' => 'Profile / booking link', 'name' => 'link', 'type' => 'url', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_team_bio', 'label' => 'Short bio', 'name' => 'bio', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
		),
	) );

	/* --------------------------------------------------------------- Services */
	acf_add_local_field_group( array(
		'key'      => 'group_service',
		'title'    => 'Service details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ) ),
		'fields'   => array(
			array( 'key' => 'field_service_summary', 'label' => 'Summary', 'name' => 'summary', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_service_price', 'label' => 'Price / from', 'name' => 'price', 'type' => 'text', 'instructions' => 'Optional, e.g. "From $30".', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_service_featured', 'label' => 'Highlight?', 'name' => 'featured', 'type' => 'true_false', 'ui' => 1, 'wrapper' => array( 'width' => 50 ) ),
		),
	) );

	/* ----------------------------------------------------------- Testimonials */
	acf_add_local_field_group( array(
		'key'      => 'group_testimonial',
		'title'    => 'Testimonial details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ) ) ),
		'fields'   => array(
			array( 'key' => 'field_t_author', 'label' => 'Author name', 'name' => 'author_name', 'type' => 'text', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_t_role', 'label' => 'Author role / company', 'name' => 'author_role', 'type' => 'text', 'wrapper' => array( 'width' => 30 ) ),
			array( 'key' => 'field_t_rating', 'label' => 'Rating (1-5)', 'name' => 'rating', 'type' => 'number', 'default_value' => 5, 'min' => 1, 'max' => 5, 'wrapper' => array( 'width' => 20 ) ),
			array( 'key' => 'field_t_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
		),
	) );

	/* --------------------------------------------------------- Site Settings */
	$day = function ( $key, $label ) {
		return array( 'key' => "field_ss_{$key}", 'label' => $label, 'name' => "hours_{$key}", 'type' => 'text', 'placeholder' => '9:00 AM – 5:00 PM  (or "Closed")', 'wrapper' => array( 'width' => 50 ) );
	};

	acf_add_local_field_group( array(
		'key'      => 'group_sitesettings',
		'title'    => 'Site settings',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'sitesettings' ) ) ),
		'fields'   => array(
			array( 'key' => 'field_ss_tab_brand', 'label' => 'Brand', 'type' => 'tab' ),
			array( 'key' => 'field_ss_tagline', 'label' => 'Tagline', 'name' => 'tagline', 'type' => 'text', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_cta_url', 'label' => 'Primary CTA link', 'name' => 'cta_url', 'type' => 'url', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_cta_label', 'label' => 'Primary CTA label', 'name' => 'cta_label', 'type' => 'text', 'placeholder' => 'Get in touch', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_intro', 'label' => 'Intro / hero paragraph', 'name' => 'intro', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),

			array( 'key' => 'field_ss_tab_contact', 'label' => 'Contact', 'type' => 'tab' ),
			array( 'key' => 'field_ss_phone', 'label' => 'Phone (display)', 'name' => 'phone', 'type' => 'text', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_phone_href', 'label' => 'Phone (dial)', 'name' => 'phone_href', 'type' => 'text', 'placeholder' => '+15551234567', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_email', 'label' => 'Email', 'name' => 'email', 'type' => 'email', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_maps_url', 'label' => 'Google Maps link', 'name' => 'maps_url', 'type' => 'url', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_ss_address', 'label' => 'Address', 'name' => 'address', 'type' => 'textarea', 'rows' => 2, 'new_lines' => 'br' ),
			array( 'key' => 'field_ss_instagram', 'label' => 'Instagram URL', 'name' => 'instagram', 'type' => 'url', 'wrapper' => array( 'width' => 33 ) ),
			array( 'key' => 'field_ss_facebook', 'label' => 'Facebook URL', 'name' => 'facebook', 'type' => 'url', 'wrapper' => array( 'width' => 33 ) ),
			array( 'key' => 'field_ss_linkedin', 'label' => 'LinkedIn URL', 'name' => 'linkedin', 'type' => 'url', 'wrapper' => array( 'width' => 34 ) ),

			array( 'key' => 'field_ss_tab_hours', 'label' => 'Hours', 'type' => 'tab' ),
			$day( 'mon', 'Monday' ),
			$day( 'tue', 'Tuesday' ),
			$day( 'wed', 'Wednesday' ),
			$day( 'thu', 'Thursday' ),
			$day( 'fri', 'Friday' ),
			$day( 'sat', 'Saturday' ),
			$day( 'sun', 'Sunday' ),
		),
	) );
} );
