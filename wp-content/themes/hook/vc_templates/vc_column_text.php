<?php
$output = $el_class = $css_animation = $drop_cap = '';

extract( shortcode_atts( array(
	'drop_cap' => '',
	'el_class' => '',
	'css_animation' => '',
	'css_delay' => '',
	'css' => '',
	'custom_css' => '',
	'el_id' => '',
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element '.$el_class.vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );
$css_class=preg_replace('/\s+/', ' ', $css_class);

//DELAY SUPPORT
if (isset($atts['css_delay'])) {
    $css_class.=' delay-'.$atts['css_delay'];
}

//CUSTOM CSS SUPPORT
$hook_style="";
if ($custom_css!="") {
	$hook_style=' style="'.$custom_css.'"';
}

//DROP CAP SUPPORT
if ($drop_cap=="yes") {
	$css_class.=" hook_drop_cap";
}

//CUSTOM ID SUPPORT
$hook_id='';
if (!empty($el_id)) {
	$hook_id = 'id="'.esc_attr( $el_id ).'" ';
}

$output .= "\n\t".'<div '.$hook_id.'class="'.esc_attr($css_class).'"'.$hook_style.'>';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop( $content, true );
$output .= "\n\t\t".'</div> '.$this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t".'</div> '.$this->endBlockComment( '.wpb_text_column' );

echo hook_output().$output;