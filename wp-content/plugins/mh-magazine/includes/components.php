<?php
if (class_exists('MHComposer_Component', false)) {	
	
class MHMagazine_Component_Magazine extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Magazine', 'mh-magazine' );
		$this->slug = 'mhc_magazine';
		$this->main_css_element = '%%order_class%%.mh_magazine_posts';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'magazine_list',
			'include_categories',
			'title_categories',
			'title',
			'posts_number',
			'offset_posts',
			'magazine_style',
			'meta_date',
			'show_thumbnail',
			'show_excerpt',
			'show_author',
			'show_date',
			'show_categories',
			'show_comments',
			'show_views',
			'show_ratings',
			'background_layout',
			'show_more',
			'show_more_button',
			'show_avatar',
			'show_loveit',
			'categories_style',
			'design',
			'background',
			'accent',
			'accent_text',
		);
		
		$mh_accent_color = mh_composer_accent_color();
		
		$this->fields_defaults = array(
			'magazine_list'         => array( 'date' ),
			'title_categories'	  	=> array( 'on' ),
			'posts_number'          => array( '5', 'append_default' ),
			'offset_posts'          => array( '0', 'append_default' ),
			'magazine_style'        => array( 'list1' ),
			'meta_date'         	=> array( 'd/m/Y', 'append_default' ),
			'show_thumbnail'        => array( 'on' ),
			'show_excerpt'          => array( 'on' ),
			'show_author'           => array( 'on' ),
			'show_date'         	=> array( 'on' ),
			'show_categories'       => array( 'on' ),
			'show_comments' 	   	=> array( 'off' ),
			'show_views' 	   	    => array( 'off' ),
			'show_ratings'			=> array( 'off' ),
			'background_layout'     => array( 'light' ),
			'show_more'         	=> array( 'off' ),
			'show_more_button'      => array( 'off' ),
			'show_avatar'           => array( 'on' ),
			'show_loveit'           => array( 'off' ),
			'categories_style'      => array( 'parallel' ),
			'design'         		=> array( 'flat' ),
			'background'         	=> array( '#ffffff', 'append_default' ),
			'accent' 				=> array( $mh_accent_color, 'append_default' ),
			'accent_text'           => array( '#ffffff', 'append_default' ),
		);
		
		$this->custom_css_options = array(
			'magazine_post' => array(
				'label'    => esc_html__( 'Post', 'mh-magazine' ),
				'selector' => '.mh-magazine-post',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
			'magazine_post_featured_image' => array(
				'label'    => esc_html__( 'Featured Image', 'mh-magazine' ),
				'selector' => '.mh-magazine-post .mh-magazine-post-thumb img',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
			'magazine_post_content' => array(
				'label'    => esc_html__( 'Content', 'mh-magazine' ),
				'selector' => '.mh-magazine-post .mh-magazine-post-meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
			'magazine_post_title' => array(
				'label'    => esc_html__( 'Title', 'mh-magazine' ),
				'selector' => '.mh-magazine-post .mh-magazine-post-meta h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
			'magazine_post_title_xs' => array(
				'label'    => esc_html__( 'Small Title', 'mh-magazine' ),
				'selector' => '.mh-magazine-post.xs .mh-magazine-post-meta h2',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
			'magazine_post_meta' => array(
				'label'    => esc_html__( 'Post Meta', 'mh-magazine' ),
				'selector' => '.mh-magazine-post .post-meta',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.', 'mh-magazine' ),
			),
		);

		}
	
	function get_fields() {
		
		
		$fields = array(
			'magazine_list' => array(
				'label'             => esc_html__( 'Content Type', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'date'  			=> esc_html__( 'Latest', 'mh-magazine' ),
					'comment_count'   => esc_html__( 'Popular', 'mh-magazine' ),
					'title' 		   => esc_html__( 'Title', 'mh-magazine' ),
					'rand' 			=> esc_html__( 'Random', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Order by: Latest - the most recent articles, Popular - the most commented, Title, or Random.', 'mh-magazine' ),
			),
			'design' => array(
				'label'             => esc_html__( 'Style', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'flat'	 => esc_html__( 'Flat', 'mh-magazine' ),
					'boxed'	=> esc_html__( 'Boxed', 'mh-magazine' ),
				),
				'affects'           => array(
					'#mhc_categories_style',
					'#mhc_background',
					//'#mhc_accent_text',
				),
				'description'        => esc_html__( 'Choose the desired style.', 'mh-magazine' ),
			),
			'magazine_style' => array(
				'label'             => esc_html__( 'Layout', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'list1'  			=> esc_html__( 'Feature the first', 'mh-magazine' ),
					'list2'  		 	=> esc_html__( 'Large', 'mh-magazine' ),
					'list3'  		 	=> esc_html__( 'Small', 'mh-magazine' ),
					'list4'  		 	=> esc_html__( 'Card', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Choose the desired layout.', 'mh-magazine' ),
				'affects'           => array(
					'#mhc_show_more',
				),
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'mh-magazine' ),
				'renderer'         => 'mh_composer_include_categories_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'mh-magazine' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to show.', 'mh-magazine' ),
			),
			'offset_posts' => array(
				'label'           => esc_html__( 'Offset Posts', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose by how many posts you would like to offset. Numeric value only', 'mh-magazine' ),
			),
			'title_categories' => array(
				'label'             => esc_html__( 'Show Category/Title', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'       => esc_html__( 'Here you can define whether to show the category as a title, or you can define a custom title below.', 'mh-magazine' ),
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Define a custom title here. Make sure you did not choose to show category as a title above.', 'mh-magazine' ),
			),
			'categories_style' => array(
				'label'             => esc_html__( 'Category Style', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'parallel'  => esc_html__( 'Parallel', 'mh-magazine' ),
					'classic'   => esc_html__( 'Button', 'mh-magazine' ),
					'link'   	  => esc_html__( 'Link', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Choose the desired style.', 'mh-magazine' ),
				'depends_show_if'   => 'flat',
				'affects'           => array(
					'#mhc_accent_text',
				),
			),
			'background_layout' => array(
				'label'       => esc_html__( 'Text Colour', 'mh-magazine' ),
				'type'        => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-magazine' ),
					'dark'  => esc_html__( 'Light', 'mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-magazine' ),
			),
			'background' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-magazine' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'boxed',
				'description'       => esc_html__( 'Here you can define a custom background colour.', 'mh-magazine' ),
			),
			'accent' => array(
				'label'             => esc_html__( 'Accent Colour', 'mh-magazine' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Here you can define a custom colour.', 'mh-magazine' ),
			),
			'accent_text' => array(
				'label'             => esc_html__( 'Buttons Text Colour', 'mh-magazine' ),
				'type'              => 'color-alpha',
				'depends_show_if_not' => 'link',
				'description'       => esc_html__( 'For parallel and button style you can define a custom colour.', 'mh-magazine' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Featured Image', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the post featured image.', 'mh-magazine' ),
			),
			'show_avatar' => array(
				'label'             => esc_html__( 'Show Author Avatar', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the author avatar.', 'mh-magazine' ),
			),
			'show_author' => array(
				'label'             => esc_html__( 'Show Author', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the author name.', 'mh-magazine' ),
			),
			'show_date' => array(
				'label'             => esc_html__( 'Show Date', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'affects'           => array(
					'#mhc_meta_date',
				),
				'description'        => esc_html__( 'Here you can define whether to show the date.', 'mh-magazine' ),
			),
			'meta_date' => array(
				'label'             => esc_html__( 'Date Format', 'mh-magazine' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'mh-magazine' ),
			),
			'show_categories' => array(
				'label'             => esc_html__( 'Show Categories', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show categories links.', 'mh-magazine' ),
			),
			'show_comments' => array(
				'label'             => esc_html__( 'Show Comments Count', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'       => esc_html__( 'Here you can choose whether or not display the Comments Count.', 'mh-magazine' ),
			),
			'show_views' => array(
				'label'             => esc_html__( 'Show Views Count', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show Views Count. For this option to work you must have "WP-PostViews" plugin installed and activated.', 'mh-magazine' ),
			),
			'show_ratings' => array(
				'label'             => esc_html__( 'Show Ratings', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show reviews rating. For this option to work you must have "MH REVIEWS" plugin installed and activated.', 'mh-magazine' ),
			),
			'show_excerpt' => array(
				'label'             => esc_html__( 'Show Excerpt', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'       => esc_html__( 'Here you can define whether to show excerpts. Some layouts do not show excerpts.', 'mh-magazine' ),
			),
			'show_more' => array(
				'label'             => esc_html__( 'Show Read More', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'affects'           => array(
					'#mhc_show_more_button',
				),
				'depends_show_if_not'   => 'list4',
				'description'       => esc_html__( 'Here you can define whether to show “read more” link after the excerpts.', 'mh-magazine' ),
			),
			'show_more_button' => array(
				'label'             => esc_html__( 'Read More Button Style', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Here you can define whether to display "read more" link as a button.', 'mh-magazine' ),
			),
			'show_loveit' => array(
				'label'             => esc_html__( 'Like Icon', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the “Like icon”. For this option to work you must have “Mharty - Love it” plugin installed and activated.', 'mh-magazine' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'mh-magazine' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-magazine' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide on', 'mh-magazine' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'mh-magazine' ),
					'tablet'  => esc_html__( 'Tablet', 'mh-magazine' ),
					'desktop' => esc_html__( 'Desktop', 'mh-magazine' ),
				),
				'additional_att'  => 'disable_on',
				'description'     => esc_html__( 'This will hide the component on selected devices', 'mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          			 = $this->shortcode_atts['module_id'];
		$module_class       			  = $this->shortcode_atts['module_class'];
		$magazine_list 				 = $this->shortcode_atts['magazine_list'];
		$include_categories 			= $this->shortcode_atts['include_categories'];
		$title_categories 			  = $this->shortcode_atts['title_categories'];
		$title 						 = $this->shortcode_atts['title'];
		$posts_number       			  = $this->shortcode_atts['posts_number'];
		$offset_posts      			  = $this->shortcode_atts['offset_posts'];
		$magazine_style				= $this->shortcode_atts['magazine_style'];
		$meta_date					 = $this->shortcode_atts['meta_date'];
		$show_thumbnail     			= $this->shortcode_atts['show_thumbnail'];
		$show_excerpt				  = $this->shortcode_atts['show_excerpt'];
		$show_author				   = $this->shortcode_atts['show_author'];
		$show_date					 = $this->shortcode_atts['show_date'];
		$show_categories			   = $this->shortcode_atts['show_categories'];
		$show_comments				 = $this->shortcode_atts['show_comments'];
		$show_views				    = $this->shortcode_atts['show_views'];
		$show_ratings			    = $this->shortcode_atts['show_ratings'];
		$background_layout  			 = $this->shortcode_atts['background_layout'];
		$show_more					 = $this->shortcode_atts['show_more'];
		$show_more_button			  = $this->shortcode_atts['show_more_button'];
		$show_avatar				   = $this->shortcode_atts['show_avatar'];
		$show_loveit				   = $this->shortcode_atts['show_loveit'];
		$categories_style			  = $this->shortcode_atts['categories_style'];
		$design						= $this->shortcode_atts['design'];
		$background					= $this->shortcode_atts['background'];
		$accent						= $this->shortcode_atts['accent'];
		$accent_text				   = $this->shortcode_atts['accent_text'];
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ('flat' !== $design){
			if ('list4' !== $magazine_style){
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh-magazine',
					'declaration' => sprintf(
						'background-color: %1$s;',
						'#ffffff' !== $background ? esc_html( $background ) : '#ffffff'
					),
				) );
			}else{
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh-magazine .card',
					'declaration' => sprintf(
						'background-color: %1$s;',
						'#ffffff' !== $background ? esc_html( $background ) : '#ffffff'
					),
				) );
				
			}
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_magazine_head',
				'declaration' => sprintf(
					'border-bottom: 1px solid %1$s;',
					esc_html( $accent )
				),
			) );
		}
		if ('flat' === $design && 'link' === $categories_style){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_magazine_head',
				'declaration' => sprintf(
					'border-%2$s-color: %1$s;',
					esc_html( $accent ),
					(is_rtl()? 'right' : 'left')
				),
			) );
		}
		
		if('on' == $show_more && (('list1' == $magazine_style) || 'list2' == $magazine_style)){
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .more-link',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $accent )
				),
			) );
			
			if ('off' !== $show_more_button) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .more-link.mhc_contact_submit',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $accent )
					),
				) );
			}
		}
		if ( '' !== $include_categories && 'off' !== $title_categories) {
			if ( 'flat' === $design && 'link' !== $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title',
					'declaration' => sprintf(
						'background-color:%1$s; border-color:%1$s;',
						esc_html( $accent )
					),
				) );
			}
			if ( 'flat' !== $design || 'link' === $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title a',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $accent )
					),
				) );
			}
			if ('flat' === $design && 'link' !== $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title a',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $accent_text )
					),
				) );
			}
		} elseif ('' !== $title){
			if ( 'flat' !== $design || 'link' === $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $accent )
					),
				) );
			}
			if ( 'flat' === $design && 'link' !== $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title',
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $accent_text )
					),
				) );
			}
			if ( 'flat' === $design && 'link' !== $categories_style ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_title',
					'declaration' => sprintf(
						'background-color:%1$s; border-color:%1$s;',
						esc_html( $accent )
					),
				) );
			}
		}
		
		wp_enqueue_script( 'mh-magazine-js');
		$show_loveit_class = 'on' === $show_loveit ? ' with-loveit' : '';
		$class = " mhc_bg_layout_{$background_layout}";
		if ('list4' !== $magazine_style) $class .= " mhc_style_{$design}";
		if ( 'flat' === $design) $class .= " cat_{$categories_style}" ;
		  
		$args = array( 'posts_per_page' => (int) $posts_number );
		if ( '' !== $offset_posts && ! empty( $offset_posts ) ) {
			$args['offset'] = (int) $offset_posts;
		}
		if ( '' !== $include_categories )
			$args['cat'] = $include_categories;
			
		if ( '' !== $magazine_list )
			$args['orderby'] = $magazine_list;
		
		if ( is_single()){
			global $post;
			$args['post__not_in'] = array( $post->ID );
		}
			$bg_color ='';
	
	
		$the_posts = mh_magazine_get_posts( $args );
		ob_start();
		if( $the_posts->post_count > 0 ) {
		?>
		<div class="mh-magazine mh-container mh-row mh-magazine-list<?php echo $class, $show_loveit_class; ?>">
	<?php 
    $buttons = $category_icons ='';
    
    if ( '' !== $include_categories && 'off' !== $title_categories) :
    	$categories_included = explode ( ',', $include_categories );
        $terms_args = array(
            'include' => $categories_included,
            'orderby' => 'name',
            'order' => 'ASC',
        );
        $terms = get_terms( 'category', $terms_args );
        $category_icons = '<ul class="mh_magazine_head clearfix">';
        foreach ( $terms as $term  ) {
            $category_icons .= sprintf( '<li class="mh_magazine_title%3$s"><a href="%2$s">%1$s</a></li>',
            esc_attr( $term->name ),
            sprintf( esc_url( site_url('/category/%1$s') ), $term->slug),
            ('flat' !== $design ? ' mh-font-heading' : '')
            );
        }
        $category_icons.= '</ul>';
	elseif ('' !== $title):
		$category_icons = '<ul class="mh_magazine_head clearfix">';
		$category_icons .= sprintf( '<li class="mh_magazine_title%2$s">%1$s</li>',
			esc_html( $title ),
			('flat' !== $design ? ' mh-font-heading' : '')
		);
	   $category_icons.= '</ul>';
	endif;
				if ('list4' !== $magazine_style){ echo  $category_icons; }
			
                $count = 0; 
                while ( $the_posts->have_posts() ) {
                $the_posts->the_post(); 
                $post_format = get_post_format();
                $video_overlay = '';
                if ( in_array( $post_format, array( 'video' ) ) ) {$video_overlay = '<div class="video-overlay icon-mhicons"></div>';}
        
    	$author_byline = '';
    	$post_meta_block = '';
        if ( 'on' === $show_author){
            $author_byline = sprintf( '%1$s %2$s',
                mh_get_post_author_pre(),
                mh_get_the_author_posts_link()
            );
        }
		
		$the_views = function_exists('the_views') ? '<span class="mhc_the_views">' . do_shortcode('[views]') . '</span>' : '';
		$the_ratings = class_exists( 'MHReviewsClass') && 'on' === $show_ratings ? do_shortcode('[mh_reviews_meta]') : '';
		$sep = mh_wp_kses( _x( ', ', 'This is a comma followed by a space.','mh-magazine') );
        //check any info to show with two styles
        if ( 'on' === $show_avatar || 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments || 'on' === $show_views ) {
            $post_meta_block = sprintf( '<div class="post-meta post-meta-alt">%1$s <div class="post-meta-inline"><p> %2$s %3$s %4$s %5$s %6$s %7$s %8$s %9$s %10$s</p></div></div>',
                            ( 'on' === $show_avatar
                                    ? mh_get_the_author_avatar('40')
                                    : ''), //1
                            $author_byline, //2
							((( 'on' === $show_author ) && 'on' === $show_date) ? mh_get_post_info_sep()
                                    : ''), //3
                            ( ('on' === $show_date)
                            ? mh_wp_kses( sprintf( __( '%s', 'mhc' ), esc_html( get_the_date( $meta_date ) ) ) )
                                    : ''), //4
                            ((( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories) ? mh_get_post_info_sep()
                                    : ''), //5
                            ('on' === $show_categories
                                    ? get_the_category_list($sep)
                                    : ''), //6
							((( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories) && 'on' === $show_comments) ? mh_get_post_info_sep()
								: ''), //7
								('on' === $show_comments
									? sprintf( esc_html__( '%s Comments','mh-magazine'), number_format_i18n( get_comments_number() ) )
									: ''), //8
								((( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments) && 'on' === $show_views && function_exists('the_views')) ? mh_get_post_info_sep()
								: ''), //9
						'on' === $show_views ? $the_views : ''//10
                        ); //$post_meta_block
                    } //end check any info to show
                    
                $count++;
                $count_class ='';
            if('list1' == $magazine_style){
                $count_class= ' xs';
                 $width =  80;
                 $height =  80;
                if ($count == 1) :
                 $count_class= ' xl';
                 $width =  1080;
                 $height =  675;
                 elseif ($count == 2) :
                 $count_class .= ' second';
                 endif;
                 
                }elseif('list2' == $magazine_style){
                $count_class= ' xl';
                $count_class .= ' all-xl';
                 $width =  1080;
                 $height =  675;
                         
                }elseif('list3' == $magazine_style){
                $count_class= ' xs';
                $count_class .= ' all-xs';
                 $width =  80;
                 $height =  80;
				
				}elseif('list4' == $magazine_style){
                $count_class= ' card clearfix';
				$count_class .= " mhc_style_{$design}";
                 $width =  1080;
                 $height =  675;
				
                         
                }
                $thumb = '';
                $width = (int) apply_filters( 'mh_magazine_image_width', $width );
                $height = (int) apply_filters( 'mh_magazine_image_height', $height );
                $classtext = 'mh_magazine_image';
                $titletext = get_the_title();
                $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
                $thumb = $thumbnail["thumb"];
                ?>
    <article <?php post_class( 'mh-magazine-post' .$count_class); ?>>
     <div class="mh-magazine-post-inner">
     <?php if ( '' !== $thumb && 'on' === $show_thumbnail ){?>
     <div class="mh-magazine-post-thumb">
    <a href="<?php esc_url( the_permalink() ); ?>">
    <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
        <?php echo $video_overlay; ?>
                </a>
                </div>
                <?php } ?>
     <div class="mh-magazine-post-meta">
     <?php if ('list4' === $magazine_style){ echo  $category_icons; } ?>
    <h2><a href="<?php esc_url(the_permalink() ); ?>"><?php the_title(); ?></a><?php  echo $the_ratings; ?></h2>
    <?php if ('list4' !== $magazine_style) echo $post_meta_block; 
	$post_content = get_the_content();
    if('on' == $show_excerpt && (('list1' == $magazine_style && $count == 1) || 'list2' == $magazine_style || 'list4' == $magazine_style)){
		if ( has_excerpt() ) { 
			the_excerpt();
		} else { 
			if ( ! has_shortcode( $post_content, 'mhc_blog' ) && ! has_shortcode( $post_content, 'mhc_portfolio' ) && ! has_shortcode( $post_content, 'mhc_ticker' ) && ! has_shortcode( $post_content, 'mhc_fullwidth_ticker' ) && ! has_shortcode( $post_content, 'mhc_magazine' )  && ! has_shortcode( $post_content, 'mhc_fullwidth_magazine' ) && ! has_shortcode( $post_content, 'mhc_activity' ) )
		truncate_post( 70 );
		} //end nested if
	}
    $more = 'on' == $show_more && (('list1' == $magazine_style && $count == 1) || 'list2' == $magazine_style)
	? sprintf( '%4$s<a href="%1$s" class="more-link%3$s" >%2$s</a>%5$s',
			esc_url( get_permalink() ),
			apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mh-magazine' )),
			'off' !== $show_more_button ? ' mhc_contact_submit' : '',
			'off' !== $show_more_button ? '<div class="mhc_more_link" >' : '', 
			'off' !== $show_more_button ? '</div>' : ''
			)  : '';
    echo $more;  
	if ('list4' === $magazine_style) echo $post_meta_block;
    if (( 'on' === $show_loveit ) && ( function_exists('mh_loveit') )): mh_loveit();  endif;
            ?>
    </div></div>
    </article> <!-- .mhc_post -->
    
    <?php			}
                echo '</div>';
            wp_reset_postdata();
        } else {
            get_template_part( 'includes/no-results', 'index' );
        }
    
        $posts = ob_get_contents();
    
        ob_end_clean();
        
        $output = sprintf(
            '<div%2$s class="mh_magazine_posts%3$s">
                %1$s
            </div> <!-- .mh_magazine_posts -->',
            $posts,
            ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
            ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
        );
		
	return $output;
	}
}
new MHMagazine_Component_Magazine;

