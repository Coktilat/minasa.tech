<?php

//ADD THEME NAME TO BODY CLASS
add_filter( 'body_class', 'hook_body' );
function hook_body( $classes ) {
    $classes[]='hook_theme';
    return $classes;
}

//CUSTOMIZE TITLE
function hook_wp_title_for_home( $title ) {
    if(empty($title) && (is_home() || is_front_page()) ) {
        if (get_bloginfo('description')!="") {
            return get_bloginfo('name').' | '.get_bloginfo('description');
        }
        else {
            return get_bloginfo('name');
        }
    }
    if (HOOK_WOO_ON=="true" && is_woocommerce() && is_product_category()) {
        return trim(str_replace('&raquo; ','',single_term_title())).' | '.get_bloginfo('name');
    }
    //DEFAULT RETURN
    return trim(str_replace('&raquo; ','',$title)).' | '.get_bloginfo('name');
}
add_filter( 'wp_title', 'hook_wp_title_for_home' );

//ADD CUSTOM SCRIPTS FOR THE BACKEND
function hook_admin_scripts() {
    wp_register_style( 'prk_admin_css', get_template_directory_uri().'/css/admin.css',false,HOOK_VERSION );
    wp_enqueue_style('prk_admin_css');
    wp_register_script('prk_admin_js',  get_template_directory_uri(). '/js/admin-min.js', array('jquery', 'jquery-ui-core'), HOOK_VERSION, TRUE);
    wp_enqueue_script('prk_admin_js');
}
if (!function_exists('hook_output')) {
    function hook_output() {
        return;
    }
}

//MULTIPLE INCLUDES
include_once get_parent_theme_file_path().'/inc/config.php';
include_once get_parent_theme_file_path().'/inc/css.php';
include_once get_parent_theme_file_path().'/inc/dashboard.php';
include_once get_parent_theme_file_path().'/inc/helper.php';
include_once get_parent_theme_file_path().'/inc/gutenberg.php';
include_once get_parent_theme_file_path().'/inc/widgets.php';
include_once get_parent_theme_file_path().'/inc/modules/custom-menu/sweet-custom-menu.php';
include_once get_parent_theme_file_path().'/inc/modules/ambrosite/ambrosite.php';
include_once get_parent_theme_file_path().'/inc/modules/vt_resize.php';


//CONNECT FUNCTIONS
add_action('admin_enqueue_scripts', 'hook_admin_scripts');
add_action('after_setup_theme', 'hook_setup');
add_action('wp_footer','hook_jquery_send');

