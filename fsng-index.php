<?php
/*
	Plugin Name: Flexslider for themes and galleries
	Description: Options to add Flexslider to WordPress site, change global slider settings, enable slider for galleries
	Version: 1.1
	Author: Marktime Media

	WordPress plugin that has Flexslider options, plus options to hack the gallery[id="1,22,... etc "] shortcode
	to display a clean basic flexslider instead of the default static thumbnails (h/t Flexslider for Native Gallery plugin by sarankumar)
*/


//define constants for Plugin details
define( 'FS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// includes
require_once( FS_PLUGIN_DIR . 'lib/fs-wp-options.php' );
require_once( FS_PLUGIN_DIR . 'lib/fs-wp-gallery.php' );

// scripts
function fs_wp_scripts() {

	$fs_options = get_option( 'fs_wp_options' );

	if( 'yes' == $fs_options['fs_wp_field_enqueue_flexslider'] ) {
		wp_enqueue_script('flexslider', plugins_url( 'assets/jquery.flexslider-min.js', __FILE__), array( 'jquery' ) );
	}
	if( 'yes' == $fs_options['fs_wp_field_enqueue_css'] ) {
		wp_enqueue_style('flexslider_css', plugins_url( 'assets/flexslider.css', __FILE__) );
	}
	wp_enqueue_script( 'flexslider-options', plugins_url( 'flexslider-options.js', __FILE__) );

	wp_localize_script( 'flexslider-options', 'fsOptions', $fs_options );

}

add_action( 'wp_enqueue_scripts', 'fs_wp_scripts' );

?>