class MHMagazine_Component_Fullwidth_Magazine extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Full-width Magazine', 'mh-magazine' );
		$this->slug = 'mhc_fullwidth_magazine';
		$this->fullwidth       = true;
		$this->main_css_element = '%%order_class%%.mh-magazine';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'magazine_list',
			'style',
			'grid_layout',
			'slide_position',
			'include_categories',
			'posts_number',
			'offset_posts',
			'show_categories',
			'text_orientation',
			'categories_style',
			'background_layout',
			'show_title',
			'show_excerpt',
			'show_ratings',
			'accent',
			'accent_text',
			'background',
			'auto',
			'auto_speed',
			'show_pagination',
			'show_arrows',
			'align',
			'infinite_scroll',
			'pagination_style',
			'pagination_color',
			'max_height',
			'gap',
			'custom_radius',
			'container_max_width',
		);
		
		$mh_accent_color = mh_composer_accent_color();
		
		$this->fields_defaults = array(
			'magazine_list'         => array( 'date' ),
			'posts_number'          => array( '6', 'append_default' ),
			'offset_posts'          => array( '0', 'append_default' ),
			'style'         		=> array( 'slide' ),
			'grid_layout'			=> array('3'),
			'slide_position'        => array( 'right' ),
			'show_title'         	=> array( 'on' ),
			'text_orientation'      => array( 'center' ),
			'show_excerpt'          => array( 'on' ),
			'show_ratings'			=> array( 'off' ),
			'show_categories'       => array( 'on' ),
			'background_layout'     => array( 'light' ),
			'categories_style'      => array( 'parallel' ),
			'accent' 				=> array( $mh_accent_color, 'append_default' ),
			'accent_text'           => array( '#ffffff', 'append_default' ),
			'auto'         		  	=> array( 'off' ),
			'auto_speed'          	=> array( '7000', 'append_default' ),
			'show_pagination'       => array( 'on' ),
			'show_arrows'           => array( 'off' ),
			'infinite_scroll'	    => array( 'on' ),
			'pagination_style'	  	=> array( 'dots' ),
			'gap'	   				=> array( '0', 'append_default' ),
			'custom_radius'	   			=> array( '0', 'append_default' ),
		);
	}
	
	function get_fields() {
		$fields = array(
			'magazine_list' => array(
				'label'             => esc_html__( 'Content Type', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'date'  			=> esc_html__( 'Latest', 'mh-magazine' ),
					'comment_count'   => esc_html__( 'Popular', 'mh-magazine' ),
					'title' 		   => esc_html__( 'Title', 'mh-magazine' ),
					'rand' 			=> esc_html__( 'Random', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Order by: Latest - the most recent articles, Popular - the most commented, Title, or Random.', 'mh-magazine' ),
			),
			'style' => array(
				'label'             => esc_html__( 'Layout', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'slide'  			=> esc_html__( 'Posts slider', 'mh-magazine' ),
					'carousel'  		=> esc_html__( 'Posts carousel', 'mh-magazine' ),
					'gallery'  		  	=> esc_html__( 'Posts gallery', 'mh-magazine' ),
					'grid'  		  	=> esc_html__( 'Posts Grid', 'mh-magazine' ),
				),
				'affects'           => array(
					'#mhc_grid_layout',
					'#mhc_posts_number',
					'#mhc_slide_position',
					'#mhc_text_orientation',
					'#mhc_show_title',
					'#mhc_background',
					'#mhc_show_excerpt',
					'#mhc_background_layout',
					'#mhc_show_pagination',
					'#mhc_show_arrows',
					'#mhc_align',
					'#mhc_auto',
					'#mhc_infinite_scroll',
					'#mhc_pagination_style',
					'#mhc_pagination_color',
					'#mhc_max_height',
					'#mhc_gap',
					'#mhc_custom_radius',
					'#mhc_container_max_width',
				),
				'description'        => esc_html__( 'Choose the desired layout.', 'mh-magazine' ),
			),
			'grid_layout' => array(
				'label'             => esc_html__( 'Grid Layout', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'1'  			=> esc_html__( '1 Post', 'mh-magazine' ),
					'2'  			=> esc_html__( '2 Posts', 'mh-magazine' ),
					'3'  			=> esc_html__( '3 Posts', 'mh-magazine' ),
					'4'  			=> esc_html__( '4 Posts', 'mh-magazine' ),
					'5'  			=> esc_html__( '5 Posts', 'mh-magazine' ),
					'6'  			=> esc_html__( '6 Posts', 'mh-magazine' ),
					'7'  			=> esc_html__( '7 Posts', 'mh-magazine' ),
					'8'  			=> esc_html__( '8 Posts', 'mh-magazine' ),
				),
				'depends_show_if'   => 'grid',
				'description'        => esc_html__( 'Choose the desired grid layout.', 'mh-magazine' ),
			),
			'slide_position' => array(
				'label'             => esc_html__( 'Navigation Position', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'right'  			=> esc_html__( 'Right', 'mh-magazine' ),
					'left'  		     => esc_html__( 'Left', 'mh-magazine' ),
					'off'  			  => esc_html__( 'Hide', 'mh-magazine' ),
				),
				'depends_show_if'   => 'slide',
				'description'        => esc_html__( 'Toggle between the navigation positions.', 'mh-magazine' ),
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'mh-magazine' ),
				'renderer'         => 'mh_composer_include_categories_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'mh-magazine' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to show.', 'mh-magazine' ),
				'depends_show_if_not'   => 'grid',
			),
			'offset_posts' => array(
				'label'           => esc_html__( 'Offset Posts', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose by how many posts you would like to offset. Numeric value only.', 'mh-magazine' ),
			),
			'background_layout' => array(
				'label'       => esc_html__( 'Text Colour', 'mh-magazine' ),
				'type'        => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'mh-magazine' ),
					'dark'  => esc_html__( 'Light', 'mh-magazine' ),
				),
				'depends_show_if'   => 'slide',
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-magazine' ),
			),
			'accent' => array(
				'label'             => esc_html__( 'Accent Colour', 'mh-magazine' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Here you can define a custom colour for the buttons.', 'mh-magazine' ),
			),
			'accent_text' => array(
				'label'             => esc_html__( 'Buttons Text Colour', 'mh-magazine' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Here you can define a custom colour.', 'mh-magazine' ),
			),
			'background' => array(
				'label'             => esc_html__( 'Background Colour', 'mh-magazine' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'carousel',
				'description'       => esc_html__( 'Here you can define a custom background colour.', 'mh-magazine' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => mh_composer_get_text_orientation_options_no_just(),
				'depends_show_if_not'   => 'carousel',
				'description'       => esc_html__( 'This controls how your text is aligned.', 'mh-magazine' ),
			),
			'show_categories' => array(
				'label'             => esc_html__( 'Show Categories', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show categories links.', 'mh-magazine' ),
			),
			'categories_style' => array(
				'label'             => esc_html__( 'Category Style', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'parallel'  		=> esc_html__( 'Parallel', 'mh-magazine' ),
					'classic'   		=> esc_html__( 'Button', 'mh-magazine' ),
					'bold'   			=> esc_html__( 'Bold', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Choose the desired style.', 'mh-magazine' ),
			),
			'show_title' => array(
				'label'             => esc_html__( 'Show Title', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'On', 'mh-magazine' ),
					'off' => esc_html__( 'Off', 'mh-magazine' ),
				),
				'depends_show_if'   => 'slide',
				'description'       => esc_html__( 'Here you can define whether to show the title on the slide image.', 'mh-magazine' ),
			),
			'show_excerpt' => array(
				'label'             => esc_html__( 'Show Excerpt', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'On', 'mh-magazine' ),
					'off' => esc_html__( 'Off', 'mh-magazine' ),
				),
				'depends_show_if_not'   => 'carousel',
				'description'       => esc_html__( 'Here you can define whether to show excerpts. Some layouts do not show excerpts.', 'mh-magazine' ),
			),
			'show_ratings' => array(
				'label'             => esc_html__( 'Show Ratings', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'off' => esc_html__( 'No', 'mh-magazine' ),
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show reviews rating. For this option to work you must have "MH REVIEWS" plugin installed and activated.', 'mh-magazine' ),
			),
			'show_arrows' => array(
				'label'           => esc_html__( 'Show Arrows','mh-magazine' ),
				'type'              => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No','mh-magazine' ),
					'on'  => esc_html__( 'Yes','mh-magazine' ),
				),
				'depends_show_if'   => 'gallery',
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.','mh-magazine' ),
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Show Controls','mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes','mh-magazine' ),
					'off' => esc_html__( 'No','mh-magazine' ),
				),
				'depends_show_if'   => 'gallery',
				'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom.','mh-magazine' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-magazine' ),
					'on'  => esc_html__( 'On', 'mh-magazine' ),
				),
				'affects' => array(
					'#mhc_auto_speed',
				),
				'depends_show_if_not'   => 'grid',
				'description'        => esc_html__( 'If you would like the slider to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-magazine' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-magazine' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'mh-magazine' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'mh-magazine' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-magazine' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'max_height' => array(
				'label'           => esc_html__( 'Maximum Height','mh-magazine' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
				'depends_show_if_not'   => 'carousel',
				'description'     => esc_html__( 'This will change the maximum height for the images.','mh-magazine' ),
			),
			'infinite_scroll' => array(
				'label'           => esc_html__( 'Infinite Rotation','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'On','mh-magazine' ),
					'off' => esc_html__( 'Off','mh-magazine' ),
				),
				'depends_show_if'   => 'gallery',
				'tab_slug'          => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'First Item Alignment','mh-magazine' ),
				'type'            => 'select',
				'options'         => array(
					'center'  	 => esc_html__( 'Centre','mh-magazine' ),
					'right' 	=> esc_html__( 'Right','mh-magazine' ),
					'left' 	=> esc_html__( 'Left','mh-magazine' ),
				),
				'depends_show_if'   => 'gallery',
				'tab_slug'          => 'advanced',
			),
			'pagination_style' => array(
				'label'           => esc_html__( 'Pagination Style','mh-magazine' ),
				'type'            => 'select',
				'options'         => array(
					'dots' => esc_html__( 'Dots','mh-magazine' ),
					'lines'  => esc_html__( 'Lines','mh-magazine' ),
				),
				'depends_show_if'   => 'gallery',
				'description'       => esc_html__( 'Define the style for the pagination.','mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'pagination_color' => array(
				'label'           => esc_html__( 'Pagination Colour','mh-magazine' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the arrows and pagination.','mh-magazine' ),
				'depends_show_if'   => 'gallery',
				'tab_slug'          => 'advanced',
				'custom_color' => true,
			),
			'container_max_width' => array(
				'label'           => esc_html__( 'Container Maximum Width','mh-magazine' ),
				'type'            => 'text',
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
				'depends_show_if'   => 'grid',
				'description'     => esc_html__( 'This will change the container maximum width. For best result keep the max width between 1366 and 795.','mh-magazine' ),
			),
			'gap' => array(
				'label'           => esc_html__( 'Gap', 'mh-magazine' ),
				'type'            => 'range',
				'default'         => '0',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'depends_show_if'   => 'grid',
			),
			'custom_radius' => array(
				'label'           => esc_html__( 'Corners Radius', 'mh-magazine' ),
				'type'            => 'range',
				'default'         => '0',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'depends_show_if'   => 'grid',
			),
			
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          			= $this->shortcode_atts['module_id'];
		$module_class       			= $this->shortcode_atts['module_class'];
		$magazine_list 					= $this->shortcode_atts['magazine_list'];
		$include_categories 			= $this->shortcode_atts['include_categories'];
		$posts_number       			= $this->shortcode_atts['posts_number'];
		$offset_posts      			  	= $this->shortcode_atts['offset_posts'];
		$style				     	 	= $this->shortcode_atts['style'];
		$grid_layout					= $this->shortcode_atts['grid_layout'];
		$slide_position					= $this->shortcode_atts['slide_position'];
		$show_excerpt				  	= $this->shortcode_atts['show_excerpt'];
		$show_ratings			    	= $this->shortcode_atts['show_ratings'];
		$text_orientation			  	= $this->shortcode_atts['text_orientation'];
		$show_categories			   	= $this->shortcode_atts['show_categories'];
		$background_layout  			= $this->shortcode_atts['background_layout'];
		$show_title						= $this->shortcode_atts['show_title'];
		$categories_style			  	= $this->shortcode_atts['categories_style'];
		$auto    					  	= $this->shortcode_atts['auto'];
		$auto_speed     				= $this->shortcode_atts['auto_speed'];
		$background						= $this->shortcode_atts['background'];
		$accent							= $this->shortcode_atts['accent'];
		$accent_text				   	= $this->shortcode_atts['accent_text'];
		$show_pagination        	   	= $this->shortcode_atts['show_pagination'];
		$show_arrows        		   	= $this->shortcode_atts['show_arrows'];
		$align                  		= $this->shortcode_atts['align'];
		$infinite_scroll        	   	= $this->shortcode_atts['infinite_scroll'];
		$pagination_style	   		  	= $this->shortcode_atts['pagination_style'];
		$pagination_color	   		  	= $this->shortcode_atts['pagination_color'];
		$max_height             		= $this->shortcode_atts['max_height'];
		$container_max_width			= $this->shortcode_atts['container_max_width'];
		$gap							= $this->shortcode_atts['gap'];
		$custom_radius							= $this->shortcode_atts['custom_radius'];
		
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( '' !== $max_height ) {
			if ('slide' === $style) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .main-tab-image',
					'declaration' => sprintf(
						'max-height: %1$s;',
						esc_attr( $max_height )
					),
				) );
			}elseif('gallery' === $style) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc_magzaine_gallery_items',
					'declaration' => sprintf(
						'max-height: %1$s; height: %1$s;',
						esc_attr( $max_height )
					),
				) );
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mhc_magazine_gallery_item',
					'declaration' => 'height: 100%;'
				) );
			
			}elseif('grid' === $style) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_grid_item',
					'declaration' => sprintf(
						'height: %1$s;',
						esc_attr( $max_height )
					),
				) );
			}
		}
		
		
		if('grid' === $style) {
			if ( '' !== $container_max_width ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_grid_container',
					'declaration' => sprintf(
						'max-width: %1$s;',
						esc_attr( $container_max_width )
					),
				) );
			}
			if ( '' !== $gap ) {
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%% .mh_magazine_grid_item',
					'declaration' => sprintf(
						'padding: %1$s;',
						esc_html( mh_composer_process_range_value( $gap ) )
					),
				) );
				MHComposer_Core::set_style( $function_name, array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf(
						'padding-top: %1$s; padding-bottom: %2$s;',
						esc_html( mh_composer_process_range_value( $gap*2 ) ),
						esc_html( mh_composer_process_range_value( $gap ) )
					),
				) );
				if ( '' !== $custom_radius ) {
					MHComposer_Core::set_style( $function_name, array(
						'selector'    => '%%order_class%% .mh_magazine_grid_item .mhc_portfolio_image',
						'declaration' => sprintf(
							'-webkit-border-radius: %1$s; -moz-border-radius: %1$s; border-radius: %1$s;',
							esc_html( mh_composer_process_range_value( $custom_radius ) )
						),
					) );
				}
			}
		}
		
		if ( 'slide' === $style && '' !== $background ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .slideshow-posts-wrap',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background )
				),
			) );
		}
		
		if ( 'slide' === $style && 'off' !== $slide_position) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh-slideshow-tabs-wrap',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $accent )
				),
			) );
		}
		if ('on' === $show_categories) {
			if ('bold' === $categories_style){
				MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_magazine_title',
				'declaration' => sprintf(
					'color: %1$s; font-weight:bold; opacity:0.8;',
					esc_html( $accent_text )
				),
			) );
			}
			if ('bold' !== $categories_style) {
				MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_magazine_title',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $accent_text )
				),
			) );
			}
			if ('parallel' === $categories_style && 'center' !== $text_orientation && 'grid' === $style){
				MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% ul.mh_magazine_head',
				'declaration' => sprintf(
					'padding: 0 10px;'
				),
			) );
			}
			
			if ('bold' !== $categories_style) {
				MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh_magazine_title',
				'declaration' => sprintf(
					'background-color:%1$s; border-color:%1$s;',
					esc_html( $accent )
				),
			) );
			}
		}
		if ( 'gallery' === $style) {
			if ( 'lines' === $pagination_style ) {
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot',
					'declaration' => 'width:30px;',
				) );
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot::before',
					'declaration' => 'height:7px;',
				) );
			}
			
			if ( '' !== $pagination_color ) {
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-prev-next-button .arrow',
					'declaration' => sprintf(
						'fill:%1$s;',
					esc_html( $pagination_color ))
				) );
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-prev-next-button.no-svg',
					'declaration' => sprintf(
						'color:%1$s;',
					esc_html( $pagination_color ))
				) );
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot::before',
					'declaration' => sprintf(
						'background-color:%1$s !important; opacity:0.5;',
					esc_html( $pagination_color ))
				) );
				MHComposer_Component::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flickity-page-dots .dot.is-selected::before',
					'declaration' => sprintf(
						'background-color:%1$s !important; opacity:1;',
					esc_html( $pagination_color ))
				) );
			}
		}
	if ('gallery' == $style) {
		wp_enqueue_script( 'flickity' );
	} elseif ( 'grid' == $style ){
		wp_enqueue_script( 'jquery-masonry-3' );
	} else {
		wp_enqueue_script( 'mh-magazine-js' );
	}

	$args = array();
	if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
		if ('grid' !== $style){
			$args['posts_per_page'] = $posts_number;
		}else{
			$args['posts_per_page'] = (int) $grid_layout;
		}
	} else {
		$args['nopaging'] = true;
	}
	if ( '' !== $offset_posts && ! empty( $offset_posts ) ) {
		$args['offset'] = (int) $offset_posts;
	}
	if ( '' !== $include_categories )
		$args['cat'] = $include_categories;
		
	if ( '' !== $magazine_list )
		$args['orderby'] = $magazine_list;
		
	if ( is_single()){
		global $post;
		$args['post__not_in'] = array( $post->ID );
	}	

	$class = " mhc_text_align_{$text_orientation} cat_{$categories_style}";
	if ('slide' === $style){
		$class .= " mhc_bg_layout_{$background_layout}";
	}
	
	if ( 'slide' === $style ) {
		$class .= " slide_position_{$slide_position}";
	}	
	if ( 'gallery' === $style ) {
		$class .= 'lines' === $pagination_style ? ' mhc_controllers_corners' : '';
		$class .= 'on' === $auto ? ' mh_slider_auto mh_slider_speed_' . esc_attr( $auto_speed ) : '';
	}

