<?php
/**
 *
 */
global $tgmpa;

//var_dump(call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) ));
?>

<p><?php _e( 'Before you can use WPSAAS you must first install Divi and Divi child theme. You can read about <a href="#">why our plugin requires these</a> in the documentation.', 'listify' ); ?></p>

<p>
<?php if (wp_get_theme( 'Divi' )->errors() != false || wp_get_theme( 'WPSAAS' )->errors() != false) { ?>
	<a href="<?php echo network_admin_url( 'admin.php?page=wpsaas-setup&action=wpsaas-install-theme' ); ?>" class="button button-primary button-large"><?php _e( 'Install Themes', 'listify' ); ?></a>
<?php } ?>
</p>
