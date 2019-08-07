<?php
/*
Plugin Name: Hook Framework
Plugin URI: https://themeforest.net/user/Pirenko/portfolio/
Description: Plugin that creates custom post types and shortcodes to work with Hook WordPress Theme
Version: 3.5.1
Author: Pirenko
Author URI: https://www.pirenko.com/
License: GPLv2
*/

if( !defined('PLUGIN_PATH') ) {
    define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
if( !defined('PLUGIN_URL') ) {
    define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

define('HOOK_PLUGIN_ID','16278811');

if (!function_exists('register_field_group') && !function_exists('get_field')) {
    include_once dirname(__FILE__) . '/inc/modules/advanced-custom-fields/acf.php';
}
include_once PLUGIN_PATH.'/shortcodes.php' ;
include_once PLUGIN_PATH.'/custom_post_types.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-twitter/pirenko-twitter.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-instagram-feed/instagram.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-social-links/social.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-vcard/vcard.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-advertising/pirenko-ads.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-tags/tags.php';
if (!function_exists('prk_church_integrateWithVC')) {
    include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-recent_portfolio/posts.php';
}
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-recent_posts/posts.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-tags_portfolio/tags.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/pirenko-video/pirenko-video.php';
include_once PLUGIN_PATH.'/inc/theme_widgets/decent-comments/decent-comments.php';
include_once PLUGIN_PATH.'/inc/modules/acf-sidebar-selector-field/acf-sidebar_selector.php';
include_once PLUGIN_PATH.'/inc/modules/mobile_detect.php';
include_once PLUGIN_PATH.'/inc/vt_resize.php';
include_once PLUGIN_PATH.'/inc/core.php';
include_once PLUGIN_PATH.'/inc/lamp.php';

if (!function_exists('hook_fonts')) {
    function hook_fonts() {
        //109 FONTS AVAILABLE
        $prk_select_font_options=array(
            '9' => array(
                'value' => 'Acme',
                'hosted'=> 'google',
                'css' => 'Acme',
                'label' => esc_html__( 'Acme','hook')
            ),
            '4' => array(
                'value' => 'Alegreya:400italic,700italic,400,700',
                'hosted'=> 'google',
                'css' => 'Alegreya',
                'label' => esc_html__( 'Alegreya','hook')
            ),
            '109' => array(
                'value' => 'Amatic+SC:400,700',
                'hosted'=> 'google',
                'css' => "'Amatic SC', cursive;",
                'label' => esc_html__( 'Amatic SC','hook')
            ),
            '16' => array(
                'value' => 'Anton',
                'hosted'=> 'google',
                'css' => "'Anton', sans-serif",
                'label' => esc_html__( 'Anton','hook')
            ),
            '14' => array(
                'value' => 'arial',
                'hosted'=> 'self',
                'css' => 'Arial, sans-serif',
                'label' => esc_html__( 'Arial','hook')
            ),
            '88' => array(
                'value' => 'Arimo:400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Arimo', sans-serif",
                'label' => esc_html__( 'Arimo','hook')
            ),
            '72' => array(
                'value' => 'Arizonia',
                'hosted'=> 'google',
                'css' => "'Arizonia', cursive",
                'label' => esc_html__( 'Arizonia','hook')
            ),
            '5' => array(
                'value' => 'Arvo',
                'hosted'=> 'google',
                'css' => 'Arvo',
                'label' => esc_html__( 'Arvo','hook')
            ),
            '10' => array(
                'value' => 'Asap',
                'hosted'=> 'google',
                'css' => 'Asap',
                'label' => esc_html__( 'Asap','hook')
            ),
            '7' => array(
                'value' => 'Asul:400,700',
                'hosted'=> 'google',
                'css' => 'Asul',
                'label' => esc_html__( 'Asul','hook')
            ),
            '43' => array(
                'value' => 'Average+Sans',
                'hosted'=> 'google',
                'css' => "'Average Sans', sans-serif",
                'label' => esc_html__( 'Average Sans','hook')
            ),
            '84' => array(
                'value' => 'Berkshire+Swash',
                'hosted'=> 'google',
                'css' => "'Berkshire Swash', cursive",
                'label' => esc_html__( 'Berkshire Swash','hook')
            ),
            '42' => array(
                'value' => 'Bitter:400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Bitter', serif",
                'label' => esc_html__( 'Bitter','hook')
            ),
            '25' => array(
                'value' => 'Bree+Serif',
                'hosted'=> 'google',
                'css' => "'Bree Serif', serif",
                'label' => esc_html__( 'Bree Serif','hook')
            ),
            '11' => array(
                'value' => 'Cabin:400,600,700',
                'hosted'=> 'google',
                'css' => "'Cabin', sans-serif",
                'label' => esc_html__( 'Cabin','hook')
            ),
            '70' => array(
                'value' => 'Cabin+Condensed:400,500,600,700',
                'hosted'=> 'google',
                'css' => "'Cabin Condensed', sans-serif",
                'label' => esc_html__( 'Cabin Condensed','hook')
            ),
            '48' => array(
                'value' => 'Changa+One:400,400italic',
                'hosted'=> 'google',
                'css' => "'Changa One', cursive",
                'label' => esc_html__( 'Changa One','hook')
            ),
            '83' => array(
                'value' => 'Ceviche+One',
                'hosted'=> 'google',
                'css' => "'Ceviche One', cursive",
                'label' => esc_html__( 'Ceviche One','hook')
            ),
            '61' => array(
                'value' => 'Cinzel:400,700,900',
                'hosted'=> 'google',
                'css' => "'Cinzel', serif",
                'label' => esc_html__( 'Cinzel','hook')
            ),
            '29' => array(
                'value' => 'courier_new',
                'hosted'=> 'self',
                'css' => "'Courier New', Courier, monospace",
                'label' => esc_html__( 'Courier New','hook')
            ),
            '24' => array(
                'value' => 'Cousine:400,700',
                'hosted'=> 'google',
                'css' => "'Cousine', sans-serif",
                'label' => esc_html__( 'Cousine','hook')
            ),
            '51' => array(
                'value' => 'Coustard',
                'hosted'=> 'google',
                'css' => "'Coustard', serif",
                'label' => esc_html__( 'Coustard','hook')
            ),
            '56' => array(
                'value' => 'Crimson+Text:400,400italic,600,600italic',
                'hosted'=> 'google',
                'css' => "'Crimson Text', serif",
                'label' => esc_html__( 'Crimson Text','hook')
            ),
            '81' => array(
                'value' => 'Cutive+Mono',
                'hosted'=> 'google',
                'css' => "'Cutive Mono', serif",
                'label' => esc_html__( 'Cutive Mono','hook')
            ),
            '95' => array(
                'value' => 'Dancing+Script:400,700',
                'hosted'=> 'google',
                'css' => "'Dancing Script', cursive",
                'label' => esc_html__( 'Dancing Script','hook')
            ),
            '22' => array(
                'value' => 'Dosis:300,400,500,600,700',
                'hosted'=> 'google',
                'css' => "'Dosis', sans-serif",
                'label' => esc_html__( 'Dosis','hook')
            ),
            '1' => array(
                'value' => 'Droid+Sans:400,700',
                'css' => 'Droid Sans',
                'hosted'=> 'google',
                'label' => esc_html__( 'Droid Sans','hook')
            ),
            '8' => array(
                'value' => 'Droid+Serif:400,700,400italic,700italic',
                'css' => 'Droid Serif',
                'hosted'=> 'google',
                'label' => esc_html__( 'Droid Serif','hook')
            ),
            '73' => array(
                'value' => 'Dr+Sugiyama',
                'hosted'=> 'google',
                'css' => "'Dr Sugiyama', cursive",
                'label' => esc_html__( 'Dr Sugiyama','hook')
            ),
            '18' => array(
                'value' => 'Economica:700',
                'hosted'=> 'google',
                'css' => "'Economica', sans-serif",
                'label' => esc_html__( 'Economica','hook')
            ),
            '103' => array(
                'value' => 'Ek+Mukta:300,400,600,700',
                'hosted'=> 'google',
                'css' => "'Ek Mukta', sans-serif",
                'label' => esc_html__( 'Ek Mukta','hook')
            ),
            '79' => array(
                'value' => 'Engagement',
                'hosted'=> 'google',
                'css' => "'Engagement', cursive",
                'label' => esc_html__( 'Engagement','hook')
            ),
            '17' => array(
                'value' => 'Exo:400,500,600,700,400italic',
                'hosted'=> 'google',
                'css' => "'Exo', sans-serif",
                'label' => esc_html__( 'Exo Sans','hook')
            ),
            '65' => array(
                'value' => 'Exo+2:400,600,700,400italic,500',
                'hosted'=> 'google',
                'css' => "'Exo 2', sans-serif",
                'label' => esc_html__( 'Exo 2','hook')
            ),
            '69' => array(
                'value' => 'Expletus+Sans:400,500,600,700',
                'hosted'=> 'google',
                'css' => "'Expletus Sans', cursive",
                'label' => esc_html__( 'Expletus Sans','hook')
            ),
            '101' => array(
                'value' => 'Finger+Paint',
                'hosted'=> 'google',
                'css' => "'Finger Paint', cursive",
                'label' => esc_html__( 'Finger Paint','hook')
            ),
            '15' => array(
                'value' => 'Francois+One',
                'hosted'=> 'google',
                'css' => "'Francois One', sans-serif",
                'label' => esc_html__( 'Francois One','hook')
            ),
            '105' => array(
                'value' => 'Fredericka+the+Great',
                'hosted'=> 'google',
                'css' => "'Fredericka the Great', cursive",
                'label' => esc_html__( 'Fredericka the Great','hook')
            ),
            '96' => array(
                'value' => 'Fredoka+One',
                'hosted'=> 'google',
                'css' => "'Fredoka One', cursive",
                'label' => esc_html__( 'Fredoka','hook')
            ),
            '93' => array(
                'value' => 'Gentium+Book+Basic:400,400italic,700',
                'hosted'=> 'google',
                'css' => "'Gentium Book Basic', serif",
                'label' => esc_html__( 'Gentium Book Basic','hook')
            ),
            '89' => array(
                'value' => 'georgia',
                'hosted'=> 'self',
                'css' => "Georgia, serif",
                'label' => esc_html__( 'Georgia','hook')
            ),
            '74' => array(
                'value' => 'Great+Vibes',
                'hosted'=> 'google',
                'css' => "'Great Vibes', cursive",
                'label' => esc_html__( 'Great Vibes','hook')
            ),
            '30' => array(
                'value' => 'helvetica',
                'hosted'=> 'self',
                'css' => "Helvetica, Arial, sans-serif",
                'label' => esc_html__( 'Helvetica','hook')
            ),
            '98' => array(
                'value' => 'Hind:400,600,700',
                'hosted'=> 'google',
                'css' => "'Hind', sans-serif",
                'label' => esc_html__( 'Hind','hook')
            ),
            '91' => array(
                'value' => 'Inconsolata:400,700',
                'hosted'=> 'google',
                'css' => "'Inconsolata', serif",
                'label' => esc_html__( 'Inconsolata','hook')
            ),
            '86' => array(
                'value' => 'Imprima',
                'hosted'=> 'google',
                'css' => "'Imprima', sans-serif",
                'label' => esc_html__( 'Imprima','hook')
            ),
            '99' => array(
                'value' => 'Istok+Web:400,400i,700,700i',
                'hosted'=> 'google',
                'css' => "'Istok Web', sans-serif",
                'label' => esc_html__( 'Istok','hook')
            ),
            '52' => array(
                'value' => 'Josefin+Sans:300,400,600,700,400italic',
                'hosted'=> 'google',
                'css' => "'Josefin Sans', sans-serif",
                'label' => esc_html__( 'Josefin Sans','hook')
            ),
            '63' => array(
                'value' => 'Josefin+Slab:400,700,400italic,700italic',
                'hosted'=> 'google',
                'css' => "'Josefin Slab', serif",
                'label' => esc_html__( 'Josefin Slab','hook')
            ),
            '92' => array(
                'value' => 'Libre+Baskerville:400,400italic',
                'hosted'=> 'google',
                'css' => "'Libre Baskerville', serif",
                'label' => esc_html__('Libre Baskerville','hook')
            ),
            '104' => array(
                'value' => 'Loved+by+the+King',
                'hosted'=> 'google',
                'css' => "'Loved by the King', cursive",
                'label' => esc_html__('Loved by the King','hook')
            ),
            '26' => array(
                'value' => 'Lato:100,300,400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Lato', sans-serif",
                'label' => esc_html__( 'Lato','hook')
            ),
            '59' => array(
                'value' => 'Lekton:400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Lekton', sans-serif",
                'label' => esc_html__( 'Lekton','hook')
            ),
            '32' => array(
                'value' => 'Lora:400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Lora', serif",
                'label' => esc_html__( 'Lora','hook')
            ),
            '82' => array(
                'value' => 'Love+Ya+Like+A+Sister',
                'hosted'=> 'google',
                'css' => "'Love Ya Like A Sister', cursive",
                'label' => esc_html__( 'Love Ya Like A Sister','hook')
            ),
            '46' => array(
                'value' => 'Maven+Pro:400,700',
                'hosted'=> 'google',
                'css' => "'Maven Pro', sans-serif",
                'label' => esc_html__( 'Maven Pro','hook')
            ),
            '54' => array(
                'value' => 'Merriweather:400,300,700,400italic,300italic',
                'hosted'=> 'google',
                'css' => "'Merriweather', serif",
                'label' => esc_html__( 'Merriweather','hook')
            ),
            '67' => array(
                'value' => 'Merriweather+Sans:400italic,400,700',
                'hosted'=> 'google',
                'css' => "'Merriweather Sans', sans-serif",
                'label' => esc_html__( 'Merriweather Sans','hook')
            ),
            '97' => array(
                'value' => 'Montaga',
                'hosted'=> 'google',
                'css' => "'Montaga', serif",
                'label' => esc_html__( 'Montaga', 'hook' )
            ),
            '31' => array(
                'value' => 'Montserrat:300,300i,400,400i,700,700i',
                'hosted'=> 'google',
                'css' => "'Montserrat', sans-serif",
                'label' => esc_html__( 'Montserrat','hook')
            ),
            '37' => array(
                'value' => 'Muli:400,400italic',
                'hosted'=> 'google',
                'css' => "'Muli', sans-serif",
                'label' => esc_html__( 'Muli','hook')
            ),
            '68' => array(
                'value' => 'Neuton:300,400,700,400italic',
                'hosted'=> 'google',
                'css' => "'Neuton', serif",
                'label' => esc_html__( 'Neuton','hook')
            ),
            '50' => array(
                'value' => 'News+Cycle:400,700',
                'hosted'=> 'google',
                'css' => "'News Cycle', sans-serif",
                'label' => esc_html__( 'News Cycle','hook')
            ),
            '71' => array(
                'value' => 'Niconne',
                'hosted'=> 'google',
                'css' => "'Niconne', cursive",
                'label' => esc_html__( 'Niconne','hook')
            ),
            '60' => array(
                'value' => 'Nobile:400,400italic,700,700italic',
                'hosted'=> 'google',
                'css' => "'Nobile', sans-serif",
                'label' => esc_html__( 'Nobile','hook')
            ),
            '0' => array(
                'value' => 'Open+Sans:300italic,400italic,400,300,700,600,800',
                'css' => 'Open Sans',
                'hosted'=> 'google',
                'label' => esc_html__( 'Open Sans','hook')
            ),
            '47' => array(
                'value' => 'Open+Sans+Condensed:300,700,300italic',
                'hosted'=> 'google',
                'css' => "'Open Sans Condensed', sans-serif",
                'label' => esc_html__( 'Open Sans Condensed','hook')
            ),
            '45' => array(
                'value' => 'Orienta',
                'hosted'=> 'google',
                'css' => "'Orienta', sans-serif",
                'label' => esc_html__( 'Orienta','hook')
            ),
            '13' => array(
                'value' => 'Oswald:700,400,300',
                'hosted'=> 'google',
                'css' => "'Oswald', sans-serif",
                'label' => esc_html__( 'Oswald','hook')
            ),
            '36' => array(
                'value' => 'Overlock+SC',
                'hosted'=> 'google',
                'css' => "'Overlock SC', cursive",
                'label' => esc_html__( 'Overlock SC','hook')
            ),
            '100' => array(
                'value' => 'Over+the+Rainbow',
                'hosted'=> 'google',
                'css' => "'Over the Rainbow', cursive",
                'label' => esc_html__( 'Over The Rainbow','hook')
            ),
            '64' => array(
                'value' => 'Oxygen:300,400,700',
                'hosted'=> 'google',
                'css' => "'Oxygen', sans-serif",
                'label' => esc_html__( 'Oxygen','hook')
            ),
            '33' => array(
                'value' => 'Oxygen+Mono',
                'hosted'=> 'google',
                'css' => "'Oxygen Mono', sans-serif",
                'label' => esc_html__( 'Oxygen Mono','hook')
            ),
            '75' => array(
                'value' => 'Pacifico',
                'hosted'=> 'google',
                'css' => "'Pacifico', cursive",
                'label' => esc_html__( 'Pacifico','hook')
            ),
            '41' => array(
                'value' => 'Patua+One',
                'hosted'=> 'google',
                'css' => "'Patua One', cursive",
                'label' => esc_html__( 'Patua One','hook')
            ),
            '76' => array(
                'value' => 'Playball',
                'hosted'=> 'google',
                'css' => "'Playball', cursive",
                'label' => esc_html__( 'Playball','hook')
            ),
            '94' => array(
                'value' => 'Playfair+Display',
                'hosted'=> 'google',
                'css' => "'Playfair Display', serif",
                'label' => esc_html__( 'Playfair Display','hook')
            ),
            '39' => array(
                'value' => 'Pompiere',
                'hosted'=> 'google',
                'css' => "'Pompiere', cursive",
                'label' => esc_html__( 'Pompiere','hook')
            ),
            '108' => array(
                'value' => 'Poppins:300,400,400i,500,600,700',
                'hosted'=> 'google',
                'css' => "'Poppins', sans-serif;",
                'label' => esc_html__( 'Poppins','hook')
            ),
            '2' => array(
                'value' => 'PT+Sans:400,700,400italic,700italic',
                'hosted'=> 'google',
                'css' => "'PT Sans', sans-serif",
                'label' => esc_html__( 'PT Sans','hook')
            ),
            '87' => array(
                'value' => 'PT+Serif:400,700',
                'hosted'=> 'google',
                'css' => "'PT Serif', serif",
                'label' => esc_html__( 'PT Serif','hook')
            ),
            '28' => array(
                'value' => 'PT+Sans+Narrow',
                'hosted'=> 'google',
                'css' => "'PT Sans Narrow', sans-serif",
                'label' => esc_html__( 'PT Sans Narrow','hook')
            ),
            '23' => array(
                'value' => 'Questrial',
                'hosted'=> 'google',
                'css' => "'Questrial', sans-serif",
                'label' => esc_html__( 'Questrial','hook')
            ),
            '35' => array(
                'value' => 'Quicksand:400,700',
                'hosted'=> 'google',
                'css' => "'Quicksand', sans-serif",
                'label' => esc_html__( 'Quicksand','hook')
            ),
            '34' => array(
                'value' => 'Raleway:300,400,600,700,800,900',
                'hosted'=> 'google',
                'css' => "'Raleway', sans-serif",
                'label' => esc_html__( 'Raleway','hook')
            ),
            '57' => array(
                'value' => 'Rambla:400,700,400italic,700italic',
                'hosted'=> 'google',
                'css' => "'Rambla', sans-serif",
                'label' => esc_html__( 'Rambla','hook')
            ),
            '62' => array(
                'value' => 'Roboto:400,700,400italic,700italic',
                'hosted'=> 'google',
                'css' => "'Roboto', sans-serif",
                'label' => esc_html__( 'Roboto','hook')
            ),
            '55' => array(
                'value' => 'Roboto+Condensed:400italic,700italic,400,700',
                'hosted'=> 'google',
                'css' => "'Roboto Condensed', sans-serif",
                'label' => esc_html__( 'Roboto Condensed','hook')
            ),
            '66' => array(
                'value' => 'Roboto+Slab:100,300,400,700',
                'hosted'=> 'google',
                'css' => "'Roboto Slab', serif",
                'label' => esc_html__( 'Roboto Slab','hook')
            ),
            '53' => array(
                'value' => 'Rokkitt:400,700',
                'hosted'=> 'google',
                'css' => "'Rokkitt', serif",
                'label' => esc_html__( 'Rokkit','hook')
            ),
            '12' => array(
                'value' => 'Ruda:400,700,900',
                'hosted'=> 'google',
                'css' => "'Ruda', sans-serif",
                'label' => esc_html__( 'Ruda','hook')
            ),
            '102' => array(
                'value' => 'Ruthie',
                'hosted'=> 'google',
                'css' => "'Ruthie', cursive",
                'label' => esc_html__( 'Ruthie','hook')
            ),
            '38' => array(
                'value' => 'Rye',
                'hosted'=> 'google',
                'css' => "'Rye', cursive",
                'label' => esc_html__( 'Rye','hook')
            ),
            '58' => array(
                'value' => 'Sanchez:400italic,400',
                'hosted'=> 'google',
                'css' => "'Sanchez', serif",
                'label' => esc_html__( 'Sanchez','hook')
            ),
            '77' => array(
                'value' => 'Satisfy',
                'hosted'=> 'google',
                'css' => "'Satisfy', cursive",
                'label' => esc_html__( 'Satisfy','hook')
            ),
            '44' => array(
                'value' => 'Share+Tech',
                'hosted'=> 'google',
                'css' => "'Share Tech', sans-serif",
                'label' => esc_html__( 'Share Tech','hook')
            ),
            '49' => array(
                'value' => 'Source+Sans+Pro:Source+Sans+Pro:300,400,400i,600,700',
                'hosted'=> 'google',
                'css' => "'Source Sans Pro', sans-serif",
                'label' => esc_html__( 'Source Sans Pro','hook')
            ),
            '80' => array(
                'value' => 'Special+Elite',
                'hosted'=> 'google',
                'css' => "'Special Elite', cursive",
                'label' => esc_html__( 'Special Elite','hook')
            ),
            '40' => array(
                'value' => 'Titillium+Web:400,400italic,600,700,700italic',
                'hosted'=> 'google',
                'css' => "'Titillium Web', sans-serif",
                'label' => esc_html__( 'Titillium Web','hook')
            ),
            '6' => array(
                'value' => 'Ubuntu:400,500,700,400italic,500italic,700italic',
                'hosted'=> 'google',
                'css' => "'Ubuntu', sans-serif",
                'label' => esc_html__( 'Ubuntu','hook')
            ),
            '90' => array(
                'value' => 'Unifraktur:700',
                'hosted'=> 'google',
                'css' => "'UnifrakturCook', cursive",
                'label' => esc_html__( 'Unifraktur','hook')
            ),
            '27' => array(
                'value' => 'Vollkorn:400italic,400',
                'hosted'=> 'google',
                'css' => "'Vollkorn', serif",
                'label' => esc_html__( 'Vollkorn','hook')
            ),
            '106' => array(
                'value' => 'Volkhov:400,400i,700',
                'hosted'=> 'google',
                'css' => "'Volkhov', serif;",
                'label' => esc_html__( 'Volkhov','hook')
            ),
            '107' => array(
                'value' => 'Work+Sans:300,400,500,600,700',
                'hosted'=> 'google',
                'css' => "'Work Sans', sans-serif;",
                'label' => esc_html__( 'Work Sans','hook')
            ),
            '3' => array(
                'value' => 'Yanone+Kaffeesatz:400,700',
                'hosted'=> 'google',
                'css' => "'Yanone Kaffeesatz', sans-serif",
                'label' => esc_html__( 'Yanone Kaffeesatz','hook')
            ),
            '85' => array(
                'value' => 'Yellowtail',
                'hosted'=> 'google',
                'css' => "'Yellowtail', cursive",
                'label' => esc_html__( 'Yellowtail','hook')
            ),
            '78' => array(
                'value' => 'Yesteryear',
                'hosted'=> 'google',
                'css' => "'Yesteryear', cursive",
                'label' => esc_html__( 'Yesteryear','hook')
            ),
        );
        return $prk_select_font_options;
    }
}

//LOAD THEME OPTIONS
if(!class_exists('ReduxFramework')){
    include_once PLUGIN_PATH.'/inc/modules/options/framework.php';
}
add_action( 'plugins_loaded', 'hook_register_options' );
function hook_register_options () {
    include_once PLUGIN_PATH.'/inc/modules/options/theme/options.php';
}

include_once( ABSPATH.'wp-admin/includes/plugin.php' );
if (is_plugin_active('js_composer/js_composer.php')) {
    include_once PLUGIN_PATH.'/inc/builder-light.php';
}

if (!function_exists('hook_attachment_id')) {
    function hook_attachment_id( $url ) {
        //DEFAULT RETURN
        $attachment_id = "EMPTY";
        $dir = wp_upload_dir();
        if ( false !== strpos( $url, $dir['baseurl'].'/' ) ) {
            $file = basename( $url );
            $query_args = array(
                'post_type'   => 'attachment',
                'post_status' => 'inherit',
                'fields'      => 'ids',
                'meta_query'  => array(
                    array(
                        'value'   => $file,
                        'compare' => 'LIKE',
                        'key'     => '_wp_attachment_metadata',
                    ),
                )
            );
            $query = new WP_Query( $query_args );
            if ( $query->have_posts() ) {
                foreach ( $query->posts as $post_id ) {
                    $meta = wp_get_attachment_metadata( $post_id );
                    $original_file       = basename( $meta['file'] );
                    $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
                    if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                        $attachment_id = $post_id;
                        break;
                    }
                }
            }
        }
        return $attachment_id;
    }
}

if (!function_exists('hook_alt_tag')) {
    function hook_alt_tag($id_flag,$img_path,$force_filename=false) {
        if ($id_flag==false) {
            $img_id=hook_attachment_id($img_path);
            if ($img_id!="EMPTY") {
                $alt_text=get_post_meta($img_id, '_wp_attachment_image_alt', true);
                //Output title if Alternative Text is empty
                if ($alt_text=="") {
                    $alt_text=get_the_title($img_id);
                }
                return $alt_text;
            }
            else {
                return __("Image Not Found On Media Library",'hook');
            }
        }
        else {
            $alt_text=get_post_meta($img_path, '_wp_attachment_image_alt', true);
            if ($alt_text=="" && $force_filename) {
                $alt_text=pathinfo(basename(get_attached_file($img_path)),PATHINFO_FILENAME);
                //$filename_only = ; // Just the file name
            }
            return $alt_text;
        }
    }
}
if (!function_exists('hook_img_caption')) {
    function hook_img_caption($id_image) {
        $prk_hook_options=hook_options();
        $hook_content="";
        if (get_the_title($id_image)!="") {
            $hook_content.='<span class="hook_img_title">'.get_the_title($id_image).'</span>';
            $thumb_img=get_post($id_image);
            if ($thumb_img->post_content!="") {
                $hook_content.=' - <span class="hook_img_desc">'.$thumb_img->post_content.'</span>';
            }
        }
        else {
            $thumb_img=get_post($id_image);
            if ($thumb_img->post_content!="") {
                $hook_content.='<span class="hook_img_desc">'.$thumb_img->post_content.'</span>';
            }
        }
        if (!isset($prk_hook_options['port_with_description'])) {
            $prk_hook_options['port_with_description']="";
        }
        if ($prk_hook_options['port_with_description']==1 && $hook_content!="") {
            return '<div class="hook_img_caption">'.$hook_content.'</div>';
        }
        else {
            return '';
        }
    }
}

if (!function_exists('hook_retiner')) {
    function hook_retiner($test_flag) {
        global $hook_retina_device;
        if ($test_flag==true) {
            $hook_detect = new Mobile_Detect;
            if ($hook_detect->isMobile()) {
                $hook_retina_device=true;
            }
            else {
                $hook_retina_device=false;
            }
        }
        return $hook_retina_device;
    }
}

//ENABLE SHORTCODES ON SIDEBARS
add_filter('widget_text', 'do_shortcode');

//REDUX SPECIAL FUNCTIONS
function hook_outside_register_ace() {
    wp_dequeue_script( 'wpb_ace' );
    wp_deregister_script( 'wpb_ace' );
    //wp_dequeue_script( 'webfont' );//CHINA GOOGLE ISSUE
}
function hook_outside_register_select() {
    wp_deregister_script( 'jquerySelect2' );
    wp_dequeue_script('jquerySelect2');
    wp_dequeue_style('jquerySelect2Style');
}

//WPBAKERY PAGE BUILDER OVERRIDES
//ENQUEUE THE THEME TWEAKED JS AND CSS FILES
function hook_vc_scripts() {
    if ( defined('WPB_VC_VERSION')) {

        //FRONTEND EDITOR SCRIPTS - LOAD TO AVOID ERRORS
        if (!isset($_GET['vc_post_id'])) {
            wp_deregister_style('js_composer_custom_css');
            wp_deregister_style('js_composer_front');
            wp_deregister_style('flexslider');
            wp_deregister_style('prettyphoto');
            wp_deregister_script('nivo-slider');
            wp_deregister_script('isotope');
            wp_deregister_script('waypoints');
            wp_deregister_script('vc_accordion_script');
            wp_deregister_script('vc_tabs_script');
            wp_deregister_script('vc_tta_autoplay_script');
            wp_deregister_script('wpb_composer_front_js');
            wp_deregister_script('jquery_ui_tabs_rotate');
        }
        else {
            //Vc601
            //CHECK IF HOOK THEME IS ACTIVE
            if (function_exists('wp_get_theme'))
                $active_theme = wp_get_theme(get_template());
            else {
                $active_theme->name="";
                $active_theme->Version="1";
            }

            wp_deregister_script('waypoints');
            wp_enqueue_style('hook_vc_frontend_style', PLUGIN_URL . '/css/vc.css', false,$active_theme->Version);
        }
    }
}
add_action('wp_enqueue_scripts', 'hook_vc_scripts', 199);

//CHECK IF HOOK THEME IS ACTIVE
if (function_exists('wp_get_theme'))
    $active_theme = wp_get_theme(get_template());
else
{
    $active_theme->name="";
    $active_theme->Version="1";
}
if ('Hook' == $active_theme->name || 'Hook' == $active_theme->parent_theme) {

}
else {
    //THEME IS NOT ACTIVE. LET'S ADD SOME ELEMENTS
    add_action('admin_enqueue_scripts', 'hook_framework_admin_scripts');
}

//ADD CUSTOM SCRIPTS FOR THE BACKEND
function hook_framework_admin_scripts() {
    global $active_theme;
    wp_register_style( 'hook_framework_admin_css', PLUGIN_URL.'css/admin.css',false,$active_theme->Version );
    wp_enqueue_style('hook_framework_admin_css');
}

//VALIDATE FUNCTIONS
function hook_widget_scripts($hook) {
    if( 'appearance_page_theme_activation_options' != $hook ) {
        return;
    }
    $active_theme = wp_get_theme();
    wp_enqueue_script( 'pirenko-widget-script', plugins_url( 'js/main.js', __FILE__ ), array('jquery'),$active_theme->Version );
    wp_localize_script( 'pirenko-widget-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'admin_enqueue_scripts', 'hook_widget_scripts' );

if (!function_exists('hook_validate_key')) {
    function hook_validate_key() {
        if (get_option('hook_prk_one')=="") {
            add_option( 'hook_prk_one', 'off', '', 'yes' );
        }
        if (get_option('hook_prk_one')=='off') {
            return false;
        }
        else {
            return true;
        }
    }
}


if (!function_exists('hook_output')) {
    function hook_output() {
        return;
    }
}


//SEND EMAIL FUNCTION
add_action('wp_ajax_mail_before_submit', 'hook_email_before_submit');
add_action('wp_ajax_nopriv_mail_before_submit', 'hook_email_before_submit');
add_action('init', 'hook_email_function');
function hook_email_function() {
    if (!function_exists('hook_email_before_submit')) {
        function hook_email_before_submit() {
            if (isset($_POST['action']) && $_POST['action']=="mail_before_submit") {
                check_ajax_referer('ajax-nonce');
                $params = array();
                parse_str($_POST['email_wrap'], $params);
                $name = $params['c_name'];
                $mail = $params['c_email'];
                $admin_mail = $params['rec_email'];
                $msg = $params['c_message'];
                $subject = $params['full_subject'];

                $headers='MIME-Version: 1.0'."\r\n";
                $headers.='Content-type: text/html; charset=utf-8'."\r\n";
                $headers.='From: '.$name.' <'.$mail.'>' ."\r\n";
                $headers.='Reply-To: '.$mail."\r\n";
                $headers.='X-Mailer: PHP/'.phpversion();

                $message="You've received a new message. <br><br>";
                $message.="Name: ".$name."<br>";
                $message.="Mail: ".$mail."<br>";
                $message.="Subject: ".$params['c_subject']."<br>";
                $message.="Message: ".$msg."<br>";

                $mail_result = wp_mail($admin_mail,$subject,$message,$headers);
                if($mail_result) {
                    echo "sent";
                }
                else {
                    echo "Email failure. Please try again.";
                }
            }
        }
    }
}

//BETTER LOADER FOR CF7 
add_filter('wpcf7_ajax_loader', 'hook_wpcf7_ajax_loader');
function hook_wpcf7_ajax_loader () {
    return  get_template_directory_uri().'/images/ajax-loader.gif';
}
//BETTER QTRANSLATE SUPPORT
if (is_plugin_active('qtranslate/qtranslate.php')) {
    function hook_qtranslate_edit_taxonomies() {
        $hook_query_args=array(
            'public' => true ,
            '_builtin' => false
        );
        $hook_output='object';
        $operator='and';

        $taxonomies=get_taxonomies($hook_query_args,$hook_output,$operator);

        if  ($taxonomies) {
            foreach ($taxonomies  as $taxonomy ) {
                add_action( $taxonomy->name.'_add_form', 'qtrans_modifyTermFormFor');
                add_action( $taxonomy->name.'_edit_form', 'qtrans_modifyTermFormFor');

            }
        }
    }
    add_action('admin_init', 'hook_qtranslate_edit_taxonomies');
}

//JETPACK RETINA SCRIPT REMOVE
function hook_dequeue_devicepx() {
    wp_dequeue_script( 'devicepx' );
}
add_action('wp_enqueue_scripts', 'hook_dequeue_devicepx', 20);

//ALLOW SVG UPLOAD
function hook_cc_mime_types($mimes) {
    $mimes['svg']='image/svg+xml';
    $mimes['ico']='image/x-icon';
    return $mimes;
}
add_filter('upload_mimes', 'hook_cc_mime_types');

add_action('init', 'hook_functions_register',5);
function hook_functions_register() {
    if (!function_exists('hook_change_links')) {
        function hook_change_links($link) {
            return $link;
        }
    }
    if (!function_exists('hook_related_portfolios')) {
        function hook_related_portfolios($related_filter) {
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $hook_translated=hook_translations();
            if ($prk_hook_options['related_port']=="0") {
                return;
            }
            $projects_number=4;
            $hook_output="";
            $hook_terms=get_the_terms ($related_filter, 'pirenko_skills');
            $hook_skills_yo="";
            if (!empty($hook_terms)) {
                foreach ($hook_terms as $hook_term) {
                    $hook_skills_links[]=$hook_term->slug;
                }
                $hook_skills_yo=join(", ", $hook_skills_links);
            }
            if ($prk_hook_options['related_info']!="folio_always_title_and_skills" && $prk_hook_options['related_info']!="folio_always_title_only") {
                $main_classes=$prk_hook_options['thumbs_text_position']." ";
            }
            else {
                $main_classes="";
            }
            $hook_query=new WP_Query();
            $args=array(
                'post_type' => 'pirenko_portfolios',
                'pirenko_skills'=>$hook_skills_yo,
                'post__not_in' => array($related_filter),
                'posts_per_page'=> 9,
                'orderby' => 'rand'
            );
            $hook_query->query($args);
            if ($hook_query->have_posts()) {
                $hook_forced_w=800;
                $hook_forced_h=800;
                $hook_output.='<div id="hook_related_projects" class="hook_center_align header_font columnize-'.$projects_number.'">';
                $hook_output.='<h4 class="zero_color prk_heavier_600 big">';
                $hook_output.=$hook_translated['related_prj_text'];
                $hook_output.='</h4>';
                $hook_output.='<div class="small_headings_color smaller_font">';
                $hook_output.=$hook_translated['related_prj_teaser_text'];
                $hook_output.='</div>';
                $hook_output.='<div id="hook_related_grid" class="'.$main_classes.$prk_hook_options['related_info'].'">';
                $i=0;
                while ($hook_query->have_posts()) : $hook_query->the_post();
                    $hook_skills_links=array();
                    $skills_names=array();
                    $skills_output="";
                    if ($prk_hook_options['related_info']=="folio_title_and_skills" || $prk_hook_options['related_info']=="folio_always_title_and_skills hk_ins" || $prk_hook_options['related_info']=="folio_always_title_and_skills")
                        $hook_terms=get_the_terms (get_the_ID(), 'pirenko_skills');
                    if (!empty($hook_terms)) {
                        foreach ($hook_terms as $hook_term) {
                            $hook_skills_links[]=$hook_term->slug;
                            $skills_names[]=$hook_term->name;
                        }
                        $skills_output=join(", ", $skills_names);
                    }
                    if (has_post_thumbnail() && $i<$projects_number) {
                        $i++;
                        if (get_field('featured_color')!="") {
                            $hook_featured_color=get_field('featured_color');
                            $hook_featured_class="featured_color ";
                        }
                        else
                        {
                            $hook_featured_color="default";
                            $hook_featured_class="";
                        }
                        $hook_output.='<div id="related_post-'.get_the_ID().'" class="'.$hook_featured_class.'portfolio_entry_li" data-color="'.esc_attr($hook_featured_color).'">';
                        $hook_output.='<a href="'.get_permalink().'">';
                        $hook_output.='<div class="grid_image_wrapper">';
                        $hook_output.='<div class="centerized_father">';
                        $hook_output.='<div class="centerized_child">';
                        $hook_output.='<div class="grid_single_title hook_animated">';
                        $hook_output.='<div class="prk_ttl hook_folio_uppercased">';
                        if (get_field('custom_logo')!="") {
                            $hook_in_image=wp_get_attachment_image_src(get_field('custom_logo'),'full');
                            $hook_vt_image=vt_resize('', $hook_in_image[0] , $hook_forced_w, '', false , true);
                            $hook_output.='<img class="hook_folio_th" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,get_field('custom_logo')).'" />';
                        }
                        else {
                            $hook_output.='<h4 class="header_font body_bk_color big">'.the_title("","",false).'</h4>';
                        }
                        if ($skills_output!="") {
                            $hook_output.='<div class="hook_liner"></div>';
                            $hook_output.='<div class="inner_skills body_bk_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                            if (get_field('thumb_skills')!="") {
                                $hook_output.=get_field('thumb_skills');
                            }
                            else {
                                $hook_output.=$skills_output;
                            }
                            $hook_output.='</div>';
                        }
                        $hook_output.='</div>';
                        $hook_output.='</div>';
                        $hook_output.='</div>';
                        $hook_output.='</div>';
                        $hook_output.='<div class="grid_block_wr"><div class="grid_colored_block"></div></div>';
                        $hook_vt_image=vt_resize(get_post_thumbnail_id(),'',$hook_forced_w,$hook_forced_h,true,$hook_retina_device);
                        $hook_output.='<img src="#" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.get_the_ID().'" class="custom-img grid_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id()).'" data-featured="no" />';
                        if (get_field('video_thumb')!="") {
                            $hook_output.='<video class="hook_video-bg" autoplay="autoplay" preload="auto" muted="" loop="">';
                            $hook_output.='<source src="'.get_field('video_thumb').'" type="video/mp4">';
                            $hook_output.='<source src="'.get_field('video_thumb_webm').'" type="video/webm">';
                            $hook_output.='</video>';
                        }
                        $hook_output.=' </div>';
                        $hook_output.='</a>';
                        $hook_output.='</div>';
                    }
                endwhile;
                $hook_output.='<div class="columns hide_now"></div></div>';
                $hook_output.='</div>';
            }
            wp_reset_postdata();
            return $hook_output;
        }
    }
    function hook_get_parent_portfolio($inner_id) {
        $hook_blog_default="";
        $hook_blog_link="";
        $hook_blog_link_timeline="";
        $hook_arra=get_the_terms( $inner_id,'pirenko_skills' );
        $hook_cats_arr=array("");
        if($hook_arra) {
            foreach($hook_arra as $hook_s_cat) {
                array_push($hook_cats_arr,$hook_s_cat->slug);
            }
        }
        $hook_pages_blog=get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'page-portfolio.php',
            'hierarchical' => 0
        ));
        foreach($hook_pages_blog as $hook_single_blog) {
            $hook_blog_default=$hook_single_blog->ID;
            if (get_field('cat_filter',$hook_single_blog->ID)!="") {
                $hook_filter=get_field('cat_filter',$hook_single_blog->ID);
                foreach ($hook_filter as $hook_child) {
                    if (in_array($hook_child->slug, $hook_cats_arr)) {
                        $hook_blog_link=$hook_single_blog->ID;
                    }
                }
            }
        }
        wp_reset_postdata();
        if ($hook_blog_link!="")
        {
            return $hook_blog_link;
        }
        else
        {
            if ($hook_blog_default!="")
            {
                return $hook_blog_default;
            }
            else
            {
                return get_option('page_on_front');
            }
        }
    }
    if (!function_exists('hook_folio_nav')) {
        function hook_folio_nav($inner_id,$hook_featured_color) {
            $prk_hook_options=hook_options();
            $hook_translated=hook_translations();
            $hook_retina_device=hook_retiner(false);
            $hook_extra_class="";
            if ($prk_hook_options['related_port']=="1") {
                $hook_extra_class=' class="with_rel"';
            }
            if ($prk_hook_options['port_nav_logic']=="0") {
                $same_skill=false;
            }
            else {
                $same_skill=true;
            }
            ?>
            <div id="single_meta_header"<?php echo esc_attr($hook_extra_class); ?>>
                <?php
                if ($prk_hook_options['persistent_folio']==0) {
                    ?>
                    <div id="hook_to_parent" class="header_font zero_color fade_anchor hook_folio_uppercased prk_heavier_600">
                        <a href="<?php if (get_field('parent_page')!=""){echo esc_url(get_field('parent_page'));}else {echo esc_url(get_page_link(hook_get_parent_portfolio($inner_id)));} ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>" class="hook_colored_link_bk hook_bk_site">
                            <i class="mdi-chevron-up"></i>
                            <?php echo '<h5 class="small">'.$hook_translated['to_portfolio'].'</h5>'; ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="hook_navigation_singles header_font body_bk_color">
                    <?php
                    $p_post_id=next_post_link_plus(array(
                            'order_by' => 'menu_order',
                            'in_same_cat' => $same_skill,
                            'loop' => true,
                            'return' => 'id')
                    );
                    $hook_featured_class=$hook_featured_color="";
                    if (get_field('featured_color',$p_post_id)!="" && $prk_hook_options['use_custom_colors']=="1") {
                        $hook_featured_color=' data-color="'.get_field('featured_color',$p_post_id).'"';
                        $hook_featured_class="featured_color color_trigger ";
                    }
                    $hook_image=wp_get_attachment_image_src(get_post_thumbnail_id($p_post_id),'');
                    $hook_vt_image=vt_resize('',$hook_image[0],980,490,true,$hook_retina_device);
                    $video_code="";
                    if (get_field('video_thumb',$p_post_id)!="") {
                        $video_code.='<video class="hook_video-bg" autoplay="autoplay" preload="auto" muted="" loop="">';
                        $video_code.='<source src="'.get_field('video_thumb',$p_post_id).'" type="video/mp4">';
                        $video_code.='<source src="'.get_field('video_thumb_webm',$p_post_id).'" type="video/webm">';
                        $video_code.='</video>';
                    }
                    //BETTER GIF FILES SUPPORT
                    $hook_type=wp_check_filetype($hook_vt_image['url']);
                    if ($hook_type['ext']=="gif") {
                        $video_code.='<img class="hook_video-bg" src="'.esc_url($hook_vt_image['url']).'">';
                        $hook_vt_image=vt_resize('',get_template_directory_uri().'/images/instaholder.png',980,490,true,$hook_retina_device);
                    }
                    next_post_link_plus(array(
                        'order_by' => 'menu_order',
                        'in_same_cat' => $same_skill,
                        'loop' => true,
                        'format' => '%link',
                        'before' => '<div class="'.$hook_featured_class.'prk_prev_folio prk_lf"'.$hook_featured_color.'>',
                        'after' => '</div>',
                        'link' => '<div class="hook_rel_folio"><div class="grid_colored_block"></div><div class="grid_image_wrapper"><img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" />'.$video_code.'</div><div class="bf_icon_folio prk_heavier_600"><i class="prk_lf mdi-chevron-left"></i><div class="prk_lf"><div class="hook_sub">'.$hook_translated['prj_prev_text'].'</div><div class="special_heading prk_upperc">%title</div></div></div></div>'
                    ) );
                    ?>
                    <?php
                    $p_post_id=previous_post_link_plus(array(
                            'order_by' => 'menu_order',
                            'in_same_cat' => $same_skill,
                            'loop' => true,
                            'return' => 'id')
                    );
                    $hook_featured_class=$hook_featured_color="";
                    if (get_field('featured_color',$p_post_id)!="" && $prk_hook_options['use_custom_colors']=="1") {
                        $hook_featured_color=' data-color="'.get_field('featured_color',$p_post_id).'"';
                        $hook_featured_class="featured_color color_trigger ";
                    }
                    $hook_image=wp_get_attachment_image_src(get_post_thumbnail_id($p_post_id),'');
                    $hook_vt_image=vt_resize( '', $hook_image[0] , 980, 490, true , $hook_retina_device );
                    $video_code="";
                    if (get_field('video_thumb',$p_post_id)!="") {
                        $video_code.='<video class="hook_video-bg" autoplay="autoplay" preload="auto" muted="" loop="">';
                        $video_code.='<source src="'.get_field('video_thumb',$p_post_id).'" type="video/mp4">';
                        $video_code.='<source src="'.get_field('video_thumb_webm',$p_post_id).'" type="video/webm">';
                        $video_code.='</video>';
                    }
                    //BETTER GIF FILES SUPPORT
                    $hook_type=wp_check_filetype($hook_vt_image['url']);
                    if ($hook_type['ext']=="gif") {
                        $video_code.='<img class="hook_video-bg" src="'.esc_url($hook_vt_image['url']).'">';
                        $hook_vt_image=vt_resize('',get_template_directory_uri().'/images/instaholder.png',980,490,true,$hook_retina_device);
                    }
                    previous_post_link_plus( array(
                        'order_by' => 'menu_order',
                        'in_same_cat' => $same_skill,
                        'loop' => true,
                        'format' => '%link',
                        'before' => '<div class="'.$hook_featured_class.'prk_next_folio prk_lf hook_right_align"'.$hook_featured_color.'>',
                        'after' => '</div>',
                        'link' => '<div class="hook_rel_folio"><div class="grid_colored_block"></div><div class="grid_image_wrapper"><img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" />'.$video_code.'</div><div class="bf_icon_folio prk_heavier_600"><i class="mdi-chevron-right prk_rf"></i><div class="hook_sub">'.$hook_translated['prj_next_text'].'</div><div class="special_heading prk_upperc">%title</div></div></div>'
                    ) );
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
        }
    }

    function hook_sticky_folio($inner_id,$inner_offset=0) {
        $prk_hook_options=hook_options();
        $hook_translated=hook_translations();
        if ($prk_hook_options['share_blog']=="1" && $prk_hook_options['persistent_folio']=="1") {
            ?>
            <div id="hook_sticky_menu" class="header_font prk_heavier_600 prk_bordered_bottom" data-offset="<?php echo esc_attr($inner_offset); ?>">
                <div id="hook_sticky_inner">
                    <div class="prk_lf">
                        <a id="hook_back_lnk" href="<?php if (get_field('parent_page')!=""){echo esc_url(get_field('parent_page'));}else {echo esc_url(get_page_link(hook_get_parent_portfolio($inner_id)));} ?>" class="hook_anchor"><i class="mdi-undo-variant"></i><?php echo esc_attr($hook_translated['to_portfolio']); ?></a>
                    </div>
                    <div class="prk_rf">
                        <?php
                        if (isset($prk_hook_options['share_blog_fb']) && $prk_hook_options['share_blog_fb']=="1") {
                            ?>
                            <div class="prk_sharrre_facebook" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                            </div>
                            <?php
                        }
                        if (isset($prk_hook_options['share_blog_pin']) && $prk_hook_options['share_blog_pin']=="1") {
                            if (has_post_thumbnail($inner_id)) {
                                $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($inner_id), 'single-post-thumbnail' );
                            }
                            else {
                                $hook_image[0]="";
                            }
                            ?>
                            <div class="prk_sharrre_pinterest" data-media="<?php echo esc_attr($hook_image[0]); ?>" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                            </div>
                            <?php
                        }
                        if (isset($prk_hook_options['share_blog_twt']) && $prk_hook_options['share_blog_twt']=="1") {
                            ?>
                            <div class="prk_sharrre_twitter" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                            </div>
                            <?php
                        }
                        if (isset($prk_hook_options['share_blog_goo']) && $prk_hook_options['share_blog_goo']=="1") {
                            ?>
                            <div class="prk_sharrre_google" data-url="<?php the_permalink(); ?>" data-text="<?php echo the_title(); ?>" data-title="share">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    function hook_member_nets ($hook_inner_id) {
        if (get_field('member_email')!="")
        {
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook_envelope-o">
                <a href="mailto:<?php echo get_field('member_email'); ?>" data-color="#FFFFFF">
                    <div class="prk_minimal_icon hook_fa-envelope-o"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_1')!="none")
        {
            if (get_field('member_social_1_link')!="")
                $in_link=get_field('member_social_1_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_1'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_1')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_2')!="none")
        {
            if (get_field('member_social_2_link')!="")
                $in_link=get_field('member_social_2_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_2'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_2')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_3')!="none")
        {
            if (get_field('member_social_3_link')!="")
                $in_link=get_field('member_social_3_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_3'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_3')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_4')!="none")
        {
            if (get_field('member_social_4_link')!="")
                $in_link=get_field('member_social_4_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_4'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_4')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_5')!="none")
        {
            if (get_field('member_social_5_link')!="")
                $in_link=get_field('member_social_5_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_5'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_5')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
        if (get_field('member_social_6')!="none")
        {
            if (get_field('member_social_6_link')!="")
                $in_link=get_field('member_social_6_link');
            else
                $in_link="";
            $in_link=hook_change_links($in_link);
            ?>
            <div class="social_img_wrp hook_socialink prk_bordered hook-<?php echo get_field('member_social_6'); ?>">
                <a href="<?php echo esc_url($in_link); ?>" target="_blank" data-color="#FFFFFF">
                    <div class="prk_minimal_icon <?php echo hook_social_icon(get_field('member_social_6')); ?>"></div>
                    <div class="bg_shifter"></div>
                </a>
            </div>
            <?php
        }
    }

    //EXTRA FIELDS FOR WORDPRESS USERS
    if (!function_exists('hook_contact_methods')) {
        function hook_contact_methods($profile_fields) {
            $profile_fields['prk_subheading']='Subheading text <span class="description">(optional)</span><br /><span class="description hook_author_help">Displayed under author name</span>';
            $profile_fields['prk_author_custom_avatar']='Custom avatar <span class="description">(optional)</span><br /><span class="description hook_author_help">Image full path</span>';
            $profile_fields['prk_author_custom_header']='Featured header for author archive page <span class="description">(optional)</span><br /><span class="description hook_author_help">Image full path</span>';
            $profile_fields['web']='Website link';
            $profile_fields['dribbble']='Dribbble link';
            $profile_fields['facebook']='Facebook link';
            $profile_fields['flickr']='Flickr link';
            $profile_fields['google_plus']='Google Plus link';
            $profile_fields['instagram']='Instagram link';
            $profile_fields['linkedin']='Linkedin link';
            $profile_fields['pinterest']='Pinterest link';
            $profile_fields['skype']='Skype link';
            $profile_fields['twitter']='Twitter link';
            $profile_fields['vimeo']='Vimeo link';
            $profile_fields['youtube']='Youtube link';
            return $profile_fields;
        }
    }
    add_filter('user_contactmethods', 'hook_contact_methods');

    if (!function_exists('hook_author_links')) {
        function hook_author_links() {
            if (get_the_author_meta('dribbble')!="" || get_the_author_meta('facebook')!="" || get_the_author_meta('flickr')!="" || get_the_author_meta('google_plus')!="" || get_the_author_meta('instagram')!="" || get_the_author_meta('linkedin')!="" || get_the_author_meta('pinterest')!="" || get_the_author_meta('skype')!="" || get_the_author_meta('twitter')!="" || get_the_author_meta('vimeo')!="" || get_the_author_meta('youtube')!="" || get_the_author_meta('web')!="") {
                $hook_output= '<div class="pirenko_social minimal">';
                $hook_output.= '<div class="pirenko_social_inner">';
                if (get_the_author_meta('web')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-book"><a href="'.get_the_author_meta('web').'" title="Website" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-globe"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('dribbble')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-dribbble"><a href="'.get_the_author_meta('dribbble').'" title="Dribbble" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-dribbble"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('facebook')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-facebook"><a href="'.get_the_author_meta('facebook').'" title="Facebook" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-facebook"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('flickr')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-flickr"><a href="'.get_the_author_meta('flickr').'" title="Flickr" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-flickr"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('google_plus')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-google_plus"><a href="'.get_the_author_meta('google_plus').'" title="Google Plus" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-google-plus"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('instagram')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-instagram"><a href="'.get_the_author_meta('instagram').'" title="Instagram" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-instagram"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('linkedin')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-linkedin"><a href="'.get_the_author_meta('linkedin').'" title="Linkedin" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-linkedin"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('pinterest')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-pinterest"><a href="'.get_the_author_meta('pinterest').'" title="Pinterest" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-pinterest"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('skype')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-skype"><a href="'.get_the_author_meta('skype').'" title="Skype" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook-skype hook_fa-skype"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('twitter')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-twitter"><a href="'.get_the_author_meta('twitter').'" title="Twitter" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-twitter"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('vimeo')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-vimeo"><a href="'.get_the_author_meta('vimeo').'" title="Vimeo" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-vimeo-square"></div><div class="bg_shifter"></div></a></div>';
                }
                if (get_the_author_meta('youtube')!="") {
                    $hook_output.= '<div class="social_img_wrp hook_socialink prk_bordered hook-youtube"><a href="'.get_the_author_meta('youtube').'" title="Youtube" target="_blank" data-color="#FFFFFF"><div class="prk_minimal_icon hook_fa-youtube"></div><div class="bg_shifter"></div></a></div>';
                }
                $hook_output.= '</div>';
                $hook_output.= '</div>';
                return $hook_output;
            }
            else {
                return;
            }
        }
    }
}

//AMP PLUGIN STUFF
//ADD CUSTOM TEMPLATE
if (!function_exists('hook_amp_set_custom_template')) {

    function hook_amp_set_custom_template( $file, $type, $post ) {
        if ( 'single' === $type ) {
            $file=dirname( __FILE__ ).'/templates-amp/single.php';
        }
        return $file;
    }
    add_filter( 'amp_post_template_file', 'hook_amp_set_custom_template', 10, 3 );
}

//ADD THEME LOGO
if (!function_exists('hook_logo_amp')) {
    function hook_logo_amp() {
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(true);
        $after_logo=false;
        $hook_output_logo='<div id="hook_logos_wrapper">';
        if ($hook_retina_device==true && isset($prk_hook_options['logo_collapsed_retina']) && $prk_hook_options['logo_collapsed_retina']['url']!="")  {
            $after_logo=true;
            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed_retina']['url'],2);
            $hook_output_logo.='<img src="'.$prk_hook_options['logo_collapsed_retina']['url'].'" alt="'.hook_alt_tag(false,$prk_hook_options['logo_collapsed_retina']['url']).'" data-width="'.ceil($prk_hook_options['logo_collapsed_retina']['width']/2).'" '.$hook_logo_dims.' />';
        }
        else {
            if (isset($prk_hook_options['logo_collapsed']) && $prk_hook_options['logo_collapsed']['url']!="") {
                $after_logo=true;
                $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed']['url'],1);
                $hook_output_logo.='<img src="'.$prk_hook_options['logo_collapsed']['url'] .'" data-width="'.$prk_hook_options['logo_collapsed']['width'].'" alt="'.hook_alt_tag(false,$prk_hook_options['logo_collapsed']['url']).'" '.$hook_logo_dims.' />';
            }
        }
        //FORCE AFTER SCROLL LOGO
        if ($after_logo==false) {
            if ($hook_retina_device==true && isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url']!="") {
                $hook_logo_dims=hook_dimensions($prk_hook_options['logo_retina']['url'],2);
                $hook_output_logo.='<img src="'.$prk_hook_options['logo_retina']['url'].'" alt="'.hook_alt_tag(false,$prk_hook_options['logo_retina']['url']).'" data-width="'.ceil($prk_hook_options['logo_retina']['width']/2).'" '.$hook_logo_dims.' />';
            }
            else
            {
                if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url']!="")
                {
                    $hook_logo_dims=hook_dimensions($prk_hook_options['logo']['url'],1);
                    $hook_output_logo.='<img src="'.$prk_hook_options['logo']['url'] .'" data-width="'.$prk_hook_options['logo']['width'].'" alt="'.hook_alt_tag(false,$prk_hook_options['logo']['url']).'" '.$hook_logo_dims.' />';
                }
            }
        }
        $hook_output_logo.='</div>';
        return $hook_output_logo;
    }
}

//ADD FEATURED IMAGE
if (!function_exists('hook_amp_add_featured_image')) {
    add_action( 'pre_amp_render_post', 'hook_amp_add_custom_actions' );
    function hook_amp_add_custom_actions() {
        add_filter( 'the_content', 'hook_amp_add_featured_image' );
    }
    function hook_amp_add_featured_image( $hook_content ) {
        if ( has_post_thumbnail() ) {
            $hook_image=sprintf( '<p class="hook-image">%s</p>', get_the_post_thumbnail() );
            $hook_content=$hook_image.$hook_content;
        }
        return $hook_content;
    }
}

//ADD CUSTOM CSS
if (!function_exists('hook_amp_my_css')) {
    function hook_amp_my_css( $amp_template ) {
        $prk_hook_options=$hook_options=hook_options();
        $prk_select_font_options=hook_fonts();
        foreach ( $prk_select_font_options as $option_body ) {
            if ($prk_hook_options['body_font'] == $option_body['value'])
            {
                $hook_options['body_font']=$option_body;
                break;
            }
        }
        $prk_font_options=get_option('prk_font_plugin_option');
        if ($prk_font_options!="") {
            foreach ($prk_font_options as $font) {
                if ($font['erased']=="false") {
                    if ($hook_options['body_font'] == $font['value'])
                    {
                        $hook_options['body_font']=$font;
                    }
                }
            }
        }
        $hook_css_build="";
        $hook_css_build.="body {font-family:".$hook_options['body_font']['css'].";}";
        $hook_css_build.="body,.amp-wp-content {color:".$hook_options['inactive_color'].";}";
        $hook_css_build.=".amp-wp-title {color:".$hook_options['bd_headings_color'].";}";
        $hook_css_build.=".amp-wp-meta, .amp-wp-meta a {color:".$hook_options['bd_smallers_color'].";}";
        $hook_css_build.="nav.amp-wp-title-bar a {line-height:60px;}";
        $hook_css_build.="nav.amp-wp-title-bar div {line-height:60px;}";
        $hook_css_build.="nav.amp-wp-title-bar {background-color: ".$hook_options['background_color_menu_bar_after'].";padding:0px 16px;height:60px;position:relative;}";
        $hook_css_build.="#hook_logos_wrapper,.mobile-menu-ul,.mobile-menu-ul li {float:left;}";
        $hook_css_build.="#hook_logos_wrapper {top:50%;position:absolute;-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-webkit-transform:translateY(-50%);transform:translateY(-50%);line-height:0px;}";
        $hook_css_build.=".mobile-menu-ul li {padding:0px 4px;}";
        $hook_css_build.=".mobile-menu-ul {float:right;list-style:none;}";
        $hook_css_build.=".mobile-menu-ul .sub-menu {display:none;}";
        echo hook_output().$hook_css_build;
    }
    add_action( 'amp_post_template_css', 'hook_amp_my_css' );
}
//AMP PLUGIN STUFF END

//first and last classes for widgets
function hook_widget_first_last_classes($params) {
    global $my_widget_num;
    $this_id = $params[0]['id'];
    $arr_registered_widgets = wp_get_sidebars_widgets();

    if (!$my_widget_num) {
        $my_widget_num = array();
    }

    if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
        return $params;
    }

    if (isset($my_widget_num[$this_id])) {
        $my_widget_num[$this_id] ++;
    } else {
        $my_widget_num[$this_id] = 1;
    }

    $class = 'class="widget-'.$my_widget_num[$this_id].' ';

    if ($my_widget_num[$this_id] == 1 && $my_widget_num[$this_id] != count($arr_registered_widgets[$this_id])) {
        $class .= 'widget-first ';
    } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
        $class .= 'widget-last ';
    }

    $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

    return $params;

}
add_filter('dynamic_sidebar_params', 'hook_widget_first_last_classes');

//FIX FOR COMPATIBILITY MODE ON IE
add_filter('wp_headers', 'hook_cdfie_add_header');
function hook_cdfie_add_header($headers) {
    $headers['X-UA-Compatible']='IE=edge';
    return $headers;
}

//Remove REDUX framework messages
function prk_remove_redux_messages() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
    }
}
add_action('init', 'prk_remove_redux_messages');


add_filter( 'ups_sidebar', 'hook_ups_display_sidebar' );
add_filter( 'ryno_sidebar', 'hook_ups_display_sidebar' );
add_action( 'init', 'ups_options_init' );
add_action( 'admin_init', 'ups_options_admin_init' );
add_action( 'admin_enqueue_scripts', 'ups_options_admin_scripts' );
add_action( 'admin_menu', 'ups_options_add_page' );

function hook_ups_display_sidebar( $default_sidebar ) {
    global $post;

    $sidebars = get_option( 'ups_sidebars' );
    if ($sidebars!="") {
        foreach ( $sidebars as $id => $sidebar ) {
            if ( array_key_exists( 'pages', $sidebar ) ) {
                if ( array_key_exists( 'children', $sidebar ) && $sidebar['children'] == 'on' ) {
                    $hook_child = array_key_exists( $post->post_parent, $sidebar['pages'] );
                } else {
                    $hook_child = false;
                }
                if ( array_key_exists( $post->ID, $sidebar['pages'] ) || $hook_child ) {
                    return $id;
                }
            }
        }
    }

    return $default_sidebar;
}

function ups_options_add_page() {
    add_theme_page( 'Manage Sidebars', 'Manage Sidebars', 'edit_theme_options', 'ups_sidebars', 'ups_sidebars_do_page' );
}

function ups_options_init() {
    $sidebars = get_option( 'ups_sidebars' );

    if ( is_array( $sidebars ) ) {
        foreach ( (array) $sidebars as $id => $sidebar ) {
            unset( $sidebar['pages'] );
            $sidebar['id'] = $id;
            register_sidebar( $sidebar );
        }
    }
}

function ups_options_admin_scripts() {
    wp_enqueue_script('common');
    wp_enqueue_script('wp-lists');
    wp_enqueue_script('postbox');
}

function ups_options_admin_init() {

    register_setting( 'ups_sidebars_options', 'ups_sidebars', 'ups_sidebars_validate' );

    $sidebars = get_option( 'ups_sidebars' );
    if ( is_array( $sidebars ) && count ( $sidebars ) > 0 ) {
        foreach ( $sidebars as $id => $sidebar ) {
            add_meta_box(
                esc_attr( $id ),
                esc_html( $sidebar['name'] ),
                'ups_sidebar_do_meta_box',
                'ups_sidebars',
                'normal',
                'default',
                array(
                    'id' => esc_attr( $id ),
                    'sidebar' => $sidebar
                )
            );

            unset( $sidebar['pages'] );
            $sidebar['id'] = esc_attr( $id );
            register_sidebar( $sidebar );
        }
    } else {
        add_meta_box( 'ups-sidebar-no-sidebars', 'No sidebars', 'ups_sidebar_no_sidebars', 'ups_sidebars', 'normal', 'default' );
    }

    add_meta_box( 'ups-sidebar-add-new-sidebar', 'Add New Sidebar', 'ups_sidebar_add_new_sidebar', 'ups_sidebars', 'side', 'default' );
    add_meta_box( 'ups-sidebar-about-the-plugin', 'About the Plugin', 'ups_sidebar_about_the_plugin', 'ups_sidebars', 'side', 'default' );
}

function ups_sidebar_no_sidebars() {
    ?>
    <p>You haven&rsquo;t added any sidebars yet. Add one using the form on the right hand side!</p>
    <?php
}

function ups_sidebars_do_page() {
    if ( ! isset( $_REQUEST['settings-updated'] ) )
        $_REQUEST['settings-updated'] = false;
    ?>
    <div class="wrap">
        <h2>Manage Sidebars</h2>
        <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
            <div class="updated fade"><p><strong>Sidebar settings saved.</strong> You can now go manage the <a href="<?php echo esc_url(get_admin_url()); ?>widgets.php">widgets</a> for your sidebars.</p></div>
        <?php endif; ?>
        <div id="poststuff" class="metabox-holder has-right-sidebar">
            <div id="post-body" class="has-sidebar">
                <div id="post-body-content" class="has-sidebar-content">
                    <form method="post" action="options.php">
                        <?php settings_fields( 'ups_sidebars_options' ); ?>
                        <?php do_meta_boxes( 'ups_sidebars', 'normal', null ); ?>
                    </form>
                </div>
            </div>
            <div id="side-info-column" class="inner-sidebar">
                <?php do_meta_boxes( 'ups_sidebars', 'side', null ); ?>
            </div>
        </div>
    </div>
    <?php
}

function ups_sidebar_do_meta_box( $post, $metabox ) {
    $sidebars = get_option( 'ups_sidebars' );
    $sidebar_id = esc_attr( $metabox['args']['id'] );
    $sidebar = $sidebars[$sidebar_id];

    if ( ! isset( $sidebar['pages'] ) ) {
        $sidebar['pages'] = array();
    }

    $options_fields = array(
        'name' => 'Name',
        'description' => 'Description',
        'before_title' => 'Before Title',
        'after_title' => 'After Title',
        'before_widget' => 'Before Widget',
        'after_widget' => 'After Widget'
    );

    $get_posts = new WP_Query;
    $posts = $get_posts->query( array(
        'offset' => 0,
        'order' => 'ASC',
        'orderby' => 'title',
        'posts_per_page' => -1,
        'post_type' => 'page',
        'suppress_filters' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    ) );
    ?>
    <div class="wp-tab-wrapper prk_lf pct_25 prkadmin_hide_now">
        <ul class="wp-tab-bar">
            <li class="wp-tab-active">All Pages</li>
        </ul>
        <div class="wp-tab-panel">
            <ul id="pagechecklist" class="categorychecklist form-no-clear">
                <?php foreach ( $posts as $post ) : ?>
                    <li>
                        <label>
                            <?php
                            $checked = '';
                            if ( array_key_exists( $post->ID, $sidebar['pages'] ) ) {
                                $checked = ' checked="checked"';
                            }
                            ?>
                            <input type="checkbox" class="menu-item-checkbox" name="ups_sidebars[<?php echo esc_attr($sidebar_id); ?>][pages][<?php echo esc_attr($post->ID); ?>]" value="<?php echo esc_attr( $post->post_title ); ?>"<?php echo esc_attr($checked); ?> />
                            <?php echo esc_html( $post->post_title ); ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="prk_lf">
        <table class="form-table">
            <?php foreach ( $options_fields as $id => $label ) : ?>
                <tr valign="top" class="prk_bars_<?php echo esc_attr( $id ); ?>">
                    <th scope="row"><label for="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]"><?php echo esc_html( $label ); ?></label></th>
                    <td>
                        <?php if ( 'children' == $id ) : ?>
                            <?php
                            $checked = '';
                            if ( array_key_exists( 'children', $sidebar ) && $sidebar['children'] == 'on' ) {
                                $checked = ' checked="checked"';
                            }
                            ?>
                            <label>
                                <input type="checkbox" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="on" id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]"<?php echo esc_attr($checked); ?> />
                                <span class="description">Set page children to use the parent page sidebar by default?</span>
                            </label>
                        <?php else : ?>
                            <input id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" class="regular-text" type="text" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_html( $sidebar[$id] ); ?>" />
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="clear submitbox">
        <input type="submit" class="button-primary" value="Save changes" />&nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" name="ups_sidebars[delete]" value="<?php echo esc_attr( $sidebar_id ); ?>" /> Delete this sidebar?</label>
    </div>
    <?php
}