$mh_slideshow_tabs_output = $mh_slideshow_tabs_content = '';
	$the_posts = mh_magazine_get_posts( $args );
	ob_start();
	
	if( $the_posts->post_count > 0 ) {
		$count = 0; 
		$i = 1;
		while ( $the_posts->have_posts() ) {
			$the_posts->the_post(); 
			$post_format = get_post_format();
			$video_overlay = '';
			$the_ratings = class_exists( 'MHReviewsClass') && 'on' === $show_ratings ? do_shortcode('[mh_reviews_meta]') : '';
			if ( in_array( $post_format, array( 'video' ) ) ) {$video_overlay = '<div class="video-overlay icon-mhicons"></div>';}
			//catusel
			if ('carousel' === $style){?>           
			<div <?php post_class( 'mhc_portfolio_item ' ); ?>>
			<?php
				$thumb = '';

				$width = 320;
				$width = (int) apply_filters( 'mhc_portfolio_image_width', $width );

				$height = 241;
				$height = (int) apply_filters( 'mhc_portfolio_image_height', $height );

				list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $width, $height ) );

				$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

				if ( '' !== $thumb_src ) : ?>
					<div class="mhc_portfolio_image <?php echo esc_attr($orientation ); ?>">
						<a href="<?php esc_url( the_permalink() ); ?>">
							<img src="<?php echo esc_url( $thumb_src); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
                            <?php echo $video_overlay; ?>
							<div class="meta">
                                <?php if ('on' === $show_categories):
								echo '<ul class="mh_magazine_head">';
 										foreach((get_the_category()) as $category) { 
											$category_element = sprintf(
											'<li class="mh_magazine_title"><span>%1$s</span></li>',
												esc_html($category->cat_name)
											);
										echo $category_element;	 
											 }
											 echo '</ul>';
									 endif;?>
									<h3><?php the_title(); ?><?php  echo $the_ratings; ?></h3>
							</div>
                            <span class="mh-magazine-overlay"></span>
						</a>
					</div>
			<?php endif; ?>
			</div>
		<?php 
									   
		}elseif('grid' === $style){
			
			
			?>
			<div <?php post_class( 'mh_magazine_grid_item mh_magazine_grid_item_' . $i ); ?>>
			<?php
				$thumb = '';
				
				$width = 1080;
				$width = (int) apply_filters( 'mh_magazine_grid_image_width', $width );

				$height = 675;
				$height = (int) apply_filters( 'mh_magazine_grid_image_height', $height );
				$thumbnail = get_thumbnail( $width, $height );
				$thumb = $thumbnail["thumb"];
				
				

				list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $width, $height ) );

				$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

				if ( '' !== $thumb_src ) {
					$bg_thumb = sprintf(
					'style="background-image: url(%1$s);"',
					esc_url( $thumb )
					);
				}

				if ( '' !== $thumb_src ) : ?>
					<div class="mhc_portfolio_image <?php echo esc_attr($orientation ); ?>" <?php echo $bg_thumb; ?>>
						<a href="<?php esc_url( the_permalink() ); ?>">
							<?php /*?><img src="<?php echo esc_url( $thumb_src); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/><?php */?>
                            <?php echo $video_overlay; ?>
							<div class="meta">
                                <?php if ('on' === $show_categories):
								echo '<ul class="mh_magazine_head">';
 										foreach((get_the_category()) as $category) { 
											$category_element = sprintf(
											'<li class="mh_magazine_title"><span>%1$s</span></li>',
												esc_html($category->cat_name)
											);
										echo $category_element;	 
											 }
											 echo '</ul>';
									 endif;?>
									<h2><?php the_title(); ?><?php  echo $the_ratings; ?></h2>
									
									<?php $post_content = get_the_content();
									   if('on' == $show_excerpt): 
												if ( has_excerpt() ) { 
													the_excerpt();
												} else { 
													if ( ! has_shortcode( $post_content, 'mhc_blog' ) && ! has_shortcode( $post_content, 'mhc_portfolio' ) && ! has_shortcode( $post_content, 'mhc_ticker' ) && ! has_shortcode( $post_content, 'mhc_fullwidth_ticker' ) && ! has_shortcode( $post_content, 'mhc_magazine' )  && ! has_shortcode( $post_content, 'mhc_fullwidth_magazine' ) && ! has_shortcode( $post_content, 'mhc_activity' ) ) truncate_post( 110 );
												} //end nested if
												endif;
									?>		
							</div>
                            <span class="mh-magazine-overlay"></span>
						</a>
					</div>
			<?php endif; ?>
				</div>
		<?php 
			$i++;
		
		//slide
		}else{?>
        <?php
				$thumb ='';
				$width = (int) apply_filters( 'mh_slideshow_image_width', 1080 );
				$height = (int) apply_filters( 'mh_slideshow_image_height', 675 );
				$title = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, '', $title, $title, false, 'Slideshow' );
				$thumb = $thumbnail["thumb"];
				if ( '' !== $thumb ) :
				$mh_slideshow_tabs_output .= sprintf(
					'<div class="slideshow-tab" style="border-color:%2$s;">
						<span class="slideshow-tab-title">%1$s</span>
					</div>',
					 esc_html( get_the_title() ),
					 esc_attr( $accent)
				);

				if ( 'slide' === $style) {
					echo '<div class="slideshow-post">';
				}elseif ('gallery' === $style) {
					echo '<div class="mhc_magazine_gallery_item">';
				}
				?>
								<div class="main-tab-image">
									<a href="<?php esc_url( the_permalink() ); ?>">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $title, $width, $height ); ?>
                                        	<?php echo $video_overlay; ?>
									</a>
								</div>
	<?php if ('on' === $show_categories || 'on' === $show_title || 'on' === $show_excerpt){ ?>
                        <div class="mh-slideshow-meta">
							<?php if ('on' === $show_categories):
								echo '<ul class="mh_magazine_head">';
 									foreach((get_the_category()) as $category) { 
										$category_element = sprintf(
											'<li class="mh_magazine_title"><span>%1$s</span></li>',
											esc_html($category->cat_name)
										);
										echo $category_element;	 
									}
								echo '</ul>';
							endif;
							if ('gallery' === $style || ('slide' === $style && 'on' === $show_title)){?>
								<h2><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a><?php  echo $the_ratings; ?></h2>
								<?php } ?>
                               <?php  
							   $post_content = get_the_content();
							   if('on' == $show_excerpt): 
										if ( has_excerpt() ) { 
											the_excerpt();
										} else { 
											if ( ! has_shortcode( $post_content, 'mhc_blog' ) && ! has_shortcode( $post_content, 'mhc_portfolio' ) && ! has_shortcode( $post_content, 'mhc_ticker' ) && ! has_shortcode( $post_content, 'mhc_fullwidth_ticker' ) && ! has_shortcode( $post_content, 'mhc_magazine' )  && ! has_shortcode( $post_content, 'mhc_fullwidth_magazine' ) && ! has_shortcode( $post_content, 'mhc_activity' ) ) truncate_post( 110 );
										} //end nested if
							   			echo ' <a href="' . esc_url( get_permalink()) . '" class="more-link" style= "color:' . esc_attr( $accent) . '">'.  apply_filters( 'mh_read_more_text_filter', esc_html__( 'Read more', 'mh-magazine' )) .'</a>';
							   		endif;?>
                                </div>
                                <?php } ?>
							</div> <!-- .slideshow-post -->
                                          <?php endif; ?>
				<?php
							$i++;
				?>
			
