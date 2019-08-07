<?php
get_header();
$hook_translated=hook_translations();
$hook_show_sidebar=$prk_hook_options['search_right_sidebar'];
if ($hook_show_sidebar=="1")
    $hook_show_sidebar=true;
else
    $hook_show_sidebar=false;
if ($prk_hook_options['search_image']['url']=="") {
    $hook_featured_style=' class="hook_forced_menu"';
}
else {
    $hook_featured_style=' class="hook_featured_search"';
}
?>
<div id="hook_ajax_inner"<?php echo hook_output().$hook_featured_style; ?>>
    <div id="hook_content" class="hook_search_results">
    <div id="classic_title_wrapper">
        <div id="single_page_title" class="header_font hook_center_align zero_color">
            <h1>
                <?php
                if (!have_posts()) {
                    echo esc_attr($hook_translated['submit_search_no_results'] );
                    echo '<span> "'.get_search_query().'"</span>';
                }
                else {
                    echo esc_attr($hook_translated['submit_search_res_title']);
                    echo '<span> "'.get_search_query().'"</span>';
                }
                ?>
            </h1>
        </div>
    </div>
<?php
if ($hook_show_sidebar==true) {
    ?>
    <div class="small-centered columns prk_inner_block small-12 row">
    <div class="row">
    <div class="small-9 columns prk_extra_r_pad prk_bordered_right">
    <?php
    }
    else {
    ?>
    <div id="s_sec_wp">
    <div id="hook_super_sections">
    <div id="s_sec_inner">
    <div class="small-centered columns prk_inner_block small-12">
    <?php
}
?>
    <ul id="hook_search_ul" class="unstyled">
        <?php
        $i=0;
        while (have_posts()) : the_post();
            $i++;
            ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class('prk_search_res prk_bordered_bottom'); ?>>
                <?php
                $hook_exceprt_size=64;
                if (has_post_thumbnail($post->ID) ) {
                    $hook_exceprt_size=46;
                    $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
                    $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , 200, 200, true , $hook_retina_device );
                    ?>
                    <div class="grid_image_wrapper">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url($hook_vt_image['url']); ?>" width="<?php echo esc_attr($hook_vt_image['width']); ?>" height="<?php echo esc_attr($hook_vt_image['height']); ?>" class="custom-img grid_image prk_lf" alt="<?php echo esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))); ?>" />
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="hook_search_title">
                    <h4 class="header_font zero_color prk_heavier_600 big">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                </div>
                <div class="prk_9_em hook_search_content">
                    <?php
                    $hook_cat_helper=$post->ID;
                    echo hook_excerpt_dynamic($hook_exceprt_size,$post->ID);
                    echo '<div class="colored_theme_button prk_small"><a href="'.get_permalink($hook_cat_helper).'" class="prk_heavier_700 hook_anchor">';
                    echo esc_attr($hook_translated['read_more']);
                    echo '</a></div>';
                    ?>
                </div>
            </li>
        <?php
        endwhile;
        ?>
    </ul>
<?php
if ($i==0) {
    echo '<div class="clearfix bt_2x"></div>';
    echo "<h4 class='zero_color hook_center_align header_font'>".esc_html__('Sorry, but it seems that there are no results... Try again?','hook').'</h4>';
    echo '<div class="clearfix bt_4x"></div>';
    echo '<div class="small-6 small-centered columns">';
    get_search_form();
    echo '</div>';
    echo '<div class="clearfix bt_2x"></div>';
    echo '<ul class="unstyled hook_center_align prk_9_em">';
    echo '<li>'.esc_html__('Double check your spelling','hook').'</li>';
    echo '<li>'.esc_html__('Try using single words (e.g. painting, book)','hook').'</li>';
    echo '<li>'.esc_html__('Try searching for something that is less specific','hook').'</li>';
    echo '</ul>';
    echo '<div class="clearfix bt_4x"></div>';
}
?>
    <div class="clearfix"></div>
<?php hook_paging_nav(); ?>
    </div>
<?php
if ($hook_show_sidebar)
{
    ?>
    <div id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?> inside prk_rf zero_right">
        <?php get_sidebar(); ?>
    </div>
    <?php
}
?>
    </div>
    </div>
    <div class="clearfix"></div>
    </div>
    </div>
    </div>
<?php get_footer(); ?>