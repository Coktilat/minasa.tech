<!doctype html>
<html amp>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<?php
		$prk_hook_options=hook_options();
		$prk_select_font_options=hook_fonts();
		do_action( 'amp_post_template_head', $this );
		foreach ( $prk_select_font_options as $option_body ) {
		    if ($prk_hook_options['body_font'] == $option_body['value'])
		    {
		        $options['body_font']=$option_body;
		        break;
		    }
		}
		$prk_font_options = get_option('prk_font_plugin_option');
		if ($prk_font_options!="") {
		    foreach ($prk_font_options as $font) {
		        if ($font['erased']=="false") {
		            if ($options['body_font'] == $font['value'])
		            {
		                $options['body_font']=$font;
		            } 
		        }
		    }
		}

		//FONTS
		$protocol = is_ssl() ? 'https' : 'http';
		$font_families = array();
		//BODY FONT
		if ($options['body_font']['hosted']=='google') {
		    $font_families[]=str_replace('+',' ',$options['body_font']['value']);
		}
		if ($options['body_font']['hosted']=='theme') {
		    wp_enqueue_style( 'prk_body_font', get_template_directory_uri().'/inc/fonts/'.$options['body_font']['value'].'/stylesheet.css',false,HOOK_VERSION);
		}
		if ($options['body_font']['hosted']=='plugin') {
		        wp_enqueue_style( 'prk_body_font', $options['body_font']['value'],false,HOOK_VERSION);
		}
		if (!empty($font_families)) {
		    $query_args = array(
		       'family' => urlencode(implode('|', $font_families )),
		       'subset' => urlencode('latin,latin-ext'),
		    );
		    $fonts_url = add_query_arg($query_args,'https://fonts.googleapis.com/css');
		    $fonts_url=esc_url_raw($fonts_url);
		    wp_enqueue_style('hook_google_fonts', $fonts_url, array(), null );
		    echo '<link rel="stylesheet" href="'.$fonts_url.'">';
		}
	?>
	<style amp-custom>
	<?php
		$this->load_parts( array( 'style' ) );
		do_action( 'amp_post_template_css', $this ); 
	?>
	</style>
</head>
<body <?php body_class(); ?>>
	<nav class="amp-wp-title-bar">
		<div>
			<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
				<?php echo hook_logo_amp(); ?>
			</a>
		</div>
		<div id="prk_mobile_bar_inner" class="<?php echo esc_attr($prk_hook_options['right_bar_align']); ?>">
		    <?php
		        //MOBILE MENU
		        if (has_nav_menu('prk_amp_navigation')) {
		            ?>
		            	<div class="header_stack prk_mainer">
		                <?php
		                        wp_nav_menu(array(
		                            'theme_location' => 'prk_amp_navigation', 
		                            'menu_class' => 'mobile-menu-ul header_font',
		                            'link_after' => '',
		                            'walker' => new rc_scm_walker)
		                        );
		                ?>
		            </div>
		            <?php
		        }
		    ?>
		</div>
	</nav>
	<div class="clearfix"></div>
	<div class="amp-wp-content">
		<h1 class="amp-wp-title"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
		<ul class="amp-wp-meta">
			<?php $this->load_parts( apply_filters( 'amp_post_template_meta_parts', array( 'meta-author', 'meta-time', 'meta-taxonomy' ) ) ); ?>
		</ul>
		<?php echo hook_output().$this->get( 'post_amp_content' ); ?>
	</div>
	<?php do_action( 'amp_post_template_footer', $this ); ?>
</body>
</html>
