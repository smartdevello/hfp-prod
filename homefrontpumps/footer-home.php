<?php

/** footer-home.php
 *
 * @author Creiden
 */

tha_footer_before();
if (is_user_logged_in()) {
	$user_id = get_current_user_id();
	$user = get_user_by('ID', $user_id);
	$free_product_acquired = get_user_meta($user_id, 'free_product_acquired', true);
}
?>
<!-- Begin: Footer -->
<footer role="contentinfo" class="hfp-footer">
	<!-- Begin: Footer bar -->
	<div class="hfp-footer-bar">
	</div>
	<!-- End: Footer bar -->

	<?php tha_footer_top(); ?>
	<div class="hfp-footer__container">
		<h2 <?php if (isset($free_product_acquired) && $free_product_acquired == true) {
					echo 'style="visibility:hidden;"';
				} ?> class="hfp-footer__title"><?php _e('Enter your email to get started!', 'hfp'); ?></h2>
		<!-- Begin: Footer form -->
		<form class="hfp-footer-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" <?php if (isset($free_product_acquired) && $free_product_acquired == true) {
																																																							echo 'style="display:none;"';
																																																						} ?>>
			<input class="hfp-footer-form__input" name="user_email" type="email" placeholder="<?php _e('Email address', 'hfp'); ?>" required />
			<input type="hidden" name="action" value="get_free_product_action" />
			<button class="hfp-footer-form__button" type="submit"><?php _e('Get your FREE Pump/Pouches', 'hfp'); ?></button>
		</form>
		<!-- End: Footer form -->
		<!-- Begin: Footer widgets -->
		<div class="hfp-footer__row">
			<div class="hfp-footer__col hfp-footer__col--logo">
				<div class="hfp-footer-widget__img">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" />
				</div>
			</div>
			<div class="hfp-footer__col">
				<h6 class="hfp-footer-widget__title"><?php _e('Phone', 'hfp'); ?></h6>
				<p class="hfp-footer-widget__text">
					(704) 286-9918<br />
					Monday to Friday 9am-5pm ET
				</p>
				<h6 class="hfp-footer-widget__title"><?php _e('HELP', 'hfp'); ?></h6>
				<a href="https://homefrontpumps.zendesk.com/hc/en-us/articles/360043039214-Patient-Privacy" style="display: block;" target="_blank">Privacy notice</a>
				<a href="https://homefrontpumps.zendesk.com/hc/en-us/articles/360055964514" style="display: block;" target="_blank">Return policy</a>
				<a href="https://homefrontpumps.zendesk.com/hc/en-us/articles/7445178819991" style="display: block;" target="_blank">Terms and conditions</a>
				<a href="https://homefrontpumps.zendesk.com/hc/en-us/articles/360049642234-Frequently-Asked-Questions " style="display: block;" target="_blank">FAQ</a>
			</div>
			<div class="hfp-footer__col">
				<h6 class="hfp-footer-widget__title"><?php _e('E-mail', 'hfp'); ?></h6>
				<p class="hfp-footer-widget__text">
					<a href="mailto:info@homefrontpumps.com" target="_top">info@homefrontpumps.com</a>
				</p>
			</div>
			<div class="hfp-footer__col hfp-footer__col--social">
				<h6 class="hfp-footer-widget__title"><?php _e('Join Us', 'hfp'); ?></h6>
				<div class="hfp-footer-widget__social">
					<a class="hfp-footer-widget__social__item" href="https://facebook.com/homefrontpumpsllc">
						<i class="icon-facebook"></i>
					</a>
					<a class="hfp-footer-widget__social__item" href="https://www.instagram.com/homefrontpumpsllc">
						<i class="icon-instagram"></i>
					</a>
				</div>
			</div>
			<!-- Begin: Mobile Widgets -->
			<!-- <div class="hfp-footer__col hfp-footer__col--mobile">
						<h5 class="hfp-footer-widget__heading"><?php _e('Quick Links', 'hfp'); ?></h5>
						<?php
						wp_nav_menu(array(
							// 'container'			 => 'nav',
							'container_class'	 => 'hfp-footer-widget__menu',
							'theme_location'	 => 'quick-links',
							'depth'				 => 1,
							'fallback_cb'		 => false
						));
						?>
					</div>
					<div class="hfp-footer__col hfp-footer__col--mobile">
						<h5 class="hfp-footer-widget__heading"><?php _e('About Homefront', 'hfp'); ?></h5>
						<?php
						wp_nav_menu(array(
							// 'container'			 => 'nav',
							'container_class'	 => 'hfp-footer-widget__menu',
							'theme_location'	 => 'about',
							'depth'				 => 1,
							'fallback_cb'		 => false
						));
						?>
					</div> -->
			<!-- End: Mobile Widgets -->
		</div>
		<!-- End: Footer widgets -->
	</div>
	<?php tha_footer_bottom(); ?>
</footer>
<!-- End: Footer -->

<!-- Begin: Prescription -->
<section class="hfp-prescription">
	<span class="hfp-prescription__text">
		<?php _e('Need a Prescription?', 'hfp'); ?>
	</span>
	<a class="hfp-prescription__button" href="https://homefrontpumps.com/wp-content/uploads/2021/01/HFP_CMNFull_NC.pdf" target="_blank"><?php _e('Click Here', 'hfp'); ?></a>
</section>
<!-- End: Prescription -->
<!-- Begin: Copyrights bar -->
<section class="hfp-copyrights">
	<div class="hfp-copyrights__text">
		© 2020 Homefront Pumps LLC. All Rights Reserved.
	</div>
</section>
<!-- End: Copyrights bar -->
<?php tha_footer_after(); ?>
<?php wp_footer(); ?>
<!-- Start of homefrontpumps Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=bb2d18a9-349e-49b0-8de1-88ca31db85d8"> </script>
<!-- End of homefrontpumps Zendesk Widget script -->
</body>

</html>