<?php
/*
Plugin Name: Log Out Shortcode
Plugin URI: https://om4.com.au/plugins/log-out-shortcode/
Description: Easily add a log out link to a post or page using a simple <code>[logout]</code> shortcode.
Version: 1.0.5
Author: OM4
Author URI: https://om4.com.au/plugins/
Text Domain: log-out-shortcode
License: GPLv2
*/

/*

   Copyright 2014-2016 OM4 (email: plugins@om4.com.au    web: https://om4.com.au/)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function logout_shortcode( $atts, $content = null, $shortcode_name = null ) {
	$defaults = array(
			'text'     => __( 'Log out' ), // This is the default log out text from wp-includes/general-template.php
			'redirect' => '', // path/URL to redirect to after logging out
			'class'    => 'logout', // CSS Class(es) to use in link.
	);

	if ( ! is_user_logged_in() ) {
		return '';
	}

	$atts = shortcode_atts( $defaults, $atts );

	if ( 'logout_to_home' == $shortcode_name ) {
		$atts['redirect'] = 'home';
	} else if ( 'logout_to_current' == $shortcode_name ) {
		$atts['redirect'] = 'current';
	}

	if ( 'home' == $atts['redirect'] ) {
			$atts['redirect'] = home_url();
	} else if ( 'current' == $atts['redirect'] ) {
		$atts['redirect'] = get_the_permalink();
	}

	$class_html = '';
	if ( '' != $atts['class'] ) {
		// Multiple classes are separated by a space
		$classes = explode( ' ', $atts['class'] );
		$classes = array_map( 'sanitize_html_class', $classes );
		$class_html = ' class="' . implode( $classes, ' ' ) . '"';
	}

	return '<a href="' . esc_url( wp_logout_url( $atts['redirect'] ) ) . '"' . $class_html . '>'  . esc_html( $atts['text'] ) . '</a>';

}
add_shortcode( 'logout', 'logout_shortcode' );
add_shortcode( 'logout_to_current', 'logout_shortcode' );
add_shortcode( 'logout_to_home', 'logout_shortcode' );