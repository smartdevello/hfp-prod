<?php

add_action('wp_ajax_login_from_new_form', 'login_from_new_form');
add_action('wp_ajax_nopriv_login_from_new_form', 'login_from_new_form');
function login_from_new_form()
{

    setcookie('login_from_new_form', 'true', time() + 3600, '/');
    wp_die();
}

add_action('wp_login', function () {

    if (isset($_COOKIE['login_from_new_form'])) { // Redirected from the new form
        setcookie('login_from_new_form', '', time() - 3600, '/');
        wp_redirect(get_template_page_url('templates/page-new-multistepForm.php'));
        exit;
    }
});

add_action('admin_post_new_multi_step_form_action', 'new_multi_step_form_submission');
add_action('admin_post_nopriv_new_multi_step_form_action', 'new_multi_step_form_submission');
function new_multi_step_form_submission()
{


    $post_data = filter_input_array(
        INPUT_POST,
        [
            'firstname' => FILTER_SANITIZE_STRING,
            'lastname' => FILTER_SANITIZE_STRING,
            'monthDOB' => FILTER_SANITIZE_STRING,
            'dayDOB' => FILTER_SANITIZE_STRING,
            'yearDOB' => FILTER_VALIDATE_INT,
            'phone' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_SANITIZE_STRING,
            'streetAddress' => FILTER_SANITIZE_STRING,
            'unit' => FILTER_SANITIZE_STRING,
            'city' => FILTER_SANITIZE_STRING,
            'state' => FILTER_SANITIZE_STRING,
            'postcode' => FILTER_SANITIZE_STRING,
            'signature' => FILTER_SANITIZE_STRING,
            'receptionConfirmation' => FILTER_SANITIZE_STRING,
            'productReceived' => FILTER_SANITIZE_STRING,
            'productChoose' => FILTER_SANITIZE_STRING,
            'fooby' => FILTER_SANITIZE_STRING,
            'additionalInfo' => FILTER_SANITIZE_STRING,
            'register_for_showers' => FILTER_SANITIZE_STRING,
        ]
    );

    //    if( is_user_logged_in() ) { // Registered user
    //        $user_id = get_current_user_id();
    //    } else if( ! is_user_logged_in() ) { // Not registered user
    ////        $userdata = array(
    ////           'user_login'  => $post_data['firstname'],
    ////           'user_email'  => $post_data['email'],
    ////           'user_pass'   => $post_data['password']
    ////       );
    ////       $user_id = wp_insert_user( $userdata );
    //
    ////       update_user_meta( $user_id, 'lastname', $post_data['lastname'] );
    //    }

    // Save submitted data

    //    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    //    $userdata = array(
    //           'ID'  => $user_id,
    //           'user_login'  => $post_data['firstname'],
    //       );
    //    wp_update_user( $userdata );
    global $wpdb;
    //    $wpdb->update( $wpdb->users, array( 'user_login' => $post_data['firstname'] ), array( 'ID' => $user_id ) );

    if (!empty($post_data['firstname'])) {
        update_user_meta($user_id, 'first_name', $post_data['firstname']);
    }
    if (!empty($post_data['lastname'])) {
        update_user_meta($user_id, 'last_name', $post_data['lastname']);
    }
    if (!empty($post_data['monthDOB'])) {
        update_user_meta($user_id, 'monthDOB', $post_data['monthDOB']);
    }
    if (!empty($post_data['dayDOB'])) {
        update_user_meta($user_id, 'dayDOB', $post_data['dayDOB']);
    }
    if (!empty($post_data['yearDOB'])) {
        update_user_meta($user_id, 'yearDOB', $post_data['yearDOB']);
    }
    if (!empty($post_data['phone'])) {
        update_user_meta($user_id, 'phone', $post_data['phone']);
    }
    if (!empty($post_data['signature'])) {
        update_user_meta($user_id, 'signature', $post_data['signature']);
    }

    //shipping data
    if (!empty($post_data['streetAddress'])) {
        update_user_meta($user_id, 'shipping_address_1', $post_data['streetAddress']);
        update_user_meta($user_id, 'streetAddress', $post_data['streetAddress']);
    }
    if (!empty($post_data['streetAddress']) && !empty($post_data['unit'])) {
        update_user_meta($user_id, 'shipping_address_1', $post_data['streetAddress'] . ', ' . $post_data['unit']);
        update_user_meta($user_id, 'unit', $post_data['unit']);
    }
    if (!empty($post_data['firstname'])) {
        update_user_meta($user_id, 'shipping_first_name', $post_data['firstname']);
    }
    if (!empty($post_data['lastname'])) {
        update_user_meta($user_id, 'shipping_last_name', $post_data['lastname']);
    }
    if (!empty($post_data['city'])) {
        update_user_meta($user_id, 'shipping_city', $post_data['city']);
    }
    if (!empty($post_data['postcode'])) {
        update_user_meta($user_id, 'shipping_postcode', $post_data['postcode']);
    }
    if (!empty($post_data['state'])) {
        update_user_meta($user_id, 'shipping_state', $post_data['state']);
    }
    if (!empty($post_data['additionalInfo'])) {
        update_user_meta($user_id, 'additionalInfo', $post_data['additionalInfo']);
    }
    if (!empty($post_data['register_for_showers'])) {
        update_user_meta($user_id, 'register_for_showers', $post_data['register_for_showers']);
    }

    if (!empty($post_data['receptionConfirmation'])) {
        update_user_meta($user_id, 'receptionConfirmation', $post_data['receptionConfirmation']);
    }

    //product
    if (!empty($post_data['productChoose'])) {
        update_user_meta($user_id, 'chosen_product_id', $post_data['productChoose']);
    }
    if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1 ) {
        update_user_meta($user_id, 'fooby', $post_data['fooby']);
    }

    // Create order
    $products = [];

    if (!empty($post_data['productChoose'])) {
        $products[] = $post_data['productChoose'];
    }
    if (!empty($post_data['fooby']) && $post_data['fooby'] != -1) {
        $products[] = $post_data['fooby'];
    }

    order_free_product($products, $post_data['firstname'], $post_data['lastname'], $post_data['streetAddress'] . $post_data['unit'], $post_data['city'], $post_data['state'], $post_data['postcode'], $user_id, $post_data['email'], 'new_multi_step_form');

    // Send email
    $user_firstname = $post_data['firstname'];

    // $from = get_option('admin_email');
    // $headers = "From: $from";
    // $message = "Dear $user_firstname , \n We have received your order and are working on it! If you have any questions, feel free to contact us at support@homefrontpumps.com.";
    // wp_mail($post_data['email'], 'Home Front Pumps', $message, $headers, "-f " . $from);

    update_user_meta($user_id, 'new_form_progress', 4); // final step submitted
    // update_user_meta($user_id, 'user_modified_flag', true); // For API checks

    update_user_meta($user_id, 'free_product_acquired', true);
    
    if (empty(get_user_meta($user_id, 'site', true))) {
		update_user_meta($user_id, 'site', 'homefrontpumps.com');
	}

    unset_user_email_cookie();
    $url = get_template_page_url('templates/page-thankyou.php');
    wp_redirect($url);
    exit;
}

