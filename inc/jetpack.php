<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package eFolio
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function efolio_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'efolio_jetpack_setup' );
