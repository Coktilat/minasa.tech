<?php
extract( shortcode_atts( array(
	'title' => '',
	'title_align' => '',
	'align' => 'align_center',
	'el_width' => '',
	'border_width' => '',
	'style' => '',
	'color' => '',
	'accent_color' => '',
	'font_type' => '',
	'css_animation' => '',
	'el_class' => '',
	'css_delay' => '',
	'layout' => 'separator_with_text'
), $atts ) );
$class = "vc_separator wpb_content_element";

$class .= ( $title_align != '' ) ? ' vc_'.$title_align : '';
$class .= ( $el_width != '' ) ? ' vc_sep_width_'.$el_width : ' vc_sep_width_100';
$class .= ( $style != '' ) ? ' vc_sep_'.$style : '';
$class .= ( $border_width != '' ) ? ' vc_sep_border_width_'.$border_width : '';
$class .= ( $align != '' ) ? ' vc_sep_pos_'.$align : '';

$class .= ( $layout == 'separator_no_text' ) ? ' vc_separator_no_text' : '';
if ( $color != '' && 'custom' != $color ) {
	$class .= ' vc_sep_color_'.$color;
}
$inline_css = ( 'custom' == $color && $accent_color != '' ) ? ' style="'.vc_get_css_color( 'border-color', $accent_color ).'"' : '';

if ($accent_color!="") {
	$text_css=' style="color:'.$accent_color.';"';
}
else {
	$text_css="";
}

$class .= $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$css_class.=" ".$font_type;
$css_class .= $this->getCSSAnimation( $css_animation );

//DELAY SUPPORT
if (isset($atts['css_delay'])) {
    $css_class.=' delay-'.$atts['css_delay'];
}

$css_class=rtrim($css_class);
?>
	<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">
		<span class="vc_sep_holder vc_sep_holder_l"><span<?php echo hook_output().$inline_css; ?> class="vc_sep_line"></span></span>
		<?php if ($title!='') {echo '<h4'.$text_css.'>'.$title.'</h4>';} ?>
		<span class="vc_sep_holder vc_sep_holder_r"><span<?php echo hook_output().$inline_css; ?> class="vc_sep_line"></span></span>
	</div>
<?php echo hook_output().$this->endBlockComment( 'separator' )."\n";