<?php
//themes.php?page=theme_activation_options
function hook_theme_activation_options_init() {
    if (hook_get_theme_activation_options() === false) {
        add_option('hook_theme_activation_options', hook_get_default_theme_activation_options());
    }

    register_setting(
        'hook_activation_options',
        'hook_theme_activation_options',
        'hook_theme_activation_options_validate'
    );
}
add_action('admin_init', 'hook_theme_activation_options_init');

function hook_activation_options_page_capability($capability) {
    return 'edit_theme_options';
}

add_filter('option_page_capability_hook_activation_options', 'hook_activation_options_page_capability');

function hook_theme_activation_options_add_page() {
    $hook_activation_options=hook_get_theme_activation_options();
    /*$theme_page=add_theme_page(
        esc_html__('1-Click Demo Import', 'hook'),
        esc_html__('1-Click Demo Import', 'hook'),
        'edit_theme_options',
        'theme_activation_options',
        'hook_theme_activation_options_render_page'
    );*/
    $theme_page=add_submenu_page(
            null,
        '1-Click Demo Import',
        '1-Click Demo Import',
        'edit_theme_options',
        'theme_activation_options',
        'hook_theme_activation_options_render_page'
    );

}
add_action('admin_menu', 'hook_theme_activation_options_add_page', 50);

function hook_get_default_theme_activation_options() {
    $default_theme_activation_options=array(
        'generate_content'  => false,
        'bold-startup'  => '',
        'pure-business'  => '',
        'coming'  => '',
        'stylish-showcase'  => '',
        'photography-studio'  => '',
        'modern-agency'  => '',
        'creative-agency'  => '',
        'real-estate'  => '',
        'vcard-musician'  => '',
        'agency-dark'  => '',
        'agency-bright'  => '',
        'full-demo'  => '',
        'app-landing-page'  => '',
        'architecture'  => '',
        'featured-portfolio'  => '',
        'logistics'  => '',
        'alternative-portfolio'  => '',
        'event'  => '',
        'rtl'  => '',
        'pulse-agency'  => '',
        'single-product-sale'  => '',
        'vcard-business'  => '',
        'consultancy' => '',
    );
    return apply_filters('hook_default_theme_activation_options', $default_theme_activation_options);
}

function hook_get_theme_activation_options() {
    return get_option('hook_theme_activation_options', hook_get_default_theme_activation_options());
}

