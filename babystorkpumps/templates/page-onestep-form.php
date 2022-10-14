<?php

/**
 * Template Name: One step form
 **/
get_header();
if (is_user_logged_in()) {
	$multi_step_form_progress = get_user_meta(get_current_user_id(), 'multi_step_form_progress', true);
	$multi_step_form_progress = (int)$multi_step_form_progress;
}

$title = get_the_title();
// $current_url="http://".$_SERVER['HTTP_HOST'].$_SE;
// var_dump($current_url);
// var_dump($title);

if (strpos($title, "Shower") === false) {
	$shower_page = false;
	$banner_image = get_template_directory_uri() . '/assets/img/BSP_Snoo_Header.png';
} else {
	$shower_page = true;
	$banner_image = get_template_directory_uri() . '/assets/img/bnb_aug_2022/new_banner.png';
}


?>
<style>
	.hfp-prescription {display: none;}
</style>
<div class="hfp-bnb">
	<div class="hfp-bnb-logo">
		<div class="hfp-bnb-logo__container">

			<img src="<?php echo $banner_image; ?>" alt="logo" <?php if ($shower_page === false) echo "style=\"width:100%\""; ?> />
			<?php
			
			if ($shower_page === true ) {
				?>
					<h2 class="hfp-bnb-logo__intro">Register for a FREE pump and attend a Baby Stork Shower where each attendee receives a Baby Bundle Box worth over $300.</h2>
					<h5 class="">Spots are limited. Attendees will be selected by lottery.</h5>
				<?php
			}

			?>
			
		</div>
	</div>

	<?php if ($shower_page === true ) {
		?>
			<div class="hfp-bnb-donators">
				<div class="hfp-bnb-donators__container">
					<div class="hfp-bnb-donators__slider">
						<?php

						// for ($i = 1; $i <= 14; $i++) {
						// 	echo '<div class="hfp-bnb-donators__item"><img src="' . get_template_directory_uri() . '/assets/img/bnb/' . $i . '.jpeg"/></div>';
						// }

						for ($i = 1; $i <= 11; $i++) {
							echo '<div class="hfp-bnb-donators__item"><img src="' . get_template_directory_uri() . '/assets/img/bnb_aug_2022/' . $i . '.jpeg"/></div>';
						}
						?>
					</div>
				</div>
			</div>
		<?php
	}?>

	<div class="hfp-bnb-content">
		<div class="hfp-bnb-content__container">
			<?php if (have_posts()) : while (have_posts()) : the_post();
					the_content();
				endwhile;
			endif;
			$orders_count = hfp_user_has_orders();
			// echo $orders_count;
				if ($orders_count) {				
					?>
					<div class="multiple-order-error" style="color: red; font-size: 25px; text-align: center;ont-weight: 700;">
						<p>You already have an account on file. </p>
						<p>Please contact <a href="mailto:support@babystorkpumps.com">support@babystorkpumps.com</a> if you need further assistance</p>
					</div>
					<?php
					return;
				}
			?>
		</div>
	</div>

	<div class="hfp-multisptep-container">
		<div class="col-sm-9 form-container">
			<?php
			if (!is_user_logged_in()) { // Not a logged-in user 
			?>
				<a style="text-align: center;margin-top: 60px;display: block;" id="login_link" href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="hfp-header-user__nav hfp-header-user__nav--login"><?php _e('If you already have an account, login here', 'hfp'); ?></a>
			<?php
			}
			?>

			<form id="regForm" class="onestep-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" enctype="multipart/form-data">
				<?php
				require_once 'onestep-form/step-motherInfo.php';
				require_once 'onestep-form/step-primaryInsuranceInfo.php';
				require_once 'onestep-form/step-accesories.php';
				require_once 'onestep-form/step-autograph.php';
				?>

				<div class="form-group">
					<label class="authorize__checkbox hfp-checkbox">
						<input id="accept_msgs" type="checkbox" class="form-control hfp-checkbox__input" name="accept_msgs" checked />
						<span class="hfp-checkbox__icon"></span>
						It’s OK to send me text messages about my order and account. This will greatly speed up order processing!
					</label>
				</div>

				<div class="form-group">
					<label class="authorize__checkbox hfp-checkbox">
						<input id="statement" type="checkbox" class="form-control hfp-checkbox__input" name="statement" checked required />
						<span class="hfp-checkbox__icon"></span>
						<a href="<?php echo home_url() . '/statement' ?>" target="_blank">STATEMENT </a> TO PERMIT ASSIGNMENT OF BENEFITS.
					</label>
				</div>
				<div class="form-group">
					<label class="authorize__checkbox hfp-checkbox">
						<input id="terms" type="checkbox" class="form-control hfp-checkbox__input" name="terms" checked required />
						<span class="hfp-checkbox__icon"></span>
						I agree to <a href="https://babystorkpumps.zendesk.com/hc/en-us/articles/7500751683351" target="_blank">Terms & conditions</a>, <a href="https://babystorkpumps.zendesk.com/hc/en-us/articles/7500923735703" target="_blank">Privacy Notice</a>, <a href="https://babystorkpumps.zendesk.com/hc/en-us/articles/7536326901015" target="_blank">Rights & Responsibility & Supplier</a>
					</label>
				</div>

				<div class="form-group">
					<label class="authorize__checkbox hfp-checkbox">
						<input id="event_tricare" type="checkbox" class="form-control hfp-checkbox__input" name="event_tricare" checked required />
						<span class="hfp-checkbox__icon"></span>
						By registering for this event, you are allowing Baby Stork Pumps to verify your eligibility with your insurance provider.
					</label>
				</div>

				<div class="form-group">
					<label class="authorize__checkbox hfp-checkbox">
						<input id="event_sponsors" type="checkbox" class="form-control hfp-checkbox__input" name="event_sponsors" checked required />
						<span class="hfp-checkbox__icon"></span>
						By registering for this event, you are allowing any and all event sponsors listed to contact you.
					</label>
				</div>
				<div class="note"><span class="ast">*</span> Required field</div>

				<!--begin: Form Actions -->
				<div class="action-buttons">
					<button class="action-button hfp-onestep-form__submit" type="submit"><?php _e('Submit', 'hfp'); ?></button>
					<div class="load-spinner"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/multistep/loader.gif" /></div>
					<input type="hidden" name="register_page" value="<?php 
						if ($shower_page) echo "onestep_form_bsp_shower";
						else echo "onestep_form_bsp_giveaway";
					?>" />
					<input type="hidden" name="action" value="onestep_form_action" />
				</div>

				<!--end: Form Actions -->
			</form>
		</div>
		<div class="col-sm-3">
			<div class="side-panel">
				<h3 class="side-panel__heading">How to order</h3>
				<div class="side-panel__subimg"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/multistep/Icon-Online/Icon-Online.png" title="Complete the New Patient For"></div>
				<h5 class="side-panel__subheading">Fill out the online form.</h5>
				<p>Include your insurance and doctor’s information, and we will contact your physician to obtain your prescription. If you already have a prescription, upload it here.</p>
				<div class="side-panel__subimg"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/multistep/Icon-Check/Icon-Check.png" title="Complete the New Patient For"></div>
				<h5 class="side-panel__subheading">Choose your pump.</h5>
				<p>Select the breast pump and storage bags that are best for you.</p>
				<div class="side-panel__subimg"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/multistep/Icon-Woman2/Icon-Woman2.png" title="Complete the New Patient For"></div>
				<h5 class="side-panel__subheading">Relax and enjoy your new baby!</h5>
				<p>Your order ships directly to you, hassle-free.</p>
			</div>
		</div>
	</div>
</div>
<script>
	var utilsScriptURL = "<?php echo get_template_directory_uri(); ?>/assets/intlTelInput/js/utils.js";
</script>

<?php 
wp_enqueue_script('dmez-payer');
wp_enqueue_script('intlTelInput');
wp_enqueue_script('singup_form');

get_footer(); ?>
