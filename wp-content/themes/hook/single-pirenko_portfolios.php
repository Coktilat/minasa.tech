<?php 
    get_header();
    while (have_posts()) : the_post(); 
        if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
            $hook_featured_color=get_field('featured_color');
            $hook_featured_class=' featured_color';
        }
        else {
            $hook_featured_color="default";
            $hook_featured_class="";
        }
        $hook_main_layout=$prk_hook_options['portfolio_layout'];
        if (is_array($hook_main_layout) || $hook_main_layout=="")
        {
            $hook_main_layout="wideout";
        }
        if (get_field('inner_layout')!="default") {
            $hook_main_layout=get_field('inner_layout');
        }
        if ($prk_hook_options['autoplay_portfolio']=="1") {
            $hook_autoplay="true";
        }
        else {
            $hook_autoplay="false";
        }
        $hook_slider_id="single_slider";
        $hook_slider_class="per_init owl-carousel hook_shortcode_slider hook_thumbs";
        if (get_field('no_slider')=="1")
        {
            $hook_slider_id="not_slider";
            $hook_slider_class="not_slider_wrapper";
        }
        if ($hook_main_layout=="custom") {
            ?>
            <div id="hook_ajax_inner" class="<?php echo esc_attr($hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <?php echo hook_sticky_folio($post->ID,'40'); ?>
                <div id="prk_custom_folio" class="row pirenko_portfolios">
                    <?php
                        if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                            the_content();
                        }
                        else {
                            echo '<div class="prk_inner_block small-12 small-centered columns">';
                            the_content();
                            echo '<div class="clearfix bt_4x"></div>';
                            echo '<div class="clearfix"></div>';
                            echo '</div>';
                        }
                    ?>
                    <div class="clearfix"></div>
                    <div id="after_single_folio" class="prk_bordered_top">
                        <?php
                            if ($prk_hook_options['show_port_nav']=="1") {
                                hook_folio_nav($post->ID,$hook_featured_color);
                            }
                            if (comments_open()) {
                                echo '<div class="small-12 columns prk_inner_block small-centered">';
                                comments_template();
                                echo '</div>';
                            }
                            echo hook_related_portfolios($post->ID);
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php
        }
        else if ($hook_main_layout=="half") {
            if (isset($prk_hook_options['port_resp_order']) && $prk_hook_options['port_resp_order']=="1") {
                $hook_featured_class.=' inv_folio_half';
            }
            ?>
            <div id="hook_ajax_inner" class="hook_forced_menu<?php echo esc_attr($hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <?php echo hook_sticky_folio($post->ID,'40'); ?> 
                <div id="ajaxed_content">
                    <div class="row">
                        <article id="prk_half_folio" <?php post_class($hook_featured_class); ?> data-color="<?php echo esc_attr($hook_featured_color); ?>">
                            <div class="small-12 zero_side_pad columns prk_inner_block small-centered">
                                <div id="prk_half_size_single" class="row">
                                    <div class="small-8 columns prk_bordered_right prk_extra_r_pad">
                                        <div id="<?php echo esc_attr($hook_slider_id); ?>">
                                            <div class="hook_multi_spinner"></div>
                                            <div class="<?php echo esc_attr($hook_slider_class); ?>" data-autoplay="<?php echo esc_attr($hook_autoplay); ?>" data-navigation="true" data-delay="<?php echo esc_attr($prk_hook_options['delay_portfolio']); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>" data-pagination="true">
                                                <?php
                                                    $hook_ext_count=-1;
                                                    $hook_imgs_width=ceil(($prk_hook_options['custom_width']+80*2)*0.66)-32;
                                                    if ($hook_imgs_width<690)
                                                        $hook_imgs_width=690;
                                                    $hook_imgs_width="";
                                                    if (get_field('skip_featured')=="") {
                                                        if (has_post_thumbnail($post->ID) )
                                                        {
                                                            $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                            echo '<div id="hook_slide_0" class="item">';
                                                            $hook_ext_count++;
                                                            $hook_vt_image=vt_resize(get_post_thumbnail_id($post->ID), '' , $hook_imgs_width, '', false , $hook_retina_device );
                                                            $hook_thumb=vt_resize(get_post_thumbnail_id($post->ID),'' , 150, 150, true, $hook_retina_device );
                                                            echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" data-thumb="'.$hook_thumb['url'].'" />';
                                                            echo hook_img_caption(get_post_thumbnail_id($post->ID));
                                                            echo '</div>';
                                                        }
                                                    }
                                                    if (get_field('use_gallery')!="images_only") {
                                                        for ($hook_count=2;$hook_count<21;$hook_count++) {
                                                            if (get_field('image_'.$hook_count)!="")
                                                            {
                                                                $hook_ext_count++;
                                                                echo '<div id="slide_'.esc_attr($hook_ext_count).'" class="item">';
                                                                $hook_in_image=wp_get_attachment_image_src(get_field('image_'.$hook_count),'full');
                                                                $hook_vt_image=vt_resize('', $hook_in_image[0] , $hook_imgs_width, '', false , $hook_retina_device);
                                                                $hook_thumb=vt_resize('', $hook_in_image[0] , 150, 150, true, $hook_retina_device );
                                                                echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_'.$hook_count))).'" data-thumb="'.$hook_thumb['url'].'" />';
                                                                echo hook_img_caption(get_field('image_'.$hook_count));
                                                                echo "</div>";
                                                            }
                                                            if (get_field('video_'.$hook_count)!="") {
                                                                $hook_ext_count++;
                                                                echo '<div id="slide_'.esc_attr($hook_ext_count).'" class="item slide_video">';
                                                                $hook_el_class='prk-video-container';
                                                                if (strpos(get_field('video_'.$hook_count),'soundcloud.com') !== false) {
                                                                  $hook_el_class= 'soundcloud-container';
                                                                }
                                                                echo '<div class="'.esc_attr($hook_el_class).'">'.get_field('video_'.$hook_count).'</div></div>';
                                                            }
                                                        }
                                                    }
                                                    else {
                                                        $hook_regex='/(\w+)\s*=\s*"(.*?)"/';
                                                        $hook_pattern='/\[gallery(.*?)\]/';
                                                        preg_match_all($hook_regex, get_post_meta($post->ID,'image_gallery',true), $hook_matches);
                                                        $hook_stripped_gallery=array();
                                                        for ($i=0; $i < count($hook_matches[1]); $i++) {
                                                            $hook_stripped_gallery[$hook_matches[1][$i]]=$hook_matches[2][$i];
                                                        }
                                                        if (!empty($hook_stripped_gallery) && $hook_stripped_gallery['ids']!="") {
                                                            $hook_array=explode(',', $hook_stripped_gallery['ids']);
                                                            foreach($hook_array as $hook_value)
                                                            {
                                                                $hook_ext_count++;
                                                                echo '<div id="slide_'.esc_attr($hook_ext_count).'" class="item">';
                                                                $hook_in_image=wp_get_attachment_image_src($hook_value,'full');
                                                                $hook_vt_image=vt_resize( '', $hook_in_image[0] , $hook_imgs_width, '', false , $hook_retina_device );
                                                                $hook_thumb=vt_resize('', $hook_in_image[0] , 150, 150, true, $hook_retina_device );
                                                                echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,$hook_value).'" data-thumb="'.$hook_thumb['url'].'" />';
                                                                echo hook_img_caption($hook_value);
                                                                echo "</div>";
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="half-entry-right" class="columns small-4 prk_bordered_left">
                                            <h1 id="folio_ttl" class="header_font zero_color hook_folio_uppercased">
                                                <?php the_title(); ?>
                                            </h1>
                                            <div class="clearfix"></div>
                                            <div id="single_entry_content" class="prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                                <?php the_content(); ?>
                                            </div>
                                            <div class="clearfix bt_2x"></div>
                                            <div class="prk_9_em">
                                                <?php
                                                    $hook_line_counter=0;
                                                    if ($prk_hook_options['dateby_port']=="1")
                                                    {
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['date_text']).':&nbsp;&nbsp;</span>';
                                                        echo '<span class="body_colored '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                                                        echo the_date();
                                                        echo '</span></div></div>';
                                                        $hook_line_counter++;
                                                    }
                                                    if ($prk_hook_options['categoriesby_port']=="1") {
                                                        if (get_the_term_list(get_the_ID(),'pirenko_skills')!="") {
                                                            $hook_terms=wp_get_object_terms(get_the_ID(),'pirenko_skills');
                                                            $hook_count=count($hook_terms);
                                                            if ($hook_count>0) {
                                                                if ($hook_line_counter>0) {
                                                                    echo '<div class="simple_line on_folio"></div>';
                                                                }
                                                                $hook_line_counter++;
                                                                echo '<div class="hook_info_block clearfix">';
                                                                echo '<div class="prk_lf">';
                                                                echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['skills_text']).':&nbsp;&nbsp;</span>';
                                                                $hook_in_count=0;
                                                                echo '<span class="body_colored">';
                                                                foreach ( $hook_terms as $hook_term ) {
                                                                    if ($hook_in_count>0)
                                                                        echo ", ";
                                                                    echo ''.$hook_term->name.'';
                                                                    $hook_in_count++;
                                                                }
                                                                echo '</span></div></div>';
                                                            }
                                                        }
                                                    }
                                                    $hook_terms=wp_get_object_terms(get_the_ID(),'portfolio_tag');
                                                    $hook_count=count($hook_terms);
                                                    if ($hook_count>0) {
                                                        if ($hook_line_counter>0) {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        $hook_line_counter++;
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf hook_tags">';
                                                        echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['tags_text']).':&nbsp;&nbsp;</span>';
                                                        echo '<span class="body_colored">';
                                                        echo get_the_term_list(get_the_ID(),'portfolio_tag', '', ', ', '' );
                                                        echo '</span></div></div>';
                                                    }
                                                    if (get_field('client_url')!="")
                                                    {
                                                        if ($hook_line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['client_text']).':&nbsp;&nbsp;</span>';
                                                        echo esc_attr(get_field('client_url')).'</span>';
                                                        echo '</div></div>';
                                                        $hook_line_counter++;
                                                    }
                                                    if (get_field('extra_fld1')!="")
                                                    {
                                                        if ($hook_line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld1']).':&nbsp;&nbsp;</span>';
                                                        echo esc_attr(get_field('extra_fld1')).'</span>';
                                                        echo '</div></div>';
                                                        $hook_line_counter++;
                                                    }
                                                    if (get_field('extra_fld2')!="")
                                                    {
                                                        if ($hook_line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld2']).':&nbsp;&nbsp;</span>';
                                                        echo esc_attr(get_field('extra_fld2')).'</span>';
                                                        echo '</div></div>';
                                                        $hook_line_counter++;
                                                    }
                                                    if (get_field('extra_fld3')!="")
                                                    {
                                                        if ($hook_line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld3']).':&nbsp;&nbsp;</span>';
                                                        echo esc_attr(get_field('extra_fld3')).'</span>';
                                                        echo '</div></div>';
                                                        $hook_line_counter++;
                                                    }
                                                    if (get_field('ext_url')!="") {
                                                        if (substr(get_field('ext_url'),0,7)!="http://" && substr(get_field('ext_url'),0,8)!="https://")
                                                            $hook_final_url="http://".get_field('ext_url');
                                                        else
                                                            $hook_final_url=get_field('ext_url');
                                                        $hook_final_url=hook_change_links($hook_final_url);
                                                        if ($hook_line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="hook_info_block clearfix">';
                                                        echo '<div class="prk_lf">';
                                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['project_text']).':&nbsp;&nbsp;</span>';
                                                        echo '<a href="'.esc_url($hook_final_url).'" target="_blank" data-color="'.esc_attr($hook_featured_color).'" class="hook_ext hook_italic">';
                                                        if (get_field('ext_url_label')!="") 
                                                        {
                                                            echo esc_attr(get_field('ext_url_label'));
                                                        }
                                                        else 
                                                        {
                                                            echo esc_attr($hook_translated['launch_text']);
                                                        }
                                                        echo '</a></div></div>';
                                                    }
                                                    if ($hook_line_counter>0) {
                                                        echo '<div class="simple_line on_folio"></div>';
                                                    }
                                                    if ($prk_hook_options['share_portfolio']=="1" && $prk_hook_options['persistent_folio']=="0") {
                                                        hook_output_share($post->ID,'portfolio');
                                                    }
                                                ?>
                                                </div>
                                        </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="after_single_folio" class="prk_bordered_top">
                                <?php
                                    if ($prk_hook_options['show_port_nav']=="1") {
                                        hook_folio_nav($post->ID,$hook_featured_color);
                                    }
                                    if (comments_open()) {
                                        echo '<div class="small-12 columns prk_inner_block small-centered">';
                                        comments_template();
                                        echo '</div>';
                                    }
                                    echo hook_related_portfolios($post->ID);
                                ?>
                                <div class="clearfix"></div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>   
            <?php
        }
        else {
            $hook_inner_class="hook_forced_menu";
            $hook_slider_wrapper_class="prk_inner_block small-centered columns";
            $hook_slider_class="per_init owl-carousel hook_shortcode_slider";
            if ($hook_main_layout=="wideout") {
                $hook_inner_class="hook_featured_header";
                $hook_slider_wrapper_class="owl_parallaxed";
                $hook_slider_class="per_init owl-carousel hook_shortcode_slider";
            }
            if (get_field('no_slider')=="1") {
                $hook_slider_class="not_slider_wrapper";
            }
            ?>
            <div id="hook_ajax_inner" class="<?php echo esc_attr($hook_inner_class.$hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                <?php echo hook_sticky_folio($post->ID,'40'); ?>
                <div id="ajaxed_content">
                    <div class="row">
                        <article id="prk_full_folio" class="pirenko_portfolios classy-<?php echo esc_attr(get_field('info_display')).$hook_featured_class; ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                            <div id="<?php echo esc_attr($hook_slider_id); ?>" class="<?php echo esc_attr($hook_slider_wrapper_class); ?>">
                                <div class="hook_multi_spinner"></div>
                                <div class="<?php echo esc_attr($hook_slider_class); ?>" data-autoplay="<?php echo esc_attr($hook_autoplay); ?>" data-navigation="true" data-delay="<?php echo esc_attr($prk_hook_options['delay_portfolio']); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                                <?php
                                    $hook_imgs_width=$prk_hook_options['custom_width']+80*2+32;
                                    if ($hook_imgs_width<690) {
                                        $hook_imgs_width=690;
                                    }
                                    if ($hook_main_layout=="wideout") {
                                        $hook_imgs_width='';
                                    }
                                    $hook_ext_count=-1;
                                    if (get_field('skip_featured')=="") {
                                        if (has_post_thumbnail($post->ID) ) {
                                            $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                            $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , $hook_imgs_width, '', false , $hook_retina_device );
                                            if ($hook_main_layout=="wideout") {
                                                $hook_parallaxy=' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 400px;" style="background-image: url('.esc_url($hook_vt_image['url']).');"';
                                            }
                                            else {
                                                $hook_parallaxy="";
                                            }
                                            echo '<div id="hook_slide_0" class="item"'.($hook_parallaxy).'>';
                                            $hook_ext_count++;
                                            echo '<img class="hook_vsbl" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                                            echo hook_img_caption(get_post_thumbnail_id($post->ID));
                                        echo '</div>';
                                        }
                                    }
                                    if (get_field('use_gallery')!="images_only") {
                                        for ($hook_count=2;$hook_count<21;$hook_count++) {
                                            if (get_field('image_'.$hook_count)!="") {
                                                $hook_ext_count++;
                                                $hook_in_image=wp_get_attachment_image_src(get_field('image_'.$hook_count),'full');
                                                $hook_vt_image=vt_resize( '', $hook_in_image[0] , $hook_imgs_width, '', false , $hook_retina_device );
                                                if ($hook_main_layout=="wideout") {
                                                    $hook_parallaxy=' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 400px;" style="background-image: url('.esc_url($hook_vt_image['url']).');"';
                                                    $hook_img_class=' class="hook_vsbl"';
                                                }
                                                else {
                                                    $hook_img_class=$hook_parallaxy="";
                                                }
                                                echo '<div id="hook_slide_'.esc_attr($hook_ext_count).'" class="item "'.($hook_parallaxy).'>';
                                                echo '<img '.$hook_img_class.'src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_'.$hook_count))).'" />';
                                                echo hook_img_caption(get_field('image_'.$hook_count));
                                                echo "</div>";
                                            }
                                            if (get_field('video_'.$hook_count)!="") {
                                                $hook_ext_count++;
                                                echo '<div id="slide_'.esc_attr($hook_ext_count).'" class="item slide_video">';
                                                $hook_el_class='prk-video-container';
                                                if (strpos(get_field('video_'.$hook_count),'soundcloud.com') !== false) {
                                                  $hook_el_class= 'soundcloud-container';
                                                }
                                                echo '<div class="'.esc_attr($hook_el_class).'">'.get_field('video_'.$hook_count).'</div></div>';
                                            }
                                        }
                                    }
                                    else {
                                        $hook_regex='/(\w+)\s*=\s*"(.*?)"/';
                                        $hook_pattern='/\[gallery(.*?)\]/';
                                        preg_match_all($hook_regex, get_post_meta($post->ID,'image_gallery',true), $hook_matches);
                                        $hook_stripped_gallery=array();
                                        for ($i=0; $i < count($hook_matches[1]); $i++) {
                                            $hook_stripped_gallery[$hook_matches[1][$i]]=$hook_matches[2][$i];
                                        }
                                        if (!empty($hook_stripped_gallery) && $hook_stripped_gallery['ids']!="") {
                                            $hook_array=explode(',', $hook_stripped_gallery['ids']);
                                            foreach($hook_array as $hook_value) {
                                            $hook_ext_count++;
                                            echo '<div id="slide_'.esc_attr($hook_ext_count).'" class="item">';
                                            $hook_in_image=wp_get_attachment_image_src($hook_value,'full');
                                            $hook_vt_image=vt_resize( '', $hook_in_image[0] , $hook_imgs_width, '', false , $hook_retina_device );
                                            echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.hook_alt_tag(true,$hook_value).'" />';
                                            echo hook_img_caption($hook_value);
                                            echo "</div>";
                                            }
                                        }
                                    }
                                ?>
                                </div>
                            </div>
                            <div class="clearfix"></div> 
                            <div class="small-12 columns prk_inner_block small-centered classy-<?php echo esc_attr(get_field('info_display')); ?>">
                                <?php
                                $hook_line_counter=0;
                                if (get_field('info_display')=="below") {
                                ?>
                                <h1 id="folio_ttl" class="header_font zero_color hook_center_align hook_folio_uppercased">
                                <?php the_title(); ?>
                                </h1>
                                <?php
                                if (get_field('info_display')=="below") {
                                echo '<div id="single_post_teaser" class="hook_center_align">';
                                echo '<div id="single_blog_meta">';
                                if ($prk_hook_options['dateby_port']=="1") {
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<span class="small_headings_color">';
                                    echo the_date();
                                    echo '</span></div></div>';
                                    $hook_line_counter++;
                                }
                                if ($prk_hook_options['categoriesby_port']=="1") {
                                    if (get_the_term_list(get_the_ID(),'pirenko_skills')!="") {
                                        $hook_terms=$hook_terms=wp_get_object_terms(get_the_ID(),'pirenko_skills');
                                        $hook_count=count($hook_terms);
                                        if ($hook_count>0) {
                                            if ($hook_line_counter>0) {
                                                echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                            }
                                            $hook_line_counter++;
                                            echo '<div class="single_blog_meta_div">';
                                            echo '<div class="prk_lf header_font">';
                                            $hook_in_count=0;
                                            echo '<span class="small_headings_color">';
                                            foreach ( $hook_terms as $hook_term ) {
                                                if ($hook_in_count>0)
                                                    echo ", ";
                                                echo ''.$hook_term->name.'';
                                                $hook_in_count++;
                                            }
                                            echo '<span></div></div>';
                                        }
                                    }
                                }
                                $hook_terms=wp_get_object_terms(get_the_ID(),'portfolio_tag');
                                $hook_count=count($hook_terms);
                                if ($hook_count>0) {
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider small_headings_color hook_tags">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    $hook_line_counter++;
                                    echo '<div class="single_blog_meta_div hook_tags">';
                                    echo '<div class="prk_lf header_font">';
                                    $hook_in_count=0;
                                    echo '<span class="small_headings_color">';
                                    foreach ( $hook_terms as $hook_term ) {
                                        if ($hook_in_count>0) {
                                            echo ", ";
                                        }
                                        echo esc_attr($hook_term->name);
                                        $hook_in_count++;
                                    }
                                    echo '</span></div></div>';
                                }
                                if (get_field('client_url')!="") {
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<span class="small_headings_color">'.esc_attr(get_field('client_url')).'</span>';
                                    echo '</div></div>';
                                    $hook_line_counter++;
                                }
                                if (get_field('extra_fld1')!="")
                                {
                                    if ($hook_line_counter>0)
                                    {
                                        echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<span class="small_headings_color">'.esc_attr(get_field('extra_fld1')).'</span>';
                                    echo '</div></div>';
                                    $hook_line_counter++;
                                }
                                if (get_field('extra_fld2')!="")
                                {
                                    if ($hook_line_counter>0)
                                    {
                                        echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<span class="small_headings_color">'.esc_attr(get_field('extra_fld2')).'</span>';
                                    echo '</div></div>';
                                    $hook_line_counter++;
                                }
                                if (get_field('extra_fld3')!="")
                                {
                                    if ($hook_line_counter>0)
                                    {
                                        echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<span class="small_headings_color">'.esc_attr(get_field('extra_fld3')).'</span>';
                                    echo '</div></div>';
                                    $hook_line_counter++;
                                }
                                if (get_field('ext_url')!="") {
                                    if (substr(get_field('ext_url'),0,7)!="http://" && substr(get_field('ext_url'),0,8)!="https://")
                                        $hook_final_url="http://".get_field('ext_url');
                                    else
                                        $hook_final_url=get_field('ext_url');
                                    $hook_final_url=hook_change_links($hook_final_url);
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider small_headings_color">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    echo '<div class="single_blog_meta_div">';
                                    echo '<div class="prk_lf header_font">';
                                    echo '<a href="'.esc_url($hook_final_url).'" target="_blank" data-color="'.esc_attr($hook_featured_color).'" class="hook_ext hook_italic">';
                                    if (get_field('ext_url_label')!="")  {
                                        echo esc_attr(get_field('ext_url_label'));
                                    }
                                    else 
                                    {
                                        echo esc_attr($hook_translated['launch_text']);
                                    }
                                    echo '</a></div></div>';
                                }
                                echo '</div></div>';
                                }
                                }
                                ?>
                                <div id="prk_full_size_single" class="row">
                                <?php
                                if (get_field('info_display')=="right_side")
                                {
                                echo '<div class="small-9 columns prk_bordered_right prk_extra_r_pad">';
                                }
                                else
                                {
                                echo '<div class="small-12 columns">';
                                }
                                ?>
                                <div id="single_entry_content" class="prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                <?php 
                                    if (get_field('info_display')=="right_side") {
                                        ?>
                                        <h1 id="folio_ttl" class="header_font zero_color hook_center_align hook_folio_uppercased">
                                            <?php the_title(); ?>
                                        </h1>
                                        <?php 
                                    }
                                    the_content(); 
                                ?>
                                </div>
                                <div class="clearfix"></div>
                                <?php
                                if (get_field('info_display')=="below") {
                                    if ($prk_hook_options['share_portfolio']=="1" && $prk_hook_options['persistent_folio']=="0") {
                                        hook_output_share($post->ID,'portfolio');
                                    }
                                }
                                ?>
                                </div>
                                <?php
                                if (get_field('info_display')=="right_side") {
                                ?>
                                <div id="full-entry-right" class="columns small-3 prk_bordered_left">
                                <?php
                                    if (get_field('info_display')=="right_side") {
                                        ?>
                                        <h1 id="folio_ttl" class="header_font zero_color hook_center_align hook_folio_uppercased">
                                            <?php the_title(); ?>
                                        </h1>
                                        <h1 id="ttl_spacer" class="hide_now">&nbsp;</h1>
                                        <?php 
                                    }
                                ?>
                                <div class="prk_9_em">
                                    <?php
                                    if ($prk_hook_options['dateby_port']=="1")
                                    {
                                    echo '<div class="hook_info_block clearfix">';
                                    echo '<div class="prk_lf">';
                                    echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['date_text']).':&nbsp;&nbsp;</span>';
                                    echo '<span class="body_colored">';
                                    echo the_date();
                                    echo '</span></div></div>';
                                    $hook_line_counter++;
                                    }
                                    if ($prk_hook_options['categoriesby_port']=="1") {
                                        if (get_the_term_list(get_the_ID(),'pirenko_skills')!=""){
                                            $hook_terms=$hook_terms=wp_get_object_terms(get_the_ID(),'pirenko_skills');
                                            $hook_count=count($hook_terms);
                                            if ($hook_count>0) {
                                                if ($hook_line_counter>0) {
                                                    echo '<div class="simple_line on_folio"></div>';
                                                }
                                                $hook_line_counter++;
                                                echo '<div class="hook_info_block clearfix">';
                                                echo '<div class="prk_lf">';
                                                echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['skills_text']).':&nbsp;&nbsp;</span>';
                                                $hook_in_count=0;
                                                echo '<span class="body_colored">';
                                                foreach ( $hook_terms as $hook_term ) {
                                                    if ($hook_in_count>0)
                                                        echo ", ";
                                                    echo ''.$hook_term->name.'';
                                                    $hook_in_count++;
                                                }
                                                echo '<span></div></div>';
                                            }
                                        }
                                    }
                                    $hook_terms=wp_get_object_terms(get_the_ID(),'portfolio_tag');
                                    $hook_count=count($hook_terms);
                                    if ($hook_count>0) {
                                        if ($hook_line_counter>0) {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        $hook_line_counter++;
                                        echo '<div class="hook_info_block clearfix hook_tags">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['tags_text']).':&nbsp;&nbsp;</span>';
                                        echo '<span class="body_colored">';
                                        echo get_the_term_list(get_the_ID(),'portfolio_tag', '', ', ', '' );
                                        echo '</span></div></div>';
                                    }
                                    if (get_field('client_url')!="") {
                                        if ($hook_line_counter>0)
                                        {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        echo '<div class="hook_info_block clearfix">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['client_text']).':&nbsp;&nbsp;</span>';
                                        echo '<span class="body_colored">'.esc_attr(get_field('client_url')).'</span>';
                                        echo '</div></div>';
                                        $hook_line_counter++;
                                    }
                                    if (get_field('extra_fld1')!="") {
                                        if ($hook_line_counter>0)
                                        {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        echo '<div class="hook_info_block clearfix">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld1']).':&nbsp;&nbsp;</span>';
                                        echo hook_output().get_field('extra_fld1').'</span>';
                                        echo '</div></div>';
                                        $hook_line_counter++;
                                    }
                                    if (get_field('extra_fld2')!="") {
                                        if ($hook_line_counter>0)
                                        {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        echo '<div class="hook_info_block clearfix">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld2']).':&nbsp;&nbsp;</span>';
                                        echo hook_output().get_field('extra_fld2').'</span>';
                                        echo '</div></div>';
                                        $hook_line_counter++;
                                    }
                                    if (get_field('extra_fld3')!="") {
                                        if ($hook_line_counter>0)
                                        {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        echo '<div class="hook_info_block clearfix">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="zero_color prk_heavier_700">'.esc_attr($hook_translated['extra_fld3']).':&nbsp;&nbsp;</span>';
                                        echo hook_output().get_field('extra_fld3').'</span>';
                                        echo '</div></div>';
                                        $hook_line_counter++;
                                    }
                                    if (get_field('ext_url')!="") {
                                        if (substr(get_field('ext_url'),0,7)!="http://" && substr(get_field('ext_url'),0,8)!="https://")
                                            $hook_final_url="http://".get_field('ext_url');
                                        else
                                            $hook_final_url=get_field('ext_url');
                                        $hook_final_url=hook_change_links($hook_final_url);
                                        if ($hook_line_counter>0)
                                        {
                                            echo '<div class="simple_line on_folio"></div>';
                                        }
                                        echo '<div class="hook_info_block clearfix">';
                                        echo '<div class="prk_lf">';
                                        echo '<span class="prk_heavier_700 zero_color">'.esc_attr($hook_translated['project_text']).':&nbsp;&nbsp;</span>';
                                        echo '<a href="'.esc_url($hook_final_url).'" target="_blank" data-color="'.esc_attr($hook_featured_color).'" class="hook_ext hook_italic">';
                                        if (get_field('ext_url_label')!="") 
                                        {
                                            echo get_field('ext_url_label');
                                        }
                                        else 
                                        {
                                            echo esc_attr($hook_translated['launch_text']);
                                        }
                                        echo '</a></div></div>';
                                    }
                                    if ($hook_line_counter>0) {
                                    echo '<div class="simple_line on_folio"></div>';
                                    }
                                    if ($prk_hook_options['share_portfolio']=="1" && $prk_hook_options['persistent_folio']=="0") {
                                        hook_output_share($post->ID,'portfolio');
                                    }
                                    ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="after_single_folio" class="prk_bordered_top">
                        <?php
                            if ($prk_hook_options['show_port_nav']=="1") {
                                hook_folio_nav($post->ID,$hook_featured_color);
                            }
                            if (comments_open()) {
                                echo '<div class="small-12 columns prk_inner_block small-centered">';
                                comments_template();
                                echo '</div>';
                            }
                            echo hook_related_portfolios($post->ID);
                        ?>
                        <div class="clearfix"></div>
                    </article>
                </div>
            </div>
            </div>
            <?php
        }
    endwhile;
?>
<?php get_footer(); ?>
