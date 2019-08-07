<?php
/**
 * Plugin Name: WP Ultimo: Language Selector on Sign-up
 * Description: Add a language selector field to the sign-up flow.
 * Plugin URI: http://wpultimo.com/addons
 * Text Domain: wu-lssu
 * Version: 0.0.1
 * Author: NextPress
 * Author URI: http://nextpress.co/
 * Copyright: Arindo Duque, NextPress
 * Network: true
 */ // phpcs:ignore

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
} // end if;

if (!class_exists('WP_Ultimo_Language_Selector')) :

	/**
	 * Here starts our plugin.
	 */
	class WP_Ultimo_Language_Selector {

		/**
		 * Version of the Plugin
		 *
		 * @var string
		 */
		public $version = '0.0.1';

		/**
		 * Makes sure we are only using one instance of the plugin
         *
		 * @var object WP_Ultimo_Language_Selector
		 */
		public static $instance;

		/**
		 * Returns the instance of WP_Ultimo_Language_Selector
         *
		 * @return object A WP_Ultimo_Language_Selector instance
		 */
		public static function get_instance() {

			if (null === self::$instance) {
				self::$instance = new self();
			} // end if;

			return self::$instance;

		} // end get_instance;

		/**
		 * Initializes the plugin
		 */
		public function __construct() {

			// Set the plugins_path
			$this->plugins_path = plugin_dir_path(__DIR__);

			// Load the text domain
			load_plugin_textdomain('wu-lssu', false, dirname(plugin_basename(__FILE__)) . '/lang');

			// Updater
			require_once $this->path('inc/class-wu-addon-updater.php');

			/**
			 * Adds the add-on updater.
			 *
			 * @since 0.0.1 Creates the updater
			 * @var WU_Addon_Updater
			 */
			$updater = new WU_Addon_Updater('wp-ultimo-language-selector', __('WP Ultimo: Language Selector', 'wu-lssu'), __FILE__);

			/**
			 * Require Files
			 */

			// Run Forest, run!
			$this->hooks();

		}  // end __construct;

		/**
		 * Return url to some plugin subdirectory
		 *
		 * @param string $dir Directory/file name.
		 * @return string Url to passed path
		 */
		public function path($dir) {

			return plugin_dir_path(__FILE__) . '/' . $dir;

		} // end path;

		/**
		 * Returns the URL of a particular directory/file.
		 *
		 * @since 0.0.1
		 * @param string $dir Directory/file name.
		 * @return string
		 */
		public function url($dir) {

			return plugin_dir_url(__FILE__) . '/' . $dir;

		} // end url;

		/**
		 * Gets an asset from the Assets folder.
		 *
		 * @since 0.0.1
		 * @param string $asset The name of the assets to retrieve.
		 * @param string $assets_dir The relative folder within the assets folder.
		 * @return string
		 */
		public function get_asset($asset, $assets_dir = 'img') {

			return $this->url("assets/$assets_dir/$asset");

		} // end get_asset;

		/**
		 * Render Views
		 *
		 * @param string $view View to be rendered.
		 * @param Array  $vars Variables to be made available on the view escope, via extract().
		 */
		public function render($view, $vars = false) {

			// Make passed variables available
			if (is_array($vars)) {
				extract($vars); // phpcs:ignore
			} // end if;

			// Load our view
			include $this->path("views/$view.php");

		} // end render;

		/**
		 * Add the hooks we need to make this work
		 */
		public function hooks() {

			add_filter('wu_settings_section_network', array($this, 'add_settings'), 999);

			add_action('wu_after_signup_form', array($this, 'render_selector_language'));

			add_action('login_footer', array($this, 'render_selector_language'));

			add_action('after_render_selector_language', array($this, 'add_script_selector_language'));

			add_action('login_footer', array($this, 'add_script_selector_language'));

			add_filter('locale', array($this, 'set_my_locale'));

			add_filter('wu_create_site_meta', array($this, 'save_after_signup_selector_language', 11, 2));

			add_action('init', array($this, 'save_language_cookie'));

		} // end hooks;

		/**
		 * Add the admin interface to create new simulates post type
		 *
		 * @since 1.9.7
		 * @param array $fields Admin settings fields.
		 */
		function add_settings($fields) {

			$new_fields = array(
				'allowed_languages_heading' => array(
					'title' => __('Languages', 'wp-ultimo'),
					'desc'  => __('This section holds settings regarding language and localization on WP Ultimo.', 'wp-ultimo'),
					'type'  => 'heading',
				),
				'allowed_languages'         => array(
					'title'       => __('Language selector on Signup', 'wp-ultimo'),
					'desc'        => __('Select which languages you want to display on your signup pages.', 'wp-ultimo'),
					'tooltip'     => '',
					'placeholder' => __('Leave blank to allow all languages installed.', 'wp-ultimo'),
					'type'        => 'select2',
					'default'     => 'en',
					'options'     => self::get_languages(),
				),
			);

			return array_merge($fields, $new_fields);

		} // end add_settings;

		/**
		 * Return the countries list.
		 *
		 * @since 0.0.1
		 * @return array
		 */
		public static function get_languages() {

			/**
			 * Get countries
			 *
			 * @since 1.5.0
			 */
			$languages = signup_get_available_languages();

			require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );

			$translations = wp_get_available_translations();

			$beauty_names = array();

			foreach ($languages as $locale) {

				$translation    = $translations[$locale];
				$beauty_names[] = $translation['native_name'];

			} // end foreach;

			$language_list = array_combine($languages, $beauty_names);

			return array_merge(array(
				'en_US' => 'English (United Stated)',
			), $language_list);

		} // end get_languages;

		/**
		 * Displays the selector field.
		 *
		 * @return void
		 * @since
		 */
		public function render_selector_language() {

			echo "<div style='text-align:center; margin-top:15px'>";

			do_action('before_render_selector_language');

			echo "<label for='language-switcher-locales'>
          			<span aria-hidden='true' class='dashicons dashicons-translation'></span>
				  </label>";

			if (WU_Settings::get_setting('allowed_languages')) {

				$languages = WU_Settings::get_setting('allowed_languages');

			} else {

				$languages = array_keys(self::get_languages());

			} // end if;

			// $languages =
			$locale = get_locale();

			if (!in_array('en_US', $languages) && ($locale == '' || $locale == 'en_US')) {

				$languages = array_merge(array('en_US'), $languages);

			} // end if;

			$this->output_selector_html(array(
				'name'      => 'locale',
				'id'        => 'locale',
				'selected'  => $locale,
				'languages' => $languages,
			));

			do_action('after_render_selector_language');

			echo '</div>';

		} // end render_selector_language;

		/**
		 * Save the lang after the signup.
		 *
		 * @since 0.0.1
		 * @param array $meta Array containing meta data to save to the site meta.
		 * @param array $transient Array containing transient data entered doing signup.
		 * @return array
		 */
		public function save_after_signup_selector_language($meta, $transient) {

			if (isset($_COOKIE['wu_selector_language'])) {

				$meta['WPLANG'] = $_COOKIE['wu_selector_language'];

				setcookie('wu_selector_language', get_locale(), time() - 20000, '/');

			} // end if;

			return $meta;

		}  // end save_after_signup_selector_language;

		/**
		 * Sets the locale for the sign-up.
		 *
		 * @param string $lang locale.
		 * @return string
		 * @since
		 */
		public function set_my_locale($lang) {

			if (isset($_GET['locale'])) {

				return $_GET['locale'];

			} elseif (isset($_COOKIE['wu_selector_language'])) {

				return $_COOKIE['wu_selector_language'];

			} // end if;

			return $lang;

		} // end set_my_locale;

		/**
		 * Add script after selector
		 *
		 * @return void
		 * @since
		 */
		public function add_script_selector_language() { // phpcs:disable ?>
    <script>
        jQuery(document).ready(function($) {

            function blockui_selector_language() {

								if (typeof jQuery.blockUI == 'undefined') {

									return;

								} // end if;

                $('.login').block({
                  message: null,
                  css: {
                    padding: '30px',
                    background: 'transparent',
                    border: 'none',
                    color: '#444',
                    top: '150px',
                  },
                  overlayCSS: {
                    background: '#F1F1F1',
                    opacity: 0.6,
                    cursor: 'initial',
                  }
                });

            } // end blockui_selector_language;

            $("#locale").change(function() {

                // loader
                blockui_selector_language();

                if ($('#locale').val() || $('#locale option:selected').attr("lang")) {

									window.location = '<?php echo add_query_arg('locale', 'LANGUAGE'); ?>'.replace('LANGUAGE', $('#locale').val());
                    
                } // end if;

            }); // end change();

        });
    </script>
			<?php
				// phpcs:enable
		}  // end add_script_selector_language;

		/**
		 * Ajax callback function.
		 *
		 * @since 0.0.1
		 * @return void
		 */
		public function save_language_cookie() {

			if (isset($_GET['locale'])) {

				setcookie('wu_selector_language', $_GET['locale'], time() + WEEK_IN_SECONDS, '/');

			} // end if;

		} // end save_language_cookie;

		/**
		 * Render input selector - copy core wp_dropdown_languages()
		 *
		 * @param array $args  Multi options.
		 * @return void
		 * @since
		 */
		public function output_selector_html($args = array()) {

			$parsed_args = wp_parse_args($args, array(
				'id'        => 'locale',
				'name'      => 'locale',
				'languages' => array(),
				'selected'  => '',
			));

			require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
			$translations = wp_get_available_translations();

			// Bail if no ID or no name.
			if (!$parsed_args['id'] || !$parsed_args['name']) {
				return;
			} // end if;

			$languages = array();

			// Holds the HTML markup.
			$structure = array();

			if (in_array('en_US', $parsed_args['languages'])) {

				// Always show English.
				$structure[] = sprintf(
				'<option value="en_US" lang="en" data-installed="1"%s>English (United States)</option>',
				selected('', $parsed_args['selected'], false)
				);

				unset($parsed_args['languages'][0]);

			} // end if;

			foreach ($parsed_args['languages'] as $locale) {

				$translation = $translations[$locale];
				$languages[] = array(
					'language'    => $translation['language'],
					'native_name' => $translation['native_name'],
					'lang'        => current($translation['iso']),
				);

				// Remove installed language from available translations.
				unset($translations[$locale]);

			} // end foreach;

			// List installed languages.
			foreach ($languages as $language) {

				$structure[] = sprintf(
				  	'<option value="%s" lang="%s"%s data-installed="1">%s</option>',
				  	esc_attr( $language['language'] ),
				  	esc_attr( $language['lang'] ),
				  	selected( $language['language'], $parsed_args['selected'], false ),
				  	esc_html( $language['native_name'] )
				);

			} // end foreach;

			// Combine the output string.
			$output  = sprintf( '<select name="%s" id="%s">', esc_attr( $parsed_args['name'] ), esc_attr( $parsed_args['id'] ) );
			$output .= join( "\n", $structure );
			$output .= '</select>';

			echo $output;

		} // end output_selector_html;

	} // end class WP_Ultimo_Language_Selector;

	/**
	 * Returns the active instance of the plugin
	 *
	 * @return WP_Ultimo_Language_Selector
	 */
	function WP_Ultimo_Language_Selector() { // phpcs:ignore

		return WP_Ultimo_Language_Selector::get_instance();

	} // end WP_Ultimo_Language_Selector;

	/**
	 * Initialize the Plugin
	 */
	add_action('plugins_loaded', 'wu_lssu_init', 1);

	/**
	 * We require WP Ultimo, so we need it
	 *
	 * @since 0.0.1
	 * @return void
	 */
	function wu_lssu_requires_ultimo() {
		?>

		<div class="notice notice-warning"> 
			<p><?php _e('WP Ultimo: Language Selector on Sign-up requires WP Ultimo to run. Install and active WP Ultimo to use WP Ultimo: Language Selector on Sign-up.', 'wu-lssu'); ?></p>
		</div>

		<?php
    }  // end wu_lssu_requires_ultimo;

	/**
	 * Initializes the plugin
	 *
	 * @since 0.0.1
	 * @return mixed
	 */
	function wu_lssu_init() {

		if (!class_exists('WP_Ultimo')) {

			return add_action('network_admin_notices', 'wu_lssu_requires_ultimo');

		} // end if;

		if (!version_compare(WP_Ultimo()->version, '1.9.0', '>=')) {

			return WP_Ultimo()->add_message(__('WP Ultimo: Language Selector on Sign-up requires WP Ultimo version 1.9.0. ', 'wu-lssu'), 'warning', true);

		} // end if;

		// Set global
		$GLOBALS['WP_Ultimo_Language_Selector'] = WP_Ultimo_Language_Selector();

	} // end wu_lssu_init;

endif;

if (!function_exists('signup_get_available_languages')) {

	/**
	 * Loads the native WordPress function when its not available.
	 *
	 * @since 0.0.1
	 * @return array
	 */
	function signup_get_available_languages() {

		/**
		 * Filters the list of available languages for front-end site signups.
		 *
		 * Passing an empty array to this hook will disable output of the setting on the
		 * signup form, and the default language will be used when creating the site.
		 *
		 * Languages not already installed will be stripped.
		 *
		 * @since 4.4.0
		 *
		 * @param array $available_languages Available languages.
		 */
		$languages = (array) apply_filters( 'signup_get_available_languages', get_available_languages() );

		/**
		 * Strip any non-installed languages and return.
		 *
		 * Re-call get_available_languages() here in case a language pack was installed
		 * in a callback hooked to the 'signup_get_available_languages' filter before this point.
		 */
		return array_intersect_assoc( $languages, get_available_languages() );

	} // end signup_get_available_languages;

} // end if;
