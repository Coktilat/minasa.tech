<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="hide_now">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );

        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );

        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        ?>
    </div>
    <div class="hook_woo_thumb_wrapper">
        <?php
        wc_get_template( 'loop/sale-flash.php' );
        ?>
        <div class="hook_woo_thumb">
            <a href="<?php the_permalink(); ?>">
                <?php
                $WC_Product = new WC_Product();
                $attachment_ids = $WC_Product->get_gallery_image_ids();
                if ( $attachment_ids ) {
                    echo '<div class="hook_first_img">'.woocommerce_get_product_thumbnail().'</div>';
                    $secondary_image_id = $attachment_ids['0'];
                    echo '<div class="hook_secnd_img">'.wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) ).'</div>';
                }
                else {
                    echo woocommerce_get_product_thumbnail();
                }
                ?>
            </a>
            <a href="<?php echo do_shortcode('[add_to_cart_url id="'.get_the_ID().'"]'); ?>" class="hook_woo_add_button hook_woo_hidden"><span class="prk_lf"><?php echo esc_html($product->add_to_cart_text()); ?></span></a>
        </div>
    </div>
    <div class="hook_woo_product_info">
        <a href="<?php echo get_the_permalink(); ?>">
            <h3 class="zero_color prk_heavier_600">
                <?php echo get_the_title(); ?>
            </h3>
        </a>
        <div class="hook_woo_hidden hook_woo_cats small_headings_color">
            <?php echo (wc_get_product_category_list($post->ID));//3.0 ?>
        </div>
    </div>
    <?php
    /**
     * woocommerce_after_shop_loop_item_title hook.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>
    <div class="clearfix"></div>
    <?php
    /**
     * woocommerce_after_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</li>
