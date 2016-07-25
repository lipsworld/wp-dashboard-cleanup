<?php
/*
Plugin Name: RIPEn Creative Multisite Functions
Plugin URI: https://github.com/ripencreative/multisite-plugin
Description: Customizations for Multisites
Version: 1.1.3
License: GPL
Author: Brian Morris
Author URI: https://ripencreative.ca
GitHub Plugin URI: https://github.com/ripencreative/multisite-plugin
GitHub Branch: master
*/

//Remove Non Essential Items from Default Admin Menu

function remove_menus() {
    remove_menu_page('link-manager.php');
    remove_menu_page('tools.php');
    remove_menu_page('cornerstone-home');
    remove_submenu_page('options-general.php','options-writing.php');
    remove_submenu_page('users.php','user-new.php');
    remove_submenu_page('options-general.php','options-reading.php');
    remove_submenu_page('options-general.php','options-discussion.php');
    remove_submenu_page('options-general.php','options-permalink.php');
    remove_submenu_page('options-general.php','options-media.php');
    remove_submenu_page( 'themes.php', 'ups_sidebars' );
    remove_submenu_page( 'options-general.php', 'akismet-key-config' );
    remove_submenu_page( 'users.php', 'users.php' );
    remove_submenu_page( 'index.php', 'my-sites.php' );
    remove_submenu_page('revslider' ,'revslider_navigation');
    remove_submenu_page('revslider' ,'rev_addon');
    remove_submenu_page( 'options-general.php', 'duplicatepost' );
}

add_action( 'admin_menu', 'remove_menus', 999 );

// Remove items from admin bar

function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('imagify');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Add Support Contact Widget To Dashboard - Ninja Forms Form

add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );

function register_my_dashboard_widget() {
    wp_add_dashboard_widget(
        'support_contact',
        'Have a question? Fill out the form below!',
        'my_dashboard_widget_display'
    );

}
// Change the number in brackets for the Ninja Form Form #
function my_dashboard_widget_display() {
    if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); }
}

// Remove Default Widgets from WordPress Dashboard


function remove_dashboard_widgets() {
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
    unset($wp_meta_boxes['dashboard']['normal']['high']['welcome_panel']);

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets', 999 );

// Automatically set permalink structure

function set_permalink(){
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%category%/%postname%/');
}

add_action('init', 'set_permalink');

// Defer Parsing of JavaScript

function defer_parsing_of_js ( $url ) {
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.min.js' ) ) return $url;
    return "$url' defer='defer";
  }
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

?>
