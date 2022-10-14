<?php
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $user = get_user_by('ID', $user_id);
    $free_product_acquired = get_user_meta($user_id, 'free_product_acquired', true);
}
?>
<!-- Begin: Home banner -->
<section class="hfp-home-banner">
    <div class="hfp-home-banner__container">
        <div class="hfp-home-banner__col">
            <h1 class="hfp-home-banner__title"><?php _e('best pumps. best bags.<br/> no upgrade fees.', 'hfp'); ?></h1>
            <p class="hfp-home-banner__text"><?php _e('At Baby Stork Pumps, we work directly with your medical insurance to offer the top brands of breast pumps at no cost to you and with no additional fees.', 'hfp'); ?></p>

            <!-- Begin: Home banner form -->
            <form class="hfp-home-banner__form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" <?php if (isset($free_product_acquired) && $free_product_acquired == true) {
                                                                                                                                echo 'style="display:none;"';
                                                                                                                            } ?>>
                <!-- <input class="hfp-home-banner__input" placeholder="<?php _e('email address', 'hfp'); ?>" type="email" name="user_email" required /> -->
                <input type="hidden" name="action" value="get_free_product_action" />
                <a href="<?php get_template_directory() ?>/singlepagewithshower/" class="hfp-home-banner__button">Get FREE Pump <br> Chance to Win $300 + Gifts</a>
                <!-- <button class="hfp-home-banner__button" type="submit"><?php _e('get your FREE Pump', 'hfp'); ?></button> -->
            </form>
            <!-- End: Home banner form -->
        </div>
    </div>
</section>
<!-- End: Home banner -->