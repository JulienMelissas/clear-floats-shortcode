<?php
/*
Plugin Name: Clear Floats Shortcode
Description: Provides a simple [clear] shortcode to clear floats. Defaults to clear both in a div tag, but you can provide an argument for the direction: [clear direction="both"], [clear direction="left"], [clear direction="right"]. If you put content inbetween the [clear] shortcode, you will get a div with the clearfix css added.
Author: Julien Melissas
Author URI: http://julienmelissas.com
Version: 1.0.0
License: GPL2
*/

defined( 'ABSPATH' ) or die();

// Adds CSS to the head for the plugin to use, if they're using the shortcode.
function cfs_clear_css() {
	global $post;
	if ( has_shortcode( $post->post_content, 'clear' ) ) {
		echo "
<style>
/*
 * Clear Floats Shortcode CSS
 */
.cfs-clearfix:before,
.cfs-clearfix:after {
	content: \" \";
	display: table;
}
.cfs-clearfix:after {
	clear: both;
}

.cfs-both {
	clear: both;
}

.cfs-right {
	clear: right;
}

.cfs-left {
	clear: left;
}
</style>";
	}
}
add_action( 'wp_head', 'cfs_clear_css' );

// Shortcode
function clear_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'direction' => 'both'
	), $atts));

	// Blank output at first.
	$output = '';

	if ( ! empty( $content ) ) {
		$output = '<div class="cfs-clearfix">' . $content . '</div>';
	} else {
		if ( $direction === 'right' ) {
			$output = '<div class="cfs-right"></div>';
		} elseif ( $direction === 'left' ) {
			$output = '<div class="cfs-left"></div>';
		} elseif ( $direction === 'both' ) {
			$output = '<div class="cfs-both"></div>';
		}
	}

	return $output;
}
add_shortcode( 'clear', 'clear_shortcode' );
