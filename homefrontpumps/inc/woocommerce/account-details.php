<?php
// Add the custom fields
add_action('woocommerce_edit_account_form', 'add_custom_fields_to_edit_account_form');
function add_custom_fields_to_edit_account_form()
{
    $user_id = get_current_user_id();
    $user = get_user_by('ID', $user_id);
    $lastname = get_user_meta($user_id, 'lastname', true);
    $firstname = get_user_meta($user_id, 'first_name', true);
    $dayDOB = get_user_meta($user_id, 'dayDOB', true);
    $dayDUE = get_user_meta($user_id, 'dayDUE', true);
    $monthDOB = get_user_meta($user_id, 'monthDOB', true);
    $monthDUE = get_user_meta($user_id, 'monthDUE', true);
    $yearDOB = get_user_meta($user_id, 'yearDOB', true);
    $yearDUE = get_user_meta($user_id, 'yearDUE', true);
    $phone = get_user_meta($user_id, 'phone', true);
    $doctorNameFirst = get_user_meta($user_id, 'doctorNameFirst', true);
    $doctorNameLast = get_user_meta($user_id, 'doctorNameLast', true);
    $doctorNumber = get_user_meta($user_id, 'doctorNumber', true);
    $prescription = get_user_meta($user_id, 'prescription', true);
    $primaryInsurance = get_user_meta($user_id, 'primaryInsurance', true);
    $dodNumber = get_user_meta($user_id, 'dodNumber', true);
    $sponsorName = get_user_meta($user_id, 'sponsorName', true);
    $sponsorNumber = get_user_meta($user_id, 'sponsorNumber', true);
    $sponsorRelationship = get_user_meta($user_id, 'sponsorRelationship', true);
    $receptionConfirmation = get_user_meta($user_id, 'receptionConfirmation', true);
    $additionalInfo = get_user_meta($user_id, 'additionalInfo', true);
    $signature = get_user_meta($user_id, 'signature', true);
    $statement = get_user_meta($user_id, 'statement', true);
    $terms = get_user_meta($user_id, 'terms', true);
    $streetAddress = get_user_meta($user_id, 'streetAddress', true);
    $unit = get_user_meta($user_id, 'unit', true);
    $shipping_city = get_user_meta($user_id, 'shipping_city', true);
    $shipping_postcode = get_user_meta($user_id, 'shipping_postcode', true);
    $shipping_state = get_user_meta($user_id, 'shipping_state', true);
    $accept_msgs = get_user_meta($user_id, 'accept_msgs', true);

    if ($sponsorRelationship == "Self") {
        $sponsorName = $firstname;
    }
?>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide hfp-account-multiselect">
        <label class="col-sm-12"><?php _e("Mother's Date of Birth", 'woocommerce'); ?> <span class="required">*</span></label>
        <?php
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="monthDOB" name="monthDOB" required>';
        echo '<option value="" disabled selected>month</option>';
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $saved_monthDOB = !empty($monthDOB) && ($monthDOB == $m) ? 'selected' : '';
            echo "<option value='$m'" . $saved_monthDOB . ">$m-$month</option>";
        }
        echo '</select>';
        echo '</span>';
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="dayDOB" name="dayDOB" required>';
        echo '<option value="" disabled selected>day</option>';
        for ($i = 1; $i <= 31; $i++) {
            $i = str_pad($i, 2, 0, STR_PAD_LEFT);
            $saved_dayDOB = !empty($dayDOB) && ($dayDOB == $i) ? 'selected' : '';
            echo "<option value='$i'" . $saved_dayDOB . ">$i</option>";
        }
        echo '</select>';
        echo '</span>';
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="yearDOB" name="yearDOB" required>';
        echo '<option value="" disabled selected>year</option>';
        for ($i = date('Y', strtotime('-10 years')); $i >= date('Y', strtotime('-100 years')); $i--) {
            $saved_yearDOB = !empty($yearDOB) && ($yearDOB == $i) ? 'selected' : '';
            echo "<option value='$i'" . $saved_yearDOB . ">$i</option>";
        }
        echo '</select>';
        echo '</span>';
        ?>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label><?php _e("Phone Number", 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="tel" id="phone" class="form-control" name="phone" placeholder="Phone Number" value="<?php echo isset($phone) ? $phone : '' ?>" required>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide hfp-account-multiselect">
        <label class="col-sm-12"><?php _e("Baby's Due Date or Birth Date", 'woocommerce'); ?> <span class="required">*</span></label>
        <?php
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="monthDUE" name="monthDUE" required>';
        echo '<option value="" disabled selected>month</option>';
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $saved_monthDUE = isset($monthDUE) && ($monthDUE == $m) ? 'selected' : '';
            echo "<option value='$m'" . $saved_monthDUE . ">$m-$month</option>";
        }
        echo '</select>';
        echo '</span>';
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="dayDUE" name="dayDUE" required>';
        echo '<option value="" disabled selected>day</option>';
        for ($i = 1; $i <= 31; $i++) {
            $i = str_pad($i, 2, 0, STR_PAD_LEFT);
            $saved_dayDUE = isset($dayDUE) && ($dayDUE == $i) ? 'selected' : '';
            echo "<option value='$i'" . $saved_dayDUE . ">$i</option>";
        }
        echo '</select>';
        echo '</span>';
        echo '<span class="hfp-account-multiselect__select">';
        echo '<select id="yearDUE" name="yearDUE" required>';
        echo '<option value="" disabled selected>year</option>';
        for ($i = date('Y', strtotime('+3 years')); $i >= date('Y', strtotime('-5 years')); $i--) {
            $saved_yearDUE = isset($yearDUE) && ($yearDUE == $i) ? 'selected' : '';
            echo "<option value='$i'" . $saved_yearDUE . ">$i</option>";
        }
        echo '</select>';
        echo '</span>';
        ?>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label>
            <input id="accept_msgs" type="checkbox" class="form-control" name="accept_msgs" checked />
            It’s OK to send me text messages about my order and account. This will greatly speed up order processing!
        </label>
    </p>
    </div>
    </section>
    <!-- End: Personal Information -->
    <!-- Begin: Insurance Information -->
    <section class="hfp-account-section" id="insurance-information">
        <h4 class="hfp-account-section__name"><a href="#insurance-information"># <?php _e('Insurance Information', 'hfp'); ?></a></h4>
        <div class=" hfp-account-section__panel">
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Primary Insurance", 'woocommerce'); ?> <span class="required">*</span></label>

                <?php 
                $payer_data = get_items_sync_dmez();
                ?>
                <select name="primaryInsurance" class="form-control" id="primaryInsurance" required>
                <option value="" disabled selected>select</option>
                <?php
                    foreach($payer_data as $payer) {
                        $savedPrimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == $payer->name) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $payer->name; ?>" <?php echo $savedPrimaryInsurance ?> data-payer-id="<?php echo $payer->id; ?>" > <?php echo $payer->name; ?> </option>
                        <?php
                    }					
                ?>
                </select>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Relationship to sponsor", 'woocommerce'); ?></label>
                <select name="sponsorRelationship" class="form-control" id="sponsorRelationship">
                    <option value="" disabled>select</option>
                    <?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Self') ? 'selected' : ''; ?>
                    <option value="Self" <?php echo $savedSponsorRelationship ?>>Self</option>
                    <?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Spouse') ? 'selected' : ''; ?>
                    <option value="Spouse" <?php echo $savedSponsorRelationship ?>>Spouse</option>
                    <?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Parent') ? 'selected' : ''; ?>
                    <option value="Parent" <?php echo $savedSponsorRelationship ?>>Parent</option>
                </select>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Sponsor Name", 'woocommerce'); ?> </label>
                <input id="sponsorName" type="text" class="form-control" name="sponsorName" placeholder="Sponsor Name" value="<?php echo isset($sponsorName) ? $sponsorName : '' ?>">
            </p>
            <div class="row">
              <div class="col-sm-12">
              ** We need either your DBN or SS number
            </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label><?php _e("DoD Benefits Number (DBN)", 'woocommerce'); ?> <span class="required">*</span></label>
                        <input id="dodNumber" type="text" class="form-control" name="dodNumber" value="<?php echo isset($dodNumber) ? $dodNumber : '' ?>" placeholder="DoD Benefits Number" required>
                        <span class="form-text">11-digit number on back of card</span>
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label><?php _e("Sponsor´s Social Number", 'woocommerce'); ?> <span class="required">*</span></label>
                        <input id="sponsorNumber" type="text" class="form-control" name="sponsorNumber" value="<?php echo isset($sponsorNumber) ? $sponsorNumber : '' ?>" placeholder="Sponsor´s Social Security Number" required>
                    </p>
                </div>
            </div>


        </div>
    </section>
    <!-- End: Insurance Information -->
    <!-- Begin: Prescription -->
    <section class="hfp-account-section" id="my-prescription">
        <h4 class="hfp-account-section__name"><a href="#my-prescription"># <?php _e('Prescription', 'hfp'); ?></a></h4>
        <div class=" hfp-account-section__panel">
            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Doctor/OB Name", 'woocommerce'); ?></label>
                <?php

                if ( $shipping_state == 'AZ' || $shipping_state == 'PA' || $shipping_state == 'WI' || $shipping_state == 'OH' || $shipping_state == 'NY' || $shipping_state == 'AE' || $shipping_state == 'AP' || $shipping_state == 'AA') {
                    $doctor_required = 'required';
                } else $doctor_required = '';
                 ?>
                <div class="row">
                    <div class="col-sm-6">
                        <input id="doctorNameFirst" type="text" class="form-control" name="doctorNameFirst" value="<?php echo isset($doctorNameFirst) ? $doctorNameFirst : '' ?>" placeholder="First Name" <?php echo $doctor_required; ?> >
                    </div>
                    <div class="col-sm-6">
                        <input id="doctorNameLast" type="text" class="form-control" name="doctorNameLast" value="<?php echo isset($doctorNameLast) ? $doctorNameLast : '' ?>" placeholder="Last Name" <?php echo $doctor_required; ?> >
                    </div>
                </div>
            </div>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Doctor/OB Phone Number", 'woocommerce'); ?></label>
                <input id="doctorNumber" type="tel" class="form-control" name="doctorNumber" value="<?php echo isset($doctorNumber) ? $doctorNumber : '' ?>" placeholder="Doctor/OB Number">
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Upload Prescription (if available)", 'woocommerce'); ?></label>
                <?php
                if (!empty($prescription)) {
                    foreach ($prescription as $prescription_id => $prescription_url) { ?>
                        <span class="hfp-attachment <?php echo (strpos(get_post_mime_type($prescription_id), 'image') !== false) ? 'hfp-attachment--img' : 'hfp-attachment--file'; ?>">
                            <?php if (strpos(get_post_mime_type($prescription_id), 'image') !== false) { ?>
                                <img class='js-userpp' src='<?php echo wp_get_attachment_image_src($prescription_id)[0]; ?>' alt=''>
                            <?php } else {
                                echo '<span>' . get_the_title($prescription_id) . '</span>';
                            } ?>
                            <a href='<?php echo wp_get_attachment_url($prescription_id); ?>' target="_blank">Download file</a>
                        </span>
                <?php }
                }
                ?>
                <input id="prescription" type="file" class="form-control custom-file-input__input js-prescriptionUpload" name="prescription[]" multiple>
            </p>
            <div class="clear"></div>
        </div>
    </section>
    <!-- End: Prescription -->


    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $("input:file").change(function() {

                var file_data = document.getElementById('prescription').files.length;

                var form_data = new FormData();

                for (var index = 0; index < file_data; index++) {
                    form_data.append("prescription[]", document.getElementById('prescription').files[index]);
                }

                form_data.append('action', 'homefrontpump_update_user_profile');
                form_data.append('user_id', <?php echo get_current_user_id(); ?>);

                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert('Files uploaded successfully. Finish editing your profile and click "Save Changes" to see changes.');
                        console.log('user profile update files');
                        console.log(data);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert('error');
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

            });

            var validator = $('.woocommerce-EditAccountForm').validate({
                // Validate only visible fields
                ignore: ":hidden",

                // Validation rules
                rules: {
                    phone: {
                        phoneUS: true
                    },
                    doctorNumber: {
                        phoneUS: true
                    },
                    dodNumber: {
                        exactlength: 11
                    },
                    sponsorNumber: {
                        ssnId: true
                    }
                },
                messages: {
                    phone: {
                        phoneUS: "Please specify a valid US phone number (10 digits)"
                    },
                    doctorNumber: {
                        phoneUS: "Please specify a valid US phone number (10 digits)"
                    }
                },
                // Display error
                invalidHandler: function(event, validator) {
                    document.documentElement.scrollTop = 0;
                },
            });
            jQuery.validator.addMethod("ssnId", function(value, element) {
                return this.optional(element) || /^(\d{3})-?\d{2}-?\d{4}$/i.test(value) || /^(\d{2})-?\d{7}$/i.test(value)
            }, "Invalid Sponsor Social security number");
            jQuery.validator.addMethod("csnId", function(value, element) {
                return this.optional(element) || /^(\d{3})-?\d{2}-?\d{4}$/i.test(value) || /^(\d{2})-?\d{7}$/i.test(value)
            }, "Invalid Customer Social security number");
            jQuery.validator.addMethod("exactlength", function(value, element, param) {
                return this.optional(element) || value.length == param;
            }, $.validator.format("Please enter exactly {0} digits."));

            $('#dodNumber').on('change', function() {
                if ($(this).valid() == true) {
                    $('#sponsorNumber').removeClass('.error').removeAttr('required');
                    $('#sponsorNumber').siblings('label').find('.required').hide();
                    $('#sponsorNumber').siblings('.error').hide();
                    $(this).attr('required', 'true');
                    $(this).siblings('label').find('.required').show();
                } else {
                    $('#sponsorNumber').attr('required', 'true');
                    $('#sponsorNumber').siblings('label').find('.required').show();
                    if ($('#sponsorNumber').valid() == true) {
                        $(this).removeAttr('required');
                        $(this).siblings('label').find('.required').hide();
                    }
                }
            });
            $('#sponsorNumber').on('change', function() {
                if ($(this).valid() == true) {
                    if ($('#dodNumber').valid() !== true) {
                        $('#dodNumber').removeClass('.error').removeAttr('required');
                        $('#dodNumber').siblings('label').find('.required').hide();
                        $('#dodNumber').siblings('.error').hide();
                    }
                } else {
                    $('#dodNumber').attr('required', 'true');
                    $('#dodNumber').siblings('label').find('.required').show();
                }
            });
            if ($("#dodNumber").valid() == true && $("#dodNumber").val().length !== 0) {
                $('#sponsorNumber').removeAttr('required');
                $('#sponsorNumber').siblings('label').find('.required').hide();
            }
            if ($("#sponsorNumber").valid() == true && $('#dodNumber').valid() !== true) {
                $('#dodNumber').removeAttr('required');
                $('#dodNumber').siblings('label').find('.required').hide();
            }

            $('#sponsorRelationship').on('change', function(){
                if ($(this).val() == "Self") {
                    $('#sponsorName').val( $('#account_first_name').val() );
                }
            });
            $('#account_first_name').on('change', function(){
                if ($('#sponsorRelationship').val() == "Self") {
                    $('#sponsorName').val( $('#account_first_name').val() );
                }
            });

        });
    </script>
