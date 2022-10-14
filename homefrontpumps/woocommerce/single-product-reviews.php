<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
    return;
}

?>

<div class="title">
    Add your review
</div>

<?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>
    <div class="add-review-form">
        <?php

        if (wc_review_ratings_enabled()) {
            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'woocommerce') . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
						<option value="5">' . esc_html__('Perfect', 'woocommerce') . '</option>
						<option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
						<option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
						<option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
					</select></div>';
        }

        $comment_form['comment_field'] .= '<div class="textarea-container"><textarea name="comment" cols="30" rows="20" placeholder="Comment Review" required></textarea></div>';

        comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
        ?>
    </div>
<?php else : ?>
    <p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'woocommerce'); ?></p>
<?php endif; ?>

<div class="clear"></div>





<!---->
<!--<div class="your-rating">-->
<!--    <div class="star-rating-text">-->
<!--        your rating-->
<!--    </div>-->
<!--    <div class="star-rating-stars">-->
<!--        *****-->
<!--    </div>-->
<!--</div>-->
<!--<div class="add-review-form">-->
<!--    <form action="">-->
<!--        <div class="input-container">-->
<!--            <input type="text" placeholder="Name">-->
<!--        </div>-->
<!--        <div class="input-container justify-end">-->
<!--            <input type="email" placeholder="Email">-->
<!--        </div>-->
<!--        <div class="textarea-container">-->
<!--                                        <textarea name="review" id="" cols="30" rows="10"-->
<!--                                                  placeholder="Comment Review"></textarea>-->
<!--        </div>-->
<!--        <button type="submit">-->
<!--            Submit-->
<!--        </button>-->
<!--    </form>-->
<!--</div>-->

<script>
    jQuery('.comment-form-author input').attr("placeholder", "Name");
    jQuery('.comment-form-email input').attr("placeholder", "Email");
    jQuery('.form-submit input').attr("value", "Submit");
</script>
