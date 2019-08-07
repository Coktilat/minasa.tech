<?php
add_action('init','prk_hook_scodes');
/**
 * @return array
 */
function scodes_translate() {
    if (!function_exists('hook_translations')) {
        $prk_hook_options=hook_options();
        $prk_translated=$prk_hook_options;
    }
    else {
        $prk_translated=hook_translations();
    }
    return $prk_translated;
}
function prk_hook_scodes() {
    if (!function_exists('html2rgb')) {
        /**
         * @param $color
         * @param $alpha
         * @return array|bool
         */
        function html2rgb($color, $alpha)
        {
            if ($color[0] == '#')
                $color=substr($color, 1);
            if (strlen($color) == 6)
                list($r, $g, $b)=array($color[0].$color[1],$color[2].$color[3],$color[4].$color[5]);
            elseif (strlen($color) == 3)
                list($r, $g, $b)=array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
            else
                return false;
            $r=hexdec($r); $g=hexdec($g); $b=hexdec($b);

            return array($r, $g, $b ,$alpha);
        }
    }

    //SHORTCODES MANAGEMENT
    //TWITTER FEED
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_twt_func ($atts, $content=null) {
        extract(shortcode_atts(array(
            'username'    	 => '',
            'consumerkey'    	 => '',
            'consumersecret'    	 => '',
            'accesstoken'    	 => '',
            'accesstokensecret'    	 => '',
            'cachetime'    	 => '',
            'tweetstoshow'    	 => '',
        ), $atts));
        ob_start();
        the_widget('prk_tp_widget_recent_tweets',$atts);
        $widget=ob_get_contents();
        ob_end_clean();
        $main_classes="hook_page_twt";
        if (isset($atts['css_animation']) && $atts['css_animation']!="")
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if (isset($atts['el_class']) && $atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        return '<div class="'.$main_classes.'">'.$widget.'</div>';
    }
    add_shortcode('prk_twt', 'prk_twt_func');


    //INTAGRAM FEED
    /**
     * @param $username
     * @param int $slice
     * @return array|mixed|WP_Error
     */
    function prk_instafeed($username, $slice = 9 ) {

        $username = trim( strtolower( $username ) );

        switch ( substr( $username, 0, 1 ) ) {
            case '#':
                $url              = 'https://instagram.com/explore/tags/'.str_replace( '#', '', $username );
                $transient_prefix = 'h';
                break;

            default:
                $url              = 'https://instagram.com/'.str_replace( '@', '', $username );
                $transient_prefix = 'u';
                break;
        }

        if (false === ( $instagram = get_transient( 'insta-a10-'.$transient_prefix.'-'.sanitize_title_with_dashes( $username ) ) ) ) {

            $remote = wp_remote_get( $url );

            if ( is_wp_error( $remote ) ) {
                return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
            }

            if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
                echo "Error ".wp_remote_retrieve_response_code( $remote );
                return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
            }

            $shards      = explode( 'window._sharedData = ', $remote['body'] );
            $insta_json  = explode( ';</script>', $shards[1] );
            $insta_array = json_decode( $insta_json[0], true );

            if ( ! $insta_array ) {
                return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }

            if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            } elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            } else {
                return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }

            if ( ! is_array( $images ) ) {
                return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }

            $instagram = array();

            foreach ( $images as $image ) {
                if ( true === $image['node']['is_video'] ) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }

                $caption = __( 'Instagram Image', 'wp-instagram-widget' );
                if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
                    $caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
                }

                $instagram[] = array(
                    'description' => $caption,
                    'link'        => trailingslashit( '//instagram.com/p/'.$image['node']['shortcode'] ),
                    'time'        => $image['node']['taken_at_timestamp'],
                    'comments'    => $image['node']['edge_media_to_comment']['count'],
                    'likes'       => $image['node']['edge_liked_by']['count'],
                    'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
                    'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
                    'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
                    'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
                    'type'        => $type,
                );
            } // End foreach().

            // do not set an empty transient - should help catch private or empty accounts.
            if ( ! empty( $instagram ) ) {
                $instagram = base64_encode( serialize( $instagram ) );
                set_transient( 'insta-a10-'.$transient_prefix.'-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
            }
        }

        if ( ! empty( $instagram ) ) {

            $instagram = unserialize( base64_decode( $instagram ) );
            return array_slice( $instagram, 0, $slice );

        } else {

            return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wp-instagram-widget' ) );

        }
    }

    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_instagram_func($atts, $content=null ) {
        extract(shortcode_atts(array(
            'user'    	 => '',
            'items'    	 => '',
            'title'    	 => '',
            'rows'    	 => '',
            'gen_display'    	 => '',
            'img_margin' => '0',
        ), $atts));
        $prk_hook_options=hook_options();
        $out="";
        $items=6;
        $rows=1;
        $gen_display="hook_insta_grid";
        if (isset($atts['gen_display']) && $atts['gen_display']!="") {
            $gen_display=$atts['gen_display'];
        }
        if (isset($atts['items']) && $atts['items']!="") {
            $items=$atts['items'];
        }
        if (isset($atts['rows']) && $atts['rows']!="") {
            $rows=$atts['rows'];
        }
        $images_count=$items*$rows;
        if (isset($atts['user']) && $atts['user']!="") {
            $media_array=prk_instafeed($atts['user'],$images_count);
            if ( is_wp_error( $media_array ) ) {
                $out.=$media_array->get_error_message();
            } else {
                $main_classes="hook_insta_wrapper ".$gen_display;
                if (isset($atts['css_animation']) && $atts['css_animation']!="")
                    $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
                if (isset($atts['css_delay']) && $atts['css_delay']!="") {
                    $main_classes.=" delay-".$atts['css_delay'];
                }
                if (isset($atts['el_class']) && $atts['el_class']!="")
                    $main_classes.=" ".$atts['el_class'];
                $out.='<div class="'.$main_classes.'">';
                if (isset($atts['title']) && $atts['title']!="") {
                    if (isset($atts['title_color']) && $atts['title_color']!="") {
                        $out.='<div class="hook_insta_title prk_lf zero_color" style="color:'.$atts['title_color'].'"><a href="https://instagram.com/'.$atts['user'].'/" target="_blank" data-color="'.$prk_hook_options['active_color'].'" data-forced-color="'.$atts['title_color'].'" style="color:'.$atts['title_color'].'"><i class="mdi-instagram"></i><h4>'.$atts['title'].'</h4></a></div>';
                    }
                    else {
                        $out.='<div class="hook_insta_title prk_lf zero_color"><a href="https://instagram.com/'.$atts['user'].'/" target="_blank"><i class="mdi-instagram"></i><h4>'.$atts['title'].'</h4></a></div>';
                    }
                }
                $inline_out=$inline_in="";
                if ($gen_display=="hook_insta_slider") {
                    $items.=" owl-carousel";
                }
                else {
                    if ($img_margin!="0") {
                        $inline_out=' style="margin-right:-'.$img_margin.'px;"';
                        $inline_in=' style="padding:0px '.$img_margin.'px '.$img_margin.'px 0px;"';
                    }
                }
                $out.='<ul class="hook_instagram unstyled cols-'.$items.'" data-autoplay="true" data-delay="3000" data-anim="fade"'.$inline_out.'>';
                $i=0;
                foreach ($media_array as $item) {
                    $out.='<li class="item"'.$inline_in.'><a href="'. esc_url( $item['link'] ) .'" target="_blank"><div style="background-image:url('. esc_url( $item['original'] ) .');"><div class="insta_overlay"></div><i class="mdi-instagram"></i>';
                    $out.='<img src="'.get_template_directory_uri().'/images/instaholder.png" width="1080" height="1080"  alt="'. esc_attr( $item['description'] ) .'" data-title="'. esc_attr( $item['description'] ).'" />';
                    $out.='</div></a></li>';
                    $i++;
                    if ($i%$items==0 && $gen_display=="hook_insta_grid") {
                        $out.='<li class="clearfix"></li>';
                    }
                }
                $out.='</ul>';
                $out.='<div class="clearfix"></div></div>';
            }
        }
        return $out;
    }
    add_shortcode('prk_instagram', 'prk_instagram_func');



    //SOCIAL NETWORK LINKS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function pirenko_social_nets_shortcode($atts, $content=null ) {
        $main_classes="";
        if (isset($atts['el_class']) && $atts['el_class']!="")
            $main_classes=" ".$atts['el_class'];
        if (isset($atts['css_animation']) && $atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        $icons_inline="";
        if (!isset($atts['icons_style'])) {
            $atts['icons_style']="minimal_icons";
        }
        if ($atts['icons_style']=="") {
            $atts['icons_style']="minimal_icons";
        }
        if (isset($atts['icons_size']) && $atts['icons_style']=="minimal_icons") {
            $icons_inline=' style="font-size:'.$atts['icons_size'].'px;"';
        }
        $parent_inline=' style="';
        $children_inline="";
        $up_color="default";
        $hover_color="default";
        if (isset($atts['text_color'])) {
            $up_color=$atts['text_color'];
            $children_inline=' style="color:'.$atts['text_color'].';"';
            $parent_inline.='border-color:'.$atts['text_color'].';';
        }
        if (isset($atts['custom_opacity']) && $atts['custom_opacity']!="100") {
            $parent_inline.='opacity:'.($atts['custom_opacity']/100).';';
        }
        if (isset($atts['icons_padding']) && $atts['icons_padding']!="") {
            $parent_inline.='padding-left:'.$atts['icons_padding'].'px;padding-right:'.$atts['icons_padding'].'px;';
        }
        if ($parent_inline!=' style="') {
            $parent_inline.='"';
        }
        else {
            $parent_inline="";
        }
        if (isset($atts['hover_color'])) {
            $hover_color=$atts['hover_color'];
        }
        if (isset($atts['link_1'])) {
            $atts['link_1']=hook_change_links($atts['link_1']);
        }
        if (isset($atts['link_2'])) {
            $atts['link_2'] = hook_change_links($atts['link_2']);
        }
        if (isset($atts['link_3'])) {
            $atts['link_3'] = hook_change_links($atts['link_3']);
        }
        if (isset($atts['link_4'])) {
            $atts['link_4'] = hook_change_links($atts['link_4']);
        }
        if (isset($atts['link_5'])) {
            $atts['link_5'] = hook_change_links($atts['link_5']);
        }
        if (isset($atts['link_6'])) {
            $atts['link_6'] = hook_change_links($atts['link_6']);
        }
        if (isset($atts['link_7'])) {
            $atts['link_7'] = hook_change_links($atts['link_7']);
        }
        if (isset($atts['link_8'])) {
            $atts['link_8'] = hook_change_links($atts['link_8']);
        }
        $out='<div class="social_links_shortcode '.$atts['icons_style'].$main_classes.'"'.$icons_inline.'>';
        if (isset($atts['net_1']) && $atts['net_1']!="none") {
            $out.='<a href="'.$atts['link_1'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social hook_tp_'.$atts['net_1'].'"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_1']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_2']) && $atts['net_2']!="none") {
            $out.='<a href="'.$atts['link_2'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_2']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_3']) && $atts['net_3']!="none") {
            $out.='<a href="'.$atts['link_3'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_3']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_4']) && $atts['net_4']!="none") {
            $out.='<a href="'.$atts['link_4'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_4']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_5']) && $atts['net_5']!="none") {
            $out.='<a href="'.$atts['link_5'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_5']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_6']) && $atts['net_6']!="none") {
            $out.='<a href="'.$atts['link_6'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_6']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_7']) && $atts['net_7']!="none") {
            $out.='<a href="'.$atts['link_7'].'" target="_blank" data-color="'.$hover_color.'" data-up-color="'.$up_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_7']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        if (isset($atts['net_8']) && $atts['net_8']!="none") {
            $out.='<a href="'.$atts['link_8'].'" target="_blank" data-color="'.$hover_color.'"'.$children_inline.'>';
            $out.='<div class="hook_inner_social"'.$parent_inline.'>';
            $out.='<i class="hook_mini_icon '.hook_social_icon($atts['net_8']).'">';
            $out.='</i>';
            $out.='</div>';
            $out.='</a>';
        }
        $out.='</div>';
        $out.='<div class="clearfix"></div>';
        return $out;
    }
    add_shortcode('pirenko_social_nets', 'pirenko_social_nets_shortcode');

    //VERTICAL SPACER
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function spacer_shortcode($atts, $content=null ) {
        $atts=shortcode_atts(array(
            'size' => '18',
            'size_767' => '',
            'size_480' => '',
            'el_class' => '',
            'hide_with_css' => '',
        ), $atts);

        $main_classes="";
        if ($atts['el_class']!="") {
            $main_classes=" ".$atts['el_class'];
        }
        if ($atts['hide_with_css']!="") {
            $hide_with_css=str_replace(',', ' ', $atts['hide_with_css']);
            $main_classes.=' '.$hide_with_css;
        }
        $output=$desktop_classes=$medium_classes="";
        if ($atts['size_480']!="" && $atts['size_480']!=$atts['size']) {
            $desktop_classes.=" hide_much_later";
            if ($atts['size_480'] > 0) {
                $output.= '<div class="hook_spacer show_much_later clearfix'.$main_classes.'" style="height:'.$atts['size_480'].'px;"></div>';
            } else {
                $output.= '<div class="hook_spacer show_much_later clearfix'.$main_classes.'" style="margin-top:'.$atts['size_480'].'px;"></div>';
            }
        }
        if ($atts['size_767']!="" && $atts['size_767']!=$atts['size']) {
            $medium_classes.=" hide_later";
            if ($atts['size_767'] > 0) {
                $output.= '<div class="hook_spacer show_later clearfix'.$main_classes.$desktop_classes.'" style="height:'.$atts['size_767'].'px;"></div>';
            } else {
                $output.= '<div class="hook_spacer show_later clearfix'.$main_classes.$desktop_classes.'" style="margin-top:'.$atts['size_767'].'px;"></div>';
            }
        }
        if ($atts['size']>0) {
            $output.='<div class="hook_spacer clearfix'.$main_classes.$desktop_classes.$medium_classes.'" style="height:'.$atts['size'].'px;"></div>';
        }
        else {
            $output.='<div class="hook_spacer clearfix'.$main_classes.$desktop_classes.$medium_classes.'" style="margin-top:'.$atts['size'].'px;"></div>';
        }
        return $output;

    }
    add_shortcode('pirenko_spacer', 'spacer_shortcode');

    //THEME ICON
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function pirenko_theme_icon_shortcode($atts, $content=null ) {
        if (isset($atts['icon_size']) && $atts['icon_size']!="")
        {
            $inline='style="font-size:'.$atts['icon_size'].';';
        }
        else
        {
            $inline='style="font-size:14px;';
        }
        if (isset($atts['text_color']) && $atts['text_color']!="")
        {
            $inline.='color:'.$atts['text_color'].';';
        }
        $inline_wrapper="";
        if (isset($atts['align']) && $atts['align']!="")
        {
            $inline_wrapper=' style="text-align:'.$atts['align'].';"';
        }
        $inline.='"';
        $main_classes="";
        if (isset($atts['css_animation']) && $atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if (isset($atts['el_class']) && $atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        if ($atts['icon_type']=='awesome_icons') {
            $icon=str_replace('fa fa', 'hook_fa', $atts['icon']);
        }
        else {
            $icon=$atts['icon_material'];
        }
        return '<div class="theme_icon_shortcoded'.$main_classes.'"'.$inline_wrapper.'><i class="'.$icon.'" '.$inline.'></i></div>';
    }
    add_shortcode('pirenko_theme_icon', 'pirenko_theme_icon_shortcode');

    //STYLED TITLE
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function pirenko_sh_styled_title($atts, $content=null ) {
        $atts=shortcode_atts(array(
            'underlined'    	 => '',
            'use_italic'    	 => 'no',
            'font_type'    	 => 'header_font',
            'text_color'    	 => '',
            'margin_bottom'    	 => '',
            'align'    	 => 'left',
            'title_size'    	 => 'h1',
            'hook_show_line' => '',
            'line_color' => '',
            'font_weight' => '',
            'width' => '70px',
            'css_animation' => '',
            'el_class' => '',
            'css_delay' => '',
            'custom_css' => '',
        ), $atts);
        //OUTER CLASSES
        $main_classes="";
        if ($atts['underlined']!="")
            $main_classes.=" ".$atts['underlined'];
        $inline=$inline_out="";
        if ($atts['text_color']!="") {
            $splitted_shadow=html2rgb($atts['text_color'],"1");
            $inline="color:".$atts['text_color'].";";
            $inline.="border-bottom-color:rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.9);";
            $inline.="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
        }
        if ($atts['margin_bottom']!="") {
            if ($atts['hook_show_line']=="like_sidebar" || $atts['hook_show_line']=="thin" || $atts['hook_show_line']=="thick" || $atts['hook_show_line']=="thicker") {
                $inline_out.=' style="margin-bottom:'.$atts['margin_bottom'].';"';
            }
            else {
                $inline.="margin-bottom:".$atts['margin_bottom'].";";
            }
        }
        $main_classes.=' hook_'.$atts['align'].'_align';
        $h_tag=$atts['title_size'];
        if ($atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if ($atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        $main_classes.=' '.$h_tag.'_sized';
        if ($atts['hook_show_line']=="double_lined" || $atts['hook_show_line']=="like_sidebar") {
            $main_classes.=" ".$atts['hook_show_line'];
        }
        $inline_line=' style="';
        if ($atts['line_color']!="") {
            $inline_line.='border-bottom-color:'.$atts['line_color'].';';
        }
        $inline_line.='width:'.$atts['width'].';';

        //BEGIN OUTPUT
        $out='';
        $out.='<div class="prk_shortcode-title prk_break_word'.$main_classes.'"'.$inline_out.'>';
        if ($atts['hook_show_line']=="above thin" || $atts['hook_show_line']=="above thick" || $atts['hook_show_line']=="above thicker") {
            $inline_line.='width:'.$atts['width'].';margin-top:0px;"';
            $out.='<div class="simple_line colored '.$atts['hook_show_line'].' columns small-centered forced_mobile"'.$inline_line.'></div>';
        }
        else {
            $inline_line.='"';
        }
        $inline_h="";
        $inline_h=' style="';
        if ($atts['font_weight']!="") {
            $inline_h.='font-weight:'.$atts['font_weight'].';';
        }
        else {
            $inline_h.='font-weight:100;';
        }
        if ($atts['custom_css']!="") {
            $inline_h.=$atts['custom_css'];
        }
        if ($inline_h==' style="') {
            $inline_h="";
        }
        else {
            $inline_h.='"';
        }
        if ($h_tag=="h1_bigger") {
            $h_tag="h1";
        }
        $extra_class="";

        //INNER CLASSES
        $classes="";
        if ($atts['use_italic']=="yes") {
            $classes="hook_italic ";
        }
        $classes.=$atts['font_type']." ";
        if ($atts['hook_show_line']=="like_sidebar") {
            $content.='<div class="hook_titled simple_line"></div>';
        }

        if ($inline!="") {
            $out.='<div class="'.$classes.'zero_color prk_vc_title" style="'.$inline.'"><'.$h_tag.$extra_class.$inline_h.'>'.$content.'</'.$h_tag.'></div>';
        }
        else {
            $out.='<div class="'.$classes.'zero_color prk_vc_title"><'.$h_tag.$extra_class.$inline_h.'>'.$content.'</'.$h_tag.'></div>';
        }
        if ($atts['hook_show_line']=="thin" || $atts['hook_show_line']=="thick" || $atts['hook_show_line']=="thicker") {
            $out.='<div class="simple_line colored '.$atts['hook_show_line'].' columns small-centered forced_mobile"'.$inline_line.'></div>';
        }
        if ($atts['hook_show_line']=="like_sidebar") {
            $out.='<div class="clearfix simple_line"></div></div>';
        }
        else {
            $out.='<div class="clearfix"></div></div>';
        }
        return do_shortcode($out);

    }
    add_shortcode('prk_styled_title', 'pirenko_sh_styled_title');

    if(!function_exists('pirenko_sh_prk_text_rotator')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_sh_prk_text_rotator($atts, $content=null ) {
            $atts=shortcode_atts(array(
                'prk_in' => '',
                'text_color' => '',
                'title_size' => 'h1_big',
                'effect' => 'old_timey',
                'speed' => '2500',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts);
            $main_classes="";
            $inline="";
            if ($atts['text_color']!="") {
                $splitted_shadow=html2rgb($atts['text_color'],"1");
                $inline="color:".$atts['text_color'].";";
                $inline.="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
            }
            $h_tag=$atts['title_size'];
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            $main_classes.=" ".$h_tag.'_sized';
            $main_classes.=" eff-".$atts['effect'];
            $out='';
            if ($content!="") {
                if ($inline!="")
                    $out.='<div class="prk_text_rotator header_font per_init'.$main_classes.'" style="'.$inline.'">';
                else
                    $out.='<div class="prk_text_rotator header_font per_init'.$main_classes.'">';
                $effect_in=$atts['effect'];
                $out.='<div class="cd-headline '.$atts['effect'].'" data-speed="'.$atts['speed'].'">';
                $out.='<span></span>';
                $out.='<span class="cd-words-wrapper">';
                $words_array=explode('+', $content);
                if ($words_array && count($words_array)>0) {
                    $i=0;
                    foreach ($words_array as $word) {
                        if ($i==0)
                            $out.='<b class="is-visible">'.$word.'</b>';
                        else
                            $out.='<b>'.$word.'</b>';
                        $i++;
                    }
                }
                $out.='</span>';
                $out.='</div>';
                $out.='</div>';
            }
            return do_shortcode($out);

        }
    }
    add_shortcode('prk_text_rotator', 'pirenko_sh_prk_text_rotator');

    //COUNTDOWN
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function pirenko_sh_prk_countdown($atts, $content = null ) {
        extract(shortcode_atts(array(
            'text_color' => '',
            'year' => '',
            'month' => '',
            'day' => '',
            'css_animation' => '',
            'css_delay' => '',
            'el_class' => ''
        ), $atts));
        $main_classes="";
        $inline="";
        if (isset($atts['text_color'])) {
            if ($atts['text_color']!="") {
                $inline=' style="color:'.$atts['text_color'].';"';
            }
        }
        if (isset($atts['css_animation']) && $atts['css_animation']!="")
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if (isset($atts['el_class']) && $atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        $out='<div class="hook_countdown per_init'.$main_classes.'" data-year="'.$atts['year'].'" data-month="'.$atts['month'].'" data-day="'.$atts['day'].'"'.$inline.'></div>';
        return do_shortcode($out);
    }
    add_shortcode('prk_countdown', 'pirenko_sh_prk_countdown');

    //BLOCKQUOTES
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function blockquotes_shortcode($atts, $content=null ) {
        if (isset($atts['css_animation']) && $atts['css_animation']!="") {
            if (isset($atts['el_class']) && $atts['el_class']!="") {
                $atts['css_animation']=$atts['css_animation']." ".$atts['el_class'];
            }
            if (isset($atts['css_delay']) && $atts['css_delay']!="") {
                $atts['css_animation'].=" delay-".$atts['css_delay'];
            }
            $output='<div class="hook_bquote_wrapper wpb_animate_when_almost_visible wpb_'.$atts['css_animation'].'">';
        }
        else
            $output='<div class="hook_bquote_wrapper">';
        if ($atts['type']=="") {
            $atts['type']="plain";
        }
        if ($atts['type']=="plain") {
            if ($atts['author']!="" || $atts['after_author'] !="") {
                $author_html='<div class="pirenko_author zero_color prk_heavier_600">'.$atts['author'].'<span class="after_author zero_color">'.$atts['after_author']. '</span></div>';
            }
            else {
                $author_html="";
            }
            $output.='<div class="prk_blockquote ' .$atts['type'].'">';
            $output.='<div class="in_quote not_zero_color">'.$content.'</div>'.$author_html;
            $output.='</div>';

        }
        else if ($atts['type']=="cropped_corners" || $atts['type']=="tagline") {
            $output.='<div class="prk_bordered prk_blockquote '. $atts['type'].'">';
            if ($atts['author']!="" || $atts['after_author'] !="") {
                $output.='<div class="in_quote small_headings_color">'.$content.'<div class="'. $atts['type'].' pirenko_author prk_heavier_600 zero_color prk_heavier_600">'.$atts['author'].'<span class="after_author zero_color">'.$atts['after_author']. '</span></div></div>';
            }
            else {
                $output.='<div class="in_quote small_headings_color">'.$content.'</div>';
            }
            $output.='</div>';

        }
        else {
            if ($atts['author']!="" || $atts['after_author'] !="") {
                $author_html='<div class="pirenko_author prk_heavier_600">'.$atts['author'].'<span class="after_author">'.$atts['after_author']. '</span></div>';
            }
            else {
                $author_html="";
            }
            $output.='<div class="prk_blockquote '.$atts['type']. '">';
            $output.='<div class="in_quote">'.$content.$author_html.'</div>';
            $output.='</div>';
        }
        $output.='</div>';
        return $output;
    }
    add_shortcode('pirenko_blockquote', 'blockquotes_shortcode');


    //SLIDERS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    if (!function_exists('pirenko_sh_slider')) {
        function pirenko_sh_slider($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'category' => '',
                'autoplay' => '',
                'delay' => '',
                'sl_size' => '',
                'hover' => '',
                'f_color' => '',
                'navigation' => '',
                'pagination' => '',
                'parallax_effect' => '',
                'featured_slider_anim' => '',
                'order' => '',
            ), $atts));
            $prk_hook_options = hook_options();
            wp_reset_query();
            if ($atts['category'] == "show_all") {
                $category = "";
            } else {
                $category = $atts['category'];
            }
            if (isset($order) && $order != "") {
                $slider_order = $order;
            } else {
                $slider_order = 'date';
            }
            $args = array(
                'post_type' => 'pirenko_slides',
                'showposts' => 99,
                'pirenko_slide_set' => $category,
                'orderby' => $slider_order,
            );
            $custom_query = new WP_Query($args);
            $out = '';
            $slide_number = 0;
            if (!isset($autoplay) || $autoplay == "" || $autoplay == "yes" || $autoplay == "true")
                $autoplay = "true";
            else
                $autoplay = "false";
            if (isset($pagination) && $pagination == "true")
                $pagination = "true";
            else
                $pagination = "false";
            if (isset($navigation) && $navigation == "true")
                $navigation = "true";
            else {
                $navigation = "false";
            }
            if (isset($featured_slider_anim) && $featured_slider_anim != "") {
                $sl_anim = $featured_slider_anim;
            } else {
                $sl_anim = "fade";
            }
            if (!isset($delay) || $delay == "")
                $delay = "5500";
            if (!isset($sl_size) || $sl_size == "")
                $sl_size = "";
            if (!isset($f_color) || $f_color == "")
                $f_color = $prk_hook_options['active_color'];
            $id = "prk_slider_".rand(1, 1000);
            $out .= '<div id="'.$id.'" class="per_init owl-carousel hook_shortcode_slider '.$sl_size.' anim-'.$sl_anim.'"  data-autoplay="'.$autoplay.'" data-navigation="'.$navigation.'" data-pagination="'.$pagination.'" data-delay="'.$delay.'" data-hover="'.$hover.'" data-color="'.$f_color.'" data-anim="'.$sl_anim.'">';
            while ($custom_query->have_posts()) : $custom_query->the_post();
                $use_txt = 1;
                if (get_field('hide_slide_text') == "1")
                    $use_txt = 0;
                $limit_width = true;
                if (get_field('limit_text_width') != "1")
                    $limit_width = false;
                if (get_field('slide_text_size') != "")
                    $text_size = get_field('slide_text_size');
                else
                    $text_size = "medium";
                if (get_field('slide_text_horz'))
                    $h_align = get_field('slide_text_horz');
                else
                    $h_align = "left";
                if (get_field('slide_text_vert'))
                    $v_align = get_field('slide_text_vert');
                else
                    $v_align = "top";
                $pirenko_sh_slide_header_color = "";
                $inline = "";
                if (get_field('pirenko_sh_slide_header_color')) {
                    $pirenko_sh_slide_header_color = get_field('pirenko_sh_slide_header_color');
                    $splitted_shadow = html2rgb(get_field('pirenko_sh_slide_header_color'), '1');
                    $inline = "text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
                }
                $pirenko_sh_slide_header_bk_color = "";
                if (get_field('pirenko_sh_slide_header_bk_color') != "") {
                    $pirenko_sh_slide_header_bk_color = hook_html2rgba(get_field('pirenko_sh_slide_header_bk_color'), get_field('title_background_color_opacity'));
                } else {
                    $text_size .= " hook_noback";
                }

                $pos_class = "sld_".$h_align." "."sld_".$v_align;
                if (has_post_thumbnail(get_the_ID())) {
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                } else {
                    //THERE'S NO FEATURED IMAGE SO LET'S LOAD A DEFAULT IMAGE
                    $image[0] = get_bloginfo('template_directory')."/images/sample/holder_a.jpg";
                }
                $hook_vt_image = vt_resize('', $image[0], 0, 0, true);
                $parallaxy = "";
                if ($parallax_effect == "owl_parallaxed") {
                    $parallaxy = ' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 400px;" style="background-image: url('.$image[0].');"';
                }
                $out .= '<div id="hook_slide_'.$slide_number.'" class="item '.$text_size.'"'.$parallaxy.'>';
                if (get_field('pirenko_sh_slide_url') != "") {
                    $out .= '<a href="'.get_field('pirenko_sh_slide_url').'" target="'.get_field('pirenko_sh_slide_wdw').'" class="hook_anchor">';
                }
                if (get_the_title() == "" || $use_txt == 0) {
                    $sl_title = "&nbsp;";
                    $title_class = "inv_el";
                } else {
                    if (get_field('pirenko_rotating_text') != "") {
                        if (get_field('pirenko_rotating_effect') != "") {
                            $effect = get_field('pirenko_rotating_effect');
                        } else {
                            $effect = "old_timey";
                        }
                        $sl_title = '<div class="cd-headline '.$effect.'">';
                        $sl_title .= '<span></span>';
                        $sl_title .= '<span class="cd-words-wrapper">';
                        $sl_title .= '<b class="is-visible">'.get_the_title().'</b>';
                        $words_array = explode('+', get_field('pirenko_rotating_text'));
                        if ($words_array && count($words_array) > 0) {
                            foreach ($words_array as $word) {
                                $sl_title .= '<b>'.$word.'</b>';
                            }
                        }
                        $sl_title .= '</span>';
                        $sl_title .= '</div>';
                    } else {
                        $sl_title = get_the_title();
                    }
                    $title_class = "";
                }
                if (get_field('title_css') != "") {
                    $extra_title_class = ' '.get_field('title_css');
                } else {
                    $extra_title_class = "";
                }
                if (get_the_content() == "") {
                    $sl_body = "&nbsp;";
                } else {
                    $sl_body = get_the_content();
                }

                if (get_field('pirenko_sh_video') == "") {
                    $out .= '<div class="slider_text_holder header_font '.$pos_class.'">';
                    if ($limit_width == true) {
                        $out .= '<div class="small-12 prk_inner_block columns small-centered">';
                    }
                    if (get_the_title() != "" && $use_txt == 1) {
                        $out .= '<div id="'.$id.'top_'.$slide_number.'" class="prk_heavier_600 prk_lf headings_top '.$title_class.'" style="color:'.$pirenko_sh_slide_header_color.';'.$inline.'">';
                        $out .= '<div class="prk_colored_slider'.$extra_title_class.'" style="background-color:'.$pirenko_sh_slide_header_bk_color.'">';
                        $out .= $sl_title;
                        $out .= '<div class="clearfix"></div>';
                        $out .= '</div>';
                        $out .= '</div>';
                        $out .= '<div class="clearfix"></div>';
                    }
                    if (get_the_content() != "") {
                        $out .= '<div id="'.$id.'body_'.$slide_number.'" class="prk_heavier_500 headings_body">';
                        $out .= '<div>';
                        $out .= do_shortcode($sl_body);
                        $out .= '<div class="clearfix"></div>';
                        $out .= '</div>';
                        $out .= '</div>';
                        $out .= '<div class="clearfix"></div>';
                    }
                    if ($limit_width == true) {
                        $out .= '</div>';
                    }
                    $out .= '</div>';
                    if ($slide_number == 0) {
                        $out .= '<img class="hook_preloaded hook_vsbl" src="'.$image[0].'" alt="'.hook_alt_tag(false, $image[0]).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" data-or_w="'.esc_attr($hook_vt_image['width']).'" data-or_h="'.esc_attr($hook_vt_image['height']).'" />';
                    } else {
                        $out .= '<img class="lazy_hook hook_vsbl" src="#" data-src="'.$image[0].'" alt="'.hook_alt_tag(false, $image[0]).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" data-or_w="'.esc_attr($hook_vt_image['width']).'" data-or_h="'.esc_attr($hook_vt_image['height']).'" />';
                    }
                } else {
                    //IT's A VIDEO SLIDE
                    $out .= '<div class="slider_text_holder header_font '.$pos_class.'">';
                    if ($limit_width == true) {
                        $out .= '<div class="small-12 prk_inner_block columns small-centered">';
                    }
                    if (get_the_title() != "" && $use_txt == 1) {
                        $out .= '<div id="'.$id.'top_'.$slide_number.'" class="prk_heavier_600 prk_lf headings_top '.$title_class.'" style="color:'.$pirenko_sh_slide_header_color.';">';
                        $out .= '<span class="prk_colored_slider" style="background-color:'.$pirenko_sh_slide_header_bk_color.'">';
                        $out .= ''.$sl_title.'';
                        $out .= '<div class="clearfix"></div>';
                        $out .= '</span>';
                        $out .= '</div>';
                        $out .= '<div class="clearfix"></div>';
                    }
                    if (get_the_content() != "") {
                        $out .= '<div id="'.$id.'body_'.$slide_number.'" class="prk_heavier_500 headings_body">';
                        $out .= '<span>';
                        $out .= ''.$sl_body.'';
                        $out .= '<div class="clearfix"></div>';
                        $out .= '</span>';
                        $out .= '</div>';
                        $out .= '<div class="clearfix"></div>';
                    }
                    if ($limit_width == true) {
                        $out .= '</div>';
                    }
                    $out .= '</div>';
                    $out .= get_field('pirenko_sh_video');
                }
                if (get_field('pirenko_sh_slide_url') != "")
                    $out .= '</a>';
                $out .= '</div>';
                $slide_number++;
            endwhile;
            $out .= '</div>';
            wp_reset_query();
            return $out;
        }
    }
    add_shortcode('prk_slider', 'pirenko_sh_slider');

    //SAMPLE FEED SHORTCODE - VERSION 4.3.2
    //[efb_feed fanpage_url="YOUR_FB_FANPAGE_NAME_OR_URL" layout="CHOSE_LAYOUT(thumbnail/half/full)" image_size="CHOSE_IMAGE_SIZE(thumbnail/album/normal)" type="CHOSE_TYPE(page/group)" post_by="DISPLAY_POSTS_FROM(me/others/onlyothers)" show_logo="SHOW_HIDE_PAGE_LOGO(1/0)" show_image="SHOW_HIDE_IMAGES(1/0)" show_like_box="SHOW_HIDE_LIKEBOX(1/0)" links_new_tab="OPEN_LINKS_IN_EXTERNAL_TAB(1/0)" post_number="NUMBER_OF_POST_DISPALAY(10)" post_limit="NUMBER_OF_POST_RETRIEVE(10)" cache_unit="NUMMBER_OF_MINUTES_HOURS_DAYS(1)" cache_duration="SELECT_CACHE_DURATION(minutes/hours/days)"]
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_efb_feed_shortcode($atts, $content=null ) {
        $atts=shortcode_atts(array(
            'fanpage_url'    	=> '',
            'layout' => 'thumbnail',
            'image_size' => 'thumbnail',
            'type' => 'page',
            'post_by' => 'me',
            'show_logo' => '1',
            'show_image' => '1',
            'show_like_box' => '1',
            'links_new_tab' => '1',
            'post_number' => '6',
            'cache_unit' => '60',
            'cache_duration' => '1',
            'el_class' => '',
            'css_animation' => '',
            'css_delay' => '',
        ), $atts);
        $main_classes="";
        if ($atts['css_animation']!="")
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        if ($atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        $out= '<div class="'.$atts['layout'].'_mode hook_fb_feed'.$main_classes.'">';
        $out.= '[efb_feed fanpage_url="'.$atts['fanpage_url'].'" layout="'.$atts['layout'].'" image_size="'.$atts['image_size'].'" type="'.$atts['type'].'" post_by="'.$atts['post_by'].'" show_logo="'.$atts['show_logo'].'" show_image="'.$atts['show_image'].'" show_like_box="'.$atts['show_like_box'].'" links_new_tab="'.$atts['links_new_tab'].'" post_number="'.$atts['post_number'].'" post_limit="'.$atts['post_number'].'" cache_unit="'.$atts['cache_unit'].'" cache_duration="'.$atts['cache_duration'].'"]';
        $out.='</div>';
        return do_shortcode($out);
    }
    add_shortcode('prk_efb_feed', 'prk_efb_feed_shortcode');

    //WOO SINGLE PORDUCT
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_woo_single_shortcode($atts, $content=null ) {
        if (!class_exists('woocommerce')) {
            return "WooCommerce Plugin Is Not Active.";
        }
        $hook_translated=scodes_translate();
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        $atts=shortcode_atts(array(
            'id'    	=> '',
            'css_animation' => '',
            'el_class' => '',
            'css_delay' => '',
        ), $atts);
        $main_classes="";
        if ($atts['css_animation']!="")
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        if ($atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        $out="";
        //PRODUCT QUERY
        $params = array(
            'posts_per_page' => 1,
            'post_type' => 'product',
            'p' => $atts['id'],
        );
        $wc_query = new WP_Query($params);
        if ($wc_query->have_posts()) {
            $out.='<div class="woocommerce hook_single_woo'.$main_classes.'">';
            while ($wc_query->have_posts()):
                $wc_query->the_post();
                ob_start();
                wc_get_template_part( 'content', 'single-product' );
                $out.= ob_get_clean();
            endwhile;
            wp_reset_postdata();
            $out.='</div>';
        }
        else {
            $out.=__('No Products Found','hook');
        }

        wp_reset_query();
        return $out;
    }
    add_shortcode('prk_woo_single', 'prk_woo_single_shortcode');

    //WOO FEATURED PRODUCTS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_woo_featured_shortcode($atts, $content=null ) {
        if (!class_exists('woocommerce')) {
            return "WooCommerce Plugin Is Not Active.";
        }
        $hook_translated=scodes_translate();
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        $atts=shortcode_atts(array(
            'category'    	=> '',
            'columns'		=>'4',
            'order_by' => 'best_sellers',
            'items_number' => '12',
            'general_style' => 'classic',
            'content_amount' => 'compressed',
            'icons_position' => 'under',
            'css_animation' => '',
            'el_class' => '',
            'css_delay' => '',
        ), $atts);
        if ($atts['items_number']!="")
            $items_number=$atts['items_number'];
        //DEFAULT VALUES
        $columns=$atts['columns'];
        $fluid="small-3 columns";
        if ($atts['columns']==2) {
            $fluid="small-6 columns";
        }
        if ($atts['columns']==3) {
            $fluid="small-4 columns";
        }
        if ($atts['columns']==4){
            $fluid="small-3 columns";
        }
        if ($atts['columns']==6){
            $fluid="small-2 columns";
        }
        $main_classes="";
        if ($atts['css_animation']!="")
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        if ($atts['el_class']!="")
            $main_classes.=" ".$atts['el_class'];
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        $out='';
        $i=0;
        if ($atts['general_style']!="")
            $general_style=$atts['general_style'];
        else
            $general_style='classic';
        if ($atts['content_amount']!="")
            $content_amount=$atts['content_amount'];
        else
            $content_amount='compressed';
        if ($atts['icons_position']!="")
            $icons_position=$atts['icons_position'];
        else
            $icons_position='under';
        $args=array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page' => $items_number,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'exclude-from-catalog',
                    'operator' => 'NOT IN',
                ),
            ),
        );
        if ($atts['order_by']=="best_sellers") {
            $args=array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts'   => 1,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'posts_per_page' => $items_number,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'exclude-from-catalog',
                        'operator' => 'NOT IN',
                    ),
                ),
            );
        }
        if ($atts['order_by']=="sale_only") {
            $product_ids_on_sale=woocommerce_get_product_ids_on_sale();
            $args=array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts'   => 1,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'posts_per_page' => $items_number,
                'post__in'		=> $product_ids_on_sale,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'exclude-from-catalog',
                        'operator' => 'NOT IN',
                    ),
                ),
            );
        }
        if ($atts['order_by']=="rating") {
            add_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
        }
        $products=new WP_Query( $args );
        remove_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
        if ( $products->have_posts() ) {
            $out.='<div class="woocommerce'.$main_classes.'">';
            if ($general_style=='classic')
            {
                $out.='<div class="row prk_row woocommerce hook_woo_grider"><div class="hook_cols-'.$columns.'">';
                $out.='<ul class="products">';
                while ( $products->have_posts() ) : $products->the_post();
                    ob_start();
                    woocommerce_get_template_part( 'content', 'product' );
                    $out.= ob_get_clean();
                endwhile;
                $out.='</ul></div></div>';
            }
            else
            {
                $out.='<div class="row prk_row woocommerce hook_woo_grider">';
                $touch_enable="false";
                if (isset($prk_hook_options['touch_enable']) && $prk_hook_options['touch_enable']=="1") {
                    $touch_enable="true";
                }
                $out.='<div class="products_ul_slider products per_init" data-navigation="true" data-touch='.$touch_enable.'>';
                while ( $products->have_posts() ) : $products->the_post();
                    $out.='<div class="item hook_woo_slide"><ul>';
                    ob_start();
                    woocommerce_get_template_part( 'content', 'product' );
                    $out.= ob_get_clean();
                    $out.='</ul></div>';
                    $i++;
                endwhile;
                $out.='</div></div>';
            }
            $out.='</div>';
        }
        wp_reset_query();
        return $out;
    }
    add_shortcode('prk_woo_featured', 'prk_woo_featured_shortcode');

    //WOO WIDGET PRODUCTS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_woo_widget_shortcode($atts, $content=null ) {
        if (!class_exists('woocommerce')) {
            return "WooCommerce Plugin Is Not Active.";
        }
        $hook_translated=scodes_translate();
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        $atts=shortcode_atts(array(
            'items_number'	=> '12',
            'category'    	=> '',
            'columns'		=>'columns',
            'css_animation' => '',
            'el_class' => '',
            'css_delay' => '',
            'content_amount' => 'compressed',
            'icons_position' => 'under',
            'order_by' => 'best_sellers',
        ), $atts);
        if ($atts['items_number']!="")
            $items_number=$atts['items_number'];
        //DEFAULT VALUES
        $columns=1;
        $main_classes="";
        if ($atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if ($atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        $out='';
        $i=0;
        if ($atts['content_amount']!="")
            $content_amount=$atts['content_amount'];
        if ($atts['icons_position']!="")
            $icons_position=$atts['icons_position'];
        $args=array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page' => $items_number,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'exclude-from-catalog',
                    'operator' => 'NOT IN',
                ),
            ),
        );
        if ($atts['order_by']=="best_sellers") {
            $args=array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts'   => 1,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'posts_per_page' => $items_number,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'exclude-from-catalog',
                        'operator' => 'NOT IN',
                    ),
                ),
            );
        }
        if ($atts['order_by']=="sale_only") {
            $product_ids_on_sale=woocommerce_get_product_ids_on_sale();
            $args=array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts'   => 1,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'posts_per_page' => $items_number,
                'post__in'		=> $product_ids_on_sale,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'exclude-from-catalog',
                        'operator' => 'NOT IN',
                    ),
                ),
            );
        }
        $extra_class="";
        if ($atts['order_by']=="rating") {
            add_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
            $extra_class=" by_rating";
        }
        $products=new WP_Query( $args );
        remove_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
        if ( $products->have_posts() ) {
            $out.='<div class="woocommerce'.$main_classes.'">';
            $out.='<div class="row prk_row hook_woo_grider hook_woo_widget'.$extra_class.'">';
            $out.='<ul class="products">';
            while ( $products->have_posts() ) : $products->the_post();
                $out.='<li class="small-12 columns">';
                $out.='<ul class="hook_woo_el_wrapper">';
                ob_start();
                woocommerce_get_template_part( 'content', 'product' );
                $out.= ob_get_clean();
                $out.='</ul>';
                $out.='</li>';
            endwhile;
            $out.='</ul></div></div>';
        }
        wp_reset_query();
        return $out;
    }
    add_shortcode('prk_woo_widget', 'prk_woo_widget_shortcode');

    //AUTHORS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_authors_shortcode($atts, $content=null ) {
        $hook_translated=scodes_translate();
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        extract(shortcode_atts(array(
            'category'    	=> '',
            'columns'		=>'columns',
        ), $atts));
        if ($category=="show_all")
            $category="";
        if (isset($atts['items_number']) && $atts['items_number']!="")
            $items_number=$atts['items_number'];
        else
            $items_number=999;
        //DEFAULT VALUES
        $columns=3;
        $main_classes="small-4 columns";
        if ($atts['columns']==2) {
            $main_classes="small-6 columns";
            $columns=$atts['columns'];
        }
        if ($atts['columns']==3){
            $main_classes="small-4 columns";
            $columns=$atts['columns'];
        }
        if ($atts['columns']==4){
            $main_classes="small-3 columns";
            $columns=$atts['columns'];
        }
        if ($atts['columns']==6){
            $main_classes="small-2 columns";
            $columns=$atts['columns'];
        }
        $hook_forced_w=ceil(($prk_hook_options['custom_width']+80*2)/$atts['columns']);
        if ($hook_forced_w<780);
        $hook_forced_w=780;
        if (isset($atts['css_animation']) && $atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if (isset($atts['el_class']) && $atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        $blogusers=get_users( 'include='.$category );
        $out='';
        $i=0;
        if (isset($atts['text_align']) && $atts['text_align']!="")
            $main_css=' '.$atts['text_align'];
        else
            $main_css=' text_center';
        if (isset($atts['content_amount']) && $atts['content_amount']!="")
            $content_amount=$atts['content_amount'];
        else
            $content_amount='compressed';
        if (isset($atts['icons_position']) && $atts['icons_position']!="")
            $icons_position=$atts['icons_position'];
        else
            $icons_position='under';
        $out.='<div class="row prk_row'.$main_css.'">';
        $out.='<ul class="member_ul hook_authors">';
        foreach ($blogusers as $hook_author_array) {
            $author_linka=get_author_posts_url($hook_author_array->ID);
            $out.='<li class="'.$main_classes.' sh_member_wrapper">';
            $out.='<a href="'.$author_linka.'" class="sh_member_link hook_anchor">';
            $out.='<div class="member_colored_block">';
            if (get_the_author_meta('prk_author_custom_avatar',$hook_author_array->ID)!="") {
                $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar',$hook_author_array->ID) ,$hook_forced_w ,0 , false , $hook_retina_device );
                $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar',$hook_author_array->ID))).'" />';
            }
            else {
                $out.=get_avatar(get_the_author_meta('email',$hook_author_array->ID), '480');
            }
            $out.='</div>';
            $out.=' </a>';
            $out.='<div class="clearfix"></div>';
            $out.='<div class="sh_member_name zero_color header_font">';
            $out.='<a href="'.$author_linka.'" class="hook_anchor">';
            $out.=get_the_author_meta('display_name',$hook_author_array->ID);
            $out.=' </a>';
            $out.='</div>';
            $out.='<div class="clearfix"></div>';
            $out.='<div class="sh_member_function small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
            $out.=get_the_author_meta('prk_subheading',$hook_author_array->ID);
            $out.='</div>';
            $out.='<div class="clearfix"></div>';
            if ($content_amount!='compressed') {
                $out.='<div class="body_colored wpb_text_column">';
                $out.=nl2br($hook_author_array->description);
                $out.='</div>';
                $out.='<div class="clearfix"></div>';
            }
            $out.='</li>';
            $i++;
            if ($i%$columns==0) {
                $out.='<li class="clearfix"></li>';
            }
        }
        $out.='</ul></div>';
        wp_reset_query();
        return $out;
    }
    add_shortcode('prk_authors', 'prk_authors_shortcode');

    //TEAM MEMBERS
    if (!function_exists('prk_member_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function prk_member_shortcode($atts, $content=null ) {
            $hook_translated=scodes_translate();
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $atts=shortcode_atts(array(
                'items_number' => '999',
                'category' => 'show_all',
                'columns' =>'3',
                'member_spacing' => 'cl_mode',
                'text_align' => 'hook_center_align',
                'css_delay' =>'',
                'general_style' =>'classic',
                'css_animation' =>'',
                'el_class' =>'',
            ),$atts);
            if ($atts['category']=="show_all") {
                $category="";
            }
            else {
                $category=$atts['category'];
            }
            $items_number=$atts['items_number'];
            //DEFAULT VALUES
            $columns=3;
            $main_classes="small-4 columns";
            if ($atts['columns']==1) {
                $main_classes="small-12 columns";
            }
            if ($atts['columns']==2) {
                $main_classes="small-6 columns";
            }
            if ($atts['columns']==3) {
                $main_classes="small-4 columns";
            }
            if ($atts['columns']==4) {
                $main_classes="small-3 columns";
            }
            if ($atts['columns']==6) {
                $columns=$atts['columns'];
            }
            $columns=$atts['columns'];
            $hook_forced_w=ceil($prk_hook_options['custom_width']/$atts['columns']);
            if ($hook_forced_w<780);
            $hook_forced_w=780;
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            $args=array(
                'post_type' => 'pirenko_team_member',
                'showposts' => $items_number,
                'order_by' => 'menu_order',
                'pirenko_member_group' => $category
            );
            $loop=new WP_Query( $args );
            $out='';
            $i=0;
            $general_style=$atts['general_style'];
            if ($general_style=='classic') {
                $out.='<div class="row prk_row">';
                $out.='<ul class="member_ul unstyled '.$atts['member_spacing'].' '.$atts['text_align'].'">';
                while ( $loop->have_posts() ) : $loop->the_post();
                    if (get_field('member_job')!="")
                        $member_job=get_field('member_job');
                    else
                        $member_job="";
                    if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
                    {
                        $featured_color=get_field('featured_color');
                        $featured_class='featured_color';
                    }
                    else
                    {
                        $featured_color="default";
                        $featured_class="";
                    }

                    $out.='<li class="'.$main_classes.' sh_member_wrapper" data-color="'.$featured_color.'">';
                    if (get_field('show_member_link')=="1")
                    {
                        $out.='<div class="member_colored_block hook_linked" data-link="'.get_permalink().'">';
                    }
                    else
                    {
                        $out.='<div class="member_colored_block">';
                    }
                    $out.='<div class="sh_member_desc">';
                    if (get_field('member_byline')!="") {
                        $out.='<h4 class="header_font sh_member_trg">'.get_field('member_byline').'</h4>';
                    }
                    else {
                        $out.='<h4 class="header_font sh_member_trg">'.get_the_title().'</h4>';
                    }
                    $out.='<div class="sh_member_trg">';
                    $out.=hook_excerpt_dynamic(24,$loop->post->ID);
                    $out.='</div>';
                    $out.='</div>';
                    $out.='<div class="member_colored_block_in">';
                    $out.='</div>';
                    $out.=wp_get_attachment_image( get_post_thumbnail_id( get_the_ID()), array($hook_forced_w,0),'0' );
                    $out.='<div class="hook_member_links">';
                    $out.='<div class="hook_member_links_inner">';
                    if (get_field('member_email')!="")
                    {
                        $out.='<div class="member_lnk">';
                        $out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
                        $out.= '<div class="hook_socialink hook_fa-envelope-o">';
                        $out.='</div>';
                        $out.=' </a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_1')!="none" && get_field('member_social_1')!="") {
                        if (get_field('member_social_1_link')!="")
                            $in_link=get_field('member_social_1_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_1')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_1')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_2')!="none" && get_field('member_social_2')!="") {
                        if (get_field('member_social_2_link')!="")
                            $in_link=get_field('member_social_2_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_2')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_2')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_3')!="none" && get_field('member_social_3')!="") {
                        if (get_field('member_social_3_link')!="")
                            $in_link=get_field('member_social_3_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_3')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_3')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_4')!="none" && get_field('member_social_4')!="") {
                        if (get_field('member_social_4_link')!="")
                            $in_link=get_field('member_social_4_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_4')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_4')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_5')!="none" && get_field('member_social_5')!="") {
                        if (get_field('member_social_5_link')!="")
                            $in_link=get_field('member_social_5_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_5')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_5')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_6')!="none" && get_field('member_social_6')!="") {
                        if (get_field('member_social_6_link')!="")
                            $in_link=get_field('member_social_6_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_6')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_6')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    $out.='</div>';
                    $out.='</div>';
                    $out.='</div>';
                    $out.='<div class="sh_member_name zero_color header_font">';
                    if (get_field('show_member_link')=="1") {
                        $out.='<a href="'.get_permalink().'" class="hook_anchor">';
                        $out.=get_the_title();
                        $out.=' </a>';
                    }
                    else {
                        $out.=get_the_title();
                    }
                    $out.='</div>';
                    $out.='<div class="clearfix"></div>';
                    $out.='<div class="sh_member_function small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                    $out.=$member_job;
                    $out.='</div>';
                    $out.='<div class="clearfix"></div>';
                    $out.='</li>';
                    $i++;
                    if ($i%$columns==0)
                    {
                        $out.='<li class="clearfix"></li>';
                    }
                endwhile;
                $out.='</ul></div>';
            }
            else {
                $out.='<div class="'.$atts['text_align'].'">';
                $touch_enable="false";
                if (isset($prk_hook_options['touch_enable']) && $prk_hook_options['touch_enable']=="1") {
                    $touch_enable="true";
                }
                $out.='<div class="member_ul_slider per_init" data-navigation="true" data-touch='.$touch_enable.'>';
                while ( $loop->have_posts() ) : $loop->the_post();
                    if (get_field('member_job')!="")
                        $member_job=get_field('member_job');
                    else
                        $member_job="";
                    if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
                    {
                        $featured_color=get_field('featured_color');
                        $featured_class='featured_color';
                    }
                    else
                    {
                        $featured_color="default";
                        $featured_class="";
                    }
                    if (has_post_thumbnail( $loop->post->ID ) ){
                        //GET THE FEATURED IMAGE
                        $hook_vt_image=vt_resize(get_post_thumbnail_id($loop->post->ID), '' ,$hook_forced_w ,0 , false , $hook_retina_device );
                        $image_caption=hook_alt_tag(true,get_post_thumbnail_id($loop->post->ID));
                    }
                    else {
                        //THERE'S NO FEATURED IMAGE SO LET'S LOAD A DEFAULT IMAGE
                        $image[0]=get_bloginfo('template_directory')."/images/sample/user.png";
                        $image_caption=hook_alt_tag(false,$image[0]);
                    }
                    $out.='<div class="item sh_member_wrapper" data-color="'.$featured_color.'">';
                    if (get_field('show_member_link')=="1")
                    {
                        $out.='<div class="member_colored_block hook_linked" data-link="'.get_permalink().'">';
                    }
                    else
                    {
                        $out.='<div class="member_colored_block">';
                    }
                    $out.='<div class="sh_member_desc">';
                    if (get_field('member_byline')!="") {
                        $out.='<h4 class="header_font sh_member_trg">'.get_field('member_byline').'</h4>';
                    }
                    else {
                        $out.='<h4 class="header_font sh_member_trg">'.get_the_title().'</h4>';
                    }
                    $out.='<div class="sh_member_trg">';
                    $out.=hook_excerpt_dynamic(24,$loop->post->ID);
                    $out.='</div>';
                    $out.='</div>';
                    $out.='<div class="member_colored_block_in">';
                    $out.='</div>';
                    $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.$image_caption.'" />';
                    $out.='<div class="hook_member_links">';
                    $out.='<div class="hook_member_links_inner">';
                    if (get_field('member_email')!="")
                    {
                        $out.='<div class="member_lnk">';
                        $out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
                        $out.= '<div class="hook_socialink hook_fa-envelope-o">';
                        $out.='</div>';
                        $out.=' </a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
                    {
                        if (get_field('member_social_1_link')!="")
                            $in_link=get_field('member_social_1_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_1')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_1')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
                    {
                        if (get_field('member_social_2_link')!="")
                            $in_link=get_field('member_social_2_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_2')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_2')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
                    {
                        if (get_field('member_social_3_link')!="")
                            $in_link=get_field('member_social_3_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_3')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_3')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
                    {
                        if (get_field('member_social_4_link')!="")
                            $in_link=get_field('member_social_4_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_4')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_4')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
                    {
                        if (get_field('member_social_5_link')!="")
                            $in_link=get_field('member_social_5_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_5')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_5')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
                    {
                        if (get_field('member_social_6_link')!="")
                            $in_link=get_field('member_social_6_link');
                        else
                            $in_link="";
                        $out.='<div class="member_lnk">';
                        $out.='<a href="'.hook_change_links($in_link).'" target="_blank" data-color="'.hook_social_color(get_field('member_social_6')).'">';
                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_6')).'">';
                        $out.='</div>';
                        $out.='</a>';
                        $out.='</div>';
                    }
                    $out.='</div>';
                    $out.='</div>';
                    $out.='</div>';
                    $out.='<div class="sh_member_name zero_color header_font">';
                    if (get_field('show_member_link')=="1")
                    {
                        $out.='<a href="'.get_permalink().'" class="hook_anchor">';
                        $out.=get_the_title();
                        $out.=' </a>';
                    }
                    else
                    {
                        $out.=get_the_title();
                    }
                    $out.='</div>';
                    $out.='<div class="clearfix"></div>';
                    $out.='<div class="sh_member_function small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                    $out.=$member_job;
                    $out.='</div>';
                    $out.='<div class="clearfix"></div>';

                    $out.='</div>';
                    $i++;
                endwhile;
                $out.='</div></div>';
            }
            wp_reset_query();
            return $out;
        }
    }
    add_shortcode('prk_members', 'prk_member_shortcode');

    //PRICING TABLES
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_price_table_shortcode($atts, $content=null) {
        $atts=shortcode_atts(array(
            'color' => '',
            'price' => '',
            'table_align' => 'hook_center_align',
            'button_label' =>'',
            'button_link' => '',
            'under_price' => '',
            'after_price' =>'',
            'serv_image' => '',
            'featured_text' =>'',
            'css_delay' =>'',
            'img_link_target' => '_self',
            'css_animation' =>'',
            'el_class' =>'',
        ),$atts);
        $featured="&nbsp;";
        $main_classes="";
        $color=$atts['color'];
        $price=$atts['price'];
        $button_label=$atts['button_label'];
        $button_link="#";
        if ($atts['button_link']!="") {
            $button_link=hook_change_links($atts['button_link']);
        }
        $after_price="";
        if ($atts['after_price']!="") {
            $after_price='<span class="hook_after_price">'.$atts['after_price'].'</span>';
        }
        $extra_inline="";
        if ($color!="") {
            $extra_inline=' style="background-color:'.$color.';"';
            $main_classes=" featured";
        }
        if ($atts['featured_text']!="") {
            $ribbon='<div class="hook_tables_ribbon"><span class="inner_ribbon">'.$atts['featured_text'].'</span></div>';
        }
        else {
            $ribbon='';
        }
        if ($atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if ($atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        if ($atts['serv_image']!="") {
            $main_classes.=" hook_imaged";
        }
        $output='<div class="prk_price_table hook_bk_site prk_bordered '.$atts['table_align'].$main_classes.'"'.$extra_inline.'>'.$ribbon.'<div class="prk_price_header header_font">';
        if ($atts['serv_image']!="") {
            $array=explode('.', $atts['serv_image']);
            $extension=end($array);
            if($extension=='svg') {

            }
            else {
                $hook_vt_image=vt_resize($atts['serv_image'],'','','',false);
                $output.='<div class="hook_image"><img alt="'.hook_alt_tag(true,$atts['serv_image']).'" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" /></div>';
            }
            if ($button_label!="") {
                $output.='<div class="small-12 prk_price_button"><div class="colored_theme_button small"><a href="'.$button_link.'" class="hook_anchor">'.$button_label.'</a></div></div>';
            }
            $output.='<div class="prk_price prk_heavier_700 zero_color">'.$price.$after_price.'</div><div class="underp not_zero_color prk_heavier_600">'.$atts['under_price'].'</div></div>';
            $output.='<div class="prk_prices_specs">'.$content;
        }
        else {
            $output.='<div class="prk_price prk_heavier_700 zero_color">'.$price.$after_price.'</div><div class="underp not_zero_color prk_heavier_600">'.$atts['under_price'].'</div></div>';
            $output.='<div class="prk_prices_specs">'.$content;
            if ($button_label!="") {
                $output.='<div class="small-12 prk_price_button"><div class="colored_theme_button small"><a href="'.$button_link.'" class="hook_anchor" target="'.$atts['img_link_target'].'">'.$button_label.'</a></div></div>';
            }
        }
        $output.='<div class="clearfix"></div></div></div>';
        return $output;
    }
    add_shortcode('prk_price_table', 'prk_price_table_shortcode');

    //SITEMAP
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_sitemap_shortcode($atts, $content=null ) {
        //start building output string
        $output="<div class='prk_sitemap_wrapper hook_anchor'>";
        $txt_pages="Pages";
        if (isset($atts['txt_pages']) && $atts['txt_pages']!="")
            $txt_pages=$atts['txt_pages'];
        $show_pages="yes";
        if (isset($atts['show_pages']) && $atts['show_pages']!="")
            $show_pages=$atts['show_pages'];
        if ($show_pages=="yes")
        {
            $output.="<h4 class='zero_color prk_heavier_600'>".$txt_pages."</h4>";
            $output.="<ul class='unstyled body_colored'>".wp_list_pages('title_li=&echo=0')."</ul>";
        }
        $txt_blog_cats="Blog categories";
        if (isset($atts['txt_blog_cats']) && $atts['txt_blog_cats']!="")
            $txt_blog_cats=$atts['txt_blog_cats'];
        $show_blog_cats="yes";
        if (isset($atts['show_blog_cats']) && $atts['show_blog_cats']!="")
            $show_blog_cats=$atts['show_blog_cats'];
        if ($show_blog_cats=="yes")
        {
            $output.="<h4 class='zero_color prk_heavier_600'>".$txt_blog_cats."</h4>";
            $output.="<ul class='unstyled body_colored'>".wp_list_categories('title_li=&echo=0&sort_column=name&optioncount=1&hierarchical=0')."</ul>";
        }
        $txt_blog_posts="Blog posts";
        if (isset($atts['txt_posts']) && $atts['txt_posts']!="")
            $txt_blog_posts=$atts['txt_posts'];
        $show_posts="yes";
        if (isset($atts['show_posts']) && $atts['show_posts']!="")
            $show_posts=$atts['show_posts'];
        if ($show_posts=="yes")
        {
            global $month, $wpdb, $wp_version;
            $sql='SELECT
				DISTINCT YEAR(post_date) AS year,
				MONTH(post_date) AS month,
				count(ID) as posts
			FROM '.$wpdb->posts.'
			WHERE post_status="publish"
				AND post_type="post"
				AND post_password=""
			GROUP BY YEAR(post_date),
				MONTH(post_date)
			ORDER BY post_date DESC';
            $archiveSummary=$wpdb->get_results($sql);
            if ($archiveSummary)
            {
                $output.="<h4 class='zero_color prk_heavier_600'>".$txt_blog_posts."</h4>";
                $output.= "<ul class='unstyled body_colored'>";
                foreach ($archiveSummary as $date)
                {
                    // reset the query vastroble
                    unset ($bmWp);
                    $bmWp=new WP_Query('year='.$date->year.'&monthnum='.zeroise($date->month, 2).'&posts_per_page=-1');
                    if ($bmWp->have_posts())
                    {
                        $url=get_month_link($date->year, $date->month);
                        $text=$month[zeroise($date->month, 2)].' '.$date->year;
                        $output.= get_archives_link($url, $text, '', '<li>', '</li>');
                        $output.= '<ul class="children">';
                        while ($bmWp->have_posts())
                        {
                            $bmWp->the_post();
                            $output.= '<li><a href="'.get_permalink($bmWp->post).'" title="'.esc_html($text, 1).'" class="hook_anchor">'.wptexturize($bmWp->post->post_title).'</a></li>';
                        }
                        $output.= '</ul>';
                    }
                }
                $output.= '</ul>';
            }
        }
        $txt_port_posts="Portfolio";
        if (isset($atts['txt_port_posts']) && $atts['txt_port_posts']!="")
            $txt_port_posts=$atts['txt_port_posts'];
        $show_port_posts="yes";
        if (isset($atts['show_port_posts']) && $atts['show_port_posts']!="")
            $show_port_posts=$atts['show_port_posts'];
        if ($show_port_posts=="yes")
        {
            $output.="<h4 class='zero_color prk_heavier_600'>".$txt_port_posts."</h4>";
            $output.= "<ul class='unstyled body_colored'>";
            $terms=get_terms( 'pirenko_skills', 'orderby=name' );
            foreach ($terms as $term) {
                $output.= "<li><a href='".get_term_link($term->slug, 'pirenko_skills')."' class='hook_anchor'>".$term->name."</a>";
                $output.= "<ul class='children'>";
                $args=array(
                    'post_type' => 'pirenko_portfolios',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'pirenko_skills',
                            'field' => 'slug',
                            'terms' => $term->slug
                        )
                    )
                );
                $new=new WP_Query($args);
                while ($new->have_posts()) {
                    $new->the_post();
                    $output.= '<li><a href="'.get_permalink().'" class="hook_anchor">'.get_the_title().'</a></li>';
                }
                $output.= "</ul>";
                $output.= "</li>";
            }
            $output.= "</ul>";
        }
        $output.="</div>";
        return $output;
    }
    add_shortcode('prk_sitemap', 'prk_sitemap_shortcode');

    //COUNTER
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_counter_shortcode($atts, $content=null ) {
        $atts=shortcode_atts(array(
            'counter_origin' =>'0',
            'image'		=>'',
            'link' =>	'',
            'prefix' =>	'',
            'suffix' =>	'',
            'counter_number' =>	'1000',
            'link_text' => '',
            'align' => '',
            'css_animation' => '',
            'text_color' => '',
            'el_class' => '',
            'custom_css' =>'',
            'serv_image' => '',
            'icon_type' => 'material_icons',
            'icon_material' =>'',
            'thousands_separator' =>'',
            'css_delay' => '',
        ), $atts);
        $hook_translated=scodes_translate();
        if ($atts['image']!="fa fa-adjust") {
            $atts['image']=str_replace('fa fa', 'hook_fa', $atts['image']);
        }
        $image=$atts['image'];
        $link=$atts['link'];
        $counter_number=1000;
        if (is_numeric($atts['counter_number'])) {
            $counter_number=$atts['counter_number'];
        }
        $counter_origin=0;
        if (is_numeric($atts['counter_origin']))
            $counter_origin=$atts['counter_origin'];
        $link_text=$hook_translated['read_more'];
        if ($atts['link_text']!="")
            $link_text=$atts['link_text'];
        $main_classes="";
        if ($atts['align']!="") {
            $main_classes.=" ".$atts['align'];
        }
        if ($atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if ($atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        $inline="";
        if ($atts['text_color']!="") {
            $inline=' style="color:'.$atts['text_color'].'"';
        }
        $serv_image="";
        $imager="";
        if ($atts['serv_image']!="") {
            $serv_image=$atts['serv_image'];
        }
        if ($atts['icon_type']=='custom_image') {
            if ($serv_image!="") {
                $array=explode('.', $serv_image);
                $extension=end($array);
                if($extension=='svg') {
                    $imager='<div class="hook_counter_svg"><img alt="'.hook_alt_tag(false,$serv_image).'" src="'.$serv_image.'" /></div>';
                }
                else {
                    $hook_vt_image=vt_resize('',$serv_image,'','',false);
                    $imager='<div class="hook_image"><img alt="'.hook_alt_tag(false,$serv_image).'" src="'.$serv_image.'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" /></div>';
                }
            }
        }
        else {
            if ($atts['icon_type']=='awesome_icons') {
                $imager='<i class="'.$image.' colored_link_icon"></i>';
            }
            else {
                $imager='<i class="'.$atts['icon_material'].' colored_link_icon"></i>';
            }
        }
        if ($imager=="") {
            $main_classes.=" hook_no_img";
        }
        $custom_style=' style="';
        $custom_style.=$atts['custom_css'];
        if ($custom_style==' style="') {
            $custom_style='';
        }
        else {
            $custom_style.='"';
        }
        //Eventually add spaces, because WPBakery Page Builder strips them when we save a page
        if (strpos($atts['el_class'], 'hook_spaced_prefix') !== false) {
            $atts['prefix']=$atts['prefix']." ";
        }
        if (strpos($atts['el_class'], 'hook_spaced_suffix') !== false) {
            $atts['suffix']=" ".$atts['suffix'];
        }
        $out='<div class="prk_counter_wrapper'.$main_classes.'"'.$custom_style.'>';
        $out.=$imager.'<div class="clearfix"></div>';
        $out.='<div id="hook_counter_'. rand(1, 1000) .'" class="header_font hook_counter" data-prefix="'.$atts['prefix'].'" data-suffix="'.$atts['suffix'].'" data-thousands="'.$atts['thousands_separator'].'" data-origin="'.$counter_origin.'" data-counter="'.$counter_number.'" data-duration="3000"'.$inline.'>&nbsp;</div><div class="hook_counter_desc header_font">'.$content.'</div></div>';
        return $out;
    }
    add_shortcode('prk_counter', 'prk_counter_shortcode');

    //SERVICES
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    if (!function_exists('prk_service_shortcode')) {
        function prk_service_shortcode($atts, $content = null)
        {
            $hook_translated = scodes_translate();
            $prk_hook_options = hook_options();
            $atts = shortcode_atts(array(
                'name' => '',
                'link' => '',
                'bk_color' => '',
                'text_color' => '',
                'link_text' => '',
                'window' => '_self',
                'align' => 'left_bigger',
                'text_align' => 'hook_center_align',
                'icon_type' => '',
                'icon' => '',
                'css_animation' => '',
                'el_class' => '',
                'serv_image' => '',
                'icon_up_color' => '',
                'icon_color' => '',
                'icon_material' => '',
                'css_delay' => '',
                'hook_link' => 'hook_default_service',
            ), $atts);
            $name = $atts['name'];
            $link = $atts['link'];
            $window = $atts['window'];
            $link_text = $hook_translated['read_more'];
            if ($atts['link_text'] != "")
                $link_text = $atts['link_text'];
            $main_classes = "";
            $extra = "";
            if ($atts['bk_color'] != "") {
                $main_classes .= " serv_with_color";
                $extra = ' style="background-color:'.$atts['bk_color'].';"';
            }
            $imager = $inline_icon = $inline = "";
            $default_color = "default";
            if ($atts['text_color'] != "") {
                $inline = ' style="color:'.$atts['text_color'].'"';
            }
            if ($atts['icon_up_color'] != "") {
                $inline_icon = ' style="color:'.$atts['icon_up_color'].'"';
                $default_color = $atts['icon_up_color'];
            }
            $main_classes .= " ".$atts['align'];
            if ($atts['align'] == "prk_service_center" || $atts['align'] == "prk_service_center hook_smaller_service") {
                $main_classes .= " ".$atts['text_align'];
            }
            if ($atts['css_animation'] != "") {
                $main_classes .= " wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay'] != "") {
                $main_classes .= " delay-".$atts['css_delay'];
            }
            if ($atts['el_class'] != "") {
                $main_classes .= " ".$atts['el_class'];
            }
            if ($atts['icon_color'] != "") {
                $featured_color = $atts['icon_color'];
            } else {
                $featured_color = "default";
            }
            $serv_image = $atts['serv_image'];
            if ($atts['icon_type'] == 'custom_image') {
                if ($serv_image != "") {
                    $hook_vt_image = vt_resize('', $serv_image, '', '', false);
                    $image_dims = "";
                    if ($hook_vt_image['width'] != "") {
                        $image_dims .= ' width="'.esc_attr($hook_vt_image['width']).'"';
                    }
                    if ($hook_vt_image['height'] != "") {
                        $image_dims .= ' height="'.esc_attr($hook_vt_image['height']).'"';
                    }
                    $array = explode('.', $serv_image);
                    $extension = end($array);
                    if ($extension == 'svg') {
                        $imager = '<div class="serv_holder"><div class="hook_svg"><img alt="'.hook_alt_tag(false, $serv_image).'" src="'.$serv_image.'"'.$image_dims.' /></div></div>';
                    } else {
                        $imager = '<div class="serv_holder"><div class="hook_image"><img alt="'.hook_alt_tag(false, $serv_image).'" src="'.$serv_image.'"'.$image_dims.' /></div></div>';
                    }
                } else {
                    $main_classes .= ' no_img_serv';
                }
            } else {
                $image = "";
                if ($atts['icon_type'] == 'awesome_icons') {
                    $image = str_replace('fa fa', 'hook_fa', $atts['icon']);
                } else {
                    $image = $atts['icon_material'];
                }
                $imager = '<i class="'.$image.' colored_link_icon small_headings_color"'.$inline_icon.'></i>';
            }
            if ($link == "")
                return '<div class="prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'">'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="hook_service_desc wpb_text_column">'.$content.'</div></div></div>';
            else {
                if ($atts['hook_link'] == 'hook_linked_service') {
                    return '<a href="'.$link.'" target="'.$window.'"><div class="prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'">'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="service_inner_desc hook_service_desc wpb_text_column">'.$content.'</div></div></div></a>';
                } else {
                    return '<div class="prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'">'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="service_inner_desc hook_service_desc wpb_text_column">'.$content.'</div><div class="simple_line thick special_size"></div><div class="service_lnk prk_heavier_600 header_font"><a class="zero_color hook_anchor" href="'.$link.'" target="'.$window.'"'.$inline.'>'.$link_text.'</a></div></div></div>';
                }
            }
        }
    }
    add_shortcode('prk_service', 'prk_service_shortcode');


    //HOVER BOX
    if (!function_exists('prk_hover_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function prk_hover_shortcode($atts, $content=null ) {
            $hook_translated=scodes_translate();
            $prk_hook_options=hook_options();
            $atts=shortcode_atts(array(
                'name' =>'',
                'link' =>	'',
                'bk_color' =>	'',
                'text_color' =>	'',
                'desc_color' => '',
                'link_text' => '',
                'window' => '_self',
                'align' => 'left_bigger',
                'text_align' => 'hook_center_align',
                'icon_type' => '',
                'icon' => '',
                'css_animation' => '',
                'el_class' => '',
                'serv_image' => '',
                'icon_up_color' => '',
                'icon_color' => '',
                'icon_material' =>'',
                'css_delay' => '',
                'hook_link' => 'hook_default_service',
            ), $atts);
            $name=$atts['name'];
            $link=$atts['link'];
            $window=$atts['window'];
            $link_text=$hook_translated['read_more'];
            if ($atts['link_text']!="")
                $link_text=$atts['link_text'];
            $main_classes="";
            $extra="";
            if ($atts['desc_color']!="") {
                $extra=' style="color:'.$atts['desc_color'].';"';
            }
            $extra_box="";
            if ($atts['bk_color']!="") {
                $extra_box=' style="background-color:'.$atts['bk_color'].';"';
            }
            $imager=$inline_icon=$inline="";
            $default_color="default";
            if ($atts['text_color']!="") {
                $inline=' style="color:'.$atts['text_color'].'"';
            }
            if ($atts['icon_up_color']!="") {
                $inline_icon=' style="color:'.$atts['icon_up_color'].'"';
                $default_color=$atts['icon_up_color'];
            }
            $main_classes.=" ".$atts['align'];
            if ($atts['align']=="prk_service_center" || $atts['align']=="prk_service_center hook_smaller_service") {
                $main_classes.=" ".$atts['text_align'];
            }
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            if ($atts['icon_color']!="") {
                $featured_color=$atts['icon_color'];
            }
            else {
                $featured_color="default";
            }
            $serv_image=$atts['serv_image'];
            if ($atts['icon_type']=='custom_image') {
                if ($serv_image!="") {
                    $hook_vt_image=vt_resize('',$serv_image,'','',false);
                    $image_dims="";
                    if ($hook_vt_image['width']!="") {
                        $image_dims.=' width="'.esc_attr($hook_vt_image['width']).'"';
                    }
                    if ($hook_vt_image['height']!="") {
                        $image_dims.=' height="'.esc_attr($hook_vt_image['height']).'"';
                    }
                    $array=explode('.', $serv_image);
                    $extension=end($array);
                    if($extension=='svg') {
                        $imager='<div class="serv_holder"><div class="hook_svg"><img alt="'.hook_alt_tag(false,$serv_image).'" src="'.$serv_image.'"'.$image_dims.' /></div></div>';
                    }
                    else {
                        $imager='<div class="serv_holder"><div class="hook_image"><img alt="'.hook_alt_tag(false,$serv_image).'" src="'.$serv_image.'"'.$image_dims.' /></div></div>';
                    }
                }
                else {
                    $main_classes.=' no_img_serv';
                }
            }
            else {
                $image="";
                if ($atts['icon_type']=='awesome_icons') {
                    $image=str_replace('fa fa', 'hook_fa', $atts['icon']);
                }
                else {
                    $image=$atts['icon_material'];
                }
                $imager='<i class="'.$image.' colored_link_icon small_headings_color"'.$inline_icon.'></i>';
            }
            if ($link=="")
                return '<div class="prk_hover_box prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'"><div class="hook_bk_site hook_hover_box"'.$extra_box.'></div>'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="hook_service_desc wpb_text_column">'.$content.'</div></div></div>';
            else {
                if ($atts['hook_link']=='hook_linked_service') {
                    return '<a href="'.$link.'" target="'.$window.'"><div class="prk_hover_box prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'"><div class="hook_bk_site hook_hover_box"'.$extra_box.'></div>'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="service_inner_desc hook_service_desc wpb_text_column">'.$content.'</div></div></div></a>';
                }
                else {
                    return '<div class="prk_hover_box prk_service'.$main_classes.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'"><div class="hook_bk_site hook_hover_box"'.$extra_box.'></div>'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color header_font prk_heavier_600"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="service_inner_desc hook_service_desc wpb_text_column">'.$content.'</div><div class="simple_line thick special_size"></div><div class="service_lnk prk_heavier_600 header_font"><a class="zero_color hook_anchor" href="'.$link.'" target="'.$window.'"'.$inline.'>'.$link_text.'</a></div></div></div>';
                }
            }
        }
    }
    add_shortcode('prk_hover_box', 'prk_hover_shortcode');


    //SIMPLE LINE
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function simple_line_shortcode($atts, $content=null ) {
        $prk_hook_options=hook_options();
        $custom_color=$custom_icon=$custom_icon_color="";
        $out="";
        $custom_color=' style="';
        if (isset($atts['color']) && $atts['color']!="") {
            $custom_color.='border-bottom-color:'.$atts['color'].';';
        }
        if (isset($atts['width']) && $atts['width']!="") {
            $custom_color.='width:'.$atts['width'].';';
        }
        if (isset($atts['height']) && $atts['height']!="") {
            $custom_color.='border-bottom-width:'.$atts['height'].';';
        }
        if (isset($atts['align']) && $atts['align']!="") {
            if ($atts['align']=="left") {
                $custom_color.='float:left;';
            }
            if ($atts['align']=="center") {
                $custom_color.='margin-left:auto;margin-right:auto;';
            }
            if ($atts['align']=="right") {
                $custom_color.='float:right;';
            }
        }
        if ($custom_color==' style="') {
            $custom_color="";
        }
        else {
            $custom_color.='"';
        }
        $main_classes="";
        if (isset($atts['el_class']) && $atts['el_class']!="") {
            $main_classes=" ".$atts['el_class'];
        }
        if (isset($atts['css_animation']) && $atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if (isset($atts['css_delay']) && $atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        $out.='<div class="simple_line shortcoded'.$main_classes.'"'.$custom_color.'>';
        $out.='</div><div class="clearfix"></div>';
        return $out;
    }
    add_shortcode('prk_line', 'simple_line_shortcode');


    //THEME BUTTONS
    if (!function_exists('button_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function button_shortcode($atts, $content=null ) {
            $atts=shortcode_atts(array(
                'caption'    	 => 'This is my text',
                'icon'		 => 'heart',
                'button_bk_color' =>'',
                'button_icon' =>'',
                'el_class' => '',
                'custom_css' => '',
                'css_animation' => '',
                'link' => '',
                'type' => 'theme_button',
                'button_size' => 'prk_large',
                'window' => '_self',
                'css_delay' => '',
            ), $atts);
            $main_classes=$atts['type'];
            $main_classes.=' '.$atts['button_size'];
            $window=$atts['window'];
            $custom_style=' style="';
            $custom_style.=$atts['custom_css'];
            if ($atts['button_bk_color']!="") {
                $custom_style.='border-color:'.$atts['button_bk_color'].';color:'.$atts['button_bk_color'].'" data-color="'.$atts['button_bk_color'].'';
            }
            if ($custom_style==' style="') {
                $custom_style='';
            }
            else {
                $custom_style.='"';
            }
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            $main_classes.=' hook_shortcoded';
            $icon="";
            if ($atts['button_icon']!="") {
                $icon='<div class="icon_cell"><i class="'.$atts['button_icon'].'"></i></div>';
                $content='<div class="text_shifter">'.$content.'</div>';
            }
            $out='<div class="'.$main_classes.'"><a href="'.hook_change_links($atts['link']).'" target="'.$window.'" class="hook_anchor"'.$custom_style.'>'.$content.$icon.'</a></div>';
            return $out;
        }
    }
    add_shortcode('theme_button', 'button_shortcode');

    //EXTRA FUNCTION FOR LIGHTBOX
    if (!function_exists('get_lightbox_content')) {
        /**
         * @param $flag
         * @param $pos
         * @param $post
         * @return string
         */
        function get_lightbox_content($flag, $pos, $post)
        {
            $lg_out = "";
            if ($flag == true) {
                $lg_out .= '<div class="hide_now">';
                $ext_count = 0;
                if (get_field('use_gallery') != "images_only") {
                    //PLACE THE OTHER NINETEEN IMAGES
                    for ($count = $pos; $count < 21; $count++) {
                        if (get_field('image_' . $count) != "") {
                            $ext_count++;
                            $in_image = wp_get_attachment_image_src(get_field('image_' . $count), 'full');
                            $lg_out .= '<div class="magnificent" data-mfp-src="' . $in_image[0] . '" data-title="' . hook_alt_tag(true, get_field('image_' . $count)) . '"></div>';
                        }
                        if (get_field('video_' . $count) != "") {
                            $ext_count++;
                            $magnific_image[0] = hook_get_iframe_src(get_field('video_' . $count));
                            $lg_out .= '<div class="magnificent mfp-iframe" data-mfp-src="' . $magnific_image[0] . '" data-title=""></div>';
                        }
                    }
                } else {
                    $regex = '/(\w+)\s*=\s*"(.*?)"/';
                    $pattern = '/\[gallery(.*?)\]/';
                    preg_match_all($regex, get_post_meta($post, 'image_gallery', true), $matches);
                    $stripped_gallery = array();
                    for ($i = 0; $i < count($matches[1]); $i++) {
                        $stripped_gallery[$matches[1][$i]] = $matches[2][$i];
                    }
                    if (!empty($stripped_gallery) && $stripped_gallery['ids'] != "") {
                        $array = explode(',', $stripped_gallery['ids']);
                        foreach ($array as $value) {
                            $ext_count++;
                            $in_image = wp_get_attachment_image_src($value, 'full');
                            $lg_out .= '<div class="magnificent" data-value="' . $value . '" data-mfp-src="' . $in_image[0] . '" data-title="' . hook_alt_tag(true, $value) . '"></div>';
                        }
                    }
                }
                $lg_out .= '</div>';
            }
            return $lg_out;
        }
    }

    //LATEST PORTFOLIOS
    if (!function_exists('pirenko_last_portfolios_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_last_portfolios_shortcode($atts, $content=null ) {
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $hook_translated=scodes_translate();
            $atts=shortcode_atts(array(
                'cols_number' => '3',
                'items_number' => '9',
                'cat_filter' => '',
                'tag_filter' => '',
                'show_filter' => 'yes',
                'layout_type_folio' => 'packery',
                'thumbs_mg' => '10',
                'thumbs_type_folio' => 'overlayed',
                'lightbox_type' => 'singled',
                'show_load_more' => 'yes',
                'hook_show_skills' => 'folio_title_and_skills',
                'exclude_post' => '',
                'videos_behavior' => 'resume',
                'hook_preload' => 'yes',
                'panels_number' => '3',
                'text_align' =>'hook_lf',
                'multicolored_thumbs' => 'yes',
                'filter_align' => 'hook_center_align',
                'special_text_color' =>'0',
                'panel_alpha' => '80',
                'active_filter' => '--',
                'autoplay' =>'0',
                'autoplay_delay' => '7000',
                'mute_button' => 'hide_now',
                'vol_state' => 'sound_on',
                'panels_display' => 'hook_def_panel',
                'css_animation' => '',
                'css_delay' => '',
                'text_swap' => 'hook_center_align',
                'el_class' =>'',
                'load_all' => 'false',
            ), $atts);
            if ($atts['panels_display']=="") {
                $atts['panels_display']='hook_def_panel';
            }
            if (isset($prk_hook_options['load_all']) && $prk_hook_options['load_all']==1) {
                $atts['load_all']="true";
            }
            $cols_number=$atts['cols_number'];
            $items_number=$atts['items_number'];
            $cat_filter=$atts['cat_filter'];
            $show_filter=$atts['show_filter'];
            $layout_type_folio=$atts['layout_type_folio'];
            $thumbs_mg=$atts['thumbs_mg'];
            $thumbs_type_folio=$atts['thumbs_type_folio'];
            $sides_pad=$thumbs_mg;
            if ($layout_type_folio=="packery") {
                $sides_pad="0";
            }
            $show_load_more=true;
            if (isset($atts['show_load_more']) && $atts['show_load_more']=="no") {
                $show_load_more=false;
            }
            switch ($thumbs_type_folio) {
                case 'lightboxed':
                    $anchor_type="magnificent";
                    break;
                case 'classiqued':
                    $anchor_type="hook_anchor";
                    break;
                case 'hook_unlinked':
                    $anchor_type="hook_unlinked";
                    break;
                default:
                    $anchor_type="overlayed_anchor per_init";
                    break;
            }
            $hook_show_skills=false;
            if (strpos($atts['hook_show_skills'], 'title_and_skills') !== false) {
                $hook_show_skills=true;
            }
            $main_classes=$panels_behavior="";
            $videos_behavior=' autoplay="autoplay" muted=""';
            if($atts['videos_behavior']!="default") {
                $videos_behavior='';
                if ($atts['videos_behavior']=='restart') {
                    $panels_behavior=' hook_autoplay"';
                    $main_classes=' hook_autoplay';
                }
                else {
                    $panels_behavior=' hook_autoplay hook_resume"';
                    $main_classes=' hook_autoplay hook_resume';
                }
            }
            $exclude_post="";
            if ($atts['exclude_post']!="") {
                $exclude_post=array($atts['exclude_post']);
            }
            $custom_query=new WP_Query();
            if (isset($atts['tag_filter']) && $atts['tag_filter']!="") {
                $args=array (	'post_type' => 'pirenko_portfolios',
                    'posts_per_page' => 999,
                    'portfolio_tag'=>$atts['tag_filter'],
                    'post__not_in'=>$exclude_post,
                );
            }
            else {
                $args=array (
                    'post_type' => 'pirenko_portfolios',
                    'posts_per_page' => 999,
                    'pirenko_skills'=>$cat_filter,
                    'post__not_in'=>$exclude_post,
                );
            }
            $custom_query->query($args);
            $hook_stop_flag=true;
            if ($thumbs_mg=="") {
                $thumbs_mg=0;
            }
            $thumbs_mg_2=$thumbs_mg*2;
            if ($show_filter=="yes") {
                $thumbs_mg_2=0;
            }
            $output="";
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            if ($layout_type_folio=="panels" || $layout_type_folio=="featured") {
                $sides_pad=$thumbs_mg=0;
                $show_filter="no";
                if ($atts['hook_show_skills']=="folio_always_title_and_skills") {
                    $atts['hook_show_skills']="folio_title_and_skills hook_panel_text";
                }
                if ($atts['hook_show_skills']=="folio_always_title_only") {
                    $atts['hook_show_skills']="folio_title_only hook_panel_text";
                }
                $cols_number=$atts['panels_number'];
                $show_load_more=false;
                if ($layout_type_folio=="featured") {
                    $cols_number=1;
                }
            }
            else {
                if ($atts['hook_show_skills']!="folio_always_title_and_skills" && $atts['hook_show_skills']!="folio_always_title_only") {
                    $main_classes.=" ".$prk_hook_options['thumbs_text_position'];
                }
                if($atts['hook_preload']!="no") {
                    $main_classes.=" hook_preloaded";
                }
            }
            if ($custom_query->have_posts()) {
                if($layout_type_folio=="info_board") {
                    $output.='<div class="hook_info_board">';
                    $output.='<ul class="unstyled">';
                    $output.='<li class="hook_board_heading header_font prk_heavier_700 zero_color">';
                    $output.='<span style="width:15%;">Date</span>';
                    $output.='<span style="width:45%;">Skills</span>';
                    $output.='<span style="width:20%;">Client</span>';
                    $output.='<span style="width:20%;">More Info</span>';
                    $output.='</li>';
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        $skills_links=array();
                        $skills_names=array();
                        $skills_yo="";
                        $skills_output="";
                        $terms=get_the_terms (get_the_ID(), 'pirenko_skills');
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $skills_links[]=$term->slug;
                                $skills_names[]=$term->name;
                            }
                            $skills_yo=join(" ", $skills_links);
                            $skills_output=join(", ", $skills_names);
                        }
                        $output.='<li class="hook_board_entry prk_bordered_top prk_9_em">';
                        $output.='<span style="width:15%;min-height:1px;">'.get_the_time(get_option('date_format')).'</span>';
                        $output.='<span style="width:45%;min-height:1px;">'.$skills_output.'</span>';
                        $output.='<span style="width:20%;min-height:1px;">'.get_field('client_url').'</span>';
                        $output.='<span style="width:20%;min-height:1px;">';
                        $output.='<a href="'.get_permalink().'" class="zero_color hook_italic prk_heavier_600">View Report →</a>';
                        $output.='</span>';
                        $output.='</li>';
                    endwhile;
                    $output.='</ul>';
                    $output.='<div class="clearfix"></div>';
                    $output.='</div>';
                }
                else if($layout_type_folio=="vertical") {
                    $multi_light=false;
                    $appender_class="";
                    if ($anchor_type=="magnificent" && $atts['lightbox_type']=='multipled') {
                        $main_classes.=" multipled";
                        $appender_class.=" lightboxed";
                        $multi_light=true;
                    }
                    $output.='<div class="recentfolio_ul_wp hook_vertical_folio owl-wrapper '.$thumbs_type_folio.$main_classes.'">';
                    //TEXT POSITION    			
                    if($atts['text_align']=="hook_ct") {
                        $row_params=' row_height="forced_row vertical_forced_row"';
                    }
                    else {
                        $row_params=' row_height="forced_row bottom_forced_row"';
                    }
                    if($atts['text_swap']!="hook_swap") {
                        $row_params.=' align="'.$atts['text_swap'].'"';
                    }
                    if($prk_hook_options['header_opacity_after']=="0" || $prk_hook_options['menu_hide_flag']=="1" || $prk_hook_options['menu_display']=="st_hidden_menu") { }
                    else {
                        if ($prk_hook_options['menu_collapse_flag']=="0" && $prk_hook_options['menu_display']!="st_hidden_menu") {
                            $row_params.=' height_adjust="'.$prk_hook_options['menu_vertical'].'"';
                        }
                        else {
                            $row_params.=' height_adjust="'.$prk_hook_options['collapsed_menu_vertical'].'"';
                        }
                    }
                    $counter=0;
                    $after_video=false;
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        if ($counter<$items_number) {
                            if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
                                $featured_color=get_field('featured_color');
                                $row_var_class="featured_color color_trigger ";
                            }
                            else
                            {
                                $featured_color="default";
                                $row_var_class="";
                            }
                            $magnific_image=$image=wp_get_attachment_image_src(get_post_thumbnail_id(),'');
                            $skills_names=array();
                            $skills_output="";
                            $terms=get_the_terms (get_the_ID(), 'pirenko_skills');
                            if (!empty($terms)) {
                                foreach ($terms as $term) {
                                    $skills_names[]=$term->name;
                                }
                                $skills_output=join(", ", $skills_names);
                            }
                            //BUILD ROW
                            $row_var_params="";
                            if (get_field('video_thumb')!="") {
                                if ($image[0]!="") {
                                    $custom_poster=get_post_thumbnail_id();
                                }
                                else {
                                    $custom_poster="";
                                }
                                $row_var_params.=' bk_element=video';
                                $row_var_params.=' vid_image="'.$custom_poster.'"';
                                $row_var_params.=' vid_mp4="'.get_field('video_thumb').'"';
                                $row_var_params.=' vid_webm="'.get_field('video_thumb_webm').'"';
                                $after_video=true;
                            }
                            else {
                                $row_var_params.=' bg_image="'.get_post_thumbnail_id().'"';
                                $row_var_params.=' bk_element="image"';
                                $row_var_params.=' bg_image_repeat="hook_with_parallax hook_attached"';
                                if ($after_video==true) {
                                    $row_var_class.='after_video ';
                                }
                                $after_video=false;
                            }
                            $row_var_params.=' el_class="'.rtrim($row_var_class).'"';
                            $vertical_title='<div class="hook_vt_title">';
                            if (get_field('custom_logo',$custom_query->post->ID)!="") {
                                $in_image=wp_get_attachment_image_src(get_field('custom_logo',$custom_query->post->ID),'full');
                                $hook_vt_image=vt_resize('', $in_image[0] , '', '', false , $hook_retina_device);
                                $vertical_title.='<img class="hook_folio_th" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo',$custom_query->post->ID)).'" />';
                            }
                            else {
                                $vertical_title.='<h2 class="header_font body_bk_color big">'.get_the_title().'</h2>';
                            }
                            if ($skills_output!="" && $hook_show_skills==true) {
                                $vertical_title.='<div class="body_bk_color prk_heavier_600 hook_italic prk_11_em '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                                if (get_field('thumb_skills')!="") {
                                    $vertical_title.=get_field('thumb_skills');
                                }
                                else {
                                    $vertical_title.=$skills_output;
                                }
                                $vertical_title.='</div>';
                            }
                            $vertical_title.='</div>';

                            //BUILD LINK
                            $extra_mfp="";
                            $first_pos=1;
                            if (get_field('skip_featured')==1) {
                                //CHECK IF THERE'S A SECOND IMAGE
                                if (get_field('image_2')!="") {
                                    $in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                    $magnific_image[0]=$in_image[0];
                                    $first_pos=3;
                                }
                                else if (get_field('video_2')) {
                                    $magnific_image[0]=hook_get_iframe_src(get_field('video_2'));
                                    $extra_mfp=" mfp-iframe";
                                    $first_pos=3;
                                }
                            }
                            if ($anchor_type!="hook_unlinked") {
                                $href_val=get_permalink();
                                $target="";
                                if (get_field('skip_to_external')==1 && get_field('ext_url')!="") {
                                    $href_val=get_field('ext_url');
                                    //ADD HTTP PREFIX IF NEEDED
                                    if (substr($href_val,0,7)!="http://" && substr($href_val,0,8)!="https://" && substr($href_val,0,7)!="mailto:")
                                        $href_val="http://".$href_val;
                                    $target=' target="_blank"';
                                    if (get_field('new_window')=="_self") {
                                        $target=' target="_self"';
                                    }
                                }
                                $row_link='<a href="'.$href_val.'" class="'.$anchor_type.$extra_mfp.'" data-mfp-src="'.esc_attr($magnific_image[0]).'" data-title="'.get_the_title().'"'.$target.'>';
                                $row_close_link='</a>';
                            }
                            else {
                                $row_link=$row_close_link='';
                            }
                            $counter++;
                            if($atts['text_swap']=="hook_swap") {
                                if ($counter%2==0) {
                                    $row_var_params.=' align="hook_right_align"';
                                }
                                else {
                                    $row_var_params.=' align="hook_left_align"';
                                }
                            }
                            if ($counter<$items_number) {
                                $row_var_params.=' append_arrow="yes" append_arrow_color="'.$prk_hook_options['slider_text_color'].'"';
                            }
                            $output.=do_shortcode('[vc_row el_id="hook_folio-'.$counter.'"'.$row_params.$row_var_params.']'.$row_link.$vertical_title.'<div class="hook_panel_read body_bk_color"><div class="ghost_theme_button"><span  data-color="'.$featured_color.'">'.$hook_translated['launch_text'].'<span></span></span></div></div>'.get_lightbox_content($multi_light,$first_pos,$custom_query->post->ID).$row_close_link.'[/vc_row]');
                        }
                    endwhile;
                    $output.='</div>';

                }
                else {
                    $multi_light=false;
                    $appender_class="";
                    if ($anchor_type=="magnificent" && $atts['lightbox_type']=='multipled') {
                        $main_classes.=" multipled";
                        $appender_class.=" lightboxed";
                        $multi_light=true;
                    }
                    $main_classes.=" hookz-".$cols_number;
                    $output.='<div id="folio_wrap-'.rand(1, 100000).'" class="recentfolio_ul_wp prk_shorts '.$atts['hook_show_skills'].$main_classes.'" data-items="'.$items_number.'" style="padding-top: '.$thumbs_mg_2.'px;">';
                    $shifted="";
                    $ins=0;
                    if ($show_filter=="yes") {
                        if (strpos($atts['el_class'], 'multifilter') !== false) {
                            $terms=get_terms(array( 'taxonomy' => 'pirenko_skills', 'parent' => 0 ));
                            $count=count($terms);
                            if ( $count > 0) {
                                $filter_array=explode(",",$cat_filter);
                                $filter_array=array_filter(array_map('trim', $filter_array));
                                $output.='<div class="clearfix"></div>';
                                $output.='<div class="filter_folio header_font multifilter">';
                                $output.='<div class="hook_folio_filter '.esc_attr($atts['filter_align']).'" data-text="'.esc_attr($hook_translated['all_text']).'">';
                                $output.='<ul class="header_font hook_folio_uppercased clearfix small_headings_color prk_heavier_600 unstyled">';
                                foreach ( $terms as $term ) {
                                    if (in_array($term->slug, $filter_array) !== false || $cat_filter=="") {
                                        $output.='<li class="small p_filter parent_filter active"><a class="multifilter '.esc_attr($term->slug).'" data-filter="'.esc_attr($term->slug).'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($term->name).'</a></li><ul class="inner_filter prk_lf" data-current="">';
                                        $chidlren_terms=get_term_children($term->term_id,'pirenko_skills');
                                        foreach ( $chidlren_terms as $chidlren_term ) {
                                            $chidlren_term_obj = get_term( $chidlren_term, 'pirenko_skills' );
                                            if (in_array($chidlren_term_obj->slug, $filter_array) !== false || $cat_filter=="") {
                                                $output.='<li class="small p_filter"><a class="multifilter '.esc_attr($chidlren_term_obj->slug).'" data-filter="'.esc_attr($chidlren_term_obj->slug).'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($chidlren_term_obj->name).'</a></li>';
                                            }
                                        }
                                        $output.='</ul><li class="clearfix"></li>';
                                    }
                                }
                                $output.='</ul>';
                                $output.='</div>';
                                $output.='</div>';
                            }
                        }
                        else {
                            $terms=get_terms("pirenko_skills");
                            $count=count($terms);
                            $filter_array=explode(",",$cat_filter);
                            $filter_array=array_filter(array_map('trim', $filter_array));
                            $output.='<div class="clearfix"></div>';
                            $output.='<div class="filter_folio header_font">';
                            $output.='<div class="hook_folio_filter '.esc_attr($atts['filter_align']).'" data-text="'.esc_attr($hook_translated['all_text']).'">';
                            $output.='<ul class="header_font hook_folio_uppercased clearfix small_headings_color prk_heavier_600 unstyled">';
                            $output.='<li class="active small p_filter">';
                            $output.='<a class="all" data-filter="p_all" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">';
                            $output.=esc_attr($hook_translated['all_text']);
                            $output.='</a>';
                            $output.='</li>';
                            if ( $count > 0) {
                                foreach ( $terms as $term ) {
                                    if (in_array($term->slug, $filter_array) !== false || $cat_filter=="") {
                                        $output.='<li class="small p_filter"><a class="'.esc_attr($term->slug).'" data-filter="'.esc_attr($term->slug).'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($term->name).'</a></li>';
                                    }
                                }
                            }
                            $output.='</ul>';
                            $output.='</div>';
                            $output.='</div>';
                        }
                        if ($thumbs_mg<18) {
                            $output.='<div class="clearfix" style="margin-bottom: 18px"></div>';
                        }
                        else {
                            $output.='<div class="clearfix" style="margin-bottom: '.$thumbs_mg.'px"></div>';
                        }
                    }
                    $multicolored_thumbs=$data_button="";
                    if ($atts['multicolored_thumbs']!="yes" && $atts['multicolored_thumbs']!="1") {
                        $multicolored_thumbs=" default_colored_th";
                    }
                    $panels_params="";
                    $folio_type='folio_masonry columnize-'.$cols_number;
                    if ($layout_type_folio=="panels") {
                        $folio_type='folio_panels pnz-'.$cols_number;
                        if ($atts['text_align']!="") {
                            $folio_type.=' '.$atts['text_align'];
                        }
                        if ($anchor_type=="hook_unlinked") {
                            $folio_type.=' hook_unlinked';
                        }
                        $output.='<div class="hook_panels_bk'.$panels_behavior.'"></div><div id="hook_panels_vol" class="'.$atts['mute_button'].'" data-default="'.$atts['vol_state'].'"><i class="mdi-volume-high"></i></div>';
                    }
                    if ($layout_type_folio=="featured") {
                        $folio_type='folio_panels pnz-'.$cols_number;
                        if ($atts['text_align']!="") {
                            $folio_type.=' '.$atts['text_align'];
                        }
                        if ($atts['special_text_color']=="1") {
                            $folio_type.=' hook_colored';
                            $data_button=' data-hover_color="'.$prk_hook_options['thumbs_text_color'].'"';
                        }
                        $output.='<div class="hook_panels_bk'.$panels_behavior.'"></div>';
                        $output.='<div id="hook_featured_nav"></div><div id="hook_naver_feat" class="not_zero_color prk_75_em prk_heavier_600"></div>';
                        $panels_params=' data-autoplay="'.$atts['autoplay'].'" data-delay="'.$atts['autoplay_delay'].'"';
                    }
                    $initial_filter="";
                    if ($atts['active_filter']=="--") {
                        $atts['active_filter']='*';
                    }
                    if ($atts['active_filter']!='*') {
                        $initial_filter='.'.$atts['active_filter'];
                    }
                    $output.='<div id="folio_masonry-'.rand(1, 500).'" class="'.$folio_type.' layout-'.$layout_type_folio.' '.$atts['panels_display'].' '.$thumbs_type_folio.$multicolored_thumbs.' per_init" data-columns="'.$cols_number.'" data-pad="'.$sides_pad.'" style="margin-right:-'.$thumbs_mg.'px;" data-anim="fadeUp"'.$panels_params.' data-panels="'.$atts['panels_display'].'" data-load_all="'.$atts['load_all'].'" data-filter="'.$initial_filter.'">';
                    $panel_style="";
                    if ($layout_type_folio!="panels" && $layout_type_folio!="featured") {
                        $output.='<div class="grid-sizer"></div>';
                    }
                    else if ($atts['panel_alpha']>0) {
                        if ($atts['panels_display']=="hook_img_panel") {
                            $panel_style='border-right:1px solid '.hook_html2rgba('#000000',80);
                        }
                        else {
                            $panel_style='border-right:1px solid '.hook_html2rgba($prk_hook_options['thumbs_text_color'],$atts['panel_alpha']);
                        }
                    }
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        $skills_links=array();
                        $skills_names=array();
                        $skills_yo="";
                        $skills_output="";
                        $terms=get_the_terms (get_the_ID(), 'pirenko_skills');
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $skills_links[]=$term->slug;
                                $skills_names[]=$term->name;
                            }
                            $skills_yo=join(" ", $skills_links);
                            $skills_output=join(", ", $skills_names);
                        }
                        $magnific_image=$image=wp_get_attachment_image_src(get_post_thumbnail_id(),'');
                        $alt_text=hook_alt_tag(true,get_post_thumbnail_id());
                        if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
                            $featured_color=get_field('featured_color');
                            $featured_class="featured_color ";
                        }
                        else {
                            $featured_color="default";
                            $featured_class="";
                        }
                        $extra_mfp="";
                        if ($multi_light==true) {
                            $light_title=hook_alt_tag(true,get_post_thumbnail_id($custom_query->post->ID));
                        }
                        else {
                            $light_title=get_the_title();
                        }
                        $first_pos=1;
                        if (get_field('skip_featured')==1) {
                            //CHECK IF THERE'S A SECOND IMAGE
                            if (get_field('image_2')!="") {
                                $in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                $light_title=hook_alt_tag(true,get_field('image_2'));
                                $magnific_image[0]=$in_image[0];
                                $first_pos=3;
                            }
                            else if (get_field('video_2')) {
                                $magnific_image[0]=hook_get_iframe_src(get_field('video_2'));
                                $extra_mfp=" mfp-iframe";
                                $light_title=get_the_title();
                                $first_pos=3;
                            }
                        }
                        if ($ins<$items_number) {
                            $widtha=get_field('custom_width',$custom_query->post->ID);
                            if ($layout_type_folio!="packery") {
                                $widtha="hook_hz_one";
                            }
                            $output.='<div class="'.$widtha.' hook_or_'.get_field('orientation',$custom_query->post->ID).' portfolio_entry_li '.$featured_class.$skills_yo.' p_all" data-color="'.$featured_color.'" style="padding-right:'.$thumbs_mg.'px;padding-bottom:'.$thumbs_mg.'px;'.$panel_style.'" data-pos="'.$ins.'">';
                            if ($anchor_type!="hook_unlinked") {
                                $href_val=get_permalink();
                                $target="";
                                if (get_field('skip_to_external')==1 && get_field('ext_url')!="") {
                                    $href_val=get_field('ext_url');
                                    //ADD HTTP PREFIX IF NEEDED
                                    if (substr($href_val,0,7)!="http://" && substr($href_val,0,8)!="https://" && substr($href_val,0,7)!="mailto:")
                                        $href_val="http://".$href_val;
                                    $target=' target="_blank" data-ext="true"';
                                    if (get_field('new_window')=="_self") {
                                        $target=' target="_self" data-ext="true"';
                                    }
                                }
                                $output.='<a href="'.$href_val.'" class="hook_touch '.$anchor_type.$extra_mfp.'" data-mfp-src="'.esc_attr($magnific_image[0]).'" data-title="'.$light_title.'" data-pos="'.$ins.'"'.$target.'>';
                                $output.=get_lightbox_content($multi_light,$first_pos,$custom_query->post->ID);
                            }
                            $output.='<div class="grid_image_wrapper">';
                            if (get_field('thumb_tag')!="") {
                                $output.='<div class="hook_thumb_tag">'.get_field('thumb_tag').'</div>';
                            }
                            $output.='<div class="grid_block_wr"><div class="grid_colored_block"></div></div>';
                            $hook_forced_w=480;
                            if ($cols_number!="variable" && is_numeric($cols_number))
                                $hook_forced_w=1920/$cols_number;
                            if ($hook_forced_w<480)
                                $hook_forced_w=480;
                            if ($layout_type_folio=="packery") {
                                $multipler=1;
                                if (get_field('custom_width',$custom_query->post->ID)=="hook_hz_two") {
                                    $multipler=2;
                                }
                                $hook_forced_w=$hook_forced_h=640*$multipler;
                                if (get_field('orientation',$custom_query->post->ID)=="landscape") {
                                    $hook_forced_h=320*$multipler;
                                }
                                if (get_field('orientation',$custom_query->post->ID)=="portrait") {
                                    $hook_forced_h=1280*$multipler;
                                }
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="panels" || $layout_type_folio=="featured") {

                            }
                            else if ($layout_type_folio=="masonry") {
                                $hook_forced_h=0;
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="squares") {
                                $hook_forced_h=ceil($hook_forced_w/1.16);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="grid_vertical") {
                                $hook_forced_h=floor($hook_forced_w*3/2);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else  {
                                $hook_forced_h=floor($hook_forced_w*2/3);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            //PRELOAD FIRST PANEL
                            $feat_class="";
                            if ($layout_type_folio=="panels" || $layout_type_folio=="featured") {
                                if ($ins==0) {
                                    $feat_class.=' hook_preloaded';
                                }
                                $src_code=' srcset="'.wp_get_attachment_image_srcset(get_post_thumbnail_id(),'full').'" sizes="100vw" ';
                                $output.='<div class="hook_image_parent'.$feat_class.'">';
                                $output.='<img src="'.$image[0].'"'.$src_code.'class="custom-img grid_image" alt="'.$alt_text.'" data-featured="no" />';
                                $output.='</div>';
                            }
                            else {
                                $output.='<div class="hook_image_parent'.$feat_class.'">';
                                $output.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.$alt_text.'" data-featured="no" />';
                                $output.='</div>';
                            }
                            if (get_field('video_thumb_iframe')!="") {
                                $output.='<div class="folio_iframe fitvidsignore">'.get_field('video_thumb_iframe').'</div>';
                            }
                            else if (get_field('video_thumb')!="") {
                                if ($image[0]!="") {
                                    $custom_poster=' poster="'.$image[0].'"';
                                }
                                else {
                                    $custom_poster="";
                                }
                                $output.='<div class="hook_video-wp"><video class="hook_video-bg" preload="auto" loop=""'.$videos_behavior.$custom_poster.'>';
                                $output.='<source src="'.get_field('video_thumb').'" type="video/mp4">';
                                $output.='<source src="'.get_field('video_thumb_webm').'" type="video/webm">';
                                $output.='</video></div>';
                            }
                            if ($atts['hook_show_skills']!="folio_noinfo") {
                                $output.='<div class="centerized_father">';
                                $output.='<div class="centerized_child">';
                                if ($layout_type_folio=="featured") {
                                    $output.='<div class="grid_single_title hook_animated">';
                                    if ($skills_output!="" && $hook_show_skills==true) {
                                        if(get_field('ext_url_label')=="") {
                                            $my_alt=$skills_output;
                                        }
                                        else {
                                            $my_alt=get_field('ext_url_label');
                                        }
                                        $output.='<div class="inner_skills hook_italic body_bk_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-alt="'.$my_alt.'">';
                                        if (get_field('thumb_skills')!="") {
                                            $output.=get_field('thumb_skills');
                                        }
                                        else {
                                            $output.=$skills_output;
                                        }
                                        $output.='</div>';
                                        $output.='<div class="prk_ttl hook_folio_uppercased">';
                                        if (get_field('custom_logo',$custom_query->post->ID)!="") {
                                            $in_image=wp_get_attachment_image_src(get_field('custom_logo',$custom_query->post->ID),'full');
                                            $hook_vt_image=vt_resize('', $in_image[0] , $hook_forced_w, '', false , true);
                                            $output.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo',$custom_query->post->ID)).'" />';
                                        }
                                        else {
                                            $output.='<h4 class="header_font body_bk_color big">'.the_title("","",false).'</h4>';
                                        }
                                        $output.='</div>';
                                        $output.='<div class="prk_break_word body_bk_color small-3">';
                                        $output.=hook_excerpt_dynamic(32,$custom_query->post->ID);
                                        $output.='</div>';
                                        $output.='<div class="clearfix"></div>';
                                        $output.='<div class="hook_launch body_bk_color">';
                                        $output.='<div class="ghost_theme_button"><span data-color="'.$featured_color.'"'.$data_button.'>'.$hook_translated['launch_text'].'<span></span></span></div>';
                                        $output.='</div>';
                                    }
                                }
                                else {
                                    $output.='<div class="grid_single_title hook_animated">';
                                    $output.='<div class="prk_ttl hook_folio_uppercased">';
                                    if (get_field('custom_logo',$custom_query->post->ID)!="") {
                                        $output.='<h4 class="header_font body_bk_color big hook_invsbl">'.the_title("","",false).'</h4>';
                                        $in_image=wp_get_attachment_image_src(get_field('custom_logo',$custom_query->post->ID),'full');
                                        $hook_vt_image=vt_resize('', $in_image[0] , $hook_forced_w, '', false , true);
                                        $output.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo',$custom_query->post->ID)).'" />';
                                    }
                                    else {
                                        $output.='<h4 class="header_font body_bk_color big">'.the_title("","",false).'</h4>';
                                    }
                                    if ($skills_output!="" && $hook_show_skills==true) {
                                        if(get_field('ext_url_label')=="") {
                                            $my_alt=$skills_output;
                                        }
                                        else {
                                            $my_alt=get_field('ext_url_label');
                                        }
                                        $output.='<div class="inner_skills body_bk_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-alt="'.$my_alt.'">';
                                        if (get_field('thumb_skills')!="") {
                                            $output.=get_field('thumb_skills');
                                        }
                                        else {
                                            $output.=$skills_output;
                                        }
                                        $output.='</div>';
                                    }
                                    $output.='</div>';
                                }
                                $output.='</div>';
                                $output.='</div>';
                                if ($layout_type_folio!="packery") {
                                    $output.='<div class="prk_break_word entry_content body_colored">';
                                    $output.=hook_excerpt_dynamic(12,$custom_query->post->ID);
                                    $output.='<div class="clearfix"></div>';
                                    $output.='</div>';
                                }
                                $output.='</div>';
                            }
                            $output.='</div>';
                            if ($anchor_type!="hook_unlinked" && $layout_type_folio=="panels") {
                                $output.='<div class="hook_panel_read body_bk_color">';
                                $output.='<div class="ghost_theme_button"><span data-color="'.$prk_hook_options['slider_text_color'].'">'.$hook_translated['read_more'].'<span></span></span></div>';
                                $output.='</div>';
                            }
                            if ($anchor_type!="hook_unlinked") {
                                $output.='</a>';
                            }
                            $output.='</div>';
                            //END POST
                        }
                        else {
                            if ($hook_stop_flag==true)
                            {
                                $output.='</div>';
                                $output.='<div class="folio_appender hide_now'.$appender_class.'">';
                                $hook_stop_flag=false;
                            }
                            $widtha=get_field('custom_width',$custom_query->post->ID);
                            if ($layout_type_folio!="packery") {
                                $widtha="hook_hz_one";
                            }
                            $output.='<div class="'.$widtha.' hook_or_'.get_field('orientation',$custom_query->post->ID).' portfolio_entry_li '.$featured_class.$skills_yo.' p_all" data-color="'.$featured_color.'" style="padding-right:'.$thumbs_mg.'px;padding-bottom:'.$thumbs_mg.'px;'.$panel_style.'" data-pos="'.$ins.'">';
                            if ($anchor_type!="hook_unlinked") {
                                $href_val=get_permalink();
                                $target="";
                                if (get_field('skip_to_external')==1 && get_field('ext_url')!="") {
                                    $href_val=get_field('ext_url');
                                    //ADD HTTP PREFIX IF NEEDED
                                    if (substr($href_val,0,7)!="http://" && substr($href_val,0,8)!="https://" && substr($href_val,0,7)!="mailto:")
                                        $href_val="http://".$href_val;
                                    $target=' target="_blank" data-ext="true"';
                                    if (get_field('new_window')=="_self") {
                                        $target=' target="_self" data-ext="true"';
                                    }
                                }
                                $output.='<a href="'.$href_val.'" class="hook_touch '.$anchor_type.$extra_mfp.'" data-mfp-src="'.esc_attr($magnific_image[0]).'" data-title="'.$light_title.'" data-pos="'.$ins.'"'.$target.'>';
                                $output.=get_lightbox_content($multi_light,$first_pos,$custom_query->post->ID);
                            }
                            $output.='<div class="grid_image_wrapper">';
                            if (get_field('thumb_tag')!="") {
                                $output.='<div class="hook_thumb_tag">'.get_field('thumb_tag').'</div>';
                            }
                            $output.='<div class="grid_block_wr"><div class="grid_colored_block"></div></div>';
                            $hook_forced_w=480;
                            if ($cols_number!="variable" && is_numeric($cols_number))
                                $hook_forced_w=1920/$cols_number;
                            if ($hook_forced_w<480)
                                $hook_forced_w=480;
                            if ($layout_type_folio=="packery") {
                                $multipler=1;
                                if (get_field('custom_width',$custom_query->post->ID)=="hook_hz_two") {
                                    $multipler=2;
                                }
                                $hook_forced_w=$hook_forced_h=640*$multipler;
                                if (get_field('orientation',$custom_query->post->ID)=="landscape") {
                                    $hook_forced_h=320*$multipler;
                                }
                                if (get_field('orientation',$custom_query->post->ID)=="portrait") {
                                    $hook_forced_h=1280*$multipler;
                                }
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="panels" || $layout_type_folio=="featured") {

                            }
                            else if ($layout_type_folio=="masonry") {
                                $hook_forced_h=0;
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="squares") {
                                $hook_forced_h=ceil($hook_forced_w/1.16);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else if ($layout_type_folio=="grid_vertical") {
                                $hook_forced_h=floor($hook_forced_w*3/2);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            else  {
                                $hook_forced_h=floor($hook_forced_w*2/3);
                                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                            }
                            //PRELOAD FIRST PANEL
                            $feat_class="";
                            if ($layout_type_folio=="panels" || $layout_type_folio=="featured") {
                                if ($ins==0) {
                                    $feat_class.=' hook_preloaded';
                                }
                                $src_code=' srcset="'.wp_get_attachment_image_srcset(get_post_thumbnail_id(),'full').'" sizes="100vw" ';
                                $output.='<div class="hook_image_parent'.$feat_class.'">';
                                $output.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.$image[0].'"'.$src_code.'class="custom-img grid_image" alt="'.$alt_text.'" data-featured="no" />';
                                $output.='</div>';
                            }
                            else {
                                $output.='<div class="hook_image_parent'.$feat_class.'">';
                                $output.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.$alt_text.'" data-featured="no" />';
                                $output.='</div>';
                            }
                            if (get_field('video_thumb_iframe')!="") {
                                $output.='<div class="folio_iframe fitvidsignore">'.get_field('video_thumb_iframe').'</div>';
                            }
                            else if (get_field('video_thumb')!="") {
                                if ($image[0]!="") {
                                    $custom_poster=' poster="'.$image[0].'"';
                                }
                                else {
                                    $custom_poster="";
                                }
                                $output.='<div class="hook_video-wp"><video class="hook_video-bg" preload="auto" loop=""'.$videos_behavior.$custom_poster.'>';
                                $output.='<source src="'.get_field('video_thumb').'" type="video/mp4">';
                                $output.='<source src="'.get_field('video_thumb_webm').'" type="video/webm">';
                                $output.='</video></div>';
                            }
                            if ($atts['hook_show_skills']!="folio_noinfo") {
                                $output.='<div class="centerized_father">';
                                $output.='<div class="centerized_child">';
                                if ($layout_type_folio=="featured") {
                                    $output.='<div class="grid_single_title hook_animated">';
                                    if ($skills_output!="" && $hook_show_skills==true) {
                                        if(get_field('ext_url_label')=="") {
                                            $my_alt=$skills_output;
                                        }
                                        else {
                                            $my_alt=get_field('ext_url_label');
                                        }
                                        $output.='<div class="inner_skills hook_italic body_bk_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-alt="'.$my_alt.'">';
                                        if (get_field('thumb_skills')!="") {
                                            $output.=get_field('thumb_skills');
                                        }
                                        else {
                                            $output.=$skills_output;
                                        }
                                        $output.='</div>';
                                        $output.='<div class="prk_ttl hook_folio_uppercased">';
                                        if (get_field('custom_logo',$custom_query->post->ID)!="") {
                                            $in_image=wp_get_attachment_image_src(get_field('custom_logo',$custom_query->post->ID),'full');
                                            $hook_vt_image=vt_resize('', $in_image[0] , $hook_forced_w, '', false , true);
                                            $output.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo',$custom_query->post->ID)).'" />';
                                        }
                                        else {
                                            $output.='<h4 class="header_font body_bk_color big">'.the_title("","",false).'</h4>';
                                        }
                                        $output.='</div>';
                                        $output.='<div class="prk_break_word body_bk_color small-3">';
                                        $output.=hook_excerpt_dynamic(32,$custom_query->post->ID);
                                        $output.='</div>';
                                        $output.='<div class="clearfix"></div>';
                                        $output.='<div class="hook_launch body_bk_color">';
                                        $output.='<div class="ghost_theme_button"><span data-color="'.$featured_color.'"'.$data_button.'>'.$hook_translated['launch_text'].'<span></span></span></div>';
                                        $output.='</div>';
                                    }
                                }
                                else {
                                    $output.='<div class="grid_single_title hook_animated">';
                                    $output.='<div class="prk_ttl hook_folio_uppercased">';
                                    if (get_field('custom_logo',$custom_query->post->ID)!="") {
                                        $output.='<h4 class="header_font body_bk_color big hook_invsbl">'.the_title("","",false).'</h4>';
                                        $in_image=wp_get_attachment_image_src(get_field('custom_logo',$custom_query->post->ID),'full');
                                        $hook_vt_image=vt_resize('', $in_image[0] , $hook_forced_w, '', false , true);
                                        $output.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo',$custom_query->post->ID)).'" />';
                                    }
                                    else {
                                        $output.='<h4 class="header_font body_bk_color big">'.the_title("","",false).'</h4>';
                                    }
                                    if ($skills_output!="" && $hook_show_skills==true) {
                                        if(get_field('ext_url_label')=="") {
                                            $my_alt=$skills_output;
                                        }
                                        else {
                                            $my_alt=get_field('ext_url_label');
                                        }
                                        $output.='<div class="inner_skills body_bk_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-alt="'.$my_alt.'">';
                                        if (get_field('thumb_skills')!="") {
                                            $output.=get_field('thumb_skills');
                                        }
                                        else {
                                            $output.=$skills_output;
                                        }
                                        $output.='</div>';
                                    }
                                    $output.='</div>';
                                }
                                $output.='</div>';
                                $output.='</div>';
                                if ($layout_type_folio!="packery") {
                                    $output.='<div class="prk_break_word entry_content body_colored">';
                                    $output.=hook_excerpt_dynamic(12,$custom_query->post->ID);
                                    $output.='<div class="clearfix"></div>';
                                    $output.='</div>';
                                }
                                $output.='</div>';
                            }
                            $output.='</div>';
                            if ($anchor_type!="hook_unlinked" && $layout_type_folio=="panels") {
                                $output.='<div class="hook_panel_read body_bk_color">';
                                $output.='<div class="ghost_theme_button"><span data-color="'.$featured_color.'"'.$data_button.'>'.$hook_translated['read_more'].'<span></span></span></div>';
                                $output.='</div>';
                            }
                            if ($anchor_type!="hook_unlinked") {
                                $output.='</a>';
                            }
                            $output.='</div>';
                            //END POST
                        }
                        $ins++;
                    endwhile;
                    $output.='</div>';
                    if ($hook_stop_flag==false && $show_load_more==true) {
                        $output.='<div class="pf_load_more_wrapper">';
                        $output.='<div class="pf_load_more theme_button" data-no_more="'.esc_attr($hook_translated['no_more']).'">';
                        $output.='<a href="#" class="pf_link per_init">';
                        $output.=$hook_translated['load_more'];
                        $output.='</a>';
                        $output.='<i class="hook_button_arrow hook_fa-chevron-down not_zero_color"></i>';
                        $output.='<div id="ajax_spinner" class="spinner-icon"></div>';
                        $output.='</div>';
                        $output.='</div>';
                    }
                    $output.='<div class="clearfix"></div>';
                    $output.='</div>';
                }
            }
            else
            {
                $output.='<h2 class="hook_shortcode_warning">No portfolio posts were found!</h2>';
            }
            wp_reset_postdata();
            return $output;
        }
    }
    add_shortcode('pirenko_last_portfolios', 'pirenko_last_portfolios_shortcode');

    //LATEST POSTS
    if (!function_exists('pirenko_last_posts_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_last_posts_shortcode($atts, $content=null ) {
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $hook_translated=scodes_translate();
            $atts=shortcode_atts(array(
                'items_number'		 => '3',
                'rows_number'		 => '1',
                'cat_filter'	=> '',
                'css_animation' => '',
                'el_class' => '',
                'general_style' => 'classic',
                'show_date' => 'no',
                'not_in' => '',
            ), $atts);
            $items_number=$atts['items_number'];
            $rows_number=$atts['rows_number'];
            $cat_filter=$atts['cat_filter'];
            $general_style=$atts['general_style'];
            wp_reset_query();
            $custom_query=new WP_Query();
            if ($atts['not_in']!="") {
                $args=array (
                    'post_type=posts',
                    'showposts' => $items_number,
                    'category_name'=>$cat_filter,
                    'post__not_in' => array($atts['not_in']),
                    'orderby' => 'rand',
                );
            }
            else {
                $args=array (
                    'post_type=posts',
                    'showposts' => $items_number,
                    'category_name'=>$cat_filter,
                );
            }
            $custom_query->query($args);
            $cols_number=floor($items_number/$rows_number);
            if ($cols_number==0) {
                $cols_number=1;
            }
            $columnizer=floor(12/$cols_number);
            $rand_nbr=rand(1, 500);
            $i=0;
            $out='';
            if ($custom_query->have_posts()) {
                if ($cols_number>=$custom_query->post_count)
                    $main_classes="";
                else
                    $main_classes=" extra_spaced";
                if (isset($atts['css_animation']) && $atts['css_animation']!="") {
                    $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
                }
                if (isset($atts['css_delay']) && $atts['css_delay']!="") {
                    $main_classes.=" delay-".$atts['css_delay'];
                }
                if (isset($atts['el_class']) && $atts['el_class']!="") {
                    $main_classes.=" ".$atts['el_class'];
                }
                if ($general_style=="slider") {
                    $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_shortcode'.$main_classes.'">';
                    $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_slider per_init hook_no_nbr" data-navigation="true">';
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        if ($i<$items_number)
                        {
                            if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
                            {
                                $featured_color=get_field('featured_color');
                                $featured_class=" featured_color";
                            }
                            else
                            {
                                $featured_color="default";
                                $featured_class="";
                            }
                            $out.='<div class="blog_entry_li item clearfix'.$featured_class.'" data-color="'.$featured_color.'">';
                            $out.='<div class="masonry_inner">';
                            if (has_post_thumbnail())
                            {
                                $image=wp_get_attachment_image_src(get_post_thumbnail_id(),'');
                                $out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
                                $out.='<div class="masonr_img_wp">';
                                $out.='<div class="blog_fader_grid">';
                                $out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
                                $out.='</div>';
                                $hook_vt_image=vt_resize( '', $image[0] , 700 , 436, true , $hook_retina_device );
                                $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id()).'" />';
                                $out.='</div>';
                                $out.='</a>';
                            }
                            else
                            {
                                //CHECK IF THERE'S A VIDEO TO SHOW
                                if (get_field('video_2')!="")
                                {
                                    $out.= "<div class='video-container'>";
                                    $out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
                                    $out.= "</div>";
                                }
                            }
                            $out.='<div class="header_font prk_mini_meta small">';
                            $out.='<div class="entry_title prk_lf">';
                            $out.='<h4 class="prk_heavier_600 big">';
                            $out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.$featured_color.'">';
                            $out.=get_the_title();
                            $out.='</a>';
                            $out.='</h4>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="hook_blog_uppercased prk_heavier_600 hook_blog_meta prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                            $hook_divide_me=false;
                            if (is_sticky()) {
                                $out.='<div class="prk_lf hook_sticky not_zero_color">';
                                $out.=$hook_translated['sticky_text'];
                                $out.='</div>';
                                $hook_divide_me=true;
                            }
                            if ($prk_hook_options['show_date_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }

                                $out.='<div class="prk_lf">';
                                $out.=get_the_time(get_option('date_format'));
                                $out.='</div>';
                            }
                            if ($prk_hook_options['postedby_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }
                                $out.='<div class="hook_anchor prk_lf hook_colored_link">';
                                $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                                $out.='</div>';
                            }
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="on_colored prk_break_word entry_content">';
                            $out.='<div class="wpb_text_column">';
                            $cat_helper=$custom_query->post->ID;
                            $out.=hook_excerpt_dynamic(28,$custom_query->post->ID);
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="fade_anchor prk_lf">';
                            $out.='<a href="'.get_permalink().'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
                            $out.=$hook_translated['read_more'].' &rarr;';
                            $out.='</a>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="blog_lower prk_bordered_top prk_heavier_600 header_font prk_75_em small_headings_color hook_blog_uppercased">';
                            $out.='<div class="small-12">';
                            if ($prk_hook_options['categoriesby_blog']=="1")
                            {
                                $out.='<div class="prk_lf hook_anchor">';
                                $out.='<div class="prk_lf blog_categories">';
                                $arra=get_the_category($custom_query->post->ID);
                                if(!empty($arra)) {
                                    $count_cats=0;
                                    foreach($arra as $s_cat)
                                    {
                                        if ($count_cats>0)
                                            $out.=', ';
                                        $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
                                        $count_cats++;
                                    }
                                }
                                $out.='</div>';
                                $out.='</div>';
                            }
                            if ($prk_hook_options['postedby_blog']=="1") {
                                if (function_exists('get_avatar')) {
                                    $out.='<div class="prk_author_avatar prk_lf">';
                                    $out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                                    if (get_the_author_meta('prk_author_custom_avatar')!="") {
                                        $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                                        $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                                    }
                                    else {
                                        if (get_avatar(get_the_author_meta('email'),'216')) {
                                            $out.=get_avatar(get_the_author_meta('email'),'216');
                                        }
                                    }
                                    $out.='</a>';
                                    $out.='</div>';
                                }
                                $out.='<div class="hook_anchor prk_lf hook_colored_link hook_author">';
                                $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                                $out.='</div>';
                            }
                            $out.='<div class="prk_rf hook_anchor">';
                            $out.='<a href="'.get_permalink($cat_helper).'" data-color="'.$featured_color.'">';
                            $content=get_post_field('post_content',$custom_query->post->ID);
                            $count=round(str_word_count(strip_tags($content))/200);
                            if ($count==0)
                                $count=1;
                            $out.='<span class="hook_min_read">'.$count.' '.$hook_translated['min_read_text'].'</span>';
                            $out.='</a>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='</div>';
                        }
                        $i++;
                    endwhile;
                    $out.='</div>';
                    $out.='</div>';
                }
                if ($general_style=="hook_list") {
                    $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="row'.$main_classes.'">';
                    $out.='<div id="recent_blog-'.$rand_nbr.'" class="hook_posts_list hook_left_align small-12 columns">';
                    $out.='<ul class="unstyled">';
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        if ($i<$items_number) {
                            if ($atts['show_date']!='no') {
                                $out.='<li class="small-12">';
                                $out.='<div class="small-2 hook_right_align columns">'.get_the_time(get_option('date_format')).'</div>';
                                $out.='<div class="small-10 columns"><a href="'.get_permalink().'" class="header_font zero_color">';
                                $out.=get_the_title();
                                $out.='</a></div></li>';
                            }
                            else {
                                $out.='<li><a href="'.get_permalink().'" class="header_font zero_color">';
                                $out.=get_the_title();
                                $out.='</a></li>';
                            }
                        }
                        $i++;
                    endwhile;
                    $out.='</ul>';
                    $out.='</div>';
                    $out.='</div>';
                    $out.='<div class="clearfix bt_2x"></div>';
                }
                if ($general_style=="classic") {
                    $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_wp row'.$main_classes.'">';
                    $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_shortcode hook_left_align" data-columns='.$cols_number.' data-rows='.$rows_number.'>';
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        if ($i<$items_number) {
                            $image=wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                            if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
                            {
                                $featured_color=get_field('featured_color');
                                $featured_class=" featured_color";
                            }
                            else
                            {
                                $featured_color="default";
                                $featured_class="";
                            }
                            $out.='<div class="columns small-'.$columnizer.'">';
                            $out.='<div class="blog_entry_li'.$featured_class.'" data-color="'.$featured_color.'">';
                            $out.='<div class="masonry_inner">';
                            if (has_post_thumbnail($custom_query->post->ID)):
                                //GET THE FEATURED IMAGE
                                $image=wp_get_attachment_image_src( get_post_thumbnail_id( $custom_query->post->ID ), '' );
                            else :
                                //THERE'S NO FEATURED IMAGE
                            endif;
                            if (has_post_thumbnail($custom_query->post->ID)) {
                                $out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.$featured_color.'">';
                                $out.='<div class="masonr_img_wp">';
                                $out.='<div class="blog_fader_grid centerized_father_blog">';
                                $out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
                                $out.='</div>';
                                $hook_vt_image=vt_resize( get_post_thumbnail_id($custom_query->post->ID), '' , 700, 436, true , $hook_retina_device );
                                $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$custom_query->post->ID.'" class="custom-img grid_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id($custom_query->post->ID)).'" />';
                                $out.='</div>';
                                $out.='</a>';
                            }
                            else
                            {
                                //CHECK IF THERE'S A VIDEO TO SHOW
                                if (get_field('video_2')!="")
                                {
                                    $el_class='video-container';
                                    if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                                        $el_class= 'soundcloud-container';
                                    }
                                    $out.='<div class="'.esc_attr($el_class).'">';
                                    $out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
                                    $out.='</div>';
                                }
                            }
                            $out.='<div class="header_font prk_mini_meta small">';
                            $out.='<div class="entry_title prk_lf">';
                            $out.='<h4 class="prk_heavier_600 big">';
                            $out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.$featured_color.'">';
                            $out.=get_the_title();
                            $out.='</a>';
                            $out.='</h4>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="hook_blog_uppercased prk_heavier_600 hook_blog_meta prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                            $hook_divide_me=false;
                            if (is_sticky()) {
                                $out.='<div class="prk_lf hook_sticky not_zero_color">';
                                $out.=$hook_translated['sticky_text'];
                                $out.='</div>';
                                $hook_divide_me=true;
                            }
                            if ($prk_hook_options['show_date_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }

                                $out.='<div class="prk_lf">';
                                $out.=get_the_time(get_option('date_format'));
                                $out.='</div>';
                            }
                            if ($prk_hook_options['categoriesby_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }
                                $out.='<div class="prk_lf hook_anchor">';
                                $out.='<div class="prk_lf blog_categories">';
                                $arra=get_the_category($custom_query->post->ID);
                                if(!empty($arra)) {
                                    $count_cats=0;
                                    foreach($arra as $s_cat)
                                    {
                                        if ($count_cats>0)
                                            $out.=', ';
                                        $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
                                        $count_cats++;
                                    }
                                }
                                $out.='</div>';
                                $out.='</div>';
                            }
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="on_colored entry_content prk_break_word">';
                            $out.='<div class="wpb_text_column">';
                            $cat_helper=$custom_query->post->ID;
                            $out.=hook_excerpt_dynamic(28,$custom_query->post->ID);
                            $out.='<div class="hook_anchor prk_lf">';
                            $out.='<a href="'.get_permalink($cat_helper).'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
                            $out.=$hook_translated['read_more'].' &rarr;';
                            $out.='</a>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="blog_lower prk_bordered_top prk_heavier_600 header_font prk_75_em small_headings_color hook_blog_uppercased">';
                            $out.='<div class="small-12">';
                            if ($prk_hook_options['postedby_blog']=="1") {
                                if (function_exists('get_avatar')) {
                                    $out.='<div class="prk_author_avatar prk_lf">';
                                    $out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                                    if (get_the_author_meta('prk_author_custom_avatar')!="") {
                                        $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                                        $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                                    }
                                    else {
                                        if (get_avatar(get_the_author_meta('email'),'216')) {
                                            $out.=get_avatar(get_the_author_meta('email'),'216');
                                        }
                                    }
                                    $out.='</a>';
                                    $out.='</div>';
                                }
                                $out.='<div class="hook_anchor prk_lf hook_colored_link hook_author">';
                                $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                                $out.='</div>';
                            }
                            $out.='<div class="prk_rf hook_anchor">';
                            $out.='<a href="'.get_permalink($cat_helper).'" data-color="'.$featured_color.'">';
                            $content=get_post_field('post_content',$custom_query->post->ID);
                            $count=round(str_word_count(strip_tags($content))/200);
                            if ($count==0)
                                $count=1;
                            $out.='<span class="hook_min_read">'.$count.' '.$hook_translated['min_read_text'].'</span>';
                            $out.='</a>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='</div>';
                            $out.='</div>';
                        }
                        $i++;
                        if ($i%$cols_number==0 && $i<$items_number)
                        {
                            $out.='<div class="clearfix bt_3x"></div>';
                        }
                    endwhile;
                    $out.='</div>';
                    $out.='</div>';
                }
            }
            else
            {
                $out.='<div id="prk_shortcode_latest_posts" class="recentposts_ul_wp small-12">';
                $out.= '<h2 class="hook_shortcode_warning">No posts were found!</h2>';
                $out.='</div>';
            }
            wp_reset_query();
            return $out;
        }
    }
    add_shortcode('pirenko_last_posts', 'pirenko_last_posts_shortcode');

    //THEME GALLERY
    if (!function_exists('pirenko_gallery_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_gallery_shortcode($atts, $content=null ) {
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $hook_translated=scodes_translate();
            if (!isset($hook_translated['all_text']))
                $hook_translated['all_text']='All';
            $atts=shortcode_atts(array(
                'type'    	=> 'masonry',
                'thumbs_mg'	=> '10',
                'images' => '',
                'show_titles' => '',
                'cols_number' => 'iso_doubles',
                'on_click' => 'default',
            ), $atts);
            if ($atts['cols_number']!="")
                $cols_number=$atts['cols_number'];
            if ($atts['type']!="")
                $layout_type_folio=$atts['type'];
            if ($atts['thumbs_mg']!="")
                $thumbs_mg=$atts['thumbs_mg'];
            $titles_class="";
            if ($atts['show_titles']=="no")
                $titles_class=' no_titles_gallery';
            $arr=explode(",",$atts['images']);
            if (count($arr)>0) {
                $rand_nbr=rand(1, 5000);
                $out='';
                $out.='<div class="small-12 hook_gallery hook_gallery_'.$atts['on_click'].'">';
                $out.='<div id="iso_gallery-'.$rand_nbr.'" class="'.$cols_number.' iso_folio shortcoded per_init hook_iso_gallery'.$titles_class.'" style="margin-right:-'.$thumbs_mg.'px;" data-margin='.$thumbs_mg.'>';
                $out.='<div class="grid-sizer"></div>';
                foreach ($arr as $single) {
                    $magnific_image=$image=wp_get_attachment_image_src( $single,'full' );
                    $singlu=get_post($single);
                    if(is_object($singlu) && $singlu->post_content!="") {
                        $magnific_image[0]=$singlu->post_content;
                        $out.='<div class="portfolio_entry_li without_skills" style="padding-right:'.$thumbs_mg.'px;padding-bottom:'.$thumbs_mg.'px;" data-mfp-src="'.$magnific_image[0].'" data-title="'.hook_alt_tag(true,$single).'">';
                        if ($atts['on_click']!="nothing") {
                            $out .= '<a href="'.$singlu->post_content.'" target="_blank">';
                        }
                    }
                    else {
                        $out.='<div class="portfolio_entry_li without_skills lighted" style="padding-right:'.$thumbs_mg.'px;padding-bottom:'.$thumbs_mg.'px;" data-mfp-src="'.$magnific_image[0].'" data-title="'.hook_alt_tag(true,$single).'">';
                    }
                    $extra_mfp="";
                    $out.='<div class="grid_image_wrapper">';
                    if ($atts['on_click']!="nothing") {
                        $out .= '<div class="grid_colored_block"></div>';
                    }
                    $hook_forced_w=480;
                    if ($layout_type_folio=="masonry") {
                        $hook_forced_h=0;
                        $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                    }
                    else if ($layout_type_folio=="squares")
                    {
                        $hook_forced_h=480;
                        $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                    }
                    else
                    {
                        $hook_forced_h=300;
                        $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                    }
                    $out.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.hook_alt_tag(true,$single,true).'" data-featured="no" />';
                    $out.='<div class="centerized_father">';
                    $out.='<div class="centerized_child">';
                    $out.='<div class="grid_single_title zero_color">';
                    $out.='<div class="prk_ttl"><h4 class="header_font body_bk_color">'.hook_alt_tag(true,$single,true).'</h4></div> ';
                    $out.='</div>';
                    $out.='</div>';
                    $out.='</div>';
                    $out.='</div>';
                    if(is_object($singlu) && $singlu->post_content!="" && $atts['on_click']!="nothing") {
                        $out.='</a>';
                    }
                    $out.='</div>';
                }
                $out.='</div>';
                $out.='</div>';
                $out.='<div class="clearfix"></div>';
            }
            else {
                $out.= '<h2 class="hook_shortcode_warning">No content was found!</h2>';
            }
            return $out;
        }
    }
    add_shortcode('pirenko_gallery', 'pirenko_gallery_shortcode');

    //THEME CAROUSEL
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function pirenko_carousel_shortcode($atts, $content=null ) {
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        $atts=shortcode_atts(array(
            'images'=>'',
            'images_width' => '300',
        ),$atts);
        $arr=explode(",",$atts['images']);
        $out="";
        if (count($arr)>0) {
            $rand_nbr=rand(1, 5000);
            $out.='<div id="carousel-'.$rand_nbr.'" class="owl-carousel hook_carousel per_init">';
            foreach ($arr as $single) {
                $image=wp_get_attachment_image_src( $single,'full' );
                $out.='<div>';
                $hook_forced_w=$atts['images_width'];
                $hook_forced_h=0;
                $hook_vt_image=vt_resize( '', $image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                $magnific_image=$image=wp_get_attachment_image_src( $single,'full' );
                $singlu=get_post($single);
                if(is_object($singlu) && $singlu->post_content!="") {
                    $out.='<a href="'.$singlu->post_content.'" target="_blank">';
                    $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.hook_alt_tag(true,$single).'" />';
                    $out.='</a>';
                }
                else {
                    $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.hook_alt_tag(true,$single).'" />';
                }
                $out.='</div>';
            }
            $out.='</div>';
            $out.='<div class="clearfix"></div>';
        }
        else {
            $out.='<h2 class="hook_shortcode_warning">No content was found!</h2>';
        }
        return $out;
    }
    add_shortcode('pirenko_carousel', 'pirenko_carousel_shortcode');

    //LATEST COMMENTS
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    if (!function_exists('pirenko_comments_shortcode')) {
        function pirenko_comments_shortcode($atts, $content = null)
        {
            $atts = shortcode_atts(array(
                'title' => '',
                'items_number' => '4',
                'post_id' => '',
                'el_class' => '',
            ), $atts);
            $main_classes = "";
            if ($atts['el_class'] != "") {
                $main_classes .= " ".$atts['el_class'];
            }
            $temp_str = '[decent-comments number="'.$atts['items_number'].'" post_id="'.$atts['post_id'].'" show_avatar="false" max_excerpt_words="80"][/decent-comments]';
            $out = '';
            $out .= '<div class="prk_shorts small-12 prk_shortcode_latest_cmts'.$main_classes.'">';
            if ($atts['title'] != "") {
                $out .= '<div class="header_font zero_color"><h3 class="wpb_heading prk_heavier_600 small">'.$atts['title'].'</h3></div>';
            };
            $out .= do_shortcode($temp_str);
            $out .= '</div>';
            return $out;
        }
    }
    add_shortcode('pirenko_comments', 'pirenko_comments_shortcode');

    //TESTIMONIALS
    if (!function_exists('pirenko_testimonials_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_testimonials_shortcode($atts, $content=null ) {
            $atts=shortcode_atts(array(
                'items_number' => '999',
                'category' =>'',
                'align' =>'hook_center_align',
                'autoplay' =>'yes',
                'delay' => '7500',
                'css_animation' => '',
                'el_class' => '',
                'layout' => 'testimonials_slider',
                'show_controls' => 'yes',
                'size' => '',
                'color' => '',
                'title_color' => '',
                'nav_color' => '',
                'css_delay' => '',
                'transition_style' => 'backSlide',
                'slider_height' => 'fixed',
            ), $atts);
            $hook_retina_device=hook_retiner(false);
            $items_number=$atts['items_number'];
            $category=$atts['category'];
            $extra_class=$atts['align'];
            wp_reset_query();
            $args=array(
                'post_type' => 'pirenko_testimonials',
                'showposts' => $items_number,
                'pirenko_testimonial_set' => $category,
            );
            $custom_query=new WP_Query( $args );
            $out='';
            if ($atts['autoplay']=="no")
                $autoplay="false";
            else
                $autoplay="true";
            $delay=$atts['delay'];
            $arrows="false";
            if ($atts['show_controls']=="no") {
                $navigation='false';
            }
            else {
                $navigation="true";
                $extra_class.=" with_nav";
                if ($atts['show_controls']=="thumbs") {
                    $extra_class.=" with_thumbs";
                }
                if ($atts['show_controls']=="arrows") {
                    $navigation="false";
                    $arrows="true";
                }
            }
            $main_classes="small-12";
            $custom_anim=$atts['transition_style'];
            if ($atts['align']=="hook_center_align") {
                $main_classes="small-centered small-10 columns";
            }
            $inline=$inline_title="";
            if ($atts['color']!="") {
                $inline=' style="color:'.$atts['color'].';"';
            }
            if ($atts['title_color']!="") {
                $inline_title=' style="color:'.$atts['title_color'].';"';
            }
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            $extra_class.=$atts['nav_color'].$atts['size'];
            if ($atts['layout']=="testimonials_stack") {
                $mainer="testimonials_stack";
            }
            else {
                $mainer="per_init owl-carousel testimonials_slider hook_squared";
            }
            $out='<div class="hook_tm_wrapper '.$main_classes.'">';
            $out.='<div class="'.$mainer.' '.$extra_class.'" data-autoplay="'.$autoplay.'" data-delay="'.$delay.'" data-pagination="'.$navigation.'" data-anim="'.$custom_anim.'" data-navigation="'.$arrows.'" data-height="'.$atts['slider_height'].'">';
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
                $out.='<div class="item"'.$inline.'>';
                if (has_post_thumbnail(get_the_ID())){
                    $image=wp_get_attachment_image_src(get_post_thumbnail_id(),'');
                    $hook_vt_image=vt_resize( '', $image[0] , '' , '', false , $hook_retina_device );
                    $out.='<div class="tm_image"><img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="testimonial_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id()).'" /></div>';
                }
                $out.='<div class="tm_content">';
                $out.='<h4 class="small">'.get_the_content().'</h4>';
                $out.='<div class="tm_title not_zero_color header_font prk_heavier_600"'.$inline_title.'>';
                if (get_field('testimonial_link')!="") {
                    $out.='<a href="'.get_field('testimonial_link').'" target=_blank">'.get_the_title().'</a>';
                }
                else {
                    $out.=get_the_title();
                }
                $out.='</div>';
                if (get_field('testimonial_subheading')!="") {
                    $out.='<div class="tm_subheading">';
                    $out.=get_field('testimonial_subheading');
                    $out.='</div>';
                }
                if (get_field('rating')!="" && get_field('rating')!="none") {
                    $out.='<div class="tm_stars">';
                    for ($count=1;$count<=5;$count++) {
                        if ($count<=get_field('rating'))
                            $out.='<i class="hook_fa-star not_zero_color"></i>';
                        else
                            $out.='<i class="hook_fa-star"></i>';
                    }
                    $out.='</div>';
                }
                $out.='</div>';
                $out.='</div>';
            endwhile;
            $out.='</div>';
            $out.='</div>';
            $out.='<div class="clearfix"></div>';
            wp_reset_query();
            return $out;
        }
    }
    add_shortcode('prk_testimonials', 'pirenko_testimonials_shortcode');

    //THEME CONTACT FORM
    if (!function_exists('prk_contact_form_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function prk_contact_form_shortcode($atts, $content=null ) {
            $hook_translated=scodes_translate();
            $atts=shortcode_atts(array(
                'backs_color' => '',
                'css_animation' =>'',
                'css_delay' =>'hook_center_align',
                'el_class' => '',
                'email_adr' => '',
                'fields_display' => 'hook_reg_subject',
            ), $atts);
            $main_classes=$inline="";
            if ($atts['backs_color']!="") {
                $inline=' style="background-color:'.$atts['backs_color'].'" data-bk="'.$atts['backs_color'].'"';
            }
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            if ($atts['fields_display']=="hook_big_subject") {
                $name_class="small-6";
                $subject_class="small-12 hook_big_subject";
            }
            else {
                $name_class=$subject_class="small-4";
            }
            $out='<div class="prk_shorts small-12">
	        <form action="#" class="prk_theme_form'.$main_classes.'" method="post" data-empty="'.esc_attr($hook_translated['empty_text_error']).'" data-invalid="'.esc_attr($hook_translated['invalid_email_error']).'" data-ok="'.esc_attr($hook_translated['contact_ok_text']).'" data-name="'.get_bloginfo('name').'">
	            <div class="row">
		            <div class="'.$name_class.' columns">
		                <input type="text" class="pirenko_highlighted" name="c_name" id="c_name" 
		                placeholder="'.esc_attr($hook_translated['comments_author_text']).esc_attr($hook_translated['required_text']).'"  data-original="'.esc_attr($hook_translated['comments_author_text']).esc_attr($hook_translated['required_text']).'"'.$inline.' />
		            </div>
		            <div class="'.$name_class.' columns">
		                    <input type="text" class="pirenko_highlighted" name="c_email" id="c_email" size="28" placeholder="'.esc_attr($hook_translated['comments_email_text']).esc_attr($hook_translated['required_text']).'"'.$inline.' />
		            </div>
		            <div class="'.$subject_class.' columns">
		                    <input type="text" class="pirenko_highlighted" name="c_subject" id="c_subject" size="28" placeholder="'.esc_attr($hook_translated['contact_subject_text']).'"'.$inline.' />
		            </div>
		            <div class="small-12 columns">
		                <textarea class="pirenko_highlighted" name="c_message" id="c_message" rows="8"
		                placeholder="'.esc_attr($hook_translated['contact_message_text']).'" data-original="'.esc_attr($hook_translated['contact_message_text']).'"'.$inline.'></textarea>
		            </div>
	            	<div class="clearfix"></div>
	            </div>
	        <input type="hidden" id="full_subject" name="full_subject" value="" />
	        <input type="hidden" name="rec_email" value="'.antispambot($atts['email_adr']).'" />
	        <div id="contact_ok" class="prk_heavier_600 zero_color header_font">'.$hook_translated['contact_wait_text'].'</div>
	        <input type="hidden" name="c_submitted" id="c_submitted" value="true" />
	        <div class="clearfix"></div>
	        <div id="submit_message_div" class="colored_theme_button prk_small">
	            <a href="#">'.$hook_translated['contact_submit'].'</a>
	        </div></form></div><div class="clearfix"></div>';
            return $out;
        }
    }
    add_shortcode('prk_contact_form', 'prk_contact_form_shortcode');

    //THEME VCARD
    if (!function_exists('prk_vcard_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function prk_vcard_shortcode($atts, $content=null ) {
            $atts=shortcode_atts(array(
                'text_color' => '',
                'css_animation' =>'',
                'css_delay' =>'hook_center_align',
                'el_class' => '',
                'image_path' => '',
                'company_name' => '',
                'company_text_color' => '',
                'street_address' => '',
                'locality' => '',
                'postal_code' => '',
                'email' => '',
                'tel' => '',
                'fax' => '',
                'hours' => '',
            ), $atts);
            $extra_class=$inline=$font_class="";
            if ($atts['text_color']!="") {
                $inline=' style="color:'.$atts['text_color'].'"';
                $extra_class=" forced_color";
            }
            $main_classes="";
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            if (isset($content) && $content!="" && strlen($content)>8) {
                $out='<div class="hook_vcard header_font prk_heavier_400 shortcoded'.$extra_class.$main_classes.'"'.$inline.'>';
            }
            else {
                $content="";
                $out='<div class="hook_vcard header_font prk_heavier_600 shortcoded'.$extra_class.$main_classes.'"'.$inline.'>';
                $font_class=" prk_9_em";
            }
            if ($atts['image_path']!="") {
                $in_image=wp_get_attachment_image_src( $atts['image_path'],'');
                $out.='<img src="'.$in_image[0].'" alt="'.hook_alt_tag(false,$in_image[0]).'" class="hook_vcard_logo" />';
            }
            if ($content!="" && strlen($content)>8) {
                $out.='<div class="small-12 hook_vcard_description prk_heavier_400"><div class="wpb_text_column">'.$content.'</div></div>';
            }
            $out.='<div class="adr small-12 zero_color">';
            if ($atts['company_name']!="") {
                if ($atts['company_text_color']!="") {
                    $out.='<div class="hook_company_name zero_color prk_heavier_700" style="color:'.$atts['company_text_color'].'">'.$atts['company_name'].'</div>';
                }
                else {
                    $out.='<div class="hook_company_name zero_color prk_heavier_700"'.$inline.'>'.$atts['company_name'].'</div>';
                }
            }
            $flaga=false;
            if ($atts['street_address']!="") {
                $out.='<div class="wpb_text_column'.$font_class.'"'.$inline.'>'.$atts['street_address'].'</div>';
                $flaga=true;
            }
            if ($atts['locality']!="") {
                $out.='<div class="wpb_text_column'.$font_class.'"'.$inline.'>'.$atts['locality'].'</div>';
                $flaga=true;
            }
            if ($atts['postal_code']!="") {
                $out.='<div class="wpb_text_column'.$font_class.'"'.$inline.'>'.$atts['postal_code'].'</div>';
                $flaga=true;
            }
            $out.='<div class="wpb_text_column"></div>';
            $out.='</div>';
            if ($flaga==true) {
                $out.='<div class="clearfix"></div>';
                $out.='<div class="simple_line thick"></div>';
            }
            if ($atts['email']!="") {
                $pieces = explode(" - ", $atts['email']);
                foreach ($pieces as $piece) {
                    $out.='<div class="hook_vcard_block small-12">';
                    $out.='<div class="hook_after_vcard_icon"><div class="wpb_text_column">';
                    $out.='<a class="zero_color" href="mailto:'.antispambot($piece).'"'.$inline.'>'.antispambot($piece).'</a>';
                    $out.='</div></div>';
                    $out.='</div>';
                }
            }
            if ($atts['tel']!="") {
                $out.='<div class="hook_vcard_block small-12">';
                $out.='<div class="wpb_text_column zero_color"'.$inline.'>';
                $out.=$atts['tel'];
                $out.='</div>';
                $out.='</div>';
            }
            if ($atts['fax']!="") {
                $out.='<div class="hook_vcard_block small-12">';
                $out.='<div class="wpb_text_column zero_color"'.$inline.'>';
                $out.=$atts['fax'];
                $out.='</div>';
                $out.='</div>';
            }
            if ($atts['hours']!="") {
                $out.='<div class="hook_vcard_block small-12">';
                $out.='<div class="hook_after_vcard_icon zero_color"'.$inline.'><div class="wpb_text_column">';
                $out.=$atts['hours'];
                $out.='</div></div>';
                $out.='</div>';
            }
            $out.='<div class="clearfix"></div>';
            $out.='</div>';
            return $out;
        }
    }
    add_shortcode('pirenko_contact_info', 'prk_vcard_shortcode');

    //TIMELINE
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_timeline_shortcode($atts, $content=null ) {
        $inline=$inline_bk="";
        if (isset($atts['text_color']) && $atts['text_color']!="") {
            $inline=' style="color:'.$atts['text_color'].'"';
            $inline_bk=' style="background-color:'.$atts['text_color'].'"';
        }
        $out='<div class="prk_timeline"><ul class="unstyled">';
        $timelines=explode( ",", $atts['values']);
        foreach ( $timelines as $timeline ) {
            $data=explode( "|", $timeline );
            $out.='<li'.$inline.'>';
            $out.='<div class="hook_tmmarker"'.$inline_bk.'></div>';
            $out.='<div class="hook_tmheader header_font">'.$data[0].'</div>';
            $out.='<div class="hook_tmdesc header_font">'.$data[1].'</div>';
            $out.='</li>';
        }
        $out.='</ul><div class="clearfix"></div></div>';
        return $out;
    }
    add_shortcode('prk_timeline', 'prk_timeline_shortcode');

    //INFORMATIONAL BOARD
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function prk_board_shortcode($atts, $content=null ) {
        $atts=shortcode_atts(array(
            'cols_width' => '20%|50%|30%',
            'css_animation' => '',
            'el_class' => '',
            'css_delay' => '',
            'board_header' => '',
            'values' => '',
            'link_text' => '',
            'target' => '_blank',//HARDCODED
        ), $atts);
        $main_classes="";
        if ($atts['css_animation']!="") {
            $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
        }
        if ($atts['css_delay']!="") {
            $main_classes.=" delay-".$atts['css_delay'];
        }
        if ($atts['el_class']!="") {
            $main_classes.=" ".$atts['el_class'];
        }
        $counter=0;
        $columns=explode( ",", $atts['cols_width']);
        $cols_width=explode( "|", $columns[0]);
        $headings=explode( ",", $atts['board_header']);
        $headings_text=explode( "|", $headings[0]);
        $out='<div class="hook_info_board'.$main_classes.'"><ul class="unstyled"><li class="hook_bk_site hook_board_heading header_font prk_heavier_700 zero_color">';
        foreach ($cols_width as $col_width ) {
            $out.='<span style="width:'.$col_width.';">'.$headings_text[$counter].'</span>';
            $counter++;
        }
        $out.='</li>';
        $board_lines=explode( ",", $atts['values']);
        foreach ( $board_lines as $board_line ) {
            $data=explode( "|", $board_line );
            $out.='<li class="hook_board_entry prk_bordered_top prk_9_em">';
            $counter=0;
            foreach ($cols_width as $col_width ) {
                if(filter_var($data[$counter], FILTER_VALIDATE_URL)){
                    $data[$counter]='<div class="theme_button prk_tiny"><a href="'.hook_change_links($data[$counter]).'" target="'.$atts['target'].'">'.$atts['link_text'].'</a></div>';
                }
                $out.='<span style="width:'.$col_width.';">'.$data[$counter].'</span>';
                $counter++;
            }
            $out.='</li>';
        }
        $out.='<li class="clearfix prk_bordered_top"></li>';
        $out.='</ul><div class="clearfix"></div></div>';
        return $out;
    }
    add_shortcode('prk_board', 'prk_board_shortcode');

    //SCHEDULE
    if (!function_exists('pirenko_schedule_shortcode')) {
        /**
         * @param $atts
         * @param null $content
         * @return string
         */
        function pirenko_schedule_shortcode($atts, $content=null ) {
            $atts=shortcode_atts(array(
                'element_type' => 'title',
                'head_title_left' =>'',
                'head_title_right' =>'',
                'event_title' => '',
                'event_subtitle' => '',
                'event_time' => '',
                'css_animation' => '',
                'el_class' => '',
                'css_delay' => '',
            ), $atts);
            $main_classes="";
            if ($atts['css_animation']!="") {
                $main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
            }
            if ($atts['css_delay']!="") {
                $main_classes.=" delay-".$atts['css_delay'];
            }
            if ($atts['el_class']!="") {
                $main_classes.=" ".$atts['el_class'];
            }
            $out='<div class="hook_schedule small-12'.$main_classes.'">';
            if ($atts['element_type']=="title") {
                $out.='<div class="hook_sc_title header_font prk_bordered_top prk_bordered_bottom small-12 prk_lf">';
                $out.='<div class="prk_lf zero_color prk_heavier_600">'.$atts['head_title_left'].'</div>';
                $out.='<div class="prk_rf">'.$atts['head_title_right'].'</div>';
                $out.='</div>';
            }
            else if ($atts['element_type']=="event") {
                $out.='<div class="hook_sc_event small-12 prk_lf">';
                $out.='<div class="row">';
                $out.='<div class="small-3 columns zero_color">';
                $out.='<div class="prk_lf small-12 prk_heavier_600 prk_11_em">'.$atts['event_time'].'</div>';
                $out.='<div class="prk_lf small-12 prk_9_em">'.$atts['event_subtitle'].'</div>';
                $out.='</div>';
                $out.='<div class="small-9 columns">';
                $out.='<div class="small-12 prk_lf zero_color prk_heavier_600">'.$atts['event_title'].'</div>';
                $out.='<div class="prk_lf">'.$content.'</div>';
                $out.='</div>';
                $out.='</div>';
                $out.='</div>';
            }
            $out.='</div>';
            $out.='<div class="clearfix"></div>';
            if ($atts['element_type']=="event" && strpos($atts['el_class'], 'hook_last_event') === false) {
                $out.='<div class="simple_line show_later hook_scheduled"></div>';
            }
            return $out;
        }
    }
    add_shortcode('pirenko_schedule', 'pirenko_schedule_shortcode');
}