<?php
}

// Check and validate the custom fields
add_action('woocommerce_save_account_details_errors', 'custom_fields_validation', 20, 1);
function custom_fields_validation($args)
{
    // validate input fields
    if (empty($_POST['phone'])) {
        $args->add('error', "<strong>ERROR</strong>: Phone is required.", '');
    }
    if (empty($_POST['monthDOB'])) {
        $args->add('error', "<strong>ERROR</strong>: Mother's Date of birth is required.", '');
    }
    if (empty($_POST['dayDOB'])) {
        $args->add('error', "<strong>ERROR</strong>: Mother's Date of birth is required.", '');
    }
    if (empty($_POST['yearDOB'])) {
        $args->add('error', "<strong>ERROR</strong>: Mother's Date of birth is required.", '');
    }
    if (empty($_POST['doctorNameFirst'])) {
        // $args->add('error', "<strong>ERROR</strong>: Doctor Name is required.", '');
    }
    if (empty($_POST['doctorNameLast'])) {
        // $args->add('error', "<strong>ERROR</strong>: Doctor Name is required.", '');
    }
    if (empty($_POST['primaryInsurance'])) {
        $args->add('error', "<strong>ERROR</strong>: Primary Insurance is required.", '');
    }
    if (empty($_POST['dodNumber'])) {
        $args->add('error', "<strong>ERROR</strong>: DOD benifits number is required.", '');
    }
    if (!empty($_POST['dodNumber']) && !preg_match('/^[0-9]{11}$/', $_POST['dodNumber'])) {
        $args->add('error', "<strong>ERROR</strong>: Invalid DOD benifits number, it must be 11 digits exact.", '');
    }
    if (empty($_POST['sponsorName'])) {
        $args->add('error', "<strong>ERROR</strong>: Sponsor Name is required.", '');
    }
    if (!empty($_POST['sponsorNumber']) && !preg_match('/^(\d{3})(\d{2})(\d{4})$/', $_POST['sponsorNumber'])) {
        $args->add('error', "<strong>ERROR</strong>:  Invalid Sponsor Social security number.", '');
    }
    if (empty($_POST['sponsorRelationship'])) {
        $args->add('error', "<strong>ERROR</strong>:  Sponsor relationship is required.", '');
    }
    if (empty($_POST['yearDUE'])) {
        $args->add('error', "<strong>ERROR</strong>: Child Due Date is required.", '');
    }
    if (empty($_POST['monthDUE'])) {
        $args->add('error', "<strong>ERROR</strong>: Child Due Date is required.", '');
    }
    if (empty($_POST['dayDUE'])) {
        $args->add('error', "<strong>ERROR</strong>: Child Due Date is required.", '');
    }
}

