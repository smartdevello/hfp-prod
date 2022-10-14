<?php

add_filter( 'woocommerce_account_menu_items', function ( $items ) {

    // Remove the logout menu item
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] );

    $items['change-password'] = __( 'Change Password', 'woocommerce' );
    // Insert back the logout item
    $items['customer-logout'] = $logout;

    return $items;
});

add_action( 'init', function () {

    add_rewrite_endpoint( 'change-password', EP_PAGES );

});
add_action( 'woocommerce_account_change-password_endpoint', function () { ?>

<form class="woocommerce-EditAccountForm edit-account" action="<?php echo admin_url() . 'admin-post.php' ?>" method="post" >

                    <!-- Begin: Password -->
                    <section class="hfp-account-section" id="password">
                            <h4 class="hfp-account-section__name"><a href="#password"># <?php _e('Password', 'hfp'); ?></a></h4>
                            <div class=" hfp-account-section__panel">
                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                                    </p>
                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                                    </p>
                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                                    </p>
                                    </fieldset>
                                    <div class="clear"></div>

                                    <input type="hidden" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" />

                                    <p>
                                            <?php wp_nonce_field('change_password', 'change-password-nonce'); ?>
                                            <button type="submit" class="woocommerce-Button button" name="change_password" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                                            <input type="hidden" name="action" value="change_password_action" />
                                    </p>
                            </div>
                    </section>
                    <!-- End: Password -->    
        </form>
<?php                        
});

add_action( 'admin_post_change_password_action', function () {

    $nonce_value = wc_get_var( $_REQUEST['change-password-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

    require_once ( get_home_path() . PLUGINDIR . '/woocommerce/includes/wc-notice-functions.php' ); 
    if ( ! wp_verify_nonce( $nonce_value, 'change_password' ) ) {
            return;
    }

    if ( empty( $_POST['action'] ) || 'change_password_action' !== $_POST['action'] ) {
            return;
    }

    $pass_cur             = ! empty( $_POST['password_current'] ) ? $_POST['password_current'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $pass1                = ! empty( $_POST['password_1'] ) ? $_POST['password_1'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $pass2                = ! empty( $_POST['password_2'] ) ? $_POST['password_2'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $save_pass            = true;

    $user_id = get_current_user_id();
    $current_user       = get_user_by( 'id', $user_id );
    
    WC()->session = new WC_Session_Handler();
    WC()->session->init();
    
    if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
            wc_add_notice( __( 'Please fill out all password fields.', 'woocommerce' ), 'error' );
            $save_pass = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
            wc_add_notice( __( 'Please enter your current password.', 'woocommerce' ), 'error' );
            $save_pass = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
            wc_add_notice( __( 'Please re-enter your password.', 'woocommerce' ), 'error' );
            $save_pass = false;
    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
            wc_add_notice( __( 'New passwords do not match.', 'woocommerce' ), 'error' );
            $save_pass = false;
    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
            wc_add_notice( __( 'Your current password is incorrect.', 'woocommerce' ), 'error' );
            $save_pass = false;
    }

    if ( wc_notice_count( 'error' ) === 0 ) {
        if ( $pass1 && $save_pass ) {
            wp_set_password( $pass1, $user_id );
        }
        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    } else {
        wp_safe_redirect( wp_get_referer() );
        exit;
    }
    
    
});