<?php 
	get_header();
	$hook_inportfolio_layout=$prk_hook_options['archives_ptype'];
	$hook_show_title=true;
	$hook_multicolored_thumbs="yes";
	$hook_titled_portfolio="no";
	$hook_show_filter="no";
	$hook_cols_number="3";
	$hook_preload="no";
	$hook_sides_pad="";
	$hook_show_skills='folio_title_only';
	$hook_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	$hook_tag_filter=$hook_term->slug;
	$hook_cat_filter="";
	?>
	<div id="hook_ajax_inner" class="hook_forced_menu">
		<div id="hook_content">
			<div id="portfolio_single_page" class="<?php if (get_field('limited_width')==0 || $hook_inportfolio_layout=="panels" || $hook_inportfolio_layout=="featured"){echo 'wided_folio';}else{echo 'prk_inner_block small-12 small-centered columns';} ?>">
				<?php
					if ($hook_show_title==true) {
					    $hook_uppercase="";
					    if (get_field('uppercase_title')=="1") {
					        $hook_uppercase=" uppercased_title";
					    }
					    echo '<div id="classic_title_wrapper">';
					    echo '<div class="small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
					    hook_output_title();
					    echo '</div>';
					    echo '</div>';
					}
					echo do_shortcode('[pirenko_last_portfolios thumbs_type_folio="classiqued" layout_type_folio="'.esc_attr($hook_inportfolio_layout).'" cols_number="'.esc_attr($hook_cols_number).'" cat_filter="'.esc_attr($hook_cat_filter).'" tag_filter="'.esc_attr($hook_tag_filter).'" multicolored_thumbs="'.esc_attr($hook_multicolored_thumbs).'" hook_show_skills="'.esc_attr($hook_show_skills).'" show_filter="'.esc_attr($hook_show_filter).'" hook_preload="'.esc_attr($hook_preload).'" sides_pad="'.esc_attr($hook_sides_pad).'" show_load_more="true"][/pirenko_last_portfolios]');
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>