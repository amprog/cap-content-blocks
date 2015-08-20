<?php
/*
Plugin Name: CAP Content Blocks (Shortcodes)
Plugin URI: http://americanprogress.org
Description: CAP specific shortcodes for use in long form content.
Version: 0.1
Author: Seth Rubenstein for Center for American Progress
Author URI: http://sethrubenstein.info
*/

$plugin_dir = plugin_dir_path( __FILE__ );

function ccb_styles_scripts() {
    wp_enqueue_style( 'cap-content-blocks',  plugin_dir_url( __FILE__ ) . 'css/ccb.css' );

    // Check to see if the current theme has support for cap-content-blocks
    // This can be delcared on a theme by declaring add_theme_support('cap-content-blocks'); in functions.php
    if (current_theme_supports('cap-content-blocks')) {

    } else {

    }

    // check for material design icons and then include
    if ( !wp_style_is( 'mdi', 'enqueued' ) ) {
        wp_enqueue_style( 'mdi',  plugin_dir_url( __FILE__ ) . 'bower_components/mdi/css/materialdesignicons.min.css' );
    }

}
add_action( 'wp_enqueue_scripts', 'ccb_styles_scripts' );

function ccb_editor_style() {
    add_editor_style( plugin_dir_url( __FILE__ ) . 'css/ccb-editor-style.css' );
    add_editor_style( plugin_dir_url( __FILE__ ) . 'bower_components/mdi/css/materialdesignicons.min.css' );
}
add_action( 'admin_init', 'ccb_editor_style' );

include $plugin_dir.'/shortcodes/chapter.php';
include $plugin_dir.'/shortcodes/content.php';
include $plugin_dir.'/shortcodes/download.php';
include $plugin_dir.'/shortcodes/interactive.php';
include $plugin_dir.'/shortcodes/parallax.php';
include $plugin_dir.'/shortcodes/pullquote.php';
include $plugin_dir.'/shortcodes/related-post.php';
include $plugin_dir.'/shortcodes/video.php';
