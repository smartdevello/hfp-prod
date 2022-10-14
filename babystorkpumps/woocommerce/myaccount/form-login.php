<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="hfp-login" id="customer_login">

	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	<div class="hfp-login__panel hfp-login__panel--register" id="register">

		<h2 class="hfp-login__title"><?php esc_html_e( 'Sign up, It´s easy', 'hfp' ); ?></h2>

		<div class="hfp-login__wrapper">
			<form method="post" class="hfp-login-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<div class="hfp-login-form__row">
					<label class="hfp-login-form__label" for="reg_billing_first_name"><?php esc_html_e( 'First name', 'hfp' ); ?></label>
					<input type="text" class="hfp-login-form__input" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" placeholder="<?php esc_html_e( 'First name', 'hfp' ); ?>"/>
				</div>

				<div class="hfp-login-form__row">
					<label class="hfp-login-form__label" for="reg_billing_last_name"><?php esc_html_e( 'Last name', 'hfp' ); ?></label>
					<input type="text" class="hfp-login-form__input" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" placeholder="<?php esc_html_e( 'Last name', 'hfp' ); ?>"/>
				</div>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<div class="hfp-login-form__row">
						<label class="hfp-login-form__label" for="reg_username"><?php esc_html_e( 'Username', 'hfp' ); ?></label>
						<input type="text" class="hfp-login-form__input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'hfp' ); ?>"/>
					</div>

				<?php endif; ?>

				<div class="hfp-login-form__row">
					<label class="hfp-login-form__label" for="reg_email"><?php esc_html_e( 'Email address', 'hfp' ); ?></label>
					<input type="email" class="hfp-login-form__input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Email address', 'hfp' ); ?>"/>
				</div>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

					<div class="hfp-login-form__row">
						<label class="hfp-login-form__label" for="reg_password"><?php esc_html_e( 'Password', 'hfp' ); ?></label>
						<input type="password" class="woocommerce-Input hfp-login-form__input" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'hfp' ); ?>"/>
					</div>

				<?php else : ?>

					<div><?php esc_html_e( 'A password will be sent to your email address.', 'hfp' ); ?></div>

				<?php endif; ?>

				<?php do_action( 'woocommerce_register_form' ); ?>

				<div class="hfp-login-form__row">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="hfp-login-form__submit woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'hfp' ); ?>"><?php esc_html_e( 'Sign Up', 'hfp' ); ?></button>
				</div>

				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>

			<div class="hfp-login-separator">
				<span><?php _e('Or','hfp');?></span>
			</div>

			<div class="hfp-login-social">
				<a class="hfp-login-social__button hfp-login-social__button--facebook" href="<?php echo wp_login_url() . '?loginSocial=facebook';?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="facebook" data-popupwidth="475" data-popupheight="175">
					<span class="hfp-login-social__icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><defs><style>.a-fb{fill:none;}.b-fb{fill:#1e4fad;fill-rule:evenodd;}</style></defs><rect class="a-fb" width="32" height="32"/><path class="b-fb" d="M43.1,21.375c.85-.025,1.725,0,2.6,0h.35V16.9a13.127,13.127,0,0,0-1.425-.125c-.875-.05-1.775-.075-2.65-.075a6.507,6.507,0,0,0-3.75,1.15,5.685,5.685,0,0,0-2.25,3.75,12.245,12.245,0,0,0-.15,1.925c-.025,1,0,2.025,0,3.025v.375H31.5v5h4.275v12.6H41V31.95h4.25c.225-1.675.425-3.325.65-5.025H40.975s0-2.475.05-3.55C41.025,21.875,41.9,21.425,43.1,21.375Z" transform="translate(-23.625 -12.525)"/></svg></span>
					<span class="hfp-login-social__label">Continue with Facebook</span>
				</a>
				<a class="hfp-login-social__button hfp-login-social__button--google" href="<?php echo esc_url( wp_login_url( get_permalink() ) ) . '?loginSocial=google';?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600">
				<span class="hfp-login-social__icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><defs><style>.a-g{fill:none;}.b-g{fill:#fbbc05;}.b-g,.c-g,.d-g,.e-g{fill-rule:evenodd;}.c-g{fill:#ea4335;}.d-g{fill:#34a853;}.e-g{fill:#4285f4;}</style></defs><rect class="a-g" width="32" height="32"/><path class="b-g" d="M7.95,42.7a9.753,9.753,0,0,1,.475-2.975L3.025,35.6A16.1,16.1,0,0,0,1.4,42.7a15.925,15.925,0,0,0,1.65,7.075l5.4-4.125a8.914,8.914,0,0,1-.5-2.95" transform="translate(-1.05 -26.7)"/><path class="c-g" d="M22.3,6.55a9.328,9.328,0,0,1,5.9,2.1L32.85,4A16.029,16.029,0,0,0,7.9,8.9l5.4,4.125a9.432,9.432,0,0,1,9-6.475" transform="translate(-5.925)"/><path class="d-g" d="M22.3,82.375A9.433,9.433,0,0,1,13.325,75.9L7.9,80a16,16,0,0,0,14.4,8.925,15.32,15.32,0,0,0,10.45-4l-5.15-3.95a9.678,9.678,0,0,1-5.3,1.4" transform="translate(-5.925 -56.925)"/><path class="e-g" d="M80.775,55.3a12.635,12.635,0,0,0-.375-2.9H65.5v6.175h8.6a7.18,7.18,0,0,1-3.275,4.775L75.95,67.3a15.9,15.9,0,0,0,4.825-12" transform="translate(-49.125 -39.3)"/></svg></span>
					<span class="hfp-login-social__label">Continue with Google</span>
				</a>
				<div class="hfp-login-social__footer">
					<span class="hfp-login-social__text"><?php _e('Already have an account?','hfp');?>&nbsp; <a href="#login"><?php _e('Sign in','hfp');?></a></span>
				</div>
			</div>

		</div>
	</div>

	<?php endif; ?>

	<div class="hfp-login__panel hfp-login__panel--login" id="login">

		<h2 class="hfp-login__title"><?php esc_html_e( 'Welcome Back!', 'hfp' ); ?></h2>

		<div class="hfp-login__wrapper">
			<form class="hfp-login-form" method="post">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<div class="hfp-login-form__row">
					<label class="hfp-login-form__label" for="username"><?php esc_html_e( 'Username or email address', 'hfp' ); ?></label>
					<input type="text" class="hfp-login-form__input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'hfp' ); ?>" />
				</div>
				<div class="hfp-login-form__row">
					<label class="hfp-login-form__label" for="password"><?php esc_html_e( 'Password', 'hfp' ); ?></label>
					<input class="hfp-login-form__input" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'hfp' ); ?>" />
				</div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<div class="hfp-login-form__row hfp-login-form__row--lostpassword">
					<span class="hfp-login-form__text hfp-login-form__text--mobile"><?php _e('New User?','hfp');?> <a href="<?php echo get_template_page_url( 'templates/page-multistepForm.php' )?>"><?php _e('Sign up','hfp');?></a></span>
					<a class="hfp-login-form__text" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'hfp' ); ?></a>
				</div>

				<div class="hfp-login-form__row hfp-login-form__row--submit">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" checked /> <span><?php esc_html_e( 'Remember me', 'hfp' ); ?></span>
					</label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="hfp-login-form__submit woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'hfp' ); ?>"><?php esc_html_e( 'Login', 'hfp' ); ?></button>
				</div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

				<div class="hfp-login-separator"><span><?php _e('Or','hfp');?></span></div>

			</form>
			<div class="hfp-login-social">
				<a class="hfp-login-social__button hfp-login-social__button--facebook" href="<?php echo wp_login_url() . '?loginSocial=facebook';?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="facebook" data-popupwidth="475" data-popupheight="175">
					<span class="hfp-login-social__icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><defs><style>.a-fb{fill:none;}.b-fb{fill:#1e4fad;fill-rule:evenodd;}</style></defs><rect class="a-fb" width="32" height="32"/><path class="b-fb" d="M43.1,21.375c.85-.025,1.725,0,2.6,0h.35V16.9a13.127,13.127,0,0,0-1.425-.125c-.875-.05-1.775-.075-2.65-.075a6.507,6.507,0,0,0-3.75,1.15,5.685,5.685,0,0,0-2.25,3.75,12.245,12.245,0,0,0-.15,1.925c-.025,1,0,2.025,0,3.025v.375H31.5v5h4.275v12.6H41V31.95h4.25c.225-1.675.425-3.325.65-5.025H40.975s0-2.475.05-3.55C41.025,21.875,41.9,21.425,43.1,21.375Z" transform="translate(-23.625 -12.525)"/></svg></span>
					<span class="hfp-login-social__label">Continue with Facebook</span>
				</a>
				<a class="hfp-login-social__button hfp-login-social__button--google" href="<?php echo wp_login_url() . '?loginSocial=google';?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600">
				<span class="hfp-login-social__icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><defs><style>.a-g{fill:none;}.b-g{fill:#fbbc05;}.b-g,.c-g,.d-g,.e-g{fill-rule:evenodd;}.c-g{fill:#ea4335;}.d-g{fill:#34a853;}.e-g{fill:#4285f4;}</style></defs><rect class="a-g" width="32" height="32"/><path class="b-g" d="M7.95,42.7a9.753,9.753,0,0,1,.475-2.975L3.025,35.6A16.1,16.1,0,0,0,1.4,42.7a15.925,15.925,0,0,0,1.65,7.075l5.4-4.125a8.914,8.914,0,0,1-.5-2.95" transform="translate(-1.05 -26.7)"/><path class="c-g" d="M22.3,6.55a9.328,9.328,0,0,1,5.9,2.1L32.85,4A16.029,16.029,0,0,0,7.9,8.9l5.4,4.125a9.432,9.432,0,0,1,9-6.475" transform="translate(-5.925)"/><path class="d-g" d="M22.3,82.375A9.433,9.433,0,0,1,13.325,75.9L7.9,80a16,16,0,0,0,14.4,8.925,15.32,15.32,0,0,0,10.45-4l-5.15-3.95a9.678,9.678,0,0,1-5.3,1.4" transform="translate(-5.925 -56.925)"/><path class="e-g" d="M80.775,55.3a12.635,12.635,0,0,0-.375-2.9H65.5v6.175h8.6a7.18,7.18,0,0,1-3.275,4.775L75.95,67.3a15.9,15.9,0,0,0,4.825-12" transform="translate(-49.125 -39.3)"/></svg></span>
					<span class="hfp-login-social__label">Continue with Google</span>
				</a>
				<div class="hfp-login-social__footer">
					<span class="hfp-login-social__text"><?php _e('Do not have an account yet?','hfp');?>&nbsp; <a href="<?php echo get_template_page_url( 'templates/page-multistepForm.php' )?>"><?php _e('Sign up','hfp');?></a></span>
				</div>
			</div>
		</div>

	</div>

</div>




<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