add_action('wp_ajax_homefrontpump_register_login_new_form', 'homefrontpump_register_login_new_form');
add_action('wp_ajax_nopriv_homefrontpump_register_login_new_form', 'homefrontpump_register_login_new_form');

function homefrontpump_register_login_new_form()
{    
    $post_data = filter_input_array(
        INPUT_POST,
        [
            'firstname' => FILTER_SANITIZE_STRING,
            'lastname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
            'monthDOB' => FILTER_SANITIZE_STRING,
            'dayDOB' => FILTER_SANITIZE_STRING,
            'yearDOB' => FILTER_VALIDATE_INT,
            'monthDUE' => FILTER_SANITIZE_STRING,
            'dayDUE' => FILTER_SANITIZE_STRING,
            'yearDUE' => FILTER_SANITIZE_STRING,
            'phone' => FILTER_SANITIZE_STRING,
            'streetAddress' => FILTER_SANITIZE_STRING,
            'unit' => FILTER_SANITIZE_STRING,
            'city' => FILTER_SANITIZE_STRING,
            'state' => FILTER_SANITIZE_STRING,
            'postcode' => FILTER_SANITIZE_STRING,
            'primaryInsurance' => FILTER_SANITIZE_STRING,
            'statement' => FILTER_SANITIZE_STRING,
            'terms' => FILTER_SANITIZE_STRING,
            'accept_msgs' => FILTER_SANITIZE_STRING,
            'register_page' => FILTER_SANITIZE_STRING,
        ]
    );

    if (!is_user_logged_in()) { // Not a logged-in user

        $user_id = email_exists($post_data['email']);
        if (email_exists($post_data['email'])) {
            $user_id = get_user_by('email', $post_data['email'])->ID;
            echo hfp_registered_message($user_id);
            die();
        }
        if (!$user_id) {
            $user_id = homefrontpump_register_user($post_data['firstname'], $post_data['lastname'], $post_data['email'], $post_data['password']);

            // Send welcome email
            $user_email = $post_data['email'];
            $firstname  = $post_data['firstname'];
            // add_filter('wp_new_user_notification_email', function ($wp_new_user_notification_email) use ($user_email, $firstname) {

            //     $message = "Dear $firstname, \n Thanks for registering with Home Front Pumps!";
            //     $from = get_option('admin_email');
            //     $wp_new_user_notification_email = array(
            //         'to'      => $user_email,
            //         /* translators: Login details notification email subject. %s: Site title. */
            //         'subject' => __('HomeFrontPumps'),
            //         'message' => $message,
            //         'headers' => "From: $from",
            //     );

            //     return $wp_new_user_notification_email;
            // });
            // wp_send_new_user_notifications($user_id);
        }

        automatic_login($post_data['email']);
    } else {
        $user_id = get_current_user_id();
    }

    // Save user meta
    if (!empty($post_data['phone'])) {
        update_user_meta($user_id, 'phone', $post_data['phone']);
    }

    if (!empty($post_data['monthDOB'])) {
        update_user_meta($user_id, 'monthDOB', $post_data['monthDOB']);
    }
    if (!empty($post_data['dayDOB'])) {
        update_user_meta($user_id, 'dayDOB', $post_data['dayDOB']);
    }
    if (!empty($post_data['yearDOB'])) {
        update_user_meta($user_id, 'yearDOB', $post_data['yearDOB']);
    }
    if (!empty($post_data['monthDUE'])) {
        update_user_meta($user_id, 'monthDUE', $post_data['monthDUE']);
    }
    if (!empty($post_data['dayDUE'])) {
        update_user_meta($user_id, 'dayDUE', $post_data['dayDUE']);
    }
    if (!empty($post_data['yearDUE'])) {
        update_user_meta($user_id, 'yearDUE', $post_data['yearDUE']);
    }
    if (!empty($post_data['primaryInsurance'])) {
        update_user_meta($user_id, 'primaryInsurance', $post_data['primaryInsurance']);
    }
    if (!empty($post_data['register_page'])) {
        update_user_meta($user_id, 'register_page', $post_data['register_page']);
    }
    if (!empty($post_data['accept_msgs'])) {
        $accept_msgs = 1;
    } else {
        $accept_msgs = 0;
    }
    update_user_meta($user_id, 'accept_msgs',  $accept_msgs);

    //shipping data
    if (!empty($post_data['streetAddress'])) {
        update_user_meta($user_id, 'shipping_address_1', $post_data['streetAddress']);
        update_user_meta($user_id, 'streetAddress', $post_data['streetAddress']);
    }
    if (!empty($post_data['streetAddress']) && !empty($post_data['unit'])) {
        update_user_meta($user_id, 'shipping_address_1', $post_data['streetAddress'] . ', ' . $post_data['unit']);
        update_user_meta($user_id, 'unit', $post_data['unit']);
    }
    if (!empty($post_data['firstname'])) {
        update_user_meta($user_id, 'first_name', $post_data['firstname']);
        update_user_meta($user_id, 'shipping_first_name', $post_data['firstname']);
    }
    if (!empty($post_data['lastname'])) {
        update_user_meta($user_id, 'last_name', $post_data['lastname']);
        update_user_meta($user_id, 'shipping_last_name', $post_data['lastname']);
    }
    if (!empty($post_data['city'])) {
        update_user_meta($user_id, 'shipping_city', $post_data['city']);
    }
    if (!empty($post_data['postcode'])) {
        update_user_meta($user_id, 'shipping_postcode', $post_data['postcode']);
    }
    if (!empty($post_data['state'])) {
        update_user_meta($user_id, 'shipping_state', $post_data['state']);
    }
    if (!empty($post_data['statement'])) {
        update_user_meta($user_id, 'statement', $post_data['statement']);
    }
    if (!empty($post_data['terms'])) {
        update_user_meta($user_id, 'terms', $post_data['terms']);
    }

    // Additional meta
    if (empty(get_user_meta($user_id, 'personal_information_completed', true))) {
        update_user_meta($user_id, 'personal_information_completed', 0);
    }
    if (empty(get_user_meta($user_id, 'personal_information_verified', true))) {
        update_user_meta($user_id, 'personal_information_verified', 0);
    }
    if (empty(get_user_meta($user_id, 'insurance_information_completed', true))) {
        update_user_meta($user_id, 'insurance_information_completed', 0);
    }
    if (empty(get_user_meta($user_id, 'insurance_information_verified', true))) {
        update_user_meta($user_id, 'insurance_information_verified', 0);
    }
    if (empty(get_user_meta($user_id, 'user_date_update_api', true))) {
        update_user_meta($user_id, 'user_date_update_api', 0);
    }
    if (empty(get_user_meta($user_id, 'user_date_touch_api', true))) {
        update_user_meta($user_id, 'user_date_touch_api', 0);
    }

    $new_form_progress_meta = get_user_meta($user_id, 'new_form_progress', true);
    if (empty($multi_step_form_progress_meta)) {
        update_user_meta($user_id, 'new_form_progress', 1); // step 1 submitted
    }
    update_user_meta($user_id, 'form_in_progress', 2); // indicates that the new facebook form is in progress to be used in redirection from finishOrder template
    // update_user_meta($user_id, 'user_modified_flag', true); // For API checks

    // Update sendinblue users list
    $params = [
        'email' => $user_email,
        'attributes' => [
            'FIRSTNAME' => $post_data['firstname'],
            'LASTNAME' => $post_data['lastname'],
        ],
        'listIds' => [11],
    ];
    update_sendinblue_users_list($params);

    echo get_current_user_id();
    die;
}

