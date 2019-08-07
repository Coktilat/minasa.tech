<?php
function get_adjacent_post_plus($r, $previous = true ) {
	global $post, $wpdb;

	extract( $r, EXTR_SKIP );

	if ( empty( $post ) )
		return null;

	if ( in_array($order_by, array('post_date', 'post_title', 'post_excerpt', 'post_name', 'post_modified')) ) {
		$order_format = '%s';
	} elseif ( in_array($order_by, array('ID', 'post_author', 'post_parent', 'menu_order', 'comment_count')) ) {
		$order_format = '%d';
	} elseif ( $order_by == 'custom' && !empty($meta_key) ) {
		$order_format = '%s';
	} elseif ( $order_by == 'numeric' && !empty($meta_key) ) {
		$order_format = '%d';
	} else {
		$order_by = 'post_date';
		$order_format = '%s';
	}
	
	if ( in_array($order_2nd, array('post_date', 'post_title', 'post_modified')) ) {
		$order_format2 = '%s';
	} elseif ( in_array($order_2nd, array('ID')) ) {
		$order_format2 = '%d';
	} else {
		$order_2nd = 'post_date';
		$order_format2 = '%s';
	}
	
	$num_results = intval($num_results) < 2 ? 1 : intval($num_results);

	if ( $order_by == 'custom' || $order_by == 'numeric' ) {
		$current_post = get_post_meta($post->ID, $meta_key, TRUE);
		$order_by = ($order_by === 'numeric') ? 'm.meta_value+0' : 'm.meta_value';
		$meta_join = $wpdb->prepare(" INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id AND m.meta_key = %s", $meta_key );
	} elseif ( $in_same_meta ) {
		$current_post = $post->$order_by;
		$order_by = 'p.'.$order_by;
		$meta_join = $wpdb->prepare(" INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id AND m.meta_key = %s", $in_same_meta );
	} else {
		$current_post = $post->$order_by;
		$order_by = 'p.'.$order_by;
		$meta_join = '';
	}

	$current_post2 = $post->$order_2nd;
	$order_2nd = 'p.'.$order_2nd;
	
	if ( empty($post_type) )
		$post_type = "'$post->post_type'";

	do {
		$join = $meta_join;
		$excluded_categories = $ex_cats;
		$included_categories = $in_cats;
		$excluded_posts = $ex_posts;
		$included_posts = $in_posts;
		$in_same_term_sql = $in_same_author_sql = $in_same_meta_sql = $ex_cats_sql = $in_cats_sql = $ex_posts_sql = $in_posts_sql = '';

		$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );

		if ( ($in_same_cat || $in_same_tax || $in_same_format || !empty($excluded_categories) || !empty($included_categories)) && !empty($taxonomies) ) {
			$cat_array = $tax_array = $format_array = array();

			if ( $in_same_cat ) {
				$cat_array = wp_get_object_terms($post->ID, $taxonomies, array('fields' => 'ids'));
			}
			if ( $in_same_tax && !$in_same_cat ) {
				if ( $in_same_tax === true ) {
					if ( $taxonomies != array('category') )
						$taxonomies = array_diff($taxonomies, array('category'));
				} else
					$taxonomies = (array) $in_same_tax;
				$tax_array = wp_get_object_terms($post->ID, $taxonomies, array('fields' => 'ids'));
			}
			if ( $in_same_format ) {
				$taxonomies[] = 'post_format';
				$format_array = wp_get_object_terms($post->ID, 'post_format', array('fields' => 'ids'));
			}

			$join .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy IN (\"".implode('", "', $taxonomies)."\")";

			$term_array = array_unique( array_merge( $cat_array, $tax_array, $format_array ) );
			if ( !empty($term_array) )
				$in_same_term_sql = "AND tt.term_id IN (".implode(',', $term_array).")";

			if ( !empty($excluded_categories) ) {
				$delimiter = ( strpos($excluded_categories, ',') !== false ) ? ',' : 'and';
				$excluded_categories = array_map( 'intval', explode($delimiter, $excluded_categories) );
				if ( $ex_cats_method === 'strong' ) {
					$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );
					if ( function_exists('get_post_format') )
						$taxonomies[] = 'post_format';
					$ex_cats_posts = get_objects_in_term( $excluded_categories, $taxonomies );
					if ( !empty($ex_cats_posts) )
						$ex_cats_sql = "AND p.ID NOT IN (".implode($ex_cats_posts, ',').")";
				} else {
					if ( !empty($term_array) && !in_array($ex_cats_method, array('diff', 'differential')) )
						$excluded_categories = array_diff($excluded_categories, $term_array);
					if ( !empty($excluded_categories) )
						$ex_cats_sql = "AND tt.term_id NOT IN (".implode($excluded_categories, ',').')';
				}
			}

			if ( !empty($included_categories) ) {
				$in_same_term_sql = '';
				$delimiter = ( strpos($included_categories, ',') !== false ) ? ',' : 'and';
				$included_categories = array_map( 'intval', explode($delimiter, $included_categories) );
				$in_cats_sql = "AND tt.term_id IN (".implode(',', $included_categories).")";
			}
		}

		if ( $in_same_author )
			$in_same_author_sql = $wpdb->prepare("AND p.post_author = %d", $post->post_author );

		if ( $in_same_meta && $r['order_by'] != 'custom' && $r['order_by'] != 'numeric' )
			$in_same_meta_sql = $wpdb->prepare("AND m.meta_value = %s", get_post_meta($post->ID, $in_same_meta, TRUE) );

		if ( !empty($excluded_posts) ) {
			$excluded_posts = array_map( 'intval', explode(',', $excluded_posts) );
			$ex_posts_sql = " AND p.ID NOT IN (".implode(',', $excluded_posts).")";
		}
		
		if ( !empty($included_posts) ) {
			$included_posts = array_map( 'intval', explode(',', $included_posts) );
			$in_posts_sql = " AND p.ID IN (".implode(',', $included_posts).")";
		}

		$adjacent = $previous ? 'previous' : 'next';
		$order = $previous ? 'DESC' : 'ASC';
		$op = $previous ? '<' : '>';

		if ( $end_post ) {
			$order = $previous ? 'ASC' : 'DESC';
			$num_results = 1;
			$loop = false;
			if ( $end_post === 'fixed' )
				$op = $previous ? '<=' : '>=';
		}

		if ( $loop && isset($result) ) {
			$op = $previous ? '>=' : '<=';
			$loop = false;
		}
		
		$join  = apply_filters( "get_{$adjacent}_post_plus_join", $join, $r );

		$where = apply_filters( "get_{$adjacent}_post_plus_where", $wpdb->prepare("WHERE ( $order_by $op $order_format OR $order_2nd $op $order_format2 AND $order_by = $order_format ) AND p.post_type IN ($post_type) AND p.post_status = 'publish' $in_same_term_sql $in_same_author_sql $in_same_meta_sql $ex_cats_sql $in_cats_sql $ex_posts_sql $in_posts_sql", $current_post, $current_post2, $current_post), $r );

		$sort  = apply_filters( "get_{$adjacent}_post_plus_sort", "ORDER BY $order_by $order, $order_2nd $order LIMIT $num_results", $r );

		$query = "SELECT DISTINCT p.* FROM $wpdb->posts AS p $join $where $sort";
		$query_key = 'adjacent_post_'.md5($query);
		$result = wp_cache_get($query_key);
		if ( false !== $result )
			return $result;

		$result = $wpdb->get_results("SELECT DISTINCT p.* FROM $wpdb->posts AS p $join $where $sort");
		if ( null === $result )
			$result = '';

	} while ( !$result && $loop );

	wp_cache_set($query_key, $result);
	return $result;
}

