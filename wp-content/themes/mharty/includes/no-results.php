<div class="entry">
<!--If no results are found-->
	<?php if ( is_search() ) : ?>
	<h2><?php esc_html_e('No Results Found','mharty'); ?></h2>
	<p><?php esc_html_e( 'Try different keywords.', 'mharty' ); ?></p>
	<div class="mh-no-content-search">
		<?php the_widget( 'WP_Widget_Search' ); ?> 
	</div>
	<?php else : ?>
	<h1><?php esc_html_e('No Content in this page','mharty'); ?></h1>
	<p><?php esc_html_e( 'It looks like nothing was found. We suggest you use the navigation above to find what you are looking for.', 'mharty' ); ?></p>

	<?php endif; ?>
</div>
<!--End if no results are found-->
