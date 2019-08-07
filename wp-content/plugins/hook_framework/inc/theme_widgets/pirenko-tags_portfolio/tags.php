<?php
	/*
		Plugin Name: Pirenko Portfolio Tags
		Plugin URI: https://www.pirenko.com
		Description: A widget to show in a different way tags or categories for portfolio.
		Version: 1.0
		Author: Pirenko
		Author URI: https://www.pirenko.com
	*/
	
	//LOAD WIDGET
	add_action( 'widgets_init', 'load_pirenko_tags_portfolio' );
	//REGISTER WIDGET
	function load_pirenko_tags_portfolio() {
		register_widget( 'pirenko_tags_portfolio_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_tags_portfolio_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-tags-portfolio-widget', 'description' => ('A widget to add Tag or Categories Links for Portfolio posts.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-tags-portfolio-widget' );
			parent::__construct( 'pirenko-tags-portfolio-widget', esc_html__('Hook: Portfolio Tag Links', 'hook'), $widget_ops, $control_ops );
		}

		//SET UP WIDGET OUTPUT
		function widget( $args, $instance ) 
		{
			extract($args);
			//BEFORE WIDGET CODE
			echo hook_output().$before_widget;	
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo hook_output().$before_title.$title.$after_title;
			}
			?>
			<div class="pirenko_tags hook_anchor">
                <ul class="prk_tags_ul">
                    <?php
						if ( $instance['link_type']=='both')
							$links_type=array('portfolio_tag','pirenko_skills');
						else
							$links_type=$instance['link_type'];
						$args=array(
						'taxonomy'  => $links_type, 
						'format' => 'array',
						'orderby' => 'count',
						'order' => 'DESC',
						'unit'=>'px',
						'smallest' => 12,
                        'largest'=>12,
					   ); 
   
                       	$tag_cloud=wp_tag_cloud($args);
                        if (!empty($tag_cloud))
						{
							foreach($tag_cloud as $tags) :
								echo "<div class='colored_theme_button prk_tiny'>";
								echo hook_output().$tags;
								echo "</div>";
							endforeach; 
						}
						else
						{
							echo ("Tags not found!");	
						}
                    ?>
                </ul>
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
			if (isset($instance['link_type']))
				$link_type = $instance['link_type'];
			else
				$link_type="tags";
			?>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'hook'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('title'); ?>" name="<?php echo hook_output().$this->get_field_name('title'); ?>" value="<?php echo hook_output().$title; ?>" class="widefat" />
			</p>
            <p>
				<label for="<?php echo hook_output().$this->get_field_id('link_type'); ?>"><?php esc_html_e('Use skills or tags?', 'hook'); ?></label><br />
				<select id="<?php echo hook_output().$this->get_field_id('link_type'); ?>" name="<?php echo hook_output().$this->get_field_name('link_type'); ?>" class="pct_69">
					<?php   
						if ( $link_type == 'category' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='pirenko_skills'>Skills</option>";
                       	else
                          	echo "\n\t<option value='pirenko_skills'>Skills</option>";
                      	if ( $link_type == 'portfolio_tag' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='portfolio_tag'>Tags</option>";
                       	else
                         	echo "\n\t<option value='portfolio_tag'>Tags</option>";
						if ( $link_type == 'both' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='both'>Both</option>";
                       	else
                         	echo "\n\t<option value='both'>Both</option>";
							
                    ?>
              	</select>
			</p>
			<?php
			
		}
	}
?>