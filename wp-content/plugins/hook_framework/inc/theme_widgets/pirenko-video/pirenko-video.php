<?php
/*
    Plugin Name: Pirenko Video Widgtet
    Plugin URI: https://www.pirenko.com
    Description: A widget to diplay one video
    Version: 1.0
    Author: Pirenko
    Author URI: https://www.pirenko.com
*/

//LOAD WIDGET
add_action( 'widgets_init', 'load_Pirenko_Video_Widget' );

//REGISTER WIDGET
function load_Pirenko_Video_Widget() {
    register_widget( 'Pirenko_Video_Widget' );
}

//CREATE CLASS TO CONTROL EVERYTHING
class pirenko_video_widget extends WP_Widget {
    //SET UP WIDGET
    function __construct() {
        $widget_ops = array( 'classname' => 'pirenko-video-widget', 'description' => ('A widget to diplay one video.') );
        $control_ops = array( 'width' => 255, 'height' => 460, 'id_base' => 'pirenko-video-widget' );
        parent::__construct( 'pirenko-video-widget', esc_html__('Hook: Video Widget ', 'hook'), $widget_ops, $control_ops );
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['video_html'] = strip_tags($new_instance['video_html']);

        if (function_exists('icl_translate')) {
            icl_translate('hook', 'widget_title', $instance['title']);
            icl_translate('hook', 'video_widget_html_text', $instance['video_html']);
        }

        return $instance;
    }
    //SET UP WIDGET FORM ON THE CONTROL PANEL
    function form( $instance )
    {
        if (isset($instance['title']))
            $title=$instance['title'];
        else
            $title="";
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if (isset($instance['video_html']))
            $video_html=$instance['video_html'];
        else
            $video_html="";
        ?>
        <p>
            <label for="<?php echo hook_output().$this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat" id="<?php echo hook_output().$this->get_field_id( 'title' ); ?>" name="<?php echo hook_output().$this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo hook_output().$this->get_field_id( 'video_html' ); ?>">Video embed code:</label>
            <textarea class="widefat" rows="12" id="<?php echo hook_output().$this->get_field_id( 'video_html' ); ?>" name="<?php echo hook_output().$this->get_field_name( 'video_html' ); ?>" type="text"><?php echo esc_attr($video_html); ?></textarea>
        </p>
        <?php
    }
    //RENDER WIDGET IN THE SIDEBAR
    function widget( $args, $instance )
    {
        echo hook_output().$args['before_widget'];
        echo ("<div class='pirenko_video_widget'>");
        //DISPLAY TITLE IF NECESSARY
        if (!empty( $instance['title'])) {
            $title = apply_filters('widget_title',empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
            echo hook_output().$args['before_title'].$title.$args['after_title'];
        }
        if(function_exists('icl_translate')) {
            if (!isset($instance['video_html'])) {
                $instance['video_html'] = '';
            }
            else {
                $instance['video_html'] = icl_translate( 'hook', 'video_widget_html_text', $instance['video_html'] );
            }

        } else {
            if (!isset($instance['video_html'])) {
                $instance['video_html'] = '';
            }
        }
        echo "<div class='clearfix'></div><div class='video-container'>".$instance['video_html']."</div>";
        //CLOSE SUBDIV FOR WIDGET
        echo ("</div>");
        echo hook_output().$args['after_widget'];
    }
};
?>