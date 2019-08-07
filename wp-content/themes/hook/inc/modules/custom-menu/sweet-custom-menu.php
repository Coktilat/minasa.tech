<?php

	class rc_sweet_custom_menu {

	function __construct() {
		
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_nav_fields' ) );

		add_action( 'wp_update_nav_menu_item', array( $this, 'rc_scm_update_custom_nav_fields'), 10, 3 );
		
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'rc_scm_edit_walker'), 10, 2 );

	}
	
	function rc_scm_add_custom_nav_fields( $menu_item ) {
	
	    $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
	    $menu_item->trigger = get_post_meta( $menu_item->ID, '_menu_item_trigger', true );
	    $menu_item->action = get_post_meta( $menu_item->ID, '_menu_item_action', true );
	    return $menu_item;
	    
	}
	
	function rc_scm_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	    if (isset ($_REQUEST['menu-item-icon'])) {
		    if ( is_array( $_REQUEST['menu-item-icon']) ) {
		        $icon_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
		        update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
		        if (isset( $_REQUEST['menu-item-trigger'])) {
		        	if (array_key_exists($menu_item_db_id,$_REQUEST['menu-item-trigger'])) {
		        		$just_one=false;
		        		$trigger_value = $_REQUEST['menu-item-trigger'][$menu_item_db_id];
		        		update_post_meta( $menu_item_db_id, '_menu_item_trigger', $trigger_value );
		        	}
		        	else {
		        		update_post_meta( $menu_item_db_id, '_menu_item_trigger', '' );
		        	}
		        }
		        else {
		        	update_post_meta( $menu_item_db_id, '_menu_item_trigger', '' );
		        }
		        if (isset( $_REQUEST['menu-item-action'])) {
		        	if (array_key_exists($menu_item_db_id,$_REQUEST['menu-item-action'])) {
		        		$action_value = $_REQUEST['menu-item-action'][$menu_item_db_id];
		        		update_post_meta( $menu_item_db_id, '_menu_item_action', $action_value );
		        	}
		        	else {
		        		update_post_meta( $menu_item_db_id, '_menu_item_action', '' );
		        	}
		        }
		        else {
		        	update_post_meta( $menu_item_db_id, '_menu_item_action', '' );
		        }
		    }
	    }
	}
	
	function rc_scm_edit_walker($walker,$menu_id) {
	
	    return 'Walker_Nav_Menu_Edit_Custom';
	    
	}

}

$GLOBALS['sweet_custom_menu'] = new rc_sweet_custom_menu();


include_once get_template_directory().'/inc/modules/custom-menu/edit_custom_walker.php';
include_once get_template_directory().'/inc/modules/custom-menu/custom_walker.php';


