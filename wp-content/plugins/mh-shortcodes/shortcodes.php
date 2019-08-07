<?php
// Shortcodes
// =============================================================================

//// All
//   01. Buttons
//   02. Marker (highlight)
//   03. Alert boxes
//   04. Clearfix tool
//   05. Separator (vertically) with colour
//   06. Link
// Buttons
// =============================================================================

function mhsc_shortcode_button( $atts, $content = null ) {
  extract( shortcode_atts( array(
	'href'             => '',
	'shape'            => '',
	'size'             => '',
	'fullwidth'            => '',
	'title'            => '',
	'target'           => '',
	'color'					=> '',
	'txcolor'     => '',
	'id'               => '',
	'class'            => ''
  ), $atts ) );

$id			   = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
$class			= ( $class != '' ) ? ' ' . esc_attr( $class ) : '';
$type			 = ( $shape != '' ) ? ' mhc_' . esc_attr( $shape ) : '';
$size			 = ( $size  != '' ) ? ' mhsc_btn_' . esc_attr( $size ) : '';
$fullwidth		= ( $fullwidth            == 'true'  ) ? ' mhsc_btn_fullwidth' : '';
$href			 = ( $href  != '' ) ? esc_url( $href ) : '#';
$title            = ( $title != '' ) ? 'title="' . esc_html( $title ) . '"' : '';
$txcolor		  = ( $txcolor != '' ) ? ' color:' . esc_html( $txcolor ) . '!important;' : '';
if($shape != 'transify'){
	$color        = ( $color != '' ) ? ' background:' . esc_html( $color ) . '; border-color:' . $color .';' : '';
}else{
	$color        = ( $color != '' ) ? ' border-color:' . esc_html( $color ) . ';' : '';
}
$target           = ( $target == 'blank' ) ? 'target="_blank"' : '';



    $output = "<a {$id} class=\"mhsc_btn mhc_promo_button{$class}{$type}{$size}{$fullwidth}\" style=\"{$color}{$txcolor}\" href=\"{$href}\" {$title} {$target}>" . do_shortcode( $content ) . "</a>";
  
  return $output;
}

add_shortcode( 'button', 'mhsc_shortcode_button' );


// Marker (highlight) >> light & dark
// =============================================================================

function mhsc_shortcode_marker( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => '',
    'color'  => '',
		'txcolor' =>'',

  ), $atts ) );

$id	   = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
$class 	= ( $class != '' ) ? 'mhsc_marker ' . esc_attr( $class ) : 'mhsc_marker';
$style	= ( $style	!= '' ) ? $style : ' ';
$color    = ( $color	!= '' ) ? ' background-color:' . esc_html( $color ) . ';' : '';
switch ( $txcolor ) {
    case 'dark' :
      $txcolor = ' dark_text';
      break;
			 case 'light' :
      $txcolor = ' light_text';
      break;
			default :
      $txcolor = ' dark_text';
  }
  $output = "<marker {$id} class=\"{$class}{$txcolor}\" style=\"{$color} {$style}\" >" . do_shortcode( $content ) ."</marker>";
  
  return $output;
}

add_shortcode( 'marker', 'mhsc_shortcode_marker' );


// Alert boxes
// =============================================================================

function mhsc_shortcode_alert( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'      => '',
    'class'   => '',
    'style'   => '',
    'heading' => '',
	'color' => '',
	'border' => '',
    'close'   => ''
  ), $atts ) );

  $id      = ( $id      != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class   = ( $class   != '' ) ? 'mhsc_alert ' . esc_attr( $class ) : 'mhsc_alert';
  $style   = ( $style   != '' ) ? 'style="' . esc_html( $style ) . '"' : '';
$border            = 'border: 2px solid ' . esc_html( $color ) . ';';
$color            = ( $color            != ''      ) ? ' color:' . esc_html( $color ) . ';' : '';	
  $heading = ( $heading != '' ) ? $heading = '<h3 class="h_alert">' . esc_html( $heading ) . '</h3>' : $heading = '';
  if ( $close == "true" ) {
    $close = "fade in";
    $close_btn = "<button type=\"button\" class=\"mhsc_close\" data-dismiss=\"alert\" style=\"{$color}\">&times;</button>";
  } else {
    $close = " mhsc_alert_block";
    $close_btn = "";
  }
    
  $output = "<div {$id} class=\"{$class} {$close}\" style=\"{$color} {$border} {$style}\" >{$close_btn}{$heading}" . do_shortcode( $content ) . "</div>";
  
  return $output;
}

add_shortcode( 'alert', 'mhsc_shortcode_alert' );


// Clearfix tool
// =============================================================================

function mhsc_shortcode_clearfix( $atts ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => ''
  ), $atts ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'clearfix ' . esc_attr( $class ) : 'clearfix';
  $style = ( $style != '' ) ? 'style="' . esc_html( $style ) . '"' : '';
    
  $output = "<div {$id} class=\"{$class}\" {$style}></div>";
  
  return $output;
}

add_shortcode( 'clearfix', 'mhsc_shortcode_clearfix' );



// Separator (vert) >> in px
// =============================================================================

function mhsc_shortcode_separator( $atts ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => '',
    'size'  => '',
		'color' => ''
  ), $atts ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'mhsc_separator ' . esc_attr( $class ) : 'mhsc_separator';
  $style = ( $style != '' ) ? esc_html( $style ) : '';
  $size  = ( $size  != '' ) ? " height: {$size}px; margin: 0;" : ' height: 0; margin: 0;';
  $color = ( $color != '' ) ? ' background:' . esc_html( $color ) . ';' : '';
    
  $output = "<div {$id} class=\"{$class} clearfix\" style=\"{$style}{$color}{$size}\"></div>";
  
  return $output;
}

add_shortcode( 'separator', 'mhsc_shortcode_separator' );


// Link
// =============================================================================

function mhsc_shortcode_link( $atts, $content = null ) {
   extract( shortcode_atts( array(
	'href'             => '',
	'title'            => '',
	'target'           => '',
	'id'               => '',
	'class'            => ''
  ), $atts ) );

  $id    = ( $id != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? ' ' . esc_attr( $class ) : '';
  $href  = ( $href != '' ) ? esc_url( $href ) : '#';
  $title = ( $title != '' ) ? 'title="' . esc_html( $title ) . '"' : '';
  $target = ( $target == 'blank' ) ? 'target="_blank"' : '';



    $output = "<a {$id} class=\"{$class}\" href=\"{$href}\" {$title} {$target}>" . do_shortcode( $content ) . "</a>";
  
  return $output;
}

add_shortcode( 'link', 'mhsc_shortcode_link' );