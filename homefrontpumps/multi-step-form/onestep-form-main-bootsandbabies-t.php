<?php

add_action('wp_login', function () {

	if (isset($_COOKIE['login_from_onestep_form'])) { // Redirected from the new form
		setcookie('login_from_onestep_form', '', time() - 3600, '/');
		wp_redirect(get_template_page_url('templates/page-onestep-form-bootsandbabies-t.php'));
		exit;
	}
});

add_action('admin_post_onestep_form_bootsandbabies_t_action', 'onestep_form_bootsandbabies_t_action');
add_action('admin_post_nopriv_onestep_form_bootsandbabies_t_action', 'onestep_form_bootsandbabies_t_action');
function onestep_form_bootsandbabies_t_action()
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
				'event_tricare' => FILTER_SANITIZE_STRING,
				'event_sponsors' => FILTER_SANITIZE_STRING,
				'primaryInsurance' => FILTER_SANITIZE_STRING,
				'register_page' => FILTER_SANITIZE_STRING,
			]
		);
	
		// Save submitted data
	
		//    $user_id = get_current_user_id();
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
	
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
		if (!empty($post_data['event_tricare'])) {
			update_user_meta($user_id, 'event_tricare', $post_data['event_tricare']);
		}
		if (!empty($post_data['event_sponsors'])) {
			update_user_meta($user_id, 'event_sponsors', $post_data['event_sponsors']);
		}
		if (!empty($post_data['receptionConfirmation'])) {
			update_user_meta($user_id, 'receptionConfirmation', $post_data['receptionConfirmation']);
		}
	
		if (!empty($post_data['register_page'])) {
			update_user_meta($user_id, 'register_page', $post_data['register_page']);
		}
		//product
		if (!empty($post_data['productChoose'])) {
			update_user_meta($user_id, 'chosen_product_id', $post_data['productChoose']);
		}
		if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1) {
			update_user_meta($user_id, 'fooby', $post_data['fooby']);
		}
	
		// Create order
		$products = [];
	
		if (!empty($post_data['productChoose']) && $post_data['receptionConfirmation'] == 'No') {
			$products[] = $post_data['productChoose'];
		}
		if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1 ) {
			$products[] = $post_data['fooby'];
		}
	
		order_free_product($products, $post_data['firstname'], $post_data['lastname'], $post_data['streetAddress'] . $post_data['unit'], $post_data['city'], $post_data['state'], $post_data['postcode'], $user_id, $post_data['email'], $post_data['register_page']);
	
		// Send email
		$user_firstname = $post_data['firstname'];
	
		// $from = get_option('admin_email');
		// $headers = "From: $from";
		// $message = "Dear $user_firstname , \n We have received your order and are working on it! If you have any questions, feel free to contact us at support@homefrontpumps.com.";
		// wp_mail($post_data['email'], 'Home Front Pumps', $message, $headers, "-f " . $from);
	
		update_user_meta($user_id, 'onestep_form_progress', 4); // final step submitted
		update_user_meta($user_id, 'user_modified_flag', true); // For API checks
	
		update_user_meta($user_id, 'free_product_acquired', true);

		if (empty(get_user_meta($user_id, 'site', true))) {
			update_user_meta($user_id, 'site', 'homefrontpumps.com');
		}
		
		unset_user_email_cookie();


		$url = get_template_page_url('templates/page-thankyou.php');
		if (!empty($post_data['primaryInsurance']) && $post_data['primaryInsurance'] == 'other') {
			$url .= '?primaryInsurance=other';
		}

		wp_redirect($url);
		exit;


}

add_action('wp_ajax_homefrontpump_register_login_onestep_form_bootsandbabies_t', 'homefrontpump_register_login_onestep_form_bootsandbabies_t');
add_action('wp_ajax_nopriv_homefrontpump_register_login_onestep_form_bootsandbabies_t', 'homefrontpump_register_login_onestep_form_bootsandbabies_t');

