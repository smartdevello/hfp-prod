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
    $prescription = get_user_meta($user_id, 'prescription', true);
    $doctorNpiNumber = get_user_meta($user_id, 'doctorNpiNumber', true);
    $primaryInsurance = get_user_meta($user_id, 'primaryInsurance', true);
    $memberId = get_user_meta($user_id, 'memberId', true);
    $groupNumber = get_user_meta($user_id, 'groupNumber', true);
    $subscriberName = get_user_meta($user_id, 'subscriberName', true);
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
            <div class="row">
                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label>Name of Medical Insurance <span class="required">*</span></label>
                        <input id="primaryInsurance" placeholder="Medical Insurance" name="primaryInsurance" class="form-control" value="<?php echo isset($primaryInsurance) ? $primaryInsurance : ''; ?>" type="text" required />
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label>Member ID Number <span class="required">*</span></label>
                        <input id="memberId" type="text" class="form-control" name="memberId" value="<?php echo isset($memberId) ? $memberId : '' ?>" placeholder="Member ID Number" required />
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label>Group Number (if applicable)</label>
                        <input id="groupNumber" type="text" class="form-control" name="groupNumber" value="<?php echo isset($groupNumber) ? $groupNumber : '' ?>" placeholder="Group Number" />
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label>Name of Subscriber <span class="required">*</span></label>
                        <input id="subscriberName" type="text" class="form-control" name="subscriberName" value="<?php echo isset($subscriberName) ? $subscriberName : '' ?>" placeholder="Name of Subscriber" required />
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
                <label><?php _e("Doctor/OB Name", 'woocommerce'); ?> <span class="required">*</span></label>
                <div class="row">
                    <div class="col-sm-6">
                        <input id="doctorNameFirst" type="text" class="form-control" name="doctorNameFirst" value="<?php echo isset($doctorNameFirst) ? $doctorNameFirst : '' ?>" placeholder="First Name" required>
                    </div>
                    <div class="col-sm-6">
                        <input id="doctorNameLast" type="text" class="form-control" name="doctorNameLast" value="<?php echo isset($doctorNameLast) ? $doctorNameLast : '' ?>" placeholder="Last Name" required>
                    </div>
                </div>
            </div>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label><?php _e("Doctor/OB NPI Number", 'woocommerce'); ?> <span class="required">*</span></label>
                <input id="doctorNpiNumber" type="tel" class="form-control" name="doctorNpiNumber" value="<?php echo isset($doctorNpiNumber) ? $doctorNpiNumber : '' ?>" placeholder="Doctor/OB NPI Number" required>
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
        $args->add('error', "<strong>ERROR</strong>: Doctor Name is required.", '');
    }
    if (empty($_POST['doctorNameLast'])) {
        $args->add('error', "<strong>ERROR</strong>: Doctor Name is required.", '');
    }
    if (empty($_POST['primaryInsurance'])) {
        $args->add('error', "<strong>ERROR</strong>: Medical Insurance is required.", '');
    }
    if (empty($_POST['memberId'])) {
        $args->add('error', "<strong>ERROR</strong>: Member ID number is required.", '');
    }
    if (empty($_POST['subscriberName'])) {
        $args->add('error', "<strong>ERROR</strong>: Subscriber Name number is required.", '');
    }
    if (empty($_POST['doctorNpiNumber'])) {
        $args->add('error', "<strong>ERROR</strong>: Doctor/OB NPI Number is required.", '');
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
            'subscriberName' => FILTER_SANITIZE_STRING,
            'memberId' => FILTER_SANITIZE_STRING,
            'doctorNpiNumber' => FILTER_SANITIZE_STRING,
            'doctorNumber' => FILTER_SANITIZE_STRING,
            'primaryInsurance' => FILTER_SANITIZE_STRING,
            'dodNumber' => FILTER_SANITIZE_STRING,
            'sponsorName' => FILTER_SANITIZE_STRING,
            'sponsorNumber' => FILTER_SANITIZE_STRING,
            'sponsorRelationship' => FILTER_SANITIZE_STRING,
            'groupNumber' => FILTER_SANITIZE_STRING
        ]
    );
    // Save meta data
    update_user_meta($user_id, 'first_name', $post_data['account_first_name']);
    update_user_meta($user_id, 'last_name', $post_data['account_last_name']);
    update_user_meta($user_id, 'monthDOB', $post_data['monthDOB']);
    update_user_meta($user_id, 'dayDOB', $post_data['dayDOB']);
    update_user_meta($user_id, 'yearDOB', $post_data['yearDOB']);
    update_user_meta($user_id, 'phone', $post_data['phone']);
    update_user_meta($user_id, 'groupNumber', $post_data['groupNumber']);
    update_user_meta($user_id, 'subscriberName', $post_data['subscriberName']);
    update_user_meta($user_id, 'memberId', $post_data['memberId']);
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
    update_user_meta($user_id, 'doctorNpiNumber', $post_data['doctorNpiNumber']);

    update_user_meta($user_id, 'user_modified_flag', true); // For API checks
});
