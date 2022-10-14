<?php


defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); 
if (is_user_logged_in()) {
	$user_id = get_current_user_id();
	$user = get_user_by('ID', $user_id);

	$face_file = get_user_meta($user_id, 'face_file', true);
	$national_id_file = get_user_meta($user_id, 'national_id_file', true);
	$assigned_sex = get_user_meta($user_id, 'assigned_sex', true);
	$currently_pregnant = get_user_meta($user_id, 'currently_pregnant', true);
	$breastfeeding_past = get_user_meta($user_id, 'breastfeeding_past', true);
	$breastfeeding_pain = get_user_meta($user_id, 'breastfeeding_pain', true);
	$breast_red_swelling = get_user_meta($user_id, 'breast_red_swelling', true);
	$breast_milk_amount_change = get_user_meta($user_id, 'breast_milk_amount_change', true);
	$breastfeeding_pain_comments = get_user_meta($user_id, 'breastfeeding_pain_comments', true);
	$breast_red_swelling_comments = get_user_meta($user_id, 'breast_red_swelling_comments', true);
	$breast_milk_amount_change_comments = get_user_meta($user_id, 'breast_milk_amount_change_comments', true);

}

?>

<form id="regForm" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')) ?>" enctype="multipart/form-data" novalidate>

	<?php do_action('woocommerce_edit_account_form_start'); ?>
    <div class="form-group" id="option_set1" >
        <div class="custom_file_input_div">
            <label style="display:block;">Upload a picture of yourself <span class="ast">*</span></label>
            <?php
                if(isset($face_file) && !empty( $face_file ) ) { ?>
                    <span><?php _e('(This file was uploaded before)','hfp');?></span>
                <?php
                }
            ?>

            <label class="custom-file-input__label" for="face_file">
                <span class="custom-file-input__button"><?php _e('Choose a File','hfp');?></span>
                <span class="custom-file-input__name js-prescriptionName"></span>
            </label>
            <input  id="face_file" type="file" class="form-control custom-file-input__input js-prescriptionUpload" name="face_file"  required>
            <label class="file-error" style="display:none;">This field is required</label>
            <hr>
        </div>

        <div class="custom_file_input_div">
            <label style="display:block;">Upload a picture of the front of your drivers license for DOB verification<span class="ast">*</span></label>
            <?php
                if(isset($national_id_file) && !empty( $national_id_file ) ) { ?>
                    <span><?php _e('(This file was uploaded before)','hfp');?></span>
                <?php
                }
            ?>
            <label class="custom-file-input__label" for="national_id_file">
                <span class="custom-file-input__button"><?php _e('Choose a File','hfp');?></span>
                <span class="custom-file-input__name js-prescriptionName"></span>
            </label>
            <input  id="national_id_file" type="file" class="form-control custom-file-input__input js-prescriptionUpload" name="national_id_file" required>
            <label class="file-error" style="display:none;">This field is required</label>

        </div>

        <label class="additional-info-label">What was your assigned sex at birth?  <span class="ast">*</span></label>		
        <select name="assigned_sex" class="form-control" id="assigned_sex" required>
                <option value="" disabled selected>select</option>
				<?php $saved_assigned_sex = isset( $assigned_sex ) && ( $assigned_sex == 'male' ) ? 'selected' : ''; ?>
                <option value="male"  <?php echo $saved_assigned_sex; ?> >Male</option>
				<?php $saved_assigned_sex = isset( $assigned_sex ) && ( $assigned_sex == 'female' ) ? 'selected' : ''; ?>
                <option value="female"  <?php echo $saved_assigned_sex; ?> >Female</option>
        </select>


        <label class="additional-info-label">Are you currently pregnant?  <span class="ast">*</span></label>
        <select name="currently_pregnant" class="form-control" id="currently_pregnant" required>
                <option value="" disabled selected>select</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'Yes' ) ? 'selected' : ''; ?>
                <option value="Yes"  <?php echo $saved_currently_pregnant; ?> >Yes</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'No, baby born in the past 6 months' ) ? 'selected' : ''; ?>
                <option value="No, baby born in the past 6 months"  <?php echo $saved_currently_pregnant; ?> >No, baby born in the past 6 months</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'No, baby born more than 6 months ago' ) ? 'selected' : ''; ?>
                <option value="No, baby born more than 6 months ago" <?php echo $saved_currently_pregnant; ?>  >No, baby born more than 6 months ago</option>
        </select>

        <label class="additional-info-label">Have you ever breastfed in the past?  <span class="ast">*</span></label>
        <select name="breastfeeding_past" class="form-control" id="breastfeeding_past" required>
                <option value="" disabled selected>select</option>
				<?php $saved_breastfeeding_past = isset( $breastfeeding_past ) && ( $breastfeeding_past == 'Yes' ) ? 'selected' : ''; ?>
                <option value="Yes" <?php echo $saved_breastfeeding_past; ?> >Yes</option>
				<?php $saved_breastfeeding_past = isset( $breastfeeding_past ) && ( $breastfeeding_past == 'No' ) ? 'selected' : ''; ?>
                <option value="No" <?php echo $saved_breastfeeding_past; ?> >No</option>
        </select>
        <div class="breastfeed_yes">
            <label class="additional-info-label">Have you previously experienced any pain or discomfort while pumping?  <span class="ast">*</span></label>
            <select name="breastfeeding_pain" class="form-control" id="breastfeeding_pain" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breastfeeding_pain = isset( $breastfeeding_pain ) && ( $breastfeeding_pain == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breastfeeding_pain; ?> >Yes</option>
					<?php $saved_breastfeeding_pain = isset( $breastfeeding_pain ) && ( $breastfeeding_pain == 'No' ) ? 'selected' : ''; ?>
                    <option value="No"  <?php echo $saved_breastfeeding_pain; ?> >No</option>
            </select>
            <div class="extra_comments" id="breastfeeding_pain_comments">
                <label class="additional-info-label">Please describe</label>
                <textarea class="form-control" name="breastfeeding_pain_comments" rows="5"><?php echo $breastfeeding_pain_comments;?></textarea>
            </div>

            <label class="additional-info-label">Have you ever had any redness or swelling of the breast while you were breastfeeding in the past (or have you been diagnosed with mastitis)? <span class="ast">*</span></label>
            <select name="breast_red_swelling" class="form-control" id="breast_red_swelling" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breast_red_swelling = isset( $breast_red_swelling ) && ( $breast_red_swelling == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breast_red_swelling; ?> >Yes</option>
					<?php $saved_breast_red_swelling = isset( $breast_red_swelling ) && ( $breast_red_swelling == 'No' ) ? 'selected' : ''; ?>
                    <option value="No"  <?php echo $saved_breast_red_swelling; ?> >No</option>
            </select>
            <div class="extra_comments" id="breast_red_swelling_comments">
                <label class="additional-info-label">Please describe</label>
                <textarea  class="form-control" name="breast_red_swelling_comments" rows="5"><?php echo $breast_red_swelling_comments;?></textarea>
            </div>


            <label class="additional-info-label">Have you ever experienced unexpected increases or decreases in your milk production? <span class="ast">*</span></label>
            <select name="breast_milk_amount_change" class="form-control" id="breast_milk_amount_change" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breast_milk_amount_change = isset( $breast_milk_amount_change ) && ( $breast_milk_amount_change == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breast_milk_amount_change; ?> >Yes</option>
					<?php $saved_breast_milk_amount_change = isset( $breast_milk_amount_change ) && ( $breast_milk_amount_change == 'No' ) ? 'selected' : ''; ?>
                    <option value="No" <?php echo $saved_breast_milk_amount_change; ?>  >No</option>
            </select>
            <div class="extra_comments" id="breast_milk_amount_change_comments">
                <label class="additional-info-label">Please describe</label>
                <textarea  class="form-control" name="breast_milk_amount_change_comments" rows="5"><?php echo $breast_milk_amount_change_comments;?></textarea>
            </div>
        </div>
    </div>

			<!--begin: Form Actions -->
			<div class="action-buttons">
				<div class="btn btn-brand btn-md btn-tall btn-wide action-button" id="action-submit">
					<button class="hfp-multi-step-form__submit" type="submit"><?php _e('Save', 'hfp'); ?></button>
					<input type="hidden"  name="account-additional-info" value="yes" />
					<input type="hidden" name="action" value="homefrontpump_step_3" />
				</div>
				<div class="load-spinner" style="display:none;"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/multistep/loader.gif"/></div>
			</div>

			<!--end: Form Actions -->


	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>

<script>
	jQuery(document).ready(function($){

		var selectedValue = $('#breastfeeding_past').val();
		if ( selectedValue == "Yes") {
			$('.breastfeed_yes').show();
		} else {
			$('.breastfeed_yes').hide();
		}

		selectedValue = $('#breastfeeding_pain').val();
		if ( selectedValue == "Yes") {
			$('#breastfeeding_pain_comments').show();
		} else {
			$('#breastfeeding_pain_comments').hide();
		}

		selectedValue = $('#breast_red_swelling').val();
		if ( selectedValue == "Yes") {
			$('#breast_red_swelling_comments').show();
		} else {
			$('#breast_red_swelling_comments').hide();
		}

		selectedValue = $('#breast_milk_amount_change').val();
		if ( selectedValue == "Yes") {
			$('#breast_milk_amount_change_comments').show();
		} else {
			$('#breast_milk_amount_change_comments').hide();
		}

		$("#action-next").click(function() {			
			$('#action-next').addClass('disabled');
			
			var form_data = new FormData();

			form_data.append('action', 'homefrontpump_step_3');
			form_data.append('assigned_sex', $('#assigned_sex').val());
			form_data.append('currently_pregnant', $('#currently_pregnant').val());

			form_data.append('breastfeeding_past', $('#breastfeeding_past').val());
			form_data.append('breastfeeding_pain', $('#breastfeeding_pain').val());
			form_data.append('breastfeeding_pain_comments', $('#breastfeeding_pain_comments textarea').val());

			form_data.append('breast_red_swelling', $('#breast_red_swelling').val());
			form_data.append('breast_red_swelling_comments', $('#breast_red_swelling_comments textarea').val());

			form_data.append('breast_milk_amount_change', $('#breast_milk_amount_change').val());
			form_data.append('breast_milk_amount_change_comments', $('#breast_milk_amount_change_comments textarea').val());

			form_data.append('additionalInfo', $('#additionalInfo').val());




			if (document.getElementById('face_file').files.length > 0)
				form_data.append("face_file", document.getElementById('face_file').files[0]);

			if ( document.getElementById('national_id_file').files.length > 0)
				form_data.append("national_id_file", document.getElementById('national_id_file').files[0]);

			$('div.load-spinner').show();
			$.ajax({
				url: global_creiden.ajax_url,
				type: "POST",
				data: form_data,
				contentType: false,
				processData: false,
				success: function(data) {
					$('#action-next').removeClass('disabled');
					$('div.load-spinner').hide();
					console.log(data);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					$('#action-next').removeClass('disabled');
					alert('erroooor:(');
					$('div.load-spinner').hide();
					alert(xhr.status);
					alert(thrownError);
				}
			});
		});


		$('#breastfeeding_past').on('change', function(){
			var selectedValue = $(this).val();
			if ( selectedValue == "Yes") {
				$('.breastfeed_yes').show();
			} else {
				$('.breastfeed_yes').hide();
			}
		});

		$('#breastfeeding_pain').on('change', function(){
			var selectedValue = $(this).val();
			if ( selectedValue == "Yes") {
				$('#breastfeeding_pain_comments').show();
			} else {
				$('#breastfeeding_pain_comments').hide();
			}
		});

		$('#breast_red_swelling').on('change', function(){
			var selectedValue = $(this).val();
			if ( selectedValue == "Yes") {
				$('#breast_red_swelling_comments').show();
			} else {
				$('#breast_red_swelling_comments').hide();
			}
		});


		$('#breast_milk_amount_change').on('change', function(){
			var selectedValue = $(this).val();
			if ( selectedValue == "Yes") {
				$('#breast_milk_amount_change_comments').show();
			} else {
				$('#breast_milk_amount_change_comments').hide();
			}
		});
	});
</script>