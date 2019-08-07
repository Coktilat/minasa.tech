<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $nav_menu
 * @var $el_class
 * @var $align
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Wp_Custommenu
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$el_class.=' '.$align;

$output = '<div class="vc_wp_custommenu wpb_content_element'.esc_attr( $el_class ).'">';
$type = 'WP_Nav_Menu_Widget';
$args = array();
global $wp_widget_factory;
// to avoid unwanted warnings let's check before using widget
if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	the_widget( $type, $atts, $args );
	$output .= ob_get_clean();

	$output .= '</div>'.$this->endBlockComment( $this->getShortcode() )."\n";

	echo hook_output().$output;
} else {
	echo hook_output().$this->endBlockComment( 'Widget '.esc_attr( $type ).'Not found in : vc_wp_custommenu' );
}