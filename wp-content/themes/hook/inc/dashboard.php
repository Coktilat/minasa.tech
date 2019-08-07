<?php
add_action( 'admin_menu', 'hook_admin_menu' );
function hook_admin_menu() {
    add_submenu_page( 'themes.php', __('Theme Dashboard','hook'), __('Theme Dashboard','hook'), 'manage_options', 'hook-admin-settings.php','hook_admin_page' );
}

function hook_admin_tab_content($in_tab) {

    ob_start();

    switch ($in_tab) {
        case 'support':
            ?>
            <div class="hook_follow_numbers left_floated">
                <div class="hook_tabbed_section left_floated">
                    <div class="hook_tabbed_section_content left_floated">
                        <h3>We are happy to assist</h3>
                        <p>If you haven't done it yet, you can start by checking the theme documentation <a href="https://support.pirenko.com/documentation-hub/" target="_blank">here</a>. General theme information and customization tips can be found there.</p>
                        <p>We have also setup some video tutorials on our <a href="https://www.youtube.com/user/PirenkoThemes/playlists" target="_blank">Youtube Channel</a> that should cover pretty much eveything.</p>
                        <p>If you still have trouble or got stuck with something, you can reach us anytime on our support forum <a href="https://support.pirenko.com/" target="_blank">here</a>.</p>
                    </div>
                </div>
            </div>
            <?php
            break;
        case 'customization':
            ?>
            <div class="hook_follow_numbers left_floated">
                <div class="hook_tabbed_section left_floated">
                    <div class="hook_tabbed_section_content left_floated">
                        <h3>Need to go one step further?</h3>
                        <p>If you need some sort of customization that is not covered by the theme options and/or features, please email us at <a href="mailto:customizations@pirenko.com">customizations@pirenko.com</a> and we will take things from there. </p>
                    </div>
                </div>
            </div>
            <?php
            break;
        default:
            ?>
            <div class="hook_follow_numbers left_floated">
                <div class="hook_tabbed_section left_floated">
                    <div class="hook_tabbed_section_content left_floated">
                        <?php
                        //Fix broken license?
                        if (hook_validate_key()) {
                            if (strlen(get_option('hook_prk_one')) != 36) {
                                update_option('hook_prk_one', 'off');
                            }
                        }
                        if (hook_validate_key()) {
                            ?>
                            <h3><span class="hook_numbered hook_done">1</span>Validate your license key - Done<span class="hook_checked">&#9989;</span></h3>
                            <p>Spot on! The install is already licensed.<br /><span class="prk_small_span">The license key associated with this install is: <?php echo get_option('hook_prk_one'); ?>.</span></p>
                            <?php
                        }
                        else {
                            ?>
                            <h3><span class="hook_numbered">1</span>Validate License Key</h3>
                            <p>Unlock all theme features by adding your license key to this install. Click on the button below to add your license.</p>
                            <a class="button-primary" href="themes.php?page=hook-install-required-plugins">Validate License Key &rarr;</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php if (hook_validate_key()) {
                    ?>
                    <div class="hook_tabbed_section left_floated">
                        <div class="hook_tabbed_section_content left_floated">
                            <?php
                            if (TGM_Plugin_Activation::get_instance()->is_tgmpa_complete()) {
                                ?>
                                <h3><span class="hook_numbered hook_done">2</span>Install bundled plugins - Done<span class="hook_checked">&#9989;</span></h3>
                                <p>Nice! All the recommended plugins are installed and active.</p>
                                <?php
                            }
                            else {
                                ?>
                                <h3><span class="hook_numbered">2</span>Install bundled plugins</h3>
                                <p>To ensure that you take full advantage of the theme features make sure that you install all the plugins below.</p>
                                <ul class="hook_admin_list">
                                    <?php
                                    $tgmpa = isset( $GLOBALS['tgmpa'] ) ? $GLOBALS['tgmpa'] : TGM_Plugin_Activation::get_instance();

                                    $in_plugs=$tgmpa->plugins;
                                    foreach ($in_plugs as $in_plug) {
                                        if (!TGM_Plugin_Activation::get_instance()->prk_plugin_active($in_plug['slug'])) {
                                            echo '<li><span class="hook_checked">&#10060;</span><strong>'.$in_plug['name'].'</strong> <u>'.esc_html__('needs to be installed and activated.','hook').'</u></li>';
                                        }
                                        else {
                                            if (TGM_Plugin_Activation::get_instance()->does_plugin_require_update($in_plug['slug'])) {
                                                echo '<li><span class="hook_checked">&#10071;</span><strong>' . $in_plug['name'] . '</strong> <u>' . esc_html__('needs to be updated.', 'hook') . '</u></li>';
                                            }
                                            else {
                                                echo '<li><span class="hook_checked">&#9989;</span><strong>' . $in_plug['name'] . '</strong> ' . esc_html__('is already installed and activated.', 'hook') . '</li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                                <a class="button-primary" href="<?php echo TGM_Plugin_Activation::get_instance()->get_tgmpa_url(); ?>">Manage Bundled Plugins &rarr;</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            break;
    }
    $zip_out = ob_get_clean();
    echo hook_output().$zip_out;
}

function hook_admin_page() {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'guide';
    ?>
    <div class="wrap about-wrap hook-welcome">
        <div id="hook-header">
            <a href="admin.php?page=hook-admin-settings.php" id="hook-close"><i class="mdi-close"></i></a>
            <a href="https://www.hook.me" id="header_logo" title="hook" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/images/admin/dashboard-thumb.png" alt="hook">
            </a>
            <h1>Welcome To Hook</h1>
            <p class="about-text">
                <?php
                if ($active_tab == 'guide') {
                    echo __('Thank you for purchasing Hook! You are free to do pretty much anything, but we recommend you to get started with the steps below.','hook');
                }
                else if ($active_tab == 'support') {
                    echo __('Still stuck with someting? We are available to help you anytime.','hook');
                }
                else {
                    echo __("Already cleared the initial steps? Let's dig deeper into Hook...",'hook');
                }
                ?>
            </p>
        </div>
        <div class="clear"></div>
        <h2 class="nav-tab-wrapper">
            <a href="admin.php?page=hook-admin-settings.php&tab=guide" class="nav-tab<?php echo hook_output().$active_tab == 'guide' ? ' nav-tab-active' : ''; ?>"><div class="dashicons-before dashicons-admin-home"></div>Getting Started</a>
            <?php
            if (hook_validate_key() && TGM_Plugin_Activation::get_instance()->prk_plugin_active('one-click-demo-import')) {
                ?>
                <a href="themes.php?page=pt-one-click-demo-import"
                   class="nav-tab<?php echo hook_output().$active_tab == 'demo-import' ? ' nav-tab-active' : ''; ?>">
                    <div class="dashicons-before dashicons-upload"></div>
                    Demo Import</a>
                <?php
            }
            ?>
            <a href="admin.php?page=hook-admin-settings.php&tab=support" class="nav-tab<?php echo hook_output().$active_tab == 'support' ? ' nav-tab-active' : ''; ?>"><div class="dashicons-before dashicons-sos"></div>Support</a>
            <a href="admin.php?page=hook-admin-settings.php&tab=customization" class="nav-tab<?php echo hook_output().$active_tab == 'customization' ? ' nav-tab-active' : ''; ?>"><div class="dashicons-before dashicons-admin-appearance"></div>Customize</a>
        </h2>

        <form method="post" action="options.php">

            <?php
            hook_admin_tab_content($active_tab);
            ?>

        </form>

    </div>
    <?php
}



