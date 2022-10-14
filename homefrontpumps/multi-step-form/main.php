<?php

add_action('admin_post_get_free_product_action', 'get_free_product_submission');
add_action('admin_post_nopriv_get_free_product_action', 'get_free_product_submission');
function get_free_product_submission()
{
	$user_email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
	setcookie('user_email', $user_email, time() + 360000, '/');
	if (!email_exists($user_email)) { // Email doesn't exist
		// Redirects to the multi step form
		wp_redirect(get_template_page_url('templates/page-onestep-form-bootsandbabies-t.php'));
		exit;
	}

	// Email exists
	set_free_product_cookie(); // To indicate redirection from this submission
	wp_redirect(home_url() . '/wp-login.php');
	exit;
}

add_action('wp_login', function () {

	if (isset($_COOKIE['free_product'])) { // Redirected after get free product submission
		unset_free_product_cookie();
		$free_product_acquired = check_user_free_product_acquisition(get_current_user_id());

		if (empty($free_product_acquired)) { // Free product hasn't been acquired before
			wp_redirect(get_template_page_url('templates/page-multistepForm.php'));
			exit;
		}
	}
});

add_action('admin_post_multi_step_form_action', 'multi_step_form_submission');
add_action('admin_post_nopriv_multi_step_form_action', 'multi_step_form_submission');
function multi_step_form_submission()
{


	$post_data = filter_input_array(
		INPUT_POST,
		[
			'firstname'             => FILTER_SANITIZE_STRING,
			'lastname'              => FILTER_SANITIZE_STRING,
			'monthDOB'              => FILTER_SANITIZE_STRING,
			'dayDOB'                => FILTER_SANITIZE_STRING,
			'yearDOB'               => FILTER_VALIDATE_INT,
			'phone'                 => FILTER_SANITIZE_STRING,
			'email'                 => FILTER_SANITIZE_EMAIL,
			'password'              => FILTER_SANITIZE_STRING,
			'streetAddress'         => FILTER_SANITIZE_STRING,
			'unit'                  => FILTER_SANITIZE_STRING,
			'city'                  => FILTER_SANITIZE_STRING,
			'state'                 => FILTER_SANITIZE_STRING,
			'postcode'              => FILTER_SANITIZE_STRING,
			'signature'             => FILTER_SANITIZE_STRING,
			'statement'             => FILTER_SANITIZE_STRING,
			'terms'                 => FILTER_SANITIZE_STRING,
			'receptionConfirmation' => FILTER_SANITIZE_STRING,
			'productReceived'       => FILTER_SANITIZE_STRING,
			'productChoose'         => FILTER_SANITIZE_STRING,
			'fooby'                 => FILTER_SANITIZE_STRING,
			'hear'                  => FILTER_SANITIZE_STRING,
			'otherReason'           => FILTER_SANITIZE_STRING,
			'additionalInfo'        => FILTER_SANITIZE_STRING,
			'register_for_showers'        => FILTER_SANITIZE_STRING,
		]
	);

	$current_user = wp_get_current_user();
	$user_id      = $current_user->ID;

	global $wpdb;

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
	if (!empty($post_data['statement'])) {
		update_user_meta($user_id, 'statement', $post_data['statement']);
	}
	if (!empty($post_data['terms'])) {
		update_user_meta($user_id, 'terms', $post_data['terms']);
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
	// Indicate step 4 submission
	update_user_meta($user_id, 'multi_step_form_progress', 4);

	if (!empty($post_data['receptionConfirmation'])) {
		update_user_meta($user_id, 'receptionConfirmation', $post_data['receptionConfirmation']);
	}
	if (!empty($post_data['additionalInfo'])) {
		update_user_meta($user_id, 'additionalInfo', $post_data['additionalInfo']);
	}
	
	if (!empty($post_data['register_for_showers'])) {			
		update_user_meta($user_id, 'register_for_showers', $post_data['register_for_showers']);
	}
	if (!empty($post_data['hear'])) {
		update_user_meta($user_id, 'hear', $post_data['hear']);
	}
	if (!empty($post_data['otherReason'])) {
		update_user_meta($user_id, 'otherReason', $post_data['otherReason']);
	}
	//product
	if (!empty($post_data['productChoose'])) {
		update_user_meta($user_id, 'chosen_product_id', $post_data['productChoose']);
	}
	if (!empty($post_data['fooby']) && $post_data['fooby'] != -1) {
		update_user_meta($user_id, 'fooby', $post_data['fooby']);
	}


	// Create order
	$products = [];

	if (!empty($post_data['productChoose'])) {
		$products[] = $post_data['productChoose'];
	}
	if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1 ) {
		$products[] = $post_data['fooby'];
	}

	order_free_product($products, $post_data['firstname'], $post_data['lastname'], $post_data['streetAddress'] . $post_data['unit'], $post_data['city'], $post_data['state'], $post_data['postcode'], $user_id, $post_data['email'], 'multi_step_form');

	// Send email
	$user_firstname = $post_data['firstname'];

	if (empty(get_user_meta($user_id, 'site', true))) {
		update_user_meta($user_id, 'site', 'homefrontpumps.com');
	}
	update_user_meta($user_id, 'free_product_acquired', true);
	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks
	unset_user_email_cookie();
	$url = get_template_page_url('templates/page-thankyou.php');
	wp_redirect($url);
	exit;
}

function check_user_free_product_acquisition($user_id)
{
	return get_user_meta($user_id, 'free_product_acquired', true);
}

function get_template_page_url($template_file)
{
	$url   = null;
	$pages = get_pages(array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => $template_file
	));
	if (isset($pages[0])) {
		$url = get_page_link($pages[0]->ID);
	}

	return $url;
}

function order_free_product($products, $shipping_first_name, $shipping_last_name, $shipping_address_1, $shipping_city, $shipping_state, $shipping_postcode, $user_id, $user_email, $form_name)
{
	$order = wc_create_order();
	foreach ($products as $product_id) {
		$order->add_product(wc_get_product($product_id), 1);
	}


	//    add_filter( 'woocommerce_email_recipient_customer_invoice', function( $recipient ) use( $user_email ) {
	//    $recipient = $user_email;
	//    return $recipient;
	//
	//    });
	update_post_meta($order->get_id(), '_shipping_first_name', $shipping_first_name);
	update_post_meta($order->get_id(), '_shipping_last_name', $shipping_last_name);
	update_post_meta($order->get_id(), '_shipping_address_1', $shipping_address_1);
	update_post_meta($order->get_id(), '_shipping_city', $shipping_city);
	update_post_meta($order->get_id(), '_shipping_state', $shipping_state);
	update_post_meta($order->get_id(), '_shipping_postcode', $shipping_postcode);
	update_post_meta($order->get_id(), '_customer_user', $user_id);
	update_post_meta($order->get_id(), 'order_verified', 0);
	update_post_meta($order->get_id(), 'prescription_cmn_status', 0);
	update_post_meta($order->get_id(), 'prescription_cmn_url', 0);
	update_post_meta($order->get_id(), 'order_date_update_api', 0);
	update_post_meta($order->get_id(), 'order_date_touch_api', 0);
	update_post_meta($order->get_id(), 'order_modified_flag', true); // For API checks
	update_post_meta($order->get_id(), 'form_name', $form_name);
}

