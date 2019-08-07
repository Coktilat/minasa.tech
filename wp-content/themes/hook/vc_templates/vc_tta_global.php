<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
$this->setGlobalTtaInfo();

$this->enqueueTtaScript();

// It is required to be before tabs-list-top/left/bottom/right for tabs/tours
$prepareContent = $this->getTemplateVariable( 'content' );


//CUSTOM CSS SUPPORT
$hook_style=' style="';
if (isset($atts['custom_css']) && $atts['custom_css']!="") {
	$hook_style.=$atts['custom_css'];
}
if ($hook_style!=' style="') {
	$hook_style.='"';
}
else {
	$hook_style="";
}
$hook_class='';
if (isset($atts['numbers_acc']) && $atts['numbers_acc']!="") {
	$hook_class=$atts['numbers_acc'];
}

$output = '<div '.$this->getWrapperAttributes().' ' .$hook_style. '>';
$output .= $this->getTemplateVariable( 'title' );
$output .= '<div class="'.esc_attr($this->getTtaGeneralClasses()).$hook_class.'">';
$output .= $this->getTemplateVariable( 'tabs-list-top' );
$output .= $this->getTemplateVariable( 'tabs-list-left' );
$output .= '<div class="vc_tta-panels-container">';
$output .= $this->getTemplateVariable( 'pagination-top' );
$output .= '<div class="vc_tta-panels">';
$output .= $prepareContent;
$output .= '</div>';
$output .= $this->getTemplateVariable( 'pagination-bottom' );
$output .= '</div>';
$output .= $this->getTemplateVariable( 'tabs-list-bottom' );
$output .= $this->getTemplateVariable( 'tabs-list-right' );
$output .= '</div>';
$output .= '</div>';

$output.='<div class="clearfix"></div>';
$output.='<div class="clearfix"></div>';

echo hook_output().$output;
