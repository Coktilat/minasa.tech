<?php
  	wp_reset_postdata();
  	$hook_right_sidebar_id='sidebar-primary';
	if (get_field('right_sidebar_id')!="")
	    $hook_right_sidebar_id=get_field('right_sidebar_id');
	if (function_exists('dynamic_sidebar') && dynamic_sidebar(apply_filters('ups_sidebar',$hook_right_sidebar_id))) :
		else : 

	endif; 
?>
