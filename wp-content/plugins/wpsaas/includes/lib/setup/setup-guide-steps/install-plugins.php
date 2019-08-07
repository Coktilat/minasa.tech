<?php
/**
 *
 */
global $tgmpa;

//var_dump(call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) ));
?>

<p><?php _e( 'Before you can use WPSAAS you must first install <insert required plugins here>. You can read about <a href="#">why our plugin requires these</a> in the documentation.', 'listify' ); ?></p>

<p><?php _e( '<strong>Note:</strong> If you plan on automatically importing content in the next step ensure you do not run any plugin install guides. This can cause duplication in content. <strong>THIS NOTICE IS GENERATED BY LISTIFY AND MAY BE APPLICABLE TO US IF WE PLAN ON ALLOWING CONTENT IMPORT</strong>', 'listify' ); ?></p>

<p>

<?php if ( ! $tgmpa->is_tgmpa_complete() ) : ?>
	<a href="<?php echo esc_url( $tgmpa->get_tgmpa_url() ); ?>" class="button button-primary button-large"><?php _e( 'Install Plugins', 'listify' ); ?></a>
<?php else : ?>
	<a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-primary button-large"><?php _e( 'View Installed Plugins', 'listify' ); ?></a>
<?php endif; ?>

</p>
