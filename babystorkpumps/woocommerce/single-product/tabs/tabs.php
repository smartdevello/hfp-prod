<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<ul class="nav nav-tabs">
    <li>
        <a data-toggle="tab" href="#description" class="description active">
            Description
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#reviews" class="reviews">
            Reviews
        </a>
    </li>
</ul>

<div class="tab-content">
    <div id="description" class="tab-pane fade in active show">
        <div class="description-container">
            <div class="left-content">
                <div class="content">
                    <?php do_action('woocommerce_product_description_tab'); ?>
                </div>
            </div>
            <div class="right-content">
                <div class="content">
                    <div class="title">
                        Specs
                    </div>
                    <div class="specs">
                        <?php do_action('woocommerce_product_additional_information_tab') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="reviews" class="tab-pane fade">
        <div class="reviews-items-container">
            <?php

            global $product;
            $id = $product->get_id();

            $args = array('post_type' => 'product', 'post_id' => $id);
            $comments = get_comments($args);
            wp_list_comments(array('callback' => 'woocommerce_comments'), $comments);

            ?>
        </div>
        <div class="add-review">
            <?php
            wc_get_template( 'single-product-reviews.php' );
            ?>
        </div>
    </div>
</div>
