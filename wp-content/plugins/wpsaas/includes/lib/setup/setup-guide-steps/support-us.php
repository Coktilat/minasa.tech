<p>Tell the world you love us and please support WP Ultimo by purchasing the license here</p>
<a href="#" target="_blank" class="button button-primary button-large"><?php _e( 'Purchase WP Ultimo License', 'wpsaas' ); ?></a>

<?php return false; ?>

<p><?php _e( 'Help improve Listify by submitting a rating and helping to translate the theme to as many languages as possible!', 'listify' ); ?></p>

<p>
	<a href="http://astoundify.com/go/rate-listify" class="button button-primary"><?php _e( 'Leave a Positive Rating', 'listify' ); ?></a>
	<a href="http://astoundify.com/go/translate-listify" class="button button-secondary"><?php _e( 'Translate Listify', 'listify' ); ?></a>
</p>

<?php if ( ! get_option( 'astoundify_setup_guide_hidden', false ) ) : ?>
<p>
	<a href="<?php echo esc_url( Astoundify_Setup_Guide::get_hide_menu_item_url() ); ?>"><em><?php _e( 'Move this guide under the "Appearance" menu item', 'listify' ); ?></em></a>
</p>
<?php endif; ?>
