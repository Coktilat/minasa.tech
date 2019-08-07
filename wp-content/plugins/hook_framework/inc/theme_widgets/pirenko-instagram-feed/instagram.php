<?php
	/*
		Plugin Name: Pirenko Instagram Feed
		Plugin URI: https://www.pirenko.com
		Description: A widget to show recent instagram entries
		Version: 1.0
		Author: Pirenko
		Author URI: http://www.pirenko-themes.com
	*/
	
	//LOAD WIDGET
	add_action( 'widgets_init', 'load_pirenko_recent_instagram' );
	//REGISTER WIDGET
	function load_pirenko_recent_instagram() {
		register_widget( 'pirenko_recent_instagram_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_recent_instagram_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-recent_instagram-widget', 'description' => ('A widget to show an Instagram feed.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-recent_instagram-widget' );
			parent::__construct( 'pirenko-recent_instagram-widget', esc_html__('Hook : Instagram Feed', 'pirenko-recent_instagram-widget'), $widget_ops, $control_ops );
		}

		//SET UP WIDGET OUTPUT
		function widget( $args, $instance ) {
			$hook_retina_device=hook_retiner(false);
			extract($args);
			//BEFORE WIDGET CODE
			echo hook_output().$before_widget;	
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo hook_output().$before_title.$title.$after_title;
			}
			?>
			<div class="pirenko_recent_instagram">
                <?php
					$my_home_query = new WP_Query();
					if (isset($instance['rows']))
						$rows = $instance['rows'];
					else
						$rows="1";
					if (isset($instance['img_margin']))
						$img_margin = $instance['img_margin'];
					else
						$img_margin="0";
					if (isset($instance['user']))
						$user = $instance['user'];
					else
						$user="";
					if (isset($instance['items']))
						$items = $instance['items'];
					else
						$items="1";
					echo do_shortcode('[prk_instagram user="'.$user.'" items="'.$items.'" rows="'.$rows.'" img_margin="'.$img_margin.'"]');
				?>
                <div class="clearfix"></div>
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
			if (isset($instance['title']))
				$title = $instance['title'] ;
			else
				$title="";
			if (isset($instance['rows']))
				$rows = $instance['rows'];
			else
				$rows="1";
			if (isset($instance['img_margin']))
				$img_margin = $instance['img_margin'];
			else
				$img_margin="0";
			if (isset($instance['user']))
				$user = $instance['user'] ;
			else
				$user="";
			if (isset($instance['items']))
				$items = $instance['items'] ;
			else
				$items="thumbnail_lay";
			?>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'spw'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('title'); ?>" name="<?php echo hook_output().$this->get_field_name('title'); ?>" value="<?php echo hook_output().$title; ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('user'); ?>"><?php esc_html_e('Username', 'spw'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('user'); ?>" name="<?php echo hook_output().$this->get_field_name('user'); ?>" value="<?php echo hook_output().$user; ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('items'); ?>"><?php esc_html_e('Columns Number', 'spw'); ?></label><br />
				<select id="<?php echo hook_output().$this->get_field_id('items'); ?>" name="<?php echo hook_output().$this->get_field_name('items'); ?>" class="possibly_hider">
					<?php   
						if ( $items == '1' )
                        	echo "\n\t<option selected='selected' value='1'>One</option>";
                       	else
                          	echo "\n\t<option value='1'>One</option>";
						if ( $items == '2' )
                        	echo "\n\t<option selected='selected' value='2'>Two</option>";
                       	else
                          	echo "\n\t<option value='2'>Two</option>";
                        if ( $items == '3' )
                        	echo "\n\t<option selected='selected' value='3'>Three</option>";
                       	else
                          	echo "\n\t<option value='3'>Three</option>";
                        if ( $items == '4' )
                        	echo "\n\t<option selected='selected' value='4'>Four</option>";
                       	else
                          	echo "\n\t<option value='4'>Four</option>";
                        if ( $items == '6' )
                        	echo "\n\t<option selected='selected' value='6'>Six</option>";
                       	else
                          	echo "\n\t<option value='6'>Six</option>";
                    ?>
              	</select>
			</p>
            <p>
				<label for="<?php echo hook_output().$this->get_field_id( 'rows' ); ?>">Number of rows:</label>
				<input id="<?php echo hook_output().$this->get_field_id( 'rows' ); ?>" name="<?php echo hook_output().$this->get_field_name( 'rows' ); ?>" value="<?php echo hook_output().$rows; ?>" class="widefat" />
			</p>
            <p>
				<label for="<?php echo hook_output().$this->get_field_id( 'img_margin' ); ?>">Images margin (in pixels):</label>
				<input id="<?php echo hook_output().$this->get_field_id( 'img_margin' ); ?>" name="<?php echo hook_output().$this->get_field_name( 'img_margin' ); ?>" value="<?php echo hook_output().$img_margin; ?>" class="widefat" />
			</p>
			<?php
			
		}
	}
?>