</div><!-- #hook_ajax_container -->
<?php
$prk_hook_options=hook_options();
$hook_translated=hook_translations();
$hook_extra_class="";
if ($prk_hook_options['use_footer']=="1") {
    ?>
    <div id="prk_footer_outer">
        <?php
        if ($prk_hook_options['footer_reveal']=="1") {
            ?>
            <div id="prk_footer_mirror" class="columns small-12"></div>
            <?php
            $hook_wrapper_class="";
        }
        else {
            $hook_wrapper_class=" no_mirror";
        }
        if (get_field('hide_footer')==1 || (is_singular('pirenko_portfolios') && $prk_hook_options['footer_port']=="0")) {
            $hook_wrapper_class.=" hook_no_footer";
            $hook_extra_class="hook_no_footer";
        }
        wp_reset_postdata();
        ?>
        <div id="prk_footer_wrapper" class="small-12 row<?php echo esc_attr($hook_wrapper_class); ?>">
            <div id="prk_footer" data-layout="<?php echo esc_attr($prk_hook_options['widgets_nr']); ?>">
                <div id="prk_footer_revealer">
                    <?php
                    if ($prk_hook_options['bottom_page']=="1" && $prk_hook_options['bottom_page_id']!="") {
                        echo '<div id="prk_footer_page">';
                        echo do_shortcode(get_post_field('post_content', $prk_hook_options['bottom_page_id'], 'raw' ));
                        echo '</div>';
                    }
                    if ($prk_hook_options['bottom_sidebar']=="1" && is_active_sidebar('sidebar-footer')) {
                        echo '<div id="prk_footer_sidebar">';
                        echo '<div id="prk_footer_inner" class="columns small-12 prk_inner_block small-centered wpb_animate_when_almost_visible wpb_hook_fade_waypoint">';
                        echo '<div class="row">';
                        if ($prk_hook_options['bottom_sidebar']=="1" && function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-footer')) :
                        else :
                        endif;
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="clearfix"></div>';
                        echo '</div>';
                    }
                    if ($prk_hook_options['bottom_page_after']=="1" && $prk_hook_options['bottom_page_after_id']!="") {
                        echo '<div id="prk_footer_page_after">';
                        echo do_shortcode(get_post_field( 'post_content', $prk_hook_options['bottom_page_after_id'], 'raw' ));
                        echo '</div>';
                    }
                    if ($prk_hook_options['footer_text_extra']!='' || $prk_hook_options['footer_text']!='')
                    {
                        ?>
                        <div id="prk_after_widgets">
                            <div class="columns small-12 prk_inner_block small-centered">
                                <div class="row">
                                    <?php
                                    $hook_html=array(
                                        'a' => array('href' => array(),'title' => array(),'style'=>array(),'target'=>array(),'rel'=>array()),
                                        'p' => array('style'=>array()),
                                        'br' => array('style'=>array()),
                                        'em' => array('style'=>array()),
                                        'span' => array('class' =>array(),'style'=>array()),'strong' => array('style'=>array()),
                                        'img' => array('src' => array(),'width' => array(),'height' => array(),'title' => array(),'style'=>array(),'alt'=>array(),'rel'=>array()),
                                    );
                                    if ($prk_hook_options['footer_text_extra']=='') {
                                        echo '<div class="prk_copyright small-12 hook_center_align columns">'.wp_kses(prk_filters($prk_hook_options['footer_text']),$hook_html);
                                        echo '</div>';
                                    }
                                    else {
                                        echo '<div class="prk_copyright small-6 columns">'.wp_kses(prk_filters($prk_hook_options['footer_text']),$hook_html).'</div>';
                                        echo '<div class="prk_copyright small-6 columns hook_right_align">'.wp_kses(prk_filters($prk_hook_options['footer_text_extra']),$hook_html);
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div><!-- #prk_footer_outer -->
    <?php
}
?>
<div id="hook_to_top" class="prk_radius">
    <div id="arrows_shifter">
        <i class="hook_fa-angle-up"></i>
        <i class="hook_fa-angle-up second"></i>
    </div>
</div>
<!--googleoff: all-->
<div id="hook_ajax_meta">
    <div id="hook_ajax_title"><?php wp_title(); ?></div>
    <div id="hook_ajax_classes" <?php body_class(); ?> data-hook_class="<?php echo esc_attr($hook_extra_class); ?>"></div>
</div>
<!--googleon: all-->
</div><!-- #hook_main_wrapper -->
<?php wp_footer(); ?>
</body>
</html>