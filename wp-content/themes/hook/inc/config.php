<?php
if (!isset($content_width)) {
    $content_width = 1920;
}

define('HOOK_SIDEBAR_CLASSES','small-3 columns prk_bordered_left');
define('ACF_LITE',false);
define('HOOK_THEME_ID','16278811');//prk_hook_options


include_once( ABSPATH.'wp-admin/includes/plugin.php' );

if (function_exists('wp_get_theme')) {
    $prk_theme=wp_get_theme(get_template());
    define('HOOK_VERSION',$prk_theme->Version);
}
else {
    define('HOOK_VERSION',1);
}

if ( function_exists('hook_vc_scripts') ) {
    define('HOOK_FRAMEWORK_ON',true);
}
else {
    define('HOOK_FRAMEWORK_ON',false);
}
if ( class_exists( 'Vc_Manager' ) ) {
    define('HOOK_VC_ON',true);
}
else {
    define('HOOK_VC_ON',false);
}
if ( class_exists( 'woocommerce' ) ) {
    define('HOOK_WOO_ON',true);
}
else {
    define('HOOK_WOO_ON',false);
}
if ( function_exists('icl_object_id') ) {
    define('HOOK_WPML_ON',true);
}
else {
    define('HOOK_WPML_ON',false);
}

//SHOW PLUGIN REQUIRES UPDATE MESSAGE
if (is_admin()) {
    if (get_option('hook_last_version')=="") {
        add_option('hook_last_version', HOOK_VERSION, '', 'yes');
    }
    if (get_option('hook_last_version')!=HOOK_VERSION) {
        update_option('hook_last_version', HOOK_VERSION);
        delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' );
    }
}

function hook_request_filter($hook_query_vars) {
    if (isset($_GET['s']) && empty($_GET['s'])) {
        $hook_query_vars['s'] = " ";
    }
    return $hook_query_vars;
}

add_filter('request', 'hook_request_filter');

/*
function hook_root_relative_url($hook_input) {
    $hook_output = preg_replace_callback(
        '!(https?://[^/|"]+)([^"]+)?!',
        create_function(
            '$matches',
            'if (isset($matches[0]) && $matches[0] === home_url("/")) { return "/";' .
            '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
            '} else { return $matches[0]; };'
        ),
        $hook_input
    );
    return $hook_output;
}

function hook_root_relative_attachment_urls() {
    if (!is_feed()) {
        add_filter('wp_get_attachment_url', 'hook_root_relative_url');
        add_filter('wp_get_attachment_link', 'hook_root_relative_url');
    }
}

function hook_enable_root_relative_urls() {
    return !(is_admin() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) && current_theme_supports('root-relative-urls');
}

if (hook_enable_root_relative_urls()) {
    $tags = array(
        'bloginfo_url',
        'theme_root_uri',
        'stylesheet_directory_uri',
        'template_directory_uri',
        'plugins_url',
        'the_permalink',
        'wp_list_pages',
        'wp_list_categories',
        'wp_nav_menu',
        'the_content_more_link',
        'the_tags',
        'get_pagenum_link',
        'get_comment_link',
        'month_link',
        'day_link',
        'year_link',
        'tag_link',
        'the_author_posts_link'
    );

    add_filters($tags, 'hook_root_relative_url');
    add_action('pre_get_posts', 'hook_root_relative_attachment_urls');
}
*/

function hook_wp_nav_menu($hook_text) {
    $hook_replace = array(
        'current-menu-item'     => 'active',
        'current-menu-parent'   => 'active',
        'current-menu-ancestor' => 'active',
        'current_page_item'     => 'active',
        'current_page_parent'   => 'active',
        'current_page_ancestor' => 'active',
    );
    $hook_text = str_replace(array_keys($hook_replace), $hook_replace, $hook_text);
    return $hook_text;
}
add_filter('wp_nav_menu', 'hook_wp_nav_menu');


//WOOCOMMERCE TWEAKS
//CART.PHP
//LINE 131