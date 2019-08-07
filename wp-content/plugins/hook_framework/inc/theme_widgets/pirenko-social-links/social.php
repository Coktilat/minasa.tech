<?php
	/*
		Plugin Name: Hook Social Links 
		Plugin URI: https://www.pirenko.com/
		Description: A widget to add social network links to your website.
		Version: 1.0
		Author: Pirenko
		Author URI: https://www.pirenko.com/
	*/
	
	//LOAD WIDGET
	add_action( 'widgets_init', 'load_pirenko_social' );
	//REGISTER WIDGET
	function load_pirenko_social() {
		register_widget( 'pirenko_social_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_social_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-social-widget', 'description' => ('A widget to add social network links to your website.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-social-widget' );
			parent::__construct( 'pirenko-social-widget', esc_html__('Hook : Social Links ', 'hook'), $widget_ops, $control_ops );
		}

		
		var $imgs_url;
		var $z_social_title;
		var $pir_icons;
		var $tips;
		function fields_array( $instance = array() ) 
		{
			$this->imgs_url = plugins_url( '/icons/colored/' , __FILE__ );
			return array(			
				'behance' => array(
					'title' => esc_html__('Behance URL', 'astro_lang'),
					'img' => sprintf( '%sbehance.png', '' ),
					'img_widget' => sprintf( '%sbehance.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'behance',
					'img_color' => '#2d9ad2',
					'img_title' => esc_html__('Behance', 'astro_lang')
				),
				'digg' => array(
					'title' => esc_html__('Digg URL', 'hook'),
					'img' => sprintf( '%sdigg.png', '' ),
					'img_widget' => sprintf( '%sdigg.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'digg',
					'img_color' => '#24578e',
					'img_title' => esc_html__('Digg', 'hook')
				),
				'dribbble' => array(
					'title' => esc_html__('Dribbble URL', 'hook'),
					'img' => sprintf( '%sdribbble.png', '' ),
					'img_widget' => sprintf( '%sdribbble.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'dribbble',
					'img_color' => '#ea4c89',
					'img_title' => esc_html__('Dribbble', 'hook')
				),
				'facebook' => array(
					'title' => esc_html__('Facebook URL', 'hook'),
					'img' => sprintf( '%sfacebook.png', '' ),
					'img_widget' => sprintf( '%sfacebook.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'facebook',
					'img_color' => '#1f69b3',
					'img_title' => esc_html__('Facebook', 'hook')
				),
				'flickr' => array(
					'title' => esc_html__('Flickr URL', 'hook'),
					'img' => sprintf( '%sflickr.png', '' ),
					'img_widget' => sprintf( '%sflickr.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'flickr',
					'img_color' => '#fd0083',
					'img_title' => esc_html__('Flickr', 'hook')
				),
				'google_plus' => array(
					'title' => esc_html__('Google Plus URL', 'hook'),
					'img' => sprintf( '%sgoogle_plus.png', '' ),
					'img_widget' => sprintf( '%sgoogle_plus.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'google-plus',
					'img_color' => '#333333',
					'img_title' => esc_html__('Google Plus', 'hook')
				),
				'instagram' => array(
					'title' => esc_html__('Instagram URL', 'hook'),
					'img' => sprintf( '%sinstagram.png', '' ),
					'img_widget' => sprintf( '%sinstagram.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'instagram',
					'img_color' => '#3f729b',
					'img_title' => esc_html__('Instagram', 'hook')
				),
				'linkedin' => array(
					'title' => esc_html__('Linkedin URL', 'hook'),
					'img' => sprintf( '%slinkedin.png', '' ),
					'img_widget' => sprintf( '%slinkedin.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'linkedin',
					'img_color' => '#1a7696',
					'img_title' => esc_html__('Linkedin', 'hook')
				),
				'pinterest' => array(
					'title' => esc_html__('Pinterest URL', 'hook'),
					'img' => sprintf( '%spinterest.png', '' ),
					'img_widget' => sprintf( '%spinterest.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'pinterest-square',
					'img_color' => '#df2126',
					'img_title' => esc_html__('Pinterest', 'hook')
				),
				'skype' => array(
					'title' => esc_html__('Skype URL', 'hook'),
					'img' => sprintf( '%sskype.png', '' ),
					'img_widget' => sprintf( '%sskype.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'skype',
					'img_color' => '#28a9ed',
					'img_title' => esc_html__('Skype', 'hook')
				),
				'soundcloud' => array(
					'title' => esc_html__('Soundlcloud URL', 'hook'),
					'img' => sprintf( '%ssoundcloud.png', '' ),
					'img_widget' => sprintf( '%ssoundcloud.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'soundcloud',
					'img_color' => '#ef4e23',
					'img_title' => esc_html__('Soundlcloud', 'hook')
				),
				'tumblr' => array(
					'title' => esc_html__('Tumblr URL', 'hook'),
					'img' => sprintf( '%stumblr.png', '' ),
					'img_widget' => sprintf( '%stumblr.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'tumblr',
					'img_color' => '#374a61',
					'img_title' => esc_html__('Tumblr', 'hook')
				),
				'twitter' => array(
					'title' => esc_html__('Twitter URL', 'hook'),
					'img' => sprintf( '%stwitter.png', '' ),
					'img_widget' => sprintf( '%stwitter.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'twitter',
					'img_color' => '#43b3e5',
					'img_title' => esc_html__('Twitter', 'hook')
				),
				'vimeo' => array(
					'title' => esc_html__('Vimeo URL', 'hook'),
					'img' => sprintf( '%svimeo.png', '' ),
					'img_widget' => sprintf( '%svimeo.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'vimeo-square',
					'img_color' => '#4ab2d9',
					'img_title' => esc_html__('Vimeo', 'hook')
				),
				'youtube' => array(
					'title' => esc_html__('YouTube URL', 'hook'),
					'img' => sprintf( '%syoutube.png', '' ),
					'img_widget' => sprintf( '%syoutube.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'youtube-play',
					'img_color' => '#fb2d39',
					'img_title' => esc_html__('Youtube', 'hook')
				),
				'feedburner' => array(
					'title' => esc_html__('RSS/Feedburner URL', 'hook'),
					'img' => sprintf( '%srss.png', '' ),
					'img_widget' => sprintf( '%srss.png', $this->imgs_url.esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'rss',
					'img_color' => '#ed8333',
					'img_title' => esc_html__('RSS Feed', 'hook')
				),	
			);
		}
		//SET UP WIDGET OUTPUT
		function widget( $args, $instance ) 
		{
			extract($args);
			//GRAB CURRENT VALUES
			$instance = wp_parse_args($instance, array(
				'title' => '',
				'new_window' => 0,
				'icon_set' => '',
				'size' => '24x24'
			) );
			//BEFORE WIDGET CODE
			echo hook_output().$before_widget;	
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo hook_output().$before_title.$title.$after_title;
			}
			if (isset($instance['description_text']) && $instance['description_text']!="") {
				echo '<div class="small-12 hook_social_description"><div class="wpb_text_column">'.$instance['description_text'].'</div></div>';
			}
			//DISPLAY LINKS
			$c_color="";
			?>
			<div class="pirenko_social <?php echo hook_output().$instance['pir_icons']; ?>">
				<div class="pirenko_social_inner">
				<?php
				$tips_class="";
				$big_icons="";
				if ($instance['pir_icons']=="rounded_large")
					$big_icons="big_icons";	
				$new_window="target='_blank'";
				$inside_counter=1;
				$sizer=34;
				if ($instance['pir_icons'] == 'minimal_bw') 
				{
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp hook_socialink prk_bordered hook-%s"><a href="%s" title="%s" %s %s data-color="%s"><div class="prk_minimal_icon hook-%s hook_fa-%s"></div></a></div>',$data['img_class'],hook_change_links($instance[$key]), esc_attr( $data['img_title'] ), $new_window , $tips_class,$data['img_color'],$data['img_class'],$data['img_class'],$data['img_class']);
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'minimal') 
				{
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp hook_socialink prk_bordered hook-%s"><a href="%s" title="%s" %s %s data-color="#FFFFFF"><div class="prk_minimal_icon hook-%s hook_fa-%s"></div><div class="bg_shifter"></div></a></div>',$data['img_class'],hook_change_links($instance[$key]), esc_attr( $data['img_title'] ), $new_window , $tips_class,$data['img_class'],$data['img_class'],$data['img_class']);
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'rounded') {
					$sizer=34;
					foreach ( $this->fields_array( $instance ) as $key => $data ) {
						if ( ! empty ( $instance[$key] ) ) {
							printf( '<div class="social_img_wrp" style="width:%spx;height:%spx;float:left;"><a href="%s" title="%s" %s %s><img src="%s" class="pir_icons %s" width="%s" height="%s" alt="%s" /></a></div>', $sizer,$sizer,hook_change_links($instance[$key]), esc_attr( $data['img_title'] ), $new_window , $tips_class, plugins_url( '/icons/' , __FILE__ ).$instance['pir_icons'].'/'.$data['img'], $big_icons,$sizer,$sizer, esc_attr( $data['img_title'] ) );
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'squared') 
				{
					$sizer=34;
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp" style="width:%spx;height:%spx;float:left;"><a href="%s" title="%s" %s %s><img src="%s" class="pir_icons %s" width="%s" height="%s" alt="%s" /></a></div>', $sizer,$sizer,hook_change_links($instance[$key]), esc_attr( $data['img_title'] ), $new_window , $tips_class, plugins_url( '/icons/' , __FILE__ ).$instance['pir_icons'].'/'.$data['img'], $big_icons,$sizer,$sizer, esc_attr( $data['img_title'] ) );
							$inside_counter++;
						}
					}
				}
				?>
				</div>
			</div>
			<?php
			//AFTER WIDGET CODE
			echo hook_output().$after_widget;
		}
		//UPDATE WIDGET SETTINGS
		function update( $new_instance, $old_instance ) 
		{
			return $new_instance;
		}
		//SET UP WIDGET FORM ON THE CONTROL PANEL
		function form( $instance ) 
		{
			
			$instance = wp_parse_args($instance, array(
				'title' => '',
				'new_window' => 0,
				'icon_set' => '',
				'size' => '24x24',
				'c_color' => '',
				'description_text' => '',
			) ); 
			if (isset($instance['tips']))
				$tips=$instance['tips'];
			else
				$tips="yes";
			$instance['tips']=$tips;
			?>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'hook'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('title'); ?>" name="<?php echo hook_output().$this->get_field_name('title'); ?>" value="<?php echo hook_output().$instance['title']; ?>" class="widefat" />
			</p>
			<p>
	      		<label for="<?php echo esc_attr($this->get_field_id('description_text')); ?>"><?php esc_html_e('Description text (optional):', 'hook'); ?></label>
	      		<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description_text')); ?>" name="<?php echo esc_attr($this->get_field_name('description_text')); ?>" type="text"><?php echo hook_output().$instance['description_text']; ?></textarea>
	    	</p>
            <p>
				<label for="<?php echo hook_output().$this->get_field_id('pir_icons'); ?>"><?php esc_html_e('Icons style', 'hook'); ?>:</label><br />
				<select id="<?php echo hook_output().$this->get_field_id('pir_icons'); ?>" name="<?php echo hook_output().$this->get_field_name('pir_icons'); ?>" class="pct_69">
					<?php
						if ( $instance['pir_icons'] == 'minimal_bw' )
                                echo "\n\t<option selected='selected' value='minimal_bw'>Minimal - monochrome</option>";
                            else
                                echo "\n\t<option value='minimal_bw'>Minimal - monochrome</option>";
						if ( $instance['pir_icons'] == 'rounded' ) 
                            echo "\n\t<option selected='selected' value='rounded'>Rounded - Flat style</option>";
                        else
                            echo "\n\t<option value='rounded'>Rounded - Flat style</option>";

						if ( $instance['pir_icons'] == 'squared' )
                            echo "\n\t<option selected='selected' value='squared'>Squared - Flat style</option>";
                        else
                            echo "\n\t<option value='squared'>Squared - Flat style</option>";
						if ( $instance['pir_icons'] == 'minimal' )
                            echo "\n\t<option selected='selected' value='minimal'>Colored with border</option>";
                        else
                            echo "\n\t<option value='minimal'>Colored with border</option>";
                    ?>
              	</select>
			</p>
			<?php
			foreach ( $this->fields_array( $instance ) as $key => $data ) 
			{
				$inner_c="";
				if (isset($instance[$key] ))
					$inner_c= $instance[$key] ;
				echo '<p>';
				printf( '<img class="socials_icns" src="%s" title="%s" />', $data['img_widget'], $data['img_title'] );
				printf( '<label for="%s"> %s:</label><br>', esc_attr( $this->get_field_id($key) ), esc_attr( $data['title'] ) );
				if ($data['img_title']!='Skype') {
					printf( '<input id="%s" name="%s" value="%s" style="%s" class="pct_75" type="text" />', esc_attr( $this->get_field_id($key) ), esc_attr( $this->get_field_name($key) ), esc_url( $inner_c ), 'width:75%;' );
				}
				else
				{
					printf( '<input id="%s" name="%s" value="%s" style="%s" class="pct_75" type="text" />', esc_attr( $this->get_field_id($key) ), esc_attr( $this->get_field_name($key) ), ( $inner_c ), 'width:75%;' );
				}
				echo '</p>'."\n";
			}
		}
	}
?>