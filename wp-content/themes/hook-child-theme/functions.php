<?php
    //PLACE YOUR CUSTOM FUNCTIONS HERE

	/*
	//UNCOMMENT THIS CODE TO OVERRIDE THE THEME main-min.js FILE
	add_action( 'wp_enqueue_scripts', 'prk_overwrite_scripts', 101 );
	function prk_overwrite_scripts() {
		if (function_exists('wp_get_theme')) {
		    $prk_theme = wp_get_theme();
		} 
		else {
		    $prk_theme->Version="1";
		}
	    wp_deregister_script('hook_main');
	    wp_enqueue_script('hook_main', get_stylesheet_directory_uri() . '/js/main-min.js', array('jquery'), $prk_theme->Version, true );
	    $prk_hook_options=hook_options();
	    $prk_hook_options['active_visual_composer']=HOOK_VC_ON;	    
	    wp_localize_script('hook_main', 'theme_options', $prk_hook_options);
	}
	*/
	/*
	UNCOMMENT THIS CODE TO LOAD TRANSLATIONS FROM THE CHILD THEME
	// Load translation files from your child theme instead of the parent theme
	function hook_theme_locale() {
	    load_child_theme_textdomain( 'hook', get_stylesheet_directory() . '/languages' );
	}
	add_action( 'after_setup_theme', 'hook_theme_locale' );
	*/
?>