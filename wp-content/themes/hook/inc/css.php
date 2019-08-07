<?php
if (!function_exists('hook_scripts')) {
    function hook_scripts()
    {
        $prk_hook_options = hook_options();
        $prk_select_font_options = hook_fonts();
        $hook_retina_device = hook_retiner(false);

        //CSS ENQUEUE
        wp_enqueue_style('hook_main_style', get_template_directory_uri() . '/css/main.css', false, HOOK_VERSION);
        if (is_child_theme()) {
            if (function_exists('wp_get_theme'))
                $prk_theme = wp_get_theme();
            else {
                $prk_theme->Version = "1";
            }
            wp_enqueue_style('hook_child_styles', get_stylesheet_directory_uri() . '/style.css', false, $prk_theme->Version);
        }
        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        //LOAD SCRIPT
        wp_enqueue_script('hook_main', get_template_directory_uri() . '/js/main-min.js', array('jquery'), HOOK_VERSION, true);
        wp_localize_script('hook_main', 'ajax_var', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce'),
        ));

        //FONT MANAGEMENT
        $hook_options = $prk_hook_options;
        foreach ($prk_select_font_options as $option_header) {
            if ($prk_hook_options['header_font'] == $option_header['value']) {
                $hook_options['header_font'] = $option_header;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options != "") {
            foreach ($prk_font_options as $font) {
                if ($font['erased'] == "false") {
                    if (!is_array($hook_options['header_font']) && strpos($hook_options['header_font'], '&') !== false) {
                        $compare_a = strtok($hook_options['header_font'], '&');
                    } else {
                        $compare_a = $hook_options['header_font'];
                    }
                    if (strpos($font['value'], '&') !== false) {
                        $compare_b = strtok($font['value'], '&');
                    } else {
                        $compare_b = $font['value'];
                    }
                    if ($compare_a === $compare_b) {
                        $hook_options['header_font'] = $font;
                    }
                }
            }
        }
        foreach ($prk_select_font_options as $option_body) {
            if ($prk_hook_options['body_font'] == $option_body['value']) {
                $hook_options['body_font'] = $option_body;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options != "") {
            foreach ($prk_font_options as $font) {
                if ($font['erased'] == "false") {
                    if (!is_array($hook_options['body_font']) && strpos($hook_options['body_font'], '&') !== false) {
                        $compare_a = strtok($hook_options['body_font'], '&');
                    } else {
                        $compare_a = $hook_options['body_font'];
                    }
                    if (strpos($font['value'], '&') !== false) {
                        $compare_b = strtok($font['value'], '&');
                    } else {
                        $compare_b = $font['value'];
                    }
                    if ($compare_a === $compare_b) {
                        $hook_options['body_font'] = $font;
                    }
                }
            }
        }
        foreach ($prk_select_font_options as $option_custom) {
            if ($prk_hook_options['custom_font'] == $option_custom['value']) {
                $hook_options['custom_font'] = $option_custom;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options != "") {
            foreach ($prk_font_options as $font) {
                if ($font['erased'] == "false") {
                    if (!is_array($hook_options['custom_font']) && strpos($hook_options['custom_font'], '&') !== false) {
                        $compare_a = strtok($hook_options['custom_font'], '&');
                    } else {
                        $compare_a = $hook_options['custom_font'];
                    }
                    if (strpos($font['value'], '&') !== false) {
                        $compare_b = strtok($font['value'], '&');
                    } else {
                        $compare_b = $font['value'];
                    }
                    if ($compare_a === $compare_b) {
                        $hook_options['custom_font'] = $font;
                    }
                }
            }
        }

        //FONTS
        $hook_font_families = array();
        //HEADER FONT
        if ($hook_options['header_font']['hosted'] == 'google') {
            $hook_font_families[] = str_replace('+', ' ', $hook_options['header_font']['value']);
        }
        if ($hook_options['header_font']['hosted'] == 'theme') {
            wp_enqueue_style('prk_header_font', get_template_directory_uri() . '/inc/fonts/' . $hook_options['header_font']['value'] . '/stylesheet.css', false, HOOK_VERSION);
        }
        if ($hook_options['header_font']['hosted'] == 'plugin') {
            wp_enqueue_style('prk_header_font', $hook_options['header_font']['value'], false, HOOK_VERSION);
        }
        //BODY FONT
        if ($hook_options['body_font']['hosted'] == 'google') {
            $hook_font_families[] = str_replace('+', ' ', $hook_options['body_font']['value']);
        }
        if ($hook_options['body_font']['hosted'] == 'theme') {
            wp_enqueue_style('prk_body_font', get_template_directory_uri() . '/inc/fonts/' . $hook_options['body_font']['value'] . '/stylesheet.css', false, HOOK_VERSION);
        }
        if ($hook_options['body_font']['hosted'] == 'plugin') {
            wp_enqueue_style('prk_body_font', $hook_options['body_font']['value'], false, HOOK_VERSION);
        }
        //EXTRA FONT
        if ($hook_options['custom_font'] != "") {
            if ($hook_options['custom_font']['hosted'] == 'google') {
                $hook_font_families[] = str_replace('+', ' ', $hook_options['custom_font']['value']);
            }
            if ($hook_options['custom_font']['hosted'] == 'theme') {
                wp_enqueue_style('prk_custom_font', get_template_directory_uri() . '/inc/fonts/' . $hook_options['custom_font']['value'] . '/stylesheet.css', false, HOOK_VERSION);
            }
            if ($hook_options['custom_font']['hosted'] == 'plugin') {
                wp_enqueue_style('prk_custom_font', $hook_options['custom_font']['value'], false, HOOK_VERSION);
            }
        }
        if (!empty($hook_font_families)) {
            $query_args = array(
                'family' => urlencode(implode('|', $hook_font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
            $fonts_url = esc_url_raw($fonts_url);
            wp_enqueue_style('hook_google_fonts', $fonts_url, array(), null);
        }

        $prk_hook_options['active_visual_composer'] = HOOK_VC_ON;

        if (HOOK_FRAMEWORK_ON) {
            $prk_hook_options['sharrre_dir_prk'] = plugins_url("hook_framework");
        } else {
            $prk_hook_options['sharrre_dir_prk'] = "";
        }
        if (!isset($prk_hook_options['active_skin'])) {
            $prk_hook_options['active_skin'] = '';
        }

        //SEND THEME OPTIONS TO MAIN SCRIPT
        wp_localize_script('hook_main', 'theme_options', $prk_hook_options);

        //CONVERT COLORS FOR CSS
        $hook_spl_bk_menu_bar = hook_html2rgba($hook_options['background_color_menu_bar'], $hook_options['header_default_opacity']);
        $hook_spl_bk_menu_bar_after = hook_html2rgba($hook_options['background_color_menu_bar_after'], $hook_options['header_opacity_after']);
        $hook_spl_bk_menu_overlay = hook_html2rgba($hook_options['bk_color_menu_overlay'], $hook_options['opacity_menu_overlay']);
        $hook_spl_background_color_btns = hook_html2rgba($hook_options['background_color_btns'], $hook_options['custom_opacity_folio']);
        $hook_spl_active_inputs = hook_html2rgba($hook_options['active_color'], 65);
        $hook_spl_active_inputs_bk = hook_html2rgba($hook_options['background_color'], 95);
        $hook_spl_bd_smallers_color = hook_html2rgba($hook_options['bd_smallers_color'], 15);
        $hook_spl_spinner_color = hook_html2rgba($hook_options['bd_headings_color'], 30);
        $hook_spl_spinner_color_over = hook_html2rgba($hook_options['headings_color_overlayer'], 30);
        $hook_spl_body_color_footer = hook_html2rgba($hook_options['body_color_footer'], 20);
        $hook_spl_body_color_sidebar = hook_html2rgba($hook_options['body_color_sidebar'], 20);
        $hook_spl_body_color_right_bar = hook_html2rgba($hook_options['body_color_right_bar'], 12);
        $hook_spl_bk_sidebar_overlay = hook_html2rgba($hook_options['bk_color_sidebar_overlay'], $hook_options['opacity_sidebar_overlay']);
        $hook_spl_bk_mobile_overlay = hook_html2rgba($hook_options['bk_color_sidebar_overlay'], $hook_options['opacity_mobile_overlay']);
        $hook_spl_inputs_bordercolor = hook_html2rgba($hook_options['inputs_bordercolor'], 40);
        $hook_spl_lines_bordercolor = hook_html2rgba($hook_options['lines_color'], 30);
        $hook_spl_inactive_color = hook_html2rgba($hook_options['inactive_color'], 7);


        //ADD STYLES ACCORDING TO THE THEME OPTIONS
        $hook_css_build = "";

        //BACKGROUND IMAGES
        if ($hook_options['background_image_sidebar']['url'] = !"") {
            $bar_image = wp_get_attachment_image_src($hook_options['background_image_sidebar']['id'], 'full');
            $hook_css_build .= "#prk_hidden_bar {background-image: url(" . esc_url($bar_image['0']) . ");}";
        }
        if ($hook_options['background_image_right_bar']['url'] = !"") {
            $bar_image = wp_get_attachment_image_src($hook_options['background_image_right_bar']['id'], 'full');
            $hook_css_build .= "#prk_mobile_bar {background-image: url(" . esc_url($bar_image['0']) . ");}";
        }

        //FONTS
        $hook_css_build .= "html {font-size:" . $hook_options['font_size'] . "px;}";
        $hook_css_build .= "body,.regular_font,input,textarea {font-family:" . $hook_options['body_font']['css'] . ";}";
        $hook_css_build .= "#calendar_wrap caption,.header_font,.sod_select,.vc_tta-tabs-list,.vc_tta-accordion .vc_tta-panel-heading {font-family:" . $hook_options['header_font']['css'] . ";}";
        if ($hook_options['uppercase_blog_headings'] == "1") {
            $hook_css_build .= ".hook_blog_uppercased {text-transform:uppercase;}";
        }
        if ($hook_options['uppercase_folio_headings'] == "1") {
            $hook_css_build .= ".hook_folio_uppercased {text-transform:uppercase;}";
        }
        if ($hook_options['custom_font'] != "") {
            $hook_css_build .= ".custom_font,.custom_font .header_font,.custom_font.header_font,.extra_font,.custom_font .extra_font,.custom_font.extra_font {font-style:" . $hook_options['custom_font_style'] . ";font-family:" . $hook_options['custom_font']['css'] . "}";
            if ($hook_options['buttons_font'] == "custom_f") {
                $hook_css_build .= ".colored_theme_button,.theme_button,.colored_theme_button input,.theme_button input,.ghost_theme_button,.vc_btn,.prk_button_like {font-style:" . $hook_options['custom_font_style'] . ";font-family:" . $hook_options['custom_font']['css'] . "}";
            }
            if ($hook_options['main_subheadings_font'] == "custom_font") {
                $hook_css_build .= "#single_meta_header .special_heading,#single_blog_meta.header_font,#single_blog_meta .header_font,#single_blog_meta .pir_divider {font-style:" . $hook_options['custom_font_style'] . ";font-family:" . $hook_options['custom_font']['css'] . "}";
            }
        }
        if ($hook_options['buttons_font'] == "headings_f") {
            $hook_css_build .= ".colored_theme_button,.theme_button,.colored_theme_button input,.theme_button input,.ghost_theme_button,.vc_btn,.prk_button_like {
                font-family:" . $hook_options['header_font']['css'] . ";}";
        }
        $hook_css_build .= ".hook_drop_cap>div>p:first-child::first-letter {font-size:" . $hook_options['drop_caps_size'] . "px;}";

        //WIDTH SET MANAGEMENT
        $adjusted_width = $prk_hook_options['custom_width'] + 36 * 2;
        $hook_css_build .= "#hook_comments,.prk_inner_block,.woocommerce-notices-wrapper
         {max-width: " . $adjusted_width . "px;}";
        $hook_css_build .= ".blog_limited_width {max-width: " . $hook_options['custom_width_blog'] . "px;}";

        //MENU MANAGEMENT
        $hook_css_build .= "#hook_header_background,#hook_header_inner,#hook_header_inner>div,#hook_main_menu .hook-mn>li,#hook_main_menu,#hook_side_menu,#hook_mm_inner {height:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= "#hook_main_menu .hook-mn>li>a {height:" . $hook_options['menu_vertical'] . "px;line-height:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= ".prk_menu_sized,.hook-mn {font-style:" . $hook_options['menu_parent_style'] . ";letter-spacing:" . $hook_options['menu_spacing'] . "px;}";
        $hook_css_build .= ".prk_menu_sized>li>a,.hook-mn>li>a {font-weight:" . $hook_options['menu_font_weight'] . ";font-size:" . $hook_options['menu_font_size'] . "px;}";
        $hook_css_build .= ".mobile-menu-ul {font-weight:" . $hook_options['menu_font_weight'] . ";}";
        $hook_css_build .= "#hook_main_menu .hook-mn>li>a .hook_menu_main {margin-top:" . $hook_options['labels_offset'] . "px;}";
        $hook_css_build .= ".hook-mn>li>a,#prk_menu_loupe,#menu_social_nets>a,#hook_extra_bar,#hook_extra_bar ul>li a,#hook_extra_bar ul>li a:hover {color:" . $hook_options['menu_up_color'] . ";}";
        $hook_css_build .= ".hook-mn>li>a:hover,#prk_menu_loupe:hover,#menu_social_nets>a:hover,.hook-mn>li.active>a {color:" . $hook_options['menu_active_color'] . ";}";
        $hook_css_build .= ".hook-mn .sub-menu {border: 1px solid " . $hook_options['submenu_lines_color'] . ";}";
        $hook_css_build .= ".hook-mn .sub-menu li {border-bottom: 1px solid " . $hook_options['submenu_lines_color'] . ";}";
        $hook_css_build .= ".hook-mn .sub-menu li a {font-weight:" . $hook_options['submenu_font_weight'] . ";font-size:" . $hook_options['submenu_font_size'] . "px;height:" . $hook_options['menu_sub_padding'] . "px;line-height:" . $hook_options['menu_sub_padding'] . "px;color:" . $hook_options['submenu_text_color'] . ";background-color:" . $hook_options['submenu_background_color'] . "}";
        $hook_css_build .= ".hook-mn>li.hook_actionized>a:hover:after {background-color:" . $hook_options['menu_up_color'] . ";}";
        $hook_css_build .= "#hook_main_menu .hook_hover_sub.menu-item-has-children>a:before {background-color: " . $hook_options['submenu_active_color'] . ";}";
        $hook_css_build .= ".hook-mn .sub-menu li>a:hover {color:" . $hook_options['submenu_active_color'] . ";}";
        $hook_css_build .= ".hook_menu_sub {font-style:" . $hook_options['menu_subheadings_style'] . ";font-weight:" . $hook_options['subheadings_font_weight'] . ";font-size:" . $hook_options['subheadings_font_size'] . "px;top:" . $hook_options['subheadings_offset'] . "px;color:" . $hook_options['subheadings_color'] . ";}";
        $hook_css_build .= ".hook_forced_menu #hook_ajax_container {margin-top:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= "#hook_header_background {background-color: " . $hook_options['background_color_menu_bar'] . ";background-color:$hook_spl_bk_menu_bar;;}";
        $hook_css_build .= "#hook_logos_wrapper {margin-top:" . $hook_options['logo_top_margin'] . "px;}";
        $hook_css_build .= ".prk_menu_block {background-color: " . $hook_options['menu_up_color'] . ";}";
        $hook_css_build .= "#prk_sidebar_trigger.hover_trigger .prk_menu_block {background-color: " . $hook_options['menu_active_color_after'] . ";}";
        $menu_height_dif = ceil(($hook_options['menu_vertical'] - $hook_options['collapsed_menu_vertical']) / 2);
        $menu_height_dif += $hook_options['logo_collapsed_top_margin'];
        $hook_css_build .= ".hook_forced_menu #hook_logos_wrapper {margin-top:" . $menu_height_dif . "px;}";
        $hook_css_build .= ".hook_hide_nav #hook_header_section,.hook_hide_nav #hook_header_background {margin-top:-" . $hook_options['menu_vertical'] . "px;}";
        $above_four = $hook_options['menu_vertical'] + 36;
        $hook_css_build .= "#hook_content.hook_error404 {padding-top: " . $above_four . "px;}";
        $hook_css_build .= "#menu_social_nets {margin-top: " . $hook_options['nets_offset'] . "px;}";
        $hook_menu_half = ceil($hook_options['menu_vertical'] / 2);
        $hook_css_build .= "#prk_blocks_wrapper {top:" . $hook_menu_half . "px;}";
        if ($hook_options['menu_display'] == 'st_hidden_menu') {
            $hook_css_build .= ".prk_popper_menu a {line-height:" . $hook_options['menu_line_height'] . "px;}";
        }
        if ($hook_options['menu_align'] == 'st_menu_under') {
            $n_height = 0;
            if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url'] != "") {
                $hook_vt_image = vt_resize('', $prk_hook_options['logo']['url'], '', '', false, false);
                $n_before_height = $hook_vt_image['height'] + $prk_hook_options['logo_top_margin'] + $hook_options['menu_vertical'];
                $hook_css_build .= ".hook_forced_menu #hook_header_background, #hook_header_background {height:" . $n_before_height . "px;}";
                $hook_css_build .= ".hook_forced_menu #hook_logos_wrapper {margin-top:" . $hook_options['logo_top_margin'] . "px;}";
                $hook_css_build .= ".hook_forced_menu #hook_ajax_container {margin-top:" . $n_before_height . "px;}";
            }
        }

        //MENU PADDING
        $submenu_pad = 3 * $hook_options['menu_padding'];
        $hook_css_build .= ".hook-mn a {padding-left:" . $hook_options['menu_padding'] . "px;padding-right:" . $hook_options['menu_padding'] . "px;}";
        $hook_css_build .= ".hook-mn .sub-menu a {padding-right:" . $submenu_pad . "px;}";
        $hook_css_build .= ".hook_actionized {padding-left:" . $hook_options['menu_padding'] . "px;}";
        $hook_css_build .= ".st_logo_on_left #hook_logos_wrapper {margin-right:" . (2 * $hook_options['menu_padding']) . "px;}";
        $hook_css_build .= ".st_logo_on_right #hook_logos_wrapper {margin-left:" . (2 * $hook_options['menu_padding']) . "px;}";
        $hook_css_build .= ".st_menu_on_right .hook-mn>li.menu-item-has-children:last-child>a {margin-right:-" . $hook_options['menu_padding'] . "px;}";
        $hook_css_build .= ".st_menu_on_left .hook-mn>li.menu-item-has-children:first-child>a {margin-left:-" . $hook_options['menu_padding'] . "px;}";
        $hook_css_build .= ".st_menu_on_right .hook-mn>li:last-child>a:before {right:-" . $hook_options['menu_padding'] . "px;};";
        $hook_css_build .= ".st_menu_on_left .hook-mn>li:first-child>a:before {left:-" . $hook_options['menu_padding'] . "px;}";

        //MENU AFTER SCROLL
        $hook_css_build .= ".hook_forced_menu #hook_main_menu .hook-mn>li>a,.hook_collapsed_menu#hook_main_menu .hook-mn>li>a,.hook_collapsed_menu#prk_menu_loupe,.hook_forced_menu #prk_menu_loupe,.hook_collapsed_menu#menu_social_nets>a,.hook_forced_menu #menu_social_nets>a {color:" . $hook_options['menu_up_color_after'] . ";}";
        $hook_css_build .= ".hook_forced_menu #hook_main_menu .hook-mn>li>a:hover,.hook_collapsed_menu #hook_main_menu .hook-mn>li>a:hover,.hook_collapsed_menu #prk_menu_loupe:hover,.hook_forced_menu #prk_menu_loupe:hover,.hook_collapsed_menu #menu_social_nets>a:hover,.hook_forced_menu #menu_social_nets>a:hover,.hook_collapsed_menu #hook_main_menu .hook-mn>li.active>a,.hook_forced_menu #hook_main_menu .hook-mn>li.active>a {color:" . $hook_options['menu_active_color_after'] . ";}";

        $hook_css_build .= ".hook_collapsed_menu#hook_header_background,#hook_header_inner.hook_collapsed_menu,.hook_collapsed_menu#hook_header_inner>div,.hook_collapsed_menu#hook_main_menu .hook-mn>li,.hook_collapsed_menu#nav-main,.hook_collapsed_menu#hook_main_menu,.hook_collapsed_menu#hook_side_menu,.menu_at_top #hook_header_background,.menu_at_top #hook_header_inner,.menu_at_top #hook_header_inner>div,.hook_collapsed_menu #hook_mm_inner,.menu_at_top .hook_collapsed_menu#hook_header_background {height:" . $hook_options['collapsed_menu_vertical'] . "px;}";
        $hook_adjust_logo = $hook_options['collapsed_menu_vertical'] - 20;
        $hook_css_build .= ".menu_at_top #hook_logos_wrapper {max-height:" . $hook_options['collapsed_menu_vertical'] . "px;}";
        $hook_css_build .= ".menu_at_top #hook_logo_after img {max-height:" . $hook_adjust_logo . "px;}";
        $hook_css_build .= ".menu_at_top #hook_ajax_container {margin-top: " . $hook_options['collapsed_menu_vertical'] . "px;}";

        $hook_css_build .= ".hook_collapsed_menu#hook_main_menu .hook-mn>li>a {height:" . $hook_options['collapsed_menu_vertical'] . "px;line-height:" . $hook_options['collapsed_menu_vertical'] . "px;}";
        $hook_css_build .= ".hook_forced_menu #hook_header_background, .hook_collapsed_menu#hook_header_background,.menu_at_top #hook_header_background {background-color: " . $hook_options['background_color_menu_bar_after'] . ";background-color:$hook_spl_bk_menu_bar_after;}";
        $hook_css_build .= ".hook_collapsed_menu .prk_menu_block, .hook_forced_menu .prk_menu_block,.menu_at_top .prk_menu_block,.hook_forced_menu #hook_main_menu .hook-mn>li.hook_actionized>a:hover:after,.hook_collapsed_menu #hook_main_menu .hook-mn>li.pls_actionized>a:hover:after {background-color: " . $hook_options['menu_up_color_after'] . ";}";
        $hook_css_build .= ".hook_collapsed_menu #hook_logos_wrapper,.hook_collapsed_menu.hook_forced_menu #hook_logos_wrapper,.menu_at_top #hook_logos_wrapper {margin-top:" . $hook_options['logo_collapsed_top_margin'] . "px;}";
        $hook_css_build .= ".hook_collapsed_menu #prk_sidebar_trigger.hover_trigger .prk_menu_block,.hook_forced_menu #prk_sidebar_trigger.hover_trigger .prk_menu_block {background-color:" . $hook_options['menu_active_color_after'] . "}";
        $hook_menu_half = ceil($hook_options['collapsed_menu_vertical'] / 2);
        $hook_css_build .= ".hook_collapsed_menu #prk_blocks_wrapper,.menu_at_top #prk_blocks_wrapper {top:" . $hook_menu_half . "px;}";
        if ($hook_options['menu_parent_rollover'] == 'with_lines') {
            $hook_css_build .= ".prk_menu_block:after,.hook-mn>li>a .hook_menu_main:before,.hook-mn>li>a .hook_menu_main:after {background-color: " . $hook_options['menu_active_color'] . ";}";
            $hook_css_build .= ".hook_collapsed_menu .prk_menu_block:after, .hook_forced_menu .prk_menu_block:after,.hook_collapsed_menu .hook-mn>li>a .hook_menu_main:before,.hook_collapsed_menu .hook-mn>li>a .hook_menu_main:after, .hook_forced_menu .hook-mn>li>a .hook_menu_main:before,.hook_forced_menu .hook-mn>li>a .hook_menu_main:after, .menu_at_top .prk_menu_block:after {background-color: " . $hook_options['menu_active_color_after'] . ";}";
        }

        if ($hook_options['menu_align'] == 'st_menu_under') {
            $hook_css_build .= "#prk_sidebar_trigger {margin-left:" . $hook_options['menu_padding'] . "px;}#prk_menu_loupe{margin-left:" . $hook_options['menu_padding'] . "px;}";
            if (isset($prk_hook_options['logo_collapsed']) && $prk_hook_options['logo_collapsed']['url'] != "") {
                $hook_vt_image = vt_resize('', $prk_hook_options['logo_collapsed']['url'], '', '', false, false);
                $n_after_height = $hook_vt_image['height'] + $prk_hook_options['logo_collapsed_top_margin'] + $hook_options['collapsed_menu_vertical'];
                $hook_css_build .= "#hook_header_background.hook_collapsed_menu {height:" . $n_after_height . "px;}";
                $hook_css_build .= ".menu_at_top #hook_header_background.hook_collapsed_menu {height:" . $hook_options['collapsed_menu_vertical'] . "px;}";
            }
        }
        if ($hook_options['border_menu_bar'] != "") {
            $hook_spl_border_menu_bar = hook_html2rgba($hook_options['border_menu_bar'], $hook_options['border_default_opacity']);
            $hook_css_build .= "#hook_header_background {border-bottom:1px solid $hook_spl_border_menu_bar;}";
            $hook_css_build .= "#hook_side_menu {border-color: $hook_spl_border_menu_bar;}";
            if ($hook_options['border_default_opacity'] > 0) {
                $hook_css_build .= ".st_menu_on_right #hook_side_menu {margin-left: 54px;padding-left: 54px;border-left-width: 1px;}";
                $hook_css_build .= ".st_menu_on_left #hook_side_menu {margin-right: 54px;padding-right: 54px;border-right-width: 1px;}";
            } else {
                $hook_menu_pad = 2 * $hook_options['menu_padding'];
                $hook_css_build .= ".st_menu_on_right #hook_side_menu {padding-left: " . $hook_menu_pad . "px;}";
                $hook_css_build .= ".st_menu_on_left #hook_side_menu {padding-right: " . $hook_menu_pad . "px;}";
            }
        } else {
            $hook_menu_pad = 2 * $hook_options['menu_padding'];
            $hook_css_build .= ".st_menu_on_right #hook_side_menu {padding-left: " . $hook_menu_pad . "px;}";
            $hook_css_build .= ".st_menu_on_left #hook_side_menu {padding-right: " . $hook_menu_pad . "px;}";
        }
        if ($hook_options['border_menu_bar_after'] != "" && $hook_options['border_opacity_after'] != "0") {
            $hook_spl_border_menu_bar_after = hook_html2rgba($hook_options['border_menu_bar_after'], $hook_options['border_opacity_after']);
            $hook_css_build .= ".hook_forced_menu #hook_header_background, #hook_header_background.hook_collapsed_menu,.menu_at_top #hook_header_background {border-bottom:1px solid $hook_spl_border_menu_bar_after;}";
            $hook_css_build .= ".hook_forced_menu #hook_side_menu, .hook_collapsed_menu #hook_side_menu {border-color: $hook_spl_border_menu_bar_after;}";
            $hook_css_build .= "#prk_mobile_bar {border-left: 1px solid " . $hook_spl_border_menu_bar_after . ";}";
        }

        //OVERLAY
        $hook_css_build .= "#prk_hidden_menu a,#prk_hidden_menu {color:" . $hook_options['color_menu_overlay'] . ";}";
        $hook_css_build .= ".hook_showing_menu #prk_hidden_menu a:hover {color:" . $hook_options['active_color_menu_overlay'] . ";}";
        $hook_css_build .= ".hook_showing_menu .prk_menu_block, .hook_showing_menu .prk_menu_block:after {background-color:" . $hook_options['color_menu_overlay'] . ";}";
        $hook_css_build .= ".hook_theme.hook_showing_menu #hook_header_background,.hook_theme.hook_showing_menu #hook_header_inner,.hook_theme.hook_showing_menu #hook_header_inner>div,.hook_theme.hook_showing_menu #hook_main_menu .hook-mn>li,.hook_theme.hook_showing_menu #hook_main_menu {height:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= ".hook_theme.hook_showing_menu #hook_main_menu .hook-mn>li>a {height:" . $hook_options['menu_vertical'] . "px;line-height:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= ".hook_theme.hook_showing_menu #hook_logos_wrapper {margin-top:" . $hook_options['logo_top_margin'] . "px;}";
        $hook_css_build .= ".hook_showing_menu #body_hider {background-color:$hook_spl_bk_menu_overlay;}";
        $hook_css_build .= '#hook_loader_block {background-color:' . $hook_options['page_transition_bk'] . ';}';

        //PORTFOLIO GRID OVERLAY
        $hook_css_build .= "#hook_hidden_portfolio {background-color:" . $hook_options['background_color_overf'] . ";}";

        //FOOTER
        if ($hook_options['bk_image_footer']['url'] != "") {
            $bar_image = (wp_get_attachment_image_src($hook_options['bk_image_footer']['id'], 'full'));
            $hook_css_build .= "#prk_footer_wrapper {background-image: url('" . $bar_image['0'] . "');background-position: center " . $hook_options['footer_image_align'] . ";}";
        }

        //FOOTER
        $hook_css_build .= "#prk_footer_wrapper {background-color:" . $hook_options['background_color_footer'] . ";}";
        $hook_css_build .= "#prk_footer_sidebar,#prk_after_widgets {font-size:" . $hook_options['footer_font_size'] . "px;}";
        $hook_css_build .= "#prk_footer_sidebar .simple_line {border-bottom-color: $hook_spl_body_color_footer;}";
        $hook_css_build .= "#prk_footer_sidebar table {border-top-color: $hook_spl_body_color_footer;}";
        $hook_css_build .= "#prk_footer_sidebar table {border-left-color: $hook_spl_body_color_footer;}";
        $hook_css_build .= "#prk_footer_sidebar .pirenko_highlighted,#hook_main_wrapper #prk_footer_sidebar .tagcloud a, #hook_main_wrapper #prk_footer_sidebar #wp-calendar th, #hook_main_wrapper #prk_footer_sidebar #wp-calendar td {border-color: $hook_spl_body_color_footer;}";
        $hook_css_build .= "#prk_footer_sidebar ::-webkit-input-placeholder {color: " . $hook_options['body_color_footer'] . ";}#prk_footer_sidebar :-moz-placeholder {color: " . $hook_options['body_color_footer'] . ";}#prk_footer_sidebar ::-moz-placeholder {color: " . $hook_options['body_color_footer'] . ";}#prk_footer_sidebar :-ms-input-placeholder {color: " . $hook_options['body_color_footer'] . ";}";
        $hook_css_build .= "#prk_footer_sidebar .zero_color,#prk_footer_sidebar a.zero_color,#prk_footer_sidebar .zero_color a,#hook_main_wrapper #prk_footer .prk_twt_body .twt_in a.body_colored,#prk_footer_sidebar a.twitter_time,#prk_footer_sidebar .prk_recent_tweets .prk_twt_author {color:" . $hook_options['titles_color_footer'] . ";}";
        $hook_css_build .= "#prk_footer_sidebar,#prk_footer_sidebar a,#prk_after_widgets,#prk_footer_sidebar #prk_after_widgets a,#prk_footer_sidebar .pirenko_highlighted,#prk_footer_wrapper .small_headings_color,#hook_main_wrapper #prk_footer_sidebar .tagcloud a,#hook_main_wrapper #prk_footer_sidebar a.body_colored {color:" . $hook_options['body_color_footer'] . ";}";
        $hook_css_build .= "#prk_after_widgets {background-color:" . $hook_options['footer_text_background_color'] . ";}";
        if ($hook_options['footer_border_color'] != "") {
            $hook_css_build .= "#prk_footer_outer {border-top: 1px solid " . $hook_options['footer_border_color'] . "}";
        }

        //MENU SEARCH
        $hook_css_build .= "#search_hider {background-color:" . $hook_options['bk_color_sidebar_overlay'] . ";}";
        $hook_css_build .= "#searchform_top .pirenko_highlighted {color:" . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= "#top_form_close .mfp-close_inner:before, #top_form_close .mfp-close_inner:after {background-color:" . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= "#searchform_top ::-webkit-input-placeholder {color: " . $hook_options['site_background_color'] . ";}#searchform_top :-moz-placeholder {color: " . $hook_options['site_background_color'] . ";}#searchform_top ::-moz-placeholder {color: " . $hook_options['site_background_color'] . ";}#searchform_top :-ms-input-placeholder {color: " . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper #searchform_top .pirenko_highlighted:focus {color:" . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= "#prk_hidden_menu a:hover,#top_form_close:hover {color:" . $hook_options['active_color'] . ";}";

        //PERSISTENT MENU BAR
        $hook_css_build .= ".sticky_hook #hook_sticky_menu {top:" . $hook_options['collapsed_menu_vertical'] . "px;}";
        $hook_css_build .= "#hook_sticky_menu {background-color: " . $hook_options['background_color_prst'] . ";color:" . $hook_options['body_color_prst'] . ";}";
        $hook_css_build .= "#hook_sticky_menu a {color:" . $hook_options['body_color_prst'] . ";}";
        $hook_css_build .= "#hook_sticky_menu .prk_lf {border-right: 1px solid " . hook_html2rgba($hook_options['body_color_prst'], 30) . "}";
        $hook_css_build .= "#hook_sticky_menu .sharrre {border-left: 1px solid " . hook_html2rgba($hook_options['body_color_prst'], 30) . "}";

        //HIDDEN SIDEBAR
        if ($hook_options['show_hidden_sidebar'] == "1") {
            $hook_half_margin = $hook_options['sidebar_width'];
            $hook_css_build .= "#prk_hidden_bar {width:" . $hook_options['sidebar_width'] . "px;background-color:" . $hook_options['background_color_sidebar'] . ";border-left: 1px solid " . $hook_options['background_color_sidebar'] . ";}";
            $hook_css_build .= ".st_sidebar_on_right #prk_hidden_bar {margin-right:-" . $hook_half_margin . "px;}";
            $hook_css_build .= ".st_sidebar_on_left #prk_hidden_bar {margin-left:-" . $hook_half_margin . "px;}";
            $hook_css_build .= "#prk_hidden_bar {color:" . $hook_options['body_color_sidebar'] . ";}";
            $hook_css_build .= "#prk_hidden_bar a,#prk_hidden_bar .zero_color,#prk_hidden_bar .not_zero_color {color:" . $hook_options['active_color_sidebar'] . ";}";
            $hook_css_build .= "#prk_hidden_bar .mCSB_scrollTools .mCSB_draggerRail {background-color: " . $hook_spl_body_color_sidebar . "}";
            $hook_css_build .= "#prk_hidden_bar .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{background-color: " . $hook_options['active_color_right_bar'] . ";}";
            $hook_css_build .= "#prk_hidden_bar .pirenko_highlighted {color:" . $hook_options['body_color_sidebar'] . ";border-color:" . $hook_spl_body_color_sidebar . ";}";


            if ($prk_hook_options['sidebar_position'] == "st_sidebar_on_right") {
                $hook_css_build .= "#hook_ajax_container.hook_second_sidebar_anims,#hook_header_section.hook_second_sidebar_anims,#body_hider.hook_second_sidebar_anims,#hook_header_background.hook_second_sidebar_anims,#prk_footer_outer.hook_second_sidebar_anims {margin-left:-" . $hook_options['sidebar_width'] . "px;}";
                $hook_css_build .= "#prk_hidden_bar.hook_second_sidebar_anims{margin-right:0px;}";
            } else {
                $hook_css_build .= "#hook_ajax_container.hook_second_sidebar_anims,#hook_header_section.hook_second_sidebar_anims,#body_hider.hook_second_sidebar_anims,#hook_header_background.hook_second_sidebar_anims,#prk_footer_outer.hook_second_sidebar_anims {margin-left:" . $hook_options['sidebar_width'] . "px;}";
                $hook_css_build .= "#prk_hidden_bar.hook_second_sidebar_anims{margin-left:0px;}";
            }

            $hook_css_build .= ".hook_showing_sidebar #body_hider {background-color:$hook_spl_bk_sidebar_overlay;}";
        }

        //DOTTED NAVIGATION
        $hook_css_build .= "#dotted_navigation li:before {background-color: " . $hook_options['background_color_dots'] . "}";
        $hook_css_build .= "#dotted_navigation li>a {color: " . $hook_options['active_color'] . "}";
        $hook_css_build .= "#dotted_navigation li:hover:before {background-color: " . $hook_options['active_color'] . "}";

        //BLOG
        $hook_css_build .= ".blog_info_wrapper, .blog_info_wrapper .zero_color, .blog_info_wrapper .zero_color a, .blog_info_wrapper a.zero_color, .hook_featured_header #single_blog_info,.hook_featured_header #single_blog_info .zero_color, .hook_featured_header #single_blog_info .small_headings_color,.hook_featured_header #single_blog_info .small_headings_color a {color:" . $hook_options['featured_header_color'] . ";}";
        $hook_css_build .= ".topped_content.vertical_forced_row>.columns>div {padding-top:" . $hook_options['menu_vertical'] . "px;}";
        $hook_css_build .= ".hook_featured_header #single_blog_info .theme_button a {border-color:" . $hook_options['featured_header_color'] . ";}";
        if ($hook_options['posts_bk_color'] != "") {
            $hook_css_build .= ".page-prk-blog-masonry .blog_entry_li .masonry_inner, .page-prk-blog-full .blog_entry_li {background-color:" . $hook_options['posts_bk_color'] . ";}";
        }
        if ($hook_options['comments_bk_color'] != "") {
            $hook_css_build .= "#comments {background-color:" . $hook_options['comments_bk_color'] . ";}";
        }

        //PORTFOLIO
        $hook_css_build .= ".body_bk_color,.hook_thumb_tag,.folio_always_title_and_skills.hk_ins .prk_ttl .body_bk_color, .folio_always_title_only.hk_ins .prk_ttl .body_bk_color,.body_bk_color a,.body_bk_color a:hover {color:" . $hook_options['thumbs_text_color'] . ";}";
        $hook_css_build .= ".hook_panels_bk {background-color:" . $hook_options['thumbs_text_color'] . ";}";
        $hook_css_build .= ".grid_colored_block,.hk_ins .centerized_child .grid_single_title {background-color: $hook_spl_background_color_btns;}";
        $hook_css_build .= ".prk_grid-button .prk_grid {background: " . $hook_options['thumbs_text_color'] . ";color: " . $hook_options['thumbs_text_color'] . ";}";
        $hook_css_build .= ".hook_thumb_tag,.hook-globe .bg_shifter {background-color:" . $hook_options['active_color'] . ";}";

        //THEME BUTTONS
        if ($hook_options['uppercase_buttons'] == "1") {
            $hook_css_build .= ".colored_theme_button input,.colored_theme_button a,.theme_button input,.theme_button a,.ghost_theme_button a,.ghost_theme_button>span {text-transform:uppercase;}";
        }
        $hook_css_build .= ".colored_theme_button input,.colored_theme_button a,.theme_button input,.theme_button a,.ghost_theme_button a,.ghost_theme_button>span {-webkit-border-radius: " . $hook_options['buttons_radius'] . "px;border-radius: " . $hook_options['buttons_radius'] . "px;border-width: " . $hook_options['buttons_border'] . "px;color:" . $hook_options['buttons_text_color'] . ";letter-spacing:" . $hook_options['buttons_spacing'] . "px;}";
        $hook_css_build .= ".theme_button input,.theme_button a,.theme_button.hook_button_off a:hover {background-color:" . $hook_options['theme_buttons_color'] . ";border-color:" . $hook_options['theme_buttons_color'] . ";}";
        $hook_css_build .= ".theme_button input:before,.theme_button a:before,#single_blog_info .theme_button a:before,.ghost_theme_button a:before,.ghost_theme_button>span:before {background-color:" . $hook_options['active_color'] . ";border-color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".colored_theme_button input,.colored_theme_button a,.prk_minimal_button span.current,.theme_button .wpcf7-submit:hover {background-color:" . $hook_options['active_color'] . ";border-color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".colored_theme_button input:before,.colored_theme_button a:before {background-color:" . $hook_options['theme_buttons_color'] . ";border-color:" . $hook_options['theme_buttons_color'] . ";}";
        $hook_css_build .= ".prk_buttons_list .theme_button a,.tagcloud a {background-color:transparent;border-color:" . $hook_options['inputs_bordercolor'] . ";color:" . $hook_options['inactive_color'] . "}";
        $hook_css_build .= ".prk_buttons_list .theme_button a:hover,.tagcloud a:hover {border-color:" . $hook_options['active_color'] . ";color:" . $hook_options['active_color'] . "}";
        $hook_css_build .= ".ghost_theme_button a,.ghost_theme_button>span {border-color:" . $hook_options['theme_buttons_color'] . ";color:" . $hook_options['theme_buttons_color'] . "}";
        $hook_css_build .= ".ghost_theme_button a:hover,.ghost_theme_button>span:hover {color:" . $hook_options['site_background_color'] . ";border-color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".ghost_theme_button.colored a,.social_img_wrp.hook_envelope-o {border-color:" . $hook_options['active_color'] . ";color:" . $hook_options['active_color'] . "}";
        $hook_css_build .= ".ghost_theme_button.colored a:hover {color:" . $hook_options['buttons_text_color'] . ";background-color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".theme_button a:hover,.colored_theme_button a:hover,#prk_footer_sidebar .tagcloud a:hover {color:" . $hook_options['buttons_text_color'] . "}";

        //COLORS
        $hook_css_build .= "body,#hook_ajax_container,.hook_bk_site,.hook_theme .mfp-bg,.featured_owl,.sod_select:after,.sod_select,.sod_select .sod_list_wrapper,.folio_always_title_only .centerized_father, .folio_always_title_and_skills .centerized_father,.single_comment,#hook_sidebar .hook_swrapper .pirenko_highlighted {background-color:" . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= "body,.body_colored,.body_colored a,a.body_colored {color:" . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= ".zero_color,a.zero_color,.zero_color a,.vc_tta-accordion a,.vc_tta-accordion a:hover,.hook_folio_filter ul li a:hover, .hook_blog_filter ul li a:hover,.hook_folio_filter ul li.active a, .hook_blog_filter ul li.active a,.folio_always_title_and_skills .prk_ttl .body_bk_color,.folio_always_title_only .prk_ttl .body_bk_color {color:" . $hook_options['bd_headings_color'] . ";}";
        $hook_css_build .= "a,a:hover, #prk_hidden_bar a:hover,a.small_headings_color:hover,.small_headings_color a:hover,a.zero_color:hover,.zero_color a:hover,.small_headings_color a.not_zero_color,.not_zero_color,#prk_footer_sidebar a:hover,#prk_after_widgets a:hover,#hook_main_wrapper #prk_footer .prk_twt_body .twt_in a.body_colored:hover,#hook_main_wrapper .prk_twt_ul i:hover,.high_search .hook_lback i,.hook_page_twt .zero_color,.hook_page_twt a.zero_color {color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".prk_caption,.prk_button_like,.hook_envelope-o .bg_shifter {background-color:" . $hook_options['active_color'] . ";color:" . $hook_options['site_background_color'] . "}";
        if ($hook_options['preloader_style'] == "theme_spinner") {
            $hook_css_build .= "#prk_spinner {border-top-color:" . $hook_options['preloader_color_1'] . ";}";
            $hook_css_build .= "#prk_spinner:before {border-top-color:" . $hook_options['preloader_color_2'] . ";}";
            $hook_css_build .= "#prk_spinner:after {border-top-color:" . $hook_options['preloader_color_3'] . ";}";
        } else {
            $hook_css_build .= ".ball-triangle-path>div {border-color:" . $hook_options['preloader_color'] . ";}";
            $hook_css_build .= ".rectangle-bounce>div {background-color:" . $hook_options['preloader_color'] . ";}";
        }
        if ($hook_options['preloader_opacity'] != "100") {
            $hook_css_build .= "#prk_spinner,.rectangle-bounce,.ball-triangle-path>div {filter: alpha(opacity=" . $hook_options['preloader_opacity'] . ");opacity:" . ($hook_options['preloader_opacity'] / 100) . ";}";
        }
        $hook_css_build .= ".site_background_colored a,a.site_background_colored,.site_background_colored,.owl-numbers,.prk_minimal_button span.current {color:" . $hook_options['site_background_color'] . "}";
        $hook_css_build .= "a.small_headings_color,.small_headings_color a,.small_headings_color,.sod_select.open:before,.sod_select .sod_option.selected:before,.sod_select.open,.folio_always_title_and_skills .inner_skills.body_bk_color {color:" . $hook_options['bd_smallers_color'] . ";}";
        $hook_css_build .= ".sod_select .sod_option.active {background-color:$hook_spl_bd_smallers_color;}";
        $hook_css_build .= ".blog_fader_grid {background-color:" . hook_html2rgba($hook_options['background_color_btns_blog'], $hook_options['custom_opacity']) . "}";
        $hook_css_build .= ".hook_theme .prk_sharrre_wrapper .prk_sharrre_email a {background-color:" . $hook_options['active_color'] . ";}";

        //LINES AND BORDERS
        $hook_css_build .= "#wp-calendar th,#wp-calendar td,.simple_line,.hook_theme .testimonials_stack .item,.prk_bordered_bottom,.prk_vc_title:before,.prk_vc_title:after,th,td {border-bottom: 1px solid " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= "ol.commentlist .single_comment,.prk_bordered_top,table {border-top: 1px solid " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= ".prk_bordered_right,th,td {border-right: 1px solid " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= ".prk_bordered_left,table {border-left: 1px solid " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= ".prk_bordered,.prk_minimal_button a, .prk_minimal_button span, .prk_minimal_button input {border: 1px solid " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= "#in_touch:before {background-color: " . $hook_options['lines_color'] . ";}";
        $hook_css_build .= ".hook_vd_thumb {border-color: " . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= ".sod_select,.sod_select:hover,.sod_select.open,.sod_select .sod_list_wrapper {border: 1px solid " . $hook_options['inputs_bordercolor'] . ";}";
        $hook_css_build .= ".pirenko_highlighted {border: 1px solid " . $hook_options['inputs_bordercolor'] . ";background-color:" . $hook_options['background_color'] . ";color:" . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= "#top_form_close,#searchform_top .pirenko_highlighted {color:" . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= ".pirenko_highlighted::-webkit-input-placeholder {color: " . $hook_options['inactive_color'] . ";}.pirenko_highlighted:-moz-placeholder {color: " . $hook_options['inactive_color'] . ";}.pirenko_highlighted::-moz-placeholder {color: " . $hook_options['inactive_color'] . ";}.pirenko_highlighted:-ms-input-placeholder {color: " . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .pirenko_highlighted:focus::-webkit-input-placeholder {color: " . $hook_options['active_color'] . ";}#hook_main_wrapper .pirenko_highlighted:focus:-moz-placeholder {color: " . $hook_options['active_color'] . ";}#hook_main_wrapper .pirenko_highlighted:focus::-moz-placeholder {color: " . $hook_options['active_color'] . ";}#hook_main_wrapper .pirenko_highlighted:focus:-ms-input-placeholder {color: " . $hook_options['active_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .hook_swrapper .pirenko_highlighted:focus::-webkit-input-placeholder {color: " . $hook_options['bd_headings_color'] . ";}#hook_main_wrapper .hook_swrapper .pirenko_highlighted:focus:-moz-placeholder {color: " . $hook_options['bd_headings_color'] . ";}#hook_main_wrapper .hook_swrapper .pirenko_highlighted:focus::-moz-placeholder {color: " . $hook_options['bd_headings_color'] . ";}#hook_main_wrapper .hook_swrapper .pirenko_highlighted:focus:-ms-input-placeholder {color: " . $hook_options['bd_headings_color'] . ";}";
        $hook_css_build .= ".hook_button_in .pirenko_highlighted {color:" . $hook_options['inputs_bordercolor'] . ";}.hook_button_in .pirenko_highlighted::-webkit-input-placeholder {color: " . $hook_options['inputs_bordercolor'] . ";}.hook_button_in .pirenko_highlighted:-moz-placeholder {color: " . $hook_options['inputs_bordercolor'] . ";}.hook_button_in .pirenko_highlighted::-moz-placeholder {color: " . $hook_options['inputs_bordercolor'] . ";}.hook_button_in .pirenko_highlighted:-ms-input-placeholder {color: " . $hook_options['inputs_bordercolor'] . ";}";

        $hook_css_build .= ".prk_blockquote.plain {border-left-color: " . $hook_options['active_color'] . ";}";
        $hook_css_build .= "#hook_sidebar .hook_titled.simple_line {border-bottom-color: " . $hook_options['active_color'] . ";}";
        if ($hook_options['inputs_radius'] > 0) {
            $hook_css_build .= ".pirenko_highlighted {-webkit-border-radius: " . $hook_options['inputs_radius'] . "px;border-radius: " . $hook_options['inputs_radius'] . "px;}";
        }
        if ($hook_options['custom_shadow'] > 0) {
            $hook_css_build .= ".pirenko_highlighted,.prk_bordered {-webkit-box-shadow: 0px 1px 4px " . hook_html2rgba($hook_options['shadow_color'], $hook_options['custom_shadow']) . ";box-shadow: 0px 1px 4px " . hook_html2rgba($hook_options['shadow_color'], $hook_options['custom_shadow']) . ";}";
        }

        $hook_css_build .= "#hook_main_wrapper .pirenko_highlighted:focus {border-color:$hook_spl_active_inputs;background-color:$hook_spl_active_inputs_bk;color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .pirenko_highlighted.hook_plain:focus {border: 1px solid " . $hook_options['inputs_bordercolor'] . ";background-color:" . $hook_options['background_color'] . ";color:" . $hook_options['inactive_color'] . ";}";

        $hook_css_build .= ".hook_theme .vc_progress_bar .vc_single_bar {background-color:" . $hook_options['background_color'] . ";}";

        $hook_css_build .= ".archive.author .prk_author_avatar img {border:6px solid " . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= ".hook_theme .prk_sharrre_wrapper .prk_sharrre_email,#hook_heading_line,.hook-globe {border-color: " . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".prk_blockquote.hook_active_colored .in_quote:after {border-color: rgba(0,0,0,0) rgba(0,0,0,0) " . $hook_options['site_background_color'] . " rgba(0,0,0,0);}";

        //TABS+ACCORDION
        $hook_css_build .= ".vc_tta-tabs .vc_tta-tabs-list li {background-color:$hook_spl_inputs_bordercolor;}";
        $hook_css_build .= ".vc_tta-tabs .vc_tta-tabs-list li a{color:" . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= ".hook_numbered .vc_tta-panels .vc_tta-panel .vc_tta-panel-heading:before{color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs .vc_tta-tabs-list li.vc_active a,.hook_theme .vc_tta-tabs .vc_tta-tabs-list li:hover a, .vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-panel-heading a {color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs-container .vc_tta-tabs-list li, .vc_tta-panels .vc_tta-panel-body {border:1px solid " . $hook_options['inputs_bordercolor'] . ";}";
        $hook_css_build .= ".vc_tta-accordion .vc_tta-panels .vc_tta-panel-body {border-left:1px solid " . $hook_options['inputs_bordercolor'] . ";border-right:1px solid " . $hook_options['inputs_bordercolor'] . ";}";
        $hook_css_build .= ".vc_tta-panels-container .vc_tta-panel:last-child .vc_tta-panel-body,.vc_tta-accordion .vc_tta-panel-heading {border-bottom:1px solid " . $hook_options['inputs_bordercolor'] . ";}";
        $hook_css_build .= ".vc_tta-accordion .vc_tta-panels .vc_tta-panel:first-child .vc_tta-panel-heading {border-top:1px solid " . $hook_options['inputs_bordercolor'] . ";}";

        //TABS - ACTIVE
        $hook_css_build .= ".vc_tta-container .vc_tta-tabs-list .vc_tta-tab.vc_active,.vc_tta-container .vc_tta-tabs-list .vc_tta-tab:hover,.vc_tta-panels .vc_tta-panel {background-color:" . $hook_options['background_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-bottom:1px solid " . $hook_options['background_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs.vc_tta-tabs-position-bottom .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-top:1px solid " . $hook_options['background_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-right:1px solid " . $hook_options['background_color'] . ";}";
        $hook_css_build .= ".vc_tta-tabs.vc_tta-tabs-position-right .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-left:1px solid " . $hook_options['background_color'] . ";}";
        $hook_css_build .= "@media(max-width:600px) {.vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-right:1px solid " . $hook_options['inputs_bordercolor'] . ";}.vc_tta-tabs.vc_tta-tabs-position-right .vc_tta-tabs-container .vc_tta-tabs-list li.vc_active {border-left:1px solid " . $hook_options['inputs_bordercolor'] . ";}}";

        //OWL SLIDER
        $hook_css_build .= "#hook_main_wrapper .owl-wrapper .ghost_theme_button a,#hook_main_wrapper .owl-wrapper .ghost_theme_button>span{border-color:" . $hook_options['slider_text_color'] . ";color: " . $hook_options['slider_text_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .owl-wrapper .ghost_theme_button>span:hover,.simple_line.hook_colored {border-color:" . $hook_options['active_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .owl-wrapper .ghost_theme_button>span span {background-color: " . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".owl-page:before {background-color:" . $hook_options['site_background_color'] . "; border:1px solid " . $hook_options['site_background_color'] . ";}";
        $hook_css_build .= ".hook_btn_like .owl-page:before {background-color:" . $hook_options['theme_buttons_color'] . "; border:1px solid " . $hook_options['theme_buttons_color'] . ";}";
        $hook_css_build .= ".hook_btn_like.hook_texty .owl-page:before {background-color:" . $hook_options['buttons_text_color'] . "; border:1px solid " . $hook_options['buttons_text_color'] . ";}";
        $hook_css_build .= ".hook_multi_spinner {border: 3px solid " . $hook_spl_spinner_color . ";border-right-color:" . $hook_options['bd_headings_color'] . ";border-left-color:" . $hook_options['bd_headings_color'] . ";}";
        $hook_css_build .= ".owl-prev,.owl-next,.member_colored_block_in,.owl-controls .owl-buttons div {background-color:" . $hook_options['buttons_color'] . ";}";
        $hook_css_build .= ".hook_featured_line,.owl-controls .site_background_colored,.member_colored_block, .member_colored_block .hook_member_links a,#hook_arrow,#hook_main_wrapper .owl-wrapper .grid_single_title .body_bk_color,#hook_panels_vol {color:" . $hook_options['slider_text_color'] . ";}";
        $hook_css_build .= ".hk_inline {background-color:" . $hook_options['slider_text_color'] . ";}";
        $hook_css_build .= "#hook_main_wrapper .layout-panels .owl-wrapper .ghost_theme_button>span:hover {color:" . $hook_options['buttons_color'] . ";}";
        $hook_css_build .= ".testimonials_slider.owl-theme.hook_squared .owl-page.active:before {background-color:" . $hook_options['active_color'] . ";border-color:" . $hook_options['active_color'] . ";}";

        //404 ERROR PAGE
        if ($prk_hook_options['error_image']['url'] != "") {
            $hook_css_build .= ".error404 #hook_main_wrapper #hook_content {background-image: url(" . $prk_hook_options['error_image']['url'] . ");}";
            $hook_css_build .= "#hook_content.hook_error404 p,.error404 #hook_main_wrapper #hook_404_title .zero_color, .error404 #hook_main_wrapper #hook_404_title .not_zero_color {color:" . $hook_options['site_background_color'] . ";}";
            $hook_css_build .= ".hook_error404 .columns.simple_line {margin-top: -16px;visibility:hidden;}";
            $hook_css_build .= "#hook_404_title h1 {margin-top: 32px;}";
            $hook_css_build .= "#hook_content.hook_error404 p {font-size:1.4rem;}";
        }
        if ($prk_hook_options['search_color'] != "") {
            $hook_css_build .= "#hook_content.hook_error404 p, .error404 #hook_main_wrapper #hook_404_title .zero_color, .error404 #hook_main_wrapper #hook_404_title .not_zero_color {color:" . $prk_hook_options['search_color'] . ";}";
        }

        //SEARCH RESULTS
        if ($prk_hook_options['search_image']['url'] != "") {
            $hook_css_build .= ".hook_search_results #classic_title_wrapper {background-image: url(" . $prk_hook_options['search_image']['url'] . ");}";
            $hook_css_build .= ".hook_search_results #single_page_title {color:" . $hook_options['menu_up_color'] . ";}";
        }

        //OVERLAYER
        $hook_css_build .= "#hook_overlayer {background-color:" . $hook_options['background_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .simple_line {border-bottom-color:" . $hook_options['lines_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .prk_bordered_top {border-top-color:" . $hook_options['lines_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .prk_bordered_left {border-left-color: " . $hook_options['lines_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .prk_bordered_right {border-right-color: " . $hook_options['lines_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .prk_bordered_bottom {border-bottom-color: " . $hook_options['lines_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .prk_grid-button .prk_grid {color:" . $hook_options['headings_color_overlayer'] . ";background:" . $hook_options['headings_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio {color:" . $hook_options['body_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .hook_info_block a,#hook_ajax_portfolio .hook_info_block a:hover {color:" . $hook_options['active_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .zero_color, #hook_ajax_portfolio a.zero_color,#hook_ajax_portfolio .zero_color a {color:" . $hook_options['headings_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .small_headings_color, #hook_ajax_portfolio a.small_headings_color,#hook_ajax_portfolio .small_headings_color a {color:" . $hook_options['smallers_color_overlayer'] . ";}";
        $hook_css_build .= "#hook_ajax_portfolio .hook_multi_spinner {border: 3px solid " . $hook_spl_spinner_color_over . ";border-right-color:" . $hook_options['headings_color_overlayer'] . ";border-left-color:" . $hook_options['headings_color_overlayer'] . ";}";

        //LIGHTBOX
        $hook_css_build .= ".hook_theme .mfp-arrow-left,.hook_theme .mfp-arrow-right,.hook_theme .mfp-counter,.hook_theme .mfp-title {color:" . $hook_options['inactive_color'] . ";
        }";
        $hook_css_build .= ".mfp-close_inner:before,.mfp-close_inner:after{background-color:" . $hook_options['inactive_color'] . ";}";

        //MOBILE BAR
        $hook_css_build .= "#prk_mobile_bar .body_colored a,#prk_mobile_bar a.body_colored,#prk_mobile_bar .body_colored,#prk_mobile_bar,#prk_mobile_bar a {color: " . $hook_options['body_color_right_bar'] . "; }";
        $hook_css_build .= "#prk_mobile_bar a:hover,#prk_mobile_bar .active>a,#prk_mobile_bar .zero_color,#prk_mobile_bar .zero_color a,#prk_mobile_bar .mobile-menu-ul .hook_actionized a {color: " . $hook_options['active_color_right_bar'] . ";}";
        $hook_css_build .= "#prk_mobile_bar #mirror_social_nets,#prk_mobile_bar_inner>.header_stack {border-bottom: 1px solid $hook_spl_body_color_right_bar;}";
        $hook_css_build .= "#prk_mobile_bar .pirenko_highlighted {border: 1px solid $hook_spl_body_color_right_bar;}";
        $hook_css_build .= "#prk_mobile_bar .mCSB_scrollTools .mCSB_draggerRail {background-color: $hook_spl_body_color_right_bar;}";
        $hook_css_build .= "#prk_mobile_bar .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {background-color: " . $hook_options['active_color_right_bar'] . "}";
        $hook_css_build .= "#prk_mobile_bar {background-color: " . $hook_options['background_color_right_bar'] . ";}";

        //OTHER ELEMENTS
        if (isset($hook_options['menu_text']) && $hook_options['menu_text'] != "") {
            $hook_css_build .= "#prk_blocks_wrapper:before {content: '" . $hook_options['menu_text'] . "';color:" . $hook_options['menu_up_color'] . "}";
            $hook_css_build .= "#prk_blocks_wrapper.hover_trigger:before {color: " . $hook_options['menu_active_color'] . ";}";
            $hook_css_build .= ".menu_at_top #prk_blocks_wrapper:before,.hook_collapsed_menu #prk_blocks_wrapper:before,.hook_forced_menu #prk_blocks_wrapper:before {color:" . $hook_options['menu_up_color_after'] . "}";
            $hook_css_build .= ".menu_at_top #prk_blocks_wrapper.hover_trigger:before {color: " . $hook_options['menu_active_color_after'] . ";}";
            $hook_css_build .= ".hook_showing_menu #prk_blocks_wrapper:before {color:" . $hook_options['color_menu_overlay'] . ";}";
        }
        if (isset($hook_options['sidebar_text']) && $hook_options['sidebar_text'] != "") {
            $hook_css_build .= "#prk_sidebar_trigger:before {content: '" . $hook_options['sidebar_text'] . "';color:" . $hook_options['menu_up_color'] . "}";
            $hook_css_build .= "#prk_sidebar_trigger.hover_trigger:before {color: " . $hook_options['menu_active_color'] . ";}";
            $hook_css_build .= ".menu_at_top #prk_sidebar_trigger:before {color:" . $hook_options['menu_up_color_after'] . "}";
            $hook_css_build .= ".menu_at_top #prk_sidebar_trigger.hover_trigger:before {color: " . $hook_options['menu_active_color_after'] . ";}";
            $hook_css_build .= ".hook_showing_menu #prk_sidebar_trigger:before {color:" . $hook_options['color_menu_overlay'] . ";}";
        }
        $hook_css_build .= "#body_hider {background-color:$hook_spl_bk_mobile_overlay;}";
        $hook_css_build .= ".prk_menu_sized .sub-menu li a {font-weight:" . $hook_options['submenu_font_weight'] . ";font-size:" . $hook_options['submenu_font_size'] . "px;}";
        $hook_css_build .= "#hook_to_top {color: " . $hook_options['back_to_top_color'] . "; background-color: " . $hook_options['back_to_top_bk'] . ";}";
        $hook_css_build .= ".hook_active_colored,.hook_actionized a:after {background-color: " . $hook_options['active_color'] . ";}";
        $hook_css_build .= ".hook_tmmarker{background-color: " . $hook_options['inactive_color'] . ";}";
        $hook_css_build .= ".prk_sharrre_wrapper .sharrre a,.prk_sharrre_wrapper .sharrre a:hover {color:" . $hook_options['buttons_text_color'] . ";}";
        $hook_css_build .= ".hook_info_board li:hover {background-color:$hook_spl_lines_bordercolor;}";

        //Min read info display
        if (isset($prk_hook_options['show_min_read']) && $prk_hook_options['show_min_read'] == "0") {
            $hook_css_build .= ".hook_min_read {display:none;}";
        }

        //ABOVE MENU BAR
        if ($prk_hook_options['show_top_bar'] == "1") {
            $hook_css_build .= "#hook_header_bar,#hook_header_inner .widget_nav_menu>.menu,#hook_abovebar-top-right,hook_abovebar-top-left,#hook_header_bar .menu>li>a {height:" . $hook_options['top_bar_height'] . "px;line-height:" . $hook_options['top_bar_height'] . "px;font-size:" . $hook_options['top_bar_font_size'] . "px;}";
            $hook_css_build .= "#hook_header_bar a,#hook_header_bar,#hook_header_inner .widget_nav_menu>.menu .sub-menu li a,#hook_header_inner #hook_header_wpml>.menu .sub-menu li a {color:" . $hook_options['body_color_header_bar'] . ";}";
            $hook_css_build .= "#hook_header_bar a:hover,#hook_header_bar .active a,#hook_header_inner .widget_nav_menu>.menu .sub-menu li a:hover {color:" . $hook_options['active_color_header_bar'] . ";}";
            $hook_css_build .= "#hook_header_bar,#hook_header_inner .widget_nav_menu>.menu .sub-menu li a {background-color:" . $hook_options['background_color_header_bar'] . ";}";
            $summed_height = $hook_options['menu_vertical'] + $hook_options['top_bar_height'];
            $hook_css_build .= ".hook_hide_nav #hook_header_section,.hook_hide_nav #hook_header_background {margin-top:-" . $summed_height . "px;}";
            $hook_css_build .= "#hook_header_background {height:" . $summed_height . "px;}";
            $summed_height_after = $hook_options['collapsed_menu_vertical'] + $hook_options['top_bar_height'];
            $hook_css_build .= ".hook_collapsed_menu#hook_header_background {height:" . $summed_height_after . "px;}";
            $hook_css_build .= ".hook_forced_menu #hook_ajax_container {margin-top:" . $summed_height . "px;}";
            if ($hook_options['border_color_header_bar'] != "") {
                $hook_css_build .= "#hook_header_bar {border-bottom: 1px solid " . $hook_options['border_color_header_bar'] . "}";
            }
        }

        if (class_exists('Easy_Custom_Facebook_Feed_Widget')) {
            $hook_css_build .= ".mfp-content .white-popup {background-color:" . $hook_options['site_background_color'] . ";}";
            $hook_css_build .= ".hook_fb_feed .efbl_author_name {color:" . $hook_options['bd_headings_color'] . ";}";
            $hook_css_build .= ".hook_fb_feed #efblcf .efbl_comments_wraper,.mfp-content #efblcf_holder .efbl_popupp_footer {background-color: " . $hook_spl_inactive_color . ";}";
            $hook_css_build .= ".hook_fb_feed #efblcf .efbl_post_content .efbl_author_info .efbl_story_time {color:" . $hook_options['bd_smallers_color'] . ";}";
            $hook_css_build .= ".hook_fb_feed #efblcf .efbl_info span {color:" . $hook_options['active_color'] . ";}";
            $hook_css_build .= ".hook_fb_feed #efblcf, .hook_fb_feed #efblcf .efbl_comments_header,.hook_fb_feed #efblcf.thumbnail .efbl_story_meta {border-bottom: 1px solid " . $hook_options['lines_color'] . ";}";
            $hook_css_build .= ".hook_fb_feed #efblcf .efbl_comments_footer,.hook_fb_feed #efblcf.thumbnail .efbl_story_meta {border-top: 1px solid " . $hook_options['lines_color'] . ";}";
        }


        if (HOOK_WOO_ON == "true") {
            $hook_adjusted_width_woo = $prk_hook_options['custom_width'] - 18 * 2;
            $hook_css_build .= "#s_sec_inner>.woocommerce-message {max-width: " . $hook_adjusted_width_woo . "px;}";
            $hook_css_build .= ".woocommerce .cart-collaterals h2,.woocommerce-result-count,.hook_woo_add_button,.woocommerce-checkout .woocommerce h2,.woocommerce-checkout .woocommerce h3,.woocommerce-checkout .woocommerce h4,.woocommerce #order_review_heading,.woocommerce #customer_details h3, .woocommerce #reply-title, .hook_woo_product_info h3,.woocommerce-tabs .tabs,.woocommerce .summary h1,.woocommerce .related>h3,.woocommerce .price,.woocommerce .amount,.woocommerce .product-title,.woocommerce-MyAccount-navigation li a {font-family:" . $hook_options['header_font']['css'] . "}";
            $hook_css_build .= "#hook_main_wrapper #hook_content .cart-collaterals table,#hook_main_wrapper #hook_content .shop_table,#hook_main_wrapper .woocommerce textarea, #hook_main_wrapper .woocommerce input,.woocommerce .quantity input.qty,.woocommerce #hook_content .quantity input.qty,.woocommerce-page .quantity input.qty,.woocommerce-page #hook_content .quantity input.qty,.shop_table,.woocommerce #payment .wc_payment_methods,.woocommerce .widget_product_search #s,.select2-container .select2-choice {color:" . $hook_options['inactive_color'] . ";border: 1px solid " . $hook_options['inputs_bordercolor'] . ";background-color: " . $hook_options['background_color'] . "}";
            $hook_css_build .= "#hook_main_wrapper #hook_content .cart-collaterals table {border-top: 0px solid " . $hook_options['inputs_bordercolor'] . ";}";
            $hook_css_build .= ".woocommerce table.shop_table tbody th, .woocommerce table.shop_table tfoot td, .woocommerce table.shop_table tfoot th,#hook_main_wrapper #hook_content .cart-collaterals .cart_totals tr th,#hook_main_wrapper #hook_content .cart-collaterals .cart_totals tr td,#hook_main_wrapper #hook_content table.shop_table td,.woocommerce-MyAccount-navigation ul li:first-child {border-top:1px solid " . $hook_options['inputs_bordercolor'] . ";}";
            $hook_css_build .= "#hook_main_wrapper .woocommerce textarea:focus, #hook_main_wrapper .woocommerce input:focus,.woocommerce .quantity input.qty:focus,.woocommerce #hook_content .quantity input.qty:focus,.woocommerce-page .quantity input.qty:focus,.woocommerce-page #hook_content .quantity input.qty:focus,.woocommerce .widget_product_search #s:focus {border-color:$hook_spl_active_inputs;background-color:$hook_spl_active_inputs_bk;color:" . $hook_options['active_color'] . ";}";
            $hook_css_build .= "#hook_main_wrapper #hook_content .woocommerce .button.alt,#hook_main_wrapper #hook_content .woocommerce .button,#hook_main_wrapper .woocommerce .button,.woocommerce .widget_product_search .hook_fa-search,.woocommerce #respond input#submit {background: " . $hook_options['active_color'] . ";letter-spacing:" . $hook_options['buttons_spacing'] . "px;}";
            $hook_css_build .= "#hook_main_wrapper #hook_content .woocommerce .button:hover,#hook_main_wrapper .woocommerce .button:hover,.woocommerce span.onsale,.woocommerce .widget_product_search #searchsubmit:hover,#hook_main_wrapper #hook_content .woocommerce .woocommerce-message a:hover, #hook_main_wrapper .woocommerce .woocommerce-message a:hover,.woocommerce #respond input#submit:hover {background:" . $hook_options['theme_buttons_color'] . ";}";
            $hook_css_build .= "#hook_main_wrapper #hook_content .woocommerce .button.alt,#hook_main_wrapper #hook_content .woocommerce .button,#hook_main_wrapper .woocommerce .button, .hook_woo_add_button,.hook_woo_add_button:hover,.woocommerce #respond input#submit,.woocommerce #respond input#submit:hover {color:" . $hook_options['buttons_text_color'] . ";}";
            $hook_css_build .= ".woocommerce-message {border-top-color:" . $hook_options['active_color'] . ";}";
            $hook_css_build .= ".woocommerce #hook_main_wrapper #hook_content div.product .woocommerce-tabs ul.tabs li.active {background: " . $hook_options['site_background_color'] . ";border-bottom-color: " . $hook_options['site_background_color'] . ";}";
            $hook_css_build .= ".hook_woo_add_button {background:" . $hook_options['theme_buttons_color'] . ";}";
            $hook_css_build .= "html .woocommerce .star-rating span,.woocommerce nav.woocommerce-pagination ul li a:hover,.woocommerce-MyAccount-navigation li a:hover,.woocommerce-MyAccount-navigation li.is-active a {color: " . $hook_options['active_color'] . ";}";
            $hook_css_build .= ".woocommerce nav.woocommerce-pagination ul li span.current {color: " . $hook_options['site_background_color'] . ";background-color: " . $hook_options['active_color'] . ";}";
            $hook_css_build .= "#hook_main_wrapper #hook_sidebar ul.product_list_widget li a,.woocommerce .hook_woo_checkout h3,.woocommerce .customer_details dt,.shipping_calculator h2 a,.woocommerce-checkout ul.order_details,.woocommerce-checkout table.order_details tfoot>tr:last-child,.woocommerce-checkout .addresses h3,.woocommerce #order_review_heading, .woocommerce #customer_details h3,.woocommerce .order-total,.woocommerce-result-count,.pp_woocommerce .pp_description,.woocommerce #hook_main_wrapper .woocommerce-tabs .tabs li a,#hook_main_wrapper .woocommerce #hook_content .price,#hook_main_wrapper .woocommerce .price,#hook_main_wrapper .woocommerce #hook_content ins .amount,#hook_main_wrapper .woocommerce ins .amount,#hook_main_wrapper .woocommerce .product_title,#hook_main_wrapper .woocommerce .product_meta,#hook_main_wrapper .woocommerce h2, .woocommerce table th,.woocommerce #reply-title,#customer_details label,.woocommerce-order-received h3,.woocommerce-MyAccount-navigation li a,.single-product .summary .variations td.label {color: " . $hook_options['bd_headings_color'] . ";}";
            $hook_css_build .= ".woocommerce .hook_woo_thankyou header h2,.woocommerce .simple_line,.woocommerce-checkout #hook_main_wrapper h3,.woocommerce #hook_main_wrapper .woocommerce-tabs ul.tabs:before {border-bottom-color:" . $hook_options['inputs_bordercolor'] . ";}";
            $hook_css_build .= ".woocommerce #hook_main_wrapper .woocommerce-tabs ul.tabs {border-color:" . $hook_options['inputs_bordercolor'] . ";}";
            $hook_css_build .= ".woocommerce #hook_main_wrapper div.product .woocommerce-tabs .tabs li,.woocommerce table.shop_table th {border-color:" . $hook_options['site_background_color'] . ";}";
            $hook_css_build .= ".woocommerce #hook_main_wrapper #hook_content div.product .woocommerce-tabs ul.tabs li,.woocommerce nav.woocommerce-pagination ul li a:hover,.woocommerce nav.woocommerce-pagination ul li a:focus {background-color:" . $hook_options['site_background_color'] . ";}";
            $hook_css_build .= ".woocommerce #hook_main_wrapper .woocommerce-tabs .tabs li.active a,.woocommerce-message:before,.woocommerce-account fieldset legend {color:" . $hook_options['active_color'] . ";}";
            $hook_css_build .= "#hook_main_wrapper .price del, #hook_main_wrapper .woocommerce .price del, .woocommerce #hook_main_wrapper .price del {color:" . $hook_options['bd_smallers_color'] . ";}";
            $hook_css_build .= ".woocommerce .order_details li {border-right-color: " . $hook_options['lines_color'] . ";}";
            $hook_css_build .= ".woocommerce nav.woocommerce-pagination ul li a {color: " . $hook_options['inactive_color'] . ";}";
            $hook_css_build .= ".hook_woo_el_wrapper,#hook_main_wrapper #hook_sidebar ul.product_list_widget li,.woocommerce-checkout #payment ul.payment_methods,.woocommerce-MyAccount-navigation ul li {border-bottom:1px solid " . $hook_options['lines_color'] . ";}";
            $hook_css_build .= ".cart_totals table,.woocommerce-checkout #payment .payment_methods,.shop_table,.woocommerce .woocommerce-error,.woocommerce .woocommerce-info,.woocommerce .woocommerce-message {background:" . $hook_options['inputs_bordercolor'] . ";background:$hook_spl_inputs_bordercolor;}";
            $hook_css_build .= ".woocommerce.single-product #hook_main_wrapper #hook_ajax_container .summary .cart:after {background:" . $hook_options['inputs_bordercolor'] . ";}";
            $hook_css_build .= "#hook_cart_info {background-color:" . $hook_options['active_color'] . ";}";
            $hook_css_build .= ".woocommerce-account fieldset {border: 1px solid " . $hook_options['active_color'] . ";}";
            if ($hook_options['buttons_font'] == "headings_f") {
                $hook_css_build .= ".woocommerce button.button,.woocommerce input.button,.woocommerce a.button {font-family:" . $hook_options['header_font']['css'] . ";}";
            }
            if ($hook_options['buttons_font'] == "body_f") {
                $hook_css_build .= ".woocommerce button.button,.woocommerce input.button,.woocommerce a.button {font-family:" . $hook_options['body_font']['css'] . "}";
            }
            if ($hook_options['custom_font'] != "") {
                if ($hook_options['main_subheadings_font'] == "custom_font") {
                    $hook_css_build .= ".hook_woo_cats {font-style:" . $hook_options['custom_font_style'] . ";font-family:" . $hook_options['custom_font']['css'] . "}";
                }
            }
        }
        //RETINA DESKTOPS - LOGO
        if (isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url'] != "") {
            $hook_css_build .= ".hook_retina_desktop #hook_logo_before {background-image: url(" . $prk_hook_options['logo_retina']['url'] . ");}.hook_retina_desktop #hook_logo_before img {visibility: hidden;}";
        }
        if (isset($prk_hook_options['logo_collapsed_retina']) && $prk_hook_options['logo_collapsed_retina']['url'] != "") {
            $hook_css_build .= ".hook_retina_desktop #hook_logo_after {background-image: url(" . $prk_hook_options['logo_collapsed_retina']['url'] . ");}.hook_retina_desktop #hook_logo_after img {visibility: hidden;}";
        }
        $hook_css_build .= "@media only screen and (max-width: 767px) {.hook_theme .hook_featured_header #single_blog_info.unforced_row .zero_color {color:" . $hook_options['bd_headings_color'] . ";}.hook_theme .hook_featured_header #single_blog_info.unforced_row .small_headings_color, .hook_theme .hook_featured_header #single_blog_info.unforced_row .small_headings_color a {color:" . $hook_options['bd_smallers_color'] . ";}}";

        if (isset($prk_hook_options['css_text']) && $prk_hook_options['css_text'] != "") {
            $hook_css_build .= wp_specialchars_decode($prk_hook_options['css_text']);
        }
        //OUTPUT THE CUSTOM STYLES WE JUST BUILT
        wp_add_inline_style('hook_main_style', $hook_css_build);
    }//HOOK SCRIPTS
}

add_action('wp_enqueue_scripts', 'hook_scripts', 100);