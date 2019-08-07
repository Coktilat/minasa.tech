<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}

/**
 * MH Composer compatibility for Block Editor
 */
class MH_Composer_Compat_Block_Editor{
	
	function __construct() {
		//if it is WP 5 & classic editor plugin enabled
		if ( mhc_is_wp_5() && ( class_exists( 'Classic_Editor', false ) || function_exists('classic_editor_init_actions') ) ) {
			$this->init_hooks();
		}
	}
	
	//Filter on map_meta_cap.
	public function map_meta_cap( $caps, $cap, $user_id, $args ) {
		// This only needs to run once,
		remove_filter( 'map_meta_cap', array( $this, 'map_meta_cap' ), 10 );
		if (
			// Gutenberg checks for 'edit_post' so do nothing in all other cases
			'edit_post' !== $cap ||
			// Ignore the case where mharty composer wasn't used to edit the post
			! mh_composer_is_active( $args[0] )
		) {
			return $caps;
		}
		// We need to add `do_not_allow` for superadmins
		$caps = array( 'do_not_allow' );
		return $caps;
	}

	//load assets
	public function enqueue_block_editor_assets() {
		$post_id = get_the_ID();
		//$edit_url = mhc_get_ssl_link( get_edit_post_link($post_id) );
		//$remember = get_option( 'classic-editor-remember' ) === 'remember';
		$edit_url = "post.php?post={$post_id}&action=edit";
		
			wp_enqueue_script( 'mhc_gutenberg_js', MH_COMPOSER_URI . '/js/gutenberg.js', 'jquery', MH_COMPOSER_VER, true );

			//Forget the previous value when going to a specific editor.
			$edit_url = add_query_arg( 'classic-editor__forget', '', $edit_url );
			

		$mhcomposer_settings = [
			'EditURL'       => add_query_arg( 'classic-editor', '', $edit_url ),
			'MHComposerisActive' => mh_composer_is_active(),
			'PageDraftTitle' => esc_attr(__( 'Page Title #', 'mh-composer' )),
		];

		wp_localize_script( 'mhc_gutenberg_js', 'MHComposerGutenbergSettings', $mhcomposer_settings );
		wp_enqueue_style( 'mhc_gutenberg_css', MH_COMPOSER_URI .'/css/gutenberg.css', array(), MH_COMPOSER_VER );
	
	}

	//load buttons (WP admin bar)
	public function print_admin_js_template() {
		global $typenow;
		?>
		<script id="mhcomposer-gutenberg-button-switch-mode" type="text/html">
			<div id="mhcomposer-switch-mode">
				<button id="mhcomposer-switch-mode-button" type="button" class="button button-primary button-large pulse">
					<span class="mhcomposer-switch-mode-on"><?php echo __( '&#8592; Back to Block Editor', 'mh-composer' ); ?></span>
					<span class="mhcomposer-switch-mode-off">
						<?php echo __( 'Edit in Page Composer', 'mh-composer' ); ?>
					</span>
				</button>
			</div>
		</script>

		<script id="mhcomposer-gutenberg-panel" type="text/html">
			<div id="mhcomposer-editor">
			<h3 class="mhcomposer-editor-title"><?php echo __( 'Great! Mharty Page Composer is enabled on this page', 'mh-composer' ); ?></h3>
			<a id="mhcomposer-go-to-edit-page-link" href="">
					<div id="mhcomposer-editor-button" class="button button-primary button-large">
						<?php echo __( 'Launch Page Composer', 'mh-composer' ); ?>
					</div>
					<div id="mhc_loading_animation"></div>
				</a></div>
		</script>
<?php }
	
	public static function is_mharty() {
		global $post;
		//if ( $post_id ) {

			if ( mh_composer_is_active( $post->ID ) ) {
					return true;
				} else {
					return false;
				}
		if ( isset( $_GET['classic-editor'] ) ) {
			return true;
		}

		return false;
	}
	
	public static function choose_editor( $which_editor, $post ) {
		// Open the Block editor when no $post and for "Add New" links.
		if ( empty( $post->ID ) || ( $post->post_status === 'auto-draft' && ! MH_Composer_Compat_Block_Editor::is_mharty() ) ) {
			return $which_editor;
		}

		if ( MH_Composer_Compat_Block_Editor::is_mharty( $post->ID ) ) {
			return false;
		}

		return $which_editor;
	}
	
	//init
	public function init_hooks() {
		if ( is_admin() ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ), 4 );
			add_action( 'admin_footer', array( $this, 'print_admin_js_template') );

			//add_filter( 'display_post_states', array( $this, 'display_post_states' ), 10, 2 );
			
			//remove gutenberg notice when switching to the classic editor
			//@todo this should only be used when composer is active
			remove_action( 'admin_enqueue_scripts', 'gutenberg_check_if_classic_needs_warning_about_blocks' );
			add_filter( 'use_block_editor_for_post', array( $this, 'choose_editor' ), 100, 2 );
		}
	}
}
new MH_Composer_Compat_Block_Editor;