<?php
/**
 * Check if the theme has support for any of the additional Foundation utilities
 */

function flair_check_theme_support() {
	if ( current_theme_supports( 'foundation-interchange' ) ) {
		add_filter( 'post_thumbnail_html', 'flair_interchange_post_thumbnail_html', 5, 5 );
		add_action( 'init', 'flair_interchange_sizes', 11 );
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_interchange', 11 );
	}

	if ( current_theme_supports( 'foundation-top-bar' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_top_bar', 11 );
	}

	if ( current_theme_supports( 'foundation-magellan' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_magellan', 11 );
	}

	if ( current_theme_supports( 'foundation-orbit' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_orbit', 11 );
	}

	if ( current_theme_supports( 'foundation-clearing' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_clearing', 11 );
	}

	if ( current_theme_supports( 'foundation-abide' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_abide', 11 );
	}

	if ( current_theme_supports( 'foundation-reveal' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_reveal', 11 );
	}

	if ( current_theme_supports( 'foundation-alert' ) ) {
		add_action( 'wp_enqueue_scripts',  'flair_enqueue_alert', 11 );
	}
}

add_action( 'init', 'flair_check_theme_support' );

/**
 * Enqueue Foundations Interchange
 */

function flair_enqueue_interchange() {
	wp_enqueue_script( 'interchange', get_template_directory_uri() . '/js/foundation/foundation.interchange.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Top Bar
 */

function flair_enqueue_top_bar() {
	wp_enqueue_script( 'top-bar', get_template_directory_uri() . '/js/foundation/foundation.topbar.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Magellan
 */

function flair_enqueue_magellan() {
	wp_enqueue_script( 'magellan', get_template_directory_uri() . '/js/foundation/foundation.magellan.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Orbit
 */

function flair_enqueue_orbit() {
	wp_enqueue_script( 'orbit', get_template_directory_uri() . '/js/foundation/foundation.orbit.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Clearing
 */

function flair_enqueue_clearing() {
	wp_enqueue_script( 'clearing', get_template_directory_uri() . '/js/foundation/foundation.clearing.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Abide
 */

function flair_enqueue_abide() {
	wp_enqueue_script( 'abide', get_template_directory_uri() . '/js/foundation/foundation.abide.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Reveal
 */

function flair_enqueue_reveal() {
	wp_enqueue_script( 'reveal', get_template_directory_uri() . '/js/foundation/foundation.reveal.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Enqueue Foundations Alert
 */

function flair_enqueue_alert() {
	wp_enqueue_script( 'alert', get_template_directory_uri() . '/js/foundation/foundation.alert.js', array( 'jquery', 'foundation' ), '5.1.1', true );
}

/**
 * Add some default image sizes to assist with interchange images
 */

function flair_interchange_sizes() {
	add_image_size( 'interchange-small', 480, 99999 );
	add_image_size( 'interchange-medium', 768, 99999 );
	add_image_size( 'interchange-large', 1024, 99999 );
	add_image_size( 'interchange-retina', 1920, 99999 );
}

/**
 * We need to filter our post thumbnails so we can output them in a format that Foundations Interchange needs.
 * We also need a fallback for no JavaScript
 *
 * @param $html
 * @param $post_id
 * @param $post_thumbnail_id
 * @param $size
 * @param $attr
 *
 * @return string
 */

function flair_interchange_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	$default = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	$large   = wp_get_attachment_image_src( $post_thumbnail_id, 'interchange-retina' );
	$small   = wp_get_attachment_image_src( $post_thumbnail_id, 'interchange-small' );
	$medium  = wp_get_attachment_image_src( $post_thumbnail_id, 'interchange-medium' );
	// Create out image tag with our media queries in it
	$html = '<img data-interchange="['. $default[0]. ', (default)],';
	$html .= '[' .$small[0] .', (small)],';
	$html .= '['. $medium[0] .', (medium)],';
	$html .= '['. $large[0] .', (large)],';
	$html .= '['. $large[0] .', (retina)]';
	$html .='">';
	$html .= "<noscript>";
	$html .= "<img src='" . $default[0] . "' />";
	$html .= "</noscript>";

	return $html;
}