function previous_post_link_plus($args = '') {
	return adjacent_post_link_plus($args, '&laquo; %link', true);
}

function next_post_link_plus($args = '') {
	return adjacent_post_link_plus($args, '%link &raquo;', false);
}

function adjacent_post_link_plus($args = '', $format = '%link &raquo;', $previous = true) {
	$defaults = array(
		'order_by' => 'post_date', 'order_2nd' => 'post_date', 'meta_key' => '', 'post_type' => '',
		'loop' => false, 'end_post' => false, 'thumb' => false, 'max_length' => 0,
		'format' => '', 'link' => '%title', 'date_format' => '', 'tooltip' => '%title',
		'in_same_cat' => false, 'in_same_tax' => false, 'in_same_format' => false,
		'in_same_author' => false, 'in_same_meta' => false,
		'ex_cats' => '', 'ex_cats_method' => 'weak', 'in_cats' => '', 'ex_posts' => '', 'in_posts' => '',
		'before' => '', 'after' => '', 'num_results' => 1, 'return' => false, 'echo' => true
	);

	if ( function_exists('CPTOrderPosts') )
		$defaults['order_by'] = 'menu_order';
	
	$r = wp_parse_args( $args, $defaults );
	if ( empty($r['format']) )
		$r['format'] = $format;
	if ( empty($r['date_format']) )
		$r['date_format'] = get_option('date_format');
	if ( !function_exists('get_post_format') )
		$r['in_same_format'] = false;

	if ( $previous && is_attachment() ) {
		$posts = array();
		$posts[] = & get_post($GLOBALS['post']->post_parent);
	} else
		$posts = get_adjacent_post_plus($r, $previous);

	if ( !$posts )
		return false;

	if ( ($previous && $r['order_by'] != 'post_date') || (!$previous && $r['order_by'] == 'post_date') )
		$posts = array_reverse( $posts, true );
		
	if ( $r['return'] ) {
		if ( $r['num_results'] == 1 ) {
			reset($posts);
			$post = current($posts);
			if ( $r['return'] === 'id')
				return $post->ID;
			if ( $r['return'] === 'href')
				return get_permalink($post);
			if ( $r['return'] === 'object')
				return $post;
			if ( $r['return'] === 'title')
				return $post->post_title;
			if ( $r['return'] === 'date')
				return mysql2date($r['date_format'], $post->post_date);
		} elseif ( $r['return'] === 'object')
			return $posts;
	}

	$output = $r['before'];

	foreach ( $posts as $post ) {
		$title = $post->post_title;
		if ( empty($post->post_title) )
			$title = $previous ? ('Previous Post') : ('Next Post');

		$title = apply_filters('the_title', $title, $post->ID);
		$date = mysql2date($r['date_format'], $post->post_date);
		$author = get_the_author_meta('display_name', $post->post_author);
	
		if ( $r['tooltip'] ) {
			$tooltip = str_replace('%title', $title, $r['tooltip']);
			$tooltip = str_replace('%date', $date, $tooltip);
			$tooltip = str_replace('%author', $author, $tooltip);
			$tooltip = ' data-pir_title="'.esc_attr($tooltip).'"';
		} else
			$tooltip = '';

		$max_length = intval($r['max_length']) < 1 ? 9999 : intval($r['max_length']);
		if ( strlen($title) > $max_length )
			$title = substr( $title, 0, strrpos(substr($title, 0, $max_length), ' ') ).'...';
	
		$rel = $previous ? 'prev' : 'next';

		$anchor = '<a href="'.get_permalink($post).'" rel="'.$rel.'"'.$tooltip.'>';
		$link = str_replace('%title', $title, $r['link']);
		$link = str_replace('%date', $date, $link);
		$link = $anchor.$link.'</a>';
	
		$format = str_replace('%link', $link, $r['format']);
		$format = str_replace('%title', $title, $format);
		$format = str_replace('%date', $date, $format);
		$format = str_replace('%author', $author, $format);
		if ( ($r['order_by'] == 'custom' || $r['order_by'] == 'numeric') && !empty($r['meta_key']) ) {
			$meta = get_post_meta($post->ID, $r['meta_key'], true);
			$format = str_replace('%meta', $meta, $format);
		} elseif ( $r['in_same_meta'] ) {
			$meta = get_post_meta($post->ID, $r['in_same_meta'], true);
			$format = str_replace('%meta', $meta, $format);
		}

		if ( (strpos($format, '%category') !== false) && version_compare(PHP_VERSION, '5.0.0', '>=') ) {
			$term_list = '';
			$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );
			if ( $r['in_same_format'] && get_post_format($post->ID) )
				$taxonomies[] = 'post_format';
			foreach ( $taxonomies as &$taxonomy ) {
				if ( $next_term = get_the_term_list($post->ID, $taxonomy, '', ', ', '') ) {
					$term_list .= $next_term;
					if ( current($taxonomies) ) $term_list .= ', ';
				}
			}
			$format = str_replace('%category', $term_list, $format);
		}

		if ( $r['thumb'] && has_post_thumbnail($post->ID) ) {
			if ( $r['thumb'] === true )
				$r['thumb'] = 'post-thumbnail';
			$thumbnail = '<a class="post-thumbnail" href="'.get_permalink($post).'" rel="'.$rel.'"'.$tooltip.'>'.get_the_post_thumbnail( $post->ID, $r['thumb'] ).'</a>';
			$format = $thumbnail.'<span class="post-link">'.$format.'</span>';
		}
		
		if ( intval($r['num_results']) > 1 )
			$format = '<li>'.$format.'</li>';
		
		$output .= $format;
	}

	$output .= $r['after'];

	if ( !$r['echo'] || $r['return'] === 'output' )
		return $output;

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link_plus", $output, $r );

	return true;
}
?>