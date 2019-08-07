<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * The Template for displaying all single events
 * 
 * @author Webnus <info@webnus.biz>
 * @package MEC/Templates
 * @version 1.0.0
 */
get_header('mec'); ?>
<div id="hook_ajax_inner" class="hook_blog_single row hook_forced_menu">
    <?php do_action('mec_before_main_content'); ?>

        <section id="<?php echo apply_filters('mec_single_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_single_page_html_class', 'mec-container'); ?>">
		<?php while(have_posts()): the_post(); ?>

            <?php $MEC = MEC::instance(); echo hook_output().$MEC->single(); ?>

		<?php endwhile; // end of the loop. ?>
	    <?php comments_template(); ?>
        </section>
    <?php do_action('mec_after_main_content'); ?>
</div>
<?php get_footer('mec');