function hook_theme_activation_options_render_page() {
    $hook_theme=wp_get_theme();
    if (isset($_GET["prk_act_activate"])) {
        echo '<div id="prk_activate_message">';
        $remote = wp_remote_get( 'http://www.pirenko.com/licenses/wp-json/check_license/prk_core?prk_key='.$_GET["prk_act_activate"].'&prk_domain='.$_SERVER['HTTP_HOST'].'&prk_theme_id='.HOOK_PLUGIN_ID);
        if (is_wp_error($remote)) {
            echo __('Error! Unable to communicate with pirenko.com. Please try again in a few seconds.','shout');
            return;
            echo '</div>';
        }
        if ( 200 != wp_remote_retrieve_response_code($remote)) {
            echo __('Error! Invalid response from pirenko.com. Please try again in a few seconds.','shout');
            return;
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
    <div class="wrap">
    </div>
    <div id="hook_one_click">
        <?php
        if (!hook_validate_key()) {
            ?>
            <div id="lic_wrapper" class="left_floated">
                <div id="lic_left_column" class="left_floated"></div>
                <div id="lic_right_column" class="left_floated">
                    <h2 class="pirenko_import_title"><?php echo esc_attr($hook_theme->get('Name').' '.__('Theme - One-click install sample content', 'hook')); ?></h2>
                    <em>To access this feature you need to enter the theme license key.</em>
                    <form id="pirenko_verify_form" class="plugined" method="post" data-path="<?php echo $_SERVER['HTTP_HOST']; ?>" data-admin="<?php echo admin_url('themes.php?page=theme_activation_options&prk_act_activate='); ?>" data-theme="<?php echo HOOK_PLUGIN_ID; ?>">
                        <div class="pirenko_verify_purchase">
                            <div class="spinner"></div>
                            <input id="pirenko_purchase_key" type="text" name="pirenko_purchase_key" value="" /><br />
                            <input type="submit" value="<?php echo esc_attr__( 'Validate License Key', 'hook'); ?>" class="button button-primary button-large" />
                        </div>
                        <div id="pirenko_verify_form-output">
                            <p>You can purchase a <?php echo esc_attr($hook_theme->get('Name').' - '.$hook_theme->get('Description')); ?> license <a href="https://themeforest.net/cart/configure_before_adding/<?php echo HOOK_PLUGIN_ID; ?>?license=regular&ref=Pirenko&size=source&support=bundle_6month" target="_blank">here</a>.</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear bt_48"></div>
            <em>If you already have a license, please head to <a href="https://themeforest.net/downloads?ref=Pirenko" target="_blank">themeforest.net</a> and here's how to get it in 3 easy steps:</em>
            <div class="clear bt_6"></div>
            <img id="prk_license_img" src="<?php echo get_template_directory_uri(); ?>/images/license.jpg" />
            <?php
        }
        else if (HOOK_FRAMEWORK_ON==false) {
            ?>
            <div id="lic_wrapper" class="left_floated lic_fulled">
                <div id="lic_right_column" class="left_floated">
                    <em>This option is only available after installing and activating the bundled plugins. You can access the Demo Import feature later by clicking on Appearance>Demo Import.</em>
                </div>
            </div>
            <?php
        }
        else {
            ?>
            <div id="redux-header">
                <div class="display_header">
                    <h2><?php esc_html_e('Install sample content?', 'hook'); ?></h2>
                </div>
                <div class="clear"></div>
            </div>
            <form method="post" action="options.php" class="hook_one_form">
                <?php
                settings_fields('hook_activation_options');
                $hook_activation_options=hook_get_theme_activation_options();
                ?>
                <div id="hook_oc_title" class="redux-group-tab" data-rel="14" >
                    <h4>This feature will generate some pages and related content to help you creating your own custom website.<br />Portfolio Items, Blog Posts, Team Members and Testimonials will always be generated if they don't exist already.</h4>
                    <p>Please select the demos that should be generated.</p>
                </div>
                <?php submit_button('Generate Content'); ?>
                <table class="form-table no-border">
                    <tbody id="one-click-table">
                    <tr id="one-click-first" class="fold hook_page">
                        <th id="hook_toggle_row" scope="row">
                            <fieldset class="redux-field-container redux-field redux-container-checkbox">
                                <input type="checkbox" name="hook_toggle_all" id="hook_toggle_all" value="1" class="checkbox" checked="checked">
                                <label for="hook_toggle_all"><span></span></label>
                            </fieldset>
                            <div class="redux_field_th">Toggle selection</div>
                        </th>
                        <td>
                        </td>
                    </tr>
                    <?php
                    $pages_array=array(
                        'pure-business'  => 'Pure Business',
                        'stylish-showcase'  => 'Stylish Showcase - 6 pages',
                        'creative-agency'  => 'Creative Agency',
                        'photography-studio'  => 'Photography Studio',
                        'full-demo'  => 'Full Demo - 13 pages',
                        'event'  => 'Event',
                        'bold-startup'  => 'Bold Startup',
                        'architecture'  => 'Architecture',
                        'single-product-sale'  => 'Single Prodcut Sale',
                        'featured-portfolio'  => 'Featured Portfolio',
                        'modern-agency'  => 'Modern Agency',
                        'rtl'  => 'RTL Language',
                        'app-landing-page'  => 'App - Landing Page',
                        'agency-dark'  => 'Agency Dark Colors - 5 pages',
                        'alternative-portfolio'  => 'Alternative Portfolio',
                        'real-estate'  => 'Real Estate - 7 pages',
                        'logistics'  => 'Transportation & Logistics',
                        'pulse-agency'  => 'Pulse Agency',
                        'consultancy' => 'Lawyers/Consultants',
                        'agency-bright'  => 'Agency Bright Colors - 5 pages',
                        'vcard-musician'  => 'vCard - Musician',
                        'vcard-business'  => 'vCard - Business',
                        'coming'  => 'Coming Soon',
                    );
                    $links_array=array(
                        'pure-business'  => 'http://www.pirenko-themes.com/hook/business/',
                        'stylish-showcase'  => 'http://www.pirenko-themes.com/hook/agency/',
                        'creative-agency'  => 'http://www.pirenko-themes.com/hook/creative/',
                        'photography-studio'  => 'http://www.pirenko-themes.com/hook/photography/',
                        'full-demo'  => 'http://www.pirenko-themes.com/hook/fulldemo/',
                        'event'  => 'http://www.pirenko-themes.com/hook/event/',
                        'bold-startup'  => 'http://www.pirenko-themes.com/hook/startup/',
                        'architecture'  => 'http://www.pirenko-themes.com/hook/architecture/',
                        'single-product-sale'  => 'http://www.pirenko-themes.com/hook/single-product-sale/',
                        'featured-portfolio'  => 'http://www.pirenko-themes.com/hook/small-portfolio/',
                        'modern-agency'  => 'http://www.pirenko-themes.com/hook/worker/',
                        'rtl'  => 'http://www.pirenko-themes.com/hook/startup-rtl/',
                        'app-landing-page'  => 'http://www.pirenko-themes.com/hook/app/',
                        'agency-dark'  => 'http://www.pirenko-themes.com/hook/black/',
                        'alternative-portfolio'  => 'http://www.pirenko-themes.com/hook/alternative-portfolio/',
                        'real-estate'  => 'http://www.pirenko-themes.com/hook/real-state/',
                        'logistics'  => 'http://www.pirenko-themes.com/hook/logistics/',
                        'pulse-agency'  => 'http://www.pirenko-themes.com/hook/agency-dark/',
                        'consultancy' => 'http://www.pirenko-themes.com/hook/consultancy/',
                        'agency-bright'  => 'http://www.pirenko-themes.com/hook/white/',
                        'vcard-musician'  => 'http://www.pirenko-themes.com/hook/single-screen/',
                        'vcard-business'  => 'http://www.pirenko-themes.com/hook/resume/',
                        'coming'  => 'http://www.pirenko-themes.com/hook/coming-soon/',
                    );
                    $i=0;
                    foreach ($pages_array as $page=>$stringer) {
                        echo '<tr class="fold hook_page">';
                        echo '<th scope="row">';
                        echo '<fieldset class="redux-field-container redux-field redux-container-checkbox">
                      <input type="checkbox" name="hook_theme_activation_options['.$page.']" id="'.$page.'" class="checkbox hook_check" checked="checked">
                      <label for="'.$page.'"><span></span></label>
                    </fieldset>
                    <div class="redux_field_th">'.$stringer.'</div>
                    <img src="'.plugin_dir_url( __FILE__ ).'/images/demos/'.$page.'.jpg" />
                    <a class="prk_demo_link" href="'.$links_array[$page].'" target="_blank">Demo Preview &rarr;</a>
                  </th><td></td>';
                        echo '</tr>';
                        $i++;
                        if ($i%3==0) {
                            echo '<tr class="fold hook_clear"></tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>


                <?php submit_button('Generate Content'); ?><br />
            </form>
            <?php
        }
        ?>
    </div>


<?php }

function hook_theme_activation_options_validate($input) {
    $output=$defaults=hook_get_default_theme_activation_options();

    $pages_array=array(
        'bold-startup'  => '',
        'pure-business'  => '',
        'coming'  => '',
        'stylish-showcase'  => '',
        'photography-studio'  => '',
        'modern-agency'  => '',
        'creative-agency'  => '',
        'real-estate'  => '',
        'vcard-musician'  => '',
        'agency-dark'  => '',
        'agency-bright'  => '',
        'full-demo'  => '',
        'app-landing-page'  => '',
        'architecture'  => '',
        'featured-portfolio'  => '',
        'logistics'  => '',
        'alternative-portfolio' => '',
        'event'  => '',
        'rtl'  => '',
        'pulse-agency'  => '',
        'single-product-sale'  => '',
        'vcard-business'  => '',
        'consultancy' => '',
    );
    foreach ($pages_array as $page=>$value) {
        if (isset($input[$page]) && $input[$page]!="") {
            $output[$page]=$input[$page];
            $output['generate_content']=true;
        }
    }

    return apply_filters('hook_theme_activation_options_validate', $output, $input, $defaults);
}

function hook_theme_activation_action() {
    $hook_theme_activation_options=hook_get_theme_activation_options();
    if ($hook_theme_activation_options['generate_content']==true) {

        //ADD THE SAMPLE CONTENT
        //CREATE CONTENT

        //------------------------ IMPORT IMAGES ------------------------ //
        global $wpdb;
        $filename_a=get_template_directory_uri().'/images/sample/holder_a.jpg';
        $description_a='Red Cup';
        media_sideload_image($filename_a, 0, $description_a);
        $attachment_a=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
        $folio_image_1=$attachment_a['ID'];

        $filename_b=get_template_directory_uri().'/images/sample/holder_b.jpg';
        $description_b='Sun Flowers';
        media_sideload_image($filename_b, 0, $description_b);
        $attachment_b=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 2", ARRAY_A);
        $folio_image_2=$attachment_b['ID'];

        $filename_c=get_template_directory_uri().'/images/sample/holder_c.jpg';
        $description_c='Blue Bird';
        media_sideload_image($filename_c, 0, $description_c);
        $attachment_c=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 3", ARRAY_A);
        $folio_image_3=$attachment_c['ID'];

        $filename_row=get_template_directory_uri().'/images/sample/row.jpg';
        $description_row='Blue Sea';
        media_sideload_image($filename_row, 0, $description_row);
        $attachment_row=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 4", ARRAY_A);
        $row_image=$attachment_row['ID'];

        $filename_short=get_template_directory_uri().'/images/sample/holder_short.jpg';
        $description_short='Paper Writer';
        media_sideload_image($filename_short, 0, $description_short);
        $attachment_short=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 5", ARRAY_A);
        $image_short=$attachment_short['ID'];

        $filename_u=get_template_directory_uri().'/images/sample/member.jpg';
        $description_u='Girl Portrait';
        media_sideload_image($filename_u, 0, $description_u);
        $attachment_u=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 6", ARRAY_A);
        $member_image=$attachment_u['ID'];

        $filename_t=get_template_directory_uri().'/images/sample/user.png';
        $description_t='Testimonial Image';
        media_sideload_image($filename_t, 0, $description_t);
        $attachment_t=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 7", ARRAY_A);
        $monial_image=$attachment_t['ID'];

        $filename_v=get_template_directory_uri().'/images/sample/signa.png';
        $description_v='Signature';
        media_sideload_image($filename_v, 0, $description_v);
        $attachment_v=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 8", ARRAY_A);
        $signa_image=$attachment_v['ID'];

        $filename_w=get_template_directory_uri().'/images/sample/signa-white.png';
        $description_w='Signature - White';
        media_sideload_image($filename_w, 0, $description_w);
        $attachment_w=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 8", ARRAY_A);
        $signa_image_white=$attachment_w['ID'];

        $filename_x=get_template_directory_uri().'/images/sample/logo.png';
        $description_x='Logo Sample - Clear';
        media_sideload_image($filename_x, 0, $description_x);
        $attachment_x=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 9", ARRAY_A);
        $logo_image=$attachment_x['ID'];

        $filename_z=get_template_directory_uri().'/images/sample/logo-dark.png';
        $description_z='Logo Sample - Dark';
        media_sideload_image($filename_z, 0, $description_z);
        $attachment_z=$wpdb->get_row($query="SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 9", ARRAY_A);
        $logo_image_dark=$attachment_z['ID'];


        //------------------------ CUSTOM POST TYPES ------------------------//

        //ADD A DEFAULT GROUP - SLIDES
        wp_insert_term(
            'Hook Group', //TERM
            'pirenko_slide_set', //TAXONOMY
            array(
                'description'=> 'A sample slides group',
                'slug' => 'hook-group'
            )
        );
        $new_group=get_term_by('slug', 'hook-group', 'pirenko_slide_set');

        //SLIDES ITEM 1
        $new_page_title='Business Slide';
        $new_page_content='[vc_row row_height="forced_row vertical_forced_row" align="hook_right_align"][vc_column][prkwp_styled_title prk_in="We Will Make You Stronger" align="Right" font_type="body_font" font_weight="400" title_size="h5" margin_bottom="-6px" css_animation="left-to-right-faster" css_delay="500"][prkwp_styled_title prk_in="WORLDWIDE BIZ" align="Right" font_weight="600" title_size="h1" css_animation="left-to-right-faster" css_delay="650"][vc_row_inner top_padding="6px" bottom_padding="4px" css_animation="left-to-right-faster" css_delay="800"][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text el_class="zero_color"]<p style="text-align: right;">Now, by reason of this timely spinning round the boat upon its axis, its bow, by anticipation, was made to face the whales head while yet under water.</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][prk_wp_theme_button type="colored_theme_button" button_size="prk_small" prk_in="DO SOMETHING →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="left-to-right-faster" css_delay="950"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="90"][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_slides');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_slides',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-09',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $row_image);
            add_post_meta($new_page_id, 'hide_slide_text', '1');
            add_post_meta($new_page_id, 'limit_text_width', '1');
            add_post_meta($new_page_id, 'slide_text_vert', 'v_center');
            add_post_meta($new_page_id, 'slide_text_horz', 'center');
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_slide_set', false );
        }
        //SLIDES ITEM 2
        $new_page_title='Shop Slide';
        $new_page_content='[vc_row row_height="forced_row vertical_forced_row"][vc_column][prkwp_styled_title prk_in="Great Prices & Variety" align="Center" font_type="body_font" font_weight="400" text_color="#ffffff" title_size="h5" margin_bottom="-4px" css_animation="hook_fadeInDownBig"][prkwp_styled_title prk_in="SHOP ONLINE" align="Center" font_weight="600" text_color="#ffffff" title_size="h1" css_animation="hook_fadeInUpBig"][prkwp_spacer size="16"][vc_row_inner][vc_column_inner align="hook_center_align"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="ALL PRODUCTS →" link="http://www.pirenko-themes.com/hook/fulldemo/shop/" css_animation="hook_fade_waypoint" css_delay="600"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_slides');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_slides',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-08',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_3);
            add_post_meta($new_page_id, 'hide_slide_text', '1');
            add_post_meta($new_page_id, 'limit_text_width', '1');
            add_post_meta($new_page_id, 'slide_text_vert', 'v_center');
            add_post_meta($new_page_id, 'slide_text_horz', 'center');
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_slide_set', false );
        }

        //ADD A DEFAULT GROUP - TESTIMONIALS
        wp_insert_term(
            'Hook Testimonials', //TERM
            'pirenko_testimonial_set', //TAXONOMY
            array(
                'description'=> 'A sample testimonials set',
                'slug' => 'hook-testimonials'
            )
        );
        $new_group=get_term_by('slug', 'hook-testimonials', 'pirenko_testimonial_set');


        //TESTIMONIALS A
        $new_page_title='Mark Russell';
        $new_page_content='"Doubtless one leading reason why the world declines honouring us whalemen, is this: they think that, at best, our vocation amounts to a butchering sort of business. There were only four witches in all the Land of Oz, and two of them, those who live in the North and the South, are good witches."';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_testimonials');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_testimonials',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-08',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $monial_image);
            add_post_meta($new_page_id, 'testimonial_subheading', 'Awesome Client');
            add_post_meta($new_page_id, 'rating', '5');
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
        }
        //TESTIMONIALS B
        $new_page_title='Amber Washington';
        $new_page_content='"Doubtless one leading reason why the world declines honouring us whalemen, is this: they think that, at best, our vocation amounts to a butchering sort of business. There were only four witches in all the Land of Oz, and two of them, those who live in the North and the South, are good witches."';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_testimonials');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_testimonials',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-07',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $monial_image);
            add_post_meta($new_page_id, 'testimonial_subheading', 'Gorgeous Manager');
            add_post_meta($new_page_id, 'rating', '5');
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
        }
        //TESTIMONIALS C
        $new_page_title='Kurt Ratzenberger';
        $new_page_content='"Doubtless one leading reason why the world declines honouring us whalemen, is this: they think that, at best, our vocation amounts to a butchering sort of business. There were only four witches in all the Land of Oz, and two of them, those who live in the North and the South, are good witches."';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_testimonials');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_testimonials',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-06',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $monial_image);
            add_post_meta($new_page_id, 'testimonial_subheading', 'Main Entrepeneur');
            add_post_meta($new_page_id, 'rating', '5');
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
        }

        //ADD A DEFAULT SKILL - PORTFOLIO FULLSCREEN
        wp_insert_term(
            'Hook Skill', //TERM
            'pirenko_skills', //TAXONOMY
            array(
                'description'=> 'Portfolio sample skill',
                'slug' => 'hook-sample-skill'
            )
        );

        $new_skill=get_term_by('slug', 'hook-sample-skill', 'pirenko_skills');

        //PORTFOLIO ITEM - IMAGE
        $new_page_title='Split Layout';
        $new_page_content='[vc_row][vc_column width="1/1"][vc_column_text]The way led along upon what had once been the embankment of a railroad. But no train had run upon it for many years. The forest on either side swelled up the slopes of the embankment and crested across it in a green wave of trees and bushes. The trail was as narrow as a man’s body, and was no more than a wild-animal runway. Occasionally, a piece of rusty iron, showing through the forest-mould, advertised that the rail and the ties still remained. In one place, a ten-inch tree, bursting through at a connection, had lifted the end of a rail clearly into view.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-06',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_1);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'custom_width', 'hook_hz_two');
            add_post_meta($new_page_id, 'orientation', 'landscape');
            add_post_meta($new_page_id, 'inner_layout', 'half');
            add_post_meta($new_page_id, 'info_display', 'right_side');
            add_post_meta($new_page_id, 'featured_color', '#c62f2f');
            add_post_meta($new_page_id, 'client_url', 'Time Stoppers Inc.');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }

        //PORTFOLIO ITEM - VIDEO
        $new_page_title='Split Layout with Video';
        $new_page_content='[vc_row][vc_column width="1/1"][vc_column_text]The way led along upon what had once been the embankment of a railroad. But no train had run upon it for many years. The forest on either side swelled up the slopes of the embankment and crested across it in a green wave of trees and bushes. The trail was as narrow as a man’s body, and was no more than a wild-animal runway. Occasionally, a piece of rusty iron, showing through the forest-mould, advertised that the rail and the ties still remained. In one place, a ten-inch tree, bursting through at a connection, had lifted the end of a rail clearly into view.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-05',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_2);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'inner_layout', 'half');
            add_post_meta($new_page_id, 'skip_featured', '1');
            add_post_meta($new_page_id, 'position_2_use_video', 'video');
            add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
            add_post_meta($new_page_id, 'featured_color', '#f9c401');
            add_post_meta($new_page_id, 'client_url', 'Time Stoppers Inc.');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }

        //PORTFOLIO ITEM - WIDE
        $new_page_title='Wide Layout';
        $new_page_content='[vc_row][vc_column width="1/1"][vc_column_text]The way led along upon what had once been the embankment of a railroad. But no train had run upon it for many years. The forest on either side swelled up the slopes of the embankment and crested across it in a green wave of trees and bushes. The trail was as narrow as a mans body, and was no more than a wild-animal runway. Occasionally, a piece of rusty iron, showing through the forest-mould, advertised that the rail and the ties still remained. In one place, a ten-inch tree, bursting through at a connection, had lifted the end of a rail clearly into view.[/vc_column_text][bquote prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whales afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer][vc_column_text]An old man and a boy travelled along this runway. They moved slowly, for the old man was very old, a touch of palsy made his movements tremulous, and he leaned heavily upon his staff. A rude skull-cap of goat-skin protected his head from the sun. From beneath this fell a scant fringe of stained and dirty-white hair. A visor, ingeniously made from a large leaf, shielded his eyes, and from under this he peered at the way of his feet on the trail. His beard, which should have been snow-white but which showed the same weather-wear.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-04',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $image_short);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'featured_color', '#1770d7');
            add_post_meta($new_page_id, 'inner_layout', 'wideout');
            add_post_meta($new_page_id, 'info_display', 'right_side');
            add_post_meta($new_page_id, 'client_url', 'Time Stoppers Inc.');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }

        //PORTFOLIO ITEM - WIDE
        $new_page_title='Wide Layout - Boxed';
        $new_page_content='[vc_row][vc_column width="1/1"][vc_column_text]The way led along upon what had once been the embankment of a railroad. But no train had run upon it for many years. The forest on either side swelled up the slopes of the embankment and crested across it in a green wave of trees and bushes. The trail was as narrow as a mans body, and was no more than a wild-animal runway. Occasionally, a piece of rusty iron, showing through the forest-mould, advertised that the rail and the ties still remained. In one place, a ten-inch tree, bursting through at a connection, had lifted the end of a rail clearly into view.[/vc_column_text][bquote prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whales afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer][vc_column_text]An old man and a boy travelled along this runway. They moved slowly, for the old man was very old, a touch of palsy made his movements tremulous, and he leaned heavily upon his staff. A rude skull-cap of goat-skin protected his head from the sun. From beneath this fell a scant fringe of stained and dirty-white hair. A visor, ingeniously made from a large leaf, shielded his eyes, and from under this he peered at the way of his feet on the trail. His beard, which should have been snow-white but which showed the same weather-wear.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-03',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_1);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'featured_color', '#c62f2f');
            add_post_meta($new_page_id, 'inner_layout', 'wide');
            add_post_meta($new_page_id, 'info_display', 'below');
            add_post_meta($new_page_id, 'image_2', $image_short);
            add_post_meta($new_page_id, 'client_url', 'Time Stoppers Inc.');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }

        //PORTFOLIO ITEM - WIDE LAYOUT II
        $new_page_title='Wide Layout With Video';
        $new_page_content='[vc_row top_padding="60px"][vc_column width="1/1"][vc_row_inner bottom_padding="40px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text drop_cap="yes"]Nor does this - its amazing strength, at all tend to cripple the graceful flexion of its motions; where infantileness of ease undulates through a Titanism of power. On the contrary, those motions derive their most appalling beauty from it. Real strength never impairs beauty or harmony, but it often bestows it; and in everything imposingly beautiful, strength has much to do with the magic. Take away the tied tendons that all over seem bursting from the marble in the carved Hercules, and its charm would be gone. As devout Eckerman lifted the linen sheet from the naked corpse of Goethe, he was overwhelmed with the massive chest of the man, that seemed as a Roman triumphal arch. When Angelo paints even God the Father in human form, mark what robustness is there. And whatever they may reveal of the divine love in the Son, the soft, curled, hermaphroditical Italian pictures, in which his idea has been most successfully embodied; these pictures, so destitute as they are of all brawniness, hint nothing of any power, but the mere negative, feminine one of submission and endurance, which on all hands it is conceded, form the peculiar practical virtues of his teachings.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner bottom_padding="60px"][vc_column_inner width="5/6"][vc_single_image image="'.$folio_image_1.'" img_size="full" alignment="center"][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text el_class="prk_9_em"]<em>But as if this vast local power in the tendinous tail were not enough, the whole bulk of the leviathan is knit.</em>[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner bottom_padding="40px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]Nor does this - its amazing strength, at all tend to cripple the graceful flexion of its motions; where infantileness of ease undulates through a Titanism of power. On the contrary, those motions derive their most appalling beauty from it. Real strength never impairs beauty or harmony, but it often bestows it; and in everything imposingly beautiful, strength has much to do with the magic. Take away the tied tendons that all over seem bursting from the marble in the carved Hercules, and its charm would be gone. As devout Eckerman lifted the linen sheet from the naked corpse of Goethe, he was overwhelmed with the massive chest of the man, that seemed as a Roman triumphal arch. When Angelo paints even God the Father in human form, mark what robustness is there. And whatever they may reveal of the divine love in the Son, the soft, curled, hermaphroditical Italian pictures, in which his idea has been most successfully embodied; these pictures, so destitute as they are of all brawniness, hint nothing of any power, but the mere negative, feminine one of submission and endurance, which on all hands it is conceded, form the peculiar practical virtues of his teachings.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner bottom_padding="60px"][vc_column_inner width="1/6"][vc_column_text el_class="prk_9_em"]<p style="text-align: right"><em>But as if this vast local power in the tendinous tail were not enough, the whole bulk of the leviathan is knit.</em></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="5/6"][vc_single_image image="'.$folio_image_2.'" img_size="full" alignment="center"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][bquote prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion." border_color="#fc6e51"][prkwp_spacer][vc_column_text]Nor does this - its amazing strength, at all tend to cripple the graceful flexion of its motions; where infantileness of ease undulates through a Titanism of power. On the contrary, those motions derive their most appalling beauty from it. Real strength never impairs beauty or harmony, but it often bestows it; and in everything imposingly beautiful, strength has much to do with the magic. Take away the tied tendons that all over seem bursting from the marble in the carved Hercules, and its charm would be gone. As devout Eckerman lifted the linen sheet from the naked corpse of Goethe, he was overwhelmed with the massive chest of the man, that seemed as a Roman triumphal arch. When Angelo paints even God the Father in human form, mark what robustness is there. And whatever they may reveal of the divine love in the Son, the soft, curled, hermaphroditical Italian pictures, in which his idea has been most successfully embodied; these pictures, so destitute as they are of all brawniness, hint nothing of any power, but the mere negative, feminine one of submission and endurance, which on all hands it is conceded, form the peculiar practical virtues of his teachings.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-02',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_2);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'skip_featured', '1');
            add_post_meta($new_page_id, 'inner_layout', 'wideout');
            add_post_meta($new_page_id, 'position_2_use_video', 'video');
            add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
            add_post_meta($new_page_id, 'featured_color', '#f9c401');
            add_post_meta($new_page_id, 'client_url', 'Company ABC');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }


        //PORTFOLIO ITEM - CUSTOM LAYOUT
        $new_page_title='Custom layout';
        $new_page_content='[vc_row row_height="forced_row bottom_forced_row" font_color="#3a6474" bk_element="image" bg_image_repeat="hook_with_parallax" append_arrow="yes" el_class="ultra_lax" bg_image="'.$row_image.'"][vc_column width="1/1"][/vc_column][/vc_row][vc_row top_padding="72px" bottom_padding="72px" el_class="vc_row"][vc_column width="1/2"][prkwp_styled_title prk_in="ABOUT THE PROJECT" font_weight="600" title_size="h3" margin_bottom="12px" seven_show_line="no"][vc_column_text]A little may as well be related here. The <strong>strongest and most reliable</strong> hold which the ship has upon the whale when moored alongside, is by the flukes or tail; and as from its greater density that part is relatively heavier than any other person around here.And so it was indeed: she was now only ten inches high, and <strong>her face brightened up</strong> at the thought that she was now the right size for going through the little door into that lovely garden. First, however, she waited for a few minutes to get inside.If she was going to shrink any further: she felt a little nervous about this; for it might end, you know, said Alice to herself, in my going out altogether, like a candle. I wonder what I should be like then? And she tried to fancy what <strong>the flame of a candle</strong> is like after the candle is blown out, for she could not remember ever having seen such a thing.[/vc_column_text][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="WHAT AMAZED US" font_weight="600" title_size="h3" margin_bottom="12px" seven_show_line="no"][vc_column_text]She ate a little bit, and said anxiously to herself, <strong>holding her hand</strong> on the top of her head to feel which way it was growing, and she was quite surprised to find that she remained the same size: to be sure, this generally happens when one eats cake more oftenThe strongest and most reliable hold which the ship has upon the whale when moored alongside, is by the flukes or tail; and as from <strong>its greater density</strong> that part is relatively heavier than any other person around here. And she tried to stay inside.<strong>My first concern</strong> was with Perry. I was horrified at the thought that upon the very threshold of salvation he might be dead. Tearing open his shirt I placed my ear to his breast. I could have cried with relief—his heart was beating quite regularly once again.[/vc_column_text][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="92px" bk_element="image" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SOME FUN FACTS" align="Center" font_weight="600" text_color="#ffffff" title_size="h2" seven_show_line="no"][vc_column_text el_class="header_font"]<p style="text-align: center;"><span style="color: #ffffff;">I say this continual smoking must have been one cause, at least, of his peculiar disposition for every one.</span><span style="color: #ffffff;"> Whether ashore or afloat, is terribly infected with the nameless misteries.</span></p>[/vc_column_text][prkwp_spacer size="48"][vc_row_inner font_color="#ffffff"][vc_column_inner width="1/4"][prkwp_counter counter_number="3714" prk_in="Miles Ran" icon_material="mdi-car-wash"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="168" prk_in="Pictures Taken" icon_material="mdi-camera"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="4298" prk_in="People Reached" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="1274" prk_in="Meals Eaten" icon_material="mdi-food"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="90px" bk_element="image"][vc_column width="1/1"][prkwp_styled_title prk_in="AN ENJOYABLE EVENING" align="Center" font_weight="600" title_size="h2" seven_show_line="no"][vc_column_text el_class="header_font zero_color"]<p style="text-align: center;">The scenery was absolutely breathtaking and we had the time of our lives.</p>[/vc_column_text][prkwp_spacer][pirenko_gallery cols_number="iso_thirds" thumbs_mg="16" images="'.$folio_image_1.','.$folio_image_2.','.$folio_image_3.','.$row_image.'"][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_portfolios');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_portfolios',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-01',
                'post_status' => 'publish',
                'comment_status' => 'closed',
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_3);
            wp_publish_post($new_page_id);
            add_post_meta($new_page_id, 'inner_layout', 'custom');
            add_post_meta($new_page_id, 'custom_width', 'hook_hz_two');
            add_post_meta($new_page_id, 'orientation', 'landscape');
            add_post_meta($new_page_id, 'featured_color', '#1770d7');
            add_post_meta($new_page_id, 'client_url', 'Company ABC');
            add_post_meta($new_page_id, 'ext_url', 'https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko');
            wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
        }

        //------------------------ POSTS ------------------------//

        //ADD A DEFAULT CATEGORY - BLOG
        wp_create_category('Hook Category');
        $new_category=get_category_by_slug('hook-category');


        //BLOG ITEM - FEATURED HEADER
        $new_page_title='Featured Header';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope. Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-09',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $image_short);
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'featured');
            add_post_meta($new_page_id,'featured_color', '#c62f2f');
            add_post_meta($new_page_id,'bl_icon', 'hook_fa-bullhorn');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }

        //BLOG ITEM - FEATURED HEADER & SIDEBAR
        $new_page_title='Featured Header - Sidebar ON';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope. Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-08',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $image_short);
            add_post_meta($new_page_id,'show_sidebar', 'yes');
            add_post_meta($new_page_id,'featured_header', 'featured');
            add_post_meta($new_page_id,'show_title', 'no');
            add_post_meta($new_page_id,'featured_color', '#f9c401');
            add_post_meta($new_page_id,'bl_icon', 'hook_fa-bullhorn');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }

        //BLOG ITEM - BIG HEADER
        $new_page_title='Big Header';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope.Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.<br />Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-07',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $row_image);
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'featured_100');
            add_post_meta($new_page_id,'featured_color', '#c62f2f');
            add_post_meta($new_page_id,'bl_icon', 'hook_fa-bullhorn');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }

        //BLOG ITEM - DEFAULT HEADER
        $new_page_title='Default Header';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.<br />In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope.<br />Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.<br />Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-06',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            set_post_thumbnail($new_page_id, $folio_image_3);
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'default');
            add_post_meta($new_page_id,'featured_color', '#1770d7');
            add_post_meta($new_page_id,'bl_icon', 'hook_fa-bullhorn');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }


        //BLOG ITEM - VIDEO
        $new_page_title='Post With Video';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.<br />In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope.<br />Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.<br />Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-05',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'skip_featured', '1');
            add_post_meta($new_page_id, 'bl_icon', 'hook_fa-bullhorn');
            add_post_meta($new_page_id, 'featured_color', '#8e44ad');
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'default');
            add_post_meta($new_page_id, 'position_2_use_video', 'video');
            add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }


        //BLOG ITEM - AUDIO
        $new_page_title='Post With Audio';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.<br />In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope.<br />Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.<br />Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-04',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'skip_featured', '1');
            add_post_meta($new_page_id, 'bl_icon', 'hook_fa-bullhorn');
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'default');
            add_post_meta($new_page_id, 'featured_color', '#e67e22');
            add_post_meta($new_page_id, 'position_2_use_video', 'video');
            add_post_meta($new_page_id, 'video_2', '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F58223409"></iframe>');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }

        //BLOG ITEM - NO MEDIA
        $new_page_title='Post Without Media';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.<br />In the first place, <strong>the enormous cutting tackles</strong>, among other ponderous things comprising a cluster of blocks generally painted green, and which no single man can possibly lift—this vast bunch of grapes was swayed up to the main-top and firmly lashed to the lower mast-head, the strongest point anywhere above a ships deck. The end of the hawser-like rope.<br />Suspended in stages over the side, <strong>Starbuck and Stubb</strong>, the mates, armed with their long spades, began cutting a hole in the body for the insertion of the hook just above the nearest of the two side-fins. This done, a broad, semicircular line is cut round the hole, the hook is inserted, and the main body of the crew striking up a wild chorus, now commence heaving in one dense crowd.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.<br />Alice laughed so much at this, that she had to run back into the wood for fear of their hearing her; and when she next peeped out <strong>the Fish-Footman was gone</strong>, and the other was sitting on the ground near the door, staring stupidly up into the sky.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'post');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'post',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_date' => '2016-09-03',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'bl_icon', 'hook_fa-bullhorn');
            add_post_meta($new_page_id,'show_sidebar', 'no');
            add_post_meta($new_page_id,'featured_header', 'default');
            add_post_meta($new_page_id, 'featured_color', '#0ab6d1');
            wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
        }

        //ADD A DEFAULT TEAM - TEAM MEMBERS
        wp_insert_term(
            'Hook Team', //TERM
            'pirenko_member_group', //TAXONOMY
            array(
                'description'=> 'A sample team',
                'slug' => 'hook-team'
            )
        );
        $new_group=get_term_by('slug', 'hook-team', 'pirenko_member_group');


        //MEMBERS - MEMBER A
        $new_page_title='Jane Doe';
        $new_page_content='[vc_row][vc_column width="1/1"][vc_column_text drop_cap="no"]<strong>Yesterday there seemed</strong> to be no possibility of getting her hands specially after her head, she attempted yesterday getting her head down to them, and was delighted to find that her neck would bend about easily in any direction, like a serpent.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in=" It cannot well be doubted, that the one visible quality in the aspect of the dead which most appals the gazer, is the marble pallor lingering there; as if indeed that pallor were as much like the badge of consternation in the other world, as of mortal trepidation here."][prkwp_spacer size="18"][vc_column_text]Nor, in some things, does the common, <strong>hereditary experience of all mankind</strong> fail to bear witness to the supernaturalism of this hue. It cannot well be doubted, that the one visible quality in the aspect of the dead which most appeals the gazer.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_team_member');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_team_member',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_excerpt' => 'Operations Manager',
                'post_date' => '2016-09-08',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'member_byline', 'Systems Expert');
            add_post_meta($new_page_id, 'member_layout', 'divided');
            add_post_meta($new_page_id, 'member_social_1', 'none');
            add_post_meta($new_page_id, 'member_social_2', 'none');
            add_post_meta($new_page_id, 'member_social_3', 'none');
            add_post_meta($new_page_id, 'member_social_4', 'none');
            add_post_meta($new_page_id, 'member_social_5', 'none');
            add_post_meta($new_page_id, 'member_social_6', 'none');
            add_post_meta($new_page_id, 'member_job', 'Operations Manager');
            add_post_meta($new_page_id, 'member_email', 'john@hook.com');
            add_post_meta($new_page_id, 'show_member_link', '1');
            add_post_meta($new_page_id, 'show_member_image', '1');
            add_post_meta($new_page_id, 'image_2', $member_image);
            set_post_thumbnail($new_page_id, $member_image);
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
        }


        //MEMBERS - MEMBER B
        $new_page_title='Jackie May';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_team_member');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_team_member',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_excerpt' => 'Creative Director',
                'post_date' => '2016-09-07',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'member_layout', 'regular');
            add_post_meta($new_page_id, 'member_social_1', 'none');
            add_post_meta($new_page_id, 'member_social_2', 'none');
            add_post_meta($new_page_id, 'member_social_3', 'none');
            add_post_meta($new_page_id, 'member_social_4', 'none');
            add_post_meta($new_page_id, 'member_social_5', 'none');
            add_post_meta($new_page_id, 'member_social_6', 'none');
            add_post_meta($new_page_id, 'member_job', 'Creative Director');
            add_post_meta($new_page_id, 'member_email', 'jane@hook.com');
            add_post_meta($new_page_id, 'show_member_link', '1');
            add_post_meta($new_page_id, 'show_member_image', '1');
            add_post_meta($new_page_id, 'image_2', $member_image);
            set_post_thumbnail($new_page_id, $member_image);
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
        }


        //MEMBERS - MEMBER C
        $new_page_title='Mary Ferrel';
        $new_page_content='[vc_row][vc_column][vc_column_text]<strong>It was a Saturday night</strong>, and such a Sabbath as followed! Ex officio professors of Sabbath breaking are all whalemen. The ivory Pequod was turned into what seemed a shamble; every sailor a butcher. You would have thought we were offering up ten thousand red oxen.[/vc_column_text][prkwp_spacer size="18"][bquote type="plain" prk_in="I have given no small attention to that not unvexed subject, the skin of the whale. I have had controversies about it with experienced whalemen afloat, and learned naturalists ashore. My original opinion remains unchanged; but it is only an opinion."][prkwp_spacer size="18"][vc_column_text]For the strain constantly kept up by the windlass continually keeps the <strong>whale rolling over</strong> and over in the water, and as the blubber in one strip uniformly peels off along the line called the "scarf," simultaneously cut by the spades of Starbuck and Stubb, the mates; and just as fast as it is thus peeled off, and indeed by that very act itself.<br /><strong>The men at the windlass</strong> then cease heaving, and for a moment or two the prodigious blood-dripping mass sways to and fro as if let down from the sky, and every one present must take good heed to dodge it when it swings, else it may box his ears and pitch him again.[/vc_column_text][/vc_column][/vc_row]';
        $page_check=get_page_by_title($new_page_title, '', 'pirenko_team_member');
        if(!isset($page_check->ID)){
            $new_page=array(
                'post_type' => 'pirenko_team_member',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_excerpt' => 'Business Analyst',
                'post_date' => '2016-09-06',
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'member_layout', 'big_image');
            add_post_meta($new_page_id, 'member_social_1', 'none');
            add_post_meta($new_page_id, 'member_social_2', 'none');
            add_post_meta($new_page_id, 'member_social_3', 'none');
            add_post_meta($new_page_id, 'member_social_4', 'none');
            add_post_meta($new_page_id, 'member_social_5', 'none');
            add_post_meta($new_page_id, 'member_social_6', 'none');
            add_post_meta($new_page_id, 'member_job', 'Business Analyst');
            add_post_meta($new_page_id, 'member_email', 'jane@hook.com');
            add_post_meta($new_page_id, 'show_member_link', '1');
            add_post_meta($new_page_id, 'show_member_image', '1');
            add_post_meta($new_page_id, 'image_2', $member_image);
            set_post_thumbnail($new_page_id, $member_image);
            wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
        }

        //------------------------ PAGES ------------------------//

        if (isset($hook_theme_activation_options['vcard-business']) && $hook_theme_activation_options['vcard-business']!="") {
            $hook_theme_activation_options['vcard-business']="";
            $new_page_title='vCard - Business';
            $new_page_content='[vc_row bk_type="hook_full_row" bk_element="image" bg_image_repeat="hook_fixed_bk" bg_image="'.$row_image.'"][vc_column width="1/2"][/vc_column][vc_column col_width="80" width="1/2"][prkwp_spacer size="180"][prkwp_styled_title prk_in="Patrick Miller" font_weight="800" text_color="#0c3038" title_size="h1" css_animation="hook_fade_waypoint" custom_css="margin-left:-6px;"][prkwp_styled_title prk_in="Consultancy Specialist" font_weight="600" text_color="#0c3038" title_size="h4" margin_bottom="21px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" custom_css="font-size: 1.2em;line-height: 26px;"]Should you ever be athirst in the great American desert, try this experiment, if your caravan happen to be supplied with a metaphysical professor. Yes, as every one knows, meditation and water are wedded forever.[/vc_column_text][prkwp_spacer size="130"][prk_line width="40px" height="4px" css_animation="top-to-bottom-faster"][prkwp_spacer size="12"][prkwp_styled_title prk_in="BIG LIFE, SHORT STORY" font_weight="700" title_size="h5" margin_bottom="6px" css_animation="bottom-to-top-faster"][vc_column_text css_animation="bottom-to-top-faster"]Once more. Say you are in the country; in some high land of lakes. Take almost any path you please, and ten to one it carries you down in a dale, and leaves you there by a pool in the stream. There is magic in it. Let the most absent-minded of men be plunged in his deepest reveries—stand that man on his legs, set his feet a-going, and he will infallibly lead you to water, if water there be in all that region. Should you ever be athirst in the great American desert, try this experiment, if your caravan happen to be supplied with a metaphysical professor. Yes, as every one knows, meditation and water.[/vc_column_text][prkwp_spacer size="130"][prk_line width="40px" height="4px" css_animation="top-to-bottom-faster"][prkwp_spacer size="12"][prkwp_styled_title prk_in="CONSULTANCY SERVICES" font_weight="700" title_size="h5" margin_bottom="6px" css_animation="bottom-to-top-faster"][vc_column_text css_animation="bottom-to-top-faster"]These reflections just here are occasioned by the circumstance that after we were all seated at the table, and I was preparing to hear some good stories about whaling; to my no small surprise, nearly every man maintained a profound beauty.[/vc_column_text][prkwp_spacer size="-7"][vc_progress_bar values="%5B%7B%22label%22%3A%22DATA%20ANALYSIS%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230c3038%22%7D%2C%7B%22label%22%3A%22MARKETING%20STRATEGIES%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230c3038%22%7D%2C%7B%22label%22%3A%22INTERNATIONAL%20TRADING%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230c3038%22%7D%2C%7B%22label%22%3A%22NETWORK%20POLICIES%22%2C%22value%22%3A%2285%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230c3038%22%7D%5D" margin_bottom_barra="48px" css_animation="hook_fade_waypoint" custombgcolor_back="#e0e0e0" units="%"][prkwp_spacer size="130"][prk_line width="40px" height="4px" css_animation="top-to-bottom-faster"][prkwp_spacer size="12"][prkwp_styled_title prk_in="PROFESSIONAL EXPERIENCE" font_weight="700" title_size="h5" margin_bottom="6px" css_animation="bottom-to-top-faster"][vc_column_text css_animation="bottom-to-top-faster"]These reflections just here are occasioned by the circumstance that after we were all seated at the table, and I was preparing to hear some good stories about whaling; to my no small surprise, nearly every man maintained a profound beauty.[/vc_column_text][prkwp_board cols_width="24%|52%|24%" board_header="DATE|JOB|COMPANY" values="2016 - 2017|General Manager|Oil Industry,2013 - 2016|Global Strategy Guru|Blue Stocks,2009 - 2013|Professional Marketeer|Go Branding,2008 - 2009|Junior Consultant|Big Markets" css_animation="hook_fade_waypoint"][prkwp_spacer size="130"][prk_line width="40px" height="4px" css_animation="top-to-bottom-faster"][prkwp_spacer size="12"][prkwp_styled_title prk_in="LETS GET TOGETHER" font_weight="700" title_size="h5" margin_bottom="6px" css_animation="bottom-to-top-faster"][vc_column_text css_animation="bottom-to-top-faster"]These reflections just here are occasioned by the circumstance that after we were all seated at the table, and I was preparing to hear some good stories about whaling; to my no small surprise, nearly every man maintained a profound beauty.<br />&nbsp;<br /><a class="body_colored prk_heavier_600" href="mailto:patrick.miller@hook.com">patrick.miller@hook.com →</a>[/vc_column_text][prkwp_spacer size="-10"][pirenko_social_nets icons_size="18" icons_padding="2" text_color="#0c3038" net_1="facebook" net_2="twitter" net_4="dribbble" net_5="instagram" net_6="xing" css_animation="bottom-to-top-faster" link_1="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" link_2="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" link_4="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" link_5="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" link_6="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][prkwp_spacer size="260"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

        }

        if (isset($hook_theme_activation_options['vcard-musician']) && $hook_theme_activation_options['vcard-musician']!="") {
            $hook_theme_activation_options['vcard-musician']="";
            $new_page_title='vCard - Musician';
            $new_page_content='[vc_row bk_type="hook_full_row" row_height="forced_row bottom_forced_row" bottom_padding="28px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover_top" align="hook_right_align" bg_image="'.$row_image.'"][vc_column align="hook_left_align" column_height="hook_forced_clm bottom_forced_clm" width="1/1"][vc_row_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="1/3" align="hook_right_align"][prkwp_styled_title prk_in="John Malcom" align="Right" font_type="body_font" font_weight="600" title_size="h1" text_color="#ffffff"][vc_column_text el_class="header_font"]<h4 style="text-align: right;"><span style="color: #ffffff;">FREE SPIRIT &amp; MUSICIAN</span></h4>[/vc_column_text][prkwp_spacer size="14"][vc_column_text]<p style="text-align: right;">Besides his hoisted boats, an American whaler is outwardly distinguished by his try-works. He presents the curious anomaly of the most solid masonry joining with oak and hemp in constituting the completed ship.</p>[/vc_column_text][prkwp_spacer][prk_line color="rgba(255,255,255,0.23)"][prkwp_spacer size="4"][vc_column_text el_class="prk_9_em"]<a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Pinterest</a> | <a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Facebook</a> | <a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Twitter</a> | <a style="color: #ffffff;" href="mailto:jm@hook.com">jm@hook.com →</a>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

        }

        if (isset($hook_theme_activation_options['coming']) && $hook_theme_activation_options['coming']!="") {
            $hook_theme_activation_options['coming']="";
            $new_page_title='Coming Soon';
            $new_page_content='[vc_row margin_bottom="18px" font_color="#ffffff" el_class="hook_retina"][vc_column width="1/1"][prkwp_spacer size="-54"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center"][prkwp_spacer size="-14"][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]<p style="text-align: center;">We are working in something new and we will be back soon.<br />Thank you for your patience.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-coming-soon.php");

            //PAGES
            add_post_meta($new_page_id, 'image_back', $row_image);
            add_post_meta($new_page_id, 'text_color', '#FFFFFF');
            add_post_meta($new_page_id, 'launch_date', '20200926');

        }


        if (isset($hook_theme_activation_options['logistics']) && $hook_theme_activation_options['logistics']!="") {
            $hook_theme_activation_options['logistics']="";
            $new_page_title='Logistics & Transportation';
            $new_page_content='[vc_row bk_type="hook_full_row" row_height="forced_row bottom_forced_row" bk_element="image" vid_parallax="yes" bk_overlay="vertical-line.png" append_arrow="yes" el_id="log_header" append_arrow_color="#ffffff" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Worldwide Logistics Operator" align="Center" font_type="body_font" font_weight="400" text_color="#ffffff" title_size="h4" margin_bottom="-4px"][prkwp_spacer size="14" el_class="show_much_later"][prk_wptext_rotator title_size="h1" text_color="#ffffff" effect="rotate-1" prk_in="EXPRESS DELIVERIES+SUPERB SUPPORT+AWARDED COMPANY" el_class="prk_heavier_700"][prkwp_spacer size="74"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" el_id="about-us"][vc_column width="1/2"][vc_single_image image="'.$folio_image_1.'" img_size="full" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/2"][prkwp_spacer size="36" hide_with_css="show_later"][prkwp_styled_title prk_in="WELCOME TO HOOK!" font_weight="700" title_size="h3" margin_bottom="24px" hook_show_line="above thick" line_color="#f9df1e" width="50px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint"]The more I dive into this matter of whaling, and push my researches up to the very spring-head of it so much the more am I impressed with its great honourableness and antiquity and especially when I find so many great demi-gods and heroes, prophets of all sorts or truly beautiful things to be seen.<br />Who one way or other have shed distinction upon it, I am transported with the reflection that I myself belong, though but subordinately, to so emblazoned a fraternity. Often and often, though this narrative must not be clogged by the details, was Granser tale interrupted while the boys squabbled.<br />But the pretty milkmaid was much too vexed to make any answer. She picked up the leg sulkily and led her cow away, the poor animal limping on three legs. As she left them the milkmaid cast many reproachful glances over her shoulder at the clumsy strangers holding her among themselves.[/vc_column_text][prkwp_spacer][vc_single_image image="'.$signa_image.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="80px" bg_color="#f1f4f8"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/3"][vc_single_image image="'.$folio_image_2.'" img_size="full" custom_css="margin-bottom:22px;"][prkwp_styled_title prk_in="Worldwide Presence" font_weight="600" title_size="h4" margin_bottom="6px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="600" width="1/3"][prkwp_spacer size="36" hide_with_css="show_later"][vc_single_image image="'.$folio_image_3.'" img_size="full" custom_css="margin-bottom:22px;"][prkwp_styled_title prk_in="We Do The Paperwork" font_weight="600" title_size="h4" margin_bottom="6px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="1100" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="1" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Start Now" tab_id="1474556120842-149a6748-c761"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT FEEDBACK" align="Center" font_weight="700" text_color="#ffffff" title_size="h2" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;"><span style="color: #ffffff;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prk_testimonials category="" size=" hook_bigger" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="72px" bottom_padding="100px" el_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR SERVICES" align="Center" font_weight="700" title_size="h2" margin_bottom="8px" hook_show_line="above thicker" line_color="#f9df1e" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner bottom_padding="64px"][vc_column_inner width="1/4"][prkwp_service name="Live Support" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" el_class="hook_lower_svg"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Express Deliveries" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="200"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Exclusive Deals" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="400"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Fingerprint Sensors" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="600"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Environmental Care" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="50"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Detailed Reports" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="250"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Security Systems" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="450"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Online Tracking" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="650"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" bg_color="#f1f4f8"][vc_column col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column align="hook_center_align" col_width="75" css_animation="hook_fade_waypoint" width="5/12"][prkwp_spacer size="148" hide_with_css="hide_later"][prkwp_spacer size="30" hide_with_css="show_later"][prkwp_styled_title prk_in="BY AIR" align="Center" font_weight="700" title_size="h2" margin_bottom="6px"][prkwp_styled_title prk_in="Fast &amp; Accurate Deliveries" align="Center" font_type="body_font" font_weight="400" text_color="#4e78a1" title_size="h5" hook_show_line="thick" line_color="#f9df1e"][vc_column_text custom_css="margin-bottom:26px;"]<p style="text-align: center;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchase for the win.</p>[/vc_column_text][prkwp_spacer size="10"][prk_wp_theme_button button_size="prk_small" prk_in="LEARN MORE →" link="http://www.pirenko-themes.com/hook/logistics/#pricing"][prkwp_spacer size="30" hide_with_css="show_later"][prkwp_spacer size="148" hide_with_css="hide_later"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="hide_later" bg_color="#f1f4f8"][vc_column align="hook_center_align" col_width="75" css_animation="hook_fade_waypoint" width="5/12"][prkwp_spacer size="148"][prkwp_styled_title prk_in="BY LAND" align="Center" font_weight="700" title_size="h2" margin_bottom="6px"][prkwp_styled_title prk_in="Fully Capable &amp; Fast" align="Center" font_type="body_font" font_weight="400" text_color="#4e78a1" title_size="h5" hook_show_line="thick" line_color="#f9df1e"][vc_column_text custom_css="margin-bottom:26px;"]<p style="text-align: center;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchase for the win.</p>[/vc_column_text][prkwp_spacer size="10"][prk_wp_theme_button button_size="prk_small" prk_in="LEARN MORE →" link="http://www.pirenko-themes.com/hook/logistics/#pricing"][prkwp_spacer size="148"][/vc_column][vc_column bg_image_hz_align="hook_hz_left" bg_image_vt_align="hook_vt_top" col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="show_later" bg_color="#f1f4f8"][vc_column bg_image_hz_align="hook_hz_left" bg_image_vt_align="hook_vt_top" col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column align="hook_center_align" col_width="75" css_animation="hook_fade_waypoint" width="5/12"][prkwp_spacer size="30" hide_with_css="show_later"][prkwp_styled_title prk_in="BY LAND" align="Center" font_weight="700" title_size="h2" margin_bottom="6px"][prkwp_styled_title prk_in="Fully Capable &amp; Fast" align="Center" font_type="body_font" font_weight="400" text_color="#4e78a1" title_size="h5" hook_show_line="thick" line_color="#f9df1e"][vc_column_text custom_css="margin-bottom:26px;"]<p style="text-align: center;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchase for the win.</p>[/vc_column_text][prkwp_spacer size="10"][prk_wp_theme_button button_size="prk_small" prk_in="LEARN MORE →" link="http://www.pirenko-themes.com/hook/logistics/#pricing"][prkwp_spacer size="30" hide_with_css="show_later"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" bg_color="#f1f4f8"][vc_column bg_image_hz_align="hook_hz_right" col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column align="hook_center_align" col_width="75" css_animation="hook_fade_waypoint" width="5/12"][prkwp_spacer size="148" hide_with_css="hide_later"][prkwp_spacer size="30" hide_with_css="show_later"][prkwp_styled_title prk_in="BY SEA" align="Center" font_weight="700" title_size="h2" margin_bottom="6px"][prkwp_styled_title prk_in="Affordable &amp; Long Distance" align="Center" font_type="body_font" font_weight="400" text_color="#4e78a1" title_size="h5" hook_show_line="thick" line_color="#f9df1e"][vc_column_text custom_css="margin-bottom:26px;"]<p style="text-align: center;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchase for the win.</p>[/vc_column_text][prkwp_spacer size="10"][prk_wp_theme_button button_size="prk_small" prk_in="LEARN MORE →" link="http://www.pirenko-themes.com/hook/logistics/#pricing"][prkwp_spacer size="30" hide_with_css="show_later"][prkwp_spacer size="148" hide_with_css="hide_later"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="124px" bottom_padding="124px" font_color="#4f78a1" bg_color="#002142" el_id="counters"][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" prk_in="TONS LIFTED" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="1256" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" prk_in="NEW DELIVERIES" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="1987" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" prk_in="MILES RAN" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="782" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" prk_in="SALES GROWTH" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="72px" el_id="pricing"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR SOLUTIONS" align="Center" font_weight="700" title_size="h2" margin_bottom="8px" hook_show_line="above thicker" line_color="#f9df1e" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="80px" css_animation="hook_fade_waypoint" custom_css="overflow:hidden;"][vc_column width="1/4"][prkwp_styled_title prk_in="1. Get In Touch" font_weight="600" title_size="h5" margin_bottom="2px" hook_show_line="above thick" line_color="#dadada" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="2. Select One Product" font_weight="600" title_size="h5" margin_bottom="2px" hook_show_line="above thick" line_color="#dadada" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="3. Wait For Our Call" font_weight="600" title_size="h5" margin_bottom="2px" hook_show_line="above thick" line_color="#dadada" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="4. Sit Back &amp; Relax" font_weight="600" title_size="h5" margin_bottom="2px" hook_show_line="above thick" line_color="#dadada" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="bottom-to-top" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f1f4f8" under_price="HOOK FIRESTARTER KIT" price="$19" after_price="| KG" serv_image="'.$folio_image_1.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f1f4f8" under_price="HOOK ADVANCED KIT" price="$59" after_price="| KG" serv_image="'.$folio_image_2.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f1f4f8" under_price="HOOK ULTIMATE KIT" price="$99" after_price="| KG" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Need A Custom Quotation?" align="Center" font_weight="600" text_color="#ffffff" title_size="h2" margin_bottom="24px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;"><span style="color: #ffffff;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="32"][prk_wp_theme_button type="colored_theme_button" prk_in="GET IN TOUCH" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="bottom-to-top"][/vc_column][/vc_row][vc_row top_padding="70px" bottom_padding="48px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="700" title_size="h2" margin_bottom="8px" hook_show_line="above thicker" line_color="#f9df1e" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="96px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Lisbon Headquarters" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay=""][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="500"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="1000"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="1500"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special" zoom="14" marker_image="9214" size="560" map_latitude="40.6900" map_longitude="-73.96000"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about-us',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#services',
                    'menu-item-title' => 'SERVICES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#pricing',
                    'menu-item-title' => 'PRICING',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['pulse-agency']) && $hook_theme_activation_options['pulse-agency']!="") {
            $hook_theme_activation_options['pulse-agency']="";
            $new_page_title='Pulse Agency';
            $new_page_content='[vc_row row_height="forced_row bottom_forced_row" font_color="#ffffff" bk_element="image" preload_bk="yes" bg_image_repeat="hook_with_parallax" append_arrow="yes" bg_image="'.$row_image.'"][vc_column width="1/2"][/vc_column][vc_column width="1/2"][vc_column_text el_class="header_font"]<h4 class="big" style="font-weight: 300; text-align: right; line-height: 1.25em;">We Are Hook. Digital Artists.<br />Awarded Studio. Lets work <a href="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" target="_blank">together</a>.</h4>[/vc_column_text][prkwp_spacer size="72"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" el_id="about"][vc_column caption="Creative Team Working" caption_position="prk_caption_right" width="1/2" bg_image="'.$folio_image_1.'"][/vc_column][vc_column col_width="70" css_animation="right-to-left" el_class="delay-300" width="1/2"][prkwp_spacer size="120"][prkwp_styled_title prk_in="WHO WE ARE." font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px"][vc_column_text]Doubtless one leading reason why the world declines honouring us whalemen, is this: they think that, at best, our vocation amounts to a butchering sort of business; and that when actively engaged therein, we are surrounded by all manner of defilements. Butchers we are, that is true. But butchers, also, and butchers of the bloodiest badge have been all Martial Commanders whom the world invariably delights to honour. And as for the matter of the alleged uncleanliness of our business, ye shall soon be initiated into certain facts hitherto pretty generally unknown, and which, upon the whole, will triumphantly plant the sperm whale-ship at least among the cleanliest things of this tidy earth.[/vc_column_text][vc_single_image image="'.$signa_image.'" img_size="full" retina_image="yes"][prkwp_spacer size="120"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" el_id="work"][vc_column width="1/1"][pirenko_last_portfolios cols_number="4" items_number="7" videos_behavior="default" show_load_more="no" show_filter="no" thumbs_mg="0" css_animation="hook_fade_waypoint" liner_color="#ffffff"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" el_id="reasons"][vc_column bg_image_hz_align="hook_hz_right" width="7/12" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="60" css_animation="right-to-left" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="01" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE ARE A TALENTED AND SOLID TEAM." font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="hide_later"][vc_column align="hook_right_align" col_width="60" css_animation="left-to-right" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" align="Right" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="02" align="Right" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE ARE CREATIVE AND HONEST PEOPLE." align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][vc_column bg_image_hz_align="hook_hz_left" width="7/12" bg_image="'.$row_image.'"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="show_later"][vc_column bg_image_hz_align="hook_hz_left" width="7/12" bg_image="'.$row_image.'"][/vc_column][vc_column align="hook_right_align" col_width="60" css_animation="left-to-right" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" align="Right" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="02" align="Right" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE ARE CREATIVE AND HONEST PEOPLE." align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column width="7/12" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="60" css_animation="right-to-left" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="03" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE HAVE THE BEST ONLINE RESOURCES." font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="hide_later"][vc_column align="hook_right_align" col_width="60" css_animation="left-to-right" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" align="Right" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="04" align="Right" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE ARE GOING TO SURPRISE YOU" align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][vc_column width="7/12" bg_image="'.$row_image.'"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" hide_with_css="show_later"][vc_column width="7/12" bg_image="'.$row_image.'"][/vc_column][vc_column align="hook_right_align" col_width="60" css_animation="left-to-right" el_class="delay-300" width="5/12"][prkwp_spacer size="140"][prkwp_styled_title prk_in="REASONS TO JOIN" align="Right" font_weight="400" text_color="#49b6b2" title_size="h5" margin_bottom="-10px" custom_css="font-size:1em;"][prkwp_styled_title prk_in="04" align="Right" font_weight="700" text_color="#49b6b2" title_size="h1" margin_bottom="18px" custom_css="font-size:110px;"][prkwp_styled_title prk_in="WE ARE GOING TO SURPRISE YOU" align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]At the next halt Hooja the Sly One managed to find enough slack chain to permit him to worm himself back quite close to Dian. We were all standing, and as he edged near the girl.[/vc_column_text][prkwp_spacer size="130"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="90px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_fixed_bk" el_id="services" bg_image="'.$folio_image_2.'"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR SERVICES" align="Center" font_weight="600" text_color="#49b6b2" title_size="h1" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-9 columns small-centered prk_9_em"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression by separate citations of items, practically or reliably known to me as a whaleman. From these citations, I take it and dash.</p>[/vc_column_text][prkwp_spacer size="54"][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Custom Feedback" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" el_class="hook_bubbles"][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Trusted Designers" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" css_delay="400" el_class="hook_paint"][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Online Reports" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" css_delay="800"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="72" el_class="hide_later"][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Problem Solving" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" el_class="hook_target"][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Awarded Speakers" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" css_delay="400" el_class="hook_mega"][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Hub Conferences" text_color="#49b6b2" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center" prk_in="In this one matter, Ahab seemed no exception to most American whale captains, who, as a set, rather incline to the opinion that by rights the ship cabin belongs to them." icon_up_color="#49b6b2" css_animation="hook_fade_waypoint" css_delay="800"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="126px" bottom_padding="126px"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][prkwp_styled_title prk_in="Our clients love us and heres their feedback.<br />Awesome work as usual." align="Center" font_weight="300" text_color="#ffffff" title_size="h3" css_animation="hook_fade_waypoint" custom_css="line-height: 1.25em;font-size:32px;"][prkwp_spacer size="36"][prk_testimonials category="" items_number="3" nav_color=" hook_btn_like" css_animation="hook_fade_waypoint" el_class="small-10 small-centered columns"][/vc_column][vc_column width="10/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" align="hook_center_align"][vc_column css_animation="hook_fade_waypoint" el_class="delay-300" width="1/1"][prk_instagram title="FOLLOW US ON INSTAGRAM" title_color="#ffffff" user="airbnb" items="6" rows="2" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align" el_id="contact"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center" retina_image="yes"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #49b6b2; font-size: 1.45rem;">Hook WordPress Theme</strong>Would like to test this WordPress Theme?<br /><a style="color: #ffffff;" href="https://www.pirenko.com/sandbox/" target="_blank">Request a tryout here →</a>[/vc_column_text][prkwp_spacer size="6"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#e91e63" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="dribbble" net_4="instagram" net_5="xing" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#49b6b2" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #49b6b2; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'WORK',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#reasons',
                    'menu-item-title' => 'WHY US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#services',
                    'menu-item-title' => 'SERVICES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['consultancy']) && $hook_theme_activation_options['consultancy']!="") {
            $hook_theme_activation_options['consultancy']="";
            $new_page_title='Lawyers/Consultants';
            $new_page_content='[vc_row bk_type="hook_full_row" bk_element="image" append_arrow="yes"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="featured" items_number="5" special_text_color="1" cat_filter="home" thumbs_type_folio="hook_unlinked"][/vc_column][/vc_row][vc_row top_padding="90px" margin_bottom="90px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="ABOUT US" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#f1c40f" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Worldwide Number One Consultancy Company " align="Center" font_type="custom_font" font_weight="400" text_color="#6a92d4" title_size="h5" use_italic="Yes" margin_bottom="48px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text css_animation="left-to-right" append_arrow="yes"]<p style="text-align: right;">The three men at her mast-head wore long streamers of narrow red bunting at their hats; from the stern, a whale-boat was suspended, bottom down; and hanging captive from the bowsprit was seen the long lower jaw of the last whale.</p><p style="text-align: right;"><strong>Signals, ensigns, and jacks</strong> of all colours were flying from her rigging, on every side. Sideways lashed in each of her three basketed tops were two barrels of sperm; above which, in her top-mast cross-trees, you saw slender breakers of the same precious fluid; and nailed to her main truck was a brazen lamp and thank God that it was perfectly fine.</p><p style="text-align: right;">As was afterwards learned, the <em>Bachelor</em> had met with the most surprising success; all the more wonderful, for that while cruising in the same seas numerous other vessels had gone entire months without securing a single fish. Not only had barrels of beef and bread been given away to make room for the far more valuable sperm, but additional <strong>supplemental casks</strong> had been bartered for, from the ships she had met; and these were stowed along the deck, and in the captains and officers state-rooms. You gotta love this type of service for sure.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="right-to-left"]In the forecastle, the sailors had actually caulked and pitched their chests, and filled them; it was humorously added, that the cook had clapped a head on his <em>largest boiler</em>, and filled it; that the steward had plugged his spare coffee-pot and filled it.<br />The harpooneers had headed the sockets of their irons and filled them; that indeed everything was filled with sperm, except the captain pantaloons pockets, and those he reserved to thrust his hands into, in self-complacent testimony of his entire satisfaction.As this glad ship of good luck bore down upon the moody Pequod, the <strong>Barbarian Sound</strong> of enormous drums came from her forecastle and she kept moving forward again and again.<br />Drawing still nearer, <strong>a crowd of men were seen standing</strong> round her huge try-pots, which, covered her with the parchment-like POKE or stomach skin of the black fish, gave forth a loud roar to every stroke of the clenched hands of the crew. On the quarter-deck, the mates and harpooneers were dancing with the olive-hued girls who had eloped with them from the Polynesian Isles which are absolutely amazing by the way and you know it.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer][vc_single_image image="'.$signa_image.'" img_size="full" alignment="center" retina_image="yes" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column bg_image_hz_align="hook_hz_right" column_height="hook_forced_clm hook_vertical_clm" width="1/2" bg_image="'.$row_image.'"][vc_column_text][/vc_column_text][/vc_column][vc_column col_width="70" width="1/2" bg_color="#002346"][prkwp_spacer size="100"][prkwp_styled_title prk_in="Empowering Businesses Worldwide. With Confidence." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" custom_css="line-height: 1.25em;"][vc_column_text]Forgetful of us, our guards joined in the general rush for the exits, many of which pierced the wall of the amphitheater behind us. Perry, Ghak, and I became separated in the chaos which reigned for a few moments after the beast cleared the wall of the arena, each intent upon saving his own hide.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="LETS WORK →" link="#" window="Yes"][prkwp_spacer size="106"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="60px" el_id="showcase"][vc_column width="1/1"][prkwp_styled_title prk_in="SHOWCASE" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#f1c40f" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Selected With Care, Heres Our Finest Selection" align="Center" font_type="custom_font" font_weight="400" text_color="#6a92d4" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.<br />From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][prkwp_spacer size="48"][prkwp_board cols_width="15%|45%|20%|20%" board_header="Date|Description|Client|Case Study" values="Apr 2017|Something Fancy Goes Here Rigth|John Norton|https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko,Feb 2017|An Awesome Description For You|Lundy Industries|https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko,Dec 2016|This Is Some Dummy Text |Rita Miller|,Dec 2016|He Was Hoisted Against The Ship|Golden Wings|https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko,Jun 2016|Silence reigned Over The Before|Ten Records Inc.|https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko,Feb 2016|Stood Leaning Over With Big Eyes|Diego Tudor|,Jan 2016|Hanging There Midst Intense Calm|Mary Stiller|,Nov 2015|Planets Lake Infidel Abraham Head|Robert Ride|https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" link_text="MORE INFO →" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="126px" bottom_padding="126px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" el_class="hook_retina" bg_image="2399"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST ACHIEVMENTS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 small-centered columns"]<p style="text-align: center;">The leading matter of it requires to be still further and more familiarly enlarged upon.<br />Moreover to take away any incredulity which a profound expertise.[/vc_column_text][prkwp_spacer size="54"][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="945" prk_in="TIMELY DELIVERIES" icon_material="mdi-alarm"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_origin="685" counter_number="0" prk_in="UNSOLVED MISTERIES" icon_material="mdi-beaker-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="980" prk_in="BIG HEARBEATS" icon_material="mdi-heart-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="876" prk_in="CLOUD WORKERS" icon_material="mdi-image-filter-drama"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="90px" margin_bottom="90px" el_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="SERVICES" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#f1c40f" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="We Are Powerful Multifaceted Consultants" align="Center" font_type="custom_font" font_weight="400" text_color="#6a92d4" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.<br />From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][prkwp_spacer size="48"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="WITH US, YOU ARE IN GOOD HANDS" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul; and more stranger thing seemed to be going upwards.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22MARKETING%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23124e8a%22%2C%22customtxtcolor%22%3A%22%23124e8a%22%7D%2C%7B%22label%22%3A%22FINANCE%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23124e8a%22%2C%22customtxtcolor%22%3A%22%23124e8a%22%7D%2C%7B%22label%22%3A%22E-COMMERCE%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23124e8a%22%2C%22customtxtcolor%22%3A%22%23124e8a%22%7D%2C%7B%22label%22%3A%22GLOBAL%20LOGISTICS%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23124e8a%22%2C%22customtxtcolor%22%3A%22%23124e8a%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="90px" font_color="#ffffff" custom_css="overflow:hidden;" el_id="services" bg_color="#002346"][vc_column width="1/3"][prkwp_service name="E-Commerce Solutions" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#f1c40f" icon_color="#f1c40f" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Media Partnerships" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media Boost" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="90px" font_color="#ffffff" custom_css="overflow:hidden;" bg_color="#002346"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="One-On-One Support" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Tailored Solutions" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="54px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#f1c40f" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Time To Start Our Partnership" align="Center" font_type="custom_font" font_weight="400" text_color="#6a92d4" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.<br />From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="108px"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="COME AND CHECK OUR NEW OFFICE" font_weight="600" title_size="h5" margin_bottom="6px"][pirenko_contact_info text_color="#444444" street_address="River Street, Blue Building, 1st. floor" postal_code="5690-970 New york City" tel="+1 (245) 785 952 354" email="hello@hook.com"]As he stood hovering over you half suspended in air, so wildly and eagerly peering towards the horizon, you would have thought him some prophet or seer beholding the shadows of Fate, and by those wild.[/pirenko_contact_info][/vc_column_inner][vc_column_inner width="1/2"][prkwp_spacer size="36" el_class="show_later"][prk_contact_form email_adr="pirenko.themeforest@gmail.com" fields_display="hook_big_subject" backs_color="rgba(255,255,255,0.08)"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" align="hook_center_align"][vc_column width="1/1"][vc_gmaps map_style="theme_special" zoom="13" marker_image="2636" map_latitude="40.6700" map_longitude="-73.9400" size="600"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#showcase',
                    'menu-item-title' => 'SHOWCASE',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#services',
                    'menu-item-title' => 'SERVICES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['single-product-sale']) && $hook_theme_activation_options['single-product-sale']!="") {
            $hook_theme_activation_options['single-product-sale']="";
            $new_page_title='Single Product Sale';
            $new_page_content='[vc_row row_height="forced_row vertical_forced_row" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" append_arrow="yes" bg_image="'.$row_image.'" append_arrow_color="#ffffff"][vc_column width="1/2"][vc_single_image image="'.$folio_image_1.'" img_size="full" alignment="right" css_animation="hook_fade_waypoint" css_delay="1000" el_class="hide_later" custom_css="position:absolute;right:0px;margin-top:-160px;"][/vc_column][vc_column width="1/2"][prkwp_spacer size="52" hide_with_css="show_later"][prkwp_styled_title prk_in="Your New Mobile Phone." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="4px" css_animation="right-to-left-faster" css_delay="50"][prkwp_styled_title prk_in="Stay Connected 24/7." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="12px" css_animation="right-to-left-faster" css_delay="250"][vc_column_text css_animation="right-to-left-faster" css_delay="450"]<span style="color: #ffffff;">Saturday lives in my memory as a day of suspense.<br />It was a day of lassitude too, hot and close the door.<br />I am told a rapidly fluctuating barometer.</span>[/vc_column_text][prkwp_spacer size="4"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="LEARN MORE →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="right-to-left-faster" css_delay="650"][prkwp_spacer size="36"][prkwp_spacer size="72" hide_with_css="show_later"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" el_id="concept"][vc_column width="1/1"][prkwp_styled_title prk_in="DESIGN AND FUNCTIONALITY" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#ffc400" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Partnering With The Best" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="48px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text drop_cap="yes" css_animation="left-to-right" append_arrow="yes"]The three men at her mast-head wore long streamers of narrow red bunting at their hats; from the stern, a whale-boat was suspended, bottom down; and hanging captive from the bowsprit was seen the long lower jaw of the last whale.<br /><strong>Signals, ensigns, and jacks</strong> of all colours were flying from her rigging, on every side. Sideways lashed in each of her three basketed tops were two barrels of sperm; above which, in her top-mast cross-trees, you saw slender breakers of the same precious fluid; and nailed to her main truck was a brazen lamp.<br />As was afterwards learned, the <em>Bachelor</em> had met with the most surprising success; all the more wonderful, for that while cruising in the same seas numerous other vessels had gone entire months without securing a single fish. Not only had barrels of beef and bread been given away to make room for the far more valuable sperm, but additional <strong>supplemental casks</strong> had been bartered for, from the ships she had met; and these were stowed along the deck, and in the captains and officers state-rooms.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="right-to-left"]In the forecastle, the sailors had actually caulked and pitched their chests, and filled them; it was humorously added, that the cook had clapped a head on his <em>largest boiler</em>, and filled it; that the steward had plugged his spare coffee-pot and filled it.<br />The harpooneers had headed the sockets of their irons and filled them; that indeed everything was filled with sperm, except the captains pantaloons pockets, and those he reserved to thrust his hands into, in self-complacent testimony of his entire satisfaction.As this glad ship of good luck bore down upon the moody Pequod, the <strong>Barbarian Sound</strong> of enormous drums came from her forecastle.<br />Drawing still nearer, <strong>a crowd of men were seen standing</strong> round her huge try-pots, which, covered her with the parchment-like POKE or stomach skin of the black fish, gave forth a loud roar to every stroke of the clenched hands of the crew. On the quarter-deck, the mates and harpooneers were dancing with the olive-hued girls who had eloped with them from the Polynesian Isles.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer][vc_single_image image="'.$signa_image.'" img_size="full" alignment="center" retina_image="yes" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column column_height="hook_forced_clm hook_vertical_clm" width="1/2" bg_image="'.$row_image.'"][vc_column_text][/vc_column_text][/vc_column][vc_column col_width="70" width="1/2" bg_color="#0f0e10"][prkwp_spacer size="140"][prkwp_styled_title prk_in="Better Performance<br />And Less Weight" font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" custom_css="line-height: 1.25em;"][vc_column_text]Forgetful of us, our guards joined in the general rush for the exits, many of which pierced the wall of the amphitheater behind us. Perry, Ghak, and I became separated in the chaos which reigned for a few moments after the beast cleared the wall of the arena, each intent upon saving his own hide.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="BUY HOOK APP →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes"][prkwp_spacer size="146"][/vc_column][/vc_row][vc_row top_padding="100px" el_id="features"][vc_column width="1/1"][prkwp_styled_title prk_in="MAIN FEATURES" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#FFC400" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="What You Can Expect" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="80px"][vc_column width="1/4"][vc_single_image image="'.$folio_image_2.'" img_size="full"][/vc_column][vc_column width="3/4"][vc_row_inner][vc_column_inner width="1/2"][prkwp_spacer size="80"][prkwp_service name="Easier Text Messaging" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="14"][prkwp_service name="Improved Camera" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="200"][prkwp_spacer size="14"][prkwp_service name="Review System" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="400"][/vc_column_inner][vc_column_inner width="1/2"][prkwp_spacer size="14" hide_with_css="show_later"][prkwp_spacer size="80" hide_with_css="hide_later"][prkwp_service name="Full HD Movies" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="14"][prkwp_service name="Social Sharing" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="200"][prkwp_spacer size="14"][prkwp_service name="Custom Views" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="400"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/3"][vc_single_image image="'.$folio_image_1.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Easy Desktop Connect" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="600" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_single_image image="'.$folio_image_2.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Next Day Delivery" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="1100" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="1" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="120px" bottom_padding="102px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CUSTOMER REVIEWS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;"><span style="color: #ffffff;">An ancient culvert had here washed out, and the stream, no longer confined.<br />On the opposite side, the end of a rail projected and overhung.</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="16"][prk_testimonials category="" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="purchase"][vc_column width="1/1"][prkwp_styled_title prk_in="MAKE YOUR CHOICE" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#ffc400" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Three Different Options" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="hook_fade_waypoint" width="1/1"][vc_column_text]<p style="text-align: center;">Insert a WooCommerce Single Product page element here.</p>[/vc_column_text][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="80px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1c1b1d" bg_image="'.$row_image.'"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][prk_twt username="Pirenko" consumerkey="rbpMoRJimFm7palfAdFcQ" consumersecret="INDitVlv660xLnhXOCJ0SDTbTRpNYUnTZhTc0dKMEc" accesstoken="104003281-qI5XDb9lAI9FCoLr228A0K2dSUHG82hs9uhV6al4" accesstokensecret="smVTcE6BU7kdLkzL5nGR1zjMuGBolNUlgXWDekfIdk" cachetime="2" tweetstoshow="4" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#FFC400" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Our Contact Information" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="106px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Come And Meet Us" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#FFC400" icon_color="#FFC400" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#FFC400" icon_color="#FFC400" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#FFC400" icon_color="#FFC400" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#FFC400" icon_color="#FFC400" css_animation="bottom-to-top" css_delay="1500" icon_material="mdi-android-studio"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;"><span style="color: #ffffff;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align" bg_color="#0f0e10"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center" retina_image="yes"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #ffc400; font-size: 1.45rem;">Hook WordPress Theme</strong><br />Would like to test this WordPress Theme?<br /><a style="color: #ffffff;" href="https://www.pirenko.com/sandbox/" target="_blank">Request a tryout here →</a>[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#FFC400" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="dribbble" net_4="instagram" net_5="xing" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#FFC400" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #ffc400; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#concept',
                    'menu-item-title' => 'THE CONCEPT',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#features',
                    'menu-item-title' => 'FEATURES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#purchase',
                    'menu-item-title' => 'PURCHASE',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['alternative-portfolio']) && $hook_theme_activation_options['alternative-portfolio']!="") {
            $hook_theme_activation_options['alternative-portfolio']="";
            $new_page_title='Alternative Portfolio';
            $new_page_content='[vc_row font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_spacer size="480"][vc_column_text]<h3 class="header_font small" style="text-align: right; font-weight: normal; line-height: 34px;">Hi and welcome!<br />I am <span style="color: #e91e63;">Jane Mathews</span>.<br />This is my online portfolio.</h3>[/vc_column_text][prkwp_spacer size="40"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" el_id="work"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="masonry" cols_number="5" items_number="99" show_load_more="no" show_filter="no" thumbs_type_folio="lightboxed" thumbs_mg="0" multicolored_thumbs="no" css_animation="hook_fade_waypoint" el_class="out_thumbs"][/vc_column][/vc_row][vc_row top_padding="110px" bottom_padding="140px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="About Me" align="Center" font_weight="600" text_color="#ffffff" title_size="h1" margin_bottom="8px" hook_show_line="above thicker" line_color="#e91e63" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="10/12"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">As I came to a halt before him, Tars Tarkas pointed over the incubator and said, "Sak." I saw that he wanted me to repeat my performance of yesterday for the edification of Lorquas Ptomel, and, as I must confess that my prowess gave me no little satisfaction, I responded quickly leaping entirely over.</p><p style="text-align: center;">As I returned, Lorquas Ptomel grunted something at me, and turning to his warriors gave a few words of command relative to the incubator. They paid no further attention to me and I was thus permitted to remain close and watch their operations, which consisted in breaking an opening in the wall of the incubator large enough to permit of the exit of the young Martians and I was stumped by such beauty.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="17"][vc_single_image image="'.$signa_image.'" img_size="full" alignment="center" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row top_padding="130px" bottom_padding="110px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1c1b1d" bg_image="'.$row_image.'"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][prk_twt username="Pirenko" consumerkey="rbpMoRJimFm7palfAdFcQ" consumersecret="INDitVlv660xLnhXOCJ0SDTbTRpNYUnTZhTc0dKMEc" accesstoken="104003281-qI5XDb9lAI9FCoLr228A0K2dSUHG82hs9uhV6al4" accesstokensecret="smVTcE6BU7kdLkzL5nGR1zjMuGBolNUlgXWDekfIdk" cachetime="2" tweetstoshow="4" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="Lets Communicate.And Be <span>Together</span>." align="Center" font_weight="600" text_color="#ffffff" title_size="h1" margin_bottom="18px"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Would like to test this WordPress Theme?<br /><a style="color: #ffffff;" href="https://www.pirenko.com/sandbox/" target="_blank">Request a tryout here →</a>[/vc_column_text][prkwp_spacer size="6"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#e91e63" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="dribbble" net_4="instagram" net_5="xing" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#e91e63" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #e91e63; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'WORK',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['featured-portfolio']) && $hook_theme_activation_options['featured-portfolio']!="") {
            $hook_theme_activation_options['featured-portfolio']="";
            $new_page_title='Featured Portfolio';
            $new_page_content='[vc_row row_height="forced_row vertical_forced_row" bk_element="image" bg_image_repeat="hook_with_parallax" append_arrow="yes" append_arrow_color="#e91e63" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_spacer size="160" hide_with_css="show_later"][prkwp_styled_title prk_in="hello" align="Center" font_type="custom_font" font_weight="400" text_color="#e91e63" title_size="h1_bigger" margin_bottom="4px" custom_css="font-size:8rem;"][prkwp_styled_title prk_in="I am Jane Matthews.<br />Illustrator. Designer. Celtics Fan." align="Center" font_type="body_font" font_weight="400" title_size="h5" custom_css="line-height:24px;"][prkwp_spacer size="160" hide_with_css="show_later"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="106px" el_id="work" bg_color="#13161f"][vc_column width="1/1"][prkwp_styled_title prk_in="Recent Work" align="Center" font_type="custom_font" font_weight="400" text_color="#e91e63" title_size="h1_bigger" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][pirenko_last_portfolios layout_type_folio="masonry" items_number="6" show_filter="no" thumbs_mg="32" multicolored_thumbs="no" hook_show_skills="folio_always_title_and_skills" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="48px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="Get in touch" align="Center" font_type="custom_font" font_weight="400" text_color="#e91e63" title_size="h1_bigger" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="106px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Let us Have A Coffee" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#49567d" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Me A Call" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#49567d" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Me A Message" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#49567d" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#49567d" css_animation="bottom-to-top" css_delay="1500" icon_material="mdi-android-studio"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_instagram user="justinmaller" items="6" rows="2"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HELLO',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'WORK',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['creative-agency']) && $hook_theme_activation_options['creative-agency']!="") {
            $hook_theme_activation_options['creative-agency']="";
            $new_page_title='Creative Agency';
            $new_page_content='[vc_row row_height="forced_row bottom_forced_row" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_fixed_bk" align="hook_center_align" append_arrow="yes" bg_image="'.$row_image.'" append_arrow_color="#f1c40f"][vc_column width="1/1"][prkwp_styled_title prk_in="We Are Known For Our" align="Center" font_weight="400" text_color="#ffffff" title_size="h4" margin_bottom="6px"][prk_wptext_rotator text_color="#f1c40f" effect="slide" prk_in="GREATNESS+VERSATILITY+EXPERTISE+INSPIRATION+CAPABILITY+POTENTIAL" el_class="prk_heavier_700"][prkwp_spacer size="40"][/vc_column][/vc_row][vc_row top_padding="180px" el_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="YOUR SEARCH IS OVER" font_type="body_font" font_weight="700" text_color="#f1c40f" title_size="h5" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="OUR SERVICES" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="46px" bottom_padding="64px" custom_css="overflow:hidden;"][vc_column width="1/3"][prkwp_service name="Photography Services" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="180px" custom_css="overflow:hidden;"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Live Support" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Custom Work" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="180px" bottom_padding="46px" el_id="work"][vc_column width="1/1"][prkwp_styled_title prk_in="SIMPLY THE BEST" align="Right" font_type="body_font" font_weight="700" text_color="#f1c40f" title_size="h5" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="SELECTED WORK" align="Right" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" el_id="portfolio"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="vertical" items_number="5" text_align="hook_ct"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="108px" bottom_padding="108px" font_color="#ffffff" bg_color="#111111"][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#f1c40f" icon_type="custom_image" prk_in="COFFEE CUPS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="120" text_color="#f1c40f" icon_type="custom_image" prk_in="SUPPORT TICKETS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="84" text_color="#f1c40f" icon_type="custom_image" prk_in="WEB AWARDS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="782" text_color="#f1c40f" icon_type="custom_image" prk_in="MILES RAN" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="180px" bottom_padding="48px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="YES, WE ARE BRILLIANT" align="Right" font_type="body_font" font_weight="700" text_color="#f1c40f" title_size="h5" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="OUR TEAM" align="Right" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="180px" bottom_padding="50px"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS WORK TOGETHER" font_type="body_font" font_weight="700" text_color="#f1c40f" title_size="h5" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="PROJECTS OVERVIEW" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bottom_padding="160px" custom_css="overflow:hidden;"][vc_column css_animation="bottom-to-top" width="1/4"][prkwp_styled_title prk_in="Why Choose Us" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f1c40f" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/4"][prkwp_styled_title prk_in="How To Get Started" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f1c40f" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/4"][prkwp_styled_title prk_in="What Info Is Needed" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f1c40f" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column css_animation="bottom-to-top" css_delay="900" width="1/4"][prkwp_styled_title prk_in="The Usual Workflow" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f1c40f" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="180px" bottom_padding="50px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="TAKE THE FIRST STEP" align="Right" font_type="body_font" font_weight="700" text_color="#f1c40f" title_size="h5" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="GET IN TOUCH" align="Right" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bottom_padding="160px" custom_css="overflow:hidden;"][vc_column width="1/3"][prkwp_service name="Come And Meet Us" text_color="#ffffff" align="right_bigger" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#f1c40f" icon_color="#f1c40f" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column][vc_column width="1/3"][prkwp_spacer size="48" el_class="show_later"][prkwp_service name="Give Us A Call" text_color="#ffffff" align="right_bigger" prk_in="+1 234 567 890" icon_up_color="#f1c40f" icon_color="#f1c40f" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column][vc_column width="1/3"][prkwp_spacer size="48" el_class="show_later"][prkwp_service name="Send Us A Message" text_color="#ffffff" align="right_bigger" prk_in="withlove@hook.com" icon_up_color="#f1c40f" icon_color="#f1c40f" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" align="hook_center_align"][vc_column width="1/1"][prk_instagram user="airbnb" items="6" rows="2" css_animation="hook_fade_waypoint"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#services',
                    'menu-item-title' => 'SERVICES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'PORTFOLIO',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'OUR TEAM',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }


        if (isset($hook_theme_activation_options['modern-agency']) && $hook_theme_activation_options['modern-agency']!="") {
            $hook_theme_activation_options['modern-agency']="";
            $new_page_title='Modern Agency';
            $new_page_content='[vc_row bk_type="hook_full_row" row_height="forced_row bottom_forced_row" bottom_padding="28px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover_top" align="hook_right_align" bg_image="'.$row_image.'"][vc_column align="hook_left_align" column_height="hook_forced_clm bottom_forced_clm" width="1/1"][vc_row_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="1/3" align="hook_center_align"][/vc_column_inner][vc_column_inner width="1/3" align="hook_right_align"][prkwp_styled_title prk_in="PROFESSIONAL PHOTOGRAPHER" align="Right" font_weight="600" text_color="#ea2e49" title_size="h4" margin_bottom="3px"][vc_column_text]I love photography. The whole process makes me happy... From the moment that I adjust my camera until the whole print happens, I see nothing but joy. Reach me if you need some.[/vc_column_text][prkwp_spacer][prk_line color="rgba(255,255,255,0.23)"][prkwp_spacer size="4"][vc_column_text el_class="prk_9_em"]<a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Pinterest</a> | <a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Facebook</a> | <a style="color: #ffffff;" href="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko">Twitter</a> | <a style="color: #ffffff;" href="mailto:jm@hook.com">jm@hook.com</a>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish'
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }

            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'LATEST WORK &rarr;',
                    //'menu-item-attr-title' => 'start here',
                    'menu-item-status' => 'publish'
                );
            $menu_button_id=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            update_post_meta($menu_button_id, '_menu_item_trigger', 'on');
        }


        if (isset($hook_theme_activation_options['photography-studio']) && $hook_theme_activation_options['photography-studio']!="") {
            $hook_theme_activation_options['photography-studio']="";
            $new_page_title='Photography Studio';
            $new_page_content='[vc_row bk_type="hook_full_row" bk_element="image" append_arrow="yes"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="featured" items_number="5" special_text_color="1" cat_filter="" thumbs_type_folio="hook_unlinked"][/vc_column][/vc_row][vc_row top_padding="90px" margin_bottom="90px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="ABOUT US" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#e62c2c" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="We Are Awesome Digital Adventurers" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="48px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text css_animation="left-to-right" drop_cap="yes" append_arrow="yes"]The three men at her mast-head wore long streamers of narrow red bunting at their hats; from the stern, a whale-boat was suspended, bottom down; and hanging captive from the bowsprit was seen the long lower jaw of the last whale.<strong>Signals, ensigns, and jacks</strong> of all colours were flying from her rigging, on every side. Sideways lashed in each of her three basketed tops were two barrels of sperm; above which, in her top-mast cross-trees, you saw slender breakers of the same precious fluid; and nailed to her main truck was a brazen lamp.As was afterwards learned, the <em>Bachelor</em> had met with the most surprising success; all the more wonderful, for that while cruising in the same seas numerous other vessels had gone entire months without securing a single fish. Not only had barrels of beef and bread been given away to make room for the far more valuable sperm, but additional <strong>supplemental casks</strong> had been bartered for, from the ships she had met; and these were stowed along the deck, and in the captains and officers state-rooms.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="right-to-left"]In the forecastle, the sailors had actually caulked and pitched their chests, and filled them; it was humorously added, that the cook had clapped a head on his <em>largest boiler</em>, and filled it; that the steward had plugged his spare coffee-pot and filled it.The harpooneers had headed the sockets of their irons and filled them; that indeed everything was filled with sperm, except the captains pantaloons pockets, and those he reserved to thrust his hands into, in self-complacent testimony of his entire satisfaction.As this glad ship of good luck bore down upon the moody Pequod, the <strong>Barbarian Sound</strong> of enormous drums came from her forecastle.Drawing still nearer, <strong>a crowd of men were seen standing</strong> round her huge try-pots, which, covered her with the parchment-like POKE or stomach skin of the black fish, gave forth a loud roar to every stroke of the clenched hands of the crew. On the quarter-deck, the mates and harpooneers were dancing with the olive-hued girls who had eloped with them from the Polynesian Isles.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer][vc_single_image image="'.$signa_image.'" img_size="full" alignment="center" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column bg_image_hz_align="hook_hz_left" column_height="hook_forced_clm hook_vertical_clm" width="1/2" bg_image="'.$folio_image_1.'"][/vc_column][vc_column col_width="70" width="1/2" bg_color="#1d1e21"][prkwp_spacer size="100"][prkwp_styled_title prk_in="We Are Doing Business The Right Way" font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" custom_css="line-height: 1.25em;"][vc_column_text]Forgetful of us, our guards joined in the general rush for the exits, many of which pierced the wall of the amphitheater behind us. Perry, Ghak, and I became separated in the chaos which reigned for a few moments after the beast cleared the wall of the arena, each intent upon saving his own hide.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="LETS WORK" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes"][prkwp_spacer size="106"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="60px" el_id="work"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST WORK" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#e62c2c" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Selected With Care, Heres Our Finest Selection" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][prkwp_spacer size="48"][pirenko_last_portfolios layout_type_folio="masonry" items_number="9" cat_filter="" thumbs_type_folio="lightboxed" lightbox_type="multipled" thumbs_mg="20" multicolored_thumbs="no" liner_color="#ffffff"][/vc_column][/vc_row][vc_row top_padding="126px" bottom_padding="126px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" el_class="hook_retina" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST ACHIEVMENTS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 small-centered columns"]<p style="text-align: center;">The leading matter of it requires to be still further and more familiarly enlarged upon.Moreover to take away any incredulity which a profound expertise.[/vc_column_text][prkwp_spacer size="54"][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="945" prk_in="TIMELY DELIVERIES" icon_material="mdi-alarm"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_origin="685" counter_number="0" prk_in="UNSOLVED MISTERIES" icon_material="mdi-beaker-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="980" prk_in="BIG HEARBEATS" icon_material="mdi-heart-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="876" prk_in="CLOUD WORKERS" icon_material="mdi-image-filter-drama"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="90px" margin_bottom="90px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR TEAM" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#e62c2c" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="We Are Powerful Multifaceted Explorers" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][prkwp_spacer size="48"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="WITH US, YOU ARE IN GOOD HANDS" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul; and more stranger thing seemed to be going upwards.From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22BRANDING%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22VIDEO%20EDITION%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22E-COMMERCE%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22PHOTOGRAPHY%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="3" columns="3"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="90px" font_color="#ffffff" el_id="services" bg_color="#1d1e21"][vc_column width="1/3"][prkwp_service name="Photography Services" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="90px" font_color="#ffffff" bg_color="#1d1e21"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Live Support" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Custom Work" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="48px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#e62c2c" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Time To Start Our Partnership" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;">I care not to perform this part of my task methodically. But shall be content to produce the desired impression.<br />From these citations, I take it and dash the conclusion aimed at will naturally follow of itself.[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="108px"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="2/3"][prk_contact_form email_adr="something@mail.com" backs_color="rgba(255,255,255,0.08)"][/vc_column_inner][vc_column_inner width="1/3"][prkwp_spacer size="36" el_class="show_later"][pirenko_contact_info company_name="Hook Photography" street_address="River Street, Blue Building, 1st. floor" postal_code="5690-970 New york City" tel="+1 (245) 785 952 354" email="hello@hook.com"][/pirenko_contact_info][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" align="hook_center_align"][vc_column width="1/1"][prk_instagram user="airbnb" items="6" rows="2" css_animation="hook_fade_waypoint"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'OUR WORK',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'OUR TEAM',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['pure-business']) && $hook_theme_activation_options['pure-business']!="") {
            $hook_theme_activation_options['pure-business']="";
            $new_page_title='Pure Business';
            $new_page_content='[vc_row top_padding="80px" bottom_padding="64px" mobile_mode="hook_sooner" el_id="about-us"][vc_column width="1/3"][prkwp_service name="Photography Services" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="80px" mobile_mode="hook_sooner"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Live Support" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Custom Work" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="80px" bg_color="#f9f9f9"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/3"][vc_single_image image="'.$folio_image_1.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="An Open Minded Team" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="600" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_single_image image="'.$folio_image_2.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Lets Work Together" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="1100" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="1" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Start Now" tab_id="1474556120842-149a6748-c761"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="70px" bottom_padding="96px" el_id="portfolio"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST WORK" align="Center" font_weight="600" title_size="h2" margin_bottom="6px" hook_show_line="above thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="28"][pirenko_last_portfolios layout_type_folio="grid" items_number="9" show_load_more="no" thumbs_mg="32" multicolored_thumbs="no" hook_show_skills="folio_always_title_and_skills" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Doing Business The Right Way" align="Center" font_weight="400" text_color="#ffffff" title_size="h1" margin_bottom="24px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;"><span style="color: #ffffff;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="32"][prk_wp_theme_button type="colored_theme_button" prk_in="Schedule Meeting" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="bottom-to-top"][/vc_column][/vc_row][vc_row top_padding="70px" bottom_padding="60px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR TEAM" align="Center" font_weight="600" title_size="h2" margin_bottom="6px" hook_show_line="above thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_members items_number="6" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="96px" bottom_padding="80px" bg_color="#f9f9f9"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/2"][prkwp_styled_title prk_in="We Have Multiple Skills" font_weight="300" title_size="h3" margin_bottom="14px"][vc_column_text]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat.[/vc_column_text][/vc_column][vc_column col_width="75" width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22Branding%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%237adae6%22%2C%22customtxtcolor%22%3A%22%237adae6%22%7D%2C%7B%22label%22%3A%22Video%20Edition%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2326c6da%22%2C%22customtxtcolor%22%3A%22%2326c6da%22%7D%2C%7B%22label%22%3A%22E-Commerce%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2315a7b9%22%2C%22customtxtcolor%22%3A%22%2315a7b9%22%7D%2C%7B%22label%22%3A%22Photography%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2300838f%22%2C%22customtxtcolor%22%3A%22%2300838f%22%7D%5D" bgcolor="custom" bar_txt_size=" hook_bigger" margin_bottom_barra="50px" units="%" customtxtcolor="#222222" custombgcolor_back="#e2e2e2"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="124px" bottom_padding="124px" font_color="#004d54" bg_color="#12b2cb"][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#ffffff" icon_type="custom_image" prk_in="COFFEE CUPS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="120" text_color="#ffffff" icon_type="custom_image" prk_in="SUPPORT TICKETS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="84" text_color="#ffffff" icon_type="custom_image" prk_in="WEB AWARDS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="782" text_color="#ffffff" icon_type="custom_image" prk_in="MILES RAN" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="70px" bottom_padding="48px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="6px" hook_show_line="above thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">First it marked out a race-course, in a sort of circle and then all the party were placed along the course, here and there. They began running when they liked, and left off when they liked, so that it was not easy to know.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="96px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Come And Meet Us" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#12b2cb" icon_color="#12b2cb" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#12b2cb" icon_color="#12b2cb" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#12b2cb" icon_color="#12b2cb" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#12b2cb" icon_color="#12b2cb" css_animation="bottom-to-top" css_delay="1500" icon_material="mdi-android-studio"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special" zoom="14" marker_image="" size="560" map_latitude="40.6900" map_longitude="-73.96000"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'yes');
            add_post_meta($new_page_id, 'featured_slider_anim', 'goDown');
            add_post_meta($new_page_id, 'featured_slider_supersize', '1');
            add_post_meta($new_page_id, 'featured_slider_parallax', '1');
            add_post_meta($new_page_id, 'featured_slider_arrows', '1');
            add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
            add_post_meta($new_page_id, 'featured_arrow_color', '#222222');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about-us',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#portfolio',
                    'menu-item-title' => 'PORTFOLIO',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'OUR TEAM',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['app-landing-page']) && $hook_theme_activation_options['app-landing-page']!="") {
            $hook_theme_activation_options['app-landing-page']="";
            $new_page_title='App - Landing Page';
            $new_page_content='[vc_row row_height="forced_row vertical_forced_row" top_padding="0px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" append_arrow="yes" bg_image="'.$row_image.'" append_arrow_color="#ffffff"][vc_column width="1/2"][vc_single_image image="'.$folio_image_2.'" img_size="full" alignment="right" css_animation="hook_fade_waypoint" css_delay="1000" custom_css="position:absolute;right:0px;margin-top:-160px;"][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="Get Your Movie Tickets." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="4px" css_animation="right-to-left-faster" css_delay="50"][prkwp_styled_title prk_in="Without Hidden Fees." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="12px" css_animation="right-to-left-faster" css_delay="250"][vc_column_text css_animation="right-to-left-faster" css_delay="450"]<span style="color: #ffffff;">Saturday lives in my memory as a day of suspense.<br />It was a day of lassitude too, hot and close the door.<br />I am told a rapidly fluctuating barometer.</span>[/vc_column_text][prkwp_spacer size="4"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="LEARN MORE →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="right-to-left-faster" css_delay="650"][prkwp_spacer size="36"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" el_id="concept"][vc_column width="1/1"][prkwp_styled_title prk_in="THE CONCEPT" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#9c7ab7" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="The Initial Sparkle That Pushed Us" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="48px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text css_animation="left-to-right" drop_cap="yes" append_arrow="yes"]The three men at her mast-head wore long streamers of narrow red bunting at their hats; from the stern, a whale-boat was suspended, bottom down; and hanging captive from the bowsprit was seen the long lower jaw of the last whale.<br /><strong>Signals, ensigns, and jacks</strong> of all colours were flying from her rigging, on every side. Sideways lashed in each of her three basketed tops were two barrels of sperm; above which, in her top-mast cross-trees, you saw slender breakers of the same precious fluid; and nailed to her main truck was a brazen lamp.<br />As was afterwards learned, the <em>Bachelor</em> had met with the most surprising success; all the more wonderful, for that while cruising in the same seas numerous other vessels had gone entire months without securing a single fish. Not only had barrels of beef and bread been given away to make room for the far more valuable sperm, but additional <strong>supplemental casks</strong> had been bartered for, from the ships she had met; and these were stowed along the deck, and in the captains and officers state-rooms.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="right-to-left"]In the forecastle, the sailors had actually caulked and pitched their chests, and filled them; it was humorously added, that the cook had clapped a head on his <em>largest boiler</em>, and filled it; that the steward had plugged his spare coffee-pot and filled it.<br />The harpooneers had headed the sockets of their irons and filled them; that indeed everything was filled with sperm, except the captains pantaloons pockets, and those he reserved to thrust his hands into, in self-complacent testimony of his entire satisfaction. As this glad ship of good luck bore down upon the moody Pequod, the <strong>Barbarian Sound</strong> of enormous drums came from her forecastle.<br />Drawing still nearer, <strong>a crowd of men were seen standing</strong> round her huge try-pots, which, covered her with the parchment-like POKE or stomach skin of the black fish, gave forth a loud roar to every stroke of the clenched hands of the crew. On the quarter-deck, the mates and harpooneers were dancing with the olive-hued girls who had eloped with them from the Polynesian Isles.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer][vc_single_image image="'.$signa_image.'" img_size="full" alignment="center" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column bg_image_hz_align="hook_hz_left" column_height="hook_forced_clm hook_vertical_clm" width="1/2" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="70" width="1/2" bg_color="#0f0e10"][prkwp_spacer size="140"][prkwp_styled_title prk_in="Your Tickets, Your Way<br />Sit Back And Relax" font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" custom_css="line-height: 1.25em;"][vc_column_text]Forgetful of us, our guards joined in the general rush for the exits, many of which pierced the wall of the amphitheater behind us. Perry, Ghak, and I became separated in the chaos which reigned for a few moments after the beast cleared the wall of the arena, each intent upon saving his own hide.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="BUY HOOK APP →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes"][prkwp_spacer size="146"][/vc_column][/vc_row][vc_row top_padding="100px" el_id="features"][vc_column width="1/1"][prkwp_styled_title prk_in="MAIN FEATURES" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#9c7ab7" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="What You Can Expect" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="80px" bottom_padding="80px"][vc_column width="1/4"][vc_single_image image="'.$folio_image_2.'" img_size="full"][/vc_column][vc_column width="3/4"][vc_row_inner][vc_column_inner width="1/2"][prkwp_spacer size="80"][prkwp_service name="Live Support" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="14"][prkwp_service name="Photo Sharing" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="200"][prkwp_spacer size="14"][prkwp_service name="Rating System" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="400"][/vc_column_inner][vc_column_inner width="1/2"][prkwp_spacer size="80"][prkwp_service name="Movie Previews" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="14"][prkwp_service name="Social Media" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="200"][prkwp_spacer size="14"][prkwp_service name="Custom Views" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme. No possible endeavor then could enable him breakthrough." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="400"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/3"][vc_single_image image="'.$folio_image_2.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Online Tickets" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="600" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_single_image image="'.$folio_image_3.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Timely Deliveries" font_weight="600" title_size="h4" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="1100" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="1" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Start Now" tab_id="1474556120842-149a6748-c761"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="120px" bottom_padding="102px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CUSTOMER REVIEWS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;"><span style="color: #ffffff;">An ancient culvert had here washed out, and the stream, no longer confined.<br />On the opposite side, the end of a rail projected and overhung.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="16"][vc_row_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="10/12"][prk_testimonials category="" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="pricing"][vc_column width="1/1"][prkwp_styled_title prk_in="PRICING OPTIONS" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#9c7ab7" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Three Powerful Solutions" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="80px" css_animation="hook_fade_waypoint" custom_css="overflow:hidden;"][vc_column width="1/4"][prkwp_styled_title prk_in="Why Choose Us" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#9c7ab7" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="How To Get Started" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#9c7ab7" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="What Info Is Needed" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#9c7ab7" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="The Usual Workflow" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#9c7ab7" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="bottom-to-top" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="FREE" under_price="HOOK FIRESTARTER KIT" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="$59" under_price="HOOK ADVANCED KIT" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="$99" under_price="HOOK ULTIMATE KIT" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="80px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1c1b1d" bg_image="'.$row_image.'"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][prk_twt username="Pirenko" consumerkey="rbpMoRJimFm7palfAdFcQ" consumersecret="INDitVlv660xLnhXOCJ0SDTbTRpNYUnTZhTc0dKMEc" accesstoken="104003281-qI5XDb9lAI9FCoLr228A0K2dSUHG82hs9uhV6al4" accesstokensecret="smVTcE6BU7kdLkzL5nGR1zjMuGBolNUlgXWDekfIdk" cachetime="2" tweetstoshow="4" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="4px" hook_show_line="above thicker" line_color="#9c7ab7" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Our Contact Information" align="Center" font_type="custom_font" font_weight="400" title_size="h5" use_italic="Yes" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;">An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through dawn.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="106px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Come And Meet Us" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#9c7ab7" icon_color="#9c7ab7" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#9c7ab7" icon_color="#9c7ab7" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#9c7ab7" icon_color="#9c7ab7" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#9c7ab7" icon_color="#9c7ab7" css_animation="bottom-to-top" css_delay="1500" icon_material="mdi-android-studio"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;"><span style="color: #ffffff;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align" bg_color="#0f0e10"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center" retina_image="yes"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #9c7ab7; font-size: 1rem;">Hook WordPress Theme</strong><br />River Street, Blue Building, 1st. floor<br />5690-970 New York City</p>[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#9c7ab7" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="instagram" net_4="youtube" net_5="vimeo" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#9c7ab7" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #9c7ab7; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#concept',
                    'menu-item-title' => 'THE CONCEPT',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#features',
                    'menu-item-title' => 'FEATURES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#pricing',
                    'menu-item-title' => 'PRICING',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['architecture']) && $hook_theme_activation_options['architecture']!="") {
            $new_page_title='Architecture';
            $new_page_content='[vc_row row_height="forced_row bottom_forced_row" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_fixed_bk" align="hook_center_align" append_arrow="yes" bg_image="'.$row_image.'" append_arrow_color="#ffffff"][vc_column width="1/1"][prkwp_spacer size="248"][prkwp_styled_title prk_in="We Are Known For Our" align="Center" font_weight="400" text_color="#ffffff" title_size="h4" margin_bottom="6px" css_animation="hook_fade_waypoint" custom_css="font-size: 1.65rem;letter-spacing:0px;"][prk_wptext_rotator title_size="h1" text_color="#ffffff" effect="rotate-1" prk_in="GREATNESS+VERSATILITY+EXPERTISE+INSPIRATION+CAPABILITY+POTENTIAL" el_class="prk_heavier_700"][prkwp_spacer][prk_wp_theme_button type="ghost_theme_button" button_bk_color="#ffffff" button_size="prk_small" prk_in="LATEST WORK" link="#work" css_animation="left-to-right" css_delay="500" custom_css="margin-right:9px;"][prk_wp_theme_button type="ghost_theme_button" button_bk_color="#ffffff" button_size="prk_small" prk_in="GET IN TOUCH" link="#contact-us" css_animation="right-to-left" css_delay="500" custom_css="margin-right:0px;"][prkwp_spacer size="24"][/vc_column][/vc_row][vc_row top_padding="72px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="Our Projects &amp; Visions" align="Center" font_type="body_font" font_weight="600" text_color="#e08221" title_size="h5" margin_bottom="8px" hook_show_line="double_lined" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="ABOUT OUR STUDIO" align="Center" font_weight="600" title_size="h2" margin_bottom="5px" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="60px" bottom_padding="100px"][vc_column width="1/2"][vc_single_image image="'.$folio_image_1.'" img_size="full" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/2"][prkwp_spacer size="36" hide_with_css="show_later"][prkwp_styled_title prk_in="BRINGING IDEAS TO LIFE" font_weight="600" title_size="h5" hook_show_line="thin" width="100%" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:28px;"]The more I dive into this matter of whaling, and push my researches up to the very spring-head of it so much the more am I impressed with its great honourableness and antiquity and especially when I find so many great demi-gods and heroes, prophets of all sorts or truly beautiful things to be seen.<br />Who one way or other have shed distinction upon it, I am transported with the reflection that I myself belong, though but subordinately, to so emblazoned a fraternity. Often and often, though this narrative must not be clogged by the details, was Granser tale interrupted while the boys squabbled.<br />But the pretty milkmaid was much too vexed to make any answer. She picked up the leg sulkily and led her cow away, the poor animal limping on three legs. As she left them the milkmaid cast many reproachful glances over her shoulder at the clumsy strangers holding her among themselves.[/vc_column_text][vc_single_image image="'.$signa_image.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line color="#eaeaea"][/vc_column][/vc_row][vc_row top_padding="92px" bottom_padding="50px" bg_color="#ffffff"][vc_column width="7/12"][prkwp_styled_title prk_in="WE ARE MULTIFACETED AND GIFTED" font_weight="600" title_size="h5" hook_show_line="thin" width="100%"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing.[/vc_column_text][/vc_column][vc_column width="5/12"][vc_progress_bar values="%5B%7B%22label%22%3A%22BRANDING%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22VIDEO%20EDITION%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22E-COMMERCE%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22PHOTOGRAPHY%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6" el_class="header_font"][/vc_column][/vc_row][vc_row top_padding="126px" bottom_padding="126px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" el_class="hook_retina" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST ACHIEVMENTS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 small-centered columns"]<p style="text-align: center;">The leading matter of it requires to be still further and more familiarly enlarged upon.<br />Moreover to take away any incredulity which a profound expertise.</p>[/vc_column_text][prkwp_spacer size="54"][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="945" prk_in="TIMELY DELIVERIES" icon_material="mdi-alarm"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_origin="685" counter_number="0" prk_in="UNSOLVED MISTERIES" icon_material="mdi-beaker-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="980" prk_in="BIG HEARBEATS" icon_material="mdi-heart-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="876" prk_in="CLOUD WORKERS" icon_material="mdi-image-filter-drama"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="72px" el_id="work"][vc_column width="1/1"][prkwp_styled_title prk_in="Recognized By Everyone" align="Center" font_type="body_font" font_weight="600" text_color="#e08221" title_size="h5" margin_bottom="8px" hook_show_line="double_lined" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="OUR LATEST PROJECTS" align="Center" font_weight="600" title_size="h2" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner top_padding="18px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="30px" bottom_padding="100px"][vc_column width="1/1"][pirenko_last_portfolios cols_number="4" items_number="7" show_filter="no" thumbs_mg="0" multicolored_thumbs="no" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="138px" bottom_padding="108px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="RECENT FEEDBACK" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 small-centered columns"]<p style="text-align: center;"><span style="color: #ffffff;">The leading matter of it requires to be still further and more familiarly enlarged upon.</span><br /><span style="color: #ffffff;">Moreover to take away any incredulity which a profound expertise.</span></p>[/vc_column_text][prkwp_spacer size="24"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="72px" bottom_padding="100px" el_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="High Expectations" align="Center" font_type="body_font" font_weight="600" text_color="#e08221" title_size="h5" margin_bottom="8px" hook_show_line="double_lined" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="OUR SERVICES" align="Center" font_weight="600" title_size="h2" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner top_padding="18px" bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner bottom_padding="64px"][vc_column_inner width="1/4"][prkwp_service name="Real Brainstorming" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" el_class=""][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Awarded Projects" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="200"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Custom Builds" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="400"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Signature Design" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="600"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Environmental Care" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="50"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Detailed Reports" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="250"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Security Systems" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="450"][prkwp_spacer hide_with_css="show_later"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Timely Deliveries" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center_smaller" prk_in="Tomorrow the man will sail from Nantucket at the very beginning of the marvelous theme breakthrough." css_animation="bottom-to-top" css_delay="650"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="160px" bottom_padding="160px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STRONG WORLDWIDE PRESENCE" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="14px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" custom_css="font-size:1em;"]<p style="text-align: center;">The Mahar sank now till only the long upper bill and eyes were exposed above the surface of the water, and the girl had advanced until the end of that repulsive beak was but an inch or two from her face.</p>[/vc_column_text][prkwp_spacer size="36"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="MORE INFORMATION" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="hook_fade_waypoint"][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="72px" bottom_padding="60px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="Superb &amp; Skillful" align="Center" font_type="body_font" font_weight="600" text_color="#e08221" title_size="h5" margin_bottom="8px" hook_show_line="double_lined" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="OUR UNIQUE TEAM" align="Center" font_weight="600" title_size="h2" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner top_padding="18px" bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prk_members category="" items_number="6" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="120px" bottom_padding="100px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1c1b1d" bg_image="'.$row_image.'"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][prk_twt username="Pirenko" consumerkey="rbpMoRJimFm7palfAdFcQ" consumersecret="INDitVlv660xLnhXOCJ0SDTbTRpNYUnTZhTc0dKMEc" accesstoken="104003281-qI5XDb9lAI9FCoLr228A0K2dSUHG82hs9uhV6al4" accesstokensecret="smVTcE6BU7kdLkzL5nGR1zjMuGBolNUlgXWDekfIdk" cachetime="2" tweetstoshow="4" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row top_padding="70px" bottom_padding="48px" el_id="contact-us"][vc_column width="1/1"][prkwp_styled_title prk_in="We Are All Ears" align="Center" font_type="body_font" font_weight="600" text_color="#e08221" title_size="h5" margin_bottom="8px" hook_show_line="double_lined" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" font_weight="600" title_size="h2" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner top_padding="18px" bottom_padding="54px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">It is some systematized exhibition of the whale in his broad genera, that I would now fain put before you. Yet is it no easy task. The classification of the constituents of a chaos, nothing less is here essayed.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="110px" custom_css="overflow:hidden;"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Come And Meet Us" align="center_smaller" prk_in="River Street, 1st. floor<br />5690-970 New york City" icon_up_color="#e08221" css_animation="bottom-to-top" icon_material="mdi-comment-account-outline"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#e08221" css_animation="bottom-to-top" css_delay="500" icon_material="mdi-cellphone-android"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#e08221" css_animation="bottom-to-top" css_delay="1000" icon_material="mdi-xml"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#e08221" css_animation="bottom-to-top" css_delay="1500" icon_material="mdi-android-studio"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special" zoom="14" marker_image="" size="560" map_latitude="40.6900" map_longitude="-73.93000"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#work',
                    'menu-item-title' => 'OUR WORK',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#services',
                    'menu-item-title' => 'SERVICES',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'OUR TEAM',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#contact-us',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }


        if (isset($hook_theme_activation_options['bold-startup']) && $hook_theme_activation_options['bold-startup']!="") {
            $new_page_title='Bold Startup';
            $new_page_content='[vc_row top_padding="100px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="YOUR SEARCH IS OVER" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="OUR SERVICES" font_weight="600" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="46px" bottom_padding="64px" el_id="services"][vc_column width="1/3"][prkwp_service name="Photography Services" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="100px" el_id="more_services"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Live Support" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Custom Work" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="100px" el_id="portfolio"][vc_column width="1/1"][prkwp_styled_title prk_in="SIMPLY THE BEST" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="CLIENT SHOWCASE" font_weight="700" title_size="h1_bigger" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through the creeping vines which overran it. Beyond, crouching by a bush, a rabbit looked across at him in trembling hesitancy. Fully fifty feet was the distance.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="90px"][vc_column width="1/1"][prkwp_spacer size="-25"][pirenko_last_portfolios layout_type_folio="grid" items_number="9" show_load_more="no" show_filter="no" thumbs_type_folio="lightboxed" lightbox_type="multipled" thumbs_mg="36" multicolored_thumbs="no" hook_show_skills="folio_always_title_and_skills" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="160px" bottom_padding="168px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_color="#ffffff" bg_image="'.$row_image.'"][vc_column width="1/4"][prkwp_counter counter_number="782" text_color="#ffffff" icon_type="custom_image" prk_in="MILES RAN" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="120" text_color="#ffffff" icon_type="custom_image" prk_in="SUPPORT TICKETS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="84" text_color="#ffffff" icon_type="custom_image" prk_in="WEB AWARDS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#ffffff" icon_type="custom_image" prk_in="COFFEE CUPS" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="60px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="YES, WE ARE BRILLIANT" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;padding-left:3px;"][prkwp_styled_title prk_in="OUR TEAM" font_weight="700" title_size="h1_bigger" margin_bottom="16px" css_animation="hook_fade_waypoint" custom_css="padding-left:0px;"][vc_row_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]An ancient culvert had here washed out, and the stream, no longer confined, had cut a passage through the fill. On the opposite side, the end of a rail projected and overhung. It showed rustily through the creeping vines which overran it. Beyond, crouching by a bush, a rabbit looked across at him in trembling hesitancy. Fully fifty feet was the distance.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][/vc_column_inner][/vc_row_inner][vc_row_inner top_padding="50px" css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="WITH US, YOU ARE IN GOOD HANDS" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul; and more stranger thing seemed to be going upwards.From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22BRANDING%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22VIDEO%20EDITION%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22E-COMMERCE%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22PHOTOGRAPHY%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="3" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="80px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1d1e21" bg_image="'.$row_image.'"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][prk_twt username="Pirenko" consumerkey="rbpMoRJimFm7palfAdFcQ" consumersecret="INDitVlv660xLnhXOCJ0SDTbTRpNYUnTZhTc0dKMEc" accesstoken="104003281-qI5XDb9lAI9FCoLr228A0K2dSUHG82hs9uhV6al4" accesstokensecret="smVTcE6BU7kdLkzL5nGR1zjMuGBolNUlgXWDekfIdk" cachetime="2" tweetstoshow="4" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="pricing"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS WORK TOGETHER" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="PLANS OVERVIEW" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bottom_padding="80px" css_animation="hook_fade_waypoint" custom_css="overflow:hidden;"][vc_column width="1/4"][prkwp_styled_title prk_in="Why Choose Us" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="How To Get Started" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="What Info Is Needed" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="The Usual Workflow" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: left;">It was a sight full of quick wonder and awe! The vast swells of the omnipotent sea; the surging, hollow roar they made, as they rolled along the eight.</p>[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="bottom-to-top" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="$229" under_price="HOOK FIRESTARTER KIT" serv_image="'.$folio_image_1.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="$259" under_price="HOOK ADVANCED KIT" serv_image="'.$folio_image_2.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" price="$289" under_price="HOOK ULTIMATE KIT" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="SUBSCRIBE NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" bg_color="#1b1b1b" align="hook_center_align"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #f36176; font-size: 1rem;">Hook WordPress Theme</strong><br />River Street, Blue Building, 1st. floor<br />5690-970 New York City<br />[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#f36176" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="instagram" net_4="youtube" net_5="vimeo" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#f36176" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #f36176; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'yes');
            add_post_meta($new_page_id, 'featured_slider_anim', 'goDown');
            add_post_meta($new_page_id, 'featured_slider_supersize', '1');
            add_post_meta($new_page_id, 'featured_slider_parallax', '1');
            add_post_meta($new_page_id, 'featured_slider_arrows', '1');
            add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
            add_post_meta($new_page_id, 'featured_arrow_color', '#222222');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#portfolio',
                    'menu-item-title' => 'SHOWCASE',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'OUR TEAM',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#pricing',
                    'menu-item-title' => 'PRICING',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['rtl']) && $hook_theme_activation_options['rtl']!="") {
            $new_page_title='RTL Language';
            $new_page_content='[vc_row top_padding="100px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="انتهى البحث" align="Right" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="خدماتنا" align="Right" font_weight="600" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="46px" bottom_padding="64px" custom_css="overflow:hidden;" el_id="services"][vc_column width="1/3"][prkwp_service name="خدمات التصوير الفوتوغرافي" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="الطبعة الفيديو" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="وسائل التواصل الاجتماعي" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="100px" custom_css="overflow:hidden;" el_id="more_services"][vc_column width="1/3"][prkwp_service name="استراتيجيات التسويق" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="الدعم المباشر" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="أشغال حسب الطلب" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="right" prk_in="الآن، كان أبحرت من نانتوكيت في البداية من على خط الموسم على اساس. لا المسعى ممكن داخل المستودع." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="100px" el_id="portfolio"][vc_column width="1/1"][prkwp_styled_title prk_in="ببساطة الأفضل" align="Right" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="عرض العميل" align="Right" font_weight="700" title_size="h1_bigger" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: right;">وعلى مجرور القديم غسلها هنا خارج، وتيار، لم تعد محصورة، قطعت مرور من خلال التعبئة. على الجانب الآخر، نهاية السكك الحديدية توقعت ومتدلى. وبينت بصدىء من خلال الكروم الزاحف الذي اجتاح ذلك. بعدها، الرابض من قبل بوش، أرنب بدا في جميع أنحاء إليه في يرتجف تردد. كانت تماما خمسين قدما المسافة.</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="90px"][vc_column width="1/1"][prkwp_spacer size="-25"][pirenko_last_portfolios layout_type_folio="grid" items_number="9" show_load_more="no" show_filter="no" thumbs_type_folio="lightboxed" lightbox_type="multipled" thumbs_mg="36" multicolored_thumbs="no" hook_show_skills="folio_always_title_and_skills" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="160px" bottom_padding="168px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_color="#ffffff" bg_image="'.$row_image.'"][vc_column width="1/4"][prkwp_counter counter_number="782" text_color="#ffffff" icon_type="custom_image" prk_in="ميل ركض" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="120" text_color="#ffffff" icon_type="custom_image" prk_in="تذاكر الدعم" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="84" text_color="#ffffff" icon_type="custom_image" prk_in="جوائز الإنترنت" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#ffffff" icon_type="custom_image" prk_in="فناجين القهوة" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="60px" el_id="team"][vc_column width="1/1"][prkwp_styled_title prk_in="نعم، نحن الرائعة" align="right" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;padding-left:3px;"][prkwp_styled_title prk_in="فريقنا" align="right" font_weight="700" title_size="h1_bigger" margin_bottom="16px" css_animation="hook_fade_waypoint" custom_css="padding-left:0px;"][vc_row_inner][vc_column_inner width="1/3"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]وعلى مجرور القديم غسلها هنا خارج، وتيار، لم تعد محصورة، قطعت مرور من خلال التعبئة. على الجانب الآخر، نهاية السكك الحديدية توقعت ومتدلى. وبينت بصدىء من خلال الكروم الزاحف الذي اجتاح ذلك. بعدها، الرابض من قبل بوش، أرنب بدا في جميع أنحاء إليه في يرتجف تردد. كانت تماما خمسين قدما المسافة.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner top_padding="50px" hide_with_css="hide_later" css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22%D8%A7%D9%84%D8%B9%D9%84%D8%A7%D9%85%D8%A7%D8%AA%20%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D9%8A%D8%A9%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%B7%D8%A8%D8%B9%D8%A9%20%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D8%A9%20%D8%A7%D9%84%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A%D8%A9%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][vc_column_inner width="1/2"][prkwp_styled_title prk_in="معنا، أنت في أيد أمينة" align="right" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]في قاعدة الصاري الرئيسي، والكامل تحت الدبلون واللهب، وكانت المجوسية الركوع أمام آخاب، ولكن مع رأسه انحنى بعيدا عنه حين يكون بالقرب من ولكن ليس بعد حللنا التعويذة من هذا البياض، وعلمت لماذا الطعون مع هذه السلطة إلى الروح؛ وأكثر شيء غريب يبدو أن تسير في الاتجاه الصعودي.<br />من تزوير ويتقوس يخيم، حيث كان قد انخرط تأمين الصاري، عددا من البحارة، اعتقل من قبل على مرأى ومسمع، وقد التحمت الآن معا، وعلق متدلية، مثل عقدة من الدبابير مخدر من تدلى الشيء الكبير ودوامي.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner top_padding="50px" hide_with_css="show_later" css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="معنا، أنت في أيد أمينة" align="right" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]في قاعدة الصاري الرئيسي، والكامل تحت الدبلون واللهب، وكانت المجوسية الركوع أمام آخاب، ولكن مع رأسه انحنى بعيدا عنه حين يكون بالقرب من ولكن ليس بعد حللنا التعويذة من هذا البياض، وعلمت لماذا الطعون مع هذه السلطة إلى الروح؛ وأكثر شيء غريب يبدو أن تسير في الاتجاه الصعودي.<br />من تزوير ويتقوس يخيم، حيث كان قد انخرط تأمين الصاري، عددا من البحارة، اعتقل من قبل على مرأى ومسمع، وقد التحمت الآن معا، وعلق متدلية، مثل عقدة من الدبابير مخدر من تدلى الشيء الكبير ودوامي.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_progress_bar values="%5B%7B%22label%22%3A%22%D8%A7%D9%84%D8%B9%D9%84%D8%A7%D9%85%D8%A7%D8%AA%20%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D9%8A%D8%A9%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%B7%D8%A8%D8%B9%D8%A9%20%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D8%A9%20%D8%A7%D9%84%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A%D8%A9%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="3" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="170px" bottom_padding="152px" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="دعونا نبدأ شيء معا" align="Center" font_weight="400" text_color="#ffffff" title_size="h1" margin_bottom="24px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="hook_fade_waypoint"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]<p style="text-align: center;"><span style="color: #ffffff;">لأول مرة تميز بها السباق، بطبيعة الحال، في نوع من دائرة ومن ثم كل طرف وضعت على طول مجرى، هنا وهناك. بدأوا تشغيل عندما يشاؤون، وتوقفت عندما يشاؤون، بحيث لم يكن من السهل أن تعرف.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="32"][prk_wp_theme_button type="colored_theme_button" prk_in="جدولة اجتماع" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="bottom-to-top"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="50px" el_id="pricing"][vc_column width="1/1"][prkwp_styled_title prk_in="دعونا نعمل معا" align="right" font_type="body_font" font_weight="700" text_color="#f36176" title_size="h5" margin_bottom="-4px" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_styled_title prk_in="خطة لمحة عامة" align="right" font_weight="700" title_size="h1_bigger" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bottom_padding="80px" css_animation="hook_fade_waypoint" custom_css="overflow:hidden;"][vc_column width="1/4"][prkwp_styled_title prk_in="لماذا تختارنا" align="Right" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: right;">كان مشهدا كاملا من عجب سريع والرعب! تتضخم واسعة من البحر القاهر. على ارتفاع، هدير جوفاء وهي مصنوعة، كما أنها تدحرجت على طول ثمانية.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="كيف تبدأ" align="Right" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: right;">كان مشهدا كاملا من عجب سريع والرعب! تتضخم واسعة من البحر القاهر. على ارتفاع، هدير جوفاء وهي مصنوعة، كما أنها تدحرجت على طول ثمانية.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="ما هو مطلوب معلومات" align="Right" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: right;">كان مشهدا كاملا من عجب سريع والرعب! تتضخم واسعة من البحر القاهر. على ارتفاع، هدير جوفاء وهي مصنوعة، كما أنها تدحرجت على طول ثمانية.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][prkwp_styled_title prk_in="سير العمل المعتاد" align="Right" font_weight="600" title_size="h5" margin_bottom="6px" hook_show_line="above thick" line_color="#f36176" width="32px"][vc_column_text]<p style="text-align: right;">كان مشهدا كاملا من عجب سريع والرعب! تتضخم واسعة من البحر القاهر. على ارتفاع، هدير جوفاء وهي مصنوعة، كما أنها تدحرجت على طول ثمانية.</p>[/vc_column_text][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="bottom-to-top" width="1/3"][prkwp_price_table table_align="hook_right_align" color="#f5f5f5" under_price="هوك النار كاتب كيت" price="$229" serv_image="'.$folio_image_1.'" prk_in="خيارات رهيبة وأنيقة,بعض الميزات الرائعة حقا,دعم قوي وسريع" button_label="اشترك الآن" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/3"][prkwp_price_table table_align="hook_right_align" color="#f5f5f5" under_price="ربط عدة المتقدمة" price="$259" serv_image="'.$folio_image_2.'" prk_in="بعض الميزات الرائعة حقا,خيارات رهيبة وأنيقة,دعم قوي وسريع" button_label="اشترك الآن" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/3"][prkwp_price_table table_align="hook_right_align" color="#f5f5f5" under_price="ربط عدة النهائية" price="$289" serv_image="'.$folio_image_3.'" prk_in="بعض الميزات الرائعة حقا,خيارات رهيبة وأنيقة,دعم قوي وسريع" button_label="اشترك الآن" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="اشترك في النشرة الإخبارية لدينا" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">بعد فعل بعض الوقت، النتيجة لا شيء أكثر من حدث، وقالت انها قررت الخوض في الحديقة في وقت واحد، ولكن، للأسف لضعف أليس. عندما وصلت إلى الباب، وجدت أنها قد نسيت المفتاح الذهبي قليلا، وعندما عادت.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center" retina_image="yes"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #f36176; font-size: 1.45rem;">ربط وورد موضوع</strong><br />ترغب في اختبار هذا الموضوع وورد<br /><a style="color: #ffffff;" href="https://www.pirenko.com/sandbox/" target="_blank">طلب تجريب هنا</a></p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#f36176" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="dribbble" net_4="instagram" net_5="xing" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#f36176" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">من قبلي <i class="mdi-heart-outline" style="color: #f36176; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> بنيت مع</p>[/vc_column_text][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'yes');
            add_post_meta($new_page_id, 'featured_slider_anim', 'goDown');
            add_post_meta($new_page_id, 'featured_slider_supersize', '1');
            add_post_meta($new_page_id, 'featured_slider_parallax', '1');
            add_post_meta($new_page_id, 'featured_slider_arrows', '1');
            add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
            add_post_meta($new_page_id, 'featured_arrow_color', '#222222');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#pricing',
                    'menu-item-title' => 'التسعير',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#team',
                    'menu-item-title' => 'فريقنا',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#portfolio',
                    'menu-item-title' => 'فريقنا',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'معلومات عنا',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'الصفحة الرئيسية',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['event']) && $hook_theme_activation_options['event']!="") {
            $new_page_title='Event';
            $new_page_content='[vc_row top_padding="64px" bottom_padding="48px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="An Event Apart" font_type="custom_font" font_weight="400" text_color="#f93616" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Lisbon Design Conference" font_weight="600" title_size="h3" margin_bottom="36px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text drop_cap="yes" css_animation="hook_fade_waypoint"]The more I dive into this matter of whaling, and push my researches up to the very spring-head of it so much the more am I impressed with its great honourableness and antiquity and especially when I find so many great demi-gods and heroes, prophets of all sorts or truly beautiful things to be seen.<br />Who one way or other have shed distinction upon it, I am transported with the reflection that I myself belong, though but subordinately, to so emblazoned a fraternity. Often and often, though this narrative must not be clogged by the details, was Granser tale interrupted while the boys squabbled.[/vc_column_text][prkwp_spacer size="6"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint"]<strong>The pretty milkmaid was much too vexed</strong> to make any answer. She picked up the leg sulkily and led her cow away, the poor animal limping on three legs. As she left them the milkmaid cast many reproachful glances over her shoulder at the clumsy strangers holding her among themselves.<br />Warmest climes but nurse the cruellest fangs: the tiger of Bengal crouches in spiced groves of ceaseless verdure. Skies the most effulgent but basket the deadliest thunders: gorgeous Cuba knows tornadoes that never swept tame northern lands. So, too, it is, that in these resplendent Japanese seas.[/vc_column_text][prkwp_spacer size="36" hide_with_css="show_later"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/2"][vc_single_image image="'.$signa_image.'" img_size="full" retina_image="yes" css_animation="hook_fade_waypoint"][/vc_column_inner][vc_column_inner width="1/2"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="56px" bottom_padding="48px" el_id="services" bg_color="#f9f9f9"][vc_column width="1/3"][prkwp_service name="Photography Workshops" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Facebook Campaigns" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="62px" el_id="more_services" bg_color="#f9f9f9"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Speakers Live Events" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="E-Commerce Approach" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside the warehouse." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff" bg_color="#252221"][vc_column width="1/2" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="70" width="1/2"][prkwp_spacer size="120"][prkwp_styled_title prk_in="We Are Shaping Design.<br />Every Day, Every Year." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" css_animation="hook_fade_waypoint" custom_css="line-height: 1.25em;"][vc_column_text css_animation="hook_fade_waypoint"]<strong>The pretty milkmaid was much too vexed</strong> to make any answer. She picked up the leg sulkily and led her cow away, the poor animal limping on three legs. As she left them the milkmaid cast many reproachful glances over her shoulder at the clumsy strangers holding her among themselves.<br />Warmest climes but nurse the cruellest fangs: the tiger of Bengal crouches in spiced groves of ceaseless verdure. Skies the most effulgent but basket the deadliest thunders: gorgeous Cuba knows tornadoes that never swept tame northern lands. So, too, it is, that in these resplendent Japanese seas.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button button_size="prk_medium" prk_in="Buy Tickets →" link="http://www.pirenko-themes.com/hook/event/#tickets" css_animation="flipin_x"][prkwp_spacer size="110"][/vc_column][/vc_row][vc_row top_padding="64px" bottom_padding="48px" el_id="schedule"][vc_column width="1/1"][prkwp_styled_title prk_in="Two Beautiful Days" align="Center" font_type="custom_font" font_weight="400" text_color="#f93616" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Main Event Schedule" align="Center" font_weight="600" title_size="h3" margin_bottom="54px" css_animation="hook_fade_waypoint"][vc_row_inner css_animation="bottom-to-top"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][pirenko_schedule head_title_left="Saturday" head_title_right="February, 21st"][/pirenko_schedule][pirenko_schedule element_type="event" event_time="3pm - 5pm" event_subtitle="Paul Richardson,<br />Sponsor Hall" event_title="Design For The Masses"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][pirenko_schedule element_type="event" event_time="5pm - 6pm" event_subtitle="Chef Simon,<br />Yellow Lounge" event_title="Dinner Break"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][pirenko_schedule element_type="event" event_time="6pm - 9pm" event_subtitle="Ruthie Miller,New Theater" event_title="Think Small, Go Big" el_class="hook_last_event"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][prkwp_spacer size="54"][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner css_animation="bottom-to-top"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][pirenko_schedule head_title_left="Sunday" head_title_right="February, 22nd"][/pirenko_schedule][pirenko_schedule element_type="event" event_time="10am - 11am" event_subtitle="Annie Streep,<br />Blue Lagoon Arena" event_title="Mastering WebDesign"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][pirenko_schedule element_type="event" event_time="11am - 1pm" event_subtitle="Paul Fritz,<br />Sponsor Hall" event_title="Growth: The Right Way"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][pirenko_schedule element_type="event" event_time="1pm - who knows" event_subtitle="DJ Rockefeller,Bairro Alto Pub" event_title="Farewell Lunch &amp; Party" el_class="hook_last_event"]This piece of rudeness was more than Alice could bear: she got up in great disgust, and walked off. The Dormouse fell asleep instantly, and neither of the others took the least notice of her going, though she looked back once or twice, half hoping that they would call after her. The last time she saw them, they were trying to put the Dormouse into the teapot.[/pirenko_schedule][prkwp_spacer size="54"][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="160px" bottom_padding="168px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover_top" bg_color="#ffffff" bg_image="'.$row_image.'"][vc_column width="1/4"][prkwp_counter counter_number="3000" text_color="#ffffff" suffix="+" icon_type="custom_image" prk_in="VISITORS EXPECTED" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="545" text_color="#ffffff" icon_type="custom_image" prk_in="EARLY BIRD TICKETS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="486" text_color="#ffffff" icon_type="custom_image" prk_in="WEB PARTNERS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="975" text_color="#ffffff" icon_type="custom_image" prk_in="SEATS AVAILABLE" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="64px" bottom_padding="48px" el_id="speakers"][vc_column width="1/1"][prkwp_styled_title prk_in="Experienced &amp; Talented People" align="Center" font_type="custom_font" font_weight="400" text_color="#f93616" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Awesome Speakers" align="Center" font_weight="600" title_size="h3" margin_bottom="12px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">Going forward and glancing over the weather bow, I perceived that the ship swinging to her anchor with the flood-tide, was now obliquely pointing towards the open ocean. The prospect was unlimited, but exceedingly awesome.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_members category="" items_number="3"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="56px" bottom_padding="48px" bg_color="#f9f9f9"][vc_column width="7/12"][prkwp_styled_title prk_in="WE ARE KNOWN FOR BEING PROFESSIONAL" font_weight="600" title_size="h5" margin_bottom="9px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul And more stranger thing seemed to be going upwards in the better days it will be fun and awesome.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing. The place looked very nice and clean. But not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul.[/vc_column_text][/vc_column][vc_column width="5/12"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="-12" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Start Now" tab_id="1483971833493-2d9cabee-86d5"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_color="#1d1e21" bg_image="'.$row_image.'"][vc_column width="1/1"][pirenko_carousel images="'.$logo_image.','.$logo_image.','.$logo_image.','.$logo_image.','.$logo_image.','.$logo_image.'"][/vc_column][/vc_row][vc_row top_padding="64px" bottom_padding="48px" el_id="tickets"][vc_column width="1/1"][prkwp_styled_title prk_in="Multiple Pricing Options" align="Center" font_type="custom_font" font_weight="400" text_color="#f93616" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Buy Your Tickets Today" align="Center" font_weight="600" title_size="h3" margin_bottom="12px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">Going forward and glancing over the weather bow, I perceived that the ship swinging to her anchor with the flood-tide, was now obliquely pointing towards the open ocean. The prospect was unlimited, but exceedingly awesome.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="120px"][vc_column css_animation="bottom-to-top" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" under_price="LISBON FIRESTARTER KIT" price="$119" serv_image="'.$folio_image_1.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="BUY TICKETS NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="300" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" under_price="LISBON ADVANCED KIT" price="$199" serv_image="'.$folio_image_2.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="BUY TICKETS NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][vc_column css_animation="bottom-to-top" css_delay="600" width="1/3"][prkwp_price_table table_align="hook_left_align" color="#f5f5f5" under_price="LISBON ULTIMATE KIT" price="$399" serv_image="'.$folio_image_3.'" prk_in="Some Really Cool Features,Awesome And Stylish Options,Powerful And Fast Support" button_label="BUY TICKETS NOW" button_link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff" bg_color="#252221"][vc_column col_width="70" width="1/2"][prkwp_spacer size="120"][prkwp_styled_title prk_in="Lets Be Together In Lisbon.<br />The Awesome Way." font_weight="400" text_color="#ffffff" title_size="h3" margin_bottom="20px" css_animation="hook_fade_waypoint" custom_css="line-height: 1.25em;"][vc_column_text css_animation="hook_fade_waypoint"]<strong>The pretty milkmaid was much too vexed</strong> to make any answer. She picked up the leg sulkily and led her cow away, the poor animal limping on three legs. As she left them the milkmaid cast many reproachful glances over her shoulder at the clumsy strangers holding her among themselves.<br />Warmest climes but nurse the cruellest fangs: the tiger of Bengal crouches in spiced groves of ceaseless verdure. Skies the most effulgent but basket the deadliest thunders: gorgeous Cuba knows tornadoes that never swept tame northern lands. So, too, it is, that in these resplendent Japanese seas.[/vc_column_text][prkwp_spacer size="14"][prk_wp_theme_button button_size="prk_medium" prk_in="Buy Hook Theme →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="flipin_x"][prkwp_spacer size="110"][/vc_column][vc_column width="1/2" bg_image="'.$row_image.'"][/vc_column][/vc_row][vc_row top_padding="64px" bottom_padding="48px" el_id="get-in-touch"][vc_column width="1/1"][prkwp_styled_title prk_in="We Are All Ears" align="Center" font_type="custom_font" font_weight="400" text_color="#f93616" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Get In Touch" align="Center" font_weight="600" title_size="h3" margin_bottom="12px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">Going forward and glancing over the weather bow, I perceived that the ship swinging to her anchor with the flood-tide, was now obliquely pointing towards the open ocean. The prospect was unlimited, but exceedingly awesome.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bottom_padding="96px" el_id="git-icons"][vc_column width="1/12"][/vc_column][vc_column width="10/12"][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Lisbon Headquarters" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center_smaller" prk_in="Tejo Street, 1st. floor<br />5690-970 Lisboa" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay=""][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Give Us A Call" icon_type="custom_image" serv_image="'.$folio_image_2.'" align="center_smaller" prk_in="+1 234 567 890" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="500"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Send Us A Message" icon_type="custom_image" serv_image="'.$folio_image_3.'" align="center_smaller" prk_in="withlove@hook.com" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="1000"][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Something Else" icon_type="custom_image" serv_image="'.$row_image.'" align="center_smaller" prk_in="Feeling Really Well" icon_up_color="#4e78a1" css_animation="bottom-to-top" css_delay="1500"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/12"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special" zoom="14" marker_image="" size="600" map_latitude="40.6900" map_longitude="-73.93000"][/vc_column][/vc_row]';
            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'yes');
            add_post_meta($new_page_id, 'featured_slider_anim', 'goDown');
            add_post_meta($new_page_id, 'featured_slider_supersize', '1');
            add_post_meta($new_page_id, 'featured_slider_parallax', '1');
            add_post_meta($new_page_id, 'featured_slider_arrows', '1');
            add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
            add_post_meta($new_page_id, 'featured_arrow_color', '#222222');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //------------------------ MENU ------------------------//
            //ADD THE PAGE CUSTOM MENU

            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$new_page_title.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$new_page_title;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            add_post_meta($new_page_id, 'top_menu', $mn_menu_id->term_id);

            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#about',
                    'menu-item-title' => 'ABOUT',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#schedule',
                    'menu-item-title' => 'SCHEDULE',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#speakers',
                    'menu-item-title' => 'SPEAKERS',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#tickets',
                    'menu-item-title' => 'TICKETS',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#get-in-touch',
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish'
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['stylish-showcase']) && $hook_theme_activation_options['stylish-showcase']!="") {
            $multipage_name='Stylish Showcase';
            $new_page_title=$multipage_name.' - Home';
            $new_page_content='[vc_row bk_type="hook_full_row" bg_color="#ffffff"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="panels" panels_number="3" items_number="6" text_align="hook_ct" panel_alpha="25" thumbs_type_folio="classiqued" hook_show_skills="folio_always_title_and_skills"][/vc_column][/vc_row][vc_row row_height="hook_fixed_height" row_fixed="600" top_padding="90px" bottom_padding="90px" bg_color="#0ab6d1"][vc_column width="1/2"][prkwp_styled_title prk_in="GIVING LIFE<br />TO YOUR IDEAS" align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="AMAZING IS USUALLY THE FEEDBACK THAT<br />WE GET FROM OUR CUSTOMERS" align="Right" font_weight="600" text_color="#ffffff" title_size="h5" use_italic="Yes" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][/vc_column][vc_column width="1/2"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:12px;"]<span style="color: #ffffff;">The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.</span><span style="color: #ffffff;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.</span><span style="color: #ffffff;">Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.</span>[/vc_column_text][vc_single_image image="'.$signa_image_white.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" mobile_mode="hook_sooner"][vc_column col_width="80" width="1/4" bg_color="#000000"][prkwp_spacer size="90"][prkwp_service name="BRANDING" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#111112"][prkwp_spacer size="90"][prkwp_service name="VIDEO EDITION" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#171717"][prkwp_spacer size="90"][prkwp_service name="E-COMMERCE" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#1f1f1f"][prkwp_spacer size="90"][prkwp_service name="PHOTOGRAPHY" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1500"][prkwp_spacer size="90"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="75" width="1/2" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="75" width="1/2"][prkwp_spacer size="108"][prkwp_styled_title prk_in="BE BRAVE, GO BOLD" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:26px;"]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.<br />Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.[/vc_column_text][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="REQUEST A QUOTE →" link="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" window="Yes" css_animation="hook_fade_waypoint"][prkwp_spacer size="108"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //CREATE THE MULTIPAGE MENU
            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$multipage_name.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$multipage_name;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - About Us';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="TALENTED FOLKS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Satisfy our customer desires with elegance.<br />This is our starting point on all projects." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="OUR MANIFESTO" font_weight="600" title_size="h4" margin_bottom="18px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3" bg_color="#111112"][prkwp_spacer size="108"][prkwp_styled_title prk_in="WE ARE SKILLED" font_weight="600" title_size="h4" margin_bottom="18px"][vc_progress_bar values="%5B%7B%22label%22%3A%22Branding%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22Video%20Edition%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22E-Commerce%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22Photography%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%5D" margin_bottom_barra="50px" units="%"][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="108px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_color="#1c7e8c" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT FEEDBACK" align="Center" font_weight="600" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">From the vibrating line extending the entire length of the upper part of the boat, and from its now being more tight than a harpstring, you would have thought the craft had two keels.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_testimonials color="#ffffff" nav_color=" hook_btn_like hook_texty" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - All Work';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="36px" font_color="#ffffff" bk_element="image" el_class="limited_pad_row" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STAYING AUTHENTIC" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A collection of bits and bytes that will make your day.<br />New work will be posted every week." align="Center" font_weight="400" text_color="#f7f7f7" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'squares');
            add_post_meta($new_page_id, 'limited_width', '0');
            add_post_meta($new_page_id, 'items_number', '9');
            add_post_meta($new_page_id, 'cols_number', '3');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');
            add_post_meta($new_page_id, 'thumbs_mg', '0');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'classiqued');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'OUR WORK',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $new_page_title=$multipage_name.' - Blog';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="36px" font_color="#ffffff" bk_element="image" el_class="limited_pad_row" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STAYING AUTHENTIC" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#f7f7f7" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'masonry');
            add_post_meta($new_page_id, 'limit_width', '0');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'BLOG',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Footer';
            $new_page_content='[vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center" retina_image="yes"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #0ab6d1; font-size: 1rem;">Hook WordPress Theme</strong><br />River Street, Blue Building, 1st. floor<br />5690-970 New York City[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#0ab6d1" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="instagram" net_4="youtube" net_5="vimeo" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#0ab6d1" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #0ab6d1; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            $new_page_title=$multipage_name.' - Get In Touch';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS GET TOGETHER" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Reach us with ease and place your enquiries.<br />Would love to hear from you." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="HIT US WITH SOMETHING" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.</p>[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#0e0e0e"][prkwp_spacer size="72"][prkwp_styled_title prk_in="CONTACT INFO" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.</p>[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        if (isset($hook_theme_activation_options['agency-dark']) && $hook_theme_activation_options['agency-dark']!="") {
            $multipage_name='Agency - Dark Colors';
            $new_page_title=$multipage_name.' - Home';
            $new_page_content='[vc_row bk_type="hook_full_row" append_arrow="yes" bg_color="#ffffff" append_arrow_color="#ffffff"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="featured" items_number="7" cat_filter="" thumbs_type_folio="classiqued"][/vc_column][/vc_row][vc_row row_height="hook_fixed_height" row_fixed="600" top_padding="90px" bottom_padding="90px" bg_color="#0ab6d1"][vc_column width="1/2"][prkwp_styled_title prk_in="GIVING LIFE<br />TO YOUR IDEAS" align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="AMAZING IS USUALLY THE FEEDBACK THAT<br />WE GET FROM OUR CUSTOMERS" align="Right" font_weight="600" text_color="#ffffff" title_size="h5" use_italic="Yes" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][/vc_column][vc_column width="1/2"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:12px;"]<span style="color: #ffffff;">The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.</span><span style="color: #ffffff;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequeg hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.</span><span style="color: #ffffff;">Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.</span>[/vc_column_text][vc_single_image image="'.$signa_image_white.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" mobile_mode="hook_sooner"][vc_column col_width="80" width="1/4" bg_color="#000000"][prkwp_spacer size="90"][prkwp_service name="BRANDING" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#111112"][prkwp_spacer size="90"][prkwp_service name="VIDEO EDITION" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#171717"][prkwp_spacer size="90"][prkwp_service name="E-COMMERCE" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#1f1f1f"][prkwp_spacer size="90"][prkwp_service name="PHOTOGRAPHY" text_color="#ffffff" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1500"][prkwp_spacer size="90"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="75" width="1/2" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="75" width="1/2"][prkwp_spacer size="108"][prkwp_styled_title prk_in="BE BRAVE, GO BOLD" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:26px;"]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequeg hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.<br />Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.[/vc_column_text][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="REQUEST A QUOTE →" link="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" window="Yes" css_animation="hook_fade_waypoint"][prkwp_spacer size="108"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //CREATE THE MULTIPAGE MENU
            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$multipage_name.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$multipage_name;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - About Us';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="TALENTED FOLKS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Satisfy our customer desires with elegance.<br />This is our starting point on all projects." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" font_color="#ffffff"][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="OUR MANIFESTO" font_weight="600" title_size="h4" margin_bottom="18px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3" bg_color="#111112"][prkwp_spacer size="108"][prkwp_styled_title prk_in="WE ARE SKILLED" font_weight="600" title_size="h4" margin_bottom="18px"][vc_progress_bar values="%5B%7B%22label%22%3A%22Branding%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22Video%20Edition%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22E-Commerce%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%2C%7B%22label%22%3A%22Photography%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%230ab6d1%22%7D%5D" margin_bottom_barra="50px" units="%"][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="108px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_color="#1c7e8c" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT FEEDBACK" align="Center" font_weight="600" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">From the vibrating line extending the entire length of the upper part of the boat, and from its now being more tight than a harpstring, you would have thought the craft had two keels.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_testimonials color="#ffffff" nav_color=" hook_btn_like hook_texty" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            //ADD THE ALL WORK TRIGGER BUTTON
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'ALL WORK',
                    'menu-item-status' => 'publish'
                );
            $menu_button_id=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            update_post_meta($menu_button_id, '_menu_item_trigger', 'on');

            $new_page_title=$multipage_name.' - Blog';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="36px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STAYING AUTHENTIC" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#f7f7f7" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'masonry');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'BLOG',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Get In Touch';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS GET TOGETHER" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Reach us with ease and place your enquiries.<br />Would love to hear from you." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="HIT US WITH SOMETHING" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.</p>[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#0e0e0e"][prkwp_spacer size="72"][prkwp_styled_title prk_in="CONTACT INFO" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.</p>[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $new_page_title=$multipage_name.' - Footer';
            $new_page_content='[vc_row top_padding="108px" bottom_padding="36px" font_color="#ffffff" align="hook_center_align"][vc_column width="1/1"][vc_single_image image="'.$logo_image.'" img_size="full" alignment="center"][prkwp_spacer size="36"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #0ab6d1; font-size: 1rem;">Hook WordPress Theme</strong><br />River Street, Blue Building, 1st. floor<br />5690-970 New York City[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#ffffff" hover_color="#0ab6d1" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="instagram" net_4="youtube" net_5="vimeo" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][prkwp_spacer size="90"][prk_line color="#0ab6d1" width="90px" height="4px" align="center"][prkwp_spacer size="38"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">Built with <i class="mdi-heart-outline" style="color: #0ab6d1; font-size: 28px; vertical-align: middle; margin-top: -2px;"></i> by Pirenko.</p>[/vc_column_text][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

        }

        if (isset($hook_theme_activation_options['agency-bright']) && $hook_theme_activation_options['agency-bright']!="") {
            $multipage_name='Agency - Bright Colors';
            $new_page_title=$multipage_name.' - Home';
            $new_page_content='[vc_row bk_type="hook_full_row" append_arrow="yes" bg_color="#ffffff" append_arrow_color="#000000"][vc_column width="1/1"][pirenko_last_portfolios layout_type_folio="featured" items_number="7" special_text_color="1" cat_filter="" thumbs_type_folio="classiqued"][/vc_column][/vc_row][vc_row row_height="hook_fixed_height" row_fixed="600" top_padding="90px" bottom_padding="90px" bg_color="#e23843"][vc_column width="1/2"][prkwp_styled_title prk_in="GIVING LIFE<br />TO YOUR IDEAS" align="Right" font_weight="700" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="AMAZING IS USUALLY THE FEEDBACK THAT<br />WE GET FROM OUR CUSTOMERS" align="Right" font_weight="600" text_color="#ffffff" title_size="h5" use_italic="Yes" css_animation="hook_fade_waypoint" custom_css="letter-spacing:1px;"][prkwp_spacer el_class="show_later"][/vc_column][vc_column width="1/2"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:12px;"]<span style="color: #ffffff;">The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.</span><span style="color: #ffffff;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.</span><span style="color: #ffffff;">Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.</span>[/vc_column_text][vc_single_image image="'.$signa_image.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" mobile_mode="hook_sooner"][vc_column col_width="80" width="1/4" bg_color="#e0e0e0"][prkwp_spacer size="90"][prkwp_service name="BRANDING" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#eaeaea"][prkwp_spacer size="90"][prkwp_service name="VIDEO EDITION" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#f4f4f4"][prkwp_spacer size="90"][prkwp_service name="E-COMMERCE" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][prkwp_spacer size="90"][/vc_column][vc_column col_width="80" width="1/4" bg_color="#ffffff"][prkwp_spacer size="90"][prkwp_service name="PHOTOGRAPHY" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="center" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1500"][prkwp_spacer size="90"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="75" width="1/2" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][vc_column col_width="75" width="1/2" bg_color="#e0e0e0"][prkwp_spacer size="108"][prkwp_styled_title prk_in="NO STRINGS ATTACHED" font_weight="600" text_color="#222222" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" custom_css="margin-bottom:26px;"]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequeg hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.<br />Riotous and disordered as the universal commotion now was, it soon resolved itself into what seemed a systematic movement, for having clumped together at last in one dense body, they then renewed their onward flight with augmented fleetness.[/vc_column_text][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="REQUEST A QUOTE →" link="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" window="Yes" css_animation="hook_fade_waypoint"][prkwp_spacer size="108"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //CREATE THE MULTIPAGE MENU
            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$multipage_name.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$multipage_name;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - About Us';
            $new_page_content='[vc_row top_padding="306px" bottom_padding="306px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="108"][prkwp_styled_title prk_in="OUR MANIFESTO" font_weight="600" title_size="h4" margin_bottom="18px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="WE ARE SKILLED" font_weight="600" title_size="h4" margin_bottom="18px"][vc_progress_bar values="%5B%7B%22label%22%3A%22Branding%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23d92f3a%22%2C%22customtxtcolor%22%3A%22%23d92f3a%22%7D%2C%7B%22label%22%3A%22Video%20Edition%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23d92f3a%22%2C%22customtxtcolor%22%3A%22%23d92f3a%22%7D%2C%7B%22label%22%3A%22E-Commerce%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23d92f3a%22%2C%22customtxtcolor%22%3A%22%23d92f3a%22%7D%2C%7B%22label%22%3A%22Photography%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23d92f3a%22%2C%22customtxtcolor%22%3A%22%23d92f3a%22%7D%5D" margin_bottom_barra="50px" units="%"][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="108px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_color="#d92f3a" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT FEEDBACK" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">From the vibrating line extending the entire length of the upper part of the boat, and from its now being more tight than a harpstring, you would have thought the craft had two keels.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_testimonials color="#ffffff" nav_color=" hook_btn_like hook_texty" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            //ADD THE ALL WORK TRIGGER BUTTON
            $mn_item=
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => $page_slug.'/#',
                    'menu-item-title' => 'ALL WORK',
                    'menu-item-status' => 'publish'
                );
            $menu_button_id=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
            update_post_meta($menu_button_id, '_menu_item_trigger', 'on');

            $new_page_title=$multipage_name.' - Blog';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="36px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STAYING AUTHENTIC" align="Center" font_weight="700" text_color="#000000" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.
