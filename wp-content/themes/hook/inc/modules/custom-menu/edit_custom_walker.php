<?php

class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

	function start_lvl(&$output, $depth = 0, $args = array()) {
	}
	

	function end_lvl(&$output, $depth = 0, $args = array()) {
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	    global $_wp_nav_menu_max_depth;
	   
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );
	
	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }
	
	    $classes = array(
	        'menu-item menu-item-depth-'.$depth,
	        'menu-item-'.esc_attr( $item->object ),
	        'menu-item-edit-'.( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );
	
	    $title = $item->title;
	
	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        $title = sprintf( esc_html__( '%s (Invalid)','hook' ), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        $title = sprintf( esc_html__('%s (Pending)','hook'), $item->title );
	    }
	
	    $title = empty( $item->label ) ? $title : $item->label;
	
	    ?>
	    <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <dl class="menu-item-bar">
	            <dt class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_html_e('Move up','hook'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_html_e('Move down','hook'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_html_e('Edit Menu Item','hook'); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-'.$item_id ) ) );
	                    ?>"><span class="screen-reader-text"><?php _e( 'Edit Menu Item','hook' ); ?></span></a>
	                </span>
	            </dt>
	        </dl>
	
	        <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
	                        <?php esc_html_e( 'URL','hook' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Navigation Label','hook' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Title Attribute','hook' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
	            <p class="field-link-target description">
	                <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php esc_html_e( 'Open link in a new window/tab','hook' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'CSS Classes (optional)','hook' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Link Relationship (XFN)','hook' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Description','hook' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); ?></textarea>
	                    <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.','hook'); ?></span>
	                </label>
	            </p>        
	            <?php
	            /* EXTRA FIELDS */
	            ?>
	            <div id="hook_menu_head">
	            	<div>
	            		<?php echo esc_html__('HOOK THEME','hook'); ?>
	            	</div>
	            </div>
	            <p class="field-custom description description-wide">
	                <label for="edit-menu-item-trigger-<?php echo esc_attr($item_id); ?>">
	                	<input type="checkbox" id="edit-menu-item-trigger-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-trigger[<?php echo esc_attr($item_id); ?>]"<?php if ($item->trigger=='on'){echo ' checked="checked"';} ?> />
	                    <span><?php esc_html_e( "'Show all work' trigger",'hook' ); ?></span>
	                </label>
	            </p>
	            <p class="field-custom description description-wide">
	                <label for="edit-menu-item-action-<?php echo esc_attr($item_id); ?>">
	                	<input type="checkbox" id="edit-menu-item-action-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-action[<?php echo esc_attr($item_id); ?>]"<?php if ($item->action=='on'){echo ' checked="checked"';} ?> />
	                    <span><?php esc_html_e( 'Style as action button','hook' ); ?></span>
	                </label>
	            </p> 
	            <p class="field-custom description description-wide hide_now">
	                <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Icon','hook' ); ?><br />
	                    <input type="text" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->icon ); ?>" /><br />
	                    <?php echo "Ex: hook_fa-bell - Icons list <a href='https://www.pirenko.com/assets/hook/icons.html' target='_blank'>here</a>."; ?></a>
	                </label>
	            </p>
	            <?php
	            /* END EXTRA FIELDS */
	            ?>
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( esc_html__('Original: %s','hook'), '<a href="'.esc_attr( $item->url ).'">'.esc_html( $original_title ).'</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
	                echo wp_nonce_url(
	                    add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                    ),
	                    'delete-menu_item_'.$item_id
	                ); ?>"><?php esc_html_e('Remove','hook'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel','hook'); ?></a>
	            </div>
	
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php
	    
	    $output .= ob_get_clean();

	    }
}