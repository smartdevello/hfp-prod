<?php

/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author		Creiden
 */
?>
<!DOCTYPE html>
<!--[if IE 8 ]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie8.css" /><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <?php tha_head_top(); ?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <!-- <link rel="shortcut icon" type="image/png" href="<?php echo cr_get_option('favicon'); ?>"/> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/intlTelInput/css/intlTelInput.css">
    <title><?php wp_title('&laquo;', true, 'right'); ?></title>

    <?php wp_head(); ?>
    <?php tha_head_bottom(); ?>
    <?php echo cr_get_option('google_analytics');

	// Use script for only thankyou page
	global $wp;
	$current_url = home_url(add_query_arg($_GET, $wp->request));

	$thankyou_page_url = rtrim(get_template_page_url('templates/page-thankyou.php'), '/');

	if ($current_url == $thankyou_page_url) { ?>

    <?php
	}
	?>

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '313586947114063');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=313586947114063&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->




    <!-- Google Tag Manager -->
    <!-- <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-PTGGFH2');
    </script> -->

    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PRQZ3CR');
    </script>
    <!-- End Google Tag Manager -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-96KK738MYH"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-96KK738MYH');
    </script>


</head>

<body <?php body_class(); ?>>
    <?php tha_header_before(); ?>
    <?php if (!is_page_template('templates/page-onestep-form.php')) { ?>

    <!-- Google Tag Manager (noscript) -->
    <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTGGFH2" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript> -->

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PRQZ3CR" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Begin: Header -->
    <header role="banner" class="hfp-header js-header" id="header">

        <!-- Begin: Mobile header -->
        <div class="hfp-header__mobile">
            <a href="<?php echo site_url(); ?>" class="hfp-header-logo">
                <img width="87" src="<?php echo cr_get_option('header_dark_logo'); ?>" />
            </a>
            <?php
				if (is_user_logged_in()) {
					$multi_step_form_progress = get_user_meta(get_current_user_id(), 'multi_step_form_progress', true);
					$multi_step_form_progress = (int)$multi_step_form_progress;
				}
				?>
            <ul id="progressbarMobile">
                <li
                    class="active <?php echo (!empty($multi_step_form_progress) && ($multi_step_form_progress <= 4) ? 'mobile-active' : ''); ?>">
                    <span>1</span><i class="icon-ok"></i>
                </li>
                <div class="connector active"></div>
                <li
                    class="<?php echo (!empty($multi_step_form_progress) && ($multi_step_form_progress > 1) && ($multi_step_form_progress <= 4) ? 'mobile-active' : ''); ?>">
                    <span>2</span><i class="icon-ok"></i>
                </li>
                <div class="connector"></div>
                <li
                    class="<?php echo (!empty($multi_step_form_progress) && ($multi_step_form_progress > 2) && ($multi_step_form_progress <= 4) ? 'mobile-active' : ''); ?>">
                    <span>3</span><i class="icon-ok"></i>
                </li>
                <div class="connector"></div>
                <li
                    class="<?php echo (!empty($multi_step_form_progress) && ($multi_step_form_progress == 4) ? 'mobile-active' : ''); ?>">
                    <span>4</span><i class="icon-ok"></i>
                </li>
            </ul>
            <div class="hfp-header-burger js-toggleMenu">
                <span class="hfp-header-burger__bar"></span>
                <span class="hfp-header-burger__bar"></span>
                <span class="hfp-header-burger__bar"></span>
            </div>
        </div>
        <!-- End: Mobile header -->

        <!-- Begin: Header Content -->
        <div class="hfp-header__content">

            <!-- Begin: Header user -->
            <div class="hfp-header-user">
                <div class="hfp-header-user__message">
                    <h3><?php _e('Welcome', 'hfp'); ?>
                        <?php echo get_user_meta(get_current_user_id(), 'first_name', true); ?></h3>
                    <p><?php echo cr_get_option('header_user_text'); ?></p>
                </div>
                <?php if (is_user_logged_in()) { ?>
                <span class="hfp-header-user__nav hfp-header-user__nav--welcome"><?php _e('Welcome', 'hfp'); ?>
                    <?php echo get_user_meta(get_current_user_id(), 'first_name', true); ?></span>
                <?php
						$multi_step_form_progress = get_user_meta(get_current_user_id(), 'multi_step_form_progress', true);
						$new_form_progress = get_user_meta(get_current_user_id(), 'new_form_progress', true);
						$free_product_acquired = get_user_meta(get_current_user_id(), 'free_product_acquired', true);
						if ($free_product_acquired != true) {
							if ((!empty($multi_step_form_progress) && $multi_step_form_progress != 4) || (!empty($new_form_progress) && $new_form_progress != 4)) { ?>
                <a href="<?php echo get_template_page_url('templates/page-finishOrder.php') ?>"
                    class="hfp-header-user__nav hfp-header-user__nav--register"
                    style="max-width:none;"><?php _e('Finish Order', 'hfp'); ?></a>
                <?php }
						} ?>
                <a href="<?php echo wp_logout_url(home_url()); ?>"
                    class="hfp-header-user__nav hfp-header-user__nav--register"><?php _e('Log out', 'hfp'); ?></a>
                <?php } else { ?>
                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')) ?>"
                    class="hfp-header-user__nav hfp-header-user__nav--login"><?php _e('Log In', 'hfp'); ?></a>
                    <!-- <?php echo  get_template_page_url('templates/page-onestep-form.php'); ?> -->
                <a href="https://babystorkpumps.com/singlepagewithshower/"                
                    class="hfp-header-user__nav hfp-header-user__nav--register"><?php _e('Sign Up', 'hfp'); ?></a>
                <?php }; ?>
                <!-- <div class="hfp-header-user__minicart">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 42"><defs><style></style></defs><g transform="translate(-61.783 -12.8)"><g transform="translate(61.783 20.655)"><path class="a" d="M87.063,142.145H68.511a6.975,6.975,0,0,1-4.94-2.03,6.13,6.13,0,0,1-1.769-4.786L64.009,108H91.557l1.6,19.738a.84.84,0,0,1-.806.883.859.859,0,0,1-.937-.759l-1.472-18.228H65.639l-2.085,25.819a4.5,4.5,0,0,0,1.305,3.54,5.091,5.091,0,0,0,3.653,1.5H87.063a5.091,5.091,0,0,0,3.653-1.5,4.437,4.437,0,0,0,1.305-3.54l-.158-1.98a.84.84,0,0,1,.806-.883.859.859,0,0,1,.937.759l.158,1.98a6.13,6.13,0,0,1-1.769,4.786A6.94,6.94,0,0,1,87.063,142.145Z" transform="translate(-61.783 -108)"/></g><g transform="translate(68.661 12.8)"><path class="a" d="M155.695,28.973a.845.845,0,0,1-.859-.825V21.563a7.414,7.414,0,0,0-14.816,0v6.585a.86.86,0,0,1-1.719,0V21.563a9.135,9.135,0,0,1,18.254,0v6.585A.845.845,0,0,1,155.695,28.973Z" transform="translate(-138.3 -12.8)"/></g></g></svg>
					</div> -->
            </div>
            <!-- End: Header user -->
            <a href="<?php echo site_url(); ?>" class="hfp-header-logo__desktop">
                <img height="125" src="<?php echo cr_get_option('header_dark_logo'); ?>" />
            </a>

        </div>
        <!-- End: Header Content -->

        <?php tha_header_bottom(); ?>

    </header>
    <!-- End: Header -->
    <?php } ?>
    <?php tha_header_after();