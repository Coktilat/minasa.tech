<?php
	$hook_translated=hook_translations();
?>
<form method="get" class="form-search hook_searchform" action="<?php echo esc_url(home_url('/')); ?>" data-url="<?php echo esc_url(hook_clean_url()); ?>">
	<div class="hook_swrapper">
  		<input type="text" value="" name="s" id="hook_search" class="search-query pirenko_highlighted prk_heavier_500" placeholder="<?php echo esc_attr($hook_translated['search_tip_text']); ?>" />
      <div class="colored_theme_button">
        <input type="submit" id="searchsubmit" value="<?php echo esc_attr( 'Search', 'submit button' ); ?>" />
      </div>
  		<div class="hook_lback per_init">
  			<i class="hook_fa-search"></i>
  		</div>
    </div>
</form>