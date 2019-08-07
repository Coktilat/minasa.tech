<?php
/*
Template Name: Portfolio Page
*/
get_header();
$hook_inportfolio_layout=get_field('portfolio_layout');
$hook_show_title=false;
if (get_field('show_title')=="1")
{
    $hook_show_title=true;
}
if (get_field('titled_portfolio')=="1")
    $hook_titled_portfolio="yes";
else
    $hook_titled_portfolio="no";
if (get_field('show_filter')=="1")
    $hook_show_filter="yes";
else
    $hook_show_filter="no";
if (get_field('cols_number')!="" && get_field('cols_number')!="0")
    $hook_cols_number=get_field('cols_number');
else
    $hook_cols_number="3";
if (get_field('featured_header')=="1") {
    $hook_featured_style='';
}
else {
    $hook_featured_style=' class="hook_forced_menu"';
}
if (get_field('preload_images')=="1")
    $hook_preload="yes";
else
    $hook_preload="no";
$hook_tag_filter=$hook_cat_filter="";
$hook_cats_counter=0;
if (get_field('cat_filter')!="") {
    $hook_filter=get_field('cat_filter');
    foreach ($hook_filter as $hook_child) {
        $hook_cat_filter.=$hook_child->slug.", ";
        $hook_cats_counter++;
    }
}
$hook_sides_pad=0;
if (get_field('limited_width')==0) {
    $hook_sides_pad=get_field('thumbs_mg');
}
if (!post_password_required()) {
    ?>
    <div id="hook_ajax_inner"<?php echo hook_output().$hook_featured_style; ?>>
        <div id="hook_content">
            <?php
            wp_reset_postdata();
            while (have_posts()) : the_post();
                if (get_the_content()!=="") {
                    echo '<div id="s_sec_inner" class="row">';

                    the_content();

                    echo '</div>';
                }
            endwhile;
            ?>
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
                echo do_shortcode('[pirenko_last_portfolios thumbs_type_folio="'.get_field('thumbs_type_folio').'" layout_type_folio="'.$hook_inportfolio_layout.'" cols_number="'.$hook_cols_number.'" items_number="'.get_field('items_number').'" cat_filter="'.$hook_cat_filter.'" tag_filter="'.$hook_tag_filter.'" thumbs_mg="'.get_field('thumbs_mg').'" multicolored_thumbs="'.get_field('multicolored_thumbs').'" hook_show_skills="'.get_field('hook_show_skills').'" show_filter="'.$hook_show_filter.'" filter_align="'.esc_attr(get_field('filter_align')).'" videos_behavior="'.get_field('videos_behavior').'" hook_preload="'.$hook_preload.'" sides_pad="'.$hook_sides_pad.'" panels_number="'.get_field('panels_number').'" special_text_color="'.get_field('special_text_color').'" panel_alpha="'.get_field('panel_alpha').'" text_align="'.get_field('text_align').'" autoplay="'.get_field('autoplay').'" autoplay_delay="'.get_field('autoplay_delay').'" show_load_more="true" mute_button="'.get_field('mute_button').'"  panels_display="'.get_field('panels_display').'"][/pirenko_last_portfolios]');
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php
}
else {
    echo '<div id="hook_ajax_inner"><div id="hook_main_block"><div id="prk_protected" class="columns twelve centered">';
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    echo '</div></div></div>';
}
?>
<?php get_footer(); ?>