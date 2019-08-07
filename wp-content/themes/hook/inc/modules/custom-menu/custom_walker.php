<?php

if (!class_exists('rc_scm_walker')) {
    class rc_scm_walker extends Walker_Nav_Menu {
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            global $wp_query;
            $prk_hook_options=hook_options();
            if ($prk_hook_options['subheadings_font']=="") {
                $prk_hook_options['subheadings_font']='header_font';
            }
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $class_names = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            if (!empty( $item->icon )) {
                $class_names.=' hook_iconized';
            }
            if (!empty( $item->action )) {
                $class_names.=' hook_actionized';
            }
            if (!empty( $item->trigger )) {
                $class_names.=' hook_folio_trigger';
                global $hook_feat_flaga;
                $hook_feat_flaga="yes";
            }

            $output .= $indent.'<li class="'.esc_attr($class_names).'">';
            $prk_target = ! empty( $item->target )     ? esc_attr( $item->target) : '_self';
            $attributes="";
            $attributes .= ! empty( $item->target )     ? ' target="'.esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'   .esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'  .esc_attr( $item->url        ) .'"' : ' href="#"';

            $prepend = '';
            $append = '';
            $description  = ! empty( $item->description ) ? '<div>'.esc_attr( $item->description ).'</div>' : '';

            if($depth != 0) {
                $description = $append = $prepend = "";
            }

            $item_output=$args->before;
            $item_output.='<a'. $attributes .'><div class="hook_menu_label">';
            if (!empty( $item->attr_title ) && $prk_hook_options['active_subheadings']=="1") {
                $item_output.='<div class="hook_menu_sub '.$prk_hook_options['subheadings_font'].'">'.esc_attr($item->attr_title).'</div>';
            }
            if($depth != 0) {
                $item_output.=''.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append.'';
            }
            else {
                $item_output.='<div class="hook_menu_main">';
                $item_output.=$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
                if (!empty($item->icon)) {
                    $item_output.='<i class="'.esc_attr($item->icon).'"></i>';
                }
                $item_output.='</div>';
            }
            $item_output.='</div></a>';
            $item_output.=$args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}