function homefrontpump_register_login_onestep_form_bootsandbabies_t()
{
	
	$post_data = filter_input_array(
		INPUT_POST,
		[
			'firstname' => FILTER_SANITIZE_STRING,
			'lastname' => FILTER_SANITIZE_STRING,
			'monthDOB' => FILTER_SANITIZE_STRING,
			'dayDOB' => FILTER_SANITIZE_STRING,
			'yearDOB' => FILTER_VALIDATE_INT,
			'monthDUE' => FILTER_SANITIZE_STRING,
			'dayDUE' => FILTER_SANITIZE_STRING,
			'yearDUE' => FILTER_SANITIZE_STRING,
			'phone' => FILTER_SANITIZE_STRING,
			'email' => FILTER_SANITIZE_STRING,
			'password' => FILTER_SANITIZE_STRING,

			'streetAddress' => FILTER_SANITIZE_STRING,
			'unit' => FILTER_SANITIZE_STRING,
			'city' => FILTER_SANITIZE_STRING,
			'state' => FILTER_SANITIZE_STRING,
			'postcode' => FILTER_SANITIZE_STRING,

			'primaryInsurance' => FILTER_SANITIZE_STRING,
			
			

			'register_for_showers' => FILTER_SANITIZE_STRING,
			'accept_msgs' => FILTER_SANITIZE_STRING,
			'register_page' => FILTER_SANITIZE_STRING,
			'statement' => FILTER_SANITIZE_STRING,
			'terms' => FILTER_SANITIZE_STRING,
			'event_tricare' => FILTER_SANITIZE_STRING,
			'event_sponsors' => FILTER_SANITIZE_STRING,

			'register_giveaway' => FILTER_SANITIZE_STRING,
			'giveaway_groupname' => FILTER_SANITIZE_STRING
		]
	);

	if (!is_user_logged_in()) { // Not a logged-in user

		if (email_exists($post_data['email'])) {
			$user_id = get_user_by('email', $post_data['email'])->ID;
			echo hfp_registered_message($user_id);
			die();
		}
		$user_id = email_exists($post_data['email']);
		if (!$user_id) {
			$user_id = homefrontpump_register_user($post_data['firstname'], $post_data['lastname'], $post_data['email'], $post_data['password']);

			// Send welcome email
			$user_email = $post_data['email'];
			$firstname = $post_data['firstname'];
			// add_filter('wp_new_user_notification_email', function ($wp_new_user_notification_email) use ($user_email, $firstname) {

			// 	$message = "Dear $firstname, \n Thanks for registering with Home Front Pumps!";
			// 	$from = get_option('admin_email');
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
		}

		automatic_login($post_data['email']);
	} else {
		$user_id = get_current_user_id();
		$user_email = get_userdata($user_id)->user_email;
	}

	// Save user meta

	if (!empty($post_data['firstname'])) {
		update_user_meta($user_id, 'first_name', $post_data['firstname']);
		update_user_meta($user_id, 'shipping_first_name', $post_data['firstname']);
	}
	if (!empty($post_data['lastname'])) {
		update_user_meta($user_id, 'last_name', $post_data['lastname']);
		update_user_meta($user_id, 'shipping_last_name', $post_data['lastname']);
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
	if (!empty($post_data['phone'])) {
		update_user_meta($user_id, 'phone', $post_data['phone']);
	}

	// if (!empty($post_data['primaryInsurance'])) {
	// 	update_user_meta($user_id, 'primaryInsurance', $post_data['primaryInsurance']);
	// }
	if (!empty($post_data['register_page'])) {
		update_user_meta($user_id, 'register_page', $post_data['register_page']);
	}
	if (!empty($post_data['accept_msgs'])) {
		$accept_msgs = 1;
	} else {
		$accept_msgs = 0;
	}
	update_user_meta($user_id, 'accept_msgs',  $accept_msgs);

	if (!empty($post_data['register_for_showers'])) {
		$register_for_showers = 1;
	} else {
		$register_for_showers = 0;
	}
	update_user_meta($user_id, 'register_for_showers',  $register_for_showers);

	if (!empty($post_data['register_giveaway'])) {
		$register_giveaway = 1;
	} else {
		$register_giveaway = 0;
	}
	update_user_meta($user_id, 'register_giveaway',  $register_giveaway);

	if (!empty($post_data['giveaway_groupname'])) {
		update_user_meta($user_id, 'giveaway_groupname', $post_data['giveaway_groupname']);
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

	$onestep_form_progress_meta = get_user_meta($user_id, 'onestep_form_progress', true);
	if (empty($multi_step_form_progress_meta)) {
		update_user_meta($user_id, 'onestep_form_progress', 1); // step 1 submitted
	}
	update_user_meta($user_id, 'form_in_progress', 2); // indicates that the new facebook form is in progress to be used in redirection from finishOrder template
	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks

	if (empty(get_user_meta($user_id, 'site', true))) {
		update_user_meta($user_id, 'site', 'homefrontpumps.com');
	}
	
	// Update sendinblue users list
	if (!empty($post_data['register_for_showers'])) {

		$params = [
			'email' => $user_email,
			'attributes' => [
				'FIRSTNAME' => $post_data['firstname'],
				'LASTNAME' => $post_data['lastname'],
			],
			'listIds' => [23],
			'updateEnabled' => true
		];
		update_sendinblue_users_list($params);
	}
	if (!empty($post_data['register_giveaway'])) {
		$params = [
			'email' => $user_email,
			'attributes' => [
				'FIRSTNAME' => $post_data['firstname'],
				'LASTNAME' => $post_data['lastname'],
			],
			'listIds' => [53],
			'updateEnabled' => true
		];
		update_sendinblue_users_list($params);
	}

	// echo get_current_user_id();
	$message = get_current_user_id() ? ['success' => 'true', 'id' => get_current_user_id()] : ['success' => 'false', 'message' => 'Something went wrong while registering your account, please try again'];
	echo json_encode($message);
	die;
}

add_action('wp_ajax_homefrontpump_step_2_onestep_form_bootsandbabies_t', 'homefrontpump_step_2_onestep_form_bootsandbabies_t');
add_action('wp_ajax_nopriv_homefrontpump_step_2_onestep_form_bootsandbabies_t', 'homefrontpump_step_2_onestep_form_bootsandbabies_t');
function homefrontpump_step_2_onestep_form_bootsandbabies_t()
{

	$user_id = get_current_user_id();
	$post_data = filter_input_array(
		INPUT_POST,
		[
			'primaryInsurance' => FILTER_SANITIZE_STRING,
			'sponsorName' => FILTER_SANITIZE_STRING,
			'dodNumber' => FILTER_SANITIZE_STRING,
			'sponsorRelationship' => FILTER_SANITIZE_STRING,
			'receptionConfirmation' => FILTER_SANITIZE_STRING,
			'productChoose' => FILTER_SANITIZE_STRING,
			'fbody' => FILTER_SANITIZE_STRING,
	
			
			
		]
	);

	$error = '';
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

	if (!empty($post_data['productChoose'])) {
		update_user_meta($user_id, 'chosen_product_id', $post_data['productChoose']);
	}
	if (!empty($post_data['fooby'])  && $post_data['fooby'] != -1 ) {
		update_user_meta($user_id, 'fooby', $post_data['fooby']);
	}

	// update_user_meta($user_id, 'user_modified_flag', true); // For API checks

	$message = $error ? (['success' => 'false', 'message' => '<ul>' . $error . '</ul>']) : (['success' => 'true']);
	echo json_encode($message);
	die();
}

add_action('wp_ajax_homefrontpump_step_3_onestep_form_bootsandbabies_t', 'homefrontpump_save_step_3_onestep_form_bootsandbabies_t');
add_action('wp_ajax_nopriv_homefrontpump_step_3_onestep_form_bootsandbabies_t', 'homefrontpump_save_step_3_onestep_form_bootsandbabies_t');
function homefrontpump_save_step_3_onestep_form_bootsandbabies_t()
{

	$user_id = get_current_user_id();
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

			'hear' => FILTER_SANITIZE_STRING,
			'otherReason' => FILTER_SANITIZE_STRING,
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


	if (!empty($_FILES['face_file']) && !empty($_FILES['face_file']['name']) ) {
		// Save face_file
		hfp_uploadImage($user_id, 'face_file', 'selfieHash');
	}


	if (!empty($_FILES['national_id_file']) && !empty($_FILES['national_id_file']['name'])) {
		// Save national ID file
		hfp_uploadImage($user_id, 'national_id_file', 'nationalIdHash');

	}
	die();
}