function save_form_user_meta($user_id)
{
	update_user_meta($user_id, 'user_name', $_POST['user_name']);
}

function set_free_product_cookie()
{
	setcookie('free_product', 'true', time() + 3600, '/');
}

function unset_free_product_cookie()
{
	setcookie('free_product', '', time() - 3600, '/');
}

function unset_user_email_cookie()
{
	setcookie('user_email', '', time() - 3600, '/');
}

function homefrontpump_register_user($first_name, $last_name, $email, $password)
{
	$userdata = array(
		//        'user_login'  => $first_name,
		'user_login'   => $email,
		'user_email'   => $email,
		'user_pass'    => $password,
		'display_name' => $first_name,
	);
	$user_id  = wp_insert_user($userdata);

	update_user_meta($user_id, 'lastname', $last_name);

    do_action( 'woocommerce_created_customer', $user_id, $userdata, false);

	return $user_id;
}

function automatic_login($user_email)
{
	$user    = get_user_by('email', $user_email);
	$user_id = $user->ID;
	wp_set_current_user($user_id);
	wp_set_auth_cookie($user_id, 1);
}

function hfp_registered_message($user_id)
{
	$user_blog_id = is_multisite() ? get_active_blog_for_user($user_id)->blog_id : '';
	$blog_url = preg_replace('#^https?://#', '', get_home_url($user_blog_id));
	$message = 'You are already registered with us.<br /><a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">Please login here</a>';
	if (is_multisite()) {
		$message = get_active_blog_for_user($user_id)->blog_id == get_current_blog_id() ? $message : 'We are partners with ' . $blog_url . '.<br/>So you can use the same login and <a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">login here</a>';
	}

	return json_encode(['success' => 'false', 'message' => $message]);
}


add_action('wp_ajax_homefrontpump_register_login', 'homefrontpump_register_login');
add_action('wp_ajax_nopriv_homefrontpump_register_login', 'homefrontpump_register_login');