add_action('woocommerce_save_account_details', function () {

    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    $post_data = filter_input_array(
        INPUT_POST,
        [
            'account_first_name' => FILTER_SANITIZE_STRING,
            'account_last_name' => FILTER_SANITIZE_STRING,
            'monthDOB' => FILTER_SANITIZE_STRING,
            'dayDOB' => FILTER_SANITIZE_STRING,
            'yearDOB' => FILTER_VALIDATE_INT,
            'phone' => FILTER_SANITIZE_STRING,
            'monthDUE' => FILTER_SANITIZE_STRING,
            'dayDUE' => FILTER_SANITIZE_STRING,
            'yearDUE' => FILTER_SANITIZE_STRING,
            'doctorNameFirst' => FILTER_SANITIZE_STRING,
            'doctorNameLast' => FILTER_SANITIZE_STRING,
            'doctorNumber' => FILTER_SANITIZE_STRING,
            'primaryInsurance' => FILTER_SANITIZE_STRING,
            'dodNumber' => FILTER_SANITIZE_STRING,
            'sponsorName' => FILTER_SANITIZE_STRING,
            'sponsorNumber' => FILTER_SANITIZE_STRING,
            'sponsorRelationship' => FILTER_SANITIZE_STRING,
        ]
    );
    // Save meta data
    update_user_meta($user_id, 'first_name', $post_data['account_first_name']);
    update_user_meta($user_id, 'last_name', $post_data['account_last_name']);
    update_user_meta($user_id, 'monthDOB', $post_data['monthDOB']);
    update_user_meta($user_id, 'dayDOB', $post_data['dayDOB']);
    update_user_meta($user_id, 'yearDOB', $post_data['yearDOB']);
    update_user_meta($user_id, 'phone', $post_data['phone']);

    update_user_meta($user_id, 'monthDUE', $post_data['monthDUE']);
    update_user_meta($user_id, 'dayDUE', $post_data['dayDUE']);
    update_user_meta($user_id, 'yearDUE', $post_data['yearDUE']);
    update_user_meta($user_id, 'primaryInsurance', $post_data['primaryInsurance']);
    update_user_meta($user_id, 'dodNumber', $post_data['dodNumber']);
    update_user_meta($user_id, 'sponsorName', $post_data['sponsorName']);
    update_user_meta($user_id, 'sponsorNumber', $post_data['sponsorNumber']);
    update_user_meta($user_id, 'sponsorRelationship', $post_data['sponsorRelationship']);
    update_user_meta($user_id, 'doctorNameFirst', $post_data['doctorNameFirst']);
    update_user_meta($user_id, 'doctorNameLast', $post_data['doctorNameLast']);
    update_user_meta($user_id, 'doctorNumber', $post_data['doctorNumber']);

    update_user_meta($user_id, 'user_modified_flag', true); // For API checks
    
    if (empty(get_user_meta($user_id, 'site', true))) {
		update_user_meta($user_id, 'site', 'homefrontpumps.com');
	}

    $url = wc_get_endpoint_url( 'edit-account', '', wc_get_page_permalink( 'myaccount' ) );
    wp_safe_redirect( $url );
    exit;
});
