<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($related_products) : ?>

    <?php $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));
    
    if ($heading) :
    ?>
        <h2 class="hfp-home-products__title"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <?php woocommerce_product_loop_start(); ?>
    <div class="related-products-container">
        <div class="owl-carousel js-relatedProducts">
            <?php foreach ($related_products as $related_product) :
                $url = get_permalink($related_product->get_id());
            ?>

                <div class="hfp-home-products__item item">
                    <a class="hfp-home-products__thumb" href="<?php echo $url; ?>">
                        <?php
                        $post_object = get_post($related_product->get_id());

                        setup_postdata($GLOBALS['post'] = &$post_object);
                        ?>
                        <div class="hfp-home-products__img">
                            <img src="<?php echo get_the_post_thumbnail_url($related_product->get_id(), 'full'); ?>" />
                        </div>
                        <h5 class="hfp-home-products__name"><?php echo $related_product->get_name(); ?></h5>
                        <p class="hfp-home-products__text"><?php echo $related_product->get_short_description(); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php woocommerce_product_loop_end(); ?>


<?php endif; ?>

<?php
wp_reset_postdata();