add_action('wp_ajax_homefrontpump_step_2_new_form', 'homefrontpump_save_step_2_new_form');
add_action('wp_ajax_nopriv_homefrontpump_step_2_new_form', 'homefrontpump_save_step_2_new_form');
function homefrontpump_save_step_2_new_form()
{

    $user_id = get_current_user_id();
    $post_data = filter_input_array(
        INPUT_POST,
        [
            'doctorNameFirst' => FILTER_SANITIZE_STRING,
            'doctorNameLast' => FILTER_SANITIZE_STRING,
            'doctorNumber' => FILTER_SANITIZE_STRING,
            'dodNumber' => FILTER_SANITIZE_STRING,
            'sponsorName' => FILTER_SANITIZE_STRING,
            'sponsorNumber' => FILTER_SANITIZE_STRING,
            'sponsorRelationship' => FILTER_SANITIZE_STRING,
        ]
    );

    if (!empty($post_data['dodNumber'])) {
        update_user_meta($user_id, 'dodNumber', $post_data['dodNumber']);
    }
    if (!empty($post_data['sponsorName'])) {
        update_user_meta($user_id, 'sponsorName', $post_data['sponsorName']);
    }
    if (!empty($post_data['sponsorNumber'])) {
        update_user_meta($user_id, 'sponsorNumber', $post_data['sponsorNumber']);
    }
    if (!empty($post_data['sponsorRelationship'])) {
        update_user_meta($user_id, 'sponsorRelationship', $post_data['sponsorRelationship']);
    }
    if (!empty($post_data['doctorNameFirst'])) {
        update_user_meta($user_id, 'doctorNameFirst', $post_data['doctorNameFirst']);
    }
    if (!empty($post_data['doctorNameLast'])) {
        update_user_meta($user_id, 'doctorNameLast', $post_data['doctorNameLast']);
    }
    if (!empty($post_data['doctorNumber'])) {
        update_user_meta($user_id, 'doctorNumber', $post_data['doctorNumber']);
    }
    // update_user_meta($user_id, 'user_modified_flag', true); // For API checks
}

