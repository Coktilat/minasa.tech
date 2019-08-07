<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'hook' ) ) );

?>

<?php if ( $heading ): ?>
  <h2><?php echo hook_output().$heading; ?></h2>
<?php endif; ?>

<?php
	if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
	    the_content();
	}
	else {
		if (HOOK_VC_ON==true) {
	    	echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
	    }
	    else {
	    	the_content();
	    }
	}
?>
