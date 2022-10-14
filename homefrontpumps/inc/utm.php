<?php
//Save UTM parameters of the user in the cookies
add_action( 'wp', 'save_utm_parameters_in_cookies' );
function save_utm_parameters_in_cookies() {
	if ( is_user_logged_in() || empty( $_SERVER['QUERY_STRING'] ) ) {
		return;
	}
	// Setting UTM parameters if exists
	if ( strpos( $_SERVER['QUERY_STRING'], 'utm_' ) !== false ) {
		setcookie( 'hfp_utm', $_SERVER['QUERY_STRING'], time() + ( 86400 * 30 ), '/' );
	}
}

add_action( 'user_register', 'hfp_registration_save' );
function hfp_registration_save( $user_id ) {
          if ( isset( $_COOKIE['hfp_utm'] ) ) {
		parse_str( $_COOKIE['hfp_utm'], $query_string_array );
	}
	$url_query_args = isset( $_COOKIE['hfp_utm'] ) ? $_COOKIE['hfp_utm'] : '';
	$utm_source     = isset( $_COOKIE['hfp_utm'] ) && isset( $query_string_array['utm_source'] ) ? $query_string_array['utm_source'] : '';
	$utm_campaign   = isset( $_COOKIE['hfp_utm'] ) && isset( $query_string_array['utm_campaign'] ) ? $query_string_array['utm_campaign'] : '';
	$utm_medium     = isset( $_COOKIE['hfp_utm'] ) && isset( $query_string_array['utm_medium'] ) ? $query_string_array['utm_medium'] : '';
	$utm_term       = isset( $_COOKIE['hfp_utm'] ) && isset( $query_string_array['utm_term'] ) ? $query_string_array['utm_term'] : '';
	$utm_content    = isset( $_COOKIE['hfp_utm'] ) && isset( $query_string_array['utm_content'] ) ? $query_string_array['utm_content'] : '';
        
          add_user_meta( $user_id, 'utm_source', $utm_source );
	add_user_meta( $user_id, 'utm_campaign', $utm_campaign );
	add_user_meta( $user_id, 'utm_medium', $utm_medium );
	add_user_meta( $user_id, 'utm_term', $utm_term );
	add_user_meta( $user_id, 'utm_content', $utm_content );
	add_user_meta( $user_id, 'QUERY_STRING', $url_query_args );
        
}

add_action( 'show_user_profile', 'hfp_display_user_custom_fields' );
add_action( 'edit_user_profile', 'hfp_display_user_custom_fields' );

function hfp_display_user_custom_fields( $user ) { ?>
	<h3>UTM Fields</h3>
	<table class="form-table">
		<tr>
			<th><label>User utm_source</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'utm_source', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
		<tr>
			<th><label>User utm_campaign</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'utm_campaign', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
		<tr>
			<th><label>User utm_medium</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'utm_medium', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
		<tr>
			<th><label>User utm_term</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'utm_term', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
		<tr>
			<th><label>User utm_content</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'utm_content', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
		<tr>
			<th><label>User url_query_args</label></th>
			<td><input type="text" value="<?php echo get_user_meta( $user->ID, 'QUERY_STRING', true ); ?>" class="regular-text" readonly=readonly /></td>
		</tr>
	</table>
	<?php
}