add_action('wp_ajax_homefrontpump_step_3_new_form', 'homefrontpump_save_step_3_new_form');
add_action('wp_ajax_nopriv_homefrontpump_step_3_new_form', 'homefrontpump_save_step_3_new_form');
function homefrontpump_save_step_3_new_form()
{

    $user_id = get_current_user_id();
    $post_data = filter_input_array(
        INPUT_POST,
        [
            'prescription' => FILTER_SANITIZE_STRING,
            'hear' => FILTER_SANITIZE_STRING,
            'otherReason' => FILTER_SANITIZE_STRING,
        ]
    );

    if (!empty($post_data['hear'])) {
        update_user_meta($user_id, 'hear', $post_data['hear']);
    }
    if (!empty($post_data['otherReason'])) {
        update_user_meta($user_id, 'otherReason', $post_data['otherReason']);
    }

    if (!empty($_FILES['prescription'])) {
        // Save prescription
        hfp_uploadImages($user_id, 'prescription', 'prescriptionHash');
    }
    // update_user_meta($user_id, 'user_modified_flag', true); // For API checks
}

if (!is_admin()) {
    add_action('user_profile_update_errors', 'validateProfileFieldsNewForm');
}

function validateProfileFieldsNewForm(WP_Error &$errors)
{
    // validate input fields
    if (empty($_POST['phone'])) {
        $errors->add('phone', "<strong>ERROR</strong>: Phone is required.");
    }
    if (!empty($_POST['phone']) && !preg_match('/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/', $_POST['phone'])) {
        $errors->add('phone', "<strong>ERROR</strong>: Invalid Phone Number, it must be a US.");
    }
    if (empty($_POST['monthDOB'])) {
        $errors->add('monthDOB', "<strong>ERROR</strong>: Mother's Date of birth is required.");
    }
    if (empty($_POST['dayDOB'])) {
        $errors->add('dayDOB', "<strong>ERROR</strong>: Mother's Date of birth is required.");
    }
    if (empty($_POST['yearDOB'])) {
        $errors->add('yearDOB', "<strong>ERROR</strong>: Mother's Date of birth is required.");
    }
    if (empty($_POST['doctorNameFirst'])) {
        $errors->add('doctorNameFirst', "<strong>ERROR</strong>: Doctor Name is required.");
    }
    if (empty($_POST['doctorNameLast'])) {
        $errors->add('doctorNameLast', "<strong>ERROR</strong>: Doctor Name is required.");
    }
    if (!empty($_POST['doctorNumber']) && !preg_match('/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/', $_POST['doctorNumber'])) {
        $errors->add('doctorNumber', "<strong>ERROR</strong>:  Invalid Doctor Phone Number, it must be a US.");
    }
    if (empty($_POST['primaryInsurance'])) {
        $errors->add('primaryInsurance', "<strong>ERROR</strong>: Primary Insurance is required.");
    }
    if (empty($_POST['dodNumber'])) {
        $errors->add('dodNumber', "<strong>ERROR</strong>: DOD benifits number is required.");
    }
    if (!empty($_POST['dodNumber']) && !preg_match('/^[0-9]{11}$/', $_POST['dodNumber'])) {
        $errors->add('dodNumber', "<strong>ERROR</strong>: Invalid DOD benifits number, it must be 11 digits exact.");
    }
    if (!empty($_POST['sponsorNumber']) && !preg_match('/^(\d{3})(\d{2})(\d{4})$/', $_POST['sponsorNumber'])) {
        $errors->add('sponsorNumber', "<strong>ERROR</strong>:  Invalid Sponsor Social security number.");
    }
    if (empty($_POST['sponsorRelationship'])) {
        $errors->add('sponsorRelationship', "<strong>ERROR</strong>:  Sponsor relationship is required.");
    }
    if (empty($_POST['yearDUE'])) {
        $errors->add('yearDUE', "<strong>ERROR</strong>: Child Due Date is required.");
    }
    if (empty($_POST['monthDUE'])) {
        $errors->add('monthDUE', "<strong>ERROR</strong>: Child Due Date is required.");
    }
    if (empty($_POST['dayDUE'])) {
        $errors->add('dayDUE', "<strong>ERROR</strong>: Child Due Date is required.");
    }
    return $errors;
}
