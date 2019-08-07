<?php
/**
 * @var $this WPBakeryShortCode_VC_Column
 */
$output = $font_color = $el_class = $width = $offset = $css_animation = '';
extract( shortcode_atts( array(
	'font_color' => '',
	'bg_color' => '',
	'el_class' => '',
	'width' => '1/1',
	'column_height' => '',
	'bg_image_hz_align' => '',
	'bg_image_vt_align' => '',
	'bg_image' => '',
	'col_width' => '',
	'caption' => '',
	'caption_position' => '',
	'css' => '',
	'css_animation' => '',
	'css_delay' => '',
	'custom_css' => '',
	'hide_with_css' =>'',
	'offset' => ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );
if ($width=="1/5") {
    $width="vc_col-sm-20";
}
else {
    $width = wpb_translateColumnWidthToSpan( $width );
    $width = vc_column_offset_class_merge( $offset, $width );
}
$el_class .= ' columns vc_column_container';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class, $this->settings['base'], $atts );

//Vc601
$css_classes = array(
    $css_class,
    'wpb_column',
);
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );

//BACKGROUND STYLES SUPPORT
$hook_style=' style="';
if ($bg_image!="") {
	$img_url = wp_get_attachment_image_src( $bg_image, 'full' );
    $hook_style.='background-image:url('.$img_url[0].');';
    if ($bg_image_hz_align!="") {
    	$css_class.=' '.$bg_image_hz_align;
    }
    if ($bg_image_vt_align!="") {
    	$css_class.=' '.$bg_image_vt_align;
    }
}
else {
	if ($bg_color!="") {
	    $hook_style.='background-color:'.$bg_color.';';
	}
}
//CUSTOM CSS SUPPORT
if ($custom_css!="") {
	$hook_style.=$custom_css;
}
if ($hook_style!=' style="') {
	$hook_style.='"';
}
else {
	$hook_style="";
}

//ALIGNMENT SUPPORT
if (isset($atts['align'])) {
    $css_class.=' '.$atts['align'];
}

//100% HEIGHT SUPPORT
if ($column_height!="") {
	$css_class.=' '.$column_height;
}

//INNER COLUMN WIDTH SUPPORT
$hook_inner_style='';
if ($col_width!="") {
	$col_width=(100-$col_width)/2;
	$hook_inner_style=' style="padding-left:'.$col_width.'%;padding-right:'.$col_width.'%;margin-left:auto;margin-right:auto;"';
}

//CAPTION SUPPORT
$hook_caption='';
if ($caption!="") {
	if($caption_color!="") {
		$hook_caption='<div class="prk_caption '.$caption_position.'" style="color:'.$caption_color.';">'.$caption.'</div>';
	}
	else {
		$hook_caption='<div class="prk_caption '.$caption_position.'">'.$caption.'</div>';
	}
}

$css_class .= $this->getCSSAnimation( $css_animation );

//DELAY SUPPORT
if (isset($atts['css_delay'])) {
    $css_class.=' delay-'.$atts['css_delay'];
}

//HIDE WITH CSS SUPPORT
if (isset($atts['hide_with_css']) && $atts['hide_with_css']!="") {
	$hide_with_css = str_replace(',', ' ', $atts['hide_with_css']);
	$css_class .= $this->getExtraClass($hide_with_css);
}

$css_class=rtrim($css_class);


$output .= "\n\t".'<div class="'.$css_class.'"'.$hook_style.'>';
$output .= "\n\t\t".'<div class="wpb_wrapper"'.$hook_inner_style.'>';
$output .= "\n\t\t\t".wpb_js_remove_wpautop( $content );
$output .= "\n\t\t".'</div> '.$this->endBlockComment( '.wpb_wrapper' );
$output .= $hook_caption;
$output .= "\n\t".'</div> '.$this->endBlockComment( $el_class )."\n";
echo hook_output().$output;