if (HOOK_WOO_ON=="true") {

    $prk_hook_options=hook_options();

    //DECLARE WOOCOMMERCE SUPPORT
    add_action( 'after_setup_theme', 'woocommerce_support' );
    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }



    /**
     * Change number of products that are displayed per page (shop page)
     */
    add_filter( 'loop_shop_per_page', 'hook_loop_shop_per_page', 20 );
    function hook_loop_shop_per_page( $cols ) {
        // $cols contains the current number of products per page based on the value stored on Options -> Reading
        // Return the number of products you wanna show per page.
        $prk_hook_options=hook_options();
        if (!isset($prk_hook_options['woo_prods_nr'])) {
            $prk_hook_options['woo_prods_nr']=8;
        }

        return $prk_hook_options['woo_prods_nr'];
    }

    add_filter( 'get_product_search_form' , 'hook_custom_product_searchform' );
    function hook_custom_product_searchform( $form ) {

        $form='<form method="get" id="searchform" action="'.esc_url(home_url('/')).'">
                <div class="hook_swrapper">
                    <label class="screen-reader-text" for="s">'.esc_html__( 'Search for:', 'hook' ).'</label>
                    <input class="search-field pirenko_highlighted prk_heavier_500" type="text" value="'. get_search_query().'" name="s" id="s" placeholder="'. esc_html__( 'Search for products', 'hook' ).'" />
                    <div class="colored_theme_button">
                    <input type="submit" id="searchsubmit" value="" />
                    </div>
                    <div class="hook_lback per_init">
                        <i class="hook_fa-search"></i>
                    </div>
                    <input type="hidden" name="post_type" value="product" />
                </div>
            </form>';
        return $form;
    }

    add_filter( 'loop_shop_columns', 'hook_loop_shop_columns', 1, 10 );
    function hook_loop_shop_columns( $number_columns ) {
        global $woo_col_nr;
        $prk_hook_options=hook_options();
        if (is_product()) {
            $woo_col_nr="3";
        }
        else {
            if ($prk_hook_options['woo_col_nr']!="") {
                $woo_col_nr=$prk_hook_options['woo_col_nr'];
            } else {
                $woo_col_nr="4";
            }
        }
        return $woo_col_nr;
    }

    //CHANGE SUMMARY ORDER - SINGLE PRODUCT PAGE
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 3 );

    //ADJUST THE NUMBER OF RELATED PRODUCTS
    add_filter( 'woocommerce_output_related_products_args', 'hook_related_products_args' );
    function hook_related_products_args( $hook_query_args ) {
        $hook_query_args['posts_per_page']=3;
        $hook_query_args['columns']=3;
        return $hook_query_args;
    }

    //ADD CART INFO TO THE MENU
    if (isset($prk_hook_options['woo_cart_display']) && $prk_hook_options['woo_cart_display']=="1") {
        add_filter( 'wp_nav_menu_items', 'hook_cart_menu_item', 10, 2 );
    }
    function hook_cart_menu_item ( $hook_items, $args ) {
        global $woocommerce;
        $prk_hook_options=hook_options();
        $hook_cart_url=wc_get_cart_url();
        if ($hook_cart_url=="")
            $hook_cart_url="#";
        $hook_cart_contents_count=$woocommerce->cart->cart_contents_count;
        if ($hook_cart_contents_count==1) {
            $hook_cart_contents=$hook_cart_contents_count." ".__('Item','woocommerce');
        }
        else {
            $hook_cart_contents=$hook_cart_contents_count." ".__('Items','woocommerce');
        }
        $hook_cart_total=$woocommerce->cart->get_cart_total();
        if ($hook_cart_contents_count > 0 || (isset($prk_hook_options['woo_cart_always_display']) && $prk_hook_options['woo_cart_always_display']=="1")) {
            $hook_items .= '<li id="prk_hidden_cart">';
            $hook_items .= '<a href="'.esc_url($hook_cart_url).'">';
            if (is_array($prk_hook_options['woo_cart_info']) || $prk_hook_options['woo_cart_info']=="") {
                $prk_hook_options['woo_cart_info']="items";
            }
            $hook_items .= '<div class="prk_cart_label">';
            $hook_items.='<i class="hook_fa-shopping-basket"></i>';
            if ($prk_hook_options['woo_cart_info']=="items") {
                $hook_items.=$hook_cart_contents;
            }
            else if ($prk_hook_options['woo_cart_info']=="price") {
                $hook_items.=$hook_cart_total;
            }
            else if ($prk_hook_options['woo_cart_info']=="both") {
                $hook_items.=$hook_cart_contents.' : '. $hook_cart_total;
            }
            $hook_items .='</div></a></li>';
        }
        return $hook_items;
    }
}

add_action ('wp_loaded', 'hook_custom_redirect');
function hook_custom_redirect() {
    if (isset($_GET["prk_act_activate"]) && strlen($_GET["prk_act_activate"])==36) {
        update_option('hook_prk_one', $_GET["prk_act_activate"]);
        if ($_GET["page"]=='hook-install-required-plugins') {
            wp_redirect(admin_url('admin.php?page=hook-admin-settings.php'));
        }
        else {
            wp_redirect(admin_url('themes.php?page=theme_activation_options'));
        }
        exit;
    }
}

if (!function_exists('hook_validate_key')) {
    function hook_validate_key() {
        if (get_option('hook_prk_one')=="") {
            add_option( 'hook_prk_one', 'off', '', 'yes' );
        }
        if (get_option('hook_prk_one')=='off') {
            return false;
        }
        else {
            return true;
        }
    }
}

if (!function_exists('hook_output_keyform')) {
    function hook_output_keyform() {
        $hook_theme=wp_get_theme();
        ?>
        <form id="pirenko_verify_form" class="themed" method="post" data-path="<?php echo get_home_url(); ?>" data-admin="<?php echo admin_url('themes.php?page=hook-install-required-plugins&prk_act_activate='); ?>" data-theme="<?php echo HOOK_THEME_ID; ?>">
            <div class="pirenko_verify_purchase">
                <div class="spinner"></div>
                <input id="pirenko_purchase_key" type="text" name="pirenko_purchase_key" value="" /><br />
                <input type="submit" value="<?php echo esc_attr__( 'Validate Purchase Code', 'hook'); ?>" class="button button-primary button-large" />
            </div>
            <div id="pirenko_verify_form-output">
                <p>You can purchase a <?php echo esc_attr($hook_theme->get('Name').' - '.$hook_theme->get('Description')); ?> license <a href="https://themeforest.net/cart/configure_before_adding/<?php echo HOOK_THEME_ID; ?>?license=regular&ref=Pirenko&size=source&support=bundle_6month" target="_blank">here</a>.</p>
            </div>
        </form>
        <?php
    }
}

//REDIRECT TO LICENSE ACTIVATION PAGE AFTER THE THEME IS ACTIVATED
add_action('after_switch_theme', 'hook_welcome_page');
function hook_welcome_page () {
    if (!hook_validate_key()) {
        wp_redirect(admin_url('admin.php?page=hook-admin-settings.php'));
    }
}

