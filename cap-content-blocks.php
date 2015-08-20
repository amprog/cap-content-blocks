<?php
/*
Plugin Name: CAP Content Blocks (Shortcodes)
Plugin URI: http://americanprogress.org
Description: CAP specific shortcodes for use in long form content.
Version: 0.1
Author: Seth Rubenstein for Center for American Progress
Author URI: http://sethrubenstein.info
*/

// if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
//    add_action( 'admin_notices', function(){
//        if ( current_user_can( 'activate_plugins' ) ) {
//            echo '<div class="error message"><p><strong>UHOH</strong>. You need Shortcake (Shortcode UI) in order to use CAP Content Blocks.</p></div>';
//        }
//    });
//    return;
// }


$plugin_dir = plugin_dir_path( __FILE__ );

function ccb_styles_scripts() {
    wp_register_style( 'cap-content-blocks',  plugin_dir_url( __FILE__ ) . 'css/ccb.css' );

    // Check to see if the current theme has support for cap-content-blocks
    // This can be delcared on a theme by declaring add_theme_support('cap-content-blocks'); in functions.php
    if (current_theme_supports('cap-content-blocks')) {

    } else {

    }

    // check for material design icons and then include
    if ( wp_style_is( 'mdi', 'registered' ) ) {
        return;
    } else {
        wp_register_style( 'mdi',  plugin_dir_url( __FILE__ ) . 'bower_components/mdi/css/materialdesigicons.min.css' );
    }
    // if ( wp_script_is( $handle, 'enqueued' ) ) {
    //     return;
    // } else {
    //     wp_register_script( 'fluidVids.js', plugin_dir_url(__FILE__).'js/fluidvids.min.js');
    //     wp_enqueue_script( 'fluidVids.js' );
    // }
}
add_action( 'wp_enqueue_scripts', 'ccb_styles_scripts' );

function ccb_editor_style() {
    add_editor_style( plugin_dir_url( __FILE__ ) . 'css/ccb-editor-style.css' );
    // check for material design icons and then include
}
add_action( 'admin_init', 'ccb_editor_style' );

include $plugin_dir.'/shortcodes/chapter.php';
include $plugin_dir.'/shortcodes/content.php';
include $plugin_dir.'/shortcodes/download.php';
include $plugin_dir.'/shortcodes/interactive.php';
include $plugin_dir.'/shortcodes/parallax.php';
include $plugin_dir.'/shortcodes/pullquote.php';
include $plugin_dir.'/shortcodes/related-post.php';
