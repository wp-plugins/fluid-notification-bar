<?php

/*
Plugin Name: Fluid Notification Bar
Plugin URI: http://masterblogster.com/plugins/fluid-notification-bar/
Description: Wanna say something to your website visitor? This plugin adds the cool responsive notification bar on the top of your website homepage.
Author: Shrinivas Naik
Version: 2.0
Author URI: http://www.masterblogster.com
*/

// Add plugin options page
include(plugin_dir_path( __FILE__ ) . 'fnbar_plugin_options.php');

/* --------------------------------------------------------------------------------------------------------------------*/
/*  Main plugin code */
function load_fn_notibar_on_header()
{

        //Get notification text
        $fn_noti_text=get_option('fn_notibar_options');

    if($fn_noti_text['fn_notibar_text']==""){
    $fn_noti_text['fn_notibar_text']='Welcome to Fluid Notification Bar.. Go to Settings>>Fluid Notification Bar Options to add your notification, <a href="http://masterblogster.com/plugins/fluid-notification-bar/" target="blank"> click here</a> for more info.';
    }
    
    echo '<div id="toolbar_holder">
	<div id="toolbar">'. $fn_noti_text['fn_notibar_text'] .'</div>
    <div id="hidetoolbar">X</div>
	</div>';
 
}

function fn_notibar_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('newscript',plugins_url( 'fnbar_js.js' , __FILE__ ),array( 'jquery' ));
    wp_register_style( 'prefix-style', plugins_url('fnbar_css.css', __FILE__) );
    wp_enqueue_style( 'prefix-style' );
}

add_action('wp_head','load_fn_notibar_on_header');
add_action('wp_enqueue_scripts','fn_notibar_scripts');

?>