<?php
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
                'value' => 'Montserrat:400,700',
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
                'value' => 'Playfair+Display:400,700,400italic,700italic',
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

//Workaround for options output when ACF is OFF
/**
 * Get default options
 * @return mixed
 */

function hook_check_options()
{
    if (!class_exists('acf') && !function_exists('hook_framework_admin_scripts')) {
        function get_field($field_id)
        {
            $output = "";
            return $output;
        }
    }
}
add_action( 'init','hook_check_options');

//POSTS - ADD MORE COLUMNS FOR THE DASHBOARD VIEW
add_filter('manage_post_posts_columns', 'hook_columns_head_only', 10);
add_action('manage_post_posts_custom_column', 'hook_columns_content_only', 10, 2);

function hook_get_image_posts($post_ID) {
    $post_thumbnail_id=get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img=wp_get_attachment_image_src($post_thumbnail_id, 'medium');
        return $post_thumbnail_img[0];
    }
}
function hook_columns_head_only($defaults) {
    $defaults['featured_image']='Featured Image';
    return $defaults;
}
function hook_columns_content_only($column_name, $post_ID) {
    global $post;
    if ($column_name == 'featured_image') {
        $post_featured_image=hook_get_image_posts($post_ID);
        if ($post_featured_image) {
            echo '<img class="slides_image_preview prk_posts_img" src="'.esc_url($post_featured_image).'" />';
        }
        else {
            echo ('<span class="prk_posts_img">No image</span>');
        }
    }
}

//VISUAL COMPOSER STUFF
if (HOOK_VC_ON) {

    add_filter('wpb_widget_title', 'hook_override_widget_title', 10, 2);
    function hook_override_widget_title($hook_output='', $params=array('')) {
        $hook_extraclass=(isset($params['extraclass'])) ? " ".$params['extraclass'] : "";
        echo '<div class="header_font zero_color"><h3 class="wpb_heading prk_heavier_600 small'.esc_attr($hook_extraclass).'">'.esc_attr($params['title']).'</h3></div>';
    }

    if (!function_exists('hook_integrateWithVC')) {
        function hook_integrateWithVC() {
            return;
        }
    }
    add_action( 'vc_before_init', 'hook_integrateWithVC' );
}

function hook_setup() {
    register_nav_menus(array('prk_main_navigation' => esc_html__('Main Navigation', 'hook')));
    register_nav_menus(array('prk_mobile_navigation' => esc_html__('Mobile Mode Navigation', 'hook')));
    if (function_exists('amp_render')) {
        register_nav_menus(array('prk_amp_navigation' => esc_html__('AMP Pages Navigation', 'hook')));
    }
    add_theme_support('post-thumbnails');
    add_editor_style('css/editor-style.css');
}

function hook_header() {
    $prk_hook_options=hook_options();
    global $post;
    global $hook_translated;
    $hook_translated=$prk_hook_options;

    //TRANSLATE ACCORDING TO THE SELECTED METHOD
    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if ($prk_hook_options['theme_translation']=="1" || HOOK_WPML_ON=="true") {
        load_theme_textdomain('hook', get_template_directory().'/languages');
        $hook_translated['404_title_text']=esc_html__("PAGE NOT FOUND", 'hook');
        $hook_translated['404_body_text']=esc_html__("Ooops... Something went terribly wrong!", 'hook');
        $hook_translated['404_button_text']=esc_html__("BACK TO HOMEPAGE", 'hook');
        $hook_translated['search_tip_text']=esc_html__("Type and hit ENTER", 'hook');
        $hook_translated['submit_search_res_title']=esc_html__("Search Results For", 'hook');
        $hook_translated['submit_search_no_results']=esc_html__("No Results Found", 'hook');
        $hook_translated['required_text']=esc_html__(" (required)", 'hook');
        $hook_translated['like_text']=esc_html__("I like this!", 'hook');
        $hook_translated['already_liked_text']=esc_html__("You already liked this.", 'hook');
        $hook_translated['share_text']=esc_html__("Share on", 'hook');
        $hook_translated['profile_text']=esc_html__("View Profile", 'hook');
        $hook_translated['in_touch_text']=esc_html__("Get In Touch", 'hook');
        $hook_translated['menu_back_text']=esc_html__("BACK", 'hook');
        $hook_translated['to_portfolio']=esc_html__("BACK TO PORTFOLIO", 'hook');
        $hook_translated['filter_text']=esc_html__("Filter", 'hook');
        $hook_translated['launch_text']=esc_html__("Launch Project", 'hook');
        $hook_translated['project_text']=esc_html__("Project URL", 'hook');
        $hook_translated['skills_text']=esc_html__("Skills", 'hook');
        $hook_translated['tags_text']=esc_html__("Tags", 'hook');
        $hook_translated['client_text']=esc_html__("Client", 'hook');
        $hook_translated['extra_fld1']=esc_html__("My Custom Field 1", 'hook');
        $hook_translated['extra_fld2']=esc_html__("My Custom Field 2", 'hook');
        $hook_translated['extra_fld3']=esc_html__("My Custom Field 3", 'hook');
        $hook_translated['load_more']=esc_html__("LOAD MORE POSTS", 'hook');
        $hook_translated['no_more']=esc_html__("NO MORE POSTS", 'hook');
        $hook_translated['related_prj_teaser_text']=esc_html__("Simply delivering amazing stuff. Period.", 'hook');
        $hook_translated['prj_desc_text']=esc_html__("About this project", 'hook');
        $hook_translated['prj_prev_text']=esc_html__("PREVIOUS PROJECT", 'hook');
        $hook_translated['prj_next_text']=esc_html__("NEXT PROJECT", 'hook');
        $hook_translated['prj_close_text']=esc_html__("CLOSE", 'hook');
        $hook_translated['related_prj_text']=esc_html__("Related Projects", 'hook');
        $hook_translated['date_text']=esc_html__("Date", 'hook');
        $hook_translated['related_text']=esc_html__("Related Projects", 'hook');
        $hook_translated['all_text']=esc_html__("Show All", 'hook');
        $hook_translated['sticky_text']=esc_html__("Sticky Post", 'hook');
        $hook_translated['to_blog']=esc_html__("To Blog", 'hook');
        $hook_translated['top_search_text']=esc_html__("SEARCH", 'hook');
        $hook_translated['read_more']=esc_html__("READ MORE", 'hook');
        $hook_translated['min_read_text']=esc_html__("Min Read", 'hook');
        $hook_translated['related_posts_text']=esc_html__("Related Posts", 'hook');
        $hook_translated['related_posts_teaser_text']=esc_html__("Related posts that you should not miss.", 'hook');
        $hook_translated['posted_by_text']=esc_html__("By", 'hook');
        $hook_translated['about_author_text']=esc_html__("About", 'hook');
        $hook_translated['older']=esc_html__("Older posts", 'hook');
        $hook_translated['newer']=esc_html__("Newer posts", 'hook');
        $hook_translated['older_single']=esc_html__("PREVIOUS POST", 'hook');
        $hook_translated['newer_single']=esc_html__("NEXT POST", 'hook');
        $hook_translated['comments_label']=esc_html__("Comments", 'hook');
        $hook_translated['comments_no_response']=esc_html__("No Comments Yet", 'hook');
        $hook_translated['comments_one_response']=esc_html__("One Comment", 'hook');
        $hook_translated['comments_oneplus_response']=esc_html__("Comments", 'hook');
        $hook_translated['reply_text']=esc_html__("Reply", 'hook');
        $hook_translated['comments_leave_reply']=esc_html__("Leave a Reply", 'hook');
        $hook_translated['comments_author_text']=esc_html__("Name", 'hook');
        $hook_translated['comments_email_text']=esc_html__("Email", 'hook');
        $hook_translated['comments_url_text']=esc_html__("Website", 'hook');
        $hook_translated['comments_comment_text']=esc_html__("Comment", 'hook');
        $hook_translated['comments_submit']=esc_html__("Submit Comment", 'hook');
        $hook_translated['empty_text_error']=esc_html__("Error! Please fill all the required fields.", 'hook');
        $hook_translated['invalid_email_error']=esc_html__("Error! Invalid email.", 'hook');
        $hook_translated['comment_ok_message']=esc_html__("Thank you for your feedback!", 'hook');
        $hook_translated['contact_subject_text']=esc_html__("Subject", 'hook');
        $hook_translated['contact_message_text']=esc_html__("Your Message", 'hook');
        $hook_translated['contact_submit']=esc_html__("Send Message", 'hook');
        $hook_translated['contact_wait_text']=esc_html__("Please Wait...", 'hook');
        $hook_translated['contact_ok_text']=esc_html__("Thank you for contacting us. We will reply soon!", 'hook');
        $hook_translated['next_text']=esc_html__("Next", 'hook');
        $hook_translated['previous_text']=esc_html__("Previous", 'hook');
        $hook_translated['lightbox_text']=esc_html__("of", 'hook');
        $hook_translated['prj_info_text']=esc_html__("Project Info", 'hook');
        $hook_translated['of_text']=esc_html__("of", 'hook');
        $hook_translated['on_text']=esc_html__("on", 'hook');
        $hook_translated['footer_text']=esc_html__("2014 - All rights reserved.", 'hook');
        $hook_translated['footer_text_extra']=esc_html__("Proudly developed with WordPress", 'hook');
        $hook_translated['to_top_text']=esc_html__("To Top", 'hook');
        $hook_translated['all_the_posts']=esc_html__("All the posts.", 'hook');
        $hook_translated['all_the_portfolios']=esc_html__("All the work.", 'hook');
        $hook_translated['comments_under_reply']=esc_html__("Your feedback is valuable for us. Your email will not be published.", 'hook');
        $hook_translated['search_help_1']=esc_html__("Sorry, but it seems that there are no results... Maybe you can try again?", 'hook');
        $hook_translated['search_help_2']=esc_html__("Still looking for something else?", 'hook');
        $hook_translated['search_help_3']=esc_html__("Double check your spelling", 'hook');
        $hook_translated['search_help_4']=esc_html__("Try using single words (e.g. painting, book)", 'hook');
        $hook_translated['search_help_5']=esc_html__("Try searching for something that is less specific", 'hook');
        $hook_translated['twitter_text']=esc_html__("Tweet", 'hook');
        $hook_translated['facebook_text']=esc_html__("Share", 'hook');
        $hook_translated['google_text']=esc_html__("+1", 'hook');
        $hook_translated['pinterest_text']=esc_html__("Pin It", 'hook');
    }
    else {
        $hook_translated['search_help_1']=esc_html__("Sorry, but it seems that there are no results... Maybe you can try again?", 'hook');
        $hook_translated['search_help_2']=esc_html__("Still looking for something else?", 'hook');
        $hook_translated['search_help_3']=esc_html__("Double check your spelling", 'hook');
        $hook_translated['search_help_4']=esc_html__("Try using single words (e.g. painting, book)", 'hook');
        $hook_translated['search_help_5']=esc_html__("Try searching for something that is less specific", 'hook');
        load_theme_textdomain('hook', get_template_directory().'/languages');
    }
    if ($prk_hook_options['hook_responsive']=="1") {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />';
    }
    //ADD FAVICON
    echo '<link rel="shortcut icon" href="'.$prk_hook_options['favicon']['url'].'">';
    //NO PHONE DETECTION ON APPLE DEVICES
    echo '<meta name="format-detection" content="telephone=no">';
}
if (!function_exists('hook_extra_feature')) {
    function hook_extra_feature() {
        global $hook_feat_flaga;
        if ($hook_feat_flaga=="yes") {
            $prk_hook_options=hook_options();
            $hook_in_filter="";
            if (isset($prk_hook_options['overf_skills']) && is_array($prk_hook_options['overf_skills'])) {
                $hook_arra_of=$prk_hook_options['overf_skills'];
                foreach ($hook_arra_of as $hook_arra_of_single) {
                    $hook_term=get_term_by('id',$hook_arra_of_single,'pirenko_skills');
                    $hook_in_filter.=$hook_term->slug.',';
                }
            }
            echo '<div id="hook_hidden_portfolio">';
            echo '<div id="hook_close_hidden" class="prk_grid-button prk_rearrange"><span class="prk_grid"></span></div>';
            echo do_shortcode('[pirenko_last_portfolios thumbs_type_folio="'.esc_attr($prk_hook_options['overf_click']).'" layout_type_folio="'.esc_attr($prk_hook_options['overf_layout']).'" cols_number="'.esc_attr($prk_hook_options['overf_columns']).'" items_number="999" cat_filter="'.esc_attr($hook_in_filter).'" thumbs_mg="'.esc_attr($prk_hook_options['overf_margin']).'" multicolored_thumbs="'.esc_attr($prk_hook_options['overf_colored']).'" hook_show_skills="'.esc_attr($prk_hook_options['overf_info']).'" show_filter="no" filter_align="hook_center_align" videos_behavior="default" panels_number="3" text_align="" hook_preload="no" show_load_more="yes"][/pirenko_last_portfolios]');
            echo '</div>';
        }
    }
}