function ups_sidebars_validate( $input ) {
    if ( isset( $input['add_sidebar'] ) ) {
        $sidebars = get_option( 'ups_sidebars' );
        if ( ! empty( $input['add_sidebar'] ) ) {
            if ( is_array( $sidebars ) ) {
                $sidebar_num = count( $sidebars ) + 1;
            } else {
                $sidebar_num = 1;
            }
            $sidebar_num=rand(1,10000);
            $sidebars['ups-sidebar-'.$sidebar_num] = array(
                'name' => esc_html( $input['add_sidebar'] ),
                'description' => '',
                'before_widget' => '<div id="%1$s" class="widget %2$s vertical_widget clearfix"><div class="widget_inner prk_9_em">',
                'after_widget' => '</div><div class="clearfix"></div></div>',
                'before_title' => '<div class="widget-title header_font zero_color prk_heavier_600">',
                'after_title' => '<div class="hook_titled simple_line"></div></div><div class="clearfix simple_line"></div>',
                'pages' => array(),
                'children' => 'off'
            );
        }
        return $sidebars;
    }

    if ( isset( $input['delete'] ) ) {
        foreach ( (array) $input['delete'] as $delete_id ) {
            unset( $input[$delete_id] );
        }
        unset( $input['delete'] );
        return $input;
    }

    return $input;
}

