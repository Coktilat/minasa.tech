<?php 
  get_header();
  $hook_translated=hook_translations();
  if ($prk_hook_options['error_image']['url']!="") {
      $hook_featured_style=' class="hook_featured_404"';
  }
  else {
      $hook_featured_style=' class="hook_forced_menu"';
  }
?>
<div id="hook_ajax_inner"<?php echo hook_output().$hook_featured_style; ?>>
    <div id="hook_content" class="row hook_error404">
        <div id="hook_404_title" class="hook_center_align header_font">
            <h1 class="zero_color">
            <?php esc_html_e('404','hook'); ?>
            </h1>
            <h2 class="not_zero_color big">
                <?php echo esc_attr($hook_translated['404_title_text']); ?>
            </h2>
        </div>
        <div class="columns row small-12 prk_inner_block small-centered hook_center_align">
        <div class="simple_line columns small-centered"></div>
        <p>
        <?php 
            echo esc_attr($hook_translated['404_body_text']);
        ?>
        </p>
        <?php
          if($prk_hook_options['404_search']=="search_field" || $prk_hook_options['404_search']=="back_button") {
            ?>
            <div class="small-4 small-centered columns">
              <?php 
                if($prk_hook_options['404_search']=="search_field") {
                  echo '<div class="clearfix bt_4x"></div>';
                  get_search_form(); 
                }
                else {
                  $url = home_url( '/' );
                  echo '<div class="clearfix bt_2x"></div>';
                  echo '<div class="colored_theme_button"><a href="'.esc_url($url).'">'.esc_attr($hook_translated['404_button_text']).'</a></div>';
                }
              ?>
            </div>
            <?php
          }
        ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>