function hook_translations() {
    global $hook_translated;
    return $hook_translated;
}

function hook_options() {
    //RETURN DEFAULT OPTIONS OF FRAMEWORK IS OFF
    if (HOOK_FRAMEWORK_ON) {
        global $prk_hook_options;
    }
    else {
        global $prk_hook_options;
        $prk_hook_options=array(
            'hook_responsive'=>'1',
            'custom_width'=>'1280',
            'show_sooner'=>'',
            'hook_detect_retina'=>'1',
            'page_transition'=>'hk_trans_fade',
            'page_transition_bk'=>'#f7f7f7',
            'ajax_calls'=>'0',
            'smooth_scroll'=>'0',
            'font_size'=>'15',
            'header_font'=>'PT+Sans:400,700,400italic,700italic',
            'uppercase_headings'=>'0',
            'body_font'=>'PT+Sans:400,700,400italic,700italic',
            'custom_font'=>'',
            'custom_font_style'=>'italic',
            'titles_font'=>'header_font',
            'main_subheadings_font'=>'body_font',
            'subheadings_style'=>'italic',
            'headings_align'=>'hook_center_align',
            'drop_caps_size'=>'52',
            'use_custom_colors'=>'1',
            'site_background_color'=>'#ffffff',
            'active_color'=>'#12b2cb',
            'bd_headings_color'=>'#222222',
            'bd_smallers_color'=>'#3e3e3e',
            'inactive_color'=>'#808080',
            'lines_color'=>'#efefef',
            'background_color'=>'#ffffff',
            'inputs_bordercolor'=>'#efefef',
            'inputs_radius'=>'0',
            'shadow_color'=>'#1b1b1b',
            'custom_shadow'=>'0',
            'buttons_font'=>'headings_f',
            'buttons_spacing'=>'0',
            'uppercase_buttons'=>'1',
            'buttons_border'=>'1',
            'buttons_radius'=>'0',
            'buttons_text_color'=>'#FFFFFF',
            'theme_buttons_color'=>'#0b9bb1',
            'buttons_inner_shadow'=>'0',
            'slider_text_color'=>'#ffffff',
            'buttons_color'=>'#141414',
            'back_to_top_bk'=>'#12b2cb',
            'back_to_top_color'=>'#ffffff',
            'preloader_style'=>'theme_spinner',
            'preloader_color_1'=>'#111111',
            'preloader_color_2'=>'#12b2cb',
            'preloader_color_3'=>'#686868',
            'preloader_color'=>'#49B6B2',
            'preloader_opacity'=>'70',
            'preloader_image'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'preloader_image_retina'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'background_color_dots'=>'#FFFFFF',
            'featured_header_color'=>'#ffffff',
            'bk_color_sidebar_overlay'=>'#111111',
            'right_sidebar'=>'1',
            'logo_align'=>'st_logo_on_left',
            'logo'=>array(
                'url'=>get_template_directory_uri().'/images/logo.png',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'logo_retina'=>array(
                'url'=>get_template_directory_uri().'/images/logo-retina.png',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'logo_top_margin'=>'26',
            'logo_collapsed'=>array(
                'url'=>get_template_directory_uri().'/images/logo.png',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'logo_collapsed_retina'=>array(
                'url'=>get_template_directory_uri().'/images/logo-retina.png',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'logo_collapsed_top_margin'=>'17',
            'favicon'=> array(
                'url'=>get_template_directory_uri().'/images/favicon.ico',
                'id'=>'',
                'width'=>'',
                'height'=>'',
            ),
            'show_top_bar'=>0,
            'top_bar_height'=>36,
            'top_bar_font_size'=>11,
            'active_color_header_bar'=>'#303030',
            'body_color_header_bar'=>'#a8a8a8',
            'background_color_header_bar'=>'#FFFFFF',
            'border_color_header_bar'=>'',
            'top_bar_limited_width'=>'0',
            'resp_break'=>'900',
            'menu_vertical'=>'92',
            'background_color_menu_bar'=>'#141414',
            'header_default_opacity'=>'0',
            'border_menu_bar'=>'#141414',
            'border_default_opacity'=>'0',
            'menu_spacing'=>'1',
            'menu_align'=>'st_menu_on_right',
            'menu_display'=>'st_regular_menu',
            'menu_hide_flag'=>'1',
            'menu_hide_pixels'=>'110',
            'bk_color_menu_overlay'=>'#333038',
            'opacity_menu_overlay'=>'97',
            'active_color_menu_overlay'=>'#000000',
            'color_menu_overlay'=>'#000000',
            'overlay_align'=>'hook_center_align',
            'overlay_page_id'=>'',
            'overlay_footer_text'=>'',
            'top_search'=>'1',
            'menu_parent_rollover'=>'with_lines',
            'menu_font'=>'header_font',
            'menu_font_size'=>'14',
            'menu_line_height'=>'40',
            'menu_parent_style'=>'normal',
            'menu_font_weight'=>'600',
            'labels_offset'=>'0',
            'menu_padding'=>'14',
            'menu_active_color'=>'#ffffff',
            'menu_up_color'=>'#ffffff',
            'active_subheadings'=>'0',
            'menu_subheadings_style'=>'italic',
            'subheadings_color'=>'#a8a8a8',
            'subheadings_font_size'=>'10',
            'subheadings_font_weight'=>'400',
            'subheadings_offset'=>'36',
            'subheadings_font'=>'custom_font',
            'menu_collapse_flag'=>'1',
            'menu_collapse_pixels'=>'380',
            'collapsed_menu_vertical'=>'72',
            'background_color_menu_bar_after'=>'#141414',
            'header_opacity_after'=>'100',
            'border_menu_bar_after'=>'#141414',
            'border_opacity_after'=>'100',
            'menu_active_color_after'=>'#12b2cb',
            'menu_up_color_after'=>'#ffffff',
            'submenu_font_size'=>'12',
            'submenu_font_weight'=>'400',
            'menu_sub_padding'=>'40',
            'submenu_active_color'=>'#12b2cb',
            'submenu_text_color'=>'#ffffff',
            'submenu_lines_color'=>'#212121',
            'submenu_background_color'=>'#141414',
            'network_icon_1'=>'',
            'network_link_1'=>'',
            'network_icon_2'=>'',
            'network_link_2'=>'',
            'network_icon_3'=>'',
            'network_link_3'=>'',
            'network_icon_4'=>'',
            'network_link_4'=>'',
            'network_icon_5'=>'',
            'network_link_5'=>'',
            'network_icon_6'=>'',
            'network_link_6'=>'',
            'nets_offset'=>'-14',
            'css_enable'=>'0',
            'menu_text'=>'MENU',
            'sidebar_text'=>'MENU',
            'menu_text_only'=>'only_text',
            'menu_text_only_sb'=>'only_text',
            'append_mobile_logo'=>'mobile_logo_aft',
            'right_bar_align'=>'hook_left_align',
            'background_image_right_bar'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'background_color_right_bar'=>'#141414',
            'active_color_right_bar'=>'#12b2cb',
            'body_color_right_bar'=>'#bbbbbb',
            'opacity_mobile_overlay'=>'75',
            'show_hidden_sidebar'=>'0',
            'sidebar_position'=>'st_sidebar_on_right',
            'sidebar_width'=>'380',
            'sidebar_align'=>'hook_center_align',
            'background_image_sidebar'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'background_color_sidebar'=>'#C0C0C0',
            'active_color_sidebar'=>'#ffffff',
            'body_color_sidebar'=>'#AFAFAF',
            'sidebar_footer_id'=>'',
            'opacity_sidebar_overlay'=>'25',
            'persistent_blog'=>'0',
            'persistent_folio'=>'0',
            'background_color_prst'=>'#000000',
            'body_color_prst'=>'#ffffff',
            'use_footer'=>'1',
            'footer_reveal'=>'0',
            'footer_font_size'=>'13',
            'titles_color_footer'=>'#ffffff',
            'body_color_footer'=>'#808080',
            'footer_border_color'=>'',
            'background_color_footer'=>'#1b1b1b',
            'bk_image_footer'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'footer_image_align'=>'center',
            'bottom_page'=>'0',
            'bottom_page_id'=>'',
            'bottom_page_after'=>'0',
            'bottom_page_after_id'=>'',
            'bottom_sidebar'=>'1',
            'widgets_nr'=>'small-3',
            'footer_text_background_color'=>'#141414',
            'footer_text'=>'Hook WordPress Theme',
            'footer_text_extra'=>'Developed with Love & Pride by Pirenko.',
            'archives_type'=>'classic',
            'posts_bk_color'=>'#ffffff',
            'thumbs_text_color_blog'=>'#ffffff',
            'background_color_btns_blog'=>'#111111',
            'custom_opacity'=>'60',
            'custom_width_blog'=>'1080',
            'header_align_blog'=>'bottomed_content',
            'autoplay_blog'=>'1',
            'delay_blog'=>'6500',
            'uppercase_blog_headings'=>'1',
            'show_date_blog'=>'1',
            'postedby_blog'=>'1',
            'show_min_read'=>'1',
            'categoriesby_blog'=>'1',
            'show_blog_nav'=>'1',
            'related_posts'=>'1',
            'related_author'=>'1',
            'comments_bk_color'=>'',
            'share_blog'=>'1',
            'share_blog_fb'=>'1',
            'share_blog_goo'=>'1',
            'share_blog_pin'=>'1',
            'share_blog_twt'=>'1',
            'share_blog_email'=>'0',
            'archives_ptype'=>'grid',
            'thumbs_text_color'=>'#ffffff',
            'thumbs_text_position'=>'ct_ct',
            'background_color_btns'=>'#000000',
            'custom_opacity_folio'=>'60',
            'thumbs_bg_size'=>'full_ths',
            'portfolio_layout'=>'half',
            'autoplay_portfolio'=>'1',
            'delay_portfolio'=>'6500',
            'uppercase_folio_headings'=>'0',
            'dateby_port'=>'1',
            'footer_port'=>'0',
            'categoriesby_port'=>'1',
            'show_port_nav'=>'1',
            'related_port'=>'0',
            'related_info'=>'folio_always_title_and_skills hk_ins',
            'port_resp_order' => '0',
            'background_color_overlayer'=>'#ffffff',
            'active_color_overlayer'=>'#d92f3a',
            'headings_color_overlayer'=>'#000000',
            'smallers_color_overlayer'=>'#3e3e3e',
            'body_color_overlayer'=>'#808080',
            'lines_color_overlayer'=>'#e2e2e2',
            'share_portfolio'=>'1',
            'share_portfolio_fb'=>'1',
            'share_portfolio_goo'=>'1',
            'share_portfolio_pin'=>'1',
            'share_portfolio_twt'=>'1',
            'share_portfolio_email'=>'0',
            'background_color_overf'=>'#ffffff',
            'overf_layout'=>'grid',
            'overf_columns'=>'3',
            'overf_margin'=>'0',
            'overf_click'=>'classiqued',
            'overf_colored'=>'0',
            'overf_info'=>'folio_title_and_skills',
            'search_image'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'search_layout'=>'masonry',
            'search_right_sidebar'=>'0',
            'error_image'=>array(
                'url'=>'',
                'id'=>'',
                'height'=>'',
                'width'=>'',
                'thumbnail'=>''
            ),
            'search_color'=>'',
            '404_search'=>'back_button',
            'google_maps_key'=>'',
            'theme_translation'=>'0',
            'theme_divider'=>'-',
            'search_tip_text'=>'Type And Hit ENTER',
            'submit_search_res_title'=>'Search Results for',
            'submit_search_no_results'=>'No Results Found for',
            'previous_text'=>'Previous',
            'next_text'=>'Next',
            'lightbox_text'=>'of',
            'required_text'=>'(required)',
            'profile_text'=>'View Profile',
            'in_touch_text'=>'Get In touch',
            'twitter_text'=>'Tweet',
            'facebook_text'=>'Share',
            'google_text'=>'+1',
            'pinterest_text'=>'Pin It',
            '404_title_text'=>'PAGE NOT FOUND',
            '404_body_text'=>'Ooops... Something went terribly wrong!',
            '404_button_text'=>'BACK TO HOMEPAGE',
            'read_more'=>'Read More',
            'sticky_text'=>'Sticky Post',
            'min_read_text'=>'MIN READ',
            'posted_by_text'=>'Posted by',
            'on_text'=>'on',
            'about_author_text'=>'About',
            'to_blog'=>'BACK TO BLOG',
            'older'=>'Older posts',
            'newer'=>'Newer posts',
            'related_posts_text'=>'Related News',
            'related_posts_teaser_text'=>'Other posts that you should not miss.',
            'older_single'=>'← PREVIOUS POST',
            'newer_single'=>'NEXT POST →',
            'all_the_posts'=>'All the posts published.',
            'prj_desc_text'=>'About this project',
            'date_text'=>'Date',
            'client_text'=>'Client',
            'extra_fld1'=>'My Custom Field 1',
            'extra_fld2'=>'My Custom Field 2',
            'extra_fld3'=>'My Custom Field 3',
            'skills_text'=>'Skills',
            'tags_text'=>'Tags',
            'project_text'=>'Project URL',
            'launch_text'=>'Launch Project',
            'all_text'=>'Show All',
            'load_more'=>'LOAD MORE POSTS',
            'no_more'=>'NO MORE POSTS TO SHOW',
            'related_prj_text'=>'Related Projects',
            'related_prj_teaser_text'=>'Simply delivering amazing stuff. Period.',
            'to_portfolio'=>'BACK TO PORTFOLIO',
            'prj_prev_text'=>'PREVIOUS PROJECT',
            'prj_next_text'=>'NEXT PROJECT',
            'all_the_portfolios'=>'All the work completed.',
            'comments_label'=>'Comments',
            'comments_no_response'=>'No comments',
            'comments_one_response'=>'1 Comment',
            'comments_oneplus_response'=>'Comments',
            'reply_text'=>'Reply',
            'comments_leave_reply'=>'Leave a Comment',
            'comments_under_reply'=>'Your feedback is valuable for us. Your email will not be published.',
            'comments_author_text'=>'Name',
            'comments_email_text'=>'Email',
            'comments_url_text'=>'Website',
            'comments_comment_text'=>'Your comment',
            'comments_submit'=>'Submit Comment',
            'empty_text_error'=>'Error! This field is required.',
            'invalid_email_error'=>'Error! Invalid email.',
            'comment_ok_message'=>'Thank you for your feedback!',
            'contact_subject_text'=>'Subject',
            'contact_message_text'=>'Your message',
            'contact_submit'=>'Send Message',
            'contact_error_text'=>'Error! This field is required.',
            'contact_error_email_text'=>'Error! This email is not valid.',
            'contact_wait_text'=>'Please wait...',
            'contact_ok_text'=>'Thank you for contacting us. We will reply soon!',
            'woo_subheading'=>'A stunning place to get your stuff the easy way.',
            'woo_prods_nr'=>'8',
            'woo_col_nr'=>'4',
            'woo_sidebar_display'=>'0',
            'woo_cart_display'=>'1',
            'woo_cart_always_display'=>'0',
            'woo_cart_info'=>'',
            'css_text'=>'',
            'js_text'=>'',
            'portfolio_slug'=>'portfolios',
            'skills_slug'=>'skills',
            'folio_tags_slug'=>'tagged',
            'slides_slug'=>'slides',
            'groups_slug'=>'group',
            'members_slug'=>'member',
            'team_slug'=>'team',
            'testimonials_slug'=>'testimonials',
            'testimonials_groups_slug'=>'testimonials_group',
        );
    }
    return $prk_hook_options;
}

if (!function_exists('hook_wrapper_classes')) {
    function hook_wrapper_classes() {
        global $prk_hook_options;
        $returner=$prk_hook_options['menu_display'].' '.$prk_hook_options['menu_align'].' '.$prk_hook_options['thumbs_bg_size'].' '.$prk_hook_options['logo_align'];
        if ($prk_hook_options['buttons_inner_shadow']=="1") {
            $returner.=' shadowed_buttons';
        }
        if ($prk_hook_options['menu_hide_flag']=="1") {
            $returner.=' abs_menu';
        }
        if (isset($prk_hook_options['menu_position'])) {
            $returner.=' '.$prk_hook_options['menu_position'];
        }
        if ($prk_hook_options['show_hidden_sidebar']=="1"){
            $returner.=' '.$prk_hook_options['sidebar_position'];
            if ($prk_hook_options['sidebar_width']>440) {
                $returner.=' limited_sidebar';
            }
        }
        else {
            $returner.=' hook_no_sidebar';
        }
        return esc_attr($returner);
    }
}

if (!function_exists('hook_retiner')) {
    function hook_retiner($hook_test_flag) {
        global $hook_retina_device;
        if (class_exists('Mobile_Detect')) {
            if ($hook_test_flag == true) {
                $hook_detect = new Mobile_Detect;
                if ($hook_detect->isMobile()) {
                    $hook_retina_device = true;
                } else {
                    $hook_retina_device = false;
                }
            }
        }
        else {
            $hook_retina_device = false;
        }
        return $hook_retina_device;
    }
}

//CUSTOM OUTPUT HELPERS
if (!function_exists('prk_filters')) {
    function prk_filters ($prk_content='') {
        //REPLACE PRK_YEAR WITH CURRENT YEAR
        $prk_content=str_replace('PRK_YEAR', date("Y"), $prk_content);

        //RETURN TWEAKED STRING
        return $prk_content;
    }
}

//IMAGE RELATED FUNCTIONS
function hook_dimensions($img_url,$ret_divider) {
    $hook_vt_image=vt_resize('', $img_url , '', '', false , false);
    if ($hook_vt_image['not_found']=="true") {
        return 'width="" height=""';
    }
    if (is_numeric($hook_vt_image['width'])) {
        $hook_width = $hook_vt_image['width'] / $ret_divider;
        $hook_height = $hook_vt_image['height'] / $ret_divider;
        return 'width="'.$hook_width.'" height="'.$hook_height.'"';
    }
    else {
        //Fallback
        return 'width="" height=""';
    }

}

//RETURNS SOCIAL NETWORK ICON
function hook_social_icon($hook_network_label) {
    switch ($hook_network_label) {
        case 'behance':
            return "hook_fa-behance";
            break;
        case 'delicious':
            return "hook_fa-delicious";
            break;
        case 'deviantart':
            return "hook_fa-deviantart";
            break;
        case 'dribbble':
            return "hook_fa-dribbble";
            break;
        case 'facebook':
            return "hook_fa-facebook";
            break;
        case 'facebook-official':
            return "hook_fa-facebook-official";
            break;
        case 'flickr':
            return "hook_fa-flickr";
            break;
        case 'google_plus':
            return "hook_fa-google-plus";
            break;
        case 'instagram':
            return "hook_fa-instagram";
            break;
        case 'linkedin':
            return "hook_fa-linkedin";
            break;
        case 'linkedin-square':
            return "hook_fa-linkedin-square";
            break;
        case 'medium':
            return "hook_fa-medium";
            break;
        case 'pinterest':
            return "hook_fa-pinterest";
            break;
        case 'skype':
            return "hook_fa-skype";
            break;
        case 'soundcloud':
            return "hook_fa-soundcloud";
            break;
        case 'twitter':
            return "hook_fa-twitter";
            break;
        case 'vimeo':
            return "hook_fa-vimeo-square";
            break;
        case 'wordpress':
            return "hook_fa-wordpress";
            break;
        case 'yahoo':
            return "hook_fa-yahoo";
            break;
        case 'youtube':
            return "hook_fa-youtube";
            break;
        case 'wechat':
            return "hook_fa-wechat";
            break;
        case 'rss':
            return "hook_fa-rss";
            break;
        case 'book':
            return "hook_fa-file";
            break;
        default:
            return "hook_fa-".$hook_network_label;
    }
}

//RETURNS SOCIAL NETWORK RETURN HEXA COLOR
function hook_social_color($hook_network_label) {
    switch ($hook_network_label) {
        case 'behance':
            return "#0287e5";
            break;
        case 'delicious':
            return "#3274d1";
            break;
        case 'deviantart':
            return "#54675a";
            break;
        case 'dribbble':
            return "#ca4578";
            break;
        case 'facebook-official':
            return "#1f69b3";
            break;
        case 'flickr':
            return "#fd0083";
            break;
        case 'google_plus':
            return "#2b2b2b";
            break;
        case 'medium':
            return "#111111";
            break;
        case 'instagram':
            return "#547FA2";
            break;
        case 'linkedin-square':
            return "#1a7696";
            break;
        case 'pinterest':
            return "#df2126";
            break;
        case 'skype':
            return "#28a9ED";
            break;
        case 'soundcloud':
            return "#f8500f";
            break;
        case 'twitter':
            return "#43b3e5";
            break;
        case 'vimeo':
            return "#4ab2d9";
            break;
        case 'yahoo':
            return "#855c9c";
            break;
        case 'youtube':
            return "#fb2d39";
            break;
        case 'rss':
            return "#ed8333";
            break;
        case 'book':
            return "#e74c3c";
            break;
        case 'xing':
            return "#007072";
            break;
        default:
            return "#000000";
    }
}
if (!function_exists('hook_menu_icons')) {
    function hook_menu_icons($hook_custom_id,$hook_custom_class) {
        $prk_hook_options=hook_options();
        if ($prk_hook_options['network_link_1']!="" || $prk_hook_options['network_link_2']!="" || $prk_hook_options['network_link_3']!="" || $prk_hook_options['network_link_4']!="" || $prk_hook_options['network_link_5']!="" || $prk_hook_options['network_link_6']!="") {
            ?>
            <div id="<?php echo esc_attr($hook_custom_id); ?>" class="<?php echo esc_attr($hook_custom_class); ?>">
                <?php
                if ($prk_hook_options['network_link_1']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_1']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_1'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_1'])); ?>"></div>
                    </a>
                    <?php
                }
                if ($prk_hook_options['network_link_2']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_2']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_2'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_2'])); ?>"></div>
                    </a>
                    <?php
                }
                if ($prk_hook_options['network_link_3']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_3']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_3'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_3'])); ?>"></div>
                    </a>
                    <?php
                }
                if ($prk_hook_options['network_link_4']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_4']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_4'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_4'])); ?>"></div>
                    </a>
                    <?php
                }
                if ($prk_hook_options['network_link_5']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_5']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_5'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_5'])); ?>"></div>
                    </a>
                    <?php
                }
                if ($prk_hook_options['network_link_6']!="") {
                    ?>
                    <a href="<?php echo esc_attr($prk_hook_options['network_link_6']); ?>" target="_blank" data-color="<?php echo esc_attr(hook_social_color($prk_hook_options['network_icon_6'])); ?>">
                        <div class="<?php echo esc_attr(hook_social_icon($prk_hook_options['network_icon_6'])); ?>"></div>
                    </a>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}
if (!function_exists('hook_wpml_output')) {
    function hook_wpml_output() {
        $prk_hook_options=hook_options();
        $hook_languages=icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
        if(!empty($hook_languages)){
            echo '<div id="hook_extra_bar" class="'.$prk_hook_options['menu_font'].' prk_heavier_600">';
            echo '<ul class="unstyled">';
            foreach($hook_languages as $l){
                echo '<li>';
                if(!$l['active']) {
                    echo '<a href="'.$l['url'].'">';
                }
                echo icl_disp_language($l['native_name']);
                if(!$l['active']) {
                    echo '</a>';
                }
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }
}
if (!function_exists('hook_extra_bar')) {
    function hook_extra_bar() {
        $prk_hook_options=hook_options();
        $hook_translated=hook_translations();
        if ($prk_hook_options['show_top_bar']=="1") {
            ?>
            <div id="hook_header_bar" data-size="<?php echo esc_attr($prk_hook_options['top_bar_height']); ?>" class="header_font small-12 columns prk_extra_pad">
                <div class="small-centered small-12<?php if ($prk_hook_options['top_bar_limited_width']==1){echo " prk_inner_block columns";} ?>">
                    <div id="hook_extra_inner">
                        <?php
                        if(is_active_sidebar('abovebar-top-left')) {
                            echo '<div id="hook_abovebar-top-left" class="prk_lf">';
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar('abovebar-top-left')) :
                            endif;
                            echo '</div>';
                        }
                        if(is_active_sidebar('abovebar-top-right')) {
                            echo '<div id="hook_abovebar-top-right" class="prk_rf">';
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar('abovebar-top-right')) :
                            endif;
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php
        }
    }
}
if (!function_exists('hook_hidden_elements')) {
    function hook_hidden_elements($page_id="") {
        $prk_hook_options=hook_options();
        $hook_translated=hook_translations();
        if ($prk_hook_options['menu_display']=="st_hidden_menu") {
            ?>
            <div id="prk_hidden_menu" class="<?php echo esc_attr($prk_hook_options['overlay_align']); ?>">
                <div id="prk_hidden_menu_inner">
                    <?php
                    if($prk_hook_options['overlay_page_id']!="") {
                        ?>
                        <div id="prk_hidden_menu_page">
                            <?php echo do_shortcode(get_post_field( 'post_content', $prk_hook_options['overlay_page_id'], 'raw' )); ?>
                        </div>
                        <?php
                    }
                    else {
                        if (has_nav_menu('prk_main_navigation')) {
                            wp_nav_menu(array(
                                    'theme_location' => 'prk_main_navigation',
                                    'menu_class' => 'unstyled prk_popper_menu prk_menu_sized '.$prk_hook_options['menu_font'],
                                    'link_after' => '',
                                    'walker' => new rc_scm_walker)
                            );
                        }
                    }
                    ?>
                </div>
                <?php
                if ($prk_hook_options['overlay_footer_text']!="") {
                    $hook_html=array('a' => array('href' => array(),'title' => array(),'style'=>array()),'p' => array('style'=>array()),'br' => array('style'=>array()),'em' => array('style'=>array()),'strong' => array('style'=>array()));
                    ?>
                    <div id="prk_hidden_menu_footer">
                        <?php echo wp_kses($prk_hook_options['overlay_footer_text'],$hook_html); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        if ($prk_hook_options['show_hidden_sidebar']=="1") {
            ?>
            <div id="prk_hidden_bar" class="small-12">
                <div id="prk_hidden_bar_scroller">
                    <div id="prk_hidden_bar_inner" class="<?php echo hook_output().$prk_hook_options['sidebar_align']; ?>">
                        <?php
                        $hook_hidden_sidebar_id='sidebar-hidden';
                        if (get_field('hidden_sidebar_id')!="") {
                            $hook_hidden_sidebar_id=get_field('hidden_sidebar_id');
                        }
                        if (is_active_sidebar($hook_hidden_sidebar_id)) {
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar($hook_hidden_sidebar_id)) :
                            endif;
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php
                if ($prk_hook_options['sidebar_footer_id']!="" && is_active_sidebar($prk_hook_options['sidebar_footer_id'])) {
                    echo '<div id="hidden_bar_footer" class="small-12 '.esc_attr($prk_hook_options['sidebar_align']).'">';
                    if (function_exists('dynamic_sidebar') && dynamic_sidebar($prk_hook_options['sidebar_footer_id'])) :
                    endif;
                    echo '<div class="clearfix"></div></div>';
                }
                ?>
            </div>
            <?php
        }
        if ($prk_hook_options['top_search']=="1") {
            ?>
            <div id="search_hider"></div>
            <div id="searchform_top" class="top_sform_wrapper" data-url="<?php echo hook_clean_url(); ?>">
                <form method="get" class="form-search" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="sform_wrapper">
                        <input type="text" value="" name="s" id="hook_search_top" class="search-query pirenko_highlighted" placeholder="<?php echo esc_attr($hook_translated['search_tip_text']); ?>" />
                    </div>
                </form>
                <div id="top_form_close">
                    <div class="mfp-close_inner"></div>
                </div>
            </div>
            <?php
        }
        ?>
        <div id="prk_mobile_bar" class="small-12">
            <div id="prk_mobile_bar_scroller">
                <div id="prk_mobile_bar_inner" class="<?php echo esc_attr($prk_hook_options['right_bar_align']); ?>">
                    <?php
                    if ($prk_hook_options['append_mobile_logo']=="mobile_logo_bef") {
                        $hook_retina_device=hook_retiner(false);
                        if ($hook_retina_device==true && isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url']!="") {
                            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_retina']['url'],2);
                            ?>
                            <div id="hook_mobile_logo">
                                <img src="<?php echo esc_url($prk_hook_options['logo_retina']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_retina']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_retina']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
                            <?php
                        }
                        else {
                            if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url']!="") {
                                $hook_logo_dims=hook_dimensions($prk_hook_options['logo']['url'],1);
                                ?>
                                <div id="hook_mobile_logo">
                                    <img src="<?php echo esc_url($prk_hook_options['logo']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
                                <?php
                            }
                        }
                    }
                    else if ($prk_hook_options['append_mobile_logo']=="mobile_logo_aft") {
                        $hook_retina_device=hook_retiner(false);
                        if ($hook_retina_device==true && isset($prk_hook_options['logo_collapsed_retina']) && $prk_hook_options['logo_collapsed_retina']['url']!="")  {
                            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed_retina']['url'],2);
                            ?>
                            <div id="hook_mobile_logo">
                                <img src="<?php echo esc_url($prk_hook_options['logo_collapsed_retina']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed_retina']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_collapsed_retina']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
                            <?php
                        }
                        else {
                            if (isset($prk_hook_options['logo_collapsed']) && $prk_hook_options['logo_collapsed']['url']!="") {
                                $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed']['url'],1);
                                ?>
                                <div id="hook_mobile_logo">
                                    <img src="<?php echo esc_url($prk_hook_options['logo_collapsed']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_collapsed']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
                                <?php
                            }
                        }
                    }
                    //MOBILE MENU
                    if ($prk_hook_options['menu_display']!="st_without_menu") {
                        ?>
                        <div class="header_stack prk_mainer">
                            <?php
                            if (isset($page_id) && get_post_meta($page_id,'top_menu',true)!="" && get_post_meta($page_id,'top_menu',true)!="null") {
                                wp_nav_menu(array(
                                        'menu' => get_post_meta($page_id,'top_menu',true),
                                        'menu_class' => 'mobile-menu-ul '.$prk_hook_options['menu_font'],
                                        'link_after' => '',
                                        'walker' => new rc_scm_walker)
                                );
                            }
                            else {
                                if (has_nav_menu('prk_mobile_navigation')) {
                                    wp_nav_menu(array(
                                            'theme_location' => 'prk_mobile_navigation',
                                            'menu_class' => 'mobile-menu-ul '.$prk_hook_options['menu_font'],
                                            'link_after' => '',
                                            'walker' => new rc_scm_walker)
                                    );
                                }
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                    if (is_active_sidebar('sidebar-mobile')) {
                        echo '<div id="hook_mobile_sidebar" class="header_stack">';
                        if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-mobile')) :
                        endif;
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
if (!function_exists('hook_preloader')) {
    function hook_preloader() {
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        if ($prk_hook_options['preloader_style']=="theme_spinner") {
            ?>
            <div id="prk_main_loader" class="hook_spinned">
                <div id="prk_spinner">
                </div>
            </div>
            <?php
        }
        else if ($prk_hook_options['preloader_style']=="theme_default") {
            ?>
            <div id="prk_main_loader">
                <div class="rectangle-bounce">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
            <?php
        }
        else if ($prk_hook_options['preloader_style']=="theme_circles") {
            ?>
            <div id="prk_main_loader" class="loader-inner ball-triangle-path">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <?php
        }
        else if ($prk_hook_options['preloader_style']=="custom_image") {
            ?>
            <div id="prk_main_loader" class="hook_custom">
                <?php
                if ($hook_retina_device==true && isset($prk_hook_options['preloader_image_retina']) && $prk_hook_options['preloader_image_retina']['url']!="") {
                    $halfer_w=$prk_hook_options['preloader_image_retina']['width']/2;
                    $halfer_h=$prk_hook_options['preloader_image_retina']['height']/2;
                    ?>
                    <img src="<?php echo esc_url($prk_hook_options['preloader_image_retina']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['preloader_image_retina']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['preloader_image_retina']['width']); ?>" width="<?php echo esc_attr($halfer_w); ?>" height="<?php echo esc_attr($halfer_h); ?>" />
                    <?php
                }
                else {
                    if (isset($prk_hook_options['preloader_image']) && $prk_hook_options['preloader_image']['url']!="") {
                        ?>
                        <img src="<?php echo esc_url($prk_hook_options['preloader_image']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['preloader_image']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['preloader_image']['width']); ?>" width="<?php echo esc_attr($prk_hook_options['preloader_image']['width']); ?>" height="<?php echo esc_attr($prk_hook_options['preloader_image']['height']); ?>" />
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }
    }
}
function hook_get_parent_blog($hook_in_id) {
    $hook_blog_default="";
    $hook_blog_link="";
    $hook_arra=get_the_category($hook_in_id);
    $hook_cats_arr=array("");
    if($hook_arra) {
        foreach($hook_arra as $hook_s_cat) {
            array_push($hook_cats_arr,$hook_s_cat->slug);
        }
    }
    $hook_pages_blog=get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'template_blog.php',
        'hierarchical' => 0
    ));
    foreach($hook_pages_blog as $hook_single_blog) {
        $hook_blog_default=$hook_single_blog->post_id;
        if (get_field('blog_filter',$hook_single_blog->ID)!="") {
            $hook_filter=get_field('blog_filter',$hook_single_blog->ID);
            foreach ($hook_filter as $hook_child) {
                if (in_array($hook_child->slug, $hook_cats_arr)) {
                    $hook_blog_link=$hook_single_blog->ID;
                }
            }
        }
    }
    wp_reset_postdata();
    if ($hook_blog_link!="") {
        return $hook_blog_link;
    }
    else {
        return $hook_blog_default;
    }
}
//RELATED POSTS
if (!function_exists('hook_related_posts')) {
    function hook_related_posts($related_filter) {
        if (shortcode_exists('pirenko_last_posts')) {
            $prk_hook_options=hook_options();
            $hook_retina_device=hook_retiner(false);
            $hook_translated=hook_translations();
            if ($prk_hook_options['related_posts']=="0") {
                return;
            }
            $hook_terms=get_the_category($related_filter, 'post_type');
            $hook_skills_yo="";
            if (!empty($hook_terms)) {
                foreach ($hook_terms as $hook_term) {
                    $hook_skills_links[]=$hook_term->slug;
                }
                $hook_skills_yo=join(", ", $hook_skills_links);
            }
            ?>
            <div id="hook_related_posts" class="hook_center_align header_font prk_bordered_top">
                <div class="prk_inner_block columns small-centered">
                    <h4 class="zero_color prk_heavier_600 big">
                        <?php echo esc_attr($hook_translated['related_posts_text']); ?>
                    </h4>
                    <div class="small_headings_color smaller_font">
                        <?php echo esc_attr($hook_translated['related_posts_teaser_text']); ?>
                    </div>
                    <div id="hook_related_grid">
                        <?php
                        echo do_shortcode('[pirenko_last_posts general_style="classic" cat_filter="'.esc_attr($hook_skills_yo).'" items_number="3" rows_number="1" css_animation="hook_fade_waypoint" not_in="'.esc_attr($related_filter).'"]');
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
function hook_sticky_blog($hook_inner_id,$hook_inner_offset=240) {
    $prk_hook_options=hook_options();
    $hook_translated=hook_translations();
    if ($prk_hook_options['share_blog']=="1" && $prk_hook_options['persistent_blog']=="1") {
        ?>
        <div id="hook_sticky_menu" class="header_font prk_heavier_600 prk_bordered_bottom" data-offset="<?php echo esc_attr($hook_inner_offset); ?>">
            <div id="hook_sticky_inner">
                <div class="prk_lf">
                    <a href="<?php if (get_field('parent_page')!=""){echo esc_url(get_field('parent_page'));}else {echo esc_url(get_page_link(hook_get_parent_blog($hook_inner_id)));} ?>" class="hook_anchor"><i class="mdi-undo-variant"></i><?php echo esc_attr($hook_translated['to_blog']); ?></a>
                </div>
                <div class="prk_rf">
                    <?php
                    if ($prk_hook_options['share_blog_fb']=="1") {
                        ?>
                        <div class="prk_sharrre_facebook" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                        </div>
                        <?php
                    }
                    if ($prk_hook_options['share_blog_pin']=="1") {
                        if (has_post_thumbnail($hook_inner_id)) {
                            $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($hook_inner_id), 'single-post-thumbnail' );
                        }
                        else {
                            $hook_image[0]="";
                        }
                        ?>
                        <div class="prk_sharrre_pinterest" data-media="<?php echo esc_attr($hook_image[0]); ?>" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                        </div>
                        <?php
                    }
                    if ($prk_hook_options['share_blog_twt']=="1") {
                        ?>
                        <div class="prk_sharrre_twitter" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                        </div>
                        <?php
                    }
                    if ($prk_hook_options['share_blog_goo']=="1") {
                        ?>
                        <div class="prk_sharrre_google" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                        </div>
                        <?php
                    }
                    if ($prk_hook_options['share_blog_email']=="1") {
                        ?>
                        <div class="prk_sharrre_email sharrre">
                            <a class="box social_tipped" href="mailto:?Subject=<?php the_title(); ?>&Body=<?php echo get_permalink(); ?>">
                                <div class="share">
                                    <i class="hook_fa-envelope-o"></i>
                                </div>
                            </a>
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
function hook_output_share ($hook_inner_id,$hook_ps_type="blog") {
    $prk_hook_options=hook_options();
    ?>
    <div id="single_post_sharer" class="prk_sharrre_wrapper header_font">
        <div id="sharrer_inner">
            <?php
            if ($prk_hook_options['share_'.$hook_ps_type.'_fb']=="1") {
                ?>
                <div class="prk_sharrre_facebook" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                </div>
                <?php
            }
            if ($prk_hook_options['share_'.$hook_ps_type.'_pin']=="1") {
                if (has_post_thumbnail($hook_inner_id)) {
                    $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($hook_inner_id), 'single-post-thumbnail' );
                }
                else {
                    $hook_image[0]="";
                }
                ?>
                <div class="prk_sharrre_pinterest" data-media="<?php echo esc_attr($hook_image[0]); ?>" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                </div>
                <?php
            }
            if ($prk_hook_options['share_'.$hook_ps_type.'_twt']=="1") {
                ?>
                <div class="prk_sharrre_twitter" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                </div>
                <?php
            }
            if ($prk_hook_options['share_'.$hook_ps_type.'_goo']=="1") {
                ?>
                <div class="prk_sharrre_google" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                </div>
                <?php
            }
            if ($prk_hook_options['share_'.$hook_ps_type.'_email']=="1") {
                ?>
                <div class="prk_sharrre_email sharrre">
                    <a href="mailto:?Subject=<?php echo get_the_title(); ?>&Body=<?php echo get_permalink(); ?>">
                        <div class="share">
                            <?php esc_html_e('Email','hook'); ?>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php
}

function hook_output_title() {
    global $post;
    $prk_hook_options=hook_options();
    $hook_translated=hook_translations();
    if ($prk_hook_options['titles_font']=="") {
        $prk_hook_options['titles_font']='header_font';
    }
    if (get_field('header_align')=="") {
        $hook_header_align=$prk_hook_options['headings_align'];
    }
    else {
        $hook_header_align=get_field('header_align');
    }
    echo '<div id="headings_wrap" class="'.$hook_header_align.' zero_color">';
    echo '<div id="single_page_title">';
    if (is_page()) {
        ?>
        <h1 class="<?php echo esc_attr($prk_hook_options['titles_font']); ?>">
            <?php the_title(); ?>
        </h1>
        <?php
        if (get_field('below_headings_text')!="") {
            echo '<div id="single_page_teaser" class="smaller_font prk_heavier_500 small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-color="'.esc_attr(get_field('below_headings_color')).'">'.esc_attr(get_field('below_headings_text')).'</div>';
            echo '<div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
        }
    }
    elseif (is_front_page()) {
        echo '<h1 class="'.esc_attr($prk_hook_options['titles_font']).'">'.esc_attr(get_bloginfo('name')).'</h1>';
        echo '<div id="single_page_teaser" class="smaller_font prk_heavier_500 small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">'.esc_attr(get_bloginfo('description')).'</div>';
        echo '<div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
    }
    if (HOOK_WOO_ON=="true" && is_woocommerce()) {
        ?>
        <h1 class="<?php echo esc_attr($prk_hook_options['titles_font']); ?>">
            <?php
            if (is_product_category() || is_product_tag()) {
                single_term_title();
            }
            else {
                echo get_the_title(wc_get_page_id('shop'));
            }
            ?>
        </h1>
        <?php
        if ($prk_hook_options['woo_subheading']!="" && !is_product_category() && !is_product_tag()) {
            echo '<div id="single_page_teaser" class="smaller_font prk_heavier_500 small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'" data-color="'.esc_attr(get_field('below_headings_color')).'">'.esc_attr($prk_hook_options['woo_subheading']).'</div>';
            echo '<div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
        }
    }
    else {
        if (is_archive()) {
            $hook_pagettl="";
            $hook_teaser='<div id="single_page_teaser" class="smaller_font small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">'.esc_attr($hook_translated['all_the_posts']).'</div><div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
            if (is_category())
            {
                $hook_pagettl=single_cat_title('',FALSE);
            }
            elseif(is_tag())
            {
                $hook_pagettl=single_tag_title('',FALSE);
            }
            elseif (is_day())
            {
                $hook_pagettl=get_the_time('F jS, Y');
            }
            elseif (is_month())
            {
                $hook_pagettl=get_the_time('F, Y');
            }
            elseif (is_year())
            {
                $hook_pagettl=get_the_time('Y');
            }
            elseif (is_author())
            {
                $hook_pagettl=get_the_author();
                if (get_the_author_meta('prk_subheading')!="") {
                    $hook_teaser='<div id="single_page_teaser" class="smaller_font small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">'.esc_attr(get_the_author_meta('prk_subheading')).'</div><div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
                }
            }
            elseif (get_post_type()=="pirenko_portfolios") {
                $hook_pagettl=single_cat_title('',FALSE);
                $hook_teaser='<div id="single_page_teaser" class="smaller_font small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">'.esc_attr($hook_translated['all_the_portfolios']).'</div><div id="hook_heading_line" class="simple_line prk_bordered_bottom"></div>';
            }
            echo '<h1 class="'.esc_attr($prk_hook_options['titles_font']).'">';
            echo hook_output().$hook_pagettl;
            echo '</h1>';
            echo hook_output().$hook_teaser;
        }
    }
    echo '</div>';
    echo '<div class="clearfix"></div>';
    echo '</div>';
}
function hook_jquery_send() {
    $prk_hook_options=hook_options();
    if (isset($prk_hook_options['js_text']) && $prk_hook_options['js_text']!="") {
        echo '<script type="text/javascript">';
        echo hook_output().$prk_hook_options['js_text'];
        echo '</script>';
    }
}
//FUNCTION TO CHECK IF PATH CONTAINS SOCIAL MEDIA
function hook_external_content ($hook_stringa) {
    if (preg_match('/(\.jpg|\.png|\.bmp)$/', $hook_stringa)) {
        return "other";
    } elseif (strpos($hook_stringa, "youtube.com") !== false) {
        return "youtube";
    } elseif (strpos($hook_stringa, "youtu.be") !== false) {
        return "youtube";
    } elseif (strpos($hook_stringa, "vimeo.com") !== false) {
        return "vimeo";
    } elseif (strpos($hook_stringa, "wistia.com") !== false) {
        return "wistia";
    } elseif (strpos($hook_stringa, "wistia.net") !== false) {
        return "wistia";
    } elseif (strpos($hook_stringa, "soundcloud.com") !== false) {
        return "soundcloud";
    } else {
        return "other";
    }
}
//FUNCTION TO GET IMAGES PATH ON MULTISITE WORDPRESS INSTALLATIONS
function hook_image_path ($hook_src) {
    global $blog_id;
    if(isset($blog_id) && $blog_id > 0)
    {
        $hook_imageParts=explode('/files/' , $hook_src);
        if(isset($hook_imageParts[1]))
        {
            $hook_src='/blogs.dir/'.$blog_id.'/files/'.$hook_imageParts[1];
        }
    }
    return $hook_src;
}
function hook_youtube_url ($hook_text) {
    $hook_text=preg_replace('~
            # Match non-linked youtube URL in the wild. (Rev:20130823)
            https?://         # Required scheme. Either http or https.
            (?:[0-9A-Z-]+\.)? # Optional subdomain.
            (?:               # Group host alternatives.
              youtu\.be/      # Either youtu.be,
            | youtube\.com    # or youtube.com followed by
              \S*             # Allow anything up to VIDEO_ID,
              [^\w\-\s]       # but char before ID is non-ID char.
            )                 # End host alternatives.
            ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
            (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
            (?!               # Assert URL is not pre-linked.
              [?=&+%\w.-]*    # Allow URL (query) remainder.
              (?:             # Group pre-linked alternatives.
                [\'"][^<>]*>  # Either inside a start tag,
              | </a>          # or inside <a> element text contents.
              )               # End recognized pre-linked alts.
            )                 # End negative lookahead assertion.
            [?=&+%\w.-]*        # Consume any URL (query) remainder.
            ~ix',
        '$1',
        $hook_text);
    return $hook_text;
}
function hook_get_iframe_src($hook_raw_content) {
    if ($hook_raw_content!="") {
        if (class_exists('DOMDocument')) {
            $hook_document=new DOMDocument();
            libxml_use_internal_errors(true);
            $hook_document->loadHTML($hook_raw_content);
            libxml_use_internal_errors(false);
            if (is_object($hook_document->getElementsByTagName('iframe')->item(0))){
                $hook_src=$hook_document->getElementsByTagName('iframe')->item(0)->getAttribute('src');
            }
            else {
                return "Wrong Video Code.";
            }
            if (hook_external_content($hook_raw_content)=="youtube") {
                if (substr($hook_src,0,2)=="//")
                    $hook_src="http:".$hook_src;
                return "http://www.youtube.com/watch?v=".hook_youtube_url($hook_src);
            }
            if (hook_external_content($hook_raw_content)=="vimeo") {
                return $hook_src;
            }
            if (hook_external_content($hook_raw_content)=="wistia") {
                return $hook_src;
            }
            if (hook_external_content($hook_raw_content)=="dailymotion") {
                return $hook_src;
            }
            if (hook_external_content($hook_raw_content)=="soundcloud") {
                return $hook_src;
            }
        }
        else {
            return "DOMDocument class is OFF. Please reach your host to activate it!";
        }
    }
    else
    {
        return "No Content Is Set";
    }
}

function hook_comment($comment, $args, $depth) {
    $prk_hook_options=hook_options();
    $hook_translated=hook_translations();
    $GLOBALS['comment']=$comment; ?>
    <li <?php comment_class(); ?>>
    <div id="comment-<?php comment_ID(); ?>" class="clearfix single_comment">
        <header class="comment-author vcard">
            <?php echo hook_output().get_avatar($comment, $size='120'); ?>
        </header>
        <div class="comment_floated">
            <div class="comments_meta_wrapper header_font">
                <?php printf(wp_kses( __('<div class="zero_color author_name small-12 prk_heavier_600">%s</div>', 'hook'),array('div' => array('class'=>array()))), get_comment_author_link()); ?>
                <time datetime="<?php echo comment_date('c'); ?>" class="comment_date prk_lf small_headings_color prk_heavier_500">
                    <?php
                    echo hook_output().get_comment_date()." @ ".get_comment_time();
                    ?>
                </time>
                <div class="pir_divider_cmts prk_lf small_headings_color"><?php echo esc_attr($prk_hook_options['theme_divider']); ?></div>
                <div class="prk_lf not_zero_color prk_heavier_600">
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => $hook_translated['reply_text']))); ?>
                </div>
            </div>
            <?php if ($comment->comment_approved == '0') { ?>
                <div class="alert alert-block fade in">
                    <a class="close" data-dismiss="alert">&times;</a>
                    <p><?php esc_html_e('Your comment is awaiting moderation.', 'hook'); ?></p>
                </div>
            <?php } ?>
            <div class="comment comment_text prk_lf">
                <?php comment_text() ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}

//VARIABLE SIZE EXCERPT FUNCTION
function hook_excerpt_dynamic($hook_length,$hook_post_id) {
    global $post;
    $hook_temp=$post;
    $post=get_post($hook_post_id);
    setup_postdata($post);
    if (has_excerpt()) {
        wp_reset_postdata();
        $post=$hook_temp;
        return '<p>'.get_the_excerpt().'</p>';
    }
    else {
        $hook_excerpeter=get_post($hook_post_id);
        $hook_text=$hook_excerpeter->post_excerpt;
        if (''== $hook_text )
        {
            $hook_text=$hook_excerpeter->post_content;
            if (strpos($hook_text,'<!--more-->') !== false) {
                $hook_text=substr($hook_text,0,strpos($hook_text,'<!--more-->'));
            }
            else {
                $hook_text='';
            }
        }
        if (''== $hook_text )
        {
            $hook_text=get_the_content('');
            $hook_text=apply_filters('the_content', $hook_text);
            $hook_text=str_replace(']]>', ']]>', $hook_text);
        }
        if (strpos($hook_text,'<!--more-->') !== false) {
            $hook_text=substr($hook_text,0,strpos($hook_text,'<!--more-->'));
        }
        $hook_text=strip_shortcodes( $hook_text );
        $hook_text=strip_tags($hook_text);
        $hook_text=preg_replace( "/\s+/", " ", $hook_text );
        $hook_output="";
        $hook_words=explode( " ", $hook_text );
        $hook_words_num=count( $hook_words );
        for ( $i=0; ( $i < $hook_length ) && ( $i < $hook_words_num ); $i++ ) {
            $hook_output .= $hook_words[$i];
            if ( $i < $hook_length - 1) {
                $hook_output .= " ";
            } else {
                $hook_output .= ' ...';
            }
        }
        return apply_filters('the_excerpt',$hook_output);
    }
}
//CHECK IF EXCERPT IS LARGER THAN POST TEXT
function hook_is_big_excerpt($hook_length,$hook_post_id) {
    global $post;
    $hook_temp=$post;
    $post=get_post($hook_post_id);
    setup_postdata($post);
    $hook_text=$post->post_content;
    if (''== $hook_text )
    {
        $hook_text=get_the_content('');
        $hook_text=apply_filters('the_content', $hook_text);
        $hook_text=str_replace(']]>', ']]>', $hook_text);
    }
    if (strpos($hook_text,'<!--more-->') !== false) {
        return true;
    }
    $hook_text=$post->excerpt;
    if (''== $hook_text )
    {
        $hook_text=get_the_content('');
        $hook_text=apply_filters('the_content', $hook_text);
        $hook_text=str_replace(']]>', ']]>', $hook_text);
    }
    $hook_text=strip_shortcodes( $hook_text );
    $hook_text=strip_tags($hook_text);
    $hook_text=preg_replace( "/\s+/", " ", $hook_text );
    $hook_words=explode( " ", $hook_text );
    $hook_words_num=count( $hook_words );
    wp_reset_postdata();
    $post=$hook_temp;
    if ($hook_words_num>$hook_length)
        return true;
    else
        return false;
}

if (!function_exists('hook_attachment_id')) {
    function hook_attachment_id( $hook_url ) {
        $hook_attachment_id="EMPTY";
        $hook_dir=wp_upload_dir();
        if ( false !== strpos( $hook_url, $hook_dir['baseurl'].'/' ) ) {
            $hook_file=basename( $hook_url );
            $hook_query_args=array(
                'post_type'   => 'attachment',
                'post_status' => 'inherit',
                'fields'      => 'ids',
                'meta_query'  => array(
                    array(
                        'value'   => $hook_file,
                        'compare' => 'LIKE',
                        'key'     => '_wp_attachment_metadata',
                    ),
                )
            );
            $hook_query=new WP_Query( $hook_query_args );
            if ( $hook_query->have_posts() ) {
                foreach ( $hook_query->posts as $hook_post_id ) {
                    $hook_meta=wp_get_attachment_metadata( $hook_post_id );
                    $hook_original_file=basename( $hook_meta['file'] );
                    $hook_cropped_image_file=wp_list_pluck( $hook_meta['sizes'], 'file' );
                    if ( $hook_original_file === $hook_file || in_array( $hook_file, $hook_cropped_image_file ) ) {
                        $hook_attachment_id=$hook_post_id;
                        break;
                    }
                }
            }
        }
        return $hook_attachment_id;
    }
}

if (!function_exists('hook_alt_tag')) {
    function hook_alt_tag($hook_id_flag,$hook_img_path) {
        if ($hook_id_flag==false) {
            $hook_img_id=hook_attachment_id($hook_img_path);
            if ($hook_img_id!="EMPTY") {
                $hook_alt_text=get_post_meta($hook_img_id, '_wp_attachment_image_alt', true);
                return $hook_alt_text;
            }
            else {
                return "Image Not Found On Media Library";
            }
        }
        else {
            $hook_alt_text=get_post_meta($hook_img_path, '_wp_attachment_image_alt', true);
            return $hook_alt_text;
        }
    }
}

if (!function_exists('hook_retiner')) {
    function hook_retiner($hook_test_flag) {
        global $hook_retina_device;
        if ($hook_test_flag==true) {
            $hook_detect=new Mobile_Detect;
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

if (!(function_exists('hook_logo'))) {
    function hook_logo() {
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(false);
        $hook_before_logo=false;
        $hook_after_logo=false;
        $hook_output_logo='<a id="hook_home_link" href="'.home_url('/').'" class="hook_anchor"><div id="hook_logos_wrapper">';
        if ($hook_retina_device==true && isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url']!="") {
            $hook_before_logo=true;
            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_retina']['url'],2);
            $hook_output_logo.='<div id="hook_logo_before"><img src="'.esc_url($prk_hook_options['logo_retina']['url']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo_retina']['url'])).'" data-width="'.esc_attr(ceil($prk_hook_options['logo_retina']['width']/2)).'" '.$hook_logo_dims.' /></div>';
        }
        else {
            if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url']!="") {
                $hook_before_logo=true;
                $hook_logo_dims=hook_dimensions($prk_hook_options['logo']['url'],1);
                $hook_output_logo.='<div id="hook_logo_before"><img src="'.esc_url($prk_hook_options['logo']['url']).'" data-width="'.esc_attr($prk_hook_options['logo']['width']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo']['url'])).'" '.$hook_logo_dims.' /></div>';
            }
        }
        if ($hook_retina_device==true && isset($prk_hook_options['logo_collapsed_retina']) && $prk_hook_options['logo_collapsed_retina']['url']!="")  {
            $hook_after_logo=true;
            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed_retina']['url'],2);
            $hook_output_logo.='<div id="hook_logo_after"><img src="'.esc_url($prk_hook_options['logo_collapsed_retina']['url']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed_retina']['url'])).'" data-width="'.esc_attr(ceil($prk_hook_options['logo_collapsed_retina']['width']/2)).'" '.$hook_logo_dims.' /></div>';
        }
        else {
            if (isset($prk_hook_options['logo_collapsed']) && $prk_hook_options['logo_collapsed']['url']!="") {
                $hook_after_logo=true;
                $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed']['url'],1);
                $hook_output_logo.='<div id="hook_logo_after"><img src="'.$prk_hook_options['logo_collapsed']['url'] .'" data-width="'.esc_attr($prk_hook_options['logo_collapsed']['width']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed']['url'])).'" '.$hook_logo_dims.' /></div>';
            }
        }
        if ($hook_before_logo==true && $hook_after_logo==false) {
            if ($hook_retina_device==true && isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url']!="") {
                $hook_logo_dims=hook_dimensions($prk_hook_options['logo_retina']['url'],2);
                $hook_output_logo.='<div id="hook_logo_after"><img src="'.esc_url($prk_hook_options['logo_retina']['url']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo_retina']['url'])).'" data-width="'.esc_attr(ceil($prk_hook_options['logo_retina']['width']/2)).'" '.$hook_logo_dims.' /></div>';
            }
            else
            {
                if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url']!="")
                {
                    $hook_logo_dims=hook_dimensions($prk_hook_options['logo']['url'],1);
                    $hook_output_logo.='<div id="hook_logo_after"><img src="'.$prk_hook_options['logo']['url'] .'" data-width="'.esc_attr($prk_hook_options['logo']['width']).'" alt="'.esc_attr(hook_alt_tag(false,$prk_hook_options['logo']['url'])).'" '.$hook_logo_dims.' /></div>';
                }
            }
        }
        $hook_output_logo.='</div></a>';
        return hook_output().$hook_output_logo;
    }
}

function hook_html2rgba($hook_color,$hook_alpha) {
    if (!isset($hook_color) || $hook_color=="") {
        return;
    }
    if ($hook_color[0] == '#')
        $hook_color=substr($hook_color, 1);
    if (strlen($hook_color) == 6)
        list($hook_r, $hook_g, $hook_b)=array($hook_color[0].$hook_color[1],$hook_color[2].$hook_color[3],$hook_color[4].$hook_color[5]);
    elseif (strlen($hook_color) == 3)
        list($hook_r, $hook_g, $hook_b)=array($hook_color[0].$hook_color[0], $hook_color[1].$hook_color[1], $hook_color[2].$hook_color[2]);
    else
        return false;
    $hook_r=hexdec($hook_r);
    $hook_g=hexdec($hook_g);
    $hook_b=hexdec($hook_b);
    $hook_alpha=floatval($hook_alpha/100);
    return "rgba(".$hook_r.", ".$hook_g.", ".$hook_b." ,". $hook_alpha.")";
}

add_action( 'after_setup_theme', 'hook_theme_slug_setup' );
function hook_theme_slug_setup() {
    add_theme_support( 'title-tag' );
}

function hook_includeTrailingCharacter($hook_string, $hook_character) {
    if (strlen($hook_string) > 0) {
        if (substr($hook_string, -1) !== $hook_character) {
            return $hook_string.$hook_character;
        } else {
            return $hook_string;
        }
    } else {
        return $hook_character;
    }
}
function hook_clean_url() {
    $hook_clean_url=get_search_link('remove');
    if (strpos($hook_clean_url,'/?') == true) {
        $hook_clean_url=substr($hook_clean_url, 0, strpos($hook_clean_url, "=")+1);
    }
    else {
        $hook_clean_url=dirname($hook_clean_url);
        $hook_clean_url=hook_includeTrailingCharacter($hook_clean_url,'/');
    }
    return $hook_clean_url;
}

add_theme_support( 'automatic-feed-links' );

//PASSWORD PROTECTED PAGES
add_filter( 'the_password_form', 'hook_password_form' );
if (!function_exists('hook_password_form')) {
    function hook_password_form() {
        global $post;
        $label='pwbox-'.( empty($post->ID) ? rand() :$post->ID);
        $hook_output='<div id="prk_protected" class="columns twelve centered prk_inner_block">';
        $hook_output.= '<form class="post-password-form" action="'.get_option('siteurl').'/wp-login.php?action=postpass" method="post">';
        $hook_output.= esc_html__( "This content is password protected. To view it please enter your password below:",'hook' );
        $hook_output.='<div class="clearfix"></div>';
        $hook_output.='<label for="'.$label.'">'.esc_html__( "Password:",'hook' );
        $hook_output.='<div class="clearfix"></div>';
        $hook_output.='<input name="post_password" id="'.$label.'" type="password" class="prk_pass pirenko_highlighted" />';
        $hook_output.='</label>';
        $hook_output.='<div class="clearfix"></div>';
        $hook_output.='<div class="theme_button">';
        $hook_output.='<input type="submit" name="Submit" value="'.esc_html__( "Submit",'hook' ).'" class="prk_submit_pass" />';
        $hook_output.='</div>';
        $hook_output.='</form>';
        $hook_output.='</div>';
        return $hook_output;
    }
}

//SEARCH PAGE NAVIGATION
if (!function_exists('hook_paging_nav')) {
    function hook_paging_nav() {
        $hook_translated=hook_translations();
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }
        $hook_paged=get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $hook_pagenum_link=html_entity_decode( get_pagenum_link() );
        $hook_query_args=array();
        $hook_url_parts=explode( '?',$hook_pagenum_link );

        if ( isset( $hook_url_parts[1] ) ) {
            wp_parse_str( $hook_url_parts[1], $hook_query_args );
        }

        $hook_pagenum_link=remove_query_arg( array_keys( $hook_query_args ), $hook_pagenum_link );
        $hook_pagenum_link=trailingslashit( $hook_pagenum_link ).'%_%';

        $hook_format =$GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $hook_pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $hook_format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        $hook_links=paginate_links( array(
            'base'     => $hook_pagenum_link,
            'format'   => $hook_format,
            'total'    => $GLOBALS['wp_query']->max_num_pages,
            'current'  => $hook_paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $hook_query_args ),
            'prev_text' => $hook_translated['previous_text'],
            'next_text' => $hook_translated['next_text'],
        ) );

        if ( $hook_links ){
            ?>
            <div class="hook_paging_navigation">
                <div class="pagination loop-pagination prk_minimal_button hook_anchor header_font body_colored">
                    <?php echo hook_output().$hook_links; ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
        }
    }
}
if(function_exists("register_field_group")) {
//RETRIEVE MENUS
    $hook_menus = get_terms('nav_menu', array('hide_empty' => false));
    $hook_menus_array = array();
    if (!empty($hook_menus)) {
        foreach ($hook_menus as $key => $entry) {
            $hook_menus_array[$entry->term_id] = $entry->name;
        }
    } else {
        $hook_menus_array[1] = "No menus found";
    }
//REGULAR PAGE
    register_field_group(array(
        'id' => 'acf_theme-regular-page',
        'title' => 'Page Options',
        'fields' => array(
            array(
                'key' => 'field_3489bc7sepasd',
                'label' => 'Sidebar',
                'name' => 'separa_sd',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_5289f34e96143',
                'label' => 'Sidebar display',
                'name' => 'show_sidebar',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default option',
                    'yes' => 'Show Sidebar',
                    'no' => 'Hide Sidebar',
                ),
                'default_value' => 'default',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_537f6d97eaa59',
                'label' => 'Right custom sidebar selector',
                'name' => 'right_sidebar_id',
                'type' => 'sidebar_selector',
                'instructions' => 'Leave blank for default sidebar',
                'allow_null' => 1,
                'default_value' => '',
            ),
            array(
                'key' => 'field_3489bc7sepamn',
                'label' => 'Navigation',
                'name' => 'separa_menu',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_3489bc7a87421',
                'label' => 'Top Menu',
                'name' => 'top_menu',
                'type' => 'select',
                'instructions' => 'Select a custom menu if needed',
                'choices' => $hook_menus_array,
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528b759483aab',
                'label' => 'Hide menu and navigate using fixed-position rectangles?',
                'name' => 'dots_navigation',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528b759ea4be8',
                'label' => 'Menu display - Show content behind the menu?',
                'name' => 'featured_header',
                'type' => 'true_false',
                'message' => 'With this option selected the menu will have before and after scroll states',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_3489bc7sepasl',
                'label' => 'Featured Slider',
                'name' => 'separa_sl',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_5289fd554dc9f',
                'label' => 'Display featured slider above the content?',
                'name' => 'featured_slider',
                'type' => 'select',
                'choices' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_5289fd5animas',
                'label' => 'Featured slider animation type?',
                'name' => 'featured_slider_anim',
                'type' => 'select',
                'choices' => array(
                    'slide' => 'Slide',
                    'fade' => 'Simple fade',
                    'fadeUp' => 'Fade and scale',
                    'goDown' => 'Go Down',
                    'backSlide' => 'Back Slide',
                ),
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'slide',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_5noizlimitado',
                'label' => 'Limit slider width?',
                'name' => 'limited_slider',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a111ea4be8',
                'label' => 'Force slider height to be the same as window height?',
                'name' => 'featured_slider_supersize',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528c309ea4be8',
                'label' => 'Use parallax effect on slider?',
                'name' => 'featured_slider_parallax',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a998ea4be8',
                'label' => 'Append navigation arrows to slider?',
                'name' => 'featured_slider_arrows',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_528b749ea4be8',
                'label' => 'Append navigation dots to slider?',
                'name' => 'featured_slider_dots',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a9tuvlobe8',
                'label' => 'Append scroll down arrow to slider?',
                'name' => 'featured_slider_down_arrow',
                'type' => 'true_false',
                'instructions' => 'Will scroll to the first row of the page content',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_abhd02acbcosta',
                'label' => 'Scroll down arrow color',
                'name' => 'featured_arrow_color',
                'type' => 'color_picker',
                'instructions' => '(optional)',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                        array(
                            'field' => 'field_528a9tuvlobe8',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a340ea4be8',
                'label' => 'Autoplay slideshow?',
                'name' => 'featured_slider_autoplay',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_5289fd55order',
                'label' => 'Slides order?',
                'name' => 'order',
                'type' => 'select',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'choices' => array(
                    'date' => 'Date published',
                    'rand' => 'Random',
                ),
                'default_value' => 'date',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a9233a4be9',
                'label' => 'Slideshow delay in miliseconds',
                'name' => 'featured_slider_delay',
                'type' => 'number',
                'required' => 1,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                        array(
                            'field' => 'field_528a340ea4be8',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 6000,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => 500,
            ),
            array(
                'key' => 'field_52aafdefb25ac',
                'label' => 'Slide groups to be displayed',
                'name' => 'slide_filter',
                'type' => 'taxonomy',
                'instructions' => 'Leave blank for all',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fd554dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'taxonomy' => 'pirenko_slide_set',
                'field_type' => 'checkbox',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array(
                'key' => 'field_3489bc7sepatt',
                'label' => 'Title Display',
                'name' => 'separa_tt',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a450ceab386',
                'label' => 'Show page title?',
                'name' => 'show_title',
                'type' => 'select',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'default_value' => 'yes',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a45c387439',
                'label' => 'Title alignment',
                'name' => 'header_align',
                'type' => 'select',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450ceab386',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'choices' => array(
                    'hook_center_align' => 'Center',
                    'hook_left_align' => 'Left',
                    'hook_right_align' => 'Right',
                ),
                'default_value' => 'hook_center_align',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_567a732cef5cd',
                'label' => 'Uppercase page title?',
                'name' => 'uppercase_title',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 1,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450ceab386',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
            array(
                'key' => 'field_528d875acc438',
                'label' => 'Sub-heading text',
                'name' => 'below_headings_text',
                'type' => 'textarea',
                'instructions' => 'Will be displayed under the page title',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450ceab386',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'formatting' => 'br',
            ),
            array(
                'key' => 'field_111049fus81813',
                'label' => 'Sub-heading text color',
                'name' => 'below_headings_color',
                'type' => 'color_picker',
                'instructions' => '(optional)',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_529376017080b',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                        array(
                            'field' => 'field_528d875acc438',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a4pgcfutre',
                'label' => 'Hide footer?',
                'name' => 'hide_footer',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'default',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'custom_fields',
            ),
        ),
        'menu_order' => 0,
    ));

//COMING SOON PAGE
    register_field_group(array(
        'id' => 'acf_theme-coming-soon-options',
        'title' => 'Coming Soon Page Options',
        'fields' => array(
            array(
                'key' => 'field_5287imazutce8',
                'label' => 'Background image',
                'name' => 'image_back',
                'type' => 'image',
                'instructions' => '',
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878acb8text',
                'label' => 'Countdown Text color',
                'name' => 'text_color',
                'type' => 'color_picker',
                'instructions' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_54d4a0b3fbeze',
                'label' => 'Launch date',
                'name' => 'launch_date',
                'type' => 'date_picker',
                'date_format' => 'yymmdd',
                'display_format' => 'dd/mm/yy',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_528d875aextra',
                'label' => 'Extra text',
                'name' => 'below_headings_text',
                'type' => 'textarea',
                'instructions' => 'Will be displayed on the bottom of the page',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'formatting' => 'br',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-coming-soon.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'custom_fields',
            ),
        ),
        'menu_order' => 0,
    ));

//BLOG PAGE
    register_field_group(array(
        'id' => 'acf_theme-classic-blog-page-options',
        'title' => 'Theme Blog Page Options',
        'fields' => array(
            array(
                'key' => 'field_528a44csepasd',
                'label' => 'Sidebar',
                'name' => 'separa_sd',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a44c30297d',
                'label' => 'Sidebar display',
                'name' => 'show_sidebar',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default option',
                    'yes' => 'Show Sidebar',
                    'no' => 'Hide Sidebar',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_398a6d97eaa59',
                'label' => 'Right custom sidebar selector',
                'name' => 'right_sidebar_id',
                'type' => 'sidebar_selector',
                'instructions' => 'Leave blank for default sidebar',
                'allow_null' => 1,
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a44csepamn',
                'label' => 'Navigation',
                'name' => 'separa_mn',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_528b759eblogy',
                'label' => 'Menu display - Show content behind the menu?',
                'name' => 'featured_header',
                'type' => 'true_false',
                'message' => 'With this option selected the menu will have before and after scroll states',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a44csepaap',
                'label' => 'Appearance',
                'name' => 'separa_ap',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_52878acb8pagy',
                'label' => 'Page Background Color',
                'name' => 'featured_color',
                'type' => 'color_picker',
                'instructions' => '(optional)',
                'default_value' => '',
            ),
            array(
                'key' => 'field_8320f34e12389',
                'label' => 'General layout',
                'name' => 'blog_layout',
                'type' => 'select',
                'choices' => array(
                    'classic' => 'Classic - Big media with post information always visible',
                    'grid' => 'Image grid - Image focused with info displayed on rollover',
                    'masonry' => 'Masonry - Mosaic with post information always visible',
                    'stacked' => 'Modern - Plain text with post information always visible',
                    'split' => 'Split - Stacked posts with featured media',
                ),
                'default_value' => 'masonry',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_734590c0limit',
                'label' => 'Limit content width?',
                'name' => 'limit_width',
                'instructions' => 'Applies only when sidebar is hidden',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 1,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '!=',
                            'value' => 'panels',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
            array(
                'key' => 'field_8320f34a75mim',
                'label' => 'Thumbnails shape',
                'name' => 'grid_layout',
                'type' => 'select',
                'choices' => array(
                    'grid' => 'Grid with horizontal rectangular images',
                    'grid_vertical' => 'Grid with vertical rectangular images',
                    'squares' => 'Grid with squared images',
                    'masonry' => 'Grid without image crop (masonry)',
                ),
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'grid',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'masonry',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_8320ftracymim',
                'label' => 'Thumbnails margin',
                'name' => 'thumbs_margin',
                'type' => 'number',
                'required' => 0,
                'default_value' => 0,
                'placeholder' => '0',
                'prepend' => '',
                'append' => '',
                'min' => 0,
                'max' => '',
                'step' => '',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'grid',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 'masonry',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_734590c06prim',
                'label' => 'Make first post featured?',
                'name' => 'feature_first',
                'type' => 'true_false',
                'message' => 'Will force first post to have 100% width',
                'default_value' => 0,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'grid',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
            array(
                'key' => 'field_8320f34anueva',
                'label' => 'Text alignment',
                'name' => 'grid_align',
                'type' => 'select',
                'choices' => array(
                    'hook_center_align' => 'Center',
                    'hook_left_align' => 'Left',
                    'hook_right_align' => 'Right',
                ),
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'classic',
                        ),
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'stacked',
                        ),
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'grid',
                        ),
                        array(
                            'field' => 'field_8320f34e12389',
                            'operator' => '==',
                            'value' => 'split',
                        ),
                    ),
                    'allorany' => 'any',
                ),
                'default_value' => 'hook_left_align',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a468dd6bfa',
                'label' => 'Blog categories to be displayed',
                'name' => 'blog_filter',
                'type' => 'taxonomy',
                'instructions' => 'Leave blank for all',
                'taxonomy' => 'category',
                'field_type' => 'checkbox',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array(
                'key' => 'field_734590c0624fc',
                'label' => 'Show categories filter above thumbnails?',
                'name' => 'show_filter',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a45bdca439',
                'label' => 'Filter alignment',
                'name' => 'filter_align',
                'type' => 'select',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_734590c0624fc',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'choices' => array(
                    'filter_left' => 'Left',
                    'filter_center' => 'Center',
                    'filter_right' => 'Right',
                ),
                'default_value' => 'filter_center',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_519c65c30297d',
                'label' => 'Posts Navigation display?',
                'name' => 'navigation_type',
                'instructions' => 'How the page handles loading more posts.',
                'type' => 'select',
                'choices' => array(
                    'ajaxed' => 'Show load more posts button',
                    'paginated' => 'Show page navigation with arrows',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a4blcfutre',
                'label' => 'Hide footer?',
                'name' => 'hide_footer',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a44csepasl',
                'label' => 'Featured Slider',
                'name' => 'separa_sl',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_5289fzzz7dc9f',
                'label' => 'Display featured slider before the page content?',
                'name' => 'featured_slider',
                'type' => 'select',
                'choices' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528cglimitado',
                'label' => 'Limit slider width?',
                'name' => 'limited_slider',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_528cgh34a4be8',
                'label' => 'Use parallax effect?',
                'name' => 'featured_slider_parallax',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528xxxaea4be8',
                'label' => 'Append navigation arrows to slider?',
                'name' => 'featured_slider_arrows',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_528b749eaiiif',
                'label' => 'Append navigation dots to slider?',
                'name' => 'featured_slider_dots',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_528a340eauuua',
                'label' => 'Autoplay slideshow?',
                'name' => 'featured_slider_autoplay',
                'type' => 'true_false',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'message' => '',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_528akukaa4be9',
                'label' => 'Slideshow delay in miliseconds',
                'name' => 'featured_slider_delay',
                'type' => 'number',
                'required' => 1,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                        array(
                            'field' => 'field_528a340ea4be8',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => 6000,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => 500,
            ),
            array(
                'key' => 'field_99f2fdefb25ac',
                'label' => 'Slide groups to be displayed',
                'name' => 'slide_filter',
                'type' => 'taxonomy',
                'instructions' => 'Leave blank for all',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_5289fzzz7dc9f',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'taxonomy' => 'pirenko_slide_set',
                'field_type' => 'checkbox',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a44csepatt',
                'label' => 'Title Display',
                'name' => 'separa_tt',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_528a450cef5cd',
                'label' => 'Hide page title?',
                'name' => 'hide_title',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_999b333cef5cd',
                'label' => 'Uppercase page title?',
                'name' => 'uppercase_title',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 1,
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450cef5cd',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
            array(
                'key' => 'field_528a45accc439',
                'label' => 'Title alignment',
                'name' => 'header_align',
                'type' => 'select',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450cef5cd',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'choices' => array(
                    'hook_center_align' => 'Center',
                    'hook_left_align' => 'Left',
                    'hook_right_align' => 'Right',
                ),
                'default_value' => 'hook_center_align',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_528a457acc438',
                'label' => 'Sub-heading text',
                'name' => 'below_headings_text',
                'type' => 'textarea',
                'instructions' => 'Will be displayed under the page title',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_528a450cef5cd',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'formatting' => 'br',
            ),
            array(
                'key' => 'field_111002hus81813',
                'label' => 'Sub-heading text color',
                'name' => 'below_headings_color',
                'type' => 'color_picker',
                'instructions' => '(optional)',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_529376017080b',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                        array(
                            'field' => 'field_528a457acc438',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template_blog.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'custom_fields',
            ),
        ),
        'menu_order' => 0,
    ));

//BLOG POSTS OPTIONS
    register_field_group(array(
        'id' => 'acf_theme-post-options',
        'title' => 'Theme Post Options',
        'fields' => array(
            array(
                'key' => 'field_5289f65sepasd',
                'label' => 'Sidebar',
                'name' => 'separa_sd',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_5289f65e96143',
                'label' => 'Sidebar display',
                'name' => 'show_sidebar',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default option',
                    'yes' => 'Show Sidebar',
                    'no' => 'Hide Sidebar',
                ),
                'default_value' => 'default',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_5289f65csepaap',
                'label' => 'Appearance',
                'name' => 'separa_ap',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_528b759eafull',
                'label' => 'Post layout?',
                'name' => 'featured_header',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default - Post content will be shown under the menu',
                    'featured' => 'Featured header - Post content will be shown behind the menu',
                    'featured_100' => 'Featured header with forced height - Post content will be shown behind the menu and featured image will have 100% of screen height',
                ),
                'message' => 'The featured image will appear behind the menu',
                'default_value' => 'default',
            ),
            array(
                'key' => 'field_52878acb81813',
                'label' => 'Featured Color',
                'name' => 'featured_color',
                'type' => 'color_picker',
                'instructions' => '(optional)',
                'default_value' => '',
            ),
            array(
                'key' => 'field_5445266702cec',
                'label' => 'Blog parent page',
                'name' => 'parent_page',
                'type' => 'page_link',
                'instructions' => 'Will be used on the back to blog button. Use this option only if you want to force a specific page.',
                'post_type' => array(
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_5289f65sepamd',
                'label' => 'Media Management',
                'name' => 'separa_md',
                'type' => 'acf_field_separator',
                'instructions' => '',
                'choices' => '',
                'default_value' => '',
            ),
            array(
                'key' => 'field_52878aed81814',
                'label' => 'Skip featured image on single page and lightbox?',
                'name' => 'skip_featured',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_52878b4c16b18',
                'label' => 'Disable slider and show images and videos stacked vertically?',
                'name' => 'no_slider',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_52878d75b0ce7',
                'label' => 'Position 2: Media Type?',
                'name' => 'position_2_use_video',
                'type' => 'select',
                'choices' => array(
                    'image' => 'Image',
                    'video' => 'Other Media',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_52878d98b0ce8',
                'label' => 'Image 2',
                'name' => 'image_2',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '==',
                            'value' => 'image',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878db9b0ce9',
                'label' => 'Video 2',
                'name' => 'video_2',
                'type' => 'textarea',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'formatting' => 'html',
            ),
            array(
                'key' => 'field_52878e733daa4',
                'label' => 'Image 3',
                'name' => 'image_3',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e723daa3',
                'label' => 'Image 4',
                'name' => 'image_4',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e713daa2',
                'label' => 'Image 5',
                'name' => 'image_5',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e703daa1',
                'label' => 'Image 6',
                'name' => 'image_6',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e6f3daa0',
                'label' => 'Image 7',
                'name' => 'image_7',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e6e3da9f',
                'label' => 'Image 8',
                'name' => 'image_8',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e6c3da9e',
                'label' => 'Image 9',
                'name' => 'image_9',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_52878e6b3da9d',
                'label' => 'Image 10',
                'name' => 'image_10',
                'type' => 'image',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_52878d75b0ce7',
                            'operator' => '!=',
                            'value' => 'video',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'save_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'custom_fields',
            ),
        ),
        'menu_order' => 0,
    ));
}