function ups_sidebar_add_new_sidebar() {
    ?>
    <form method="post" action="options.php" id="add-new-sidebar">
        <?php settings_fields( 'ups_sidebars_options' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Name</th>
                <td>
                    <input id="ups_sidebars[add_sidebar]" class="text" type="text" name="ups_sidebars[add_sidebar]" value="" />
                </td>
            </tr>
        </table>
        <p class="submit zero_padding">
            <input type="submit" class="button-primary" value="Add Sidebar" />
        </p>
    </form>
    <?php
}

function ups_sidebar_about_the_plugin()
{
    ?>
    <p>This plugin was developed by Andrew Ryno, a WordPress developer based in Phoenix, AZ who never found a decent
        solution to having sidebars on different pages.</p>
    <p>Like the plugin? Think it could be improved? Feel free to contribute over at GitHub!</p>
    <?php

}

function hook_vc_disable_update() {
    if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {
        remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
        remove_filter( 'pre_set_site_transient_update_plugins', array(
            vc_updater()->updateManager(),
            'check_update'
        ) );
    }
}
add_action('admin_init','hook_vc_disable_update',9);

function hook_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'hook_remove_wp_admin_bar_button' );

//ADD ASYNC ATTRIBUTE
function hook_async_attribute($tag, $handle)
{
    $scripts_to_async = array('hook_main', 'comment-reply');
    foreach ($scripts_to_async as $async_script) {
        if ($async_script === $handle) {
            return str_replace(' src', ' async="async" src', $tag);
        }
    }
    return $tag;
}

add_filter('script_loader_tag', 'hook_async_attribute', 10, 2);

?>