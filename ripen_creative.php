<?php
/*
Plugin Name: RIPEn Creative Menu and Dashboard Cleanup
Plugin URI: https://github.com/ripencreative/multisite-plugin
Description: Customizations for Client Websites
Version: 1.2
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

// RSS Feed Widget for latest news

add_action('wp_dashboard_setup', 'organicweb_dashboard_widgets');

function organicweb_dashboard_widgets() {
// CHANGE 'OrganicWeb News' BELOW TO THE TITLE OF YOUR WIDGET
wp_add_dashboard_widget( 'dashboard_custom_feed', 'WordPress News', 'organicweb_custom_feed_output' );

function organicweb_custom_feed_output() {
echo '<div class="rss-widget">';
wp_widget_rss_output(array(
// CHANGE THE URL BELOW TO THAT OF YOUR FEED
'url' => 'https://managewp.org/articles.rss',
// CHANGE 'OrganicWeb News' BELOW TO THE NAME OF YOUR WIDGET
'title' => 'WordPress News',
// CHANGE '2' TO THE NUMBER OF FEED ITEMS YOU WANT SHOWING
'items' => 5,
// CHANGE TO '0' IF YOU ONLY WANT THE TITLE TO SHOW
'show_summary' => 1,
// CHANGE TO '1' TO SHOW THE AUTHOR NAME
'show_author' => 0,
// CHANGE TO '1' TO SHOW THE PUBLISH DATE
'show_date' => 0
));
echo "</div>";
}
}

?>
