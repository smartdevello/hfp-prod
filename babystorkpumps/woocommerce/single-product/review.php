<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="review-item">
    <div class="left-content">
        <div class="username">
            <?php
            /**
             * The woocommerce_review_meta hook.
             *
             * @hooked woocommerce_review_display_meta - 10
             */
            do_action('woocommerce_review_meta', $comment);
            ?>
        </div>
        <div class="rating">
            <?php
            /**
             * The woocommerce_review_before_comment_meta hook.
             *
             * @hooked woocommerce_review_display_rating - 10
             */
            do_action('woocommerce_review_before_comment_meta', $comment);
            ?>
        </div>
    </div>
    <div class="right-content">
        <?php
        if (!('0' === $comment->comment_approved)) {

            if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) ) {
                echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')&nbsp;</em> ';
            }

            ?>
            <?php echo esc_html( get_comment_date( wc_date_format() ) ); ?>
        <?php
        } ?>
    </div>
    <div class="content">
        <?php

        do_action('woocommerce_review_before_comment_text', $comment);

        /**
         * The woocommerce_review_comment_text hook
         *
         * @hooked woocommerce_review_display_comment_text - 10
         */
        do_action('woocommerce_review_comment_text', $comment);

        do_action('woocommerce_review_after_comment_text', $comment); ?>
    </div>
</div>
