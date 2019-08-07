<?php get_header(); ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<article id="post-0" <?php post_class( 'mhc_post not_found' ); ?>>
					<div class="entry">
						<!--If no results are found-->
						<h1><?php esc_html_e('No Results Found','mharty'); ?></h1>
						<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','mharty'); ?></p>
						<!--End if no results are found-->
					</div>
				</article> <!-- .mhc_post -->
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>