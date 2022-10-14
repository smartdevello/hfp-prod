<div class="accesories_tab">
    <div class="step-heading">Prescription Information</div>

<?php
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
    <div class="form-group option_sets_selector">
        <?php

        ?>


        <div style="font-weight: bold;">There are three ways to validate your prescription. Please choose the option that best fits you:</div>

        <div class="prescription_select_div">
            <?php $saved_validate_prescription = isset($validate_prescription) && ($validate_prescription == 'option_set1') ? 'checked' : '';
            ?>
            <input type="radio" id="option_set1_radio" name="validate_prescription" value="option_set1" <?php echo  $saved_validate_prescription;?> >
            <label for="option_set1_radio">Easiest and fastest option to get you your supplies.</label><br>
        </div>

        <div class="prescription_select_div">
            <?php $saved_validate_prescription = isset($validate_prescription) && ($validate_prescription == 'option_set2') ? 'checked' : ''; ?>
            <input type="radio" id="option_set2_radio" name="validate_prescription" value="option_set2" <?php echo  $saved_validate_prescription;?> >
            <label for="option_set2_radio">Provide your doctor/OB information.</label><br>
        </div>

        <div class="prescription_select_div">
            <?php $saved_validate_prescription = isset($validate_prescription) && ($validate_prescription == 'option_set3') ? 'checked' : ''; ?>
            <input type="radio" id="option_set3_radio" name="validate_prescription" value="option_set3" <?php echo  $saved_validate_prescription;?> >
            <label for="option_set3_radio">Already have a prescription? Upload it here.</label><br>
        </div>

    </div>

    <div class="form-group option_set" id="option_set1" >
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
            <hr>
        </div>

        <label >What was your assigned sex at birth?  <span class="ast">*</span></label>		
        <select name="assigned_sex" class="form-control" id="assigned_sex" required>
                <option value="" disabled selected>select</option>
				<?php $saved_assigned_sex = isset( $assigned_sex ) && ( $assigned_sex == 'male' ) ? 'selected' : ''; ?>
                <option value="male"  <?php echo $saved_assigned_sex; ?> >Male</option>
				<?php $saved_assigned_sex = isset( $assigned_sex ) && ( $assigned_sex == 'female' ) ? 'selected' : ''; ?>
                <option value="female"  <?php echo $saved_assigned_sex; ?> >Female</option>
        </select>

        <hr>
        <label >Are you currently pregnant?  <span class="ast">*</span></label>
        <select name="currently_pregnant" class="form-control" id="currently_pregnant" required>
                <option value="" disabled selected>select</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'Yes' ) ? 'selected' : ''; ?>
                <option value="Yes"  <?php echo $saved_currently_pregnant; ?> >Yes</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'No, baby born in the past 6 months' ) ? 'selected' : ''; ?>
                <option value="No, baby born in the past 6 months"  <?php echo $saved_currently_pregnant; ?> >No, baby born in the past 6 months</option>
				<?php $saved_currently_pregnant = isset( $currently_pregnant ) && ( $currently_pregnant == 'No, baby born more than 6 months ago' ) ? 'selected' : ''; ?>
                <option value="No, baby born more than 6 months ago" <?php echo $saved_currently_pregnant; ?>  >No, baby born more than 6 months ago</option>
        </select>
        <hr>
        <label >Have you ever breastfed in the past?  <span class="ast">*</span></label>
        <select name="breastfeeding_past" class="form-control" id="breastfeeding_past" required>
                <option value="" disabled selected>select</option>
				<?php $saved_breastfeeding_past = isset( $breastfeeding_past ) && ( $breastfeeding_past == 'Yes' ) ? 'selected' : ''; ?>
                <option value="Yes" <?php echo $saved_breastfeeding_past; ?> >Yes</option>
				<?php $saved_breastfeeding_past = isset( $breastfeeding_past ) && ( $breastfeeding_past == 'No' ) ? 'selected' : ''; ?>
                <option value="No" <?php echo $saved_breastfeeding_past; ?> >No</option>
        </select>
        <hr>
        <div class="breastfeed_yes">
            <label >Have you previously experienced any pain or discomfort while pumping?  <span class="ast">*</span></label>
            <select name="breastfeeding_pain" class="form-control" id="breastfeeding_pain" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breastfeeding_pain = isset( $breastfeeding_pain ) && ( $breastfeeding_pain == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breastfeeding_pain; ?> >Yes</option>
					<?php $saved_breastfeeding_pain = isset( $breastfeeding_pain ) && ( $breastfeeding_pain == 'No' ) ? 'selected' : ''; ?>
                    <option value="No"  <?php echo $saved_breastfeeding_pain; ?> >No</option>
            </select>
            <div class="extra_comments" id="breastfeeding_pain_comments">
                <label>Please describe</label>
                <textarea class="form-control" name="breastfeeding_pain_comments" rows="5"><?php echo $breastfeeding_pain_comments;?></textarea>
            </div>

            <label >Have you ever had any redness or swelling of the breast while you were breastfeeding in the past (or have you been diagnosed with mastitis)? <span class="ast">*</span></label>
            <select name="breast_red_swelling" class="form-control" id="breast_red_swelling" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breast_red_swelling = isset( $breast_red_swelling ) && ( $breast_red_swelling == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breast_red_swelling; ?> >Yes</option>
					<?php $saved_breast_red_swelling = isset( $breast_red_swelling ) && ( $breast_red_swelling == 'No' ) ? 'selected' : ''; ?>
                    <option value="No"  <?php echo $saved_breast_red_swelling; ?> >No</option>
            </select>
            <div class="extra_comments" id="breast_red_swelling_comments">
                <label>Please describe</label>
                <textarea  class="form-control" name="breast_red_swelling_comments" rows="5"><?php echo $breast_red_swelling_comments;?></textarea>
            </div>


            <label >Have you ever experienced unexpected increases or decreases in your milk production? <span class="ast">*</span></label>
            <select name="breast_milk_amount_change" class="form-control" id="breast_milk_amount_change" required>
                    <option value="" disabled selected>select</option>
					<?php $saved_breast_milk_amount_change = isset( $breast_milk_amount_change ) && ( $breast_milk_amount_change == 'Yes' ) ? 'selected' : ''; ?>
                    <option value="Yes" <?php echo $saved_breast_milk_amount_change; ?> >Yes</option>
					<?php $saved_breast_milk_amount_change = isset( $breast_milk_amount_change ) && ( $breast_milk_amount_change == 'No' ) ? 'selected' : ''; ?>
                    <option value="No" <?php echo $saved_breast_milk_amount_change; ?>  >No</option>
            </select>
            <div class="extra_comments" id="breast_milk_amount_change_comments">
                <label>Please describe</label>
                <textarea  class="form-control" name="breast_milk_amount_change_comments" rows="5"><?php echo $breast_milk_amount_change_comments;?></textarea>
            </div>


        </div>
    </div>

    <div class="form-group option_set" id="option_set2">
        <div class="authorize">We will contact your provider and request for them to fax a document back to us. Note: This verification method could take a few weeks</div>


        <label>Doctor/OB Name <span class="ast">*</span></label>
        <div class="row">
            <div class="col-sm-6">
                <input id="doctorNameFirst" type="text" class="form-control" name="doctorNameFirst" value="<?php echo isset( $doctorNameFirst ) ? $doctorNameFirst : '' ?>" placeholder="First Name" required>
            </div>
            <div class="col-sm-6">
                <input id="doctorNameLast" type="text" class="form-control" name="doctorNameLast" value="<?php echo isset( $doctorNameLast ) ? $doctorNameLast : '' ?>" placeholder="Last Name" required>
            </div>
        </div>

        <label>Doctor/OB Phone Number<span class="ast">*</span></label>
        <input id="doctorNumber" type="tel" class="form-control" name="doctorNumber" value="<?php echo isset( $doctorNumber ) ? $doctorNumber : '' ?>" placeholder="Doctor/OB Number" required>

    </div>


    <div class="form-group custom-file-input option_set" id="option_set3">
        <label>Upload Prescription (if available) </label>
        <?php
        if(isset($prescription) && !empty( $prescription ) ) { ?>
            <span><?php _e('(This file was uploaded before)','hfp');?></span>
        <?php
        }
        ?>
        <label class="custom-file-input__label" for="prescription">
            <span class="custom-file-input__button"><?php _e('Choose a File','hfp');?></span>
            <span class="custom-file-input__name js-prescriptionName"></span>
        </label>
        <input  id="prescription" type="file" class="form-control custom-file-input__input js-prescriptionUpload" name="prescription[]" multiple required>

    </div>        

	<div class="form-group">
		<label>How did you hear about us?</label>
		<select name="hear" class="form-control" id="hear">
			<option>select</option>
			<option>Dr. Office</option>
			<option>Friends and family</option>
			<option>Social media ( Instagram, Facebook, Twitter)</option>
			<option>Blogs</option>
			<option>Online search</option>
			<option>TRICARE referred</option>
			<option>Other</option>
		</select>
	</div>
	<div class="form-group" style="display: none" id="otherReason">
		<label>Other (please specify)</label>
		<input type="text" class="form-control" name="otherReason" placeholder="Please specify how did you hear about us">
	</div>
</div>