<?php
			}
		}
	}
	wp_reset_postdata();
	$posts = ob_get_clean();

	if('carousel' === $style){
	$output = sprintf(
		'<div%2$s class="mh-magazine mh-magazine-carousel mhc_fullwidth_portfolio mhc_fullwidth_portfolio_carousel mhc_bg_layout_dark%1$s%3$s" data-auto-rotate="%4$s" data-auto-rotate-speed="%5$s">
			<div class="mhc_portfolio_items clearfix" data-columns="">
				%6$s
			</div><!-- .mhc_portfolio_items -->
		</div> <!-- .mhc_fullwidth_portfolio -->',	
		esc_attr( $class ),
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
		( '' !== $auto && in_array( $auto, array('on', 'off') ) ? esc_attr( $auto ) : 'off' ),
		( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
		$posts
	);
	}elseif ('slide' === $style){
	$output = sprintf(
		'<div%2$s class="mh-magazine mh-magazine-slideshow mhc_container clearfix%1$s%3$s">
		<div class="slideshow-posts-wrap clearfix">
			%4$s%5$s
		</div></div> <!-- .mh-magazine-slideshow -->',
		esc_attr( $class ),//1
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),//2
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),//3
		('off' !== $slide_position && '' !== $mh_slideshow_tabs_output ? sprintf(
			'<div class="slideshow-tabs slideshow-column">
				<div class="mh-slideshow-tabs-content">
					<div class="mh-slideshow-tabs-wrap" style="color:%2$s;">
					%1$s
					</div>
				</div>
			</div> <!-- .slideshow-tabs -->',
			$mh_slideshow_tabs_output,
			esc_attr( $accent)
			) : ''), //4
						
		('' !== $posts ? sprintf('<div class="slideshow-posts%6$s" data-auto="%2$s" data-speed="%3$s" data-show="%4$s" data-rtl="%5$s"data-nav="%7$s">%1$s</div> <!-- .slideshow-posts -->',
			$posts,
			( 'on' !== $auto ? 'false' : 'true' ),
			( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
			( '' !== $posts_number && $posts_number  <= 4 ? (int) $posts_number -1 : 4) ,
			is_rtl() ? 'true' : 'false',
			('off' !== $slide_position ? ' slideshow-column' : ''),
			('off' !== $slide_position ? 'true' : 'false')
			) : ''), //5
		( '' !== $background ? sprintf(' style="background-color:%1$s;"', esc_attr( $background)) : '')
		);
	} elseif('gallery' === $style) {
		$output = sprintf(
			'<div%1$s class="mhc_module mhc_flickity_continer mh-magazine mhc_magazine_gallery clearfix%2$s%10$s">
				<div class="mhc_magzaine_gallery_items mhc_flickity" data-pagination="%3$s" data-arrows="%4$s" data-auto="%5$s" data-speed="%6$s" data-align="%7$s" data-infinite="%8$s" data-setsize="%9$s">
					%11$s
				</div>
			</div><!-- .mhc_gallery -->',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			'off' !== $show_pagination  ? 'on' : 'off',
			'off' !== $show_arrows ? 'on' : 'off',
			'off' !== $auto ? 'on' : 'off',
			'' !== $auto_speed ?  esc_attr( $auto_speed ) : '7000',
			'center' !== $align ?  esc_attr( $align ) : 'center',
			'off' !== $infinite_scroll ? 'on' : 'off',
			'' !==  $max_height ? 'off' : 'on',
			esc_attr( $class ),
			$posts
		);
	} elseif('grid' === $style) {
		$output = sprintf(
			'<div%1$s class="mhc_module mh-magazine mh_magazine_grid mh_magazine_grid_%4$s mhc_bg_layout_dark%3$s clearfix%2$s">
				<div class="mh_magazine_grid_container">
				<div class="mh_magazine_grid_sizer"></div>
					%5$s
				</div>
			</div><!-- .mh_magazine_grid -->',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			esc_attr( $class ),
			(int) $grid_layout,
			$posts
		);
	}
		
	return $output;
	}
}
new MHMagazine_Component_Fullwidth_Magazine;

