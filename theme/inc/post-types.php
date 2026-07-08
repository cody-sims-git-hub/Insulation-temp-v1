<?php
/**
 * Custom post types — the client's editable content buckets.
 *
 * Team / Services / Testimonials are open lists the client can add to.
 * Site Settings is a singleton (one entry) for contact details + hours.
 * Blog uses native Posts. None of these expose layout/design controls.
 *
 * These four cover most small-business sites. Add or rename per client; the
 * templates read whatever CPTs exist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {

	register_post_type( 'team', array(
		'labels'        => sdp_pt_labels( 'Team Member', 'Team' ),
		'public'        => true,
		'has_archive'   => false,
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 21,
		'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
		'rewrite'       => array( 'slug' => 'team' ),
	) );

	register_post_type( 'service', array(
		'labels'        => sdp_pt_labels( 'Service', 'Services' ),
		'public'        => true,
		'has_archive'   => false,
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 22,
		'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
		'rewrite'       => array( 'slug' => 'service' ),
	) );

	register_post_type( 'testimonial', array(
		'labels'        => sdp_pt_labels( 'Testimonial', 'Testimonials' ),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-format-quote',
		'menu_position' => 23,
		'supports'      => array( 'title', 'page-attributes' ),
	) );

	// Singleton: one entry drives header, footer and contact blocks everywhere.
	register_post_type( 'sitesettings', array(
		'labels'        => sdp_pt_labels( 'Site Settings', 'Site Settings' ),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-admin-generic',
		'menu_position' => 24,
		'supports'      => array( 'title' ),
		'capabilities'  => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'  => true,
	) );
} );

/**
 * Standard labels array.
 */
function sdp_pt_labels( $singular, $plural ) {
	return array(
		'name'          => $plural,
		'singular_name' => $singular,
		'add_new_item'  => "Add New {$singular}",
		'edit_item'     => "Edit {$singular}",
		'new_item'      => "New {$singular}",
		'view_item'     => "View {$singular}",
		'search_items'  => "Search {$plural}",
		'not_found'     => "No {$plural} yet",
		'all_items'     => $plural,
		'menu_name'     => $plural,
	);
}

/**
 * Order Team / Services / Testimonials by the drag-and-drop "Order" attribute.
 */
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( in_array( $q->get( 'post_type' ), array( 'team', 'service', 'testimonial' ), true ) ) {
		$q->set( 'orderby', 'menu_order' );
		$q->set( 'order', 'ASC' );
	}
} );
