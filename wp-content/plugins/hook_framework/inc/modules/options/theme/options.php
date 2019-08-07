<?php
if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, '.gettype($params[0]).' given', E_USER_WARNING);
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}
if (!class_exists('hook_options_config')) {
    class hook_options_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            if (1) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        function dynamic_section($sections) {
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'hook'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'hook'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
        Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            return $args;
        }
        /**
        Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        public function setSections() {
            $prk_select_font_options=hook_fonts();
            $a = array_column($prk_select_font_options, 'value');
            $b = array_column($prk_select_font_options, 'label');
            $fonts_array=array_combine($a, $b);
            $prk_font_options = get_option('prk_font_plugin_option');
            if (is_array($prk_font_options)) {
                foreach ($prk_font_options as $font)
                {
                    if ($font['erased']=="false" && !array_key_exists($font['value'],$fonts_array))
                    {
                        $fonts_array[$font['value']] = $font['label'];
                    }
                }
            }
            $social_options=array(
                'delicious' => 'Delicious',
                'deviantart' => 'Deviantart',
                'dribbble' => 'Dribbble',
                'facebook-official' => 'Facebook',
                'flickr' => 'Flickr',
                'google_plus' => 'Google Plus',
                'instagram' => 'Instagram',
                'lastfm' => 'LastFM',
                'linkedin-square' => 'Linkedin',
                'medium' => 'Medium',
                'pinterest' => 'Pinterest',
                'skype' => 'Skype',
                'soundcloud' => 'Soundcloud',
                'twitter' => 'Twitter',
                'viadeo' => 'Viadeo',
                'vimeo' => 'Vimeo',
                'vk' => 'VK',
                'xing' => 'Xing',
                'youtube' => 'Youtube',
                'rss' => 'RSS Feed'
            );
            ob_start();
            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'hook'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
                <?php if ($screenshot) : ?>
                    <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','hook'); ?>" />
                        </a>
                    <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','hook'); ?>" />
                <?php endif; ?>
                <h4><?php echo esc_attr($this->theme->display('Name')); ?></h4>
                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'hook'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'hook'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>'.esc_html__('Tags', 'hook').':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_attr($this->theme->display('Description')); ?></p>
                    <?php
                    if ($this->theme->parent()) {
                        printf(' <p class="howto">'.esc_html__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'hook').'</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'hook'), $this->theme->parent()->display('Name'));
                    }
                    ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $align_array=array(
                'hook_left_align' => esc_html__('Left', 'hook'),
                'hook_center_align' => esc_html__('Centred', 'hook'),
                'hook_right_align' => esc_html__('Right', 'hook'),
            );
            $sampleHTML = '';
            if (false) {
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH.'/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents('/info-html.html');
            }
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => esc_html__('General', 'hook'),
                'icon'      => 'el-icon-cogs',
                'fields'    => array(
                    array(
                        'id'=>'backend_ttlgen',
                        'type' => 'info',
                        'desc' => esc_html__('General', 'hook')
                    ),
                    array(
                        'id'=>'hook_responsive',
                        'type' => 'switch',
                        'title' => esc_html__('Make the theme layout responsive?', 'hook'),
                        'subtitle'=> esc_html__('Make theme adjust to smaller screens.', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'custom_width',
                        'type' => 'text',
                        'title' => esc_html__('Maximum content width', 'hook'),
                        'subtitle' => esc_html__('Numeric values only.', 'hook'),
                        'desc' => esc_html__('How much the center content will stretch. Not applicable on some pages.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '1280',
                        'class' => 'small-text',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'show_sooner',
                        'type' => 'select',
                        'title' => esc_html__('Show content before all images are loaded?', 'hook'),
                        'options' => array(
                            'no' => 'No',
                            'yes' => 'Yes',
                        ),
                        'default' => array('yes' => 'Yes'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'hook_detect_retina',
                        'type' => 'switch',
                        'title' => esc_html__('Detect and serve better images on retina screens?', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'page_transition',
                        'type' => 'select',
                        'title' => esc_html__('Page transitions animation', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'options' => array(
                            'hk_trans_fade' => esc_html__('Fade In/Out', 'hook'),
                            'hk_trans_hz' => esc_html__('Open/close - Horizontal', 'hook'),
                            'hk_trans_vt' => esc_html__('Open/close - Vertical', 'hook'),
                            'hk_trans_hzsl' => esc_html__('Slide In/Out - Horizontal', 'hook'),
                            'hk_trans_vtsl' => esc_html__('Slide In/Out - Vertical', 'hook'),
                        ),
                        'default' => 'hk_trans_fade',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'page_transition_bk',
                        'type' => 'color',
                        'title' => esc_html__('Page transitions background color', 'hook'),
                        'default' => '#f7f7f7',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'ajax_calls',
                        'type' => 'switch',
                        'title' => esc_html__('Use Ajax calls to load content?', 'hook'),
                        'desc' => esc_html__('If on the theme will attempt to load all content using Ajax calls. This will speed up the website page loading process and allow some elements to have smoother transitions.', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'smooth_scroll',
                        'type' => 'switch',
                        'title' => esc_html__('Smooth mouse wheel scrolling on Chrome?', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_fonts',
                        'type' => 'info',
                        'desc' => esc_html__('Fonts', 'hook')
                    ),
                    array(
                        'id'=>'font_size',
                        'type' => 'slider',
                        'title' => esc_html__('Body font size', 'hook'),
                        'subtitle'=> esc_html__('Important: all other font sizes are calculated according to this value.', 'hook'),
                        'desc'=> esc_html__('Min: 5, max: 30', 'hook'),
                        "default"       => "15",
                        "min"       => "5",
                        "step"      => "1",
                        "max"       => "30",
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'header_font',
                        'type' => 'select',
                        'class' => 'prk_hide_default',
                        'title' => esc_html__('Headings font', 'hook'),
                        'options' => $fonts_array,
                        'default' => array(
                            'value' => 'PT+Sans:400,700,400italic,700italic',
                            'css' => "'PT Sans', sans-serif",
                            'hosted'=> 'google'
                        ),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'uppercase_headings',
                        'type' => 'switch',
                        'title' => esc_html__('Uppercase text that uses the headings font?', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'body_font',
                        'type' => 'select',
                        'title' => esc_html__('Body font', 'hook'),
                        'options' => $fonts_array,
                        'default' => array(
                            'value' => 'PT+Sans:400,700,400italic,700italic',
                            'css' => "'PT Sans', sans-serif",
                            'hosted'=> 'google'
                        ),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'custom_font',
                        'type' => 'select',
                        'title' => esc_html__('Extra font', 'hook'),
                        'subtitle' => esc_html__('Optional', 'hook'),
                        'desc' => esc_attr('To apply this font to certain elements simply add the CSS class <strong>extra_font</strong>', 'hook'),
                        'options' => $fonts_array,
                        'default' => array(
                            'value' => '',
                            'css' => '',
                            'hosted'=> ''
                        ),
                        'compiler' => 'true'
                    ),
                    array('id'=>'custom_font_style',
                        'type' => 'select',
                        'title' => esc_html__('Extra font default style', 'hook'),
                        'options' => array(
                            'normal' => esc_html__('Normal','hook'),
                            'italic' => esc_html__('Italic','hook')),
                        'default' => 'italic',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'titles_font',
                        'type' => 'select',
                        'title' => esc_html__('Pages and single posts title font face', 'hook'),
                        'desc' => esc_html__('Default value is Headings font', 'hook'),
                        'options' => array(
                            'header_font' => esc_html__('Headings font', 'hook'),
                            'body_font' => esc_html__('Body font', 'hook'),
                            'custom_font' => esc_html__('Extra font', 'hook')),
                        'default' => 'header_font',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'main_subheadings_font',
                        'type' => 'select',
                        'title' => esc_html__('Pages and single posts sub-headings font face', 'hook'),
                        'desc' => esc_html__('Default value is Headings font', 'hook'),
                        'options' => array(
                            'header_font' => esc_html__('Headings font', 'hook'),
                            'body_font' => esc_html__('Body font', 'hook'),
                            'custom_font' => esc_html__('Extra font', 'hook')),
                        'default' => 'body_font',
                        'compiler' => 'true'
                    ),
                    array('id'=>'subheadings_style',
                        'type' => 'select',
                        'title' => esc_html__('Pages and single posts sub-headings font style', 'hook'),
                        'options' => array(
                            'normal' => esc_html__('Normal','hook'),
                            'italic' => esc_html__('Italic','hook')),
                        'default' => 'italic',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'headings_align',
                        'type' => 'select',
                        'title' => esc_html__('Default pages and single posts title and sub-heading text alignment', 'hook'),
                        'options' => array(
                            'hook_left_align' => esc_html__('Left', 'hook'),
                            'hook_center_align' => esc_html__('Centred', 'hook'),
                            'hook_right_align' => esc_html__('Right', 'hook')),
                        'default' => 'hook_center_align',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'drop_caps_size',
                        'type' => 'slider',
                        'title' => esc_html__('Drop caps size font size (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 8, max: 150', 'hook'),
                        "default"       => "52",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "150",
                    ),
                    array(
                        'id'=>'backend_gn_colors',
                        'type' => 'info',
                        'desc' => esc_html__('Colors: General', 'hook')
                    ),
                    array(
                        'id'=>'use_custom_colors',
                        'type' => 'switch',
                        'title' => esc_html__('Apply featured colors for single posts and portfolio entries?', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array('id'=>'site_background_color',
                        'type' => 'color',
                        'title' => esc_html__('Site background color', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'active_color',
                        'type' => 'color',
                        'title' => esc_html__('Theme active color', 'hook'),
                        'default' => '#12b2cb',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'bd_headings_color',
                        'type' => 'color',
                        'title' => esc_html__('Text headings color', 'hook'),
                        'default' => '#222222',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'bd_smallers_color',
                        'type' => 'color',
                        'title' => esc_html__('Text small headings color', 'hook'),
                        'default' => '#3e3e3e',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'inactive_color',
                        'type' => 'color',
                        'title' => esc_html__('Body text color', 'hook'),
                        'default' => '#808080',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_lb_colors',
                        'type' => 'info',
                        'desc' => esc_html__('Colors: Textfields, lines and borders', 'hook')
                    ),
                    array(
                        'id'=>'lines_color', 'type' => 'color',
                        'title' => esc_html__('Lines color', 'hook'),
                        'default' => '#efefef',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'background_color',
                        'type' => 'color',
                        'title' => esc_html__('Textfields and similar elements background color', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'default' => '#f2f2f2',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'inputs_bordercolor',
                        'type' => 'color',
                        'title' => esc_html__('Textfields and similar elements border color', 'hook'),
                        'default' => '#efefef',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'inputs_radius',
                        'type' => 'slider',
                        'title' => esc_html__('Textfields and similar elements border radius', 'hook'),
                        'subtitle' => esc_html__('Use 0 for squared textfields', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "0",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'shadow_color', 'type' => 'color',
                        'title' => esc_html__('Textfields and similar elements shadow color', 'hook'),
                        'default' => '#1b1b1b',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'custom_shadow',
                        'type' => 'slider',
                        'title' => esc_html__('Textfields and similar elements shadow opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "0",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_btn_colors',
                        'type' => 'info',
                        'desc' => esc_html__('Colors and appearance: Buttons', 'hook')
                    ),
                    array(
                        'id'=>'buttons_font',
                        'type' => 'select',
                        'title' => esc_html__('Buttons font', 'hook'),
                        'subtitle' => esc_html__('Select the font face to be used for the theme buttons.', 'hook'),
                        'options' => array(
                            'headings_f' => esc_html__('Headings font', 'hook'),
                            'body_f' => esc_html__('Body font', 'hook'),
                            'custom_f' => esc_html__('Extra font', 'hook')),
                        'default' => 'headings_f',
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'buttons_spacing',
                        'type' => 'slider',
                        'title' => esc_html__('Buttons character spacing', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 20', 'hook'),
                        "default"       => "1",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "20",
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'uppercase_buttons',
                        'type' => 'switch',
                        'title' => esc_html__('Uppercase text on buttons?', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'buttons_border',
                        'type' => 'slider',
                        'title' => esc_html__('Ghost buttons border width', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 5', 'hook'),
                        "default"       => "1",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "5",
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'buttons_radius',
                        'type' => 'slider',
                        'title' => esc_html__('Buttons border radius', 'hook'),
                        'subtitle' => esc_html__('Use 0 for squared buttons', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "0",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'buttons_text_color',
                        'type' => 'color',
                        'title' => esc_html__('Buttons text color', 'hook'),
                        'default' => '#FFFFFF', '
                validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'theme_buttons_color',
                        'type' => 'color',
                        'title' => esc_html__('Buttons background color', 'hook'),
                        'subtitle' => esc_html__('The alternative background color will be the theme current active color', 'hook'),
                        'default' => '#1e1e1e',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'buttons_inner_shadow',
                        'type' => 'switch',
                        'title' => esc_html__('Apply inner shadow on buttons?', 'hook'),
                        'subtitle'=> esc_html__('Will be placed on the lower part of the button.', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'slider_text_color',
                        'type' => 'color',
                        'title' => esc_html__('Slider, team members and navigation buttons text color', 'hook'),
                        'default' => '#FFFFFF', '
                validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'buttons_color',
                        'type' => 'color',
                        'title' => esc_html__('Slider, team members and navigation buttons background color', 'hook'),
                        'default' => '#0b9bb1', '
                validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'back_to_top_bk',
                        'type' => 'color',
                        'title' => esc_html__('Back to top button background color', 'hook'),
                        'default' => '#12b2cb', '
                validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'back_to_top_color',
                        'type' => 'color',
                        'title' => esc_html__('Back to top button color', 'hook'),
                        'default' => '#FFFFFF', '
                validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_gn_colors_oth',
                        'type' => 'info',
                        'desc' => esc_html__('Colors: Other', 'hook')
                    ),
                    array(
                        'id'=>'preloader_style',
                        'type' => 'select',
                        'title' => esc_html__('Preloader style', 'hook'),
                        'options' => array(
                            'theme_spinner' => esc_html__('Animated spinner', 'hook'),
                            'theme_default' => esc_html__('Animated bars', 'hook'),
                            'theme_circles' => esc_html__('Animated circles', 'hook'),
                            'custom_image' => esc_html__('Custom image', 'hook')),
                        'default' => 'theme_spinner',
                        'compiler' => 'true',
                    ),
                    array(
                        'id'=>'preloader_color_1',
                        'type' => 'color',
                        'title' => esc_html__('Outer spinner color', 'hook'),
                        'default' => '#111111',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('preloader_style','equals',array('theme_spinner')),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'preloader_color_2',
                        'type' => 'color',
                        'title' => esc_html__('Middle spinner color', 'hook'),
                        'default' => '#12b2cb',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('preloader_style','equals',array('theme_spinner')),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'preloader_color_3',
                        'type' => 'color',
                        'title' => esc_html__('Inner spinner color', 'hook'),
                        'default' => '#686868',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('preloader_style','equals',array('theme_spinner')),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'preloader_color',
                        'type' => 'color',
                        'title' => esc_html__('Preloader color', 'hook'),
                        'default' => '#49B6B2',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('preloader_style','equals',array('theme_default','theme_circles')),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'preloader_opacity',
                        'title' => esc_html__('Preloader opacity', 'hook'),
                        'type' => 'slider',
                        'desc'=> esc_html__('Min: 1, max: 100', 'hook'),
                        "default"       => "70",
                        "min"       => "1",
                        "step"      => "1",
                        "max"       => "100",
                        'compiler' => 'true',
                        'required' => array('preloader_style','not','custom_image'),
                    ),
                    array(
                        'id'=>'preloader_image',
                        'type' => 'media',
                        'title' => esc_html__('Preloader image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Maximum recommended dimensions: 200x200 pixels', 'hook'),
                        'required' => array('preloader_style','equals','custom_image'),
                    ),
                    array(
                        'id'=>'preloader_image_retina',
                        'type' => 'media',
                        'title' => esc_html__('Preloader image for retina screens', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Optional - If used should be the double size of the original preloader image.', 'hook'),
                        'required' => array('preloader_style','equals','custom_image'),
                    ),
                    array(
                        'id'=>'background_color_dots',
                        'type' => 'color',
                        'title' => esc_html__('Navigation rectangles up color', 'hook'),
                        'subtitle' => esc_html__('Will be used only if navigation using fixed-position rectangles is active for a page', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'featured_header_color',
                        'type' => 'color',
                        'title' => esc_html__('Featured header text color', 'hook'),
                        'subtitle' => esc_html__('Will be used on posts with featured media', 'hook'),
                        'default' => '#000000',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'bk_color_sidebar_overlay',
                        'type' => 'color',
                        'title' => esc_html__('Content overlay background color', 'hook'),
                        'subtitle' => esc_html__('Will be shown when: the mobile sidebar is visible or the menu search overlay is active.', 'hook'),
                        'default' => '#111111',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_sdb_sidebars',
                        'type' => 'info',
                        'desc' => esc_html__('Sidebars', 'hook')
                    ),
                    array(
                        'id'=>'right_sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display right sidebar on pages and posts by default', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                ));
            $this->sections[] = array(
                'icon' => 'el-icon-star',
                'title' => esc_html__('Branding', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'backend_gn_logopasd',
                        'type' => 'info',
                        'desc' => esc_html__('Appearance', 'hook')
                    ),
                    array(
                        'id'=>'logo_align',
                        'type' => 'select',
                        'title' => esc_html__('Logo position?', 'hook'),
                        'options' => array(
                            'st_logo_on_left' => esc_html__('Left', 'hook'),
                            'st_logo_on_right' => esc_html__('Right', 'hook'),
                        ),
                        'default' => 'st_logo_on_left',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_gn_colorsdas',
                        'type' => 'info',
                        'desc' => esc_html__('Logo: Before scroll', 'hook')
                    ),
                    array(
                        'id'=>'logo',
                        'type' => 'media',
                        'title' => esc_html__('Logo', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>get_template_directory_uri().'/images/logo.png',
                            'id'=>'',
                            'width'=>'160',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Optional - Leave blank if logo is not needed.', 'hook'),
                    ),
                    array(
                        'id'=>'logo_retina',
                        'type' => 'media',
                        'title' => esc_html__('Logo for retina screens', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>get_template_directory_uri().'/images/logo-retina.png',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Optional - If used should be the double size of the original logo image.', 'hook'),
                    ),
                    array( 'id'=>'logo_top_margin',
                        'type' => 'text',
                        'title' => esc_html__('Logo top margin', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '39',
                        'class' => 'small-text',
                    ),
                    array(
                        'id'=>'backend_widgets_after_scroll',
                        'type' => 'info',
                        'desc' => esc_html__('Logo: After scroll & forced menu pages', 'hook')
                    ),
                    array(
                        'id'=>'logo_collapsed',
                        'type' => 'media',
                        'title' => esc_html__('Logo - After scroll & forced menu pages', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>get_template_directory_uri().'/images/logo.png',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Options - Leave blank if logo is not needed or if the persistent menu is off.', 'hook'),
                    ),
                    array(
                        'id'=>'logo_collapsed_retina',
                        'type' => 'media',
                        'title' => esc_html__('Logo retina screens - After scroll & forced menu pages', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>get_template_directory_uri().'/images/logo-retina.png',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'subtitle' => esc_html__('Optional - If used should be the double size of the original logo image.', 'hook'),
                    ),
                    array( 'id'=>'logo_collapsed_top_margin',
                        'type' => 'text',
                        'title' => esc_html__('Logo top margin - After scroll', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '16',
                        'class' => 'small-text',
                    ),
                    array(
                        'id'=>'favicon',
                        'type' => 'media',
                        'title' => esc_html__('Favicon image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>get_template_directory_uri().'/images/favicon.ico',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Should have .ico as file extension.', 'hook'),
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-text-width',
                'title' => esc_html__('Above Menu Bar', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'show_top_bar',
                        'type' => 'switch',
                        'title' => __('Display small bar above the menu?', 'hook'),
                        'subtitle' => __('Content for this area is managed under Appearance>Widgets. You will find 2 sidebarized areas: Above Menu - Left Sidebar and Above Menu - Right Sidebar', 'hook'),
                        "default"       => 0,
                    ),
                    /*array(
                        'id'=>'top_bar_type',
                        'type' => 'select',
                        'title' => __('Top bar display', 'hook'),
                        'subtitle' => __('If fixed the persistent menu option should be turned OFF', 'hook'),
                        'options' => array(
                            'hook_regular_top' => __('Scrollable', 'hook'),
                            'hook_fixed_top' => __('Fixed position', 'hook')),
                        'default' => 'hook_regular_top',
                        'compiler' => 'true',
                    ),*/
                    array( 'id'=>'top_bar_height',
                        'type' => 'text',
                        'title' => __('Small bar height', 'hook'),
                        'subtitle' => __('In pixels.', 'hook'),
                        'desc' => __('', 'hook'),
                        'validate' => 'numeric',
                        'default' => '36',
                        'class' => 'small-text',
                        'required' => array('show_top_bar','equals','1')
                    ),
                    array(
                        'id'=>'top_bar_font_size',
                        'type' => 'slider',
                        'title' => __('Top bar font size', 'hook'),
                        'desc'=> __('Min: 8, max: 50', 'hook'),
                        "default"       => "11",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "50",
                        'required' => array('show_top_bar','equals','1')
                    ),
                    array(
                        'id'=>'active_color_header_bar',
                        'type' => 'color',
                        'title' => __('Small bar active text color', 'hook'),
                        'subtitle' => __('', 'hook'),
                        'default' => '#303030',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_top_bar','equals','1'),
                    ),
                    array(
                        'id'=>'body_color_header_bar',
                        'type' => 'color',
                        'title' => __('Small bar text color', 'hook'),
                        'subtitle' => __('', 'hook'),
                        'default' => '#a8a8a8',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_top_bar','equals','1'),
                    ),
                    array(
                        'id'=>'background_color_header_bar',
                        'type' => 'color',
                        'title' => __('Small bar background color', 'hook'),
                        'subtitle' => __('Optional', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_top_bar','equals','1'),
                    ),
                    array(
                        'id'=>'border_color_header_bar',
                        'type' => 'color',
                        'title' => __('Small bar border color', 'hook'),
                        'subtitle' => __('Optional', 'hook'),
                        'default' => '',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_top_bar','equals','1'),
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-list',
                'title' => esc_html__('Menu Section', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'backend_gn_logopa56',
                        'type' => 'info',
                        'desc' => esc_html__('Appearance', 'hook')
                    ),
                    array(
                        'id'=>'top_bar_limited_width',
                        'type' => 'switch',
                        'title' => esc_html__('Make header bar elements align with content?', 'hook'),
                        'subtitle'=> esc_html__('If NO they will stretch until the window width.', 'hook'),
                        "default"       => 0,
                    ),
                    array( 'id'=>'menu_vertical',
                        'type' => 'text',
                        'title' => esc_html__('Header bar height', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '92',
                        'class' => 'small-text',
                    ),
                    array(
                        'id'=>'background_color_menu_bar',
                        'type' => 'color',
                        'title' => esc_html__('Header bar background color', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'header_default_opacity',
                        'type' => 'slider',
                        'title' => esc_html__('Header bar background opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "0",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                    ),
                    array(
                        'id'=>'border_menu_bar',
                        'type' => 'color',
                        'title' => esc_html__('Header bar border color', 'hook'),
                        'subtitle' => esc_html__('Optional', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'border_default_opacity',
                        'type' => 'slider',
                        'title' => esc_html__('Header bar border opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "0",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                    ),
                    array( 'id'=>'menu_spacing',
                        'type' => 'slider',
                        'title' => esc_html__('Menu buttons character spacing', 'hook'),
                        'desc'=> esc_html__('Min: 1, max: 20', 'hook'),
                        "default"       => "1",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "20",
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_align',
                        'type' => 'select',
                        'title' => esc_html__('Menu position?', 'hook'),
                        'options' => array(
                            'st_menu_on_left' => esc_html__('Left', 'hook'),
                            'st_menu_on_center' => esc_html__('Center', 'hook'),
                            'st_menu_on_right' => esc_html__('Right', 'hook'),
                            'st_menu_under' => esc_html__('Under Logo', 'hook'),
                        ),
                        'default' => 'st_menu_on_right',
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'menu_position',
                        'type' => 'select',
                        'title' => esc_html__('Header bar display/position?', 'hook'),
                        'subtitle' => esc_html__('How the menu behaves when you scroll down.', 'hook'),
                        'options' => array(
                            'hook_fixed_mn' => esc_html__('Fixed', 'hook'),
                            'hook_absolute_mn' => esc_html__('Scrollable', 'hook'),
                        ),
                        'default' => 'hook_fixed_mn',
                        //'required' => array('menu_align','equals','st_menu_under')
                    ),
                    array(
                        'id'=>'menu_display',
                        'type' => 'select',
                        'title' => esc_html__('Menu display?', 'hook'),
                        'options' => array(
                            'st_regular_menu' => esc_html__('Regular', 'hook'),
                            'st_hidden_menu' => esc_html__('Hidden - "Hamburger" Menu button', 'hook'),
                            'st_without_menu' => esc_html__('Do not display any menu', 'hook'),
                        ),
                        'default' => 'st_regular_menu',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_hide_flag',
                        'type' => 'switch',
                        'title' => esc_html__('Menu hides after scrolling?', 'hook'),
                        "default"       => 1,
                    ),
                    array( 'id'=>'menu_hide_pixels',
                        'type' => 'text',
                        'title' => esc_html__('How many pixels before hiding menu?', 'hook'),
                        'validate' => 'numeric',
                        'default' => '110',
                        'class' => 'small-text',
                        'required' => array('menu_hide_flag','equals','1')
                    ),
                    array(
                        'id'=>'bk_color_menu_overlay',
                        'type' => 'color',
                        'title' => esc_html__('Menu overlay background color', 'hook'),
                        'subtitle' => esc_html__('Will be shown when the hidden menu is visible', 'hook'),
                        'default' => '#333038',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'opacity_menu_overlay',
                        'type' => 'slider',
                        'title' => esc_html__('Menu overlay opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "97",
                        "min"       => "0",
                        "step"      => "5",
                        "max"       => "100",
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'active_color_menu_overlay',
                        'type' => 'color',
                        'title' => esc_html__('Menu overlay active color', 'hook'),
                        'default' => '#000000',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'color_menu_overlay',
                        'type' => 'color',
                        'title' => esc_html__('Menu overlay up color color', 'hook'),
                        'default' => '#000000',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'overlay_align',
                        'type' => 'select',
                        'title' => esc_html__('Menu overlay text alignment?', 'hook'),
                        'subtitle' => esc_html__('Default value is centred.', 'hook'),
                        'options' => $align_array,
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'default' => 'hook_center_align',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'overlay_page_id',
                        'type' => 'select',
                        'data' => 'pages',
                        'title' => esc_html__('Append page to Menu Overlay?', 'hook'),
                        'subtitle' => esc_html__('If empty the theme Main Menu will be displayed.', 'hook'),
                        "default"       => '',
                        'required' => array('menu_display','equals','st_hidden_menu'),
                    ),
                    array(
                        'id'=>'overlay_footer_text',
                        'type' => 'editor',
                        'title' => esc_html__('Overlay footer text', 'hook'),
                        'subtitle' => esc_html__('Space is limited so use very few text.', 'hook'),
                        'default' => esc_html__('', 'hook'),
                        'editor_options'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 1,
                            'media_buttons'    => false,
                            'tinymce'          => false
                        ),
                        'required' => array('menu_display','equals','st_hidden_menu'),
                    ),
                    array(
                        'id'=>'top_search',
                        'type' => 'switch',
                        'title' => esc_html__('Append search icon to menu?', 'hook'),
                        'subtitle'=> esc_html__('Background color comes from the option "Content overlay background color" and text color comes from "Site background color"', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'backend_widgets_mainmenu_buttons',
                        'type' => 'info',
                        'desc' => esc_html__('Main menu: Parent buttons style', 'hook')
                    ),
                    array(
                        'id'=>'menu_parent_rollover',
                        'type' => 'select',
                        'title' => esc_html__('Parent menu buttons rollover style?', 'hook'),
                        'options' => array(
                            'with_lines' => esc_html__('Append lines and change color','hook'),
                            'with_color' => esc_html__('Change color','hook'),
                        ),
                        'default' => 'with_lines',
                        'compiler' => 'true',
                    ),
                    array(
                        'id'=>'menu_font',
                        'type' => 'select',
                        'title' => esc_html__('Menu buttons font face', 'hook'),
                        'desc' => esc_html__('Default value is Headings font', 'hook'),
                        'options' => array(
                            'header_font' => esc_html__('Headings font', 'hook'),
                            'body_font' => esc_html__('Body font', 'hook'),
                            'custom_font' => esc_html__('Extra font', 'hook')),
                        'default' => 'header_font',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_font_size',
                        'type' => 'slider',
                        'title' => esc_html__('Parent menu buttons font size (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 8, max: 60', 'hook'),
                        "default"       => "14",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "60",
                    ),
                    array(
                        'id'=>'menu_line_height',
                        'type' => 'slider',
                        'title' => esc_html__('Parent menu buttons line height', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        "default"       => "40",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "90",
                        'required' => array('menu_display','equals','st_hidden_menu'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_parent_style',
                        'type' => 'select',
                        'title' => esc_html__('Parent menu buttons font style?', 'hook'),
                        'options' => array(
                            'normal' => esc_html__('Normal','hook'),
                            'italic' => esc_html__('Italic','hook'),
                        ),
                        'default' => 'normal',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_font_weight',
                        'type' => 'select',
                        'title' => esc_html__('Parent menu buttons font weight?', 'hook'),
                        'subtitle' => esc_html__('Fonts usually support only certain sizes.', 'hook'),
                        'options' => array(
                            '100' => '100',
                            '200' => '200',
                            '300' => '300',
                            '400' => esc_html__('Normal','hook'),
                            '500' => '500',
                            '600' => '600',
                            '700' => esc_html__('Bold','hook'),
                            '900' => esc_html__('Bolder','hook')
                        ),
                        'default' => '600',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'labels_offset',
                        'type' => 'text',
                        'title' => esc_html__('Parent menu buttons top offset', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Useful to postion text vertically.', 'hook'),
                        "default"       => '0',
                    ),
                    array('id'=>'menu_padding',
                        'type' => 'slider',
                        'title' => esc_html__('Parent menu buttons horizontal padding (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 4, max: 20', 'hook'),
                        "default"   => "14",
                        "min"       => "2",
                        "step"      => "1",
                        "max"       => "50",
                    ),
                    array( 'id'=>'menu_active_color',
                        'type' => 'color',
                        'title' => esc_html__('Parent menu buttons active text color', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array( 'id'=>'menu_up_color',
                        'type' => 'color',
                        'title' => esc_html__('Parent menu buttons text color', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array('id'=>'active_subheadings',
                        'type' => 'switch',
                        'title' => esc_html__('Append sub-headings to parent menu buttons?', 'hook'),
                        'subtitle'=> esc_html__('Text is set under Appearance>Menus and it is the Title Attribute', 'hook'),
                        "default"       => 0,
                    ),
                    array('id'=>'menu_subheadings_style',
                        'type' => 'select',
                        'title' => esc_html__('Sub-headings menu buttons font style?', 'hook'),
                        'options' => array(
                            'normal' => esc_html__('Normal','hook'),
                            'italic' => esc_html__('Italic','hook')),
                        'default' => 'italic',
                        'compiler' => 'true',
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array('id'=>'subheadings_color',
                        'type' => 'color',
                        'title' => esc_html__('Sub-headings text color', 'hook'),
                        'default' => '#a8a8a8',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array('id'=>'subheadings_font_size',
                        'type' => 'slider',
                        'title' => esc_html__('Sub-headings font size (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 4, max: 20', 'hook'),
                        "default"       => "10",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "20",
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array('id'=>'subheadings_font_weight',
                        'type' => 'select',
                        'title' => esc_html__('Sub-headings buttons font weight?', 'hook'),
                        'subtitle' => esc_html__('Fonts usually support only certain sizes.', 'hook'),
                        'options' => array('100' => '100','200' => '200','300' => '300','400' => esc_html__('Normal','hook'),'500' => '500','600' => '600','700' => esc_html__('Bold','hook'),'900' => esc_html__('Bolder','hook')),
                        'default' => '400',
                        'compiler' => 'true',
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array('id'=>'subheadings_offset',
                        'type' => 'text',
                        'title' => esc_html__('Sub-headings top offset', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Useful to postion text vertically.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '36',
                        'class' => 'small-text',
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array('id'=>'subheadings_font',
                        'type' => 'select',
                        'title' => esc_html__('Sub-headings font face', 'hook'),
                        'desc' => esc_html__('Default value is Headings font', 'hook'),
                        'options' => array(
                            'header_font' => esc_html__('Headings font', 'hook'),
                            'body_font' => esc_html__('Body font', 'hook'),
                            'custom_font' => esc_html__('Extra font', 'hook')),
                        'default' => 'custom_font',
                        'compiler' => 'true',
                        'required' => array('active_subheadings','equals','1'),
                    ),
                    array(
                        'id'=>'backend_widgets_mirror_menu',
                        'type' => 'info',
                        'desc' => esc_html__('Main menu: After scroll & forced menu pages style', 'hook')
                    ),
                    array( 'id'=>'menu_collapse_flag',
                        'type' => 'switch',
                        'title' => esc_html__('Menu changes style after scrolling?', 'hook'),
                        "default"       => 1,
                    ),
                    array('id'=>'menu_collapse_pixels',
                        'type' => 'text',
                        'title' => esc_html__('How many pixels before changing style', 'hook'),
                        "default"       => '380',
                        'required' => array('menu_collapse_flag','equals','1'),
                    ),
                    array('id'=>'collapsed_menu_vertical',
                        'type' => 'text',
                        'title' => esc_html__('Menu height - after scroll', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Use the same value as the menu height (option above) to disable the menu collapse effect.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '72',
                        'class' => 'small-text',
                        'required' => array('menu_collapse_flag','equals','1')
                    ),
                    array(
                        'id'=>'background_color_menu_bar_after',
                        'type' => 'color',
                        'title' => esc_html__('Header bar background color - after scroll', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'header_opacity_after',
                        'type' => 'slider',
                        'title' => esc_html__('Menu background opacity - after scroll', 'hook'),
                        'subtitle' => esc_html__('After scroll, forced menu pages & mobile mode.', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "100",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                    ),
                    array(
                        'id'=>'border_menu_bar_after',
                        'type' => 'color',
                        'title' => esc_html__('Header bar border color - after scroll', 'hook'),
                        'subtitle' => esc_html__('Optional', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'border_opacity_after',
                        'type' => 'slider',
                        'title' => esc_html__('Header bar border opacity - after scroll', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "100",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                    ),
                    array( 'id'=>'menu_active_color_after',
                        'type' => 'color',
                        'title' => esc_html__('Menu active text color - after scroll', 'hook'),
                        'subtitle' => esc_html__('After scroll, forced menu pages & mobile mode.', 'hook'),
                        'default' => '#12b2cb',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array( 'id'=>'menu_up_color_after',
                        'type' => 'color',
                        'title' => esc_html__('Menu text color - after scroll', 'hook'),
                        'subtitle' => esc_html__('After scroll, forced menu pages & mobile mode.', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array('id'=>'backend_widgets_submenu_buttons',
                        'type' => 'info',
                        'desc' => esc_html__('Main menu: Sub-menu buttons style', 'hook')
                    ),
                    array('id'=>'submenu_font_size',
                        'type' => 'slider',
                        'title' => esc_html__('Sub-menu buttons font size (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 8, max: 50', 'hook'),
                        "default"       => "12",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "50",
                    ),
                    array(
                        'id'=>'submenu_font_weight',
                        'type' => 'select',
                        'title' => esc_html__('Sub-menu buttons font weight?', 'hook'),
                        'subtitle' => esc_html__('Fonts usually support only certain sizes.', 'hook'),
                        'options' => array('100' => '100','200' => '200','300' => '300','400' => esc_html__('Normal','hook'),'500' => '500','600' => '600','700' => esc_html__('Bold','hook'),'900' => esc_html__('Bolder','hook')),
                        'default' => '400',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'menu_sub_padding',
                        'type' => 'slider',
                        'title' => esc_html__('Sub-menu buttons height (in pixels)', 'hook'),
                        'desc'=> esc_html__('Min: 8, max: 60', 'hook'),
                        "default"       => "40",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "60",
                    ),
                    array( 'id'=>'submenu_active_color',
                        'type' => 'color',
                        'title' => esc_html__('Sub-menu buttons active text color', 'hook'),
                        'default' => '#12b2cb',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array( 'id'=>'submenu_text_color',
                        'type' => 'color',
                        'title' => esc_html__('Sub-menu buttons text color', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'submenu_lines_color',
                        'type' => 'color',
                        'title' => esc_html__('Sub-menu divider lines color', 'hook'),
                        'default' => '#212121',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'submenu_background_color',
                        'type' => 'color',
                        'title' => esc_html__('Submenu background color', 'hook'),
                        'subtitle' => esc_html__('Pick a background color for the sub-menus.', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'backend_widgets_top_bar',
                        'type' => 'info',
                        'desc' => esc_html__('Social networks links', 'hook')
                    ),
                    array(
                        'id'=>'network_icon_1',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 1', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_1',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 1 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'network_icon_2',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 2', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_2',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 2 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'network_icon_3',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 3', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_3',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 3 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'network_icon_4',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 4', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_4',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 4 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'network_icon_5',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 5', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_5',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 5 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'network_icon_6',
                        'type' => 'select',
                        'title' => esc_html__('Social Network 6', 'hook'),
                        'options' => $social_options,
                        'default' => ""
                    ),
                    array(
                        'id'=>'network_link_6',
                        'type' => 'text',
                        'title' => esc_html__('Social Network 6 Link', 'hook'),
                        'default' => "",
                    ),
                    array(
                        'id'=>'nets_offset',
                        'type' => 'text',
                        'title' => esc_html__('Social networks links top offset', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Useful to adjust links vertical position.', 'hook'),
                        "default"       => '-14',
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => esc_html__('Mobile Mode', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'backend_sdb_mobile',
                        'type' => 'info',
                        'desc' => __('Mobile mode features', 'hook')
                    ),
                    array(
                        'id'=>'resp_break',
                        'type' => 'text',
                        'title' => esc_html__('Minimum window width before activate mobile mode', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Mobile mode will always be activated on screens with less than 768px.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '900',
                        'class' => 'small-text'
                    ),
                    array(
                        'id'=>'css_enable',
                        'type' => 'switch',
                        'title' => __('Enable CSS animations for page elements on mobile devices?', 'hook'),
                        'subtitle'=> __('', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_sdb_mobile_menu',
                        'type' => 'info',
                        'desc' => __('Mobile Bar', 'hook')
                    ),
                    array(
                        'id'=>'menu_text',
                        'type' => 'text',
                        'title' => esc_html__('Logo bar menu help text', 'hook'),
                        'subtitle' => esc_html__('Optional', 'hook'),
                        'default' => esc_html__('MENU','hook'),
                    ),
                    array(
                        'id'=>'menu_text_only',
                        'type' => 'select',
                        'title' => esc_html__('Menu button display?', 'hook'),
                        'options' => array(
                            'only_text' => esc_html__('Show text only', 'hook'),
                            'text_and_icon' => esc_html__('Show menu icon and text', 'hook'),
                        ),
                        'required' => array('menu_text','not',''),
                        'default' => 'only_text',
                        'compiler' => 'true',
                    ),
                    array(
                        'id'=>'append_mobile_logo',
                        'type' => 'select',
                        'title' => esc_html__('Show logo on mobile hidden menu bar?', 'hook'),
                        'options' => array(
                            'no' => esc_html__('No', 'hook'),
                            'mobile_logo_bef' => esc_html__('Yes, logo before scroll', 'hook'),
                            'mobile_logo_aft' => esc_html__('Yes, logo after scroll', 'hook')
                        ),
                        'default' => 'mobile_logo_aft',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'right_bar_align',
                        'type' => 'select',
                        'title' => esc_html__('Mobile hidden menu bar text alignment?', 'hook'),
                        'subtitle' => esc_html__('Default value is left.', 'hook'),
                        'options' => $align_array,
                        'default' => 'hook_left_align',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'background_image_right_bar',
                        'type' => 'media',
                        'title' => esc_html__('Mobile hidden menu bar background image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Optional', 'hook'),
                    ),
                    array(
                        'id'=>'background_color_right_bar',
                        'type' => 'color',
                        'title' => esc_html__('Mobile hidden menu bar background color', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'active_color_right_bar',
                        'type' => 'color',
                        'title' => esc_html__('Mobile hidden menu bar active text color', 'hook'),
                        'default' => '#12b2cb',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'body_color_right_bar',
                        'type' => 'color',
                        'title' => esc_html__('Mobile hidden menu bar text color', 'hook'),
                        'default' => '#bbbbbb',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'opacity_mobile_overlay',
                        'type' => 'slider',
                        'title' => esc_html__('Content overlay opacity', 'hook'),
                        'subtitle' => esc_html__('Applicable only for when the hidden sidebar is visible.', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "75",
                        "min"       => "0",
                        "step"      => "5",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-indent-right',
                'title' => esc_html__('Hidden Sidebar', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'show_hidden_sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Show hidden sidebar?', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'sidebar_position',
                        'type' => 'select',
                        'title' => esc_html__('Sidebar position?', 'hook'),
                        'options' => array(
                            'st_sidebar_on_left' => esc_html__('Left', 'hook'),
                            'st_sidebar_on_right' => esc_html__('Right', 'hook')),
                        'default' => 'st_sidebar_on_right',
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'sidebar_text',
                        'type' => 'text',
                        'title' => esc_html__('Sidebar help text', 'hook'),
                        'subtitle' => esc_html__('Visible only if no menu is being displayed', 'hook'),
                        'default' => esc_html__('MENU','hook'),
                        'required' => array('show_hidden_sidebar','equals','1'),
                    ),
                    array(
                        'id'=>'menu_text_only_sb',
                        'type' => 'select',
                        'title' => esc_html__('Sidebar button display?', 'hook'),
                        'options' => array(
                            'only_text' => esc_html__('Show text only', 'hook'),
                            'text_and_icon' => esc_html__('Show icon and text', 'hook'),
                        ),
                        'required' => array('sidebar_text','not',''),
                        'default' => 'only_text',
                        'compiler' => 'true',
                    ),
                    array(
                        'id'=>'sidebar_width',
                        'type' => 'text',
                        'title' => esc_html__('Hidden bar width', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__('Default value is 380.', 'hook'),
                        'validate' => 'numeric',
                        'default' => '380',
                        'class' => 'small-text',
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'sidebar_align',
                        'type' => 'select',
                        'title' => esc_html__('Hidden sidebar text alignment?', 'hook'),
                        'subtitle' => esc_html__('Default value is centred.', 'hook'),
                        'options' => $align_array,
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'default' => 'hook_center_align',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'background_image_sidebar',
                        'type' => 'media',
                        'title' => esc_html__('Hidden sidebar background image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Optional', 'hook'),
                        'required' => array('show_hidden_sidebar','equals','1'),
                    ),
                    array(
                        'id'=>'background_color_sidebar',
                        'type' => 'color',
                        'title' => esc_html__('Hidden sidebar background color', 'hook'),
                        'default' => '#C0C0C0',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'active_color_sidebar',
                        'type' => 'color',
                        'title' => esc_html__('Hidden sidebar active text color', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'body_color_sidebar',
                        'type' => 'color',
                        'title' => esc_html__('Hidden sidebar text color', 'hook'),
                        'default' => '#AFAFAF',
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array('show_hidden_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'sidebar_footer_id',
                        'type' => 'select',
                        'data' => 'sidebars',
                        'title' => esc_html__('Extra sidebar ID', 'hook'),
                        'subtitle' => esc_html__('Sidebars can be created under Appearance>Manage Sidebars', 'hook'),
                        'desc' => esc_html__('This sidebar will be used as a footer.', 'hook'),
                        'required' => array('show_hidden_sidebar','equals','1'),
                    ),
                    array(
                        'id'=>'opacity_sidebar_overlay',
                        'type' => 'slider',
                        'title' => esc_html__('Content overlay opacity', 'hook'),
                        'subtitle' => esc_html__('Applicable only for when the hidden sidebar is visible.', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "25",
                        "min"       => "0",
                        "step"      => "5",
                        "max"       => "100",
                        'compiler' => 'true',
                        'required' => array('show_hidden_sidebar','equals','1'),
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-chevron-down',
                'title' => esc_html__('Persistent Menu', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'persistent_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Enable persistent menu on blog single posts', 'hook'),
                        'subtitle'=> esc_html__('', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'persistent_folio',
                        'type' => 'switch',
                        'title' => esc_html__('Enable persistent menu on portfolio single posts', 'hook'),
                        'subtitle'=> esc_html__('', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'background_color_prst',
                        'type' => 'color',
                        'title' => esc_html__('Persistent menu bar background color', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'default' => '#000000',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'body_color_prst',
                        'type' => 'color',
                        'title' => esc_html__('Persistent menu text color', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-fork',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Footer Section', 'hook'),
                'fields' => array(
                    array('id'=>'backend_widgets_foot654',
                        'type' => 'info',
                        'desc' => esc_html__('Appearance', 'hook')
                    ),
                    array(
                        'id'=>'use_footer',
                        'type' => 'switch',
                        'title' => esc_html__('Display footer?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'footer_reveal',
                        'type' => 'switch',
                        'title' => esc_html__('Make footer position fixed?', 'hook'),
                        'subtitle'=> esc_html__('If yes it will create a reveal effect on the footer.', 'hook'),
                        "default"       => 0,
                    ),
                    array('id'=>'footer_font_size',
                        'type' => 'slider',
                        'title' => esc_html__('Footer body font size', 'hook'),
                        'desc'=> esc_html__('Min: 6, max: 50', 'hook'),
                        "default"       => "13",
                        "min"       => "8",
                        "step"      => "1",
                        "max"       => "50",
                    ),
                    array('id'=>'backend_widgets_foot352',
                        'type' => 'info',
                        'desc' => esc_html__('Colors', 'hook')
                    ),
                    array(
                        'id'=>'titles_color_footer',
                        'type' => 'color',
                        'title' => esc_html__('Footer titles and links text color', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'body_color_footer',
                        'type' => 'color',
                        'title' => esc_html__('Footer text color', 'hook'),
                        'default' => '#808080',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'footer_border_color',
                        'type' => 'color',
                        'title' => esc_html__('Footer top border color', 'hook'),
                        'subtitle' => esc_html__('Leave blank for no border', 'hook'),
                        'default' => '',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'background_color_footer',
                        'type' => 'color',
                        'title' => esc_html__('Footer background color', 'hook'),
                        'default' => '#1b1b1b',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'bk_image_footer',
                        'type' => 'media',
                        'title' => esc_html__('Footer background image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Optional', 'hook'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'footer_image_align',
                        'type' => 'select',
                        'title' => esc_html__('Background image position', 'hook'),
                        'subtitle' => esc_html__('How the image will be aligned vertically', 'hook'),
                        'options' => array(
                            'top' => esc_html__('Top','hook'),
                            'center' => esc_html__('Center','hook'),
                            'bottom' => esc_html__('Bottom','hook'),
                        ),
                        'default' => 'center',
                        'required' => array('bk_image_footer','not',''),
                        'compiler' => 'true'
                    ),
                    array('id'=>'backend_widgets_foot985',
                        'type' => 'info',
                        'desc' => esc_html__('Content: Sidebar and page appending', 'hook')
                    ),
                    array(
                        'id'=>'bottom_page',
                        'type' => 'switch',
                        'title' => esc_html__('Add special page content before footer widgets?', 'hook'),
                        'subtitle'=> esc_html__('Create a specific page to be used here', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'bottom_page_id',
                        'type' => 'select',
                        'data' => 'pages',
                        'title' => esc_html__('Page to be displayed before footer widgets?', 'hook'),
                        'subtitle' => esc_html__('Content to be appended on the footer top section.', 'hook'),
                        "default"       => '',
                        'required' => array('bottom_page','equals','1'),
                    ),
                    array(
                        'id'=>'bottom_page_after',
                        'type' => 'switch',
                        'title' => esc_html__('Add special page content after footer widgets?', 'hook'),
                        'subtitle'=> esc_html__('Create a specific page to be used here', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'bottom_page_after_id',
                        'type' => 'select',
                        'data' => 'pages',
                        'title' => esc_html__('Page to be displayed after footer widgets?', 'hook'),
                        'subtitle' => esc_html__('Content to be appended on the footer top section.', 'hook'),
                        "default"       => '',
                        'required' => array('bottom_page_after','equals','1'),
                    ),
                    array(
                        'id'=>'bottom_sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display footer sidebar?', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'widgets_nr',
                        'type' => 'select',
                        'title' => esc_html__('Number of widgets per row?', 'hook'),
                        'subtitle' => esc_html__('Default value is Three.', 'hook'),
                        'options' => array(
                            'small-12' => esc_html__('One','hook'),
                            'small-6' => esc_html__('Two','hook'),
                            'small-4' => esc_html__('Three','hook'),
                            'small-3' => esc_html__('Four','hook'),
                            'small-2' => esc_html__('Six','hook'),
                        ),
                        'default' => 'small-3',
                        'required' => array('bottom_sidebar','equals','1'),
                        'compiler' => 'true'
                    ),
                    array('id'=>'backend_widgets_foot761',
                        'type' => 'info',
                        'desc' => esc_html__('Copyright area', 'hook')
                    ),
                    array(
                        'id'=>'footer_text_background_color',
                        'type' => 'color',
                        'title' => esc_html__('After footer text background color', 'hook'),
                        'default' => '#141414',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'footer_text',
                        'type' => 'editor',
                        'title' => esc_html__('After footer text (center or left aligned)', 'hook'),
                        'subtitle' => esc_html__('Space is limited so use very few text.', 'hook'),
                        'default' => esc_html__('WordPress Theme', 'hook'),
                        'editor_options'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 1,
                            'media_buttons'    => false,
                            'tinymce'          => false
                        )
                    ),
                    array(
                        'id'=>'footer_text_extra',
                        'type' => 'editor',
                        'title' => esc_html__('Extra after footer text (right aligned)', 'hook'),
                        'subtitle' => esc_html__('Space is limited so use very few text.', 'hook'),
                        'default' => esc_html__('Developed With Love', 'hook'),
                        'editor_options'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 1,
                            'media_buttons'    => false,
                            'tinymce'          => false
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-calendar',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Blog', 'hook'),
                'fields' => array(
                    array('id'=>'backend_widgets_blog654',
                        'type' => 'info',
                        'desc' => esc_html__('Appearance', 'hook')
                    ),
                    array(
                        'id'=>'archives_type',
                        'type' => 'select',
                        'title' => esc_html__('Blog archives page template?', 'hook'),
                        'options' => array(
                            'classic' => 'Classic - Big media with post information always visible',
                            'masonry' => 'Masonry - Mosaic with post information always visible',
                            'stacked' => 'Modern - Plain text with image reveal on rollover',
                        ),
                        'default' => 'masonry'
                    ),
                    array(
                        'id'=>'posts_bk_color',
                        'type' => 'color',
                        'title' => esc_html__('Posts box background color', 'hook'),
                        'subtitle' => esc_html__('Will be used on Masonry and Classic blog feeds', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array('id'=>'backend_widgets_blog862',
                        'type' => 'info',
                        'desc' => esc_html__('Thumbnails', 'hook')
                    ),
                    array( 'id'=>'thumbs_text_color_blog',
                        'type' => 'color',
                        'title' => esc_html__('Thumbnails text color - Blog', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'background_color_btns_blog',
                        'type' => 'color',
                        'title' => esc_html__('Thumbnails rollover background color', 'hook'),
                        'subtitle' => esc_html__('Posts with a featured color will override this option', 'hook'),
                        'default' => '#111111',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'custom_opacity',
                        'type' => 'slider',
                        'title' => esc_html__('Thumbnails rollover background opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "60",
                        "min"       => "0",
                        "step"      => "5",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                    array('id'=>'backend_widgets_blog111',
                        'type' => 'info',
                        'desc' => esc_html__('Single post options', 'hook')
                    ),
                    array(
                        'id'=>'custom_width_blog',
                        'type' => 'text',
                        'title' => esc_html__('Maximum blog content width', 'hook'),
                        'subtitle' => esc_html__('In pixels.', 'hook'),
                        'desc' => esc_html__("Will be applied only to blog posts that don't have a right sidebar.", 'hook'),
                        'validate' => 'numeric',
                        'default' => '1080',
                        'class' => 'small-text'
                    ),
                    array(
                        'id'=>'header_align_blog',
                        'type' => 'select',
                        'title' => esc_html__('Single posts default featured header text position', 'hook'),
                        'subtitle' => esc_html__('Applies only to posts with featured media', 'hook'),
                        'options' => array(
                            'topped_content' => esc_html__('Top','hook'),
                            'middled_content' => esc_html__('Middle','hook'),
                            'bottomed_content' => esc_html__('Bottom','hook')),
                        'default' => 'bottomed_content'
                    ),
                    array(
                        'id'=>'autoplay_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Play slideshow on single posts?', 'hook'),
                        "default"       => 1,
                    ),
                    array( 'id'=>'delay_blog',
                        'type' => 'text',
                        'title' => esc_html__('Slideshow delay in miliseconds', 'hook'),
                        'validate' => 'numeric',
                        'default' => '6500',
                        'class' => 'small-text'
                    ),
                    array(
                        'id'=>'uppercase_blog_headings',
                        'type' => 'switch',
                        'title' => esc_html__('Uppercase titles and filter labels?', 'hook'),
                        "default"       => 1,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'show_date_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Show dates on blog?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'postedby_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Posted by" text on blog?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'show_min_read',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Min Read" info on blog?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'categoriesby_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Show post categories text on blog?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'show_blog_nav',
                        'type' => 'switch',
                        'title' => esc_html__('Show previous and next posts link?', 'hook'),
                        'subtitle'=> esc_html__('Will be shown under the post content.', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'related_posts',
                        'type' => 'switch',
                        'title' => esc_html__('Show related posts?', 'hook'),
                        'subtitle'=> esc_html__('Will be shown under the post comments section.', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'related_author',
                        'type' => 'switch',
                        'title' => esc_html__('Show author info under post?', 'hook'),
                        'subtitle'=> esc_html__('Will be shown under the post content.', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'comments_bk_color',
                        'type' => 'color',
                        'title' => esc_html__('Comments background color', 'hook'),
                        'subtitle' => esc_html__('Optional - Will be set as the comments section background color', 'hook'),
                        'default' => '',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'backend_bl_sharing',
                        'type' => 'info',
                        'desc' => esc_html__('Social Sharing', 'hook')
                    ),
                    array(
                        'id'=>'share_blog',
                        'type' => 'switch',
                        'title' => esc_html__('Show sharing buttons?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'share_blog_fb',
                        'type' => 'checkbox',
                        'required' => array('share_blog','equals','1'),
                        'title' => esc_html__('Facebook', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_blog_goo',
                        'type' => 'checkbox',
                        'required' => array('share_blog','equals','1'),
                        'title' => esc_html__('Google +', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_blog_pin',
                        'type' => 'checkbox',
                        'required' => array('share_blog','equals','1'),
                        'title' => esc_html__('Pinterest', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_blog_twt',
                        'type' => 'checkbox',
                        'required' => array('share_blog','equals','1'),
                        'title' => esc_html__('Twitter', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_blog_email',
                        'type' => 'checkbox',
                        'required' => array('share_blog','equals','1'),
                        'title' => esc_html__('Email', 'hook'),
                        'default' => '0'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-camera',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Portfolio', 'hook'),
                'fields' => array(
                    array('id'=>'backend_widgets_folio654',
                        'type' => 'info',
                        'desc' => esc_html__('Archives', 'hook')
                    ),
                    array(
                        'id'=>'archives_ptype',
                        'type' => 'select',
                        'title' => esc_html__('Portfolio archives page template?', 'hook'),
                        'options' => array(
                            'grid' => esc_html__('Grid with horizontal rectangular images','hook'),
                            'grid_vertical' => esc_html__('Grid with vertical rectangular images','hook'),
                            'squares' => esc_html__('Grid with squared images','hook'),
                            'masonry' => esc_html__('Grid without image crop - Masonry','hook')
                        ),
                        'default' => 'grid'
                    ),
                    array('id'=>'backend_widgets_folio222',
                        'type' => 'info',
                        'desc' => esc_html__('Thumbnails', 'hook')
                    ),
                    array(
                        'id'=>'thumbs_text_color',
                        'type' => 'color',
                        'title' => esc_html__('Thumbnails text color - Portfolio', 'hook'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'thumbs_text_position',
                        'type' => 'select',
                        'title' => esc_html__('Thumbnails text position', 'hook'),
                        'options' => array(
                            'ct_ct' => esc_html__('Centered','hook'),
                            'lw_left' => esc_html__('Lower Left','hook'),
                            'lw_right' => esc_html__('Lower Right','hook'),
                            'tp_left' => esc_html__('Top Left','hook'),
                            'tp_right' => esc_html__('Top Right','hook'),
                        ),
                        'default' => 'ct_ct'
                    ),
                    array( 'id'=>'background_color_btns',
                        'type' => 'color',
                        'title' => esc_html__('Thumbnails rollover background color', 'hook'),
                        'subtitle' => esc_html__('Posts with a featured color will override this option', 'hook'),
                        'default' => '#111111',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'custom_opacity_folio',
                        'type' => 'slider',
                        'title' => esc_html__('Thumbnails rollover background opacity', 'hook'),
                        'desc'=> esc_html__('Min: 0, max: 100', 'hook'),
                        "default"       => "60",
                        "min"       => "0",
                        "step"      => "1",
                        "max"       => "100",
                        'compiler' => 'true'
                    ),
                    array( 'id'=>'thumbs_bg_size',
                        'type' => 'select',
                        'title' => esc_html__('Thumbnails rollover background size', 'hook'),
                        'default' => '#111111',
                        'options' => array(
                            'full_ths' => esc_html__('Full - background covers thumbnail','hook'),
                            'border_ths' => esc_html__('Bordered - background has 12px of border','hook'),
                        ),
                        'default' => 'full_ths',
                    ),
                    array('id'=>'backend_widgets_folio333',
                        'type' => 'info',
                        'desc' => esc_html__('Single post options', 'hook')
                    ),
                    array(
                        'id'=>'portfolio_layout',
                        'type' => 'select',
                        'title' => esc_html__('Default single posts layout', 'hook'),
                        'subtitle' => esc_html__('Can be overriden individually for each post', 'hook'),
                        'options' => array(
                            'half' => esc_html__('Half','hook'),
                            'wide' => esc_html__('Wide','hook'),
                            'wideout' => esc_html__('Full width','hook'),
                            'custom' => esc_html__('Custom layout','hook'),
                        ),
                        'default' => 'half',
                    ),
                    array(
                        'id'=>'autoplay_portfolio',
                        'type' => 'switch',
                        'title' => esc_html__('Play slideshow on single posts?', 'hook'),
                        'subtitle'=> esc_html__('Applicable only for posts with wide and half layout', 'hook'),
                        "default"       => 1,
                    ),
                    array( 'id'=>'delay_portfolio',
                        'type' => 'text',
                        'title' => esc_html__('Slideshow delay in miliseconds', 'hook'),
                        'subtitle' => esc_html__('Applicable only for posts with wide and half layout layout', 'hook'),
                        'validate' => 'numeric',
                        'default' => '6500',
                        'class' => 'small-text'
                    ),
                    array(
                        'id'=>'uppercase_folio_headings',
                        'type' => 'switch',
                        'title' => esc_html__('Uppercase titles?', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'dateby_port',
                        'type' => 'switch',
                        'title' => esc_html__('Show date on single post entries?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'categoriesby_port',
                        'type' => 'switch',
                        'title' => esc_html__('Show skills on single post entries?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'load_all',
                        'type' => 'switch',
                        'title' => esc_html__('Load all portfolio entries when skills filter is clicked?', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'port_with_description',
                        'type' => 'switch',
                        'title' => esc_html__('Show single image title and description on single portfolio pages?', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'show_port_nav',
                        'type' => 'switch',
                        'title' => esc_html__('Show previous and next posts link?', 'hook'),
                        'subtitle'=> esc_html__('Will be shown under the post content.', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'port_nav_logic',
                        'type' => 'switch',
                        'title' => esc_html__('Navigate within the same skill/category?', 'hook'),
                        'subtitle'=> esc_html__('If ON previous and next posts link will show only posts with at least one common skill/category', 'hook'),
                        "default"       => 1,
                        'required' => array('show_port_nav','equals','1'),
                    ),
                    array(
                        'id'=>'related_port',
                        'type' => 'switch',
                        'title' => esc_html__('Show related projects in single post pages?', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'related_info',
                        'type' => 'select',
                        'title' => esc_html__('Related projects information display', 'hook'),
                        'options' => array(
                            'folio_title_and_skills' => esc_html__('On rollover - Title and skills','hook'),
                            'folio_title_only' => esc_html__('On rollover - Title only','hook'),
                            'folio_always_title_and_skills hk_ins' => 'Always show inside thumb - Title and skills',
                            'folio_always_title_only hk_ins' => 'Always show inside thumb - Title only',
                            'folio_always_title_and_skills' => esc_html__('Always show under thumb - Title and skills','hook'),
                            'folio_always_title_only' => esc_html__('Always show under thumb - Title only','hook'),
                            'folio_noinfo' => esc_html__("Don't show anything",'hook'),
                        ),
                        'default' => 'folio_always_title_and_skills hk_ins'
                    ),
                    array(
                        'id'=>'port_resp_order',
                        'type' => 'switch',
                        'title' => __('Show title and post content before media on split layout?', 'hook'),
                        'subtitle'=> __('Mobile mode only', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'footer_port',
                        'type' => 'switch',
                        'title' => esc_html__('Show footer on single portfolio posts?', 'hook'),
                        'subtitle'=> esc_html__('', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'backend_lb_overlayer',
                        'type' => 'info',
                        'desc' => esc_html__('Overlayer: Will be shown above the content when a portfolio thumb is clicked', 'hook')
                    ),
                    array(
                        'id'=>'background_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer background color', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'active_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer active text color', 'hook'),
                        'default' => '#d92f3a',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'headings_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer headings color', 'hook'),
                        'default' => '#000000',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'smallers_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer small headings text color', 'hook'),
                        'default' => '#3e3e3e',
                        'validate' => 'color',
                        'transparent' => false,
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'body_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer body text color', 'hook'),
                        'default' => '#808080',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'lines_color_overlayer',
                        'type' => 'color',
                        'title' => esc_html__('Overlayer divider lines color', 'hook'),
                        'default' => '#e2e2e2',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'backend_lb_share_folio',
                        'type' => 'info',
                        'desc' => esc_html__('Social Sharing', 'hook')
                    ),
                    array(
                        'id'=>'share_portfolio',
                        'type' => 'switch',
                        'title' => esc_html__('Show sharing buttons?', 'hook'),
                        "default"       => 1,
                    ),
                    array(
                        'id'=>'share_portfolio_fb',
                        'type' => 'checkbox',
                        'required' => array('share_portfolio','equals','1'),
                        'title' => esc_html__('Facebook', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_portfolio_goo',
                        'type' => 'checkbox',
                        'required' => array('share_portfolio','equals','1'),
                        'title' => esc_html__('Google +', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_portfolio_pin',
                        'type' => 'checkbox',
                        'required' => array('share_portfolio','equals','1'),
                        'title' => esc_html__('Pinterest', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_portfolio_twt',
                        'type' => 'checkbox',
                        'required' => array('share_portfolio','equals','1'),
                        'title' => esc_html__('Twitter', 'hook'),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'share_portfolio_email',
                        'type' => 'checkbox',
                        'required' => array('share_portfolio','equals','1'),
                        'title' => esc_html__('Email', 'hook'),
                        'default' => '0'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-lines',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Quick Portfolio', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'backend_lb_overf',
                        'type' => 'info',
                        'desc' => esc_html__("This section is triggered by a menu button. Activate it under Appearance>Menus and select the option 'Show all work' trigger for the appropriate button.", 'hook')
                    ),
                    array(
                        'id'=>'background_color_overf',
                        'type' => 'color',
                        'title' => esc_html__('Portfolio Overlay background color', 'hook'),
                        'default' => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id'=>'overf_skills',
                        'type' => 'select',
                        'data' => 'categories',
                        'args' => array('taxonomy' => array('pirenko_skills')),
                        'title' => esc_html__('Portfolio skills filter', 'hook'),
                        'subtitle' => esc_html__('If empty all portfolio entries will be displayed.', 'hook'),
                        'multi' => true,
                        "default"       => '',
                    ),
                    array(
                        'id'=>'overf_layout',
                        'type' => 'select',
                        'title' => esc_html__('Thumbnails grid type', 'hook'),
                        'options' => array(
                            'grid' => esc_html__('Grid with horizontal rectangular images','hook'),
                            'grid_vertical' => esc_html__('Grid with vertical rectangular images','hook'),
                            'squares' => esc_html__('Grid with squared images','hook'),
                            'masonry' => esc_html__('Grid without image crop - Masonry','hook'),
                            'packery' => esc_html__('Grid - Multi-width','hook'),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id'=>'overf_columns',
                        'type' => 'text',
                        'title' => esc_html__('Number of columns', 'hook'),
                        'subtitle' => esc_html__('Numeric values only.', 'hook'),
                        'desc' => esc_html__('Use 0 for variable number', 'hook'),
                        'validate' => 'numeric',
                        'default' => '3',
                        'class' => 'small-text',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'overf_margin',
                        'type' => 'text',
                        'title' => esc_html__('Thumbnails margin', 'hook'),
                        'subtitle' => esc_html__('Numeric values only.', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'validate' => 'numeric',
                        'default' => '0',
                        'class' => 'small-text',
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'overf_click',
                        'type' => 'select',
                        'title' => esc_html__('Thumbnails click behavior', 'hook'),
                        'options' => array(
                            'overlayed' => esc_html__('Show project with an overlay and hide page content','hook'),
                            'lightboxed' => esc_html__('Open lightbox','hook'),
                            'classiqued' => esc_html__('Open project on a different page','hook'),
                        ),
                        'default' => 'classiqued'
                    ),
                    array(
                        'id'=>'overf_colored',
                        'type' => 'switch',
                        'title' => esc_html__('Multi-colored thumbs on rollover?', 'hook'),
                        'subtitle'=> esc_html__('If YES the portfolio featured color will be applied to each thumb.', 'hook'),
                        "default"       => 0,
                    ),
                    array(
                        'id'=>'overf_info',
                        'type' => 'select',
                        'title' => esc_html__('Project information display', 'hook'),
                        'options' => array(
                            'folio_title_and_skills' => esc_html__('On rollover - Title and skills','hook'),
                            'folio_title_only' => esc_html__('On rollover - Title only','hook'),
                            'folio_always_title_and_skills hk_ins' => 'Always show inside thumb - Title and skills',
                            'folio_always_title_only hk_ins' => 'Always show inside thumb - Title only',
                            'folio_always_title_and_skills' => esc_html__('Always show under thumb - Title and skills','hook'),
                            'folio_always_title_only' => esc_html__('Always show under thumb - Title only','hook'),
                            'folio_noinfo' => esc_html__("Don't show anything",'hook'),
                        ),
                        'default' => 'folio_title_and_skills'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-search',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Search Results', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'search_image',
                        'type' => 'media',
                        'title' => esc_html__('Header image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Optional', 'hook'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'search_layout',
                        'type' => 'select',
                        'title' => esc_html__('General display', 'hook'),
                        'options' => array(
                            'classic' => 'Classic',
                            'masonry' => 'Masonry',
                        ),
                        'default' => 'masonry'
                    ),
                    array(
                        'id'=>'search_right_sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display right sidebar on search page?', 'hook'),
                        "default"       => 0,
                        'compiler' => 'true'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-error',
                'icon_class' => 'icon-large',
                'title' => esc_html__('404 Error Page', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'error_image',
                        'type' => 'media',
                        'title' => esc_html__('Header image', 'hook'),
                        'compiler' => 'true',
                        'default'=> array(
                            'url'=>'',
                            'id'=>'',
                            'width'=>'',
                            'height'=>'',
                        ),
                        'desc'=> esc_html__('Optional', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id'=>'search_color',
                        'type' => 'color',
                        'title' => esc_html__('Heading text color', 'hook'),
                        'default' => '',
                        'validate' => 'color',
                        'transparent' => false,
                        'subtitle' => esc_html__('Optional', 'hook'),
                    ),
                    array(
                        'id'=>'404_search',
                        'type' => 'select',
                        'title' => esc_html__('Append element to 404 page?', 'hook'),
                        'subtitle'=> esc_html__('', 'hook'),
                        "default"       => 'back_button',
                        'options' => array(
                            'no' => 'No',
                            'search_field' => 'Search field',
                            'back_button' => 'Back to homepage button',
                        ),
                        'compiler' => 'true',
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-map-marker',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Google Maps API', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'google_maps_key',
                        'type' => 'text',
                        'title' => esc_html__('Google API Key', 'hook'),
                        'subtitle' => esc_html__('More info here https://developers.google.com/maps/pricing-and-plans/standard-plan-2016-update', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'default' => '',
                        'class' => ''
                    ),
                )
            );
            $hook_html=array('a' => array('href' => array(),'title' => array(),'style'=>array()),'p' => array('style'=>array()),'br' => array('style'=>array()),'em' => array('style'=>array()),'strong' => array('style'=>array()));
            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Translations', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'theme_translation',
                        'type' => 'switch',
                        'title' => esc_html__('Translate using .mo files?', 'hook'),
                        'subtitle'=> wp_kses('If ON the options below will be ignored.<br />If the WPML plugin is active the values below will be overriden too. WPML is a premium plugin that can be downloaded <a href="'.get_admin_url().'plugin-install.php?tab=commercial">here</a>.', $hook_html),
                        "default" => 0,
                    ),
                    array(
                        'id'=>'backend_tr_general',
                        'type' => 'info',
                        'desc' => esc_html__('General', 'hook')
                    ),
                    array(
                        'id'=>'theme_divider',
                        'type' => 'text',
                        'title' => esc_html__('Text separator', 'hook'),
                        'subtitle' => esc_html__('Used on multiple parts of the theme to divide pieces of text', 'hook'),
                        'default' => esc_html__('-','hook')
                    ),
                    array(
                        'id'=>'search_tip_text',
                        'type' => 'text',
                        'title' => esc_html__('Search field tip text', 'hook'),
                        'default' => esc_html__('Type and hit ENTER','hook')
                    ),
                    array(
                        'id'=>'submit_search_res_title',
                        'type' => 'text',
                        'title' => esc_html__('Search results page title text', 'hook'),
                        'default' => esc_html__('Search Results for', 'hook')
                    ),
                    array(
                        'id'=>'submit_search_no_results',
                        'type' => 'text',
                        'title' => esc_html__('Search results - no results found text', 'hook'),
                        'default' => esc_html__('No Results Found for', 'hook')
                    ),
                    array(
                        'id'=>'previous_text',
                        'type' => 'text',
                        'title' => esc_html__('Previous entries text', 'hook'),
                        'subtitle' => esc_html__('Will be used on navigation buttons', 'hook'),
                        'default' => esc_html__('Previous','hook')
                    ),
                    array(
                        'id'=>'next_text',
                        'type' => 'text',
                        'title' => esc_html__('Next entries text', 'hook'),
                        'subtitle' => esc_html__('Will be used on navigation buttons', 'hook'),
                        'default' => esc_html__('Next','hook')
                    ),
                    array(
                        'id'=>'lightbox_text',
                        'type' => 'text',
                        'title' => esc_html__('Lightbox - slide numbers divider text', 'hook'),
                        'subtitle' => esc_html__('Example: 2 of 9', 'hook'),
                        'default' => esc_html__('of','hook')
                    ),
                    array(
                        'id'=>'required_text',
                        'type' => 'text',
                        'title' => esc_html__('Required text', 'hook'),
                        'subtitle' => esc_html__('Used on mandatory fields.', 'hook'),
                        'default' => esc_html__(' (required)', 'hook')
                    ),
                    array(
                        'id'=>'profile_text',
                        'type' => 'text',
                        'title' => esc_html__('Members view profile link text', 'hook'),
                        'subtitle' => esc_html__('Shown under each member image and description', 'hook'),
                        'default' => esc_html__('View Profile', 'hook'),
                    ),
                    array(
                        'id'=>'in_touch_text',
                        'type' => 'text',
                        'title' => esc_html__('Get in touch text', 'hook'),
                        'subtitle' => esc_html__('Used near team member social network buttons.', 'hook'),
                        'default' => esc_html__('Get In touch', 'hook')
                    ),
                    array(
                        'id'=>'backend_tr_share_page',
                        'type' => 'info',
                        'desc' => esc_html__('Social Sharing', 'hook')
                    ),
                    array(
                        'id'=>'twitter_text',
                        'type' => 'text',
                        'title' => esc_html__('Twitter share text', 'hook'),
                        'default' => esc_html__('Tweet','hook')
                    ),
                    array(
                        'id'=>'facebook_text',
                        'type' => 'textarea',
                        'title' => esc_html__('Facebook share text', 'hook'),
                        'validate' => 'html',
                        'default' => esc_html__('Share','hook')
                    ),
                    array(
                        'id'=>'google_text',
                        'type' => 'textarea',
                        'title' => esc_html__('Google+ share text', 'hook'),
                        'validate' => 'html',
                        'default' => esc_html__('+1','hook')
                    ),
                    array(
                        'id'=>'pinterest_text',
                        'type' => 'textarea',
                        'title' => esc_html__('Pinterest share text', 'hook'),
                        'validate' => 'html',
                        'default' => esc_html__('Pin It','hook')
                    ),
                    array(
                        'id'=>'backend_tr_error_page',
                        'type' => 'info',
                        'desc' => esc_html__('404 Error Page', 'hook')
                    ),
                    array(
                        'id'=>'404_title_text',
                        'type' => 'text',
                        'title' => esc_html__('Page title text', 'hook'),
                        'default' => esc_html__('PAGE NOT FOUND','hook')
                    ),
                    array(
                        'id'=>'404_body_text',
                        'type' => 'textarea',
                        'title' => esc_html__('Page body text', 'hook'),
                        'validate' => 'html',
                        'default' => esc_html__('Ooops... Something went terribly wrong!','hook')
                    ),
                    array(
                        'id'=>'404_button_text',
                        'type' => 'textarea',
                        'title' => esc_html__('Back to homepage button text', 'hook'),
                        'validate' => 'html',
                        'default' => esc_html__('BACK TO HOMEPAGE','hook')
                    ),
                    array(
                        'id'=>'backend_tr_blog',
                        'type' => 'info',
                        'desc' => esc_html__('Blog', 'hook')
                    ),
                    array(
                        'id'=>'read_more',
                        'type' => 'text',
                        'title' => esc_html__('Read more button text', 'hook'),
                        'default' => esc_html__('Read More', 'hook')
                    ),
                    array(
                        'id'=>'sticky_text',
                        'type' => 'text',
                        'title' => esc_html__('Sticky post text', 'hook'),
                        'default' => esc_html__('Sticky Post', 'hook')
                    ),
                    array(
                        'id'=>'min_read_text',
                        'type' => 'text',
                        'title' => esc_html__('Minutes read text', 'hook'),
                        'default' => esc_html__('MIN READ', 'hook')
                    ),
                    array(
                        'id'=>'posted_by_text',
                        'type' => 'text',
                        'title' => esc_html__('Posted by text', 'hook'),
                        'default' => esc_html__('Posted by', 'hook')
                    ),
                    array(
                        'id'=>'on_text',
                        'type' => 'text',
                        'title' => esc_html__('On text', 'hook'),
                        'subtitle' => esc_html__('Will be used on some blog sentences.', 'hook'),
                        'desc' => esc_html__('Posted on Jan 13th.', 'hook'),
                        'default' => esc_html__('on','hook')
                    ),
                    array(
                        'id'=>'about_author_text',
                        'type' => 'text',
                        'title' => esc_html__('About text', 'hook'),
                        'subtitle' => esc_html__('Displayed before post author name.', 'hook'),
                        'default' => esc_html__('About', 'hook')
                    ),
                    array(
                        'id'=>'to_blog',
                        'type' => 'text',
                        'title' => esc_html__('Back to Blog button text', 'hook'),
                        'default' => esc_html__('BACK TO BLOG', 'hook')
                    ),
                    array(
                        'id'=>'older',
                        'type' => 'text',
                        'title' => esc_html__('Older posts text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on parent blog pages.', 'hook'),
                        'default' => esc_html__('Older posts', 'hook')
                    ),
                    array(
                        'id'=>'newer',
                        'type' => 'text',
                        'title' => esc_html__('Newer posts text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on parent blog pages.', 'hook'),
                        'default' => esc_html__('Newer posts', 'hook')
                    ),
                    array(
                        'id'=>'related_posts_text',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - related posts text', 'hook'),
                        'default' => esc_html__('Related News', 'hook')
                    ),
                    array(
                        'id'=>'related_posts_teaser_text',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - related posts sub-heading text', 'hook'),
                        'default' => esc_html__('Other posts that you should not miss.', 'hook')
                    ),
                    array(
                        'id'=>'older_single',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - previous post text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on single post pages.', 'hook'),
                        'default' => esc_html__('&larr; PREVIOUS POST', 'hook')
                    ),
                    array(
                        'id'=>'newer_single',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - next post text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on single post pages.', 'hook'),
                        'default' => esc_html__('NEXT POST &rarr;', 'hook')
                    ),
                    array(
                        'id'=>'all_the_posts',
                        'type' => 'text',
                        'title' => esc_html__('Archives pages', 'hook'),
                        'subtitle' => esc_html__('Subheading text', 'hook'),
                        'default' => esc_html__('All the posts published.', 'hook')
                    ),
                    array(
                        'id'=>'backend_tr_portfolio',
                        'type' => 'info',
                        'desc' => esc_html__('Portfolio', 'hook')
                    ),
                    array(
                        'id'=>'prj_desc_text',
                        'type' => 'text',
                        'title' => esc_html__('Project description text', 'hook'),
                        'subtitle' => esc_html__('Will be displayed just above the project text.', 'hook'),
                        'default' => esc_html__('About this project','hook')
                    ),
                    array(
                        'id'=>'date_text',
                        'type' => 'text',
                        'title' => esc_html__('Date text', 'hook'),
                        'default' => esc_html__('Date','hook')
                    ),
                    array(
                        'id'=>'client_text',
                        'type' => 'text',
                        'title' => esc_html__('Client description text', 'hook'),
                        'default' => esc_html__('Client','hook')
                    ),
                    array(
                        'id'=>'extra_fld1',
                        'type' => 'text',
                        'title' => esc_html__('Extra field 1 - Description text', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'default' => esc_html__('My Custom Field 1','hook')
                    ),
                    array(
                        'id'=>'extra_fld2',
                        'type' => 'text',
                        'title' => esc_html__('Extra field 2 - Description text', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'default' => esc_html__('My Custom Field 2','hook')
                    ),
                    array(
                        'id'=>'extra_fld3',
                        'type' => 'text',
                        'title' => esc_html__('Extra field 3 - Description text', 'hook'),
                        'subtitle' => esc_html__('', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'default' => esc_html__('My Custom Field 3','hook')
                    ),
                    array(
                        'id'=>'skills_text',
                        'type' => 'text',
                        'title' => esc_html__('Category description text', 'hook'),
                        'default' => esc_html__('Skills','hook')
                    ),
                    array(
                        'id'=>'tags_text',
                        'type' => 'text',
                        'title' => esc_html__('Tag description text', 'hook'),
                        'default' => esc_html__('Tags','hook')
                    ),
                    array(
                        'id'=>'project_text',
                        'type' => 'text',
                        'title' => esc_html__('Project link header text', 'hook'),
                        'default' => esc_html__('Project URL','hook')
                    ),
                    array(
                        'id'=>'launch_text',
                        'type' => 'text',
                        'title' => esc_html__('Project link button text', 'hook'),
                        'default' => esc_html__('Launch Project','hook')
                    ),
                    array(
                        'id'=>'all_text',
                        'type' => 'text',
                        'title' => esc_html__('Show All text', 'hook'),
                        'subtitle' => esc_html__('Used on filters. Will show all posts on current page.', 'hook'),
                        'default' => esc_html__('Show All', 'hook')
                    ),
                    array(
                        'id'=>'load_more',
                        'type' => 'text',
                        'title' => esc_html__('Load more posts text', 'hook'),
                        'subtitle' => esc_html__('Will be shown under the posts grid.', 'hook'),
                        'default' => esc_html__('LOAD MORE POSTS', 'hook')
                    ),
                    array(
                        'id'=>'no_more',
                        'type' => 'text',
                        'title' => esc_html__('No more posts to show text', 'hook'),
                        'subtitle' => esc_html__('Will be shown under the posts grid.', 'hook'),
                        'default' => esc_html__('NO MORE POSTS TO SHOW', 'hook')
                    ),
                    array(
                        'id'=>'related_prj_text',
                        'type' => 'text',
                        'title' => esc_html__('Related projects text', 'hook'),
                        'default' => esc_html__('Related Projects', 'hook')
                    ),
                    array(
                        'id'=>'related_prj_teaser_text',
                        'type' => 'text',
                        'title' => esc_html__('Related projects sub-heading text', 'hook'),
                        'default' => esc_html__('Simply delivering amazing stuff. Period.', 'hook')
                    ),
                    array(
                        'id'=>'to_portfolio',
                        'type' => 'text',
                        'title' => esc_html__('Back to Portfolio button text', 'hook'),
                        'default' => esc_html__('BACK TO PORTFOLIO', 'hook')
                    ),
                    array(
                        'id'=>'prj_prev_text',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - previous post text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on single post pages.', 'hook'),
                        'default' => esc_html__('PREVIOUS PROJECT', 'hook')
                    ),
                    array(
                        'id'=>'prj_next_text',
                        'type' => 'text',
                        'title' => esc_html__('Single posts pages - next post text', 'hook'),
                        'subtitle' => esc_html__('Used for navigation on single post pages.', 'hook'),
                        'default' => esc_html__('NEXT PROJECT', 'hook')
                    ),
                    array(
                        'id'=>'all_the_portfolios',
                        'type' => 'text',
                        'title' => esc_html__('Archives pages', 'hook'),
                        'subtitle' => esc_html__('Subheading text', 'hook'),
                        'default' => esc_html__('All the work completed.', 'hook')
                    ),
                    array(
                        'id'=>'backend_tr_comments',
                        'type' => 'info',
                        'desc' => esc_html__('Comments Section', 'hook')
                    ),
                    array(
                        'id'=>'comments_label', 'type' => 'text',
                        'title' => esc_html__('Comments title text', 'hook'),
                        'default' => esc_html__('Comments', 'hook')
                    ),
                    array(
                        'id'=>'comments_no_response',
                        'type' => 'text',
                        'title' => esc_html__('Zero comments text', 'hook'),
                        'default' => esc_html__('No comments', 'hook')
                    ),
                    array(
                        'id'=>'comments_one_response',
                        'type' => 'text',
                        'title' => esc_html__('One comment text', 'hook'),
                        'default' => esc_html__('1 Comment', 'hook')
                    ),
                    array(
                        'id'=>'comments_oneplus_response',
                        'type' => 'text',
                        'title' => esc_html__('Multiple comments text', 'hook'),
                        'default' => esc_html__('Comments', 'hook')
                    ),
                    array(
                        'id'=>'backend_tr_respond',
                        'type' => 'info',
                        'desc' => esc_html__('Respond Section', 'hook')
                    ),
                    array(
                        'id'=>'reply_text',
                        'type' => 'text',
                        'title' => esc_html__('Reply text', 'hook'),
                        'subtitle' => esc_html__('Used on buttons.', 'hook'),
                        'default' => esc_html__('Reply', 'hook')
                    ),
                    array(
                        'id'=>'comments_leave_reply',
                        'type' => 'text',
                        'title' => esc_html__('Text to ask the user to leave a reply', 'hook'),
                        'default' => esc_html__('Leave a Comment', 'hook')
                    ),
                    array(
                        'id'=>'comments_under_reply',
                        'type' => 'text',
                        'title' => esc_html__('Compementary text shown under the leave a reply text', 'hook'),
                        'default' => esc_html__('Your feedback is valuable for us. Your email will not be published.', 'hook')
                    ),
                    array(
                        'id'=>'comments_author_text',
                        'type' => 'text',
                        'title' => esc_html__('Name input field text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside the author input textfield.', 'hook'),
                        'default' => esc_html__('Name', 'hook')
                    ),
                    array(
                        'id'=>'comments_email_text',
                        'type' => 'text',
                        'title' => esc_html__('Email input field text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside the email input textfield.', 'hook'),
                        'default' => esc_html__('Email', 'hook')
                    ),
                    array(
                        'id'=>'comments_url_text',
                        'type' => 'text',
                        'title' => esc_html__('URL input field text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside the URL input textfield.', 'hook'),
                        'default' => esc_html__('Website', 'hook')
                    ),
                    array(
                        'id'=>'comments_comment_text',
                        'type' => 'text',
                        'title' => esc_html__('Comment input textarea text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside the comment input textarea.', 'hook'),
                        'default' => esc_html__('Your comment', 'hook')
                    ),
                    array(
                        'id'=>'comments_submit',
                        'type' => 'text',
                        'title' => esc_html__('Submit comment button text', 'hook'),
                        'default' => esc_html__('Submit Comment', 'hook')
                    ),
                    array(
                        'id'=>'empty_text_error',
                        'type' => 'text',
                        'title' => esc_html__('Empty text error message', 'hook'),
                        'default' => esc_html__('Error! This field is required.', 'hook')
                    ),
                    array(
                        'id'=>'invalid_email_error',
                        'type' => 'text',
                        'title' => esc_html__('Invalid email error message', 'hook'),
                        'default' => esc_html__('Error! Invalid email.', 'hook')
                    ),
                    array( 'id'=>'comment_ok_message',
                        'type' => 'text',
                        'title' => esc_html__('Comment submitted text', 'hook'),
                        'subtitle' => esc_html__('This text is displayed after the comment is submitted.', 'hook'),
                        'default' => esc_html__('Thank you for your feedback!', 'hook')
                    ),
                    array(
                        'id'=>'backend_tr_respond',
                        'type' => 'info',
                        'desc' => esc_html__('Contact Page', 'hook')
                    ),
                    array(
                        'id'=>'contact_subject_text',
                        'type' => 'text',
                        'title' => esc_html__('Subject help text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside of the subject input textfield. The name and email fields are the same as defined before for the comments section.', 'hook'),
                        'default' => esc_html__('Subject', 'hook')
                    ),
                    array(
                        'id'=>'contact_message_text',
                        'type' => 'text', 'title' => esc_html__('Message help text', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed inside of the message input textfield.', 'hook'),
                        'default' => esc_html__('Your message', 'hook')
                    ),
                    array(
                        'id'=>'contact_submit',
                        'type' => 'text', 'title' => esc_html__('Submit button text', 'hook'),
                        'default' => esc_html__('Send Message','hook')
                    ),
                    array(
                        'id'=>'contact_error_text',
                        'type' => 'text',
                        'title' => esc_html__('Error message for empty field', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed when a mandatory input field is empty.', 'hook'),
                        'default' => esc_html__('Error! This field is required.', 'hook')
                    ),
                    array(
                        'id'=>'contact_error_email_text',
                        'type' => 'text',
                        'title' => esc_html__('Error message for invalid email', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed when the entered email is invalid.', 'hook'),
                        'default' => esc_html__('Error! This email is not valid.', 'hook')
                    ),
                    array(
                        'id'=>'contact_wait_text',
                        'type' => 'text',
                        'title' => esc_html__('Form submission: Wait message', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed right after the send message button is clicked and only until the email is sent.', 'hook'),
                        'default' => esc_html__('Please wait...', 'hook')
                    ),
                    array(
                        'id'=>'contact_ok_text',
                        'type' => 'text',
                        'title' => esc_html__('Form submission: Ok message', 'hook'),
                        'subtitle' => esc_html__('This text will be displayed after sending the email.', 'hook'),
                        'default' => esc_html__('Thank you for contacting us. We will reply soon!', 'hook')
                    ),
                )
            );
            if(function_exists('icl_object_id')) {
                $this->sections[] = array(
                    'icon' => 'el-icon-globe',
                    'icon_class' => 'icon-large',
                    'title' => esc_html__('WPML', 'hook'),
                    'fields' => array(
                        array(
                            'id'=>'hook_wpml_menu',
                            'type' => 'switch',
                            'title' => esc_html__('Append languages menu to header bar?', 'hook'),
                            'subtitle'=> wp_kses('WPML is a premium plugin that can be downloaded <a href="'.get_admin_url().'plugin-install.php?tab=commercial">here</a>.', $hook_html),
                            "default" => 0,
                        ),
                    )
                );
            }
            if (class_exists('woocommerce')) {
                $this->sections[] = array(
                    'icon' => 'el-icon-shopping-cart',
                    'icon_class' => 'icon-large',
                    'title' => esc_html__('Woocommerce', 'hook'),
                    'fields' => array(
                        array(
                            'id'=>'woo_subheading',
                            'type' => 'text',
                            'title' => esc_html__('Shop page subheadings', 'hook'),
                            'subtitle' => esc_html__('Will be displayed under the shop page title', 'hook'),
                            'desc' => esc_html__('Optional', 'hook'),
                            'default' => esc_html__('A stunning place to get your stuff the easy way.', 'hook'),
                        ),
                        array(
                            'id'=>'woo_prods_nr',
                            'type' => 'text',
                            'title' => esc_html__('Number of products per page?', 'hook'),
                            'subtitle' => esc_html__('', 'hook'),
                            'type' => 'text',
                            'validate' => 'numeric',
                            'class' => 'small-text',
                            'default' => '8',
                            'compiler' => 'true'
                        ),
                        array(
                            'id'=>'woo_col_nr',
                            'type' => 'select',
                            'title' => esc_html__('Number of products per row?', 'hook'),
                            'subtitle' => esc_html__('Default value is Four.', 'hook'),
                            'options' => array('2' => esc_html__('Two', 'hook'),'3' => esc_html__('Three', 'hook'),'4' => esc_html__('Four', 'hook')),
                            'default' => '4',
                            'compiler' => 'true'
                        ),
                        array(
                            'id'=>'woo_sidebar_display',
                            'type' => 'switch',
                            'title' => esc_html__('Display right sidebar by default?', 'hook'),
                            'subtitle'=> esc_html__("This option will apply only to WooCommerce Core Pages that aren't set up using shortcodes. If you want to display/hide a sidebar on a specific page add ?sidebar=y or ?sidebar=n to your link URL", 'hook'),
                            "default"       => 1,
                        ),
                        array(
                            'id'=>'woo_cart_display',
                            'type' => 'switch',
                            'title' => esc_html__('Add Shopping Cart info to the main menu?', 'hook'),
                            "default"       => 1,
                        ),
                        array(
                            'id'=>'woo_cart_always_display',
                            'type' => 'switch',
                            'title' => esc_html__('Show Shopping Cart info even when it is empty?', 'hook'),
                            "default"       => 0,
                            'required' => array('woo_cart_display','equals','1'),
                        ),
                        array(
                            'id'=>'woo_cart_info',
                            'type' => 'select',
                            'title' => esc_html__('Cart information?', 'hook'),
                            'options' => array('items' => esc_html__('Items', 'hook'),'price' => esc_html__('Price', 'hook'),'both' => esc_html__('Both', 'hook')),
                            'default' => array('price' => 'Price'),
                            'required' => array('woo_cart_display','equals','1'),
                        ),
                    )
                );
            }
            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Custom Scripts', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'css_text',
                        'type' => 'ace_editor',
                        'title' => esc_html__('Custom CSS', 'hook'),
                        'subtitle' => esc_html__('Quickly add some CSS to your theme by adding it to this block.', 'hook'),
                        'mode'     => 'css',
                        'theme'    => 'monokai',
                        'default'       => '',
                        'options' => array('minLines'=>20)
                    ),
                    array(
                        'id'=>'js_text',
                        'type' => 'ace_editor',
                        'mode'     => 'javascript',
                        'theme'    => 'monokai',
                        'title' => esc_html__('Custom Javascript', 'hook'),
                        'subtitle' => esc_html__('Add some js scripting here', 'hook'),
                        'desc' => "For object targeting use 'jQuery' prefix instead of the default '$' notation.",
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-key',
                'icon_class' => 'icon-large',
                'title' => esc_html__('Advanced settings', 'hook'),
                'fields' => array(
                    array(
                        'id'=>'info_warning_slugs',
                        'type'=>'info',
                        'style'=>'warning',
                        'header'=> esc_html__( 'This is a header.','hook'),
                        'desc' => esc_html__( "If slug changes don't apply immediately it is related to WordPress permalinks. After making your changes here you need to go to Settings>Reading and change permalinks structure to default. Save changes and then revert it to previous state.", 'hook')
                    ),
                    array(
                        'id'=>'portfolio_slug',
                        'type' => 'text',
                        'title' => esc_html__('Portfolios slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'portfolios'
                    ),
                    array(
                        'id'=>'skills_slug',
                        'type' => 'text',
                        'title' => esc_html__('Skills slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'desc' => esc_html__('Portfolio hierarchical category', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'skills'
                    ),
                    array(
                        'id'=>'folio_tags_slug',
                        'type' => 'text',
                        'title' => esc_html__('Portfolio tag slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'desc' => esc_html__('Portfolio non-hierarchical category', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'tagged'
                    ),
                    array(
                        'id'=>'slides_slug',
                        'type' => 'text',
                        'title' => esc_html__('Slides slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'slides'
                    ),
                    array(
                        'id'=>'groups_slug',
                        'type' => 'text',
                        'title' => esc_html__('Slides groups slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'group'
                    ),
                    array(
                        'id'=>'members_slug',
                        'type' => 'text',
                        'title' => esc_html__('Members slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'member'
                    ),
                    array(
                        'id'=>'team_slug',
                        'type' => 'text',
                        'title' => esc_html__('Team slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'team'
                    ),
                    array(
                        'id'=>'testimonials_slug',
                        'type' => 'text',
                        'title' => esc_html__('Testimonials slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'testimonials'
                    ),
                    array(
                        'id'=>'testimonials_groups_slug',
                        'type' => 'text',
                        'title' => esc_html__('Testimonials groups slug', 'hook'),
                        'subtitle' => esc_html__('No special characters and must be unique.', 'hook'),
                        'desc' => esc_html__('', 'hook'),
                        'validate' => 'no_special_chars',
                        'default' => 'testimonials_group'
                    ),
                )
            );
            $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'hook'),
                'desc'      => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'hook'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => esc_html__('Import Export', 'hook'),
                        'subtitle'      => esc_html__('Save and restore your Redux options', 'hook'),
                        'full_width'    => false,
                    ),
                ),
            );
            $this->sections[] = array(
                'type' => 'divide',
            );
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_html__('Theme Information', 'hook'),
                'desc'      => esc_html__('<p class="description">Hook - Hybrid WordPress Theme</p>', 'hook'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
            if (false) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => esc_html__('Documentation', 'hook'),
                    'content'   => nl2br('README.html')
                );
            }
        }
        public function setHelpTabs() {
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'hook'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'hook')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'hook'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'hook')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'hook');
        }
        /**
        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme();
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'prk_hook_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => esc_html__("Theme Control Panel","hook"),
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'hook'),
                'page_title'        => esc_html__('Theme Options', 'hook'),
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => false,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );
        }
    }
    global $reduxConfig;
    $reduxConfig = new hook_options_config();
}
/**
Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;
/**
Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
