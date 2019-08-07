<?php
	global $post;
	$prk_hook_options=hook_options();
	$hook_translated=hook_translations();
	if (post_password_required()) { 
		?>
		<div id="comments">
			<div class="alert alert-block fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<p><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'hook'); ?></p>
			</div>
		</div>
		<?php
  		return;
	} 
	if (have_comments()) {
		$hook_num_comments=get_comments_number();
		?>
		<div id="comments" class="prk_bordered_top">
			<div class="prk_inner_block columns small-centered">
				<div class="vrv_outer_row">
				  	<div id="comments_inner">
				    	<div class="hook_centered_text header_font">
				    		<h4 class="zero_color prk_heavier_600 big">
				                <?php
				                	if ($hook_num_comments==1) {
				                		echo hook_output().$hook_translated['comments_one_response'];
				                	}
				                	else {
				                		echo hook_output().$hook_num_comments.' '.$hook_translated['comments_oneplus_response'];
				                	}
				                ?>
				        	</h4>
				        	<div class="small_headings_color prk_9_em">
				                <?php echo esc_attr($hook_translated['on_text'])." ".get_the_title()."."; ?>
				        	</div>
				        </div>
					    <ol class="commentlist unstyled">
					      <?php wp_list_comments(array('callback' => 'hook_comment')); ?>
					    </ol>
					    <?php 
					    	if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
								<nav id="comments-nav" class="pager">
									<div class="previous"><?php previous_comments_link(esc_html__('&larr; Older comments', 'hook')); ?></div>
									<div class="next"><?php next_comments_link(esc_html__('Newer comments &rarr;', 'hook')); ?></div>
								</nav>
								<?php 
							}
						?>
					</div>
		 			<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<?php 
	}

	if (comments_open()) {
		?>
		<div id="respond_wrapper" class="prk_bordered_top">
			<div class="prk_inner_block columns small-centered">
				<div class="vrv_outer_row">
					<?php
						$hook_req=get_option( 'require_name_email' );
						$hook_aria_req=( $hook_req ? " aria-required='true'" : '' );
						$hook_place_req=( $hook_req ? $hook_translated['required_text'] : '' );
						$hook_form_extra_heading=($hook_translated['comments_under_reply']!="" ? '<div class="small_headings_color prk_9_em">'.esc_attr($hook_translated['comments_under_reply']).'</div>' : '' );

                        $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
						$fields= array(
						  'author' =>
						    '<div class="row"><div class="small-4 columns">
								<input type="text" class="text pirenko_highlighted" name="author" id="author" size="22" tabindex="2"'.esc_attr($hook_aria_req).' placeholder="'.esc_attr($hook_translated['comments_author_text']).esc_attr($hook_place_req).'" data-original="'.esc_attr($hook_translated['comments_author_text']).esc_attr($hook_place_req).'" />
							</div>',

						  'email' =>
						    '<div class="small-4 columns">
                                <input type="email" class="text pirenko_highlighted" name="email" id="email" size="22" tabindex="3"'.esc_attr($hook_aria_req).' placeholder="'.esc_attr($hook_translated['comments_email_text']).esc_attr($hook_place_req).'" data-original="'.esc_attr($hook_translated['comments_email_text']).esc_attr($hook_place_req).'" />		
                            </div>',

						  'url' =>
						    '<div class="small-4 columns">
                                <input type="url" class="text pirenko_highlighted" name="url" id="url" size="22" tabindex="4" 
                                placeholder="'.esc_attr($hook_translated['comments_url_text']).'" />
                            </div></div>',
                            'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"'.$consent.' />' .
                                '<label for="wp-comment-cookies-consent">'.__( 'Save my name, email, and website in this browser for the next time I comment.','hook' ).'</label></p>',
						);
						$args_form=array(
						  'id_form'           => 'commentform',
						  'class_form'      	=> 'comment-form prk_theme_form',
						  'id_submit'         => 'submit_comment_div',
						  'class_submit'      => 'colored_theme_button',
						  'name_submit'       => 'submit',
						  'title_reply'       => '<div id="prk_respond_header" class="hook_centered_text header_font"><h4 class="zero_color prk_heavier_600 big">'.$hook_translated['comments_leave_reply'].'</h4>'.$hook_form_extra_heading.'</div>',
						  'title_reply_to'    => esc_html__( 'Leave a Reply to %s', 'hook' ),
						  'cancel_reply_link' => esc_html__( 'Cancel Reply', 'hook' ),
						  'title_reply_before'	=> '<div id="reply-title" class="comment-reply-title">',
						  'title_reply_after'	=> '</div>',
						  'label_submit'      => $hook_translated['comments_submit'],
						  'format'            => 'xhtml',
						  'submit_button' => '<div id="contact_ok" class="prk_heavier_600 zero_color header_font">'.esc_attr($hook_translated['contact_wait_text']).'</div><div class="clearfix"></div><div id="submit_comment_div" class="colored_theme_button" data-wordpress_directory="'.esc_url(get_option('siteurl')).'" data-empty_text_error="'.esc_attr($hook_translated['empty_text_error']).'" data-invalid_email_error="'.esc_attr($hook_translated['invalid_email_error']).'" data-comment_ok_message="'.esc_attr($hook_translated['comment_ok_message']).'"><a href="#">'.$hook_translated['comments_submit'].'</a></div><p>',
						  'comment_field' =>  '<textarea name="comment" id="comment" class="pirenko_highlighted small-12" tabindex="1" placeholder="'.$hook_translated['comments_comment_text'].'" data-original="'.$hook_translated['comments_comment_text'].'" rows="8"></textarea>',
						  'must_log_in' => '<p class="must-log-in">' .
						    sprintf(
						      wp_kses( __('You must be <a href="%s">logged in</a> to post a comment.', 'hook'),array('a' => array('href'=>array())) ),
						      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
						    ).'</p>',
						  'logged_in_as' => '<p class="logged-in-as not_zero_color">' .
						    sprintf(
						    wp_kses( __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'hook'),array('a' => array('href'=>array())) ),
						      admin_url( 'profile.php' ),
						      $user_identity,
						      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
						    ).'</p>',
						  'comment_notes_before' => '',
						  'comment_notes_after' => '',
						  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
						);
						comment_form($args_form);
					?>
				</div>
			</div>
		</div>
		<?php
	}
?>