function homefrontpump_register_login()
{


	$post_data = filter_input_array(
		INPUT_POST,
		[
			'firstname'     => FILTER_SANITIZE_STRING,
			'lastname'      => FILTER_SANITIZE_STRING,

			'monthDOB'      => FILTER_SANITIZE_STRING,
			'dayDOB'        => FILTER_SANITIZE_STRING,
			'yearDOB'       => FILTER_VALIDATE_INT,
			'monthDUE'      => FILTER_SANITIZE_STRING,
			'dayDUE'        => FILTER_SANITIZE_STRING,
			'yearDUE'       => FILTER_VALIDATE_INT,		
						
			'email'         => FILTER_SANITIZE_STRING,
			'password'      => FILTER_SANITIZE_STRING,
			'phone'         => FILTER_SANITIZE_STRING,

			'streetAddress' => FILTER_SANITIZE_STRING,
			'unit'          => FILTER_SANITIZE_STRING,
			'city'          => FILTER_SANITIZE_STRING,
			'state'         => FILTER_SANITIZE_STRING,
			'postcode'      => FILTER_SANITIZE_STRING,
			'accept_msgs'   => FILTER_SANITIZE_STRING,
			'register_page'   => FILTER_SANITIZE_STRING,
		]
	);

	if (!is_user_logged_in()) { // Not a logged-in user
		$user_email = $post_data['email'];
		$firstname  = $post_data['firstname'];

		if (email_exists($user_email)) {
			$user_id = get_user_by('email', $user_email)->ID;
			echo hfp_registered_message($user_id);
			die();
		}

		$user_id = homefrontpump_register_user($post_data['firstname'], $post_data['lastname'], $post_data['email'], $post_data['password']);

		// Send welcome email
		// add_filter('wp_new_user_notification_email', function ($wp_new_user_notification_email) use ($user_email, $firstname) {

		// 	$message                        = "Dear $firstname, \n Thanks for registering with Home Front Pumps!";
		// 	$from                           = get_option('admin_email');
		// 	$wp_new_user_notification_email = array(
		// 		'to'      => $user_email,
		// 		/* translators: Login details notification email subject. %s: Site title. */
		// 		'subject' => __('HomeFrontPumps'),
		// 		'message' => $message,
		// 		'headers' => "From: $from",
		// 	);

		// 	return $wp_new_user_notification_email;
		// });
		
		// wp_send_new_user_notifications($user_id);

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

	if (!empty($post_data['register_page'])) {
		update_user_meta($user_id, 'register_page', $post_data['register_page']);
	}
	if (!empty($post_data['accept_msgs'])) {
		$accept_msgs = 1;
	} else {
		$accept_msgs = 0;
	}
	update_user_meta($user_id, 'accept_msgs', $accept_msgs);

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



	if (empty(get_user_meta($user_id, 'site', true))) {
		update_user_meta($user_id, 'site', 'homefrontpumps.com');
	}
	update_user_meta($user_id, 'form_in_progress', 1); // indicates that the main multistep form is in progress to be used in redirection from finishOrder template
	//update_user_meta($user_id, 'user_modified_flag', true); // For API checks

	// Update sendinblue users list
	$params = [
		'email'      => $user_email,
		'attributes' => [
			'FIRSTNAME' => $post_data['firstname'],
			'LASTNAME'  => $post_data['lastname'],
		],
		'listIds'    => [11],
	];
	update_sendinblue_users_list($params);

	echo get_current_user_id();
	die;
}

add_action('wp_ajax_homefrontpump_step_2', 'homefrontpump_save_step_2');
add_action('wp_ajax_nopriv_homefrontpump_step_2', 'homefrontpump_save_step_2');
function homefrontpump_save_step_2()
{

	$user_id   = get_current_user_id();
	$post_data = filter_input_array(
		INPUT_POST,
		[
			'primaryInsurance'    => FILTER_SANITIZE_STRING,
			'dodNumber'           => FILTER_SANITIZE_STRING,
			'sponsorName'         => FILTER_SANITIZE_STRING,
			'sponsorRelationship' => FILTER_SANITIZE_STRING,
			'receptionConfirmation' => FILTER_SANITIZE_STRING,
			'productChoose' => FILTER_SANITIZE_STRING,
			'fooby' => FILTER_SANITIZE_STRING,
		]
	);

	if (!empty($post_data['primaryInsurance'])) {
		update_user_meta($user_id, 'primaryInsurance', $post_data['primaryInsurance']);
	}

	if (!empty($post_data['sponsorName'])) {
		update_user_meta($user_id, 'sponsorName', $post_data['sponsorName']);
	}
	if (!empty($post_data['dodNumber'])) {
		update_user_meta($user_id, 'dodNumber', $post_data['dodNumber']);
	}
	if (!empty($post_data['sponsorRelationship'])) {
		update_user_meta($user_id, 'sponsorRelationship', $post_data['sponsorRelationship']);
	}

	if (!empty($post_data['receptionConfirmation'])) {
		update_user_meta($user_id, 'receptionConfirmation', $post_data['receptionConfirmation']);
	}


	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks
}


add_action('admin_post_homefrontpump_step_3', 'homefrontpump_save_step_3');
add_action('admin_post_nopriv_homefrontpump_step_3', 'homefrontpump_save_step_3');

add_action('wp_ajax_homefrontpump_step_3', 'homefrontpump_save_step_3');
add_action('wp_ajax_nopriv_homefrontpump_step_3', 'homefrontpump_save_step_3');
function homefrontpump_save_step_3()
{

	$user_id   = get_current_user_id();

	$post_data = filter_input_array(
		INPUT_POST,
		[
			'validate_prescription'    => FILTER_SANITIZE_STRING,
			'doctorNameFirst' => FILTER_SANITIZE_STRING,
			'doctorNameLast' => FILTER_SANITIZE_STRING,
			'doctorNumber' => FILTER_SANITIZE_STRING,
			'assigned_sex' => FILTER_SANITIZE_STRING,
			'currently_pregnant' => FILTER_SANITIZE_STRING,

			'breastfeeding_past' => FILTER_SANITIZE_STRING,
			'breastfeeding_pain' => FILTER_SANITIZE_STRING,
			'breastfeeding_pain_comments' => FILTER_SANITIZE_STRING,
			'breast_red_swelling' => FILTER_SANITIZE_STRING,
			'breast_red_swelling_comments' => FILTER_SANITIZE_STRING,
			'breast_milk_amount_change' => FILTER_SANITIZE_STRING,
			'breast_milk_amount_change_comments' => FILTER_SANITIZE_STRING,

			'additionalInfo' => FILTER_SANITIZE_STRING,
			'account-additional-info' => FILTER_SANITIZE_STRING,
		]
	);

	if (!empty($post_data['validate_prescription'])) {
		update_user_meta($user_id, 'validate_prescription', $post_data['validate_prescription']);
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
	if (!empty($post_data['assigned_sex'])) {
		update_user_meta($user_id, 'assigned_sex', $post_data['assigned_sex']);
	}

	if (!empty($post_data['currently_pregnant'])) {
		update_user_meta($user_id, 'currently_pregnant', $post_data['currently_pregnant']);
	}


	if (!empty($post_data['breastfeeding_past'])) {
		update_user_meta($user_id, 'breastfeeding_past', $post_data['breastfeeding_past']);
	}

	if (!empty($post_data['breastfeeding_pain'])) {
		update_user_meta($user_id, 'breastfeeding_pain', $post_data['breastfeeding_pain']);
	}

	if (!empty($post_data['breastfeeding_pain_comments'])) {
		update_user_meta($user_id, 'breastfeeding_pain_comments', $post_data['breastfeeding_pain_comments']);
	}
	

	if (!empty($post_data['breast_red_swelling'])) {
		update_user_meta($user_id, 'breast_red_swelling', $post_data['breast_red_swelling']);
	}

	if (!empty($post_data['breast_red_swelling_comments'])) {
		update_user_meta($user_id, 'breast_red_swelling_comments', $post_data['breast_red_swelling_comments']);
	}


	if (!empty($post_data['breast_milk_amount_change'])) {
		update_user_meta($user_id, 'breast_milk_amount_change', $post_data['breast_milk_amount_change']);
	}

	if (!empty($post_data['breast_milk_amount_change_comments'])) {
		update_user_meta($user_id, 'breast_milk_amount_change_comments', $post_data['breast_milk_amount_change_comments']);
	}

	if (!empty($post_data['additionalInfo'])) {
		update_user_meta($user_id, 'additionalInfo', $post_data['additionalInfo']);
	}
	

	if (!empty($_FILES['prescription'])) {
		// Save prescription
        hfp_uploadImages($user_id, 'prescription', 'prescriptionHash');
	}


	if (!empty($_FILES['face_file']) && !empty($_FILES['face_file']['name']) ) {
		// Save face_file
		hfp_uploadImage($user_id, 'face_file', 'selfieHash');

	}


	if (!empty($_FILES['national_id_file']) && !empty($_FILES['national_id_file']['name'])) {
		// Save national ID file
		hfp_uploadImage($user_id, 'national_id_file', 'nationalIdHash');

	}





	//If this submit is from the the page "/my-account/additional-info/" then redirect to that page.
	if (!empty($post_data['account-additional-info']) && $post_data['account-additional-info'] == 'yes') {
		update_user_meta($user_id, 'user_modified_flag', true); // For API checks
		require_once ( get_home_path() . PLUGINDIR . '/woocommerce/includes/wc-notice-functions.php' ); 		
		WC()->session = new WC_Session_Handler();
		WC()->session->init();
				
		wc_add_notice( __( 'Additional information saved successfully.', 'woocommerce' ) );
		$url = wc_get_endpoint_url( 'additional-info', '', wc_get_page_permalink( 'myaccount' ) );
		wp_safe_redirect( $url );
		
		exit;
	}
}


add_action('show_user_profile', 'extra_profile_fields', 10);
add_action('edit_user_profile', 'extra_profile_fields', 10);
function extra_profile_fields($user)
{ ?>

	<h3><?php _e('Extra User Details'); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="registered_site">Registered Site</label></th>			
			<td>
				<input type="text" name="registered_site" id="registered_site" value="<?php echo esc_attr(get_user_meta($user->ID, 'site', true)); ?>" class="regular-text" required /><br />
			</td>
		</tr>
		<tr>
			<th><label for="free_product_acquired">Free Product Acquired</label></th>
			<td>
				<input type="checkbox" name="free_product_acquired" id="free_product_acquired" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'free_product_acquired', true)) ? "checked" : ""; ?> /><br />
				<span class="description">Check if user has acquired the free product.</span>
			</td>
		</tr>
		<tr>
			<th><label for="accept_msgs">Accept Messages</label></th>
			<td>
				<input type="checkbox" name="accept_msgs" id="accept_msgs" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'accept_msgs', true)) ? "checked" : ""; ?> /><br />
				<span class="description">It’s OK to send text messages about order and account.</span>
			</td>
		</tr>
		<tr>
			<th><label for="event_tricare">Event Tricare</label></th>
			<td>
				<input type="checkbox" name="event_tricare" id="event_tricare" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'event_tricare', true)) ? "checked" : ""; ?> /><br />
				<span class="description">By registering for this event, you are allowing Homefront Pumps to verify your eligibility as a Tricare beneficiary.</span>
			</td>
		</tr>
		<tr>
			<th><label for="event_sponsors">Event Sponsors</label></th>
			<td>
				<input type="checkbox" name="event_sponsors" id="event_sponsors" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'event_sponsors', true)) ? "checked" : ""; ?> /><br />
				<span class="description">By registering for this event, you are allowing any and all event sponsors listed to contact you.</span>
			</td>
		</tr>
		<tr>
			<th><label for="register_for_showers">Register me for showers</label></th>
			<td>
				<input type="checkbox" name="register_for_showers" id="register_for_showers" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'register_for_showers', true)) ? "checked" : ""; ?> /><br />
			</td>
		</tr>
		<tr>
			<th><label for="register_giveaway">Register me for this giveaway</label></th>
			<td>
				<input type="checkbox" name="register_giveaway" id="register_giveaway" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'register_giveaway', true)) ? "checked" : ""; ?> /><br />
			</td>
		</tr>
		<tr>
			<th><label for="giveaway_groupname">Giveaway Group Name</label></th>
			<td>
				<input type="text" name="giveaway_groupname" id="giveaway_groupname" value="<?php echo esc_attr(get_user_meta($user->ID, 'giveaway_groupname', true)); ?>" class="regular-text" required /><br />
			</td>
		</tr>
		
		<tr>
			<th><label for="received_shower">Received Shower</label></th>
			<td>
				<input type="checkbox" name="received_shower" id="received_shower" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'received_shower', true)) ? "checked" : ""; ?> /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_date_update_api">user_date_update_api Meta</label></th>
			<td>
				<input type="checkbox" name="user_date_update_api" id="user_date_update_api" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'user_date_update_api', true)) ? "checked" : ""; ?> /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_date_touch_api">user_date_touch_api Meta</label></th>
			<td>
				<input type="checkbox" name="user_date_touch_api" id="user_date_touch_api" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'user_date_touch_api', true)) ? "checked" : ""; ?> /><br />
			</td>
		</tr>
		<tr>
			<th><label for="register_page">Register Page</label></th>
			<td>
				<input type="text" name="register_page" id="register_page" value="<?php echo esc_attr(get_user_meta($user->ID, 'register_page', true)); ?>" class="regular-text" readonly /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_phone">Phone</label></th>
			<td>
				<input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" required /><br />
				<span class="description">Enter Phone. ( must be 10 digits US phone ex: NXXNXXXXXX where N=digits 2–9, X=digits 0–9 )</span>
			</td>
		</tr>
		<tr>
			<th><label for="doctorNameFirst">Doctor First Name</label></th>
			<td>
				<input type="text" name="doctorNameFirst" id="doctorNameFirst" value="<?php echo esc_attr(get_user_meta($user->ID, 'doctorNameFirst', true)); ?>" class="regular-text" required /><br />
				<span class="description">Enter Doctor First Name.</span>
			</td>
		</tr>
		<tr>
			<th><label for="doctorNameLast">Doctor Last Name</label></th>
			<td>
				<input type="text" name="doctorNameLast" id="doctorNameLast" value="<?php echo esc_attr(get_user_meta($user->ID, 'doctorNameLast', true)); ?>" class="regular-text" required /><br />
				<span class="description">Enter Doctor Last Name.</span>
			</td>
		</tr>
		<tr>
			<th><label for="doctorNumber">Doctor Number</label></th>
			<td>
				<input type="text" name="doctorNumber" id="doctorNumber" value="<?php echo esc_attr(get_user_meta($user->ID, 'doctorNumber', true)); ?>" class="regular-text" /><br />
				<span class="description">Enter Doctor Number. ( must be 10 digits US phone ex: NXXNXXXXXX where N=digits 2–9, X=digits 0–9 )</span>
			</td>
		</tr>

		<tr>
			<th><label for="dodNumber">DOD Benifits Number</label></th>
			<td>
				<input type="text" name="dodNumber" id="dodNumber" value="<?php echo esc_attr(get_user_meta($user->ID, 'dodNumber', true)); ?>" class="regular-text" required /><br />
				<span class="description">Enter DOD benifits number. ( must be 11 digits )</span>
			</td>
		</tr>
		<tr>
			<th><label for="doctorNameFirst">Sponsor´s Name</label></th>
			<td>
				<input type="text" name="sponsorName" id="sponsorName" value="<?php echo esc_attr(get_user_meta($user->ID, 'sponsorName', true)); ?>" class="regular-text" required /><br />
				<span class="description">Enter Sponsor´s Name.</span>
			</td>
		</tr>
		<tr>
			<th><label for="sponsorNumber">Sponsor´s Social Security Number</label></th>
			<td>
				<input type="text" name="sponsorNumber" id="sponsorNumber" value="<?php echo esc_attr(get_user_meta($user->ID, 'sponsorNumber', true)); ?>" class="regular-text" /><br />
				<span class="description">Enter Sponsor´s Social Security Number. ( must be 9 digits )</span>
			</td>
		</tr>
		<tr>
			<th><label for="sponsorRelationship">Sponsor Relationship</label></th>
			<td>
				<select name="sponsorRelationship" class="form-control" id="sponsorRelationship">
					<option value="" disabled selected>select</option>
					<?php
					$sponsorRelationship      = get_user_meta($user->ID, 'sponsorRelationship', true);
					$savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Self') ? 'selected' : ''; ?>
					<option value="Self" <?php echo $savedSponsorRelationship ?>>Self</option>
					<?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Spouse') ? 'selected' : ''; ?>
					<option value="Spouse" <?php echo $savedSponsorRelationship ?>>Spouse</option>
					<?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Parent') ? 'selected' : ''; ?>
					<option value="Parent" <?php echo $savedSponsorRelationship ?>>Parent</option>
				</select>
				<br />
				<span class="description">Enter Sponsor relationship.</span>
			</td>
		</tr>

		<tr>
			<th><label for="face_file_img">Face</label></th>
			<?php $face_files = get_user_meta($user->ID, 'face_file', true);
			if (!empty($face_files)) { ?>
				<td>
					<?php foreach ($face_files as $face_id => $face_url) { ?>
						<div class="hfp-attachment <?php echo (strpos(get_post_mime_type($face_id), 'image') !== false) ? 'hfp-attachment--img' : 'hfp-attachment--file'; ?>">
							<?php if (strpos(get_post_mime_type($face_id), 'image') !== false) { ?>
								<img class='js-userpp' src='<?php echo wp_get_attachment_image_src($face_id)[0]; ?>' alt=''>
							<?php } else {
								echo '<span>' . get_the_title($face_id) . '</span>';
							} ?>
							<a href='<?php echo wp_get_attachment_url($face_id); ?>' target="_blank">Download
								file</a>
						</div>
					<?php } ?>
				</td>
			<?php } ?>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="file" name="face_file" id="face_file" value="<?php echo esc_attr(wp_get_attachment_url(get_user_meta($user->ID, 'face_file', true))); ?>" class="regular-text"  /><br />
				<span class="description">Upload Face.</span>
			</td>
		</tr>

		<tr>
			<th><label for="national_id_file_img">National ID or Driver License</label></th>
			<?php $nationalID_files = get_user_meta($user->ID, 'national_id_file', true);
			if (!empty($nationalID_files)) { ?>
				<td>
					<?php foreach ($nationalID_files as $national_id => $face_url) { ?>
						<div class="hfp-attachment <?php echo (strpos(get_post_mime_type($national_id), 'image') !== false) ? 'hfp-attachment--img' : 'hfp-attachment--file'; ?>">
							<?php if (strpos(get_post_mime_type($national_id), 'image') !== false) { ?>
								<img class='js-userpp' src='<?php echo wp_get_attachment_image_src($national_id)[0]; ?>' alt=''>
							<?php } else {
								echo '<span>' . get_the_title($national_id) . '</span>';
							} ?>
							<a href='<?php echo wp_get_attachment_url($national_id); ?>' target="_blank">Download
								file</a>
						</div>
					<?php } ?>
				</td>
			<?php } ?>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="file" name="national_id_file" id="national_id_file" value="<?php echo esc_attr(wp_get_attachment_url(get_user_meta($user->ID, 'face_file', true))); ?>" class="regular-text"  /><br />
				<span class="description">Upload National ID or Driver License.</span>
			</td>
		</tr>

		<tr>
			<th><label for="assigned_sex">What was your assigned sex at birth?</label></th>
			<td>
				<select name="assigned_sex" class="form-control" id="assigned_sex" required>
					<option value="" disabled selected>select</option>
					<?php
					$assigned_sex      = get_user_meta($user->ID, 'assigned_sex', true);
					$saved_assigned_sex = isset($assigned_sex) && ($assigned_sex == 'male') ? 'selected' : ''; ?>
					<option value="male" <?php echo $saved_assigned_sex ?>>Male</option>
					<?php $saved_assigned_sex = isset($assigned_sex) && ($assigned_sex == 'female') ? 'selected' : ''; ?>
					<option value="female" <?php echo $saved_assigned_sex ?>>Female</option>

				</select>
				<span class="description">Select assigned sex at birth</span>
			</td>
		</tr>

		<tr>
			<th><label for="currently_pregnant">Are you currently pregnant?</label></th>
			<td>
				<select name="currently_pregnant" class="form-control" id="currently_pregnant" required>
					<option value="" disabled selected>select</option>
					<?php
					$currently_pregnant      = get_user_meta($user->ID, 'currently_pregnant', true);

					$saved_currently_pregnant = isset($currently_pregnant) && ($currently_pregnant == 'Yes') ? 'selected' : ''; ?>
					<option value="Yes" <?php echo $saved_currently_pregnant ?>>Yes</option>

					<?php $saved_currently_pregnant = isset($currently_pregnant) && ($currently_pregnant == 'No, baby born in the past 6 months') ? 'selected' : ''; ?>
					<option value="No, baby born in the past 6 months" <?php echo $saved_currently_pregnant ?>>No, baby born in the past 6 months</option>
					
					<?php $saved_currently_pregnant = isset($currently_pregnant) && ($currently_pregnant == 'No, baby born more than 6 months ago') ? 'selected' : ''; ?>
					<option value="No, baby born more than 6 months ago" <?php echo $saved_currently_pregnant ?>>No, baby born more than 6 months ago</option>

				</select>
				<span class="description">Select one of them</span>
			</td>
		</tr>

		<tr>
			<th><label for="breastfeeding_past">Have you ever breastfed in the past?</label></th>
			<td>
				<select name="breastfeeding_past" class="form-control" id="breastfeeding_past" required>
					<option value="" disabled selected>select</option>
					<?php
					$breastfeeding_past      = get_user_meta($user->ID, 'breastfeeding_past', true);

					$savedVal = isset($breastfeeding_past) && ($breastfeeding_past == 'Yes') ? 'selected' : ''; ?>
					<option value="Yes" <?php echo $savedVal ?>>Yes</option>

					<?php $savedVal = isset($breastfeeding_past) && ($breastfeeding_past == 'No') ? 'selected' : ''; ?>
					<option value="No" <?php echo $savedVal ?>>No</option>		

				</select>
				<span class="description">Select one of them</span>
			</td>
		</tr>

		<tr>
			<th><label for="breastfeeding_pain">Have you previously experienced any pain or discomfort while pumping?</label></th>
			<td>
				<select name="breastfeeding_pain" class="form-control" id="breastfeeding_pain" required>
					<option value="" disabled selected>select</option>
					<?php
					$breastfeeding_pain      = get_user_meta($user->ID, 'breastfeeding_pain', true);

					$savedVal = isset($breastfeeding_pain) && ($breastfeeding_pain == 'Yes') ? 'selected' : ''; ?>
					<option value="Yes" <?php echo $savedVal ?>>Yes</option>

					<?php $savedVal = isset($breastfeeding_pain) && ($breastfeeding_pain == 'No') ? 'selected' : ''; ?>
					<option value="No" <?php echo $savedVal ?>>No</option>		

				</select>
				<span class="description">Select one of them</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Breastfeeding Pain Comments </label></th>
			<td>
				<div class="form-group">
					<textarea id="breastfeeding_pain_comments" class="form-control" name="breastfeeding_pain_comments" rows="3"><?php echo esc_html(get_user_meta($user->ID, 'breastfeeding_pain_comments', true)); ?></textarea>
				</div>

			</td>
		</tr>



		<tr>
			<th><label for="breast_red_swelling">Have you ever had any redness or swelling of the breast while you were breastfeeding in the past(or have you been diagnosed with mastitis)?</label></th>
			<td>
				<select name="breast_red_swelling" class="form-control" id="breast_red_swelling" required>
					<option value="" disabled selected>select</option>
					<?php
					$breast_red_swelling      = get_user_meta($user->ID, 'breast_red_swelling', true);

					$savedVal = isset($breast_red_swelling) && ($breast_red_swelling == 'Yes') ? 'selected' : ''; ?>
					<option value="Yes" <?php echo $savedVal ?>>Yes</option>

					<?php $savedVal = isset($breast_red_swelling) && ($breast_red_swelling == 'No') ? 'selected' : ''; ?>
					<option value="No" <?php echo $savedVal ?>>No</option>		

				</select>
				<span class="description">Select one of them</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Redness or swelling Comments </label></th>
			<td>
				<div class="form-group">
					<textarea id="breast_red_swelling_comments" class="form-control" name="breast_red_swelling_comments" rows="3"><?php echo esc_html(get_user_meta($user->ID, 'breast_red_swelling_comments', true)); ?></textarea>
				</div>

			</td>
		</tr>


		<tr>
			<th><label for="breast_milk_amount_change">Have you ever experienced unexpected increases or decreases in your milk production?</label></th>
			<td>
				<select name="breast_milk_amount_change" class="form-control" id="breast_milk_amount_change" required>
					<option value="" disabled selected>select</option>
					<?php
					$breast_milk_amount_change      = get_user_meta($user->ID, 'breast_milk_amount_change', true);

					$savedVal = isset($breast_milk_amount_change) && ($breast_milk_amount_change == 'Yes') ? 'selected' : ''; ?>
					<option value="Yes" <?php echo $savedVal ?>>Yes</option>

					<?php $savedVal = isset($breast_milk_amount_change) && ($breast_milk_amount_change == 'No') ? 'selected' : ''; ?>
					<option value="No" <?php echo $savedVal ?>>No</option>		

				</select>
				<span class="description">Select one of them</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Milk change comments </label></th>
			<td>
				<div class="form-group">
					<textarea id="breast_milk_amount_change_comments" class="form-control" name="breast_milk_amount_change_comments" rows="3"><?php echo esc_html(get_user_meta($user->ID, 'breast_milk_amount_change_comments', true)); ?></textarea>
				</div>

			</td>
		</tr>




		<tr>
			<th><label for="prescription_img">Prescription</label></th>
			<?php $prescriptions = get_user_meta($user->ID, 'prescription', true);
			if (!empty($prescriptions)) { ?>
				<td>
					<?php foreach ($prescriptions as $prescription_id => $prescription_url) { ?>
						<div class="hfp-attachment <?php echo (strpos(get_post_mime_type($prescription_id), 'image') !== false) ? 'hfp-attachment--img' : 'hfp-attachment--file'; ?>">
							<?php if (strpos(get_post_mime_type($prescription_id), 'image') !== false) { ?>
								<img class='js-userpp' src='<?php echo wp_get_attachment_image_src($prescription_id)[0]; ?>' alt=''>
							<?php } else {
								echo '<span>' . get_the_title($prescription_id) . '</span>';
							} ?>
							<a href='<?php echo wp_get_attachment_url($prescription_id); ?>' target="_blank">Download
								file</a>
						</div>
					<?php } ?>
				</td>
			<?php } ?>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="file" name="prescription[]" id="prescription" value="<?php echo esc_attr(wp_get_attachment_url(get_user_meta($user->ID, 'prescription', true))); ?>" class="regular-text" multiple="multiple" /><br />
				<span class="description">Upload prescription.</span>
			</td>
		</tr>

		<tr>
			<th><label for=""> Save Files</label></th>
			<td>
				<input type="button" name="saveFiles" id="saveFiles" value="Save Files" /><br />
			</td>
		</tr>

		<tr>
			<th><label for="primaryInsurance">Primary Insurance</label></th>
			<td>
				<select name="primaryInsurance" class="form-control" id="primaryInsurance" required>
					<option value="" disabled selected>select</option>
					<?php
					$primaryInsurance      = get_user_meta($user->ID, 'primaryInsurance', true);
					$savedPrimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == 'tricare_east') ? 'selected' : ''; ?>
					<option value="tricare_east" <?php echo $savedPrimaryInsurance ?>>TRICARE East</option>
					<?php $savedPrimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == 'tricare_west') ? 'selected' : ''; ?>
					<option value="tricare_west" <?php echo $savedPrimaryInsurance ?>>TRICARE West</option>
                    <?php $savedPrimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == 'tricare_overseas') ? 'selected' : ''; ?>
                    <option value="tricare_overseas" <?php echo $savedPrimaryInsurance ?>>TRICARE Overseas</option>
					<?php $savedPrimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == 'other') ? 'selected' : ''; ?>
					<option value="other" <?php echo $savedPrimaryInsurance ?>>Other</option>
				</select>
				<span class="description">Enter primary insurance.</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Mother's Date of Birth </label></th>
			<td>
				<div class="row">
					<?php
					echo '<div class="col-sm-4">';
					echo '<select id="monthDOB" name="monthDOB" required>';
					echo '<option value="" disabled selected>month</option>';
					for ($i = 1; $i <= 12; $i++) {
						$i              = str_pad($i, 2, 0, STR_PAD_LEFT);
						$monthDOB       = get_user_meta($user->ID, 'monthDOB', true);
						$saved_monthDOB = !empty($monthDOB) && ($monthDOB == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_monthDOB . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					echo '<div class="col-sm-4">';
					echo '<select id="dayDOB" name="dayDOB" required>';
					echo '<option value="" disabled selected>day</option>';
					for ($i = 1; $i <= 31; $i++) {
						$i            = str_pad($i, 2, 0, STR_PAD_LEFT);
						$dayDOB       = get_user_meta($user->ID, 'dayDOB', true);
						$saved_dayDOB = !empty($dayDOB) && ($dayDOB == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_dayDOB . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					echo '<div class="col-sm-4">';
					echo '<select id="yearDOB" name="yearDOB" required>';
					echo '<option value="" disabled selected>year</option>';
					for ($i = date('Y', strtotime('-10 years')); $i >= date('Y', strtotime('-100 years')); $i--) {
						$yearDOB       = get_user_meta($user->ID, 'yearDOB', true);
						$saved_yearDOB = !empty($yearDOB) && ($yearDOB == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_yearDOB . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					?>
				</div>
				<span class="description">Enter mother's date of birth.</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Baby's Date of Birth </label></th>
			<td>
				<div class="row">
					<?php
					echo '<div class="col-sm-4">';
					echo '<select name="monthDUE" required>';
					echo '<option value="" disabled selected>month</option>';
					for ($i = 1; $i <= 12; $i++) {
						$i              = str_pad($i, 2, 0, STR_PAD_LEFT);
						$monthDUE       = get_user_meta($user->ID, 'monthDUE', true);
						$saved_monthDUE = isset($monthDUE) && ($monthDUE == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_monthDUE . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					echo '<div class="col-sm-4">';
					echo '<select name="dayDUE" required>';
					echo '<option value="" disabled selected>day</option>';
					for ($i = 1; $i <= 31; $i++) {
						$i            = str_pad($i, 2, 0, STR_PAD_LEFT);
						$dayDUE       = get_user_meta($user->ID, 'dayDUE', true);
						$saved_dayDUE = isset($dayDUE) && ($dayDUE == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_dayDUE . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					echo '<div class="col-sm-4">';
					echo '<select name="yearDUE" required>';
					echo '<option value="" disabled selected>year</option>';
					for ($i = date('Y', strtotime('+3 years')); $i >= date('Y', strtotime('-5 years')); $i--) {
						$yearDUE       = get_user_meta($user->ID, 'yearDUE', true);
						$saved_yearDUE = isset($yearDUE) && ($yearDUE == $i) ? 'selected' : '';
						echo "<option value='$i'" . $saved_yearDUE . ">$i</option>";
					}
					echo '</select>';
					echo '</div>';
					?>
				</div>
				<span class="description">Enter baby's date of birth.</span>
			</td>
		</tr>

		<tr>
			<th><label for="">Additional Info or Comments </label></th>
			<td>
				<div class="form-group">
					<textarea id="additionalInfo" class="form-control" name="additionalInfo" rows="5"><?php echo esc_html(get_user_meta($user->ID, 'additionalInfo', true)); ?></textarea>
				</div>

			</td>
		</tr>
		<tr>
			<th><label for="user_modified_flag">User Modified?</label></th>
			<td>
				<input type="checkbox" name="user_modified_flag" id="user_modified_flag" class="regular-text" <?php echo !empty(get_user_meta($user->ID, 'user_modified_flag', true)) ? "checked" : ""; ?> disabled /><br />
			</td>
		</tr>
	</table>

	<style>
		.hfp-attachment {
			position: relative;
			display: inline-flex;
			vertical-align: middle;
			text-align: center;
			flex-direction: column;
			margin-right: 10px;
			margin-bottom: 10px;
		}

		.hfp-attachment a {
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 7px;
			background-color: rgba(0, 0, 0, 0.7);
			color: white;
			text-decoration: none;
			transition: 0.3s ease-out;
		}

		.hfp-attachment span {
			display: block;
			margin-bottom: 10px;
		}

		.hfp-attachment--img a {
			position: absolute;
			box-sizing: border-box;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			font-weight: bold;
			opacity: 0;
		}

		.hfp-attachment:hover a {
			opacity: 1;
		}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function($) {

			$("#saveFiles").click(function() {

				var file_data = document.getElementById('prescription').files.length;

				var form_data = new FormData();

				for (var index = 0; index < file_data; index++) {
					form_data.append("prescription[]", document.getElementById('prescription').files[index]);
				}

				form_data.append('action', 'homefrontpump_admin_update_user');
				form_data.append('user_id', <?php echo $user->ID; ?>);

				$.ajax({
					url: "<?php echo admin_url('admin-ajax.php'); ?>",
					type: "POST",
					data: form_data,
					contentType: false,
					processData: false,
					success: function(data) {
						alert('Files uploaded successfully. Finish editing the user and click "Update User" button to see changes.');
						console.log('admin update files');
						console.log(data);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert('erroooor:(');
						alert(xhr.status);
						alert(thrownError);
					}
				});

			});


		});
	</script>
<?php

}

if (!is_admin()) {
	add_action('user_profile_update_errors', 'validateProfileFields');
}

function validateProfileFields(WP_Error &$errors)
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
	if (empty($_POST['sponsorName'])) {
		$errors->add('sponsorName', "<strong>ERROR</strong>: Sponsor Name is required.");
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


add_action('personal_options_update', 'save_extra_profile_fields');
add_action('edit_user_profile_update', 'save_extra_profile_fields');

function save_extra_profile_fields($user_id)
{

	if (!current_user_can('edit_user', $user_id)) {
		return false;
	}

	if (!empty($_POST['phone']) && preg_match('/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/', $_POST['phone'])) {

		update_user_meta($user_id, 'phone', $_POST['phone']);
	}

	if (!empty($_POST['free_product_acquired'])) {
		$free_product_acquired = 1;
	} else {
		$free_product_acquired = 0;
	}
	update_user_meta($user_id, 'free_product_acquired', $free_product_acquired);


	if (!empty($_POST['accept_msgs'])) {
		$accept_msgs = 1;
	} else {
		$accept_msgs = 0;
	}
	update_user_meta($user_id, 'accept_msgs',  $accept_msgs);

	if (!empty($_POST['user_date_update_api'])) {
		$user_date_update_api = 1;
	} else {
		$user_date_update_api = 0;
	}

	update_user_meta($user_id, 'user_date_update_api',  $user_date_update_api);

	if (!empty($_POST['user_date_touch_api'])) {
		$user_date_touch_api = 1;
	} else {
		$user_date_touch_api = 0;
	}
	update_user_meta($user_id, 'user_date_touch_api',  $user_date_touch_api);


	if (!empty($_POST['monthDOB'])) {

		update_user_meta($user_id, 'monthDOB', $_POST['monthDOB']);
	}

	if (!empty($_POST['dayDOB'])) {

		update_user_meta($user_id, 'dayDOB', $_POST['dayDOB']);
	}

	if (!empty($_POST['yearDOB'])) {

		update_user_meta($user_id, 'yearDOB', $_POST['yearDOB']);
	}

	if (!empty($_POST['doctorNameFirst'])) {

		update_user_meta($user_id, 'doctorNameFirst', $_POST['doctorNameFirst']);
	}

	if (!empty($_POST['doctorNameLast'])) {

		update_user_meta($user_id, 'doctorNameLast', $_POST['doctorNameLast']);
	}

	if (!empty($_POST['primaryInsurance'])) {

		update_user_meta($user_id, 'primaryInsurance', $_POST['primaryInsurance']);
	}

	if (!empty($_POST['dodNumber']) && preg_match('/^[0-9]{11}$/', $_POST['dodNumber'])) {

		update_user_meta($user_id, 'dodNumber', $_POST['dodNumber']);
	}

	if (!empty($_POST['yearDUE'])) {

		update_user_meta($user_id, 'yearDUE', $_POST['yearDUE']);
	}

	if (!empty($_POST['monthDUE'])) {

		update_user_meta($user_id, 'monthDUE', $_POST['monthDUE']);
	}

	if (!empty($_POST['dayDUE'])) {

		update_user_meta($user_id, 'dayDUE', $_POST['dayDUE']);
	}

	if (empty($_POST['doctorNumber']) || preg_match('/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/', $_POST['doctorNumber'])) {

		update_user_meta($user_id, 'doctorNumber', $_POST['doctorNumber']);
	}

	if (!empty($_POST['sponsorName'])) {

		update_user_meta($user_id, 'sponsorName', $_POST['sponsorName']);
	}
	if (empty($_POST['sponsorNumber']) || preg_match('/^(\d{3})(\d{2})(\d{4})$/', $_POST['sponsorNumber'])) {

		update_user_meta($user_id, 'sponsorNumber', $_POST['sponsorNumber']);
	}

	if (!empty($_POST['sponsorRelationship'])) {

		update_user_meta($user_id, 'sponsorRelationship', $_POST['sponsorRelationship']);
	}

	if (!empty($_POST['assigned_sex'])) {

		update_user_meta($user_id, 'assigned_sex', $_POST['assigned_sex']);
	}
	if (!empty($_POST['currently_pregnant'])) {

		update_user_meta($user_id, 'currently_pregnant', $_POST['currently_pregnant']);
	}
	if (!empty($_POST['breastfeeding_past'])) {
		update_user_meta($user_id, 'breastfeeding_past', $_POST['breastfeeding_past']);
	}

	if (!empty($_POST['breastfeeding_pain'])) {
		update_user_meta($user_id, 'breastfeeding_pain', $_POST['breastfeeding_pain']);
	}
	
	if (!empty($_POST['breastfeeding_pain_comments'])) {
		update_user_meta($user_id, 'breastfeeding_pain_comments', $_POST['breastfeeding_pain_comments']);
	}
	if (!empty($_POST['breast_red_swelling'])) {
		update_user_meta($user_id, 'breast_red_swelling', $_POST['breast_red_swelling']);
	}
	if (!empty($_POST['breast_red_swelling_comments'])) {
		update_user_meta($user_id, 'breast_red_swelling_comments', $_POST['breast_red_swelling_comments']);
	}

	if (!empty($_POST['breast_milk_amount_change'])) {
		update_user_meta($user_id, 'breast_milk_amount_change', $_POST['breast_milk_amount_change']);
	}
	if (!empty($_POST['breast_milk_amount_change_comments'])) {
		update_user_meta($user_id, 'breast_milk_amount_change_comments', $_POST['breast_milk_amount_change_comments']);
	}

	if (!empty($_POST['additionalInfo'])) {

		update_user_meta($user_id, 'additionalInfo', $_POST['additionalInfo']);
	}
	
	if (!empty($_POST['register_for_showers'])) {
		$register_for_showers = 1;
	} else {
		$register_for_showers = 0;
	}
	
	update_user_meta($user_id, 'register_for_showers',  $register_for_showers);

	if (!empty($_POST['register_giveaway'])) {
		$register_giveaway = 1;
	} else {
		$register_giveaway = 0;
	}
	
	update_user_meta($user_id, 'register_giveaway',  $register_giveaway);

	if (!empty($_POST['giveaway_groupname'])) {		
		update_user_meta($user_id, 'giveaway_groupname', $_POST['giveaway_groupname']);
	}



	if (!empty($_POST['additionalInfo'])) {

		update_user_meta($user_id, 'additionalInfo', $_POST['additionalInfo']);
	}


	if (!empty($_POST['received_shower'])) {

		update_user_meta($user_id, 'received_shower', $_POST['received_shower']);
	}
	if (!empty($_POST['event_tricare'])) {
		update_user_meta($user_id, 'event_tricare', $_POST['event_tricare']);
	}
	if (!empty($_POST['event_sponsors'])) {

		update_user_meta($user_id, 'event_sponsors', $_POST['event_sponsors']);
	}

	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks
}

add_action('init', function () {

	global $wp;
	$current_url = home_url(add_query_arg($_GET, $wp->request));
	if ($current_url == get_template_page_url('templates/page-multistepForm.php') && is_user_logged_in()) {
		$free_product_acquired = check_user_free_product_acquisition(get_current_user_id());

		if (!empty($free_product_acquired)) { // Free product hasn been acquired before
			wp_redirect(home_url());
			exit;
		}
	}
});

add_action('wp_ajax_homefrontpump_admin_update_user', 'homefrontpump_update_user_files');
add_action('wp_ajax_homefrontpump_update_user_profile', 'homefrontpump_update_user_files');
function homefrontpump_update_user_files()
{

	$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);

	if (!empty($_FILES['prescription'])) {
		// Save prescription
        hfp_uploadImages($user_id, 'prescription', 'prescriptionHash');
	}

	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks

	echo json_encode('UPloadDone');
	die;
}

function update_sendinblue_users_list($data)
{

	$endpoint    = 'https://api.sendinblue.com/v3/contacts';
	$sib_api_key = get_theme_mod('sendinblue_api_key');
	$headers     = array(
		'API-KEY: ' . $sib_api_key, // api key
		'Content-Type: application/json'
	);
	$curl        = curl_init($endpoint);
	curl_setopt($curl, CURLOPT_URL, $endpoint);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
}

// Add user to sendinblue users list on admin adding new user
add_action('user_register', function ($user_id) {

	$user_email = get_user_by('ID', $user_id)->user_email;
	$first_name = get_user_meta($user_id, 'first_name', true);
	$last_name  = get_user_meta($user_id, 'last_name', true);

	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks

	if (empty($first_name)) { // Submission from multistep form or fb form
		$first_name = $_POST['firstname'];
		$last_name  = $_POST['lastname'];
	}
	// Update sendinblue users list
	$params = [
		'email'      => $user_email,
		'attributes' => [
			'FIRSTNAME' => $first_name,
			'LASTNAME'  => $last_name,
		],
		'listIds'    => [11],
	];
	update_sendinblue_users_list($params);
});

add_action('woocommerce_update_order', function ($order_id) {

	update_post_meta($order_id, 'order_modified_flag', true); // For API checks
});

add_action('woocommerce_new_order', function ($order_id) {

	update_post_meta($order_id, 'order_modified_flag', true); // For API checks
});

// Add Reorder Function
add_action('admin_post_my_reorder_form', 'reorder_action');
function reorder_action()
{
	$user = wp_get_current_user();

	$post_data = filter_input_array(
		INPUT_POST,
		[
			'productChoose'         => FILTER_SANITIZE_STRING,
			'fooby'                 => FILTER_SANITIZE_STRING,
		]
	);
	// Create reorder
	$products = [];

	if (!empty($post_data['productChoose'])) {
		$products[] = $post_data['productChoose'];
	}
	if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1) {
		$products[] = $post_data['fooby'];
	}

	order_free_product(
		$products,
		$user->first_name,
		$user->last_name,
		get_user_meta($user->ID, 'streetAddress', true) . get_user_meta($user->ID, 'unit', true),
		get_user_meta($user->ID, 'shipping_city', true),
		get_user_meta($user->ID, 'shipping_state', true),
		get_user_meta($user->ID, 'shipping_postcode', true),
		$user->ID,
		$user->user_email,
		'reorder_action'
	);

	// Send email
	$user_firstname = $user->first_name;

	// $from    = get_option('admin_email');
	// $headers = "From: $from";
	// $message = "Dear $user_firstname , \n We have received your order and are working on it! If you have any questions, feel free to contact us at support@homefrontpumps.com.";
	// wp_mail($user->user_email, 'Home Front Pumps', $message, $headers, "-f " . $from);

	update_user_meta($user->ID, 'free_product_acquired', true);
	update_user_meta($user->ID, 'user_modified_flag', true); // For API checks
	unset_user_email_cookie();
	$url = get_template_page_url('templates/page-thankyou.php');
	wp_redirect($url);
}
