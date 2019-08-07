<?php class MhWidgetAuthors extends WP_Widget {

	function __construct() {
		parent::__construct(
			'mh_authors', esc_html__( 'MH Top Authors', 'mharty' ),
			array( 'description' => esc_html__( 'Displays top authors.', 'mharty' ),)

		);
	}

	function widget( $args, $instance ) {
		
		if ( !$authors_number = (int) $instance['authors_number'] )
			$authors_number = 5;
		
		$query_args = array(
			'who'     => 'authors',
			'order'   => 'DESC',
			'orderby' => 'post_count',
			'number'       => $authors_number,
		);

		$authors = get_users( $query_args );

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		
		?>
			<ul class="widget_author_list">
				<?php
				foreach ( $authors as $author ) {
					$count = '&#40;' . count_user_posts( $author->ID ) . '&#41;';
					$url = get_author_posts_url( $author->ID );
				?>
				<li>
					<a href="<?php echo esc_url( $url ); ?>" class="widget_author_avatar mh_adjust_corners" rel="author">
						<?php echo get_avatar( $author->ID, 100, 'mystery', esc_attr( $author->display_name ) ); ?>
					</a>
					<a href="<?php echo esc_url( $url ); ?>" class="widget_author_title">
						<div class="widget_author_title_name"><?php echo esc_html( $author->display_name ); ?> <span><?php echo esc_html( $count ); ?></span></div>
						
					</a>
				</li>
				<?php } ?>
			</ul>
		<?php
		echo $args['after_widget'];
	}

	function form( $instance ) {
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Top Authors', 'mharty' );
		if ( !isset( $instance['authors_number'] ) || !$authors_number = (int) $instance['authors_number'] )
			$authors_number = 5;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'mharty' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			<label for="<?php echo $this->get_field_id( 'authors_number' ); ?>"><?php esc_html_e('Number of authors:', 'mharty'); ?></label>
		<input id="<?php echo $this->get_field_id( 'authors_number' ); ?>" name="<?php echo $this->get_field_name( 'authors_number' ); ?>" type="text" value="<?php echo $authors_number; ?>" class="widefat" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance["authors_number"] = (int) $new_instance["authors_number"];

		return $instance;
	}

}// end MhWidgetAuthors class

function MhWidgetAuthorsInit() {
	register_widget('MhWidgetAuthors');
}

add_action('widgets_init', 'MhWidgetAuthorsInit');