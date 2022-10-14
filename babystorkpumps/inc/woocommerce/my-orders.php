<?php

// Add columns to my orders table
add_filter( 'woocommerce_my_account_my_orders_columns', function ( $columns ) {

	$columns['prescription']   = 'Prescription (CMN)';
	$columns['order_verified'] = 'Order Verified';

	return $columns;
} );

// Add data for added columns
add_action( 'woocommerce_my_account_my_orders_column_prescription', function ( $order ) {

	$meta    = get_post_meta( $order->get_id(), 'prescription_cmn_status', true );
	$checked = ! empty( $meta ) ? "checked='checked'" : "";
	echo "<input type='checkbox'" . $checked . "disabled='disabled' />";

	if ( empty( $checked ) ) { // View link
		$url = get_post_meta( $order->get_id(), 'prescription_cmn_url', true );
		if ( ! empty( $url ) ) {
			echo "<a href='" . $url . "'> View Here</a>";
		}
	}
} );

//function add_my_account_reorder_action( $actions, $order ) {
//
//	$actions['reorder'] = array(
//		// adjust URL as needed
//		'url'  => get_site_url().'/reorder',
//		'name' => __( 'Create a refill order' ),
//	);
//
//	return $actions;
//}
//
//add_filter( 'woocommerce_my_account_my_orders_actions', 'add_my_account_reorder_action', 10, 2 );

add_action( 'woocommerce_my_account_my_orders_column_order_verified', function ( $order ) {

	$meta    = get_post_meta( $order->get_id(), 'order_verified', true );
	$checked = ! empty( $meta ) ? "checked='checked'" : "";
	echo "<input type='checkbox'" . $checked . "disabled='disabled' />";
} );

add_action( 'woocommerce_before_account_orders', function () {
	$user_id = get_current_user_id();

	$personal_information_verified         = get_user_meta( $user_id, 'personal_information_verified', true );
	$personal_information_verified_checked = ! empty( $personal_information_verified ) ? "checked='checked'" : "";
	$personal_insurance_verified           = get_user_meta( $user_id, 'personal_insurance_verified', true );
	$personal_insurance_verified_checked   = ! empty( $personal_insurance_verified ) ? "checked='checked'" : "";

	$personal_information_completed         = get_user_meta( $user_id, 'personal_information_completed', true );
	$personal_information_completed_checked = ! empty( $personal_information_completed ) ? "checked='checked'" : "";
	$personal_insurance_completed           = get_user_meta( $user_id, 'personal_insurance_completed', true );
	$personal_insurance_completed_checked   = ! empty( $personal_insurance_completed ) ? "checked='checked'" : "";

	$account_details_url           = home_url() . '/my-account/edit-account/';
	$complete_personal_information = '';
	$complete_personal_insurance   = '';
	if ( empty( $personal_information_completed_checked ) ) {
		$complete_personal_information = "<a href='" . $account_details_url . "'> Complete Here</a>";
	}
	if ( empty( $personal_insurance_completed_checked ) ) {
		$complete_personal_insurance = "<a href='" . $account_details_url . "'> Complete Here</a>";
	}

	$user_meta_table = "<table class='woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table'>"
	                   . "<thead><tr><td> </td><td> Completed </td><td> Verified </td> </tr></thead>"
	                   . "<tr><td> Personal Information </td> <td> <input type='checkbox'" . $personal_information_completed_checked . "disabled='disabled' />" . $complete_personal_information . "</td><td> <input type='checkbox'" . $personal_information_verified_checked . "disabled='disabled' /> </td> </tr>"
	                   . "<tr><td> Insurance Information </td><td> <input type='checkbox'" . $personal_insurance_completed_checked . "disabled='disabled' />" . $complete_personal_insurance . " </td><td> <input type='checkbox'" . $personal_insurance_verified_checked . "disabled='disabled' /> </td> </tr>"
	                   . "</table>";


	echo $user_meta_table;

	// echo "<a href='".get_site_url().'/reorder'."' class='woocommerce-button button reorder hfp-wc-reorder'>Place your order</a>";
} );