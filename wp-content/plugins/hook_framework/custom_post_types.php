<?php

	//-------------------------
	//CREATE PORTFOLIO CUSTOM TYPE
	//-------------------------
	function portfolio_register() {
 		global $prk_hook_options;
		if (!isset($prk_hook_options['portfolio_slug']) || $prk_hook_options['portfolio_slug']=="")
			$prk_hook_options['portfolio_slug']="portfolios";
		$labels = array(
			'add_new_item' => esc_html__('Add Portfolio Item', 'hook'),
			'edit_item' => esc_html__('Edit Portfolio Item', 'hook'),
			'new_item' => esc_html__('New Portfolio Item', 'hook'),
			'view_item' => esc_html__('Preview Portfolio Item', 'hook'),
			'search_items' => esc_html__('Search Portfolio Items', 'hook'),
			'not_found' => esc_html__('No Portfolio items found.', 'hook'),
			'not_found_in_trash' => esc_html__('No Portfolio items found in Trash.', 'hook')
		);	
		register_post_type('pirenko_portfolios', array(
		'label' => esc_html__('Portfolio Items', 'hook'),
		'labels' => array('all_items' => esc_html__('All Portfolios', 'hook')),
		'singular_label' => esc_html__('Portfolio Item', 'hook'),
		'public' => true,
		'show_ui' => true, 
		'_builtin' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => $prk_hook_options['portfolio_slug'],
			'with_front' => false,
		),
		'supports' => array('title', 'excerpt', 'author', 'editor', 'thumbnail', 'comments','custom-fields','revisions'), // Let's use custom fields for debugging purposes only
		'menu_icon' => 'dashicons-camera',
		));

		//ADD TAXONOMIES SIMILAR TO A CATEGORY
		$labels_pir_categories = array(
			'name' => esc_html__('Skills', 'post type general name', 'hook'),
			'all_items' => esc_html__('All Skills', 'all items', 'hook'),
			'add_new_item' => esc_html__('Add New Skill', 'adding a new item', 'hook'),
			'new_item_name' => esc_html__('New Skill Name', 'adding a new item', 'hook'),
			'edit_item' => esc_html__("Edit Skill", "hook")
		);

		if (!isset($prk_hook_options['skills_slug']) || $prk_hook_options['skills_slug']=="")
			$prk_hook_options['skills_slug']="skills";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array(
				'slug' => $prk_hook_options['skills_slug'],
				'with_front' => false,
			),
			'hierarchical' => true
		);	
		register_taxonomy( 'pirenko_skills', 'pirenko_portfolios', $args_pir_categories );

		//ADD TAXONOMIES SIMILAR TO TAGS
		  $labels = array(
			'name' => esc_html__( 'Tags', 'taxonomy general name', 'hook' ),
			'singular_name' => esc_html__( 'Tag', 'taxonomy singular name', 'hook' ),
			'search_items' =>  esc_html__( 'Search Tags', 'hook' ),
			'popular_items' => esc_html__( 'Popular Tags', 'hook' ),
			'all_items' => esc_html__( 'All Tags', 'hook' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => esc_html__( 'Edit Tag', 'hook' ), 
			'update_item' => esc_html__( 'Update Tag', 'hook' ),
			'add_new_item' => esc_html__( 'Add New Tag', 'hook' ),
			'new_item_name' => esc_html__( 'New Tag Name', 'hook' ),
			'separate_items_with_commas' => esc_html__( 'Separate Tags with commas', 'hook' ),
			'add_or_remove_items' => esc_html__( 'Add or remove Tags', 'hook' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used Tags', 'hook' ),
			'menu_name' => esc_html__( 'Tags', 'hook' ),
		  ); 
		
		if (!isset($prk_hook_options['folio_tags_slug']) || $prk_hook_options['folio_tags_slug']=="")
		{
			$prk_hook_options['folio_tags_slug']="tagged";
		}
		register_taxonomy('portfolio_tag','pirenko_portfolios',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array(
				'slug' => $prk_hook_options['folio_tags_slug'],
				'with_front' => false,
			),
		));
	}
	add_action('init', 'portfolio_register',5);
	function hook_filter_list() {
	    $screen = get_current_screen();
	    global $wp_query;
	    if ( $screen->post_type == 'pirenko_portfolios' ) {
	        wp_dropdown_categories( array(
	            'show_option_all' => 'Show All Skills',
	            'taxonomy' => 'pirenko_skills',
	            'name' => 'pirenko_skills',
	            'orderby' => 'name',
	            'selected' => ( isset( $wp_query->query['pirenko_skills'] ) ? $wp_query->query['pirenko_skills'] : '' ),
	            'hierarchical' => false,
	            'parent' => 0,//SHOW ONLY PARENT
	            'show_count' => false,
	            'hide_empty' => false,
	        ) );
	    }
	}
	add_action( 'restrict_manage_posts', 'hook_filter_list' );

	function hook_perform_filtering( $query ) {
	    $qv = &$query->query_vars;
	    if ( isset( $qv['pirenko_skills'] ) && is_numeric( $qv['pirenko_skills'] ) ) {
	        $term = get_term_by( 'id', $qv['pirenko_skills'], 'pirenko_skills' );
	        $qv['pirenko_skills'] = $term->slug;
	    }
	}
	add_filter( 'parse_query','hook_perform_filtering' );

	//PORTFOLIO ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	//ADD HOOKS
	add_filter('manage_pirenko_portfolios_posts_columns', 'hook_columns_head_only_portfolios', 10);
	add_action('manage_pirenko_portfolios_posts_custom_column', 'hook_columns_content_only_portfolios', 10, 2);
	//FUNCTION TO RETRIEVE FEATURED IMAGE
	function pirenko_get_featured_image($post_ID) {
		$post_thumbnail_id = get_post_thumbnail_id($post_ID);
		if ($post_thumbnail_id) {
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'medium');
			return $post_thumbnail_img[0];
		}
	}
	//RESORT COLUMNS
	function hook_columns_head_only_portfolios($defaults) 
	{
		unset($defaults['date']);
		$defaults['set']=esc_html__('Skills', 'hook');
		$defaults['date']="Date";
        $defaults['featured_image'] = 'Featured Image';
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function hook_columns_content_only_portfolios($column_name, $post_ID) 
	{
		global $post;
		if ($column_name == 'featured_image') {  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="'.$post_featured_image.'" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') { 
			$terms = get_the_terms( $post_ID, 'pirenko_skills' );
			if ( !empty( $terms ) ) 
			{
				$out = array();
				foreach ( $terms as $term ) 
				{
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_skills' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_skills', 'display' ) )
					);
				}
				//JOIN THE TERMS SEPARATED BY A COMMA
				echo join( ', ', $out );	
			}
		}
	}

	
	//-------------------------
	//CREATE SLIDES CUSTOM TYPE
	//-------------------------
	function slides_register() {
		global $prk_hook_options;
 		if (!isset($prk_hook_options['slides_slug']) || $prk_hook_options['slides_slug']=="")
 			$prk_hook_options['slides_slug']="slides";
		$labels = array(
			'name' => esc_html__('Slides', 'post type general name', 'hook'),
			'all_items' => esc_html__('All Slides', 'hook'),
			'singular_name' => esc_html__('Slide', 'hook'),
			'add_new' => esc_html__('Add New Slide', 'hook'),
			'add_new_item' => esc_html__('Add New Slide', 'hook'),
			'edit_item' => esc_html__('Edit Slide', 'hook'),
			'new_item' => esc_html__('New Slide', 'hook'),
			'view_item' => esc_html__('View Slide', 'hook'),
			'search_items' => esc_html__('Search Slides', 'hook'),
			'not_found' =>  esc_html__('Nothing found', 'hook'),
			'not_found_in_trash' => esc_html__('Nothing found in Trash', 'hook'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-images-alt2',
			'rewrite' => array(
				'slug' => $prk_hook_options['slides_slug'],
				'with_front' => false,
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','author','editor','thumbnail','revisions')
		);
		register_post_type( 'pirenko_slides' , $args );
		//ADD TAXONOMIES FOR SLIDES
		$labels_pir_categories = array(
			'name' => esc_html__('Groups', 'post type general name', 'hook'),
			'all_items' => esc_html__('All Groups', 'all items', 'hook'),
			'add_new_item' => esc_html__('Add New Group', 'adding a new item', 'hook'),
			'new_item_name' => esc_html__('New Group Name', 'adding a new item', 'hook'),
			'edit_item' => esc_html__("Edit Group", "hooktheme")
		);

		if (!isset($prk_hook_options['groups_slug']) || $prk_hook_options['groups_slug']=="")
			$prk_hook_options['groups_slug']="group";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array(
				'slug' => $prk_hook_options['groups_slug'],
				'with_front' => false,
			),
			'hierarchical' => true
		);
		register_taxonomy( 'pirenko_slide_set', 'pirenko_slides', $args_pir_categories );
	}
	
	//SLIDES ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	//ADD HOOKS
	add_filter('manage_pirenko_slides_posts_columns', 'hook_columns_head_only_slides', 10);
	add_action('manage_pirenko_slides_posts_custom_column', 'hook_columns_content_only_slides', 10, 2);
	//RESORT COLUMNS
	function hook_columns_head_only_slides($defaults) {
		unset($defaults['date']);
		$defaults['set']="Group";
		$defaults['date']="Date";
        $defaults['featured_image'] = 'Featured Image';
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function hook_columns_content_only_slides($column_name, $post_ID) 
	{
		global $post;
		if ($column_name == 'featured_image') {  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="'.$post_featured_image.'" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') { 
			$terms = get_the_terms( $post_ID, 'pirenko_slide_set' );
			if ( !empty( $terms ) ) 
			{
				$out = array();
				foreach ( $terms as $term ) 
				{
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_slide_set' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_slide_set', 'display' ) )
					);
				}
				//JOIN THE TERMS SEPARATED BY A COMMA
				echo join( ', ', $out );	
			}
		}
	}

	//CREATE SLIDER ITEMS POST TYPE
	add_action('init', 'slides_register',5);

	//-------------------------
	//CREATE MEMBERS CUSTOM TYPE
	//-------------------------
	function members_register() {
		global $prk_hook_options;
		if (!isset($prk_hook_options['members_slug']) || $prk_hook_options['members_slug']=="")
			$prk_hook_options['members_slug']="member";
		$labels = array(
			'add_new_item' => esc_html__('Add Team Member', 'hook'),
			'edit_item' => esc_html__('Edit Team Member', 'hook'),
			'new_item' => esc_html__('New Team Member', 'hook'),
			'view_item' => esc_html__('Preview Team Member', 'hook'),
			'search_items' => esc_html__('Search Team Members', 'hook'),
			'not_found' => esc_html__('No Team Members found.', 'hook'),
			'not_found_in_trash' => esc_html__('No Team Members found in Trash.', 'hook')
		);	
		register_post_type('pirenko_team_member', array(
			'label' => esc_html__('Team Members', 'hook'),
			'labels' => array('all_items' => esc_html__('All Members', 'hook')),
			'singular_label' => esc_html__('Team Member', 'hook'),
			'public' => true,
			'show_ui' => true, 
			'_builtin' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array(
				'slug' => $prk_hook_options['members_slug'],
				'with_front' => false,
			),
			'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments','custom-fields','revisions'), // Let's use custom fields for debugging purposes only
			'menu_icon' => 'dashicons-businessman',
		));
		//ADD TAXONOMIES SIMILAR TO A CATEGORY
		$labels_pir_categories = array(
			'name' => esc_html__('Teams', 'post type general name', 'hook'),
			'all_items' => esc_html__('All Teams', 'all items', 'hook'),
			'add_new_item' => esc_html__('Add New Team', 'adding a new item', 'hook'),
			'new_item_name' => esc_html__('New Team Name', 'adding a new item', 'hook'),
			'edit_item' => esc_html__("Edit Team", "hook")
		);

		if (!isset($prk_hook_options['team_slug']) || $prk_hook_options['team_slug']=="")
			$prk_hook_options['team_slug']="team";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array(
				'slug' => $prk_hook_options['team_slug'],
				'with_front' => false,
			),
			'hierarchical' => true
		);
		register_taxonomy('pirenko_member_group', 'pirenko_team_member', $args_pir_categories );
	}
	add_action('init', 'members_register',5);

	//MEMBERS ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	//ADD HOOKS
	add_filter('manage_pirenko_team_member_posts_columns', 'hook_columns_head_only_members', 10);
	add_action('manage_pirenko_team_member_posts_custom_column', 'hook_columns_content_only_members', 10, 2);
	//RESORT COLUMNS
	function hook_columns_head_only_members($defaults) {
		unset($defaults['date']);
		$defaults['set']=esc_html__('Team', 'hook');
		$defaults['date']="Date";
        $defaults['featured_image'] = 'Featured Image';
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function hook_columns_content_only_members($column_name, $post_ID) {
		global $post;
		if ($column_name == 'featured_image') {  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="'.$post_featured_image.'" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') { 
			$terms = get_the_terms( $post_ID, 'pirenko_member_group' );
			if ( !empty( $terms ) ) 
			{
				$out = array();
				foreach ( $terms as $term ) 
				{
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_member_group' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_member_group', 'display' ) )
					);
				}
				//JOIN THE TERMS SEPARATED BY A COMMA
				echo join( ', ', $out );	
			}
		}
	}

	//-------------------------
	//CREATE TESTIMONIALS CUSTOM TYPE
	//-------------------------
	function hook_testimonials_register() {
		global $prk_hook_options;
 		if (!isset($prk_hook_options['testimonials_slug']) || $prk_hook_options['testimonials_slug']=="")
 			$prk_hook_options['testimonials_slug']="testimonials";
		$labels = array(
			'name' => esc_html__('Testimonials', 'hook'),
			'all_items' => esc_html__('All Testimonials', 'hook'),
			'singular_name' => esc_html__('Testimonial', 'hook'),
			'add_new' => esc_html__('Add New Testimonial', 'hook'),
			'add_new_item' => esc_html__('Add New Testimonial', 'hook'),
			'edit_item' => esc_html__('Edit Testimonial', 'hook'),
			'new_item' => esc_html__('New Testimonial', 'hook'),
			'view_item' => esc_html__('View Testimonial', 'hook'),
			'search_items' => esc_html__('Search Testimonials', 'hook'),
			'not_found' =>  esc_html__('Nothing found', 'hook'),
			'not_found_in_trash' => esc_html__('Nothing found in Trash', 'hook'),
			'parent_item_colon' => ''
		);
			$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-testimonial',
			'rewrite' => array(
				'slug' => $prk_hook_options['testimonials_slug'],
				'with_front' => false,
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','excerpt','editor','thumbnail','revisions')
		);
		register_post_type( 'pirenko_testimonials' , $args );
		//ADD TAXONOMIES FOR TESTIMONIALS
		$labels_pir_categories = array(
			'name' => esc_html__('Groups', 'post type general name', 'hook'),
			'all_items' => esc_html__('All Groups', 'all items', 'hook'),
			'add_new_item' => esc_html__('Add New Group', 'adding a new item', 'hook'),
			'new_item_name' => esc_html__('New Group Name', 'adding a new item', 'hook'),
			'edit_item' => esc_html__("Edit Group", "hooktheme")
		);

		if (!isset($prk_hook_options['testimonials_groups_slug']) || $prk_hook_options['testimonials_groups_slug']=="")
			$prk_hook_options['testimonials_groups_slug']="testimonials_group";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array(
				'slug' => $prk_hook_options['testimonials_groups_slug'],
				'with_front' => false,
			),
			'hierarchical' => true
		);
		
		register_taxonomy( 'pirenko_testimonial_set', 'pirenko_testimonials', $args_pir_categories );
	}
	//MEMBERS ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	//ADD HOOKS
	add_filter('manage_pirenko_testimonials_posts_columns', 'hook_columns_head_only_testimonials', 10);
	add_action('manage_pirenko_testimonials_posts_custom_column', 'hook_columns_content_only_testimonials', 10, 2);
	//RESORT COLUMNS
	function hook_columns_head_only_testimonials($defaults) {
		unset($defaults['date']);
		$defaults['set']=esc_html__('Group', 'hook');
		$defaults['date']="Date";
        $defaults['featured_image'] = 'Featured Image';
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function hook_columns_content_only_testimonials($column_name, $post_ID) 
	{
		global $post;
		if ($column_name == 'featured_image') {  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="'.$post_featured_image.'" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') { 
			$terms = get_the_terms( $post_ID, 'pirenko_testimonial_set' );
			if ( !empty( $terms ) ) 
			{
				$out = array();
				foreach ( $terms as $term ) 
				{
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_testimonial_set' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_testimonial_set', 'display' ) )
					);
				}
				//JOIN THE TERMS SEPARATED BY A COMMA
				echo join( ', ', $out );	
			}
		}
	}

	//CREATE POST TYPE
	add_action('init', 'hook_testimonials_register',5);
	

	//EXECUTE THIS ONLY WHEN THE THEME IS ACTIVATED
	function prk_activate_new_post($oldname, $oldtheme=false) {
		portfolio_register();
		slides_register();
		flush_rewrite_rules();
	}
	add_action("after_switch_theme", "prk_activate_new_post", 10 ,  2);

	//CHECK IF OPTIONS/SLUGS WERE CHANGED
	if (isset($prk_hook_options['just_saved']) && $prk_hook_options['just_saved']=="true") {
		add_action('init', 'prk_activate_new_post');
	}
	$nets_array = array (
		'none' => 'None',
		'delicious' => 'Delicious',
		'deviantart' => 'Deviantart',
		'dribbble' => 'Dribbble',
		'facebook' => 'Facebook',
		'flickr' => 'Flickr',
		'google_plus' => 'Google Plus',
		'instagram' => 'Instagram',
		'linkedin' => 'Linkedin',
		'pinterest' => 'Pinterest',
		'reddit' => 'Reddit',
		'skype' => 'Skype',
		'twitter' => 'Twitter',
		'vimeo' => 'Vimeo',
		'xing' => 'Xing',
		'yahoo' => 'Yahoo',
		'youtube' => 'Youtube',
		'globe' => 'Website',
		'rss' => 'RSS',
		'book' => 'vCard',
	);
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	if (is_plugin_active('revslider/revslider.php')) {
      global $wpdb;
      $rs = $wpdb->get_results( 
        "
        SELECT id, title, alias
        FROM ".$wpdb->prefix."revslider_sliders
        ORDER BY id ASC LIMIT 999
        "
      );
      $hook_rev_slider = array();
      if ($rs) {
        foreach ( $rs as $slider ) {
          $hook_rev_slider[$slider->alias] = $slider->title;
        }
      } else {
        $hook_rev_slider[0] = "No sliders found";
      }
    }
    else {
        $hook_rev_slider[0] = "Plugin is not active";
    }
    
	if(function_exists("register_field_group")) {
		register_field_group(array (
			'id' => 'acf_testimonial-options',
			'title' => 'Testimonial Options',
			'fields' => array (
				array (
					'key' => 'field_5286cdc09f9be',
					'label' => 'Sub-heading',
					'name' => 'testimonial_subheading',
					'instructions' => 'Will be shown under the title',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			array (
                'key' => 'field_528a44c48star',
                'label' => 'Star rating',
                'instructions' => 'Optional',
                'name' => 'rating',
                'type' => 'select',
                'choices' => array (
                    'none' => 'Do not display',
                    '1' => 'One',
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four',
                    '5' => 'Five',
                	),
                ),
				array (
					'key' => 'field_5286cdc09link',
					'label' => 'Link',
					'name' => 'testimonial_link',
					'instructions' => 'Will be conneceted to the testimonial title (optional)',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_testimonials',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_theme-member-options',
			'title' => 'Team Member Options',
			'fields' => array (
				array (
				    'key' => 'field_528a44csepasd',
				    'label' => 'Sidebar',
				    'name' => 'separa_sd',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
                'key' => 'field_528a44c48201d',
                'label' => 'Sidebar display',
                'name' => 'show_sidebar',
                'type' => 'select',
                'choices' => array (
                    'default' => 'Default option',
                    'yes' => 'Show Sidebar',
                    'no' => 'Hide Sidebar',
                ),
                'default_value' => 'no',
                'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_8320f34a34875',
							'operator' => '!=',
							'value' => 'divided',
						),
					),
					'allorany' => 'all',
				),
                'allow_null' => 0,
                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_398a6dab76e59',
	                'label' => 'Right custom sidebar selector',
	                'name' => 'right_sidebar_id',
	                'type' => 'sidebar_selector',
	                'instructions' => 'Leave blank for default sidebar',
	                'allow_null' => 1,
	                'default_value' => '',
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_8320f34a34875',
								'operator' => '!=',
								'value' => 'divided',
							),
						),
						'allorany' => 'all',
					),
	            ),
	            array (
	                'key' => 'field_528a44csepaap',
	                'label' => 'Appearance',
	                'name' => 'separa_ap',
	                'type' => 'acf_field_separator',
	                'instructions' => '',
	                'choices' => '',
	                'default_value' => '',
	            ),
				array (
					'key' => 'field_52877cc65f9d6',
					'label' => 'Featured color',
					'name' => 'featured_color',
					'type' => 'color_picker',
					'instructions' => '(optional)',
					'default_value' => '',
				),
				array (
					'key' => 'field_5286bb2e9f9c0',
					'label' => 'Enable link to single member page?',
					'name' => 'show_member_link',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 1,
				),
				array (
	                'key' => 'field_8320f34a34875',
	                'label' => 'Single member post layout',
	                'name' => 'member_layout',
	                'type' => 'select',
	                'choices' => array (
	                    'regular' => 'Regular size image on top',
	                    'big_image' => 'Full width image on top',
	                    'divided' => 'Image on the left side',
	                ),
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bb2e9f9c0',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
	                'default_value' => 'regular',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_528a44csepamd',
	                'label' => 'Media Management',
	                'name' => 'separa_md',
	                'type' => 'acf_field_separator',
	                'instructions' => '',
	                'choices' => '',
	                'default_value' => '',
	            ),
	            array (
	            	'key' => 'field_5286bb940de2d',
	            	'label' => 'Show image on single member page?',
	            	'name' => 'show_member_image',
	            	'type' => 'true_false',
	            	'message' => '',
	            	'default_value' => 1,
	            	'conditional_logic' => array (
	            		'status' => 1,
	            		'rules' => array (
	            			array (
	            				'field' => 'field_5286bb2e9f9c0',
	            				'operator' => '==',
	            				'value' => '1',
	            			),
	            		),
	            		'allorany' => 'all',
	            	),
	            ),
	            array (
	            	'key' => 'field_5286bbb60de2e',
	            	'label' => 'Single post image',
	            	'name' => 'image_2',
	            	'type' => 'image',
	            	'instructions' => '(optional)',
	            	'save_format' => 'id',
	            	'preview_size' => 'thumbnail',
	            	'library' => 'all',
	            	'conditional_logic' => array (
	            		'status' => 1,
	            		'rules' => array (
	            			array (
	            				'field' => 'field_5286bb2e9f9c0',
	            				'operator' => '==',
	            				'value' => '1',
	            			),
	            		),
	            		'allorany' => 'all',
	            	),
	            ),
				array (
				    'key' => 'field_528a44csepami',
				    'label' => 'Informational Fields',
				    'name' => 'separa_mi',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
					'key' => 'field_5286baa09f9be',
					'label' => 'Job',
					'name' => 'member_job',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286baabyline',
					'label' => 'Byline',
					'name' => 'member_byline',
					'type' => 'text',
					'instructions' => 'Will appear on member thumbnail rollover',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bb119f9bf',
					'label' => 'Email',
					'name' => 'member_email',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
				    'key' => 'field_528a44csepasn',
				    'label' => 'Social Networks',
				    'name' => 'separa_sn',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
					'key' => 'field_5286bbf848d3b',
					'label' => 'Social network link 1',
					'name' => 'member_social_1',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286bd7aceeda',
					'label' => 'Network link 1',
					'name' => 'member_social_1_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bbf848d3b',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc50cbdc',
					'label' => 'Social network link 2',
					'name' => 'member_social_2',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be1007c5c',
					'label' => 'Network link 2',
					'name' => 'member_social_2_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc50cbdc',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc40cbdb',
					'label' => 'Social network link 3',
					'name' => 'member_social_3',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0f07c5b',
					'label' => 'Network link 3',
					'name' => 'member_social_3_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc40cbdb',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc30cbda',
					'label' => 'Social network link 4',
					'name' => 'member_social_4',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0f07c5a',
					'label' => 'Network link 4',
					'name' => 'member_social_4_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc30cbda',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc20cbd9',
					'label' => 'Social network link 5',
					'name' => 'member_social_5',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0e07c59',
					'label' => 'Network link 5',
					'name' => 'member_social_5_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc20cbd9',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc10cbd8',
					'label' => 'Social network link 6',
					'name' => 'member_social_6',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be4907c5d',
					'label' => 'Network link 6',
					'name' => 'member_social_6_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc10cbd8',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_team_member',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));

		//PORTFOLIO PAGE
	    register_field_group(array (
	        'id' => 'acf_theme-portfolio-grid-options',
	        'title' => 'Theme Portfolio Options',
	        'fields' => array (
	        	array (
	        	    'key' => 'field_528b759sepamn',
	        	    'label' => 'Navigation',
	        	    'name' => 'separa_mn',
	        	    'type' => 'acf_field_separator',
	        	    'instructions' => '',
	        	    'choices' => '',
	        	    'default_value' => '',
	        	),
	        	array (
	        	    'key' => 'field_528b759ebcafe',
	        	    'label' => 'Menu display - Show content behind the menu?',
	        	    'name' => 'featured_header',
	        	    'type' => 'true_false',
	        	    'message' => 'With this option selected the menu will have before and after scroll states',
	        	    'default_value' => 0,
	        	),
	        	array (
	        	    'key' => 'field_528b759csepaap',
	        	    'label' => 'Appearance',
	        	    'name' => 'separa_ap',
	        	    'type' => 'acf_field_separator',
	        	    'instructions' => '',
	        	    'choices' => '',
	        	    'default_value' => '',
	        	),
	            array (
	                'key' => 'field_8320f34a75901',
	                'label' => 'General layout',
	                'name' => 'portfolio_layout',
	                'type' => 'select',
	                'choices' => array (
	                	'featured' => esc_html__('Showcase Mode - 1 Project Per Screen', 'hook'),
	                	'panels' => esc_html__('Vertical Panels', 'hook'),
	                	'packery' => esc_html__('Grid - Multi-width', 'hook', 'hook'),
            			'grid' => esc_html__('Grid with horizontal rectangular images', 'hook'),
            			'grid_vertical' => esc_html__('Grid with vertical rectangular images', 'hook'),
            			'squares' => esc_html__('Grid with squared images', 'hook'),
	                    'masonry' => esc_html__('Grid without image crop - Masonry', 'hook'),
	                ),
	                'default_value' => 'masonry',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
                    'key' => 'field_528a450emover',
                    'label' => 'Limit content width?',
                    'name' => 'limited_width',
                    'type' => 'true_false',
                    'message' => '',
                    'default_value' => 1,
                    'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529732e396c0b',
	                'label' => 'Number of columns',
	                'name' => 'cols_number',
	                'type' => 'select',
	                'choices' => array (
            			'2' => '2',
            			'3' => '3',
            			'4' => '4',
            			'5' => '5',
	                    '6' => '6',
	                ),
	                'default_value' => 'masonry',
	                'allow_null' => 0,
	                'multiple' => 0,
                    'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529732epanels',
	                'label' => 'Number of panels',
	                'name' => 'panels_number',
	                'type' => 'select',
	                'choices' => array (
            			'1' => '1',
            			'3' => '3',
            			'4' => '4',
            			'5' => '5',
	                ),
	                'default_value' => '3',
	                'allow_null' => 0,
	                'multiple' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'panels',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529732epanbeh',
	                'label' => 'Panels image display',
	                'name' => 'panels_display',
	                'type' => 'select',
	                'choices' => array (
            			'hook_def_panel' => 'Single image - switch background on rollover',
            			'hook_img_panel' => 'Multiple images - one image per panel',
	                ),
	                'default_value' => 'hook_def_panel',
	                'allow_null' => 0,
	                'multiple' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'panels',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529730563ba39',
	                'label' => 'Number of posts to load',
	                'name' => 'items_number',
	                'type' => 'number',
	                'required' => 1,
	                'default_value' => 9,
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'min' => 1,
	                'max' => '',
	                'step' => '',
	            ),
	            array (
                    'key' => 'field_528a450loadre',
                    'label' => 'Preload images',
                    'name' => 'preload_images',
                    'type' => 'true_false',
                    'message' => 'If yes, content will not be show until images are loaded',
                    'default_value' => 0,
                ),
                array (
                    'key' => 'field_528a340easter',
                    'label' => 'Autoplay slideshow?',
                    'name' => 'autoplay',
                    'type' => 'true_false',
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_8320f34a75901',
                                'operator' => '==',
                                'value' => 'featured',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'message' => '',
                    'default_value' => 1,
                ),
                array (
                    'key' => 'field_528akukaawill',
                    'label' => 'Slideshow delay in miliseconds',
                    'name' => 'autoplay_delay',
                    'type' => 'number',
                    'required' => 1,
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_8320f34a75901',
                                'operator' => '==',
                                'value' => 'featured',
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
	            array (
	                'key' => 'field_8320f34alenha',
	                'label' => 'Text position',
	                'name' => 'text_align',
	                'type' => 'select',
	                'choices' => array (
	                	'hook_lf' => 'Bottom',
	                	'hook_ct' => 'Middle',
	                ),
	                'default_value' => 'hook_lf',
	                'allow_null' => 0,
	                'multiple' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'any',
	                ),
	            ),
				array (
	                'key' => 'field_529738c0corre',
	                'label' => 'Make text color have the post featured color?',
	                'name' => 'special_text_color',
	                'type' => 'true_false',
	                'message' => '',
	                'default_value' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_8320f34a7beha',
	                'label' => 'Background videos behavior',
	                'name' => 'videos_behavior',
	                'type' => 'select',
	                'choices' => array (
	                	'default' => 'Loop & autoplay (sound OFF)',
	                	'restart' => 'Restart and play on rollover',
	                	'resume' => 'Resume and play on rollover',
	                ),
	                'default_value' => 'default',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529732epsound',
	                'label' => 'Show mute videos button',
	                'name' => 'mute_button',
	                'type' => 'select',
	                'choices' => array (
            			'hide_now' => 'No',
            			'hide_later' => 'Yes',
	                ),
	                'default_value' => '3',
	                'allow_null' => 0,
	                'multiple' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '==',
	                            'value' => 'panels',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529737270f73c',
	                'label' => 'Portfolio skills to be displayed',
	                'name' => 'cat_filter',
	                'type' => 'taxonomy',
	                'instructions' => 'Leave blank for all',
	                'taxonomy' => 'pirenko_skills',
	                'field_type' => 'checkbox',
	                'allow_null' => 0,
	                'load_save_terms' => 0,
	                'return_format' => 'object',
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529738c0624fc',
	                'label' => 'Show skills filter above thumbnails?',
	                'name' => 'show_filter',
	                'type' => 'true_false',
	                'message' => '',
	                'default_value' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_528a45btakeme',
	                'label' => 'Filter alignment',
	                'name' => 'filter_align',
	                'type' => 'select',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_529738c0624fc',
	                            'operator' => '==',
	                            'value' => '1',
	                        ),
                            array (
                                'field' => 'field_8320f34a75901',
                                'operator' => '!=',
                                'value' => 'panels',
                            ),
                            array (
                                'field' => 'field_8320f34a75901',
                                'operator' => '!=',
                                'value' => 'featured',
                            ),
	                    ),
	                    'allorany' => 'all',
	                ),
	                'choices' => array (
	                    'filter_left' => 'Left',
	                    'filter_center' => 'Center',
	                    'filter_right' => 'Right',
	                ),
	                'default_value' => 'filter_center',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529735738ad74',
	                'label' => 'Thumbnails margin',
	                'name' => 'thumbs_mg',
	                'type' => 'number',
	                'required' => 1,
	                'default_value' => 0,
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'min' => 0,
	                'max' => '',
	                'step' => '',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_529751afeaaa3',
	                'label' => 'Multi-colored thumbs on rollover?',
	                'name' => 'multicolored_thumbs',
	                'type' => 'true_false',
	                'message' => 'If no the portfolio default color will be applied to each thumb',
	                'default_value' => 1,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_8320f34a000723',
	                'label' => 'Project click behavior?',
	                'name' => 'thumbs_type_folio',
	                'type' => 'select',
	                'choices' => array (
	                	'overlayed' => 'Show project with an overlay and hide page content',
            			'lightboxed' => 'Open lightbox',
            			'classiqued' => 'Open project on a different page',
            			'hook_unlinked' => 'Do nothing',
	                ),
	                'default_value' => 'classiqued',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_8320f34a92600',
	                'label' => 'Show project information?',
	                'name' => 'hook_show_skills',
	                'type' => 'select',
	                'choices' => array (
            			'folio_title_and_skills' => 'On rollover - Title and skills',
            			'folio_title_only' => 'On rollover - Title only',
            			'folio_always_title_and_skills hk_ins' => 'Always show inside thumb - Title and skills',
            			'folio_always_title_only hk_ins' => 'Always show inside thumb - Title only',
            			'folio_always_title_and_skills' => 'Always show under thumb - Title and skills',
            			'folio_always_title_only' => 'Always show under thumb - Title only',
	                ),
	                'default_value' => 'folio_title_and_skills',
	                'allow_null' => 0,
	                'multiple' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
                array (
    				'key' => 'field_52877cc6liner',
    				'label' => 'Carousel column divider line opacity',
    				'name' => 'panel_alpha',
    				'type' => 'number',
    				'instructions' => '',
    				'default_value' => '50',
    				'required' => 1,
    				'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_8320f34a75901',
                                'operator' => '==',
                                'value' => 'panels',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'placeholder' => '',
    				'prepend' => '',
    				'append' => '',
    				'min' => 0,
    				'max' => 100,
    				'step' => 1,
    			),
				array (
			        'key' => 'field_528a450cfutre',
			        'label' => 'Hide footer?',
			        'name' => 'hide_footer',
			        'type' => 'true_false',
			        'message' => '',
			        'default_value' => 0,
			    ),
    			array (
    			    'key' => 'field_528b759sepatt',
    			    'label' => 'Title Display',
    			    'name' => 'separa_tt',
    			    'type' => 'acf_field_separator',
    			    'instructions' => '',
    			    'choices' => '',
    			    'default_value' => '',
    			),
	        	array (
	                'key' => 'field_528a450cef555',
	                'label' => 'Show page title?',
	                'name' => 'show_title',
	                'type' => 'true_false',
	                'message' => '',
	                'default_value' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'panels',
	                        ),
	                        array (
	                            'field' => 'field_8320f34a75901',
	                            'operator' => '!=',
	                            'value' => 'featured',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_528c54accc439',
	                'label' => 'Title alignment',
	                'name' => 'header_align',
	                'type' => 'select',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_528a450cef555',
	                            'operator' => '==',
	                            'value' => '1',
	                        ),
	                        array (
	                            'field' => 'field_528a999ea4be8',
	                            'operator' => '!=',
	                            'value' => '1',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	                'choices' => array (
	                    'hook_left_align' => 'Left',
	                    'hook_center_align' => 'Center',
	                    'hook_right_align' => 'Right'
	                ),
	                'default_value' => 'hook_center_align',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_5281127acc438',
	                'label' => 'Header text',
	                'name' => 'below_headings_text',
	                'type' => 'textarea',
	                'instructions' => 'Will be displayed under the page title',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_528a450cef555',
	                            'operator' => '==',
	                            'value' => '1',
	                        ),
	                        array (
	                            'field' => 'field_528a999ea4be8',
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
	        ),
	        'location' => array (
	            array (
	                array (
	                    'param' => 'page_template',
	                    'operator' => '==',
	                    'value' => 'page-portfolio.php',
	                    'order_no' => 0,
	                    'group_no' => 0,
	                ),
	            ),
	        ),
	        'options' => array (
	            'position' => 'normal',
	            'layout' => 'default',
	            'hide_on_screen' => array (
	                0 => 'custom_fields',
	            ),
	        ),
	        'menu_order' => 0,
	    ));
		$prk_hook_options=get_option('prk_hook_options');

		//PORTFOLIO SINGLES
		register_field_group(array (
			'id' => 'acf_theme-portfolio-options',
			'title' => 'Theme Portfolio Options',
			'fields' => array (
                array (
                    'key' => 'field_5289f65csepaap',
                    'label' => 'Appearance',
                    'name' => 'separa_ap',
                    'type' => 'acf_field_separator',
                    'instructions' => '',
                    'choices' => '',
                    'default_value' => '',
                ),
                array (
                    'key' => 'field_528a5fc30297d',
                    'label' => 'Post layout',
                    'name' => 'inner_layout',
                    'type' => 'select',
                    'choices' => array (
                        'default' => 'Default option',
                        'half' => 'Split - post info panel on the right side',
                        'wide' => 'Boxed - featured slider with margins',
                        'wideout' => 'Full width - featured slider without margins',
                        'custom' => 'Custom layout - only post content will be shown',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array (
                    'key' => 'field_528a5fcbhj4sd',
                    'label' => 'Post info display',
                    'name' => 'info_display',
                    'instructions' => 'How the post custom fiels and social sharing buttons will be displayed',
                    'type' => 'select',
                    'choices' => array (
                        'below' => 'Info before and sharing buttons after content',
                        'right_side' => 'Info on the right side',
                        'hidden' => "Don't display any of this info",
                    ),
                    'conditional_logic' => array (
                        'status' => 1,
                        'rules' => array (
                            array (
                                'field' => 'field_528a5fc30297d',
                                'operator' => '!=',
                                'value' => 'half',
                            ),
                            array (
                                'field' => 'field_528a5fc30297d',
                                'operator' => '!=',
                                'value' => 'custom',
                            ),
                        ),
                        'allorany' => 'all',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array (
                    'key' => 'field_528664954175a',
                    'label' => 'Featured Color',
                    'name' => 'featured_color',
                    'type' => 'color_picker',
                    'instructions' => '(optional)',
                    'default_value' => '',
                ),
                array (
                    'key' => 'field_5ggju66702cec',
                    'label' => 'Portfolio parent page',
                    'name' => 'parent_page',
                    'type' => 'page_link',
                    'instructions' => 'Will be used on the back to portfolio button. Use this option only if you want to force a specific page.',
                    'post_type' => array (
                        0 => 'page',
                    ),
                    'allow_null' => 1,
                    'multiple' => 0,
                ),
				array (
				    'key' => 'field_5289f65sepath',
				    'label' => 'Thumbnail Options',
				    'name' => 'separa_th',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
					'key' => 'field_5286a3dcustom',
					'label' => 'Custom Logo (for portfolio feeds)',
					'name' => 'custom_logo',
					'type' => 'image',
					'instructions' => 'Optional. Will be shown inside thumbnails and will be scaled to 50% of the original size (retina support)',
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
	                'key' => 'field_5286a3dcutext',
	                'label' => 'Thumbnail tag (for portfolio feeds)',
	                'name' => 'thumb_tag',
	                'type' => 'text',
	                'instructions' => 'Optional. Will be shown inside the thumbnail.',
	                'default_value' => '',
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'formatting' => 'none',
	                'maxlength' => '',
	            ),
	            array (
                    'key' => 'field_5286a3dcutski',
                    'label' => 'Custom text tag (for portfolio feeds)',
                    'name' => 'thumb_skills',
                    'type' => 'wysiwyg',
					'default_value' => '',
					'toolbar' => 'basic',
					'media_upload' => 'no',
                    'instructions' => 'Optional. Will replace the skills text.',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'none',
                    'maxlength' => '',
                ),
				array (
	                'key' => 'field_528apackery_h',
	                'label' => 'Thumbnail width (for portfolio feeds)',
	                'name' => 'custom_width',
	                'instructions' => 'Multi-width layout only',
	                'type' => 'select',
	                'choices' => array (
	                    'hook_hz_one' => 'Regular',
	                    'hook_hz_two' => 'Double',
	                ),
	                'default_value' => '',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
    			array (
                    'key' => 'field_528apackery_v',
                    'label' => 'Thumbnail shape (for portfolio feeds)',
                    'name' => 'orientation',
                    'instructions' => 'Multi-width layout only',
                    'type' => 'select',
                    'choices' => array (
                        'landscape' => 'Horizontal Rectangle - Landscape',
	                    'portrait' => 'Vertical Rectangle - Portrait',
	                    'square' => 'Square',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
                array (
                	'key' => 'field_5286b44global',
                	'label' => 'Video thumbnail MP4 file path (for portfolio feeds)',
                	'name' => 'video_thumb',
                	'type' => 'text',
                	'instructions' => 'Optional. Should match featured image relative proportions.',
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'html',
                	'maxlength' => '',
                ),
                array (
                	'key' => 'field_5286b44glwebm',
                	'label' => 'Video thumbnail webm file path (for portfolio feeds)',
                	'name' => 'video_thumb_webm',
                	'type' => 'text',
                	'instructions' => 'Optional. Should match featured image relative proportions.',
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'html',
                	'maxlength' => '',
                ),
                array (
                	'key' => 'field_5286b44gtubas',
                	'label' => 'Video thumbnail iframe embed code from YouTube, Vimeo, etc...',
                	'name' => 'video_thumb_iframe',
                	'type' => 'text',
                	'instructions' => 'Optional. Width and height parameters must be included. Video controls should be disabled.<br>Here is an example from YouTube: <em>&lt;iframe width="1280" height="720" src="http://www.youtube.com/embed/41GZVVcxQps?autoplay=1&controls=0&showinfo=0&loop=1​&rel=0" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</em>',
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'html',
                	'maxlength' => '',
                ),
	            array (
	                'key' => 'field_5289f65sepain',
	                'label' => 'Informational Fields',
	                'name' => 'separa_in',
	                'type' => 'acf_field_separator',
	                'instructions' => '',
	                'choices' => '',
	                'default_value' => '',
	            ),
				array (
					'key' => 'field_5286b3e53bbb9',
					'label' => 'Client',
					'name' => 'client_url',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b3e53fld1',
					'label' => 'Extra field 1 - current translation is '.$prk_hook_options['extra_fld1'],
					'name' => 'extra_fld1',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b3e53bfld2',
					'label' => 'Extra field 2 - current translation is '.$prk_hook_options['extra_fld2'],
					'name' => 'extra_fld2',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b3e53bfld3',
					'label' => 'Extra field 3 - current translation is '.$prk_hook_options['extra_fld3'],
					'name' => 'extra_fld3',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b449ec69f',
					'label' => 'Project link',
					'name' => 'ext_url',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b448ec69e',
					'label' => 'Project link text',
					'name' => 'ext_url_label',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528aa51c449fa',
					'label' => 'Open project link when thumb is clicked?',
					'name' => 'skip_to_external',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
	                'key' => 'field_528a5fc45neue',
	                'label' => 'Open link in a new window?',
	                'name' => 'new_window',
	                'type' => 'select',
	                'choices' => array (
	                    '_blank' => 'Yes',
	                    '_self' => 'No',
	                ),
	                'default_value' => '_blank',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
                    'key' => 'field_5289f65sepamd',
                    'label' => 'Media Management',
                    'name' => 'separa_md',
                    'type' => 'acf_field_separator',
                    'instructions' => '',
                    'choices' => '',
                    'default_value' => '',
                ),
				array (
					'key' => 'field_5286b34b1e739',
					'label' => 'Skip featured image on single page and lightbox?',
					'name' => 'skip_featured',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_52f4c8aca4146',
					'label' => 'Disable slider and stack images vertically?',
					'name' => 'no_slider',
					'type' => 'true_false',
					'default_value' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'fullscreen',
							),
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'no_cropping',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
	                'key' => 'field_528a5fc45683d',
	                'label' => 'Media Type',
	                'name' => 'use_gallery',
	                'type' => 'select',
	                'choices' => array (
	                    'both_types' => 'Images and videos (maximum 20)',
	                    'images_only' => 'Images only (bulk selection)',
	                ),
	                'default_value' => 'both_types',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
				array (
					'key' => 'field_52f4c8bcf5146',
					'label' => 'Image Gallery',
					'name' => 'image_gallery',
					'type' => 'wysiwyg',
					'default_value' => '',
					'toolbar' => 'basic',
					'media_upload' => 'yes',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'images_only',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a5b702e6b',
					'label' => 'Position 2: Media Type?',
					'name' => 'position_2_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a3d0ccd3d',
					'label' => 'Image 2',
					'name' => 'image_2',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a5b702e6b',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286a6d550bd0',
					'label' => 'Video 2',
					'name' => 'video_2',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a5b702e6b',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286a7b7ef161',
					'label' => 'Position 3: Media Type?',
					'name' => 'position_3_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a77eef160',
					'label' => 'Image 3',
					'name' => 'image_3',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a7b7ef161',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286ad24752c2',
					'label' => 'Video 3',
					'name' => 'video_3',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a7b7ef161',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11e8cccf',
					'label' => 'Position 4: Media Type?',
					'name' => 'position_4_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19e9a21e',
					'label' => 'Image 4',
					'name' => 'image_4',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8cccf',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b230fdeb5',
					'label' => 'Video 4',
					'name' => 'video_4',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8cccf',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11e8ccce',
					'label' => 'Position 5: Media Type?',
					'name' => 'position_5_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19d9a21d',
					'label' => 'Image 5',
					'name' => 'image_5',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8ccce',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22ffdeb4',
					'label' => 'Video 5',
					'name' => 'video_5',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8ccce',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11d8cccd',
					'label' => 'Position 6: Media Type',
					'name' => 'position_6_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19c9a21c',
					'label' => 'Image 6',
					'name' => 'image_6',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d8cccd',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22efdeb3',
					'label' => 'Video 6',
					'name' => 'video_6',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d8cccd',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11c8cccc',
					'label' => 'Position 7: Media Type?',
					'name' => 'position_7_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19c9a21b',
					'label' => 'Image 7',
					'name' => 'image_7',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8cccc',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22dfdeb2',
					'label' => 'Video 7',
					'name' => 'video_7',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8cccc',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11b8cccb',
					'label' => 'Position 8: Media Type?',
					'name' => 'position_8_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19b9a21a',
					'label' => 'Image 8',
					'name' => 'image_8',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11b8cccb',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22cfdeb1',
					'label' => 'Video 8',
					'name' => 'video_8',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11b8cccb',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1178ccca',
					'label' => 'Position 9: Media Type?',
					'name' => 'position_9_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19a9a219',
					'label' => 'Image 9',
					'name' => 'image_9',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1178ccca',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22bfdeb0',
					'label' => 'Video 9',
					'name' => 'video_9',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1178ccca',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1148ccc9',
					'label' => 'Position 10: Media Type?',
					'name' => 'position_10_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b1999a218',
					'label' => 'Image 10',
					'name' => 'image_10',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1148ccc9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22afdeaf',
					'label' => 'Video 10',
					'name' => 'video_10',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1148ccc9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286c7398ccc9',
					'label' => 'Position 11: Media Type?',
					'name' => 'position_11_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a7878a218',
					'label' => 'Image 11',
					'name' => 'image_11',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286c7398ccc9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22affdda',
					'label' => 'Video 11',
					'name' => 'video_11',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286c7398ccc9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528eeeb702e6b',
					'label' => 'Position 12: Media Type?',
					'name' => 'position_12_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a3dcdcd3d',
					'label' => 'Image 12',
					'name' => 'image_12',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528eeeb702e6b',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5255a6d550bd0',
					'label' => 'Video 12',
					'name' => 'video_12',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528eeeb702e6b',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286a665ef161',
					'label' => 'Position 13: Media Type?',
					'name' => 'position_13_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286aaaeef160',
					'label' => 'Image 13',
					'name' => 'image_13',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a665ef161',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5244ad24752c2',
					'label' => 'Video 13',
					'name' => 'video_13',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a665ef161',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11123ccf',
					'label' => 'Position 14: Media Type?',
					'name' => 'position_14_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5232b19e9a21e',
					'label' => 'Image 14',
					'name' => 'image_14',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11123ccf',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_52bbb230fdeb5',
					'label' => 'Video 14',
					'name' => 'video_14',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11123ccf',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b89e8ccce',
					'label' => 'Position 15: Media Type?',
					'name' => 'position_15_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b1769a21d',
					'label' => 'Image 15',
					'name' => 'image_15',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b89e8ccce',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b13ffdeb4',
					'label' => 'Video 15',
					'name' => 'video_15',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b89e8ccce',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11d332cd',
					'label' => 'Position 16: Media Type',
					'name' => 'position_16_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286c66c9a21c',
					'label' => 'Image 16',
					'name' => 'image_16',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d332cd',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22efdea8',
					'label' => 'Video 16',
					'name' => 'video_16',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d332cd',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11c8c74c',
					'label' => 'Position 17: Media Type?',
					'name' => 'position_17_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_4286b19c9a21b',
					'label' => 'Image 17',
					'name' => 'image_17',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8c74c',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_4286b22dfdeb2',
					'label' => 'Video 17',
					'name' => 'video_17',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8c74c',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1139cccb',
					'label' => 'Position 18: Media Type?',
					'name' => 'position_18_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5285c19b9a21a',
					'label' => 'Image 18',
					'name' => 'image_18',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1139cccb',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5285022cfdeb1',
					'label' => 'Video 18',
					'name' => 'video_18',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1139cccb',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b9876ccca',
					'label' => 'Position 19: Media Type?',
					'name' => 'position_19_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5284119a9a219',
					'label' => 'Image 19',
					'name' => 'image_19',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b9876ccca',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5281422bfdeb0',
					'label' => 'Video 19',
					'name' => 'video_19',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b9876ccca',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b114890c9',
					'label' => 'Position 20: Media Type?',
					'name' => 'position_20_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286baa79a218',
					'label' => 'Image 20',
					'name' => 'image_20',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b114890c9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b84ffdeaf',
					'label' => 'Video 20',
					'name' => 'video_20',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b114890c9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_portfolios',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_theme-slide-options',
			'title' => 'Theme Slide Options',
			'fields' => array (
				array (
				    'key' => 'field_528a27fsepatt',
				    'label' => 'Title Display',
				    'name' => 'separa_tt',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
					'key' => 'field_528a27f8c2728',
					'label' => 'Hide title on this slide?',
					'name' => 'hide_slide_text',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_528a2c129a501',
					'label' => 'Rotating text for title',
					'name' => 'pirenko_rotating_text',
					'type' => 'textarea',
					'instructions' => 'Optional. Separate the additional strings with a plus (+) sign.',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'formatting' => 'html',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_6969jd2867a62',
					'label' => 'Text rotator effect',
					'name' => 'pirenko_rotating_effect',
					'type' => 'select',
					'choices' => array (
						'old_timey' => 'Smooth shift',
						'rotate-1' => '3D effect',
						'rotate-2 letters' => 'Fast character rotation',
						'slide' => 'Slide',
						'zoom' => 'Zoom',
						'rotate-3 letters' => 'Character shift',
						'scale letters' => 'Scale',
					),
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a2b2c9e31d',
					'label' => 'Title color',
					'name' => 'pirenko_sh_slide_header_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a2be3faca0',
					'label' => 'Title background color',
					'name' => 'pirenko_sh_slide_header_bk_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a3189b5dfd',
					'label' => 'Title background opacity',
					'name' => 'title_background_color_opacity',
					'type' => 'number',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => 90,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => 100,
					'step' => 5,
				),
				array (
					'key' => 'field_5286434dec69e',
					'label' => 'Title extra CSS classes',
					'name' => 'title_css',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
				    'key' => 'field_528a27fsepaap',
				    'label' => 'Appearance',
				    'name' => 'separa_ap',
				    'type' => 'acf_field_separator',
				    'instructions' => '',
				    'choices' => '',
				    'default_value' => '',
				),
				array (
					'key' => 'field_528a92ab22728',
					'label' => 'Limit text width to be the same as the content width?',
					'name' => 'limit_text_width',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 1,
				),
				array (
					'key' => 'field_528a2845c2729',
					'label' => 'Text size',
					'name' => 'slide_text_size',
					'type' => 'select',
					'choices' => array (
						'medium' => 'Small',
						'big' => 'Medium',
						'huge' => 'Big',

					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a291519de2',
					'label' => 'Content horizontal position',
					'instructions' => 'If the slide content is used the alignment should be set using the row/column text alignment',
					'name' => 'slide_text_horz',
					'type' => 'select',
					'choices' => array (
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a2ac019de3',
					'label' => 'Content vertical position',
					'name' => 'slide_text_vert',
					'type' => 'select',
					'choices' => array (
						'top' => 'Top',
						'v_center' => 'Center',
						'bottom' => 'Bottom',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a2c440f501',
					'label' => 'Video HTML code',
					'name' => 'pirenko_sh_video',
					'type' => 'textarea',
					'instructions' => 'optional',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_528a2ccac3848',
					'label' => 'Open this URL when slide is clicked',
					'name' => 'pirenko_sh_slide_url',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528a2d2867a62',
					'label' => 'Open link in',
					'name' => 'pirenko_sh_slide_wdw',
					'type' => 'select',
					'choices' => array (
						'_self' => 'Same window',
						'_blank' => 'New window',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_slides',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));
	}

?>