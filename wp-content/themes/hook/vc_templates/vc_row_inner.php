<?php
/** @var $this WPBakeryShortCode_VC_Row */
$output = $css_animation = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = $el_id = $parallax_image = $parallax = $row_fixed = $equal_height = $overlay_alpha = '';
extract( shortcode_atts( array(
    'el_class' => '',
    'bg_image' => '',
    'bg_color' => '',
    'bg_image_repeat' => '',
    'font_color' => '',
    'padding' => '',
    'margin_bottom' => '',
    'row_height'   => '',
    'bk_type' =>'',
    'align' =>'',
    'preload_bk' =>'',
    'bk_element' => '',
    'vid_parallax'=>'no',
    'append_arrow' =>'',
    'vid_mp4' =>'',
    'vid_webm' =>'',
    'bk_overlay' =>'',
    'row_fixed' =>'',
    'css' => '',
    'bottom_padding' =>'',
    'css_animation' => '',
    'top_padding' =>'',
    'hide_with_css' =>'',
    'el_id' => '',
    'equal_height' => '',
    'hook_inv_cols' => '',
    'css_delay' => '',
    'append_arrow_color' => '',
    'custom_css' => '',
    'in_link' => '',
    'overlay_alpha' => '',
), $atts ) );
if ($bk_type=="full_width")
    $prk_css_classes=" vc_row hook_full_row prk_section hook_row vc_row-fluid";
else
    $prk_css_classes=" vc_row hook_row vc_row-fluid";

//DELAY SUPPORT
if (isset($atts['css_delay'])) {
    $prk_css_classes.=' delay-'.$atts['css_delay'];
}

//ALIGNMENT SUPPORT
if (isset($atts['align'])) {
    $prk_css_classes.=' '.$atts['align'];
}

//PARALLAX SUPPORT
$parallax_code='';
if (isset($atts['bg_image_repeat'])) {
    $prk_css_classes.=' '.$atts['bg_image_repeat'];
    if (strpos($atts['bg_image_repeat'], 'hook_with_parallax')!==false) {
        if (strpos($atts['bg_image_repeat'], 'hook_attached')!==false) {
            $parallax_code=' data-bottom-top="background-position: 50% 300px;" data-top-bottom="background-position: 50% -200px;"';
        }
        else {
            $parallax_code=' data-bottom-top="background-position: 50% 0px;" data-top-bottom="background-position: 50% -350px;"';
        }
    }
}

//HEIGHT ADJUST SUPPORT
$adjust_code='';
if (isset($atts['height_adjust']) && $atts['height_adjust']!="") {
    $cleaned=preg_replace("/[^0-9]/","",$atts['height_adjust']);
    $adjust_code=' data-adjust="'.$cleaned.'"';
}

//FORCED HEIGHT SUPPORT
if ($row_height!="") {
    $prk_css_classes.=" ".$row_height;
}

//SCROLL DOWN ARROW SUPPORT
$arrow_code='';
if (isset($atts['append_arrow']) && $atts['append_arrow']=="yes") {
    $in_link=$in_color="";
    if (isset($atts['append_arrow_color']) && $atts['append_arrow_color']!="") {
        $in_color=' style="color:'.$atts['append_arrow_color'].'"';
    }
    if (isset($atts['in_link']) && $atts['in_link']!="") {
        if (substr( $atts['in_link'], 0, 1 ) !== "#") {
            $atts['in_link']="#".$atts['in_link'];
        }
        $in_link=$atts['in_link'];
    }
    $arrow_code='<a href="'.$in_link.'" class="hook_next_link hook_anchor"><div class="hook_next_arrow"'.$in_color.'><i class="mdi-chevron-down"></i></div></a>';
    $prk_css_classes.=" plus_arrow";
}

//OVERLAY SUPPORT
if (isset($atts['bk_overlay']) && $atts['bk_overlay']!="") {
    if (!is_numeric($overlay_alpha)) {
        $overlay_alpha=100;
    }
    $overlay_alpha=$overlay_alpha/100;
    $overlay_code='<div class="row_pattern_overlay" style="background-image:url('.get_template_directory_uri().'/images/overlays/'.$atts['bk_overlay'].');opacity:'.$overlay_alpha.'"></div>';
    $prk_css_classes.=" hook_with_overlay";
}
else {
    $overlay_code='';
}

//BK IMAGE PRELOAD SUPPORT
if ($bg_image!="") {
    $image_attributes = wp_get_attachment_image_src( $bg_image,'full' );
    if (isset($atts['preload_bk']) && $atts['preload_bk']=="yes") {
        $arrow_code.='<div class="hook_preloaded"><img src="'.$image_attributes[0].'" alt="'.hook_alt_tag(true,$bg_image).'" /></div>';
        $prk_css_classes.=" hook_preloaded_row";
    }
}

//PADDING SUPPORT
$inner_inline="";
if (isset($atts['top_padding']) && $atts['top_padding']!="") {
    $inner_inline=' style="padding-top:'.$atts['top_padding'].';';
}
if (isset($atts['bottom_padding']) && $atts['bottom_padding']!="") {
    if ($inner_inline=="") {
        $inner_inline=' style="padding-bottom:'.$atts['bottom_padding'].';';
    }
    else {
        $inner_inline.='padding-bottom:'.$atts['bottom_padding'].';';
    }
}

