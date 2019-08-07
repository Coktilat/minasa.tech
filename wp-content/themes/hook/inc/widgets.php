<?php

function hook_widgets_init() {
    $prk_hook_options=hook_options();
    register_sidebar(array(
        'name' => esc_html__('Right Sidebar', 'hook'),
        'id' => 'sidebar-primary',
        'before_widget' => '<div id="%1$s" class="widget %2$s vertical_widget clearfix"><div class="widget_inner prk_9_em">',
        'after_widget' => '</div><div class="clearfix"></div></div>',
        'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
        'after_title' => '<div class="hook_titled simple_line"></div></div><div class="clearfix simple_line"></div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Hidden Sidebar', 'hook'),
        'id' => 'sidebar-hidden',
        'before_widget' => '<div id="%1$s" class="widget %2$s vertical_widget"><div class="widget_inner">',
        'after_widget' => '</div><div class="clearfix"></div></div>',
        'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
        'after_title' => '</div><div class="clearfix"></div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Mobile Sidebar', 'hook'),
        'id' => 'sidebar-mobile',
        'before_widget' => '<div id="%1$s" class="widget %2$s header_stack prk_lf"><div class="widget_inner">',
        'after_widget' => '</div><div class="clearfix"></div></div>',
        'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
        'after_title' => '</div><div class="clearfix"></div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Sidebar', 'hook'),
        'id' => 'sidebar-footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s columns"><div class="widget_inner">',
        'after_widget' => '</div><div class="clearfix"></div></div>',
        'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
        'after_title' => '</div><div class="clearfix"></div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Above Menu - Left Sidebar', 'hook'),
        'id' => 'abovebar-top-left',
        'before_widget' => '<div id="%1$s" class="widget_inner prk_lf">',
        'after_widget' => '</div>',
        'before_title' => '<div class="hide_now">',
        'after_title' => '</div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Above Menu - Right Sidebar', 'hook'),
        'id' => 'abovebar-top-right',
        'before_widget' => '<div id="%1$s" class="widget_inner prk_lf">',
        'after_widget' => '</div>',
        'before_title' => '<div class="hide_now">',
        'after_title' => '</div>',
    ));
    //PLACE WOOCOMMERCE IF NEEDED
    if (HOOK_WOO_ON=="true") {
            register_sidebar(array(
            'name' => esc_html__('WooCommerce Sidebar', 'hook'),
            'id' => 'prk-woo-sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s vertical_widget clearfix"><div class="widget_inner prk_9_em">',
            'after_widget' => '</div><div class="clearfix"></div></div>',
            'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
            'after_title' => '<div class="hook_titled simple_line"></div></div><div class="clearfix simple_line"></div>',
        ));
    } 
}
add_action('widgets_init', 'hook_widgets_init');