New articles will be posted every week." align="Center" font_weight="400" text_color="#111111" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'masonry');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'BLOG',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Get In Touch';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS GET TOGETHER" align="Center" font_weight="700" text_color="#000000" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Reach us with ease and place your enquiries.<br />Would love to hear from you." align="Center" font_weight="400" text_color="#111111" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="HIT US WITH SOMETHING" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.</p>[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="72"][prkwp_styled_title prk_in="CONTACT INFO" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.</p>[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'GET IN TOUCH',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $new_page_title=$multipage_name.' - Footer';
            $new_page_content='[vc_row top_padding="108px" bottom_padding="96px" font_color="#222222" align="hook_center_align"][vc_column width="1/1"][vc_single_image image="'.$logo_image_dark.'" img_size="full" alignment="center"][prkwp_spacer size="30"][vc_column_text el_class="prk_9_em"]<p style="text-align: center;"><strong style="color: #d92f3a; font-size: 1rem;">Hook WordPress Theme</strong><br />River Street, Blue Building, 1st. floor<br />5690-970 New York City[/vc_column_text][vc_column_text el_class="prk_9_em"]<p style="text-align: center;">+1 785 952 354.<a href="mailto:hello@hook.com">hello@hook.com</a>.www.hook.com</p>[/vc_column_text][prkwp_spacer size="6"][pirenko_social_nets icons_size="20" icons_padding="4" text_color="#222222" hover_color="#d92f3a" custom_opacity="90" net_1="facebook" net_2="twitter" net_3="instagram" net_4="youtube" net_5="vimeo" link_1="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/pirenko/portfolio?ref=Pirenko"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

        }

        if (isset($hook_theme_activation_options['real-estate']) && $hook_theme_activation_options['real-estate']!="") {
            $hook_theme_activation_options['real-estate']="";
            $multipage_name='Real Estate';
            $new_page_title=$multipage_name.' - Home';
            $new_page_content='[vc_row top_padding="360px" bottom_padding="60px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="What Are You Looking For?" font_weight="600" text_color="#ffffff" title_size="h3"][prkwp_styled_title prk_in="We are specialized in luxury Villas &amp; Apartments.<br />Reach us if have any further enquiries or any custom requests." font_weight="400" text_color="#ffffff" title_size="h5" margin_bottom="32px"][vc_row_inner][vc_column_inner width="2/3"][vc_wp_search align="hook_no_icon"][/vc_column_inner][vc_column_inner width="1/3"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="100px" el_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="The Best Properties" font_type="body_font" font_weight="400" text_color="#afafaf" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Exceptional Services" font_weight="600" title_size="h3" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="46px" bottom_padding="64px"][vc_column width="1/3"][prkwp_service name="Easy Reminders" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Repair Services" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Real-Time Stats" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="110px" custom_css="overflow:hidden;"][vc_column width="1/3"][prkwp_service name="Live Support" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Digital Campaigns" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Prodution" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="138px" bottom_padding="108px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="RECENT FEEDBACK" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="32px" css_animation="hook_fade_waypoint"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px"][vc_column width="1/1"][prkwp_styled_title prk_in="Our Stunning Selection" font_type="body_font" font_weight="400" text_color="#afafaf" title_size="h5" use_italic="Yes" margin_bottom="4px" css_animation="hook_fade_waypoint"][prkwp_styled_title prk_in="Featured Properties" font_weight="600" title_size="h3" css_animation="hook_fade_waypoint"][pirenko_last_portfolios layout_type_folio="grid" items_number="6" show_load_more="no" show_filter="no" thumbs_type_folio="classiqued" thumbs_mg="36" multicolored_thumbs="no" hook_show_skills="folio_always_title_and_skills" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" font_color="#ffffff" bg_color="#2588ce"][vc_column width="1/2"][prkwp_styled_title prk_in="Why Choose Us" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="6px" hook_show_line="thin" line_color="#ffffff" width="100%" css_animation="hook_fade_waypoint"][vc_column_text]The more I dive into this matter of whaling, and push my researches up to the very spring-head of it so much the more am I impressed with its great honourableness and antiquity; and especially when I find so many great demi-gods and heroes, prophets of all sorts.<br />Who one way or other have shed distinction upon it, I am transported with the reflection that I myself belong, though but subordinately, to so emblazoned a fraternity.[/vc_column_text][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="Our Mission" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="6px" hook_show_line="thin" line_color="#ffffff" width="100%" css_animation="hook_fade_waypoint"][vc_column_text]The more I dive into this matter of whaling, and push my researches up to the very spring-head of it so much the more am I impressed with its great honourableness and antiquity; and especially when I find so many great demi-gods and heroes, prophets of all sorts.<br />Who one way or other have shed distinction upon it, I am transported with the reflection that I myself belong, though but subordinately, to so emblazoned a fraternity.[/vc_column_text][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //CREATE THE MULTIPAGE MENU
            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$multipage_name.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$multipage_name;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - About Us';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Experienced Team" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Satisfy our customer desires with elegance.<br />This is our starting point on all projects." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes" el_id="about"][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="Our Core Business" font_weight="600" title_size="h4" margin_bottom="18px"][vc_column_text]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequeg’s hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy.[/vc_column_text][vc_single_image image="'.$signa_image.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes" custom_css="max-width:280px;"][prkwp_spacer size="108"][/vc_column][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3" bg_color="#2588ce"][prkwp_spacer size="108"][prkwp_styled_title prk_in="Standing Out" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="18px"][vc_column_text]<span style="color: #ffffff;">At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by and then renewed their onward flight with augmented fleetness.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.</span>[/vc_column_text][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3" bg_color="#2588ce"][prkwp_spacer size="108"][prkwp_styled_title prk_in="Our Manifesto" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="18px"][vc_column_text]<span style="color: #ffffff;">At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by and then renewed their onward flight with augmented fleetness.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.</span>[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="Recent Properties Breakdown" font_weight="600" title_size="h4" margin_bottom="18px"][vc_progress_bar values="%5B%7B%22label%22%3A%22Apartments%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%232588ce%22%2C%22customtxtcolor%22%3A%22%232588ce%22%7D%2C%7B%22label%22%3A%22Villas%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%232588ce%22%2C%22customtxtcolor%22%3A%22%232588ce%22%7D%2C%7B%22label%22%3A%22Stores%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%232588ce%22%2C%22customtxtcolor%22%3A%22%232588ce%22%7D%2C%7B%22label%22%3A%22Hotels%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%232588ce%22%2C%22customtxtcolor%22%3A%22%232588ce%22%7D%5D" bgcolor="custom" margin_bottom_barra="50px" units="%" custombgcolor="#dd3333" custombgcolor_back="#efefef" el_class="header_font"][prkwp_spacer size="108"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Properties';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" margin_bottom="48px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Our Properties" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A collection of all our properties that will fulfill your needs.<br />New assets are usually added every day." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'grid');
            add_post_meta($new_page_id, 'limited_width', '1');
            add_post_meta($new_page_id, 'items_number', '6');
            add_post_meta($new_page_id, 'cols_number', '3');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');
            add_post_meta($new_page_id, 'thumbs_mg', '20');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'classiqued');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_always_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'PROPERTIES',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            //ADD THE CONTACT PARENT BUTTON TO THE MENU
            $menu =
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => '#',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            $parent_button=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $menu );

            $new_page_title=$multipage_name.' - Contact Page With Image';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" bk_element="image" el_class="limited_pad_row" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="Lets Get Together" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Reach us with ease and place your enquiries.<br />Would love to hear from you." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="Hit Us With Something" font_weight="600" title_size="h4" margin_bottom="14px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.<br />[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="72"][prkwp_styled_title prk_in="Contact Info" font_weight="600" title_size="h4" margin_bottom="14px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'With Image',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $new_page_title=$multipage_name.' - Contact Page With Map';
            $new_page_content='[vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special_dk" zoom="14" map_latitude="40.7000" map_longitude="-73.94000" size="524"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="Hit Us With Something" font_weight="600" title_size="h4" margin_bottom="14px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="72"][prkwp_styled_title prk_in="Contact Info" font_weight="600" title_size="h4" margin_bottom="14px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'With Map',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Blog';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="36px" font_color="#ffffff" bk_element="image" el_class="limited_pad_row" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="STAYING AUTHENTIC" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#f7f7f7" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'masonry');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'BLOG',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Footer';
            $new_page_content='[vc_row top_padding="140px" bottom_padding="140px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover_top" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="BRING IN YOUR PROPERTY" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" custom_css="font-size:1em;"]The Mahar sank now till only the long upper bill and eyes were exposed above the surface of the water, and the girl had advanced until the end of that repulsive beak was but an inch or two from her face.[/vc_column_text][prkwp_spacer][prk_wp_theme_button type="colored_theme_button" prk_in="MORE INFO" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="hook_fade_waypoint"][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

        }

        if (isset($hook_theme_activation_options['full-demo']) && $hook_theme_activation_options['full-demo']!="") {
            $multipage_name='Full Demo';
            $new_page_title=$multipage_name.' - Home';
            $new_page_content='[vc_row row_height="forced_row bottom_forced_row" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_fixed_bk" align="hook_center_align" append_arrow="yes" bg_image="'.$row_image.'" append_arrow_color="#ffffff"][vc_column width="1/1"][prkwp_styled_title prk_in="We Are Known For Our" align="Center" font_weight="400" text_color="#ffffff" title_size="h4" margin_bottom="6px" css_animation="hook_fade_waypoint" custom_css="font-size: 1.65rem;"][prk_wptext_rotator text_color="#ffffff" effect="rotate-1" prk_in="GREATNESS+VERSATILITY+EXPERTISE+INSPIRATION+CAPABILITY+POTENTIAL" el_class="prk_heavier_700"][prkwp_spacer][prk_wp_theme_button type="ghost_theme_button" button_bk_color="#ffffff" button_size="prk_small" prk_in="LATEST WORK" link="http://www.pirenko-themes.com/hook/fulldemo/#portfolio" css_animation="left-to-right" css_delay="500" custom_css="margin-right:9px;"][prk_wp_theme_button type="ghost_theme_button" button_bk_color="#ffffff" button_size="prk_small" prk_in="GET IN TOUCH" link="http://www.pirenko-themes.com/hook/fulldemo/get-in-touch/" css_animation="right-to-left" css_delay="500" custom_css="margin-right:0px;"][prkwp_spacer size="50"][/vc_column][/vc_row][vc_row top_padding="96px" bottom_padding="64px" mobile_mode="hook_sooner"][vc_column width="1/3"][prkwp_service name="Photography Services" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top"][/vc_column][vc_column width="1/3"][prkwp_service name="Video Edition" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="500"][/vc_column][vc_column width="1/3"][prkwp_service name="Social Media" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1000"][/vc_column][/vc_row][vc_row bottom_padding="96px" mobile_mode="hook_sooner"][vc_column width="1/3"][prkwp_service name="Marketing Strategies" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="100"][/vc_column][vc_column width="1/3"][prkwp_service name="Live Support" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor then could enable her commander to make the great." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="600"][/vc_column][vc_column width="1/3"][prkwp_service name="Custom Work" text_color="#222222" icon_type="custom_image" serv_image="'.$folio_image_1.'" align="left" prk_in="Now, the Pequod had sailed from Nantucket at the very beginning of the Season-on-the-Line. No possible endeavor inside." icon_up_color="#0ab6d1" icon_color="#0ab6d1" css_animation="bottom-to-top" css_delay="1100"][/vc_column][/vc_row][vc_row top_padding="138px" bottom_padding="108px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_image="'.$folio_image_2.'"][vc_column width="1/1"][prk_testimonials category="" size=" hook_bigger" title_color="#ffffff" color="#ffffff" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column bg_image_hz_align="hook_hz_right" bg_image_vt_align="hook_vt_top" col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$folio_image_3.'"][/vc_column][vc_column col_width="75" width="5/12" bg_color="#ffffff"][prkwp_spacer size="108"][prkwp_styled_title prk_in="An Open Minded Team" font_weight="400" text_color="#12b2cb" title_size="h5" use_italic="Yes" css_animation="right-to-left"][prkwp_styled_title prk_in="FRESH IDEAS" font_weight="600" text_color="#222222" title_size="h3" margin_bottom="18px" css_animation="right-to-left" css_delay="300"][vc_column_text css_animation="right-to-left" css_delay="300" custom_css="margin-bottom:26px;"]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.[/vc_column_text][prkwp_spacer size="108" el_class="hide_later"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="75" width="5/12" bg_color="#ffffff"][prk_line el_class="show_later hook_mobile_line"][prkwp_spacer size="108" el_class="hide_later"][prkwp_styled_title prk_in="Fully Capable &amp; Fast" align="Right" font_weight="400" text_color="#12b2cb" title_size="h5" use_italic="Yes" css_animation="left-to-right"][prkwp_styled_title prk_in="ENERGIZED TEAM" align="Right" font_weight="600" text_color="#222222" title_size="h3" margin_bottom="18px" css_animation="left-to-right" css_delay="300"][vc_column_text css_animation="left-to-right" css_delay="300" custom_css="margin-bottom:26px;"]<p style="text-align: right;">The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.</p><p style="text-align: right;">After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequegs hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy made by the sudden tossing of a pair of broad flukes close by.</p>[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column bg_image_hz_align="hook_hz_left" bg_image_vt_align="hook_vt_top" col_width="75" width="7/12" bg_color="#1b1b1c" bg_image="'.$row_image.'"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="108px" bottom_padding="108px" font_color="#ffffff" bg_color="#12b2cb"][vc_column width="1/4"][prkwp_counter counter_number="975" icon_type="custom_image" prk_in="COFFEE CUPS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="120" icon_type="custom_image" prk_in="SUPPORT TICKETS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="84" icon_type="custom_image" prk_in="WEB AWARDS" css_animation="hook_fade_waypoint"][/vc_column][vc_column width="1/4"][prkwp_counter counter_number="782" icon_type="custom_image" prk_in="MILES RAN" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" top_padding="96px" el_id="portfolio"][vc_column width="1/1"][prkwp_styled_title prk_in="LATEST WORK" align="Center" font_weight="600" title_size="h2" margin_bottom="20px" hook_show_line="thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][prkwp_spacer size="14"][pirenko_last_portfolios cols_number="4" items_number="7" show_load_more="no" thumbs_type_folio="classiqued" thumbs_mg="0" multicolored_thumbs="no" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="50px" bottom_padding="50px"][vc_column width="1/1"][vc_row_inner top_padding="50px" css_animation="hook_fade_waypoint"][vc_column_inner width="1/2"][prkwp_styled_title prk_in="With Us, You Are In Good Hands" font_weight="600" title_size="h5" margin_bottom="6px"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by but not yet have we solved the incantation of this whiteness, and learned why it appeals with such power to the soul; and more stranger thing seemed to be going upwards.<br />From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping big and swirly thing.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][prkwp_spacer size="36" hide_with_css="show_later"][vc_progress_bar values="%5B%7B%22label%22%3A%22BRANDING%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22VIDEO%20EDITION%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22E-COMMERCE%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%2C%7B%22label%22%3A%22PHOTOGRAPHY%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%23464646%22%2C%22customtxtcolor%22%3A%22%23464646%22%7D%5D" margin_bottom_barra="50px" units="%" custombgcolor_back="#e6e6e6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="hook_full_row" bk_element="image" css_animation="hook_fade_waypoint"][vc_column width="1/1"][prk_line][/vc_column][/vc_row][vc_row top_padding="100px" bottom_padding="100px" bg_color="#f9f9f9"][vc_column col_width="" css_animation="hook_fade_waypoint" width="1/3"][vc_single_image image="'.$folio_image_1.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="An Open Minded Team" font_weight="600" title_size="h5" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="600" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_single_image image="'.$folio_image_2.'" img_size="full" custom_css="margin-bottom:12px;"][prkwp_styled_title prk_in="Lets Work Together" font_weight="600" title_size="h5" margin_bottom="14px"][vc_column_text]We then turned over the book together, and I endeavored to explain to him the purpose of the printing, and the meaning of the few pictures that were in all day long.[/vc_column_text][/vc_column][vc_column css_animation="hook_fade_waypoint" css_delay="1100" width="1/3"][prkwp_spacer size="36" el_class="show_later"][vc_tta_accordion active_section="1" numbers_acc=" hook_numbered" collapsible_all="true"][vc_tta_section title="Why We Are Awesome" tab_id="1474539614863-1808fba7-886a"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Will Enjoy Hook" tab_id="1474539614943-55775924-ba45"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Be Brave" tab_id="1474539824755-0f65d0e3-e78f"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why Being Cool Is Fun" tab_id="1474556124940-a37fef92-e779"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][vc_tta_section title="Why You Should Start Now" tab_id="1474556120842-149a6748-c761"][vc_column_text]At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Marys front, but with his head bowed away from him. While near by, from the arched and overhanging rigging.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][/vc_row][vc_row top_padding="148px" bottom_padding="140px" bk_element="image" bg_image_repeat="hook_cover_top" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/1"][prk_wp_theme_button type="colored_theme_button" prk_in="BUY HOOK THEME →" link="https://themeforest.net/item/hook-superior-wordpress-theme/16278811?ref=Pirenko" window="Yes" css_animation="flipin_x" css_delay="200"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');


            //CREATE THE MULTIPAGE MENU
            $post_for_menu=get_post($new_page_id);
            $page_slug=site_url().'/'.$post_for_menu->post_name;

            //APPEND NUMBER TO MENU IF NEEDED
            if(is_numeric(substr($page_slug, -1))) {
                $mn_name=$multipage_name.' '.substr($page_slug, -1);
            }
            else {
                $mn_name=$multipage_name;
            }
            $mn_menu_out=wp_create_nav_menu($mn_name);
            $mn_menu_id=get_term_by( 'name', $mn_name, 'nav_menu' );

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'HOME',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - About Us';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="TALENTED FOLKS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Satisfy our customer desires with elegance.<br />This is our starting point on all projects." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="GIVING LIFE TO YOUR IDEAS" font_weight="600" title_size="h4" margin_bottom="18px"][vc_column_text]The boat was now all but jammed between two vast black bulks, leaving a narrow Dardanelles between their long lengths. But by desperate endeavor we at last shot into a temporary opening; then giving way rapidly, and at the same time earnestly watching.<br />After many similar hair-breadth escapes, we at last swiftly glided into what had just been one of the outer circles, but now crossed by random whales, all violently making for one centre. This lucky salvation was cheaply purchased by the loss of Queequeg’s hat, who, while standing in the bows to prick the fugitive whales, had his hat taken clean from his head by the air-eddy.[/vc_column_text][vc_single_image image="'.$signa_image.'" img_size="full" css_animation="hook_fade_waypoint" retina_image="yes"][prkwp_spacer size="108"][/vc_column][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3" bg_color="#12b2cb"][prkwp_spacer size="108"][prkwp_styled_title prk_in="STANDING OUT" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="18px"][vc_column_text]<span style="color: #ffffff;">At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by and then renewed their onward flight with augmented fleetness.</span><span style="color: #ffffff;">From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.</span>[/vc_column_text][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row bk_type="hook_full_row"][vc_column width="1/1"][prk_members member_spacing="ft_mode" items_number="6" text_align="hook_left_align" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column col_width="80" css_animation="hook_fade_waypoint" width="1/3" bg_color="#12b2cb"][prkwp_spacer size="108"][prkwp_styled_title prk_in="OUR MANIFESTO" font_weight="600" text_color="#ffffff" title_size="h4" margin_bottom="18px"][vc_column_text]<span style="color: #ffffff;">At the base of the mainmast, full beneath the doubloon and the flame, the Parsee was kneeling in Ahabs front, but with his head bowed away from him while near by and then renewed their onward flight with augmented fleetness.</span><span style="color: #ffffff;">From the arched and overhanging rigging, where they had just been engaged securing a spar, a number of the seamen, arrested by the glare, now cohered together, and hung pendulous, like a knot of numbed wasps from a drooping.</span>[/vc_column_text][prkwp_spacer size="108"][/vc_column][vc_column align="hook_left_align" col_width="80" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="108"][prkwp_styled_title prk_in="WE ARE SKILLED" font_weight="600" title_size="h4" margin_bottom="18px"][vc_progress_bar values="%5B%7B%22label%22%3A%22Branding%22%2C%22value%22%3A%2280%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2312b2cb%22%2C%22customtxtcolor%22%3A%22%2312b2cb%22%7D%2C%7B%22label%22%3A%22Video%20Edition%22%2C%22value%22%3A%2290%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2312b2cb%22%2C%22customtxtcolor%22%3A%22%2312b2cb%22%7D%2C%7B%22label%22%3A%22E-Commerce%22%2C%22value%22%3A%2295%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2312b2cb%22%2C%22customtxtcolor%22%3A%22%2312b2cb%22%7D%2C%7B%22label%22%3A%22Photography%22%2C%22value%22%3A%2275%22%2C%22color%22%3A%22custom%22%2C%22customcolor%22%3A%22%2312b2cb%22%2C%22customtxtcolor%22%3A%22%2312b2cb%22%7D%5D" margin_bottom_barra="50px" units="%"][prkwp_spacer size="108"][/vc_column][/vc_row][vc_row top_padding="108px" bottom_padding="108px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" bg_color="#04406d" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT FEEDBACK" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="18px" css_animation="hook_fade_waypoint"][vc_row_inner][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center;">From the vibrating line extending the entire length of the upper part of the boat, and from its now being more tight than a harpstring, you would have thought the craft had two keels.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][prkwp_spacer size="36"][prk_testimonials category="" color="#ffffff" nav_color=" hook_btn_like hook_texty" css_animation="hook_fade_waypoint" el_class="hook_retina"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'ABOUT US',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            //ADD THE BLOG PARENT BUTTON TO THE MENU
            $menu =
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => '#',
                    'menu-item-title' => 'BLOG',
                    'menu-item-status' => 'publish'
                );
            $parent_button=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $menu );

            $new_page_title=$multipage_name.' - Blog - Masonry';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SHARING THOUGHTS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'masonry');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Masonry Blog',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Blog - Image Grid';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SHARING THOUGHTS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'grid');
            add_post_meta($new_page_id, 'grid_layout', 'squares');
            add_post_meta($new_page_id, 'limit_width', '0');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'ajaxed');
            add_post_meta($new_page_id, 'show_filter', '0');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Image Grid Blog',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Blog - Classic';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SHARING THOUGHTS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'yes');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'classic');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'paginated');
            add_post_meta($new_page_id, 'show_filter', '0');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Classic Blog',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Blog - Plain Text';
            $new_page_content='[vc_row top_padding="256px" bottom_padding="256px" margin_bottom="0px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"]["][vc_column width="1/1"][prkwp_styled_title prk_in="SHARING THOUGHTS" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A Collection of Bits and Bytes that will make your day.<br />New articles will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //BLOG
            add_post_meta($new_page_id, 'blog_layout', 'stacked');
            add_post_meta($new_page_id, 'limit_width', '1');
            add_post_meta($new_page_id, 'blog_filter', '');
            add_post_meta($new_page_id, 'hide_title', '1');
            add_post_meta($new_page_id, 'navigation_type', 'paginated');
            add_post_meta($new_page_id, 'show_filter', '0');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');
            add_post_meta($new_page_id, 'grid_align', 'hook_center_align');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Plain Text Blog',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            //ADD THE PORTFOLIO PARENT BUTTON TO THE MENU
            $menu =
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => '#',
                    'menu-item-title' => 'PORTFOLIO',
                    'menu-item-status' => 'publish'
                );
            $parent_button=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $menu );


            $new_page_title=$multipage_name.' - Portfolio - Squared And No Header';
            $new_page_content='';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'squares');
            add_post_meta($new_page_id, 'limited_width', '0');
            add_post_meta($new_page_id, 'items_number', '6');
            add_post_meta($new_page_id, 'cols_number', '3');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '0');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');
            add_post_meta($new_page_id, 'thumbs_mg', '0');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'classiqued');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Squared And No Header',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Portfolio - Multi-width And Wide';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR WORK" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A collection of bits and bytes that will make your day.<br />New work will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'packery');
            add_post_meta($new_page_id, 'limited_width', '0');
            add_post_meta($new_page_id, 'items_number', '6');
            add_post_meta($new_page_id, 'cols_number', '4');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '0');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');
            add_post_meta($new_page_id, 'thumbs_mg', '0');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'classiqued');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Multi-width And Wide',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Portfolio - Masonry And Lightbox';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" margin_bottom="22px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR WORK" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A collection of bits and bytes that will make your day.<br />New work will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'masonry');
            add_post_meta($new_page_id, 'limited_width', '0');
            add_post_meta($new_page_id, 'items_number', '6');
            add_post_meta($new_page_id, 'cols_number', '4');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_right');
            add_post_meta($new_page_id, 'thumbs_mg', '20');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'lightboxed');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Masonry And Lightbox',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Portfolio - Titles Under And Contained';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" margin_bottom="22px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="OUR WORK" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="A collection of bits and bytes that will make your day.<br />New work will be posted every week." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);
            update_post_meta($new_page_id, "_wp_page_template", "page-portfolio.php");

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //PORTFOLIO
            add_post_meta($new_page_id, 'portfolio_layout', 'grid');
            add_post_meta($new_page_id, 'limited_width', '1');
            add_post_meta($new_page_id, 'items_number', '6');
            add_post_meta($new_page_id, 'cols_number', '3');
            add_post_meta($new_page_id, 'cat_filter', '');
            add_post_meta($new_page_id, 'show_filter', '1');
            add_post_meta($new_page_id, 'filter_align', 'filter_center');
            add_post_meta($new_page_id, 'thumbs_mg', '20');
            add_post_meta($new_page_id, 'multicolored_thumbs', '0');
            add_post_meta($new_page_id, 'thumbs_type_folio', 'classiqued');
            add_post_meta($new_page_id, 'hook_show_skills', 'folio_always_title_and_skills');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'Titles Under And Contained',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


            $new_page_title=$multipage_name.' - Shop';
            $new_page_content='[vc_row top_padding="72px" bottom_padding="72px" el_id="about"][vc_column width="1/1"][prkwp_styled_title prk_in="RECENT PRODUCTS" align="Center" font_weight="600" title_size="h2" margin_bottom="26px" hook_show_line="thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][prkwp_spacer size="26"][prk_woo_featured order_by="date" items_number="8" columns="4" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="168px" bottom_padding="168px" bk_element="image" bg_image_repeat="hook_cover" align="hook_center_align" bg_image="'.$row_image.'"][vc_column width="1/6"][/vc_column][vc_column css_animation="bottom-to-top" width="2/3"][prkwp_styled_title prk_in="WORLDWIDE SHIPMENTS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint"]<p style="text-align: center; color: #ffffff;">We had completed these arrangements for our protection after leaving Phutra when the Sagoths who had been sent to recapture the escaped prisoners returned with four of them, of whom Hooja was one. Dian and two others had eluded them. It so happened that Hooja was confined.</p>[/vc_column_text][prkwp_spacer size="24"][prk_wp_theme_button type="colored_theme_button" button_size="prk_medium" prk_in="MORE INFO" link="http://themeforest.net/item/hook-premier-wordpress-theme/12407534?ref=Pirenko" css_animation="hook_fadeInUpBig" custom_css="margin:0px;" el_class="delay-200"][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row top_padding="136px" bottom_padding="128px" bg_color="#f9f9f9"][vc_column width="1/1"][vc_row_inner anchor_id="selling_row"][vc_column_inner width="1/4" css_animation="bottom-to-top"][prkwp_styled_title prk_in="BEST SELLERS" font_weight="600" title_size="h5" margin_bottom="15px" hook_show_line="like_sidebar"][prk_woo_widget items_number="3"][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-200"][prkwp_styled_title prk_in="ON SALE" font_weight="600" title_size="h5" margin_bottom="15px" hook_show_line="like_sidebar"][prk_woo_widget order_by="sale_only" items_number="3"][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-400"][prkwp_styled_title prk_in="TOP RATED" font_weight="600" title_size="h5" margin_bottom="15px" hook_show_line="like_sidebar"][prk_woo_widget order_by="rating" items_number="3"][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-600"][prkwp_styled_title prk_in="SPOTLIGHT" font_weight="600" title_size="h5" margin_bottom="15px" hook_show_line="like_sidebar"][vc_single_image image="8685" img_size="300x300" onclick="custom_link" img_link="" link="http://www.pirenko-themes.com/hook/fulldemo/product/moonshine-t-shirt/"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_padding="90px" bottom_padding="72px" bk_element="image" bg_image_repeat="hook_with_parallax hook_attached" el_class="hook_retina" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="CUSTOMER REVIEWS" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="16px" css_animation="hook_fade_waypoint"][vc_column_text css_animation="hook_fade_waypoint" el_class="small-10 columns small-centered"]<p style="text-align: center;"><span style="color: #ffffff;">Over the last years we have received mostly good feedback which always makes us aim for greatness.<br />Here are just some of the encouraging words that make us feel good.</span>[/vc_column_text][prkwp_spacer size="58"][prk_testimonials category="" align="Center" color="#ffffff" css_animation="hook_fade_waypoint"][/vc_column][/vc_row][vc_row top_padding="72px" bottom_padding="72px" bk_element="colored" el_class="grey_lines"][vc_column width="1/1"][prkwp_styled_title prk_in="FROM OUR BLOG" align="Center" font_weight="600" title_size="h2" margin_bottom="26px" hook_show_line="thick" line_color="#12b2cb" css_animation="hook_fade_waypoint"][prkwp_spacer size="34"][pirenko_last_posts cat_filter="" items_number="3" css_animation="hook_fade_waypoint"][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'yes');
            add_post_meta($new_page_id, 'featured_slider_anim', 'fadeUp');
            add_post_meta($new_page_id, 'featured_slider_supersize', '1');
            add_post_meta($new_page_id, 'featured_slider_parallax', '0');
            add_post_meta($new_page_id, 'featured_slider_arrows', '1');
            add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
            add_post_meta($new_page_id, 'featured_arrow_color', '#FFFFFF');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');

            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'SHOP',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            //ADD THE CONTACT PARENT BUTTON TO THE MENU
            $menu =
                array(
                    'menu-item-type' => 'custom',
                    'menu-item-url' => '#',
                    'menu-item-title' => 'CONTACT US',
                    'menu-item-status' => 'publish'
                );
            $parent_button=wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $menu );

            $new_page_title=$multipage_name.' - Contact Page With Image';
            $new_page_content='[vc_row top_padding="196px" bottom_padding="196px" bk_element="image" bg_image_repeat="hook_with_parallax hook_cover" el_class="limited_pad_row" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="LETS GET TOGETHER" align="Center" font_weight="700" text_color="#ffffff" title_size="h1" margin_bottom="6px"][prkwp_styled_title prk_in="Reach us with ease and place your enquiries.<br />Would love to hear from you." align="Center" font_weight="400" text_color="#ffffff" title_size="h5"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="HIT US WITH SOMETHING" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.</p>[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="72"][prkwp_styled_title prk_in="CONTACT INFO" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.</p>[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'With Image',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

            $new_page_title=$multipage_name.' - Contact Page With Map';
            $new_page_content='[vc_row bk_type="hook_full_row"][vc_column width="1/1"][vc_gmaps map_style="theme_special_dk" zoom="14" marker_image="2618" map_latitude="40.7000" map_longitude="-73.94000" size="524"][/vc_column][/vc_row][vc_row bk_type="hook_full_row" equal_height="yes"][vc_column align="hook_right_align" col_width="70" css_animation="hook_fade_waypoint" width="2/3"][prkwp_spacer size="72"][prkwp_styled_title prk_in="HIT US WITH SOMETHING" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">The try-works are planted between the foremast and mainmast, the most roomy part of the deck. The timbers beneath are of a peculiar strength, fitted to sustain the weight of an almost solid mass of brick and mortar, some ten feet by eight square. The strong vapor now completely filling.</p>[/vc_column_text][prkwp_spacer][prk_contact_form email_adr="something@mail.com"][prkwp_spacer size="66"][/vc_column][vc_column col_width="70" css_animation="hook_fade_waypoint" column_height="hook_forced_clm" width="1/3" bg_color="#f2f2f2"][prkwp_spacer size="72"][prkwp_styled_title prk_in="CONTACT INFO" font_weight="600" title_size="h4" margin_bottom="10px"][prk_line color="#e2e2e2"][prkwp_spacer size="14"][vc_column_text]<p style="text-align: left;">He was going on with some wild reminiscences about his life. They could not stop looking into that beautiful sunset.</p>[/vc_column_text][prkwp_spacer][pirenko_contact_info company_name="Hook Company" street_address="River Street, Blue Building" postal_code="5690-970 New York City" tel="+1 234 567 890" email="hello@hook.com"][/pirenko_contact_info][prkwp_spacer size="66"][/vc_column][/vc_row][vc_row top_padding="144px" bottom_padding="144px" font_color="#ffffff" bk_element="image" bg_image_repeat="hook_cover" bg_image="'.$row_image.'"][vc_column width="1/1"][prkwp_styled_title prk_in="SUBSCRIBE OUR NEWSLETTER" align="Center" font_weight="600" text_color="#ffffff" title_size="h3" margin_bottom="8px" css_animation="hook_fade_waypoint"][vc_row_inner bottom_padding="20px"][vc_column_inner width="1/6"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css_animation="hook_fade_waypoint" el_class="prk_9_em"]<p style="text-align: center;">After a while, finding that nothing more happened, she decided on going into the garden at once, but, alas for poor Alice. When she got to the door, she found she had forgotten the little golden key, and when she went back.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text css_animation="hook_fade_waypoint" el_class="hook_button_in"]MailChimp Form Shortcode Goes Here. Check theme documentation for examples.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

            $new_page=array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
            );
            $new_page_id=wp_insert_post($new_page);

            //PAGES
            add_post_meta($new_page_id, 'below_headings_text', '');
            add_post_meta($new_page_id, 'show_title', 'no');
            add_post_meta($new_page_id, 'featured_slider', 'no');
            add_post_meta($new_page_id, 'show_sidebar', 'no');
            add_post_meta($new_page_id, 'featured_header', '1');


            //COMMON
            add_post_meta($new_page_id, 'hide_footer', '0');

            //ADD THE PAGE CUSTOM MENU
            $mn_item=
                array(
                    'menu-item-title' => 'With Map',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $new_page_id,
                    'menu-item-position' => 0,
                    'menu-item-parent-id' => $parent_button,
                );
            wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        }

        //RESET OPTIONS
        $hook_theme_activation_options=array(
            'generate_content'  => false,
            'bold-startup'  => '',
            'pure-business'  => '',
            'coming'  => '',
            'stylish-showcase'  => '',
            'photography-studio'  => '',
            'modern-agency'  => '',
            'creative-agency'  => '',
            'real-estate'  => '',
            'vcard-musician'  => '',
            'agency-dark'  => '',
            'agency-bright'  => '',
            'full-demo'  => '',
            'app-landing-page'  => '',
            'architecture' => '',
            'featured-portfolio'  => '',
            'logistics'  => '',
            'alternative-portfolio' => '',
            'event'  => '',
            'rtl'  => '',
            'pulse-agency'  => '',
            'single-product-sale' => '',
            'vcard-business'  => '',
            'consultancy' => '',
        );
        update_option('hook_theme_activation_options', $hook_theme_activation_options);
        wp_redirect( admin_url('edit.php?post_type=page&prk_gen=true') );
        exit;

    }//ONE CLICK CONTENT
    //RESET OPTIONS
    $hook_theme_activation_options=array(
        'generate_content'  => false,
        'bold-startup'  => '',
        'pure-business'  => '',
        'coming'  => '',
        'stylish-showcase'  => '',
        'photography-studio'  => '',
        'modern-agency'  => '',
        'creative-agency'  => '',
        'real-estate'  => '',
        'vcard-musician'  => '',
        'agency-dark'  => '',
        'agency-bright'  => '',
        'full-demo'  => '',
        'app-landing-page'  => '',
        'architecture' => '',
        'featured-portfolio'  => '',
        'logistics'  => '',
        'alternative-portfolio' => '',
        'event'  => '',
        'rtl'  => '',
        'pulse-agency'  => '',
        'single-product-sale' => '',
        'vcard-business'  => '',
        'consultancy' => '',
    );
    update_option('hook_theme_activation_options', $hook_theme_activation_options);

}

//CUSTOM ADMIN NOTICE
function pirenko_tools_admin_notice() {
    $screen = get_current_screen();
    if ($screen->id === 'edit-page') {
        if (isset($_GET['prk_gen'])) {
            if ($_GET['prk_gen'] === 'true') : ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e('Good news! Your content was successfully generated.', 'hook'); ?></p>
                </div>
            <?php endif;
        }
    }
}
add_action('admin_notices', 'pirenko_tools_admin_notice');

if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'theme_activation_options') {
    add_action('admin_init','hook_theme_activation_action');
}

function hook_deactivation_action() {
    update_option('hook_theme_activation_options', hook_get_default_theme_activation_options());
}

add_action('switch_theme', 'hook_deactivation_action');