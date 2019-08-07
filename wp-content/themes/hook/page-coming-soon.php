<?php
/*
Template Name: Coming Soon Page
*/
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php
        $prk_hook_options=hook_options();
        $hook_retina_device=hook_retiner(true);
        hook_header();
        wp_head();
    ?>
</head>
<body <?php body_class(); ?>>
    <div id="hook_main_wrapper" class="<?php if ($prk_hook_options['buttons_inner_shadow']=="1") {echo "shadowed_buttons ";}echo esc_attr($prk_hook_options['menu_display'].' '.$prk_hook_options['menu_align'].' '.$prk_hook_options['logo_align']); ?> prk_wait">
    <?php
        hook_preloader();
    ?>
    <div id="hook_ajax_container" class="hook_coming">
        <div id="hook_ajax_inner" class="forced_row hook_first_row"> 
            <div id="hook_main_block" class="row header_font wpb_animate_when_almost_visible wpb_hook_fade_waypoint delay-400">
                <?php
                    while (have_posts()) : the_post();
                    if (get_the_content()!="") {
                        ?>
                        <div id="hook_coming_wrapper">
                            <?php the_content(); ?>
                        </div>
                        <?php
                    }
                    endwhile;
                ?>
                <div id="hook_countdown_wrapper" data-color="<?php echo esc_attr(get_field('text_color')); ?>" class="header_font wpb_animate_when_almost_visible wpb_hook_fade_waypoint delay-400">
                    <?php
                        $hook_launch_date=get_field('launch_date');
                        if ($hook_launch_date!="") {
                            $hook_year=substr($hook_launch_date, 0, 4);
                            $hook_month=substr($hook_launch_date, 4, 2);
                            $hook_day=substr($hook_launch_date, 6, 2);
                            echo '<div class="hook_countdown per_init" data-year="'.esc_attr($hook_year).'" data-month="'.esc_attr($hook_month).'" data-day="'.esc_attr($hook_day).'"></div>';
                        }
                        else {
                            $hook_year=$hook_month=$hook_day="0";
                        }
                    ?>
                    <?php
                        if (get_field('below_headings_text')!="") {
                            ?>
                                <div id="hook_countdown_footer" class="body_font">
                                    <?php echo get_field('below_headings_text'); ?>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <?php
                if (get_field('image_back')!="") {
                    $hook_image=wp_get_attachment_image_src(get_field('image_back'),'full');
                    ?>
                        <div id="hook_full_back" data-image="<?php echo esc_url($hook_image[0]); ?>"></div>
                        <div class="hook_preloaded hide_now">
                            <img src="<?php echo esc_url($hook_image[0]); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$hook_image[0])); ?>" />
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
    </div>
    <?php get_footer(); ?>