class MHMagazine_Component_Ticker extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Ticker', 'mh-magazine' );
		$this->slug = 'mhc_ticker';
		$this->main_css_element = '%%order_class%%.mh-magazine-ticker-wrapper';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'magazine_list',
			'include_categories',
			'posts_number',
			'offset_posts',
			'background_layout',
			'show_thumbnail',
			'show_arrows',
			'auto',
			'auto_speed',
			'background',
			'fade',
			'pause',
			'ticker_title',
			
		);
		
		$mh_accent_color = mh_composer_accent_color();

		$this->fields_defaults = array(
			'magazine_list'         	=> array( 'date' ),
			'posts_number'          	 => array( '5', 'append_default' ),
			'offset_posts'          	 => array( '0', 'append_default' ),
			'background_layout'        => array( 'dark' ),
			'show_thumbnail'           => array( 'on' ),
			'show_arrows'         	  => array( 'on' ),
			'auto'         			 => array( 'off' ),
			'auto_speed'          	   => array( '3000', 'append_default' ),
			'background'          	   => array( $mh_accent_color, 'append_default' ),
			'fade'         			 => array( 'fade' ),
			'pause'         			=> array( 'off' ),
		);
	}
	
	function get_fields() {
		$fields = array(
			'magazine_list' => array(
				'label'             => esc_html__( 'Content Type', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'date'  			=> esc_html__( 'Latest', 'mh-magazine' ),
					'comment_count'   => esc_html__( 'Popular', 'mh-magazine' ),
					'title' 		   => esc_html__( 'Title', 'mh-magazine' ),
					'rand' 			=> esc_html__( 'Random', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Order by: Latest - the most recent articles, Popular - the most commented, Title, or Random.', 'mh-magazine' ),
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'mh-magazine' ),
				'renderer'         => 'mh_composer_include_categories_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'mh-magazine' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to show.', 'mh-magazine' ),
			),
			'offset_posts' => array(
				'label'           => esc_html__( 'Offset Posts', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose by how many posts you would like to offset. Numeric value only.', 'mh-magazine' ),
			),
			'ticker_title' => array(
				'label'           => esc_html__( 'Title', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Here you can define a title for your ticker, or leave empty.', 'mh-magazine' ),
			),
			'background_layout' => array(
				'label'       => esc_html__( 'Text Colour', 'mh-magazine' ),
				'type'        => 'select',
				'options'           => array(
					'dark'  => esc_html__( 'Light', 'mh-magazine' ),
					'light' => esc_html__( 'Dark', 'mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-magazine' ),
			),
			'background' => array(
				'label'             => esc_html__( 'Ticker Colour', 'mh-magazine' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Use the colour picker to choose the background colour for your ticker.', 'mh-magazine' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Featured Image', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the post featured image.', 'mh-magazine' ),
			),
			'show_arrows'         => array(
				'label'           => esc_html__( 'Show Arrows', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows for your ticker.', 'mh-magazine' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-magazine' ),
					'on'  => esc_html__( 'On', 'mh-magazine' ),
				),
				'affects' => array(
					'#mhc_auto_speed',
					'#mhc_fade',
					'#mhc_pause',
				),
				'description'        => esc_html__( 'If you would like the slider to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-magazine' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-magazine' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'mh-magazine' ),
			),
			'fade' => array(
				'label'             => esc_html__( 'Ticker Animation', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'fade'  			=> esc_html__( 'Fade', 'mh-magazine' ),
					'slide'  		   => esc_html__( 'Slide', 'mh-magazine' ),
					'vertical'  		=> esc_html__( 'Slide Vertically', 'mh-magazine' ),
				),
				'depends_default'   => true,
				'description'        => esc_html__( 'Here you can choose the style for your ticker.', 'mh-magazine' ),
			),
			'pause'         => array(
				'label'           => esc_html__( 'Pause on Hover', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-magazine' ),
					'on'  => esc_html__( 'On', 'mh-magazine' ),
				),
				'description'     => esc_html__( 'Here you can choose to pause the ticker on hover.', 'mh-magazine' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'mh-magazine' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-magazine' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide on', 'mh-magazine' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'mh-magazine' ),
					'tablet'  => esc_html__( 'Tablet', 'mh-magazine' ),
					'desktop' => esc_html__( 'Desktop', 'mh-magazine' ),
				),
				'additional_att'  => 'disable_on',
				'description'     => esc_html__( 'This will hide the component on selected devices', 'mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          			 = $this->shortcode_atts['module_id'];
		$module_class       			  = $this->shortcode_atts['module_class'];
		$magazine_list 				 = $this->shortcode_atts['magazine_list'];
		$include_categories 			= $this->shortcode_atts['include_categories'];
		$posts_number       			  = $this->shortcode_atts['posts_number'];
		$offset_posts      			  = $this->shortcode_atts['offset_posts'];
		$background_layout  			 = $this->shortcode_atts['background_layout'];
		$show_thumbnail     			= $this->shortcode_atts['show_thumbnail'];
		$show_arrows     			   = $this->shortcode_atts['show_arrows'];
		$auto    					  = $this->shortcode_atts['auto'];
		$auto_speed     				= $this->shortcode_atts['auto_speed'];
		$background     				= $this->shortcode_atts['background'];
		$fade     					  = $this->shortcode_atts['fade'];
		$pause     					 = $this->shortcode_atts['pause'];
		$ticker_title     			  = $this->shortcode_atts['ticker_title'];
		
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		wp_enqueue_script( 'mh-magazine-js');
		$args = array();
		if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
			$args['posts_per_page'] = $posts_number;
		} else {
			$args['nopaging'] = true;
		}
		if ( '' !== $offset_posts && ! empty( $offset_posts ) ) {
			$args['offset'] = (int) $offset_posts;
		}
		if ( '' !== $include_categories )
			$args['cat'] = $include_categories;
			
		if ( '' !== $magazine_list )
			$args['orderby'] = $magazine_list;
		
		$fullwidth = 'mhc_fullwidth_ticker' === $function_name ? 'on' : 'off';
		$class = " mhc_bg_layout_{$background_layout}";
		
		$ticker_bg = '';
		if ( '' !== $background ) {
			$ticker_bg = sprintf( ' style="background-color: %s;"',
			esc_attr( $background )
			);
		}
		if ( is_single()){
			global $post;
			$args['post__not_in'] = array( $post->ID );
		}
		$the_posts = mh_magazine_get_posts( $args );
		ob_start();
		if( $the_posts->post_count > 0 ) {
		while ( $the_posts->have_posts() ) {
				$the_posts->the_post(); 
				$thumb ='';
				$width = (int) apply_filters( 'mh_ticker_image_width', 80 );
				$height = (int) apply_filters( 'mh_ticker_image_height', 80 );
				$title = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, '', $title, $title, false, 'Ticker' );
				$thumb = $thumbnail["thumb"];
				?>
				<div class="mh-ticker-post" <?php echo $ticker_bg; ?>>
				<a class="mh-ticker-title" href="<?php esc_url( the_permalink() ); ?>">
				  <?php if ( '' !== $thumb && 'off' !== $show_thumbnail ) :?>
				<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $title, $width, $height ); ?>
				<?php endif; ?>
				<?php the_title(); ?>
				</a>
				</div>
				<?php
					}
		}
		wp_reset_postdata();
		
		$posts = ob_get_clean();
		
		$output = sprintf(
			'<div%1$s class="mh-magazine-ticker-wrapper clearfix%2$s%8$s%9$s"%7$s>
			<div class="%14$s">
				%15$s
				<div class="mh-magazine-ticker" data-arrows="%5$s" data-auto="%3$s" data-speed="%4$s" data-fx="%11$s" data-pause="%13$s"%10$s%12$s>
					%6$s
				</div><!-- .mh-magazine-ticker -->
				</div>
			</div> <!-- .mh-magazine-ticker-wrapper-->',	
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),//1
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),//2
			( 'on' !== $auto ? 'false' : 'true' ),
			( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
			( 'on' === $show_arrows ? 'true' : 'false' ),
			$posts,
			$ticker_bg,
			('off' !== $show_thumbnail ? ' mh-ticker-with-img' : ''),
			esc_attr( $class ),
			('vertical' !== $fade && is_rtl() ? ' data-rtl="true"' : ''),
			('fade' !== $fade ? 'false' : 'true'),
			('vertical'!== $fade ? '' : ' data-vertical="true"'),
			('off' !== $pause ? 'true' : 'false'),
			('on' === $fullwidth ? 'mhc_container' : 'not_fullwidth_ticker'),
	( '' !== $ticker_title ? sprintf( '<div class="ticker-pin" style="width: auto;"><span class="pin-title">%1$s</span><span class="pin-arrow"></span></div>',
			esc_attr( $ticker_title ) ) : '')
		);
	
		return $output;
	}
}
new MHMagazine_Component_Ticker;

class MHMagazine_Component_Fullwidth_Ticker extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Full-width Ticker', 'mh-magazine' );
		$this->slug = 'mhc_fullwidth_ticker';
		$this->fullwidth       = true;
		$this->main_css_element = '%%order_class%%.mh-magazine-ticker-wrapper';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'magazine_list',
			'include_categories',
			'posts_number',
			'offset_posts',
			'background_layout',
			'show_thumbnail',
			'show_arrows',
			'auto',
			'auto_speed',
			'background',
			'fade',
			'pause',
			'ticker_title',
			
		);

		$this->fields_defaults = array(
			'magazine_list'         	=> array( 'date' ),
			'posts_number'          	 => array( '5', 'append_default' ),
			'offset_posts'          	 => array( '0', 'append_default' ),
			'background_layout'        => array( 'dark' ),
			'show_thumbnail'           => array( 'on' ),
			'show_arrows'         	  => array( 'on' ),
			'auto'         			 => array( 'off' ),
			'auto_speed'          	   => array( '3000', 'append_default' ),
			'background'          	   => array( mh_composer_accent_color(), 'append_default' ),
			'fade'         			 => array( 'fade' ),
			'pause'         			=> array( 'off' ),
		);
	}
	
	function get_fields() {
		$fields = array(
			'magazine_list' => array(
				'label'             => esc_html__( 'Content Type', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'date'  			=> esc_html__( 'Latest', 'mh-magazine' ),
					'comment_count'   => esc_html__( 'Popular', 'mh-magazine' ),
					'title' 		   => esc_html__( 'Title', 'mh-magazine' ),
					'rand' 			=> esc_html__( 'Random', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Order by: Latest - the most recent articles, Popular - the most commented, Title, or Random.', 'mh-magazine' ),
			),
			'include_categories' => array(
				'label'            => esc_html__( 'Include Categories', 'mh-magazine' ),
				'renderer'         => 'mh_composer_include_categories_option',
				'renderer_options' => array(
					'use_terms' => false,
				),
				'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'mh-magazine' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Number of Posts', 'mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to show.', 'mh-magazine' ),
			),
			'offset_posts' => array(
				'label'           => esc_html__( 'Offset Posts', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose by how many posts you would like to offset. Numeric value only.', 'mh-magazine' ),
			),
			'ticker_title' => array(
				'label'           => esc_html__( 'Title', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Here you can define a title for your ticker, or leave empty.', 'mh-magazine' ),
			),
			'background_layout' => array(
				'label'       => esc_html__( 'Text Colour', 'mh-magazine' ),
				'type'        => 'select',
				'options'           => array(
					'dark'  => esc_html__( 'Light', 'mh-magazine' ),
					'light' => esc_html__( 'Dark', 'mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'mh-magazine' ),
			),
			'background' => array(
				'label'             => esc_html__( 'Ticker Colour', 'mh-magazine' ),
				'type'              => 'color',
				'description'       => esc_html__( 'Use the colour picker to choose the background colour for your ticker.', 'mh-magazine' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Featured Image', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'        => esc_html__( 'Here you can define whether to show the post featured image.', 'mh-magazine' ),
			),
			'show_arrows'         => array(
				'label'           => esc_html__( 'Show Arrows', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'mh-magazine' ),
					'off' => esc_html__( 'No', 'mh-magazine' ),
				),
				'description'     => esc_html__( 'This setting will turn on and off the navigation arrows for your ticker.', 'mh-magazine' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-magazine' ),
					'on'  => esc_html__( 'On', 'mh-magazine' ),
				),
				'affects' => array(
					'#mhc_auto_speed',
					'#mhc_fade',
					'#mhc_pause',
				),
				'description'        => esc_html__( 'If you would like the slider to play automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'mh-magazine' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'mh-magazine' ),
				'type'              => 'text',
				'depends_default'   => true,
				'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'mh-magazine' ),
			),
			'fade' => array(
				'label'             => esc_html__( 'Ticker Animation', 'mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'fade'  			=> esc_html__( 'Fade', 'mh-magazine' ),
					'slide'  		   => esc_html__( 'Slide', 'mh-magazine' ),
					'vertical'  		=> esc_html__( 'Slide Vertically', 'mh-magazine' ),
				),
				'depends_default'   => true,
				'description'        => esc_html__( 'Here you can choose the style for your ticker.', 'mh-magazine' ),
			),
			'pause'         => array(
				'label'           => esc_html__( 'Pause on Hover', 'mh-magazine' ),
				'type'              => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'Off', 'mh-magazine' ),
					'on'  => esc_html__( 'On', 'mh-magazine' ),
				),
				'description'     => esc_html__( 'Here you can choose to pause the ticker on hover.', 'mh-magazine' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'mh-magazine' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the component in the composer for easy identification.', 'mh-magazine' ),
			),
			'module_id' => array(
				'label'           => esc_html__( '{CSS ID}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'module_class' => array(
				'label'           => esc_html__( '{CSS Class}', 'mh-magazine' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'mh-magazine' ),
				'tab_slug'          => 'advanced',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide on', 'mh-magazine' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'mh-magazine' ),
					'tablet'  => esc_html__( 'Tablet', 'mh-magazine' ),
					'desktop' => esc_html__( 'Desktop', 'mh-magazine' ),
				),
				'additional_att'  => 'disable_on',
				'description'     => esc_html__( 'This will hide the component on selected devices', 'mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          			 = $this->shortcode_atts['module_id'];
		$module_class       			  = $this->shortcode_atts['module_class'];
		$magazine_list 				 = $this->shortcode_atts['magazine_list'];
		$include_categories 			= $this->shortcode_atts['include_categories'];
		$posts_number       			  = $this->shortcode_atts['posts_number'];
		$offset_posts      			  = $this->shortcode_atts['offset_posts'];
		$background_layout  			 = $this->shortcode_atts['background_layout'];
		$show_thumbnail     			= $this->shortcode_atts['show_thumbnail'];
		$show_arrows     			   = $this->shortcode_atts['show_arrows'];
		$auto    					  = $this->shortcode_atts['auto'];
		$auto_speed     				= $this->shortcode_atts['auto_speed'];
		$background     				= $this->shortcode_atts['background'];
		$fade     					  = $this->shortcode_atts['fade'];
		$pause     					 = $this->shortcode_atts['pause'];
		$ticker_title     			  = $this->shortcode_atts['ticker_title'];
		
		
		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		wp_enqueue_script( 'mh-magazine-js');
		$args = array();
		if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
			$args['posts_per_page'] = $posts_number;
		} else {
			$args['nopaging'] = true;
		}
		if ( '' !== $offset_posts && ! empty( $offset_posts ) ) {
			$args['offset'] = (int) $offset_posts;
		}
		if ( '' !== $include_categories )
			$args['cat'] = $include_categories;
			
		if ( '' !== $magazine_list )
			$args['orderby'] = $magazine_list;
		
		$fullwidth = 'mhc_fullwidth_ticker' === $function_name ? 'on' : 'off';
		$class = " mhc_bg_layout_{$background_layout}";
		
		$ticker_bg = '';
		if ( '' !== $background ) {
			$ticker_bg = sprintf( ' style="background-color: %s;"',
			esc_attr( $background )
			);
		}
		if ( is_single()){
			global $post;
			$args['post__not_in'] = array( $post->ID );
		}
		$the_posts = mh_magazine_get_posts( $args );
		ob_start();
		if( $the_posts->post_count > 0 ) {
		while ( $the_posts->have_posts() ) {
				$the_posts->the_post(); 
				$thumb ='';
				$width = (int) apply_filters( 'mh_ticker_image_width', 80 );
				$height = (int) apply_filters( 'mh_ticker_image_height', 80 );
				$title = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, '', $title, $title, false, 'Ticker' );
				$thumb = $thumbnail["thumb"];
				?>
				<div class="mh-ticker-post" <?php echo $ticker_bg; ?>>
				<a class="mh-ticker-title" href="<?php esc_url( the_permalink() ); ?>">
				  <?php if ( '' !== $thumb && 'off' !== $show_thumbnail ) :?>
				<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $title, $width, $height ); ?>
				<?php endif; ?>
				<?php the_title(); ?>
				</a>
				</div>
				<?php
					}
		}
		wp_reset_postdata();
		
		$posts = ob_get_clean();
		
		$output = sprintf(
			'<div%1$s class="mh-magazine-ticker-wrapper clearfix%2$s%8$s%9$s"%7$s>
			<div class="%14$s">
				%15$s
				<div class="mh-magazine-ticker" data-arrows="%5$s" data-auto="%3$s" data-speed="%4$s" data-fx="%11$s" data-pause="%13$s"%10$s%12$s>
					%6$s
				</div><!-- .mh-magazine-ticker -->
				</div>
			</div> <!-- .mh-magazine-ticker-wrapper-->',	
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),//1
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),//2
			( 'on' !== $auto ? 'false' : 'true' ),
			( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
			( 'on' === $show_arrows ? 'true' : 'false' ),
			$posts,
			$ticker_bg,
			('off' !== $show_thumbnail ? ' mh-ticker-with-img' : ''),
			esc_attr( $class ),
			('vertical' !== $fade && is_rtl() ? ' data-rtl="true"' : ''),
			('fade' !== $fade ? 'false' : 'true'),
			('vertical'!== $fade ? '' : ' data-vertical="true"'),
			('off' !== $pause ? 'true' : 'false'),
			('on' === $fullwidth ? 'mhc_container' : 'not_fullwidth_ticker'),
	( '' !== $ticker_title ? sprintf( '<div class="ticker-pin" style="width: auto;"><span class="pin-title">%1$s</span><span class="pin-arrow"></span></div>',
			esc_attr( $ticker_title ) ) : '')
		);
	
		return $output;
	}
}
new MHMagazine_Component_Fullwidth_Ticker;
	
class MHMagazine_Component_Classified extends MHComposer_Component {
	function init() {
		$this->name = esc_html__( 'Classified', 'mh-magazine' );
		$this->slug = 'mhc_classified';
		$this->main_css_element = '%%order_class%%.mh-classified-wrapper';

		$this->approved_fields = array(
			'module_id',
			'module_class',
			'admin_label',
			'choose_category',
			'description',
			'sub_categories',
			'count',
			'more_link',
			'use_icon',
			'font_list',
			'font_mhicons',
			'font_steadysets',
			'font_awesome',
			'font_lineicons',
			'font_etline',
			'font_icomoon',
			'font_linearicons',
			'background_layout',
			'icon_color',
			'border_color',
			'use_icon_size',
			'icon_size',

		);
		
		$mh_accent_color = mh_composer_accent_color();
		
		$this->fields_defaults = array(
			'description' 	   	 	 => array( 'off' ),
			'count' 	   	 	 	 => array( 'on' ),
			'more_link' 	   	 	 => array( 'on' ),
			'use_icon'            	 => array( 'off' ),
			'font_list' 		   	 => array( 'mhicons' ),
			'background_layout'  	 => array( 'light' ),
			'icon_color' 				 => array( $mh_accent_color, 'append_default' ),
			'use_icon_size'  	   	 => array( 'off' ),
		);
		
		$this->custom_css_options = array(
			'classified_icon' => array(
				'label'    => esc_html__( 'Classified Icon','mh-magazine' ),
				'selector' => '.mhc-icon',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.','mh-magazine' ),
			),
			'classified_title' => array(
				'label'    => esc_html__( 'Classified Title','mh-magazine' ),
				'selector' => 'h4',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.','mh-magazine' ),
			),
			'classified_description' => array(
				'label'    => esc_html__( 'Classified Description','mh-magazine' ),
				'selector' => '.mh-classified-description p',
				'description'     => esc_html__( 'Use this to add Custom CSS Properties.','mh-magazine' ),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'choose_category' => array(
				'label' => esc_html__( 'Select Category', 'mh-magazine' ),
				'renderer' => 'mh_composer_choose_category_option',
				'description' => esc_html__( 'Choose which category you would like to include in the feed. Top-level categories which have children.', 'mh-magazine' ),
			),
			'description' => array(
				'label'           => esc_html__( 'Show Descrption','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes','mh-magazine' ),
					'off' => esc_html__( 'No','mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether to show the category description.','mh-magazine' ),
			),
			'sub_categories' => array(
				'label'             => esc_html__( 'Sub Category Number','mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'The number of sub categories to show. Leave empty to show all.','mh-magazine' ),
			),
			'count' => array(
				'label'           => esc_html__( 'Show Posts Count','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes','mh-magazine' ),
					'off' => esc_html__( 'No','mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether to show the post count.','mh-magazine' ),
			),
			'more_link' => array(
				'label'           => esc_html__( 'Show More link','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes','mh-magazine' ),
					'off' => esc_html__( 'No','mh-magazine' ),
				),
				'description' => esc_html__( 'Here you can choose whether to show the more link.','mh-magazine' ),
			),
			'use_icon' => array(
				'label'           => esc_html__( 'Use Icon','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No','mh-magazine' ),
					'on'  => esc_html__( 'Yes','mh-magazine' ),
				),
				'affects'     => array(
					'#mhc_font_list',
				),
				'description' => esc_html__( 'Here you can choose whether icon set below should be used.','mh-magazine' ),
			),
			'font_list' => array(
				'label'               => esc_html__( 'Icons Font','mh-magazine' ),
				'renderer'            => 'mh_composer_font_list_option',
				'description'         => esc_html__( 'If you want more icons, install & activate MH More Icons Plugin.','mh-magazine'
				),
			),
			'font_mhicons' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'mhicons',
			),
			'font_steadysets' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_steadysets_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'steadysets',
			),
			'font_awesome' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_awesome_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'awesome',
			),
			'font_lineicons' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_lineicons_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'lineicons',
			),
			'font_etline' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_etline_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'etline',
			),
			'font_icomoon' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_icomoon_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'icomoon',
			),
			'font_linearicons' => array(
				'label'               => esc_html__( 'Icon','mh-magazine' ),
				'type'                => 'text',
				'class'               => array( 'mhc-font-icon' ),
				'renderer'            => 'mhc_get_font_linearicons_icon_list',
				'renderer_with_field' => true,
				'description'         => esc_html__( 'Select an icon to use it.','mh-magazine' ),
				'depends_show_if'     => 'linearicons',
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Colour','mh-magazine' ),
				'type'              => 'select',
				'options'           => array(
					'light' => esc_html__( 'Dark','mh-magazine' ),
					'dark'  => esc_html__( 'Light','mh-magazine' ),
				),
				'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.','mh-magazine' ),
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Colour','mh-magazine' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour.','mh-magazine' ),
			),
			'admin_label' => array(
				'label'             => esc_html__( 'Admin Label','mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'This will change the label of the component in the composer for easy identification.','mh-magazine' ),
			),
			'module_id' => array(
				'label'             => esc_html__( '{CSS ID}','mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter an optional CSS ID. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.','mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
			'module_class' => array(
				'label'             => esc_html__( '{CSS Class}','mh-magazine' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Enter optional CSS classes. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.','mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
			'border_color' => array(
				'label'             => esc_html__( 'Border Colour','mh-magazine' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom colour for the border.','mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
			'use_icon_size' => array(
				'label'           => esc_html__( 'Use Icon Size','mh-magazine' ),
				'type'            => 'switch_button',
				'options'         => array(
					'off' => esc_html__( 'No','mh-magazine' ),
					'on'  => esc_html__( 'Yes','mh-magazine' ),
				),
				'tab_slug'        => 'advanced',
				'affects'     => array(
					'#mhc_icon_size'
				),
			),
			'icon_size' => array(
				'label'           => esc_html__( 'Icon Size','mh-magazine' ),
				'type'            => 'range',
				'default'         => '40',
				'range_settings' => array(
					'min'  => '10',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'depends_default' => true,
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide on', 'mh-magazine' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'mh-magazine' ),
					'tablet'  => esc_html__( 'Tablet', 'mh-magazine' ),
					'desktop' => esc_html__( 'Desktop', 'mh-magazine' ),
				),
				'additional_att'  => 'disable_on',
				'description'     => esc_html__( 'This will hide the component on selected devices', 'mh-magazine' ),
				'tab_slug'        => 'advanced',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id 			   = $this->shortcode_atts[ 'module_id' ];
		$module_class 		   = $this->shortcode_atts[ 'module_class' ];
		$choose_category 	   = $this->shortcode_atts[ 'choose_category' ];
		$description 	   	   = $this->shortcode_atts[ 'description' ];
		$sub_categories   	   = $this->shortcode_atts[ 'sub_categories' ];
		$count 		   		   = $this->shortcode_atts[ 'count' ];
		$more_link 			   = $this->shortcode_atts[ 'more_link' ];
		$use_icon              = $this->shortcode_atts[ 'use_icon' ];
		$font_list             = $this->shortcode_atts[ 'font_list' ];
		$font_mhicons          = $this->shortcode_atts[ 'font_mhicons' ];
		$font_steadysets       = $this->shortcode_atts[ 'font_steadysets' ];
		$font_awesome          = $this->shortcode_atts[ 'font_awesome' ];
		$font_lineicons        = $this->shortcode_atts[ 'font_lineicons' ];
		$font_etline           = $this->shortcode_atts[ 'font_etline' ];
		$font_icomoon          = $this->shortcode_atts[ 'font_icomoon' ];
		$font_linearicons      = $this->shortcode_atts[ 'font_linearicons' ];
		$background_layout     = $this->shortcode_atts[ 'background_layout' ];
		$icon_color 		   = $this->shortcode_atts[ 'icon_color' ];
		$border_color		   = $this->shortcode_atts[ 'border_color' ];
		$use_icon_size    	   = $this->shortcode_atts[ 'use_icon_size' ];
		$icon_size        	   = $this->shortcode_atts[ 'icon_size' ];

		$module_class = MHComposer_Core::add_module_order_class( $module_class, $function_name );
		
		if ( 'off' !== $use_icon && 'off' !== $use_icon_size ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mhc-icon',
				'declaration' => sprintf(
					'font-size: %1$s;',
					esc_html( mh_composer_process_range_value( $icon_size ) )
				),
			) );
		}
		
		if ( '' !== $border_color ) {
			MHComposer_Core::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mh-classified, %%order_class%% .mh-classified-header, %%order_class%% .mh-classified-footer',
				'declaration' => sprintf(
					'border-color: %1$s;',
					esc_html( $border_color )
				),
			) );
		}
		
		$font_icon = '';
		switch($font_list){
		case 'mhicons':
			$font_icon = $font_mhicons;
			break;
		case 'steadysets':
			$font_icon = $font_steadysets;
			break;
		case 'awesome':
			$font_icon = $font_awesome;
			break;
		case 'lineicons':
			$font_icon = $font_lineicons;
			break;
		case 'etline':
			$font_icon = $font_etline;
			break;
		case 'icomoon':
			$font_icon = $font_icomoon;
			break;
		case 'linearicons':
			$font_icon = $font_linearicons;
			break;
		}
		
		if ('' !== $font_icon  && 'off' !== $use_icon) {
		$icon_style = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );
			$icon = sprintf(
					'<div class="mh-classified-icon"><span class="mhc-icon %2$s" style="%1$s">%3$s</span></div>',
					$icon_style,
					esc_attr($font_list),
					esc_attr( mhc_process_font_icon($font_icon, "mhc_font_{$font_list}_icon_symbols"))
				);
		}
		
		ob_start(); ?>

			<div class="mh-classified">

				<div class="mh-classified-header clearfix">

					<div class="mh-classified-title">
						<a href="<?php echo get_category_link( $choose_category ) ?>">
							<?php if ('' !== $font_icon && 'off' !== $use_icon ) { echo $icon; } ?>
							<h4><?php echo get_cat_name( $choose_category ); ?></h4>
						</a>
					</div>


				</div>

				<div class="mh-classified-content clearfix">
				
					<?php if ( 'off' !== $description ) { echo '<div class="mh-classified-description">' . category_description( $choose_category ) .'</div>'; } ?>

					<ul class="mh-classified-sub">
						<?php
						$args = array(
							'type' => 'post',
							'child_of' => $choose_category,
							'orderby' => 'name',
							'order' => 'ASC',
							'hide_empty' => 0,
							'taxonomy' => 'category',
						);
						if ( '' !== $sub_categories )
							$args['number'] = $sub_categories;
		
						$categories = get_categories( $args );

						foreach ( $categories as $category ) {
							?>

						<li>
							<a href="<?php echo get_category_link( $category->term_id )?>" title="View posts in <?php echo $category->name?>">
								<h5><?php echo $category->name; ?></h5>
								<?php if ( 'off' !== $count ) { ?>
									<span class="mh-classified-sub-counter">
										<?php echo $category->count ?>
									</span>
								<?php } ?>
							</a>
						</li>

						<?php } ?>

					</ul>

				</div>
				<?php if ( 'off' !== $more_link ) { ?>
				<div class="mh-classified-footer">
					<a class="mh-classified-more" href="<?php echo get_category_link( $choose_category ) ?>">
						<?php _e( 'View all', 'mh-magazine' ); ?>
					</a>
				</div>
				<?php } ?>

			</div>
		<?php 
		$list_categories = ob_get_clean();
		
		$class = " mhc_module mhc_pct mhc_bg_layout_{$background_layout}";
		
		$output = sprintf(
				'<div%1$s class="mh-classified-wrapper clearfix%2$s%4$s">
				%3$s
			</div> <!-- .mh-classified-wrapper-->',
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				$list_categories,
				$class
			);

			return $output;
		}
	}
	new MHMagazine_Component_Classified;
}