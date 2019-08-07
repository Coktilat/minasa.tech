<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}

/**
 * MH Composer compatibility for Gutenberg
 */
class MH_Composer_Plugins_Compat_Gutenberg extends MH_Composer_Plugins_Compat_Base {
	
	function __construct() {
		$this->plugin_id = 'gutenberg/gutenberg.php';
		if ( function_exists( 'gutenberg_can_edit_post' ) && ! mhc_is_wp_5() ) {
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
		
			wp_enqueue_script( 'mhc_gutenberg_js', MH_COMPOSER_URI . '/js/gutenberg.js', 'jquery', MH_COMPOSER_VER, true );

		$mhcomposer_settings = [
			'EditURL'       => add_query_arg( 'classic-editor', true, mhc_get_ssl_link( get_edit_post_link($post_id) )),
			'MHComposerisActive' => mh_composer_is_active(),
			'PageDraftTitle' => esc_attr(__( 'Page Title #', 'mh-composer' )),
		];

		wp_localize_script( 'mhc_gutenberg_js', 'MHComposerGutenbergSettings', $mhcomposer_settings );
		wp_enqueue_style( 'mhc_gutenberg_css', MH_COMPOSER_URI .'/css/gutenberg.css', array(), MH_COMPOSER_VER );
		wp_dequeue_script('mhc_app_js');
	
	}

	//load buttons
	public function print_admin_js_template() {
		global $typenow;
		if ( ! gutenberg_can_edit_post_type( $typenow ) ) {
			return;
		}
		?>
		<script id="mhcomposer-gutenberg-button-switch-mode" type="text/html">
			<div id="mhcomposer-switch-mode">
				<button id="mhcomposer-switch-mode-button" type="button" class="button button-primary button-large">
					<span class="mhcomposer-switch-mode-on"><?php echo __( '&#8592; Back to Block Editor', 'mh-composer' ); ?></span>
					<span class="mhcomposer-switch-mode-off">
						<i class="eicon-mhcomposer-square" aria-hidden="true" />
						<?php echo __( 'Edit in Page Composer', 'mh-composer' ); ?>
					</span>
				</button>
			</div>
		</script>

		<script id="mhcomposer-gutenberg-panel" type="text/html">
			<div id="mhcomposer-editor">
			<h3 class="mhcomposer-editor-title"><?php echo __( 'Great! Mharty Page Composer is enabled on this page', 'mh-composer' ); ?></h3>
			<a id="mhcomposer-go-to-edit-page-link" href="#">
					<div id="mhcomposer-editor-button" class="button button-primary button-large">
						<?php echo __( 'Launch Page Composer', 'mh-composer' ); ?>
					</div>
					<div id="mhc_loading_animation"></div>
				</a></div>
		</script>
<?php }
	//Add 'Mharty' to post states it is enabled for that page/posts
	public function display_post_states( $post_states, $post ) {
		if ( mh_composer_is_active( $post->ID ) ) {
			// Remove Gutenberg if existing
			$key = array_search( 'Gutenberg', $post_states );
			if ( false !== $key ) {
				unset( $post_states[ $key ] );
			}
			// GB devs didn't allow this to be translated so why should we ?
			$post_states[] = esc_attr(__( 'Mharty', 'mh-composer' ));
		}

		return $post_states;
	}

	//init
	public function init_hooks() {
		if ( is_admin() ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ), 4 );
			add_action( 'admin_footer', array( $this, 'print_admin_js_template') );

			add_filter( 'display_post_states', array( $this, 'display_post_states' ), 10, 2 );
			
			//remove gutenberg notice when switching to the classic editor
			//@todo this should only be used when composer is active
			remove_action( 'admin_enqueue_scripts', 'gutenberg_check_if_classic_needs_warning_about_blocks' );
		}
	}
}
new MH_Composer_Plugins_Compat_Gutenberg;