<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WPSAAS {

	/**
	 * The single instance of WPSAAS.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'wpsaas';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin JS & CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

		// TGM
		add_action( 'tgmpa_register', array( $this, 'wpsaas_register_required_plugins' ));

		// Admin notices
		add_action( 'admin_notices', array( $this, 'wpsaas_network_notice__error' ));
		add_action( 'network_admin_notices', array( $this, 'wpsaas_setup_notice__warning' ));

		// Load API for generic admin functions
		if ( is_admin() ) {
			$this->admin = new WPSAAS_Admin_API();
		}

		add_action( 'init', array( $this, 'wpsaas_setup_install_theme' ), 999);

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
	} // End __construct ()

	/**
	 * Wrapper function to register a new post type
	 * @param  string $post_type   Post type name
	 * @param  string $plural      Post type item plural name
	 * @param  string $single      Post type item single name
	 * @param  string $description Description of post type
	 * @return object              Post type class object
	 */
	public function register_post_type ( $post_type = '', $plural = '', $single = '', $description = '', $options = array() ) {

		if ( ! $post_type || ! $plural || ! $single ) return;

		$post_type = new WPSAAS_Post_Type( $post_type, $plural, $single, $description, $options );

		return $post_type;
	}

	/**
	 * Wrapper function to register a new taxonomy
	 * @param  string $taxonomy   Taxonomy name
	 * @param  string $plural     Taxonomy single name
	 * @param  string $single     Taxonomy plural name
	 * @param  array  $post_types Post types to which this taxonomy applies
	 * @return object             Taxonomy class object
	 */
	public function register_taxonomy ( $taxonomy = '', $plural = '', $single = '', $post_types = array(), $taxonomy_args = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) return;

		$taxonomy = new WPSAAS_Taxonomy( $taxonomy, $plural, $single, $post_types, $taxonomy_args );

		return $taxonomy;
	}

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
	} // End enqueue_styles ()

	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {
		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-frontend' );
	} // End enqueue_scripts ()

	/**
	 * Load admin CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_styles ( $hook = '' ) {
		wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-admin' );
	} // End admin_enqueue_styles ()

	/**
	 * Load admin Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_scripts ( $hook = '' ) {
		wp_register_script( $this->_token . '-admin', esc_url( $this->assets_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-admin' );
	} // End admin_enqueue_scripts ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'wpsaas', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'wpsaas';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main WPSAAS Instance
	 *
	 * Ensures only one instance of WPSAAS is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WPSAAS()
	 * @return Main WPSAAS instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

	function wpsaas_setup_install_theme () {

		// Install theme during setup
		if ( is_admin() and isset($_GET['page']) and $_GET['page'] == 'wpsaas-setup' and isset($_GET['action']) and $_GET['action'] == 'wpsaas-install-theme') {
			
			// TODO: Check if Divi is already installed

			// Installing the theme
			// TODO: Research about passed args
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/misc.php';
			require_once ABSPATH . 'wp-includes/pluggable.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			require_once ABSPATH . 'wp-admin/includes/post.php';
			require_once WP_PLUGIN_DIR . '/wpsaas/includes/lib/class-wordpress-importer.php';

			echo '<div class="wpsaas-message-mask">';

			$upgrader = new Theme_Upgrader( new Theme_Installer_Skin( compact('type', 'title', 'nonce', 'url') ) );

			// Install parent theme
			$result = $upgrader->install( WP_PLUGIN_DIR . '/wpsaas/includes/lib/vendor/themes/Divi.zip' );
			WP_Theme::network_enable_theme( 'Divi' );
			$parent_theme = wp_get_theme( 'Divi' );

			// Install child theme
			$result = $upgrader->install( WP_PLUGIN_DIR . '/wpsaas/includes/lib/vendor/themes/WPSAAStheme.zip' );
			WP_Theme::network_enable_theme( 'WPSAAS' );
			$child_theme = wp_get_theme( 'WPSAAS' );
			
			// var_dump(wp_get_theme( 'Divi' )->errors());
			// var_dump(wp_get_theme( 'WPSAAS' )->errors());

			$blog_ids = wp_get_sites( array('network_id' => $wpdb->siteid) );
			// var_dump($blog_ids);
			foreach( $blog_ids as $b ){

			    switch_to_blog( $b['blog_id'] );

			    if ($b['blog_id'] == 1) {
			    	switch_theme( $parent_theme->get_stylesheet() );
				} else {
					switch_theme( $child_theme->get_stylesheet() );

					$wp_import = new WP_Import();
					set_time_limit(0);
					$path = get_stylesheet_directory() . '/demo/wpsaas-pages.xml';
		
					// var_dump($path);                
					// $wp_import->fetch_attachments = $attachments;
					$value = $wp_import->import($path);

					$homepage = get_page_by_title( 'WPSAAS Front Page' );
					update_option( 'page_on_front', $homepage->ID );
    				update_option( 'show_on_front', 'page' );
				}
			 
			    restore_current_blog();
			}
			
			// TODO: Check for errors? Do smth if there are any?

			// If you know a better way of supressing those messages, please let me know
			echo '</div><style>.wpsaas-message-mask {color:#fff !important; font-size: 0 !important;}</style>';

			$string = '<script type="text/javascript">';
		    $string .= 'window.location = "' . network_admin_url( 'admin.php?page=wpsaas-setup' ) . '"';
		    $string .= '</script>';

		    echo $string;
			exit;

		}
	}

	function wpsaas_network_notice__error() {

		if (is_multisite())
			return;

	    ?>
	    <div class="notice notice-error is-dismissible">
	        <p><?php _e( 'WPSAAS must be run on a multisite installation.', 'wpsaas' ); ?></p>
	    </div>
	    <?php
	}

	function wpsaas_setup_notice__warning() {
	    ?>
	    <div class="notice notice-warning is-dismissible">
	        <p><?php _e( 'Please run WPSAAS ', 'wpsaas' ); ?><a href="<?=network_admin_url( 'admin.php?page=wpsaas-setup' )?>"><?php _e( 'setup', 'wpsaas' ); ?></a></p>
	    </div>
	    <?php
	}

	function wpsaas_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Admin Menu Editor', // The plugin name.
			'slug'               => 'admin-menu-editor', // The plugin slug (typically the folder name).
			//'source'             => dirname( __FILE__ ) . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			//'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			// 'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			// 'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			// 'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			// 'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		array(
			'name'               => 'Clientside', // The plugin name.
			'slug'               => 'Clientside', // The plugin slug (typically the folder name).
			'source'             => dirname( __FILE__ ) . '/lib/vendor/plugins/Clientside.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			//'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			// 'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			// 'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			// 'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			// 'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		array(
			'name'               => 'WP Ultimo', // The plugin name.
			'slug'               => 'wp-ultimo', // The plugin slug (typically the folder name).
			'source'             => dirname( __FILE__ ) . '/lib/vendor/plugins/wp-ultimo.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			//'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			// 'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			// 'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			// 'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			// 'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		)

		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		// array(
		// 	'name'         => 'TGM New Media Plugin', // The plugin name.
		// 	'slug'         => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
		// 	'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
		// 	'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		// 	'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
		// ),

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		// array(
		// 	'name'      => 'Adminbar Link Comments to Pending',
		// 	'slug'      => 'adminbar-link-comments-to-pending',
		// 	'source'    => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
		// ),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		// array(
		// 	'name'      => 'BuddyPress',
		// 	'slug'      => 'buddypress',
		// 	'required'  => false,
		// ),

		// This is an example of the use of 'is_callable' functionality. A user could - for instance -
		// have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
		// 'wordpress-seo-premium'.
		// By setting 'is_callable' to either a function from that plugin or a class method
		// `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
		// recognize the plugin as being installed.
		// array(
		// 	'name'        => 'WordPress SEO by Yoast',
		// 	'slug'        => 'wordpress-seo',
		// 	'is_callable' => 'wpseo_init',
		// ),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'wpsaas',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'wpsaas' ),
			'menu_title'                      => __( 'Install Plugins', 'wpsaas' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'wpsaas' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'wpsaas' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'wpsaas' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'wpsaas'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'wpsaas'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'wpsaas'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'wpsaas'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'wpsaas'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'wpsaas'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'wpsaas'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'wpsaas'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'wpsaas'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'wpsaas' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'wpsaas' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'wpsaas' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'wpsaas' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wpsaas' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'wpsaas' ),
			'dismiss'                         => __( 'Dismiss this notice', 'wpsaas' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'wpsaas' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'wpsaas' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}

}