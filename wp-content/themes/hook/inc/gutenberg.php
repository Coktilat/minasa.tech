<?php

function prk_setup_theme_supported_features() {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'prk_setup_theme_supported_features' );


function prk_check_gutenberg() {
    if(function_exists( 'register_block_type' )) {
        if (has_blocks()) {
            return true;
        }
    }
    //default
    return false;
}


function prk_tweak_blocks() {
    //Load theme scripts
    wp_enqueue_script(
        'prk_tweak_blocks',
        get_template_directory_uri().( '/js/gutenberg.js'),
        array( 'wp-blocks' ),
        HOOK_VERSION
    );

    //LOAD THEME STYLES
    wp_enqueue_style( 'hook-gutenberg', get_template_directory_uri(). '/css/admin-gutenberg.css' , false, HOOK_VERSION, 'all' );

    //Add styles related with the theme options
    $hook_options=hook_options();
    $hook_css_build="";

    //FONTS
    $hook_css_build.="html .editor-styles-wrapper,html .editor-styles-wrapper p {font-size:".$hook_options['font_size']."px;}";
    if (!isset($hook_options['body_font']['css'])) {
        $hook_options['body_font']=array(
            'value' => 'PT+Sans:400,700,400italic,700italic',
            'css' => "PT Sans",
            'hosted'=> 'google'
        );
    }
    $hook_css_build.="html .editor-styles-wrapper {font-family:".$hook_options['body_font']['css'].";}";
    if (!isset($hook_options['header_font']['css'])) {
        $hook_options['header_font']=array(
            'value' => 'PT+Sans:400,700,400italic,700italic',
            'css' => "PT Sans",
            'hosted'=> 'google'
        );
    }
    $hook_css_build.="html .editor-post-title__block .editor-post-title__input {font-family:".$hook_options['header_font']['css'].";}";

    //TITLE ALIGN
    switch ($hook_options['headings_align']) {
        case 'hook_left_align':
            $hook_css_build.="html .editor-post-title__block .editor-post-title__input {text-align:left;}";
            break;
        case 'hook_right_align':
            $hook_css_build.="html .editor-post-title__block .editor-post-title__input {text-align:right;}";
            break;
        default:
            $hook_css_build.="html .editor-post-title__block .editor-post-title__input {text-align:center;}";
    }

    //COLORS
    $hook_css_build.="html .editor-styles-wrapper,html .editor-styles-wrapper p,html .editor-styles-wrapper h1,html .editor-styles-wrapper h2,html .editor-styles-wrapper h3,html .editor-styles-wrapper h4,html .editor-styles-wrapper h5,html .editor-styles-wrapper h6,.editor-styles-wrapper .wp-block-freeform.block-library-rich-text__tinymce code,.wp-block-freeform.block-library-rich-text__tinymce pre {color:".$hook_options['inactive_color'].";}";
    $hook_css_build.=".editor-styles-wrapper .editor-rich-text__tinymce a {color: ".$hook_options['active_color'].";}";

    //Lines
    $hook_css_build.=".editor-styles-wrapper .mce-item-table {border-top: 1px solid ".$hook_options['lines_color'].";}";
    $hook_css_build.=".editor-styles-wrapper .mce-item-table td,.editor-styles-wrapper .mce-item-table th {border-right: 1px solid ".$hook_options['lines_color'].";}";
    $hook_css_build.=".editor-styles-wrapper .mce-item-table td,.editor-styles-wrapper .mce-item-table th {border-bottom: 1px solid ".$hook_options['lines_color'].";}";
    $hook_css_build.=".editor-styles-wrapper .mce-item-table {border-left: 1px solid ".$hook_options['lines_color'].";}";

    $hook_css_build .= "html .wp-block {max-width: ".$hook_options['custom_width_blog']."px;}";
    $hook_css_build .= "html .post-type-page .wp-block {max-width: ".$hook_options['custom_width']."px;}";

    //OUTPUT THE CUSTOM STYLES WE JUST BUILT
    wp_add_inline_style('hook-gutenberg',$hook_css_build);

    //FONTS
    $hook_font_families=array();
    //HEADER FONT
    if ($hook_options['header_font']['hosted']=='google') {
        $hook_font_families[]=str_replace('+',' ',$hook_options['header_font']['value']);
    }
    if ($hook_options['header_font']['hosted']=='theme') {
        wp_enqueue_style( 'prk_header_font', get_template_directory_uri().'/inc/fonts/'.$hook_options['header_font']['value'].'/stylesheet.css',false,HOOK_VERSION);
    }
    if ($hook_options['header_font']['hosted']=='plugin') {
        wp_enqueue_style( 'prk_header_font', $hook_options['header_font']['value'],false,HOOK_VERSION);
    }
    //BODY FONT
    if ($hook_options['body_font']['hosted']=='google') {
        $hook_font_families[]=str_replace('+',' ',$hook_options['body_font']['value']);
    }
    if ($hook_options['body_font']['hosted']=='theme') {
        wp_enqueue_style( 'prk_body_font', get_template_directory_uri().'/inc/fonts/'.$hook_options['body_font']['value'].'/stylesheet.css',false,HOOK_VERSION);
    }
    if ($hook_options['body_font']['hosted']=='plugin') {
        wp_enqueue_style( 'prk_body_font', $hook_options['body_font']['value'],false,HOOK_VERSION);
    }
    //EXTRA FONT
    if (isset($hook_options['custom_font']['hosted']) && $hook_options['custom_font']!="") {
        if ($hook_options['custom_font']['hosted']=='google') {
            $hook_font_families[]=str_replace('+',' ',$hook_options['custom_font']['value']);
        }
        if ($hook_options['custom_font']['hosted']=='theme') {
            wp_enqueue_style( 'prk_custom_font', get_template_directory_uri().'/inc/fonts/'.$hook_options['custom_font']['value'].'/stylesheet.css',false,HOOK_VERSION);
        }
        if ($hook_options['custom_font']['hosted']=='plugin') {
            wp_enqueue_style( 'prk_custom_font', $hook_options['custom_font']['value'],false,HOOK_VERSION);
        }
    }
    if (!empty($hook_font_families)) {
        $query_args=array(
            'family' => urlencode(implode('|', $hook_font_families )),
            'subset' => urlencode('latin,latin-ext'),
        );
        $fonts_url=add_query_arg($query_args,'https://fonts.googleapis.com/css');
        $fonts_url=esc_url_raw($fonts_url);
        wp_enqueue_style('hook_google_fonts', $fonts_url, array(), null );
    }

}
add_action( 'enqueue_block_editor_assets', 'prk_tweak_blocks' );



//CREATE gut.js
//ADD admin.css class
//ADD gut.scss
//ADJUST single post+page