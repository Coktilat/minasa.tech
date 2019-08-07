<?php
	/*
		Plugin Name: Pirenko Recent Portfolio
		Plugin URI: https://www.pirenko.com
		Description: A widget to show recent portfolios
		Version: 1.2
		Author: Pirenko
		Author URI: https://www.pirenko.com
	*/
	
	//LOAD WIDGET
	add_action( 'widgets_init', 'load_pirenko_recent_portfolio' );
	//REGISTER WIDGET
	function load_pirenko_recent_portfolio() {
		register_widget( 'pirenko_recent_portfolio_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_recent_portfolio_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-recent_portfolios-widget', 'description' => ('A widget to show recent portfolios.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-recent_portfolios-widget' );
			parent::__construct( 'pirenko-recent_portfolios-widget', esc_html__('Hook : Recent Portfolios', 'pirenko-recent_portfolios-widget'), $widget_ops, $control_ops );
		}

		//SET UP WIDGET OUTPUT
		function widget( $args, $instance )
		{
			$hook_retina_device=hook_retiner(false);
			extract($args);
			//BEFORE WIDGET CODE
			echo hook_output().$before_widget;
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo hook_output().$before_title.$title. $after_title;
			}
			?>
			<div class="pirenko_recent_portfolios">
                    <?php
						$my_home_query = new WP_Query();
						if (isset($instance['num_items']))
							$num_items = $instance['num_items'];
						else
							$num_items="9";
						if (isset($instance['prk_filter']))
							$prk_filter = $instance['prk_filter'] ;
						else
							$prk_filter="";
						if (isset($instance['layout_type']))
							$layout_type = $instance['layout_type'] ;
						else
							$layout_type="thumbnail_lay";
						if (isset($instance['lightboxed']))
							$lightboxed = $instance['lightboxed'];
						else
							$lightboxed="";
						$anchor_class="hook_anchor";
						if ($lightboxed=="hook_widget_gallery") {
							$anchor_class="magnificent";
						}
						$args = array (	'post_type' => 'pirenko_portfolios',
									'showposts' => 99,
									'pirenko_skills'=>$prk_filter
									);
						$my_home_query->query($args);
                        if ($my_home_query->have_posts())
						{
							?>
                       			<ul class="hook_recent_ul<?php echo " ".$layout_type;echo " ".$lightboxed; ?>">
								<?php
									$pst_counter=0;
									while ($my_home_query->have_posts()) : $my_home_query->the_post();
										if ($pst_counter<$num_items)
										{
											if ($layout_type=="thumbnail_lay") {
												if (has_post_thumbnail()) {
													$pst_counter++;
													$hook_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
													$hook_vt_image = vt_resize( get_post_thumbnail_id(), '' , 480, 480, true , $hook_retina_device );
													$extra_mfp="";
													if (get_field('skip_featured')==1) {
														//CHECK IF THERE'S A SECOND IMAGE
														if (get_field('image_2')!="") {
															$hook_in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
															$hook_image[0]=$hook_in_image[0];
														}
														else if (get_field('video_2')) {
															$hook_image[0]=hook_get_iframe_src(get_field('video_2'));
															$extra_mfp=" mfp-iframe";
														}
													}
													?>
													<li class="small-4 medium-4 columns thumbnail_lay prk_lf portfolio_entry_li">
														<a href="<?php the_permalink(); ?>" class="<?php echo hook_output().$anchor_class.$extra_mfp; ?>" data-mfp-src="<?php echo esc_attr($hook_image[0]); ?>" data-title="<?php echo get_the_title(); ?>">
														<div class="grid_colored_block"></div>
														<img src="<?php echo esc_attr($hook_vt_image['url']); ?>" alt="<?php echo hook_alt_tag(true,get_post_thumbnail_id()); ?>" width="<?php echo esc_attr($hook_vt_image['width']); ?>" height="<?php echo esc_attr($hook_vt_image['height']); ?>" />
														</a>
													</li>
													<?php
												}
											}
											else
											{
												$pst_counter++;
												?>
													<li class="small-12 info_lay">
														<div class="hook_widget_date"><?php the_date(); ?></div>
														<h4 class="small">
															<a href="<?php the_permalink(); ?>" class="small-12 <?php echo hook_output().$anchor_class; ?>">
																<?php echo get_the_title(); ?>
																<i class="hook_fa-angle-double-right prk_rf"></i>
															</a>
														</h4>
														<div class="clearfix"></div>
														<div class="simple_line"></div>
													</li>
													<?php
											}
										}
									endwhile;
						}
						else
						{
							echo '<div class="clearfix"></div>';
							echo ("No content was found!");
						}
						wp_reset_query();
                    ?>
                </ul>
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
			if (isset($instance['link_type']))
				$link_type = $instance['link_type'];
			else
				$link_type="tags";
			if (isset($instance['num_items']))
				$num_items = $instance['num_items'];
			else
				$num_items="9";
			if (isset($instance['lightboxed']))
				$lightboxed = $instance['lightboxed'];
			else
				$lightboxed="";
			if (isset($instance['prk_filter']))
				$prk_filter = $instance['prk_filter'] ;
			else
				$prk_filter="";
			if (isset($instance['layout_type']))
				$layout_type = $instance['layout_type'] ;
			else
				$layout_type="thumbnail_lay";
			?>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'spw'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('title'); ?>" name="<?php echo hook_output().$this->get_field_name('title'); ?>" value="<?php echo hook_output().$title; ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('layout_type'); ?>"><?php esc_html_e('Show thumbnail or title and date?', 'spw'); ?></label><br />
				<select id="<?php echo hook_output().$this->get_field_id('layout_type'); ?>" name="<?php echo hook_output().$this->get_field_name('layout_type'); ?>" class="possibly_hider pct_69">
					<?php
						if ( $layout_type == 'thumbnail_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='thumbnail_lay'>Thumbnail</option>";
                       	else
                          	echo "\n\t<option value='thumbnail_lay'>Thumbnail</option>";
                      	if ( $layout_type == 'info_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='info_lay'>Title and date</option>";
                       	else
                         	echo "\n\t<option value='info_lay'>Title and date</option>";

                    ?>
              	</select>
			</p>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('lightboxed'); ?>"><?php esc_html_e('Thumbnails open lightbox?', 'spw'); ?></label><br />
				<select id="<?php echo hook_output().$this->get_field_id('lightboxed'); ?>" name="<?php echo hook_output().$this->get_field_name('lightboxed'); ?>" class="possibly_hider pct_69">
					<?php
						if ( $lightboxed == '' )
                        	echo "\n\t<option selected='selected' value=''>No</option>";
                       	else
                          	echo "\n\t<option value=''>No</option>";
                      	if ( $lightboxed == 'hook_widget_gallery' )
                        	echo "\n\t<option selected='selected' value='hook_widget_gallery'>Yes</option>";
                       	else
                         	echo "\n\t<option value='hook_widget_gallery'>Yes</option>";

                    ?>
              	</select>
			</p>
			<p>
				<label for="<?php echo hook_output().$this->get_field_id('prk_filter'); ?>"><?php esc_html_e('Filter (optional)', 'spw'); ?>:</label><br />
				<input id="<?php echo hook_output().$this->get_field_id('prk_filter'); ?>" name="<?php echo hook_output().$this->get_field_name('prk_filter'); ?>" value="<?php echo hook_output().$prk_filter; ?>" class="widefat" />
				<br />
				<span class="description">Use skills slug (comma separated)</span>
			</p>
            <p>
				<label for="<?php echo hook_output().$this->get_field_id( 'num_items' ); ?>">Number of entries:</label>
				<input id="<?php echo hook_output().$this->get_field_id( 'num_items' ); ?>" name="<?php echo hook_output().$this->get_field_name( 'num_items' ); ?>" value="<?php echo hook_output().$num_items; ?>" class="widefat" />
			</p>
			<?php

		}
	}
?>