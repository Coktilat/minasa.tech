<?php

//CUSTOMIZE MENU BUTTON
function ocdi_plugin_page_setup( $default_settings ) {
    if (!hook_validate_key()) {
        $default_settings['parent_slug'] = '';
        $default_settings['menu_slug']   = 'not-really';
    }
    else {
        $default_settings['parent_slug'] = 'themes.php';
        $default_settings['page_title']  = esc_html__( '1-Click Demo Import' , 'pt-ocdi' );
        $default_settings['menu_title']  = esc_html__( '1-Click Demo Import' , 'pt-ocdi' );
        $default_settings['capability']  = 'import';
        $default_settings['menu_slug']   = 'pt-one-click-demo-import';
    }

    return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );

function ocdi_plugin_intro_text( $default_text ) {
    $default_text .= '<div class="ocdi__intro-text"><div class="ocdi__intro-notice hook_notice notice notice-warning is-dismissible">
    <p>Before you begin, make sure all the required plugins are activated.<br />If you want to generate shop related content make sure that you install and activate <em>WooCommerce by Automattic</em>.<br />If you want to generate the Mailchimp form make sure that you install and activate <em>MailChimp for WordPress by ibericode</em>.<br>Having trouble with this feature? Try the older import procedure. <a href="'.get_admin_url().'themes.php?page=theme_activation_options">Click here to proceed &rarr;</a></p>
  <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );



function ocdi_import_files() {
    return array(
        //DEMO
        array(
            'import_file_name'           => 'Pure Business',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/pure-business.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/pure-business.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/pure-business.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/pure-business.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/business/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Stylish Showcase - 6 pages',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/stylish-showcase.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/stylish-showcase.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/stylish-showcase.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/stylish-showcase.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/agency/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Creative Agency',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/creative-agency.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/creative-agency.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/creative-agency.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/creative-agency.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/creative/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Photography Studio',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/photography-studio.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/photography-studio.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/photography-studio.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/photography-studio.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/photography/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Full Demo - 13 pages',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/full-demo.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/full-demo.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/full-demo.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/full-demo.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/fulldemo/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Event',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/event.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/event.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/event.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/event.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/event/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Bold Startup',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/bold-startup.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/bold-startup.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/bold-startup.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/bold-startup.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/startup/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Architecture',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/architecture.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/architecture.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/architecture.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/architecture.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/architecture/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Single Prodcut Sale',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/single-product-sale.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/single-product-sale.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/single-product-sale.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/single-product-sale.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/single-product-sale/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Featured Portfolio',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/featured-portfolio.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/featured-portfolio.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/featured-portfolio.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/featured-portfolio.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/small-portfolio/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Modern Agency',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/modern-agency.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/modern-agency.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/modern-agency.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/modern-agency.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/worker/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Logistics With Extra Menu',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/logistics-alt.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/logistics-alt.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/logistics-alt.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/logistics-alt.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/logistics-alt/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'RTL Language',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/rtl.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/rtl.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/rtl.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/rtl.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/startup-rtl/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'App - Landing Page',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/app-landing-page.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/app-landing-page.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/app-landing-page.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/app-landing-page.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/app/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Agency Dark Colors - 5 pages',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/agency-dark.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/agency-dark.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/agency-dark.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/agency-dark.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/black/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Alternative Portfolio',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/alternative-portfolio.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/alternative-portfolio.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/alternative-portfolio.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/alternative-portfolio.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/alternative-portfolio/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Real Estate - 7 pages',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/real-estate.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/real-estate.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/real-estate.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/real-estate.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/real-estate/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Transportation & Logistics',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/logistics.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/logistics.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/logistics.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/logistics.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/logistics/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Pulse Agency',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/pulse-agency.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/pulse-agency.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/pulse-agency.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/pulse-agency.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/agency-dark/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Lawyers/Consultants',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/consultancy.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/consultancy.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/consultancy.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/consultancy.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/consultancy/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Agency Bright Colors - 5 pages',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/agency-bright.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/agency-bright.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/agency-bright.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/agency-bright.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'https://www.pirenko-themes.com/hook/white/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'vCard - Musician',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-musician.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-musician.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-musician.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/vcard-musician.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'http://www.pirenko-themes.com/hook/single-screen/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'vCard - Business',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-business.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-business.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/vcard-business.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/vcard-business.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'http://www.pirenko-themes.com/hook/resume/',
        ),
        //DEMO
        array(
            'import_file_name'           => 'Coming Soon',
            'categories'                 => array(''),
            'import_file_url'            => 'http://www.pirenko.com/theme_plugins/hook/import/coming.xml',
            'import_widget_file_url'     => 'http://www.pirenko.com/theme_plugins/hook/import/coming.wie',
            'import_customizer_file_url' => '',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://www.pirenko.com/theme_plugins/hook/import/coming.json',
                    'option_name' => 'prk_hook_options',
                ),
            ),
            'import_preview_image_url'   => plugin_dir_url( __FILE__ ).'/images/demos/coming.jpg',
            'import_notice'              => __( '', 'hook' ),
            'preview_url'                => 'http://www.pirenko-themes.com/hook/coming-soon/',
        ),


    );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


//SET UP HOMEPAGE AND MENUS
function ocdi_after_import_setup() {

    //Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'MainMenu', 'nav_menu' );
    $mobile_menu = get_term_by( 'name', 'MainMenu', 'nav_menu' );

    set_theme_mod(
        'nav_menu_locations', array(
            'prk_main_navigation' => $main_menu->term_id,
            'prk_mobile_navigation' => $mobile_menu->term_id,
        )
    );

    //Assign front page
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );



//DISABLE GETTING THUMBNAILS AND OTHER SIZES DURING IMPORT
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

//DISABLE BRANDING
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

//DISABLE POPUP WITH MODAL WINDOW
//add_filter( 'pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false' );











