<?php 
    get_header();
    $hook_show_sidebar=$prk_hook_options['right_sidebar'];
    if ($hook_show_sidebar=="1")
        $hook_show_sidebar=true;
    else
      $hook_show_sidebar=false;
    if (get_field('show_sidebar')=="yes") 
    {
        $hook_show_sidebar=true;
    }
    if (get_field('show_sidebar')=="no") 
    {
        $hook_show_sidebar=false;
    }
    $hook_show_image="yes";
    if (get_field('show_member_image')!="1")
    {
        $hook_show_image="no";
    }
    $hook_slider_class="not_slider";
    if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
    {
        $hook_featured_color=get_field('featured_color');
        $hook_featured_class=' featured_color';
    }
    else
    {
        $hook_featured_color="default";
        $hook_featured_class="";
    };
    while (have_posts()) : the_post();
        if (get_field('member_layout')=="regular")
        {
            ?>
            <div id="hook_ajax_inner" class="hook_forced_menu<?php echo esc_attr($hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <div id="hook_content">
                    <div class="row">
                        <?php 
                            if ($hook_show_image=="yes") {
                                echo '<div class="small-12 columns prk_inner_block small-centered">';
                                if ($hook_show_sidebar) {
                                    echo '<div class="row">';
                                    echo '<div class="small-9 columns">';
                                }
                            ?>
                                <div id="not_slider">
                                    <ul class="slides unstyled hook_preloaded">
                                        <?php
                                            if (get_field('image_2')!="") {
                                                $hook_in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                echo '<li><img src="'.$hook_in_image[0].'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_2'))).'" /></li>';
                                            }
                                            else {
                                                if (has_post_thumbnail($post->ID)) {
                                                    $hook_in_image=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo esc_url($hook_in_image[0]); ?>" alt="<?php echo esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))); ?>" />
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>   
                                <?php
                            }
                            else {
                                echo '<div class="clearfix bt_1x"></div>';
                            }
                        ?>
                        <div id="member_full_row" data-color="<?php echo esc_attr($hook_featured_color); ?>" class="row">
                        <div id="member_resume" class="prk_member small-3 columns">
                        <h1 id="member_post_title" class="header_font zero_color">
                            <?php the_title(); ?>
                        </h1>
                        <?php
                            if (get_field('member_job')!="") {
                                echo '<div class="prk_button_like">';
                                echo esc_attr(get_field('member_job'));
                                echo '</div>';
                            }
                            else {
                                echo '<div class="clearfix bt_1x"></div>';
                            }
                        ?>           
                        <div class="clearfix"></div>
                        <?php
                            if (get_field('member_email')!="" || get_field('member_social_1')!="none" || get_field('member_social_2')!="none" || get_field('member_social_3')!="none" || get_field('member_social_4')!="none" || get_field('member_social_5')!="none" || get_field('member_social_6')!="none") {
                                echo '<div id="in_touch" class="header_font zero_color smaller_font prk_heavier_600">';
                                echo esc_attr($hook_translated['in_touch_text']);
                                echo '</div>';
                            }
                        ?>
                        <div class="pirenko_social minimal">
                            <?php hook_member_nets($post->ID); ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="small-9 columns">
                        <div id="hook_member_description">
                            <?php the_content(); ?> 
                        </div>
                        <?php
                            if(next_post_link_plus(array('in_same_cat' => true,'return' => 'id')) || previous_post_link_plus(array('in_same_cat' => true,'return' => 'id'))) {
                                ?>
                                <div id="hook_member_footer" class="hook_navigation_singles prk_heavier_600 header_font small_headings_color hook_anchor prk_bordered_top"> 
                                    <div class="navigation-previous-blog prk_lf">
                                        <?php next_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<i class="prk_lf hook_fa-chevron-left"></i><div class="prk_lf">%title</div>'
                                            ));
                                        ?>
                                    </div>
                                    <div class="navigation-next-blog prk_rf">
                                        <?php previous_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<div class="prk_lf bf_icon_blog">%title</div><i class="prk_lf hook_fa-chevron-right"></i>'
                                            ));
                                        ?>
                                    </div>
                                    <div class="clearfix"></div> 
                                </div>
                                <?php
                            }
                        ?>
                </div>
            </div>
            <?php 
                if ($hook_show_sidebar) {
                    echo '</div>';
                    ?>
                    <div class="small-12 columns show_later">
                        <div class="simple_line on_sidebar"></div>
                    </div>
                    <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?> on_single_member">
                       <?php get_sidebar(); ?>
                    </aside>
                    <?php
                    echo '</div>';
               }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
        </div>
    </div>
    <?php
    }
    else if (get_field('member_layout')=="big_image")
        {
            ?>
            <div id="hook_ajax_inner" class="hook_biggie<?php echo esc_attr($hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <div id="hook_content" class="row">
                        <?php 
                            if ($hook_show_image=="yes")
                            {
                                ?>
                                <div id="not_slider">
                                    <ul class="slides unstyled hook_preloaded">
                                        <?php
                                            if (get_field('image_2')!="")
                                            {
                                                $hook_in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                echo '<li><img src="'.esc_url($hook_in_image[0]).'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_2'))).'" /></li>';
                                            }
                                            else
                                            {
                                                if (has_post_thumbnail($post->ID) ) {
                                                    $hook_in_image=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo esc_url($hook_in_image[0]); ?>" alt="<?php echo esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))); ?>" />
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>   
                                <?php
                            }
                            else
                            {
                                echo '<div class="clearfix bt_1x"></div>';
                            }
                        ?>
                        <div class="small-12 columns prk_inner_block small-centered">
                            <?php
                                if ($hook_show_sidebar) {
                                    echo '<div class="row">';
                                    echo '<div class="small-9 columns">';
                                    }
                            ?>
                                <div id="member_full_row" data-color="<?php echo esc_attr($hook_featured_color); ?>" class="row">
                                <div id="member_resume" class="prk_member small-3 columns">
                                <h1 id="member_post_title" class="header_font zero_color">
                                    <?php the_title(); ?>
                                </h1>
                                <?php
                                    if (get_field('member_job')!="")
                                    {
                                        echo '<div class="prk_button_like header_font site_background_colored">';
                                        echo esc_attr(get_field('member_job'));
                                        echo '</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="clearfix bt_2x"></div>';
                                    }
                                ?>           
                                <div class="clearfix"></div>
                                <div class="pirenko_social minimal">
                                    <?php hook_member_nets($post->ID); ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                    <div class="small-9 columns">
                        <div id="hook_member_description" class="on_colored prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                            <?php the_content(); ?> 
                            <div class="clearfix"></div>          
                        </div>
                        <?php
                            if(next_post_link_plus(array('in_same_cat' => true,'return' => 'id')) || previous_post_link_plus(array('in_same_cat' => true,'return' => 'id'))) {
                                ?>
                                <div id="hook_member_footer" class="hook_navigation_singles prk_heavier_600 header_font small_headings_color hook_anchor prk_bordered_top"> 
                                    <div class="navigation-previous-blog prk_lf">
                                        <?php next_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<i class="prk_lf hook_fa-chevron-left"></i><div class="prk_lf">%title</div>'
                                            ) );
                                        ?>
                                    </div>
                                    <div class="navigation-next-blog prk_rf">
                                        <?php previous_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<div class="prk_lf bf_icon_blog">%title</div><i class="prk_lf hook_fa-chevron-right"></i>'
                                            ) );
                                        ?>
                                    </div>
                                    <div class="clearfix"></div> 
                                </div>
                                <?php
                            }
                        ?>
                </div>
            </div>
            <?php 
                if ($hook_show_sidebar) 
                {
                    echo '</div>';
                    ?>
                    <div class="small-12 columns show_later">
                        <div class="simple_line on_sidebar"></div>
                    </div>
                    <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?> on_single_member">
                       <?php get_sidebar(); ?>
                    </aside>
                    <?php
                    echo '</div>';
               }
            ?>
            <div class="clearfix"></div> 
        </div>
    </div>
    </div>
    <?php
    }
    else {
        ?>
        <div id="hook_ajax_inner" class="hook_forced_menu<?php echo esc_attr($hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <div id="hook_content" class="row">
                    <div class="small-12 columns prk_inner_block small-centered">
                        <div class="row">
                        <?php 
                            if ($hook_show_image=="yes")
                            {
                                echo '<div class="small-5 columns">';
                                ?>
                                <div id="not_slider">
                                    <ul class="slides unstyled">
                                        <?php
                                            if (get_field('image_2')!="")
                                            {
                                                $hook_in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                echo '<li><img src="'.esc_url($hook_in_image[0]).'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_2'))).'" /></li>';
                                            }
                                            else
                                            {
                                                if (has_post_thumbnail($post->ID) )
                                                {
                                                    $hook_in_image=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo esc_url($hook_in_image[0]); ?>" alt="<?php echo esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))); ?>" />
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>   
                                <?php
                                echo '</div>';
                            }
                        ?>  
                    <div class="small-7 columns">
                            <div id="member_full_row" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                            <div id="member_resume" class="prk_member">
                            <h1 id="member_post_title" class="header_font zero_color">
                                <?php the_title(); ?>
                            </h1>
                            <?php
                                if (get_field('member_job')!="")
                                {
                                    echo '<div class="prk_button_like header_font site_background_colored">';
                                    echo esc_attr(get_field('member_job'));
                                    echo '</div>';
                                }
                                else
                                {
                                    echo '<div class="clearfix bt_1x"></div>';
                                }
                            ?>           
                            <div class="clearfix"></div>
                        </div>                       
                        <div id="hook_member_description" class="prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                            <?php the_content(); ?>           
                        </div>
                        <?php
                        if (get_field('member_email')!="" || get_field('member_social_1')!="none" || get_field('member_social_2')!="none" || get_field('member_social_3')!="none" || get_field('member_social_4')!="none" || get_field('member_social_5')!="none" || get_field('member_social_6')!="none")
                            {
                                ?>
                                <div id="member_half_social">
                                    <div id="in_touch" class="header_font zero_color smaller_font prk_heavier_600">
                                        <?php echo esc_attr($hook_translated['in_touch_text']); ?>                                   
                                    </div>
                                    <div class="pirenko_social minimal">
                                        <?php hook_member_nets($post->ID); ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="clearfix"></div>
                        <?php
                            if(next_post_link_plus(array('in_same_cat' => true,'return' => 'id')) || previous_post_link_plus(array('in_same_cat' => true,'return' => 'id'))) {
                                ?>
                                <div id="hook_member_footer" class="hook_navigation_singles prk_heavier_600 header_font small_headings_color hook_anchor prk_bordered_top"> 
                                    <div class="navigation-previous-blog prk_lf">
                                        <?php next_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<i class="prk_lf hook_fa-chevron-left"></i><div class="prk_lf">%title</div>'
                                            ) );
                                        ?>
                                    </div>
                                    <div class="navigation-next-blog prk_rf">
                                        <?php previous_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => true,
                                            'loop' => true,
                                            'format' => '%link',
                                            'link' => '<div class="prk_lf bf_icon_blog">%title</div><i class="prk_lf hook_fa-chevron-right"></i>'
                                            ) );
                                        ?>
                                    </div>
                                    <div class="clearfix"></div> 
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
        </div>
        <?php
    }
    endwhile; ?>
<?php get_footer(); ?>