//SOONER RESPONSIVE SUPPORT
if (isset($atts['mobile_mode']) && $atts['mobile_mode']!="") {
    $prk_css_classes.=' hook_sooner';
}

//HIDE WITH CSS SUPPORT
if (isset($atts['hide_with_css']) && $atts['hide_with_css']!="") {
    $hide_with_css = str_replace(',', ' ', $atts['hide_with_css']);
    $prk_css_classes .= $this->getExtraClass($hide_with_css);
}

//FIXED HEIGHT SUPPORT
if ($row_height=="hook_fixed_height" && isset($atts['row_fixed']) && $atts['row_fixed']!="") {
    if ($inner_inline=="") {
        $inner_inline=' style="min-height:'.$atts['row_fixed'].'px;';
    }
    else {
        $inner_inline.='min-height:'.$atts['row_fixed'].'px;';
    }
}
if ($inner_inline!="") {
    $inner_inline.='"';
}

//VIDEO SUPPORT
$video_code='';
if (isset($atts['bk_element']) && $atts['bk_element']=='video') {
    $vid_mp4=$vid_webm=$custom_poster=$vid_parallax_code=$vid_class="";
    if (isset($atts['vid_image']) && $atts['vid_image']!="")
    {
        $image_attributes_video = wp_get_attachment_image_src( $atts['vid_image'],'full' );
        $custom_poster=' poster="'.$image_attributes_video[0].'"';
    }
    if (isset($atts['vid_parallax']) && $atts['vid_parallax']=="yes") {
        $vid_class=" parallax_video";
        $vid_parallax_code=' data-bottom-top="bottom: 0px;" data-top-bottom="bottom: 50px;"';
    }
    else {
        $vid_class=" no_laxy";
    }
    if (isset($atts['vid_mp4']) && $atts['vid_mp4']!="")
    {
        $vid_mp4=$atts['vid_mp4'];
    }
    if (isset($atts['vid_webm']) && $atts['vid_webm']!="")
    {
        $vid_webm=$atts['vid_webm'];
    }
    if (strpos($el_class,'hook_sound_on') !== false) {
        $video_code='<video class="hook_video-bg'.$vid_class.'" autoplay="autoplay" preload="auto" loop=""'.$custom_poster.$vid_parallax_code.'>';
    }
    else {
        $video_code='<video class="hook_video-bg'.$vid_class.'" autoplay="autoplay" preload="auto" muted="" loop=""'.$custom_poster.$vid_parallax_code.'>';
    }
    $video_code.='<source src="'.$vid_mp4.'" type="video/mp4">';
    $video_code.='<source src="'.$vid_webm.'" type="video/webm">';
    $video_code.='</video>';
    $prk_css_classes.=" hook_with_video";
}

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ).$el_class.vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$css_class .= $this->getCSSAnimation( $css_animation );
//ROWS WITH EQUAL HEIGHT SUPPORT
if ( ! empty( $equal_height ) ) {
    $css_class.= ' vc_row-o-equal-height vc_row-flex';
}
$css_class=rtrim($css_class);

//ROWS WITH INVERTED COLUMNS SUPPORT
if ( ! empty( $hook_inv_cols ) ) {
    $css_class.=' hook_inv_cols';
}

$style = $this->buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );

//CUSTOM CSS SUPPORT
if ($custom_css!="") {
    if ($style=="") {
        $style.='style="'.$custom_css.'"';
    }
    else {
        $style=substr($style, 0, -1);
        $style.=''.$custom_css.'"';
    }
}
if ($style!="") {
    $style=" ".$style;
}
if (isset( $el_id ) && ! empty( $el_id )) {
    $row_id=esc_attr($el_id);
}
else {
    $row_id='hook-in-'.rand(1, 100000);
}
if ($bk_type=="hook_full_row") {
    $output .= '<div id="'.$row_id.'" class="small-12 hook_super_width '.$css_class.$prk_css_classes.'" '.$style.$parallax_code.'>';
    $output.=$overlay_code;
    $output .=$video_code;
    $output .= '<div class="hook_outer_row"'.$inner_inline.$adjust_code.'>';
    $output .= '<div class="row">';
    $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';
    $output .= '</div>'.$arrow_code;
    $output .= '</div>'.$this->endBlockComment('row');
}
else {
    $output .= '<div id="'.$row_id.'" class="hook_reg_width '.$css_class.$prk_css_classes.'" '.$style.$parallax_code.'>';
    $output.=$overlay_code;
    $output .=$video_code;
    $output .= '<div class="extra_pad prk_inner_block columns small-centered clearfix"'.$adjust_code.'>';
    $output .= '<div class="hook_outer_row"'.$inner_inline.'>';
    $output.='<div class="row">';
    $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>'.$arrow_code;
    $output .= '</div>'.$this->endBlockComment('row');
}
$output.='<div class="clearfix"></div>';
echo hook_output().$output;