if (!hook_validate_key()) {
    add_action('admin_menu', 'hook_temp_menu');
    function hook_temp_menu() {
        add_theme_page('Install Plugins Page', 'Install Plugins', 'edit_theme_options', 'hook-install-required-plugins', 'hook_license_function');
    }
    function hook_license_function() {
        $hook_theme=wp_get_theme();
        ?>
        <div class="wrap"></div>
        <div class="prk_wrap">
            <div id="lic_wrapper" class="left_floated">
                <div id="lic_left_column" class="left_floated"></div>
                <div id="lic_right_column" class="left_floated">
                    <h2 class="pirenko_import_title"><?php echo esc_attr($hook_theme->get('Name').' '.__('Theme - Install Bundled Plugins', 'hook')); ?></h2>
                    <em>To access this feature you need to enter the theme Purchase Code.</em>
                    <?php
                    $output_footer=false;
                    if (isset($_GET["prk_act_activate"])) {
                        echo '<div id="prk_activate_message">';
                        echo '</div>';
                    }
                    else {
                        hook_output_keyform();
                        $output_footer=true;
                    }
                    ?>
                </div>
            </div>
            <div class="clear"></div>
            <?php
            if ($output_footer==true) {
                ?>
                <div class="clear bt_48"></div>
                <em>If you already have a license, please head to <a href="https://themeforest.net/downloads?ref=Pirenko" target="_blank">themeforest.net</a> and here's how to get it in 3 easy steps:</em>
                <div class="clear bt_6"></div>
                <img id="prk_license_img" src="<?php echo get_template_directory_uri(); ?>/images/license.jpg" />
                <?php
            }
            ?>
        </div>
        <?php
    }
}
else {
    //PLUGIN ACTIVATION CLASS
    require_once get_template_directory().'/inc/modules/tgm-plugin-activation/class-tgm-plugin-activation.php';

    add_action( 'tgmpa_register', 'hook_register_required_plugins' );
    if (!function_exists('hook_register_required_plugins')) {
        function hook_register_required_plugins() {

            $plugins=array(
                array(
                    'name'                  => esc_html__('Hook Framework','hook'),
                    'slug'                  => 'hook_framework',
                    'source'                => 'http://www.pirenko.com/theme_plugins/hook/hook_framework.php?prk_version=35&prk_key='.trim(get_option('hook_prk_one')).'&prk_domain='.get_home_url().'&prk_theme_id='.HOOK_THEME_ID,
                    'required'              => true,
                    'version'               => '3.5',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),
                array(
                    'name'                  => esc_html__('One Click Demo Import','hook'),
                    'slug'                  => 'one-click-demo-import',
                    'required'              => true,
                    'version'               => '2.5.1',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => 'https://wordpress.org/plugins/one-click-demo-import/',
                ),
                array(
                    'name'                  => esc_html__('WPBakery Page Builder','hook'),
                    'slug'                  => 'js_composer',
                    'source'                => 'http://www.pirenko.com/theme_plugins/js_composer/js_composer.php?prk_version=603&prk_key='.trim(get_option('hook_prk_one')).'&prk_domain='.get_home_url().'&prk_theme_id='.HOOK_THEME_ID,
                    'required'              => true,
                    'version'               => '6.0.3',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),
                array(
                    'name'                  => esc_html__('Envato Market','hook'),
                    'slug'                  => 'envato-market',
                    'source'                => get_template_directory().'/external_plugins/envato-market.zip',
                    'required'              => false,
                    'version'               => '2.0.1',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),
            );
            $config=array(
                'domain'            => 'hook',
                'default_path'      => '',
                'menu'              => 'install-required-plugins',
                'has_notices'       => true,
                'is_automatic'      => true,
                'message'           => '',
                'strings'           => array(
                    'page_title'                                => esc_html__( 'Install Required Plugins','hook'),
                    'menu_title'                                => esc_html__( 'Install / Update Plugins','hook'),
                    'installing'                                => esc_html__( 'Installing Plugin: %s','hook'),
                    'oops'                                      => esc_html__( 'Something went wrong with the plugin API.','hook'),
                    'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' , 'hook'),
                    'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'hook' ),
                    'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' , 'hook'),
                    'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'hook' ),
                    'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'hook' ),
                    'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' , 'hook'),
                    'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'hook' ),
                    'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'hook'),
                    'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'hook' ),
                    'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'hook' ),
                    'return'                                    => esc_html__( 'Return to Required Plugins Installer','hook'),
                    'plugin_activated'                          => esc_html__( 'Plugin activated successfully.','hook'),
                    'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s','hook'),
                    'nag_type'                                  => 'updated'
                )
            );
            tgmpa( $plugins, $config );
        }
    }
}
?>