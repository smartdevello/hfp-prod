<div class="motherInfo_tab">
	<div class="step-heading">Mother´s Information</div>
	<div class="form-group">
		<label>Legal Name <span class="ast">*</span></label>
		<div class="row">
			<div class="col-sm-6">
				<?php
				if (is_user_logged_in()) {
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
					$sponsorRelationship = get_user_meta($user_id, 'sponsorRelationship', true);
					$sponsorName = get_user_meta($user_id, 'sponsorName', true);
					$sponsorNumber = get_user_meta($user_id, 'sponsorNumber', true);
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

                    $validate_prescription = get_user_meta($user_id, 'validate_prescription', true);
					
					if ($sponsorRelationship == "Self") {
						$sponsorName = $firstname;
					}
				}
				?>
                    <script>
                        var validate_prescription = "<?php echo isset($validate_prescription)? $validate_prescription : ''; ?>";
                    </script>					
				<input id="firstname" type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
			</div>
			<div class="col-sm-6">
				<input id="lastname" type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>Mother's Date of Birth <span class="ast">*</span></label>
		<div class="row">
			<?php
			echo '<div class="col-sm-4">';
			echo '<select id="monthDOB" name="monthDOB" required>';
			echo '<option value="" disabled selected>month</option>';
			for ($m = 1; $m <= 12; $m++) {
				$month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
				$saved_monthDOB = !empty($monthDOB) && ($monthDOB == $m) ? 'selected' : '';
				echo "<option value='$m'" . $saved_monthDOB . ">$m-$month</option>";
			}
			echo '</select>';
			echo '</div>';
			echo '<div class="col-sm-4">';
			echo '<select id="dayDOB" name="dayDOB" required>';
			echo '<option value="" disabled selected>day</option>';
			for ($i = 1; $i <= 31; $i++) {
				$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				$saved_dayDOB = !empty($dayDOB) && ($dayDOB == $i) ? 'selected' : '';
				echo "<option value='$i'" . $saved_dayDOB . ">$i</option>";
			}
			echo '</select>';
			echo '</div>';
			echo '<div class="col-sm-4">';
			echo '<select id="yearDOB" name="yearDOB" required>';
			echo '<option value="" disabled selected>year</option>';
			for ($i = date('Y', strtotime('-10 years')); $i >= date('Y', strtotime('-100 years')); $i--) {
				$saved_yearDOB = !empty($yearDOB) && ($yearDOB == $i) ? 'selected' : '';
				echo "<option value='$i'" . $saved_yearDOB . ">$i</option>";
			}
			echo '</select>';
			echo '</div>';
			?>
		</div>
	</div>
	<div class="form-group">
		<label>Baby's Due Date or Birth Date <span class="ast">*</span></label>
		<div class="row">
			<?php
			echo '<div class="col-sm-4">';
			echo '<select id="monthDUE" name="monthDUE" required>';
			echo '<option value="" disabled selected>month</option>';
			for ($m = 1; $m <= 12; $m++) {
				$month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
				$saved_monthDUE = isset($monthDUE) && ($monthDUE == $m) ? 'selected' : '';
				echo "<option value='$m'" . $saved_monthDUE . ">$m-$month</option>";
			}
			echo '</select>';
			echo '</div>';
			echo '<div class="col-sm-4">';
			echo '<select id="dayDUE" name="dayDUE" required>';
			echo '<option value="" disabled selected>day</option>';
			for ($i = 1; $i <= 31; $i++) {
				$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				$saved_dayDUE = isset($dayDUE) && ($dayDUE == $i) ? 'selected' : '';
				echo "<option value='$i'" . $saved_dayDUE . ">$i</option>";
			}
			echo '</select>';
			echo '</div>';
			echo '<div class="col-sm-4">';
			echo '<select id="yearDUE" name="yearDUE" required>';
			echo '<option value="" disabled selected>year</option>';
			for ($i = date('Y', strtotime('+3 years')); $i >= date('Y', strtotime('-5 years')); $i--) {
				$saved_yearDUE = isset($yearDUE) && ($yearDUE == $i) ? 'selected' : '';
				echo "<option value='$i'" . $saved_yearDUE . ">$i</option>";
			}
			echo '</select>';
			echo '</div>';
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="phonelabel">Phone Number <span class="ast">*</span></label>
		<input type="tel" id="phone" class="form-control" name="phone" placeholder="Phone Number" value="<?php echo isset($phone) ? $phone : '' ?>" required>
	</div>

	<?php if (!is_user_logged_in()) { ?>
		<div class="form-group" id="email_div">
			<label>Email <span class="ast">*</span></label>
			<?php
			$user_email_cookie = !empty($_COOKIE['user_email']) ? $_COOKIE['user_email'] : '';
			?>
			<input id="email" type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $user_email_cookie ?>" required>
		</div>
		<div class="form-group" id="password_div">
			<label>Password <span class="ast">*</span></label>
			<input id="password" type="password" class="form-control" name="password" placeholder="Set log in password" required>
		</div>
	<?php } ?>

	<div class="form-group">
		<label>Shipping Address <span class="ast">*</span></label>
		<input id="streetAddress" type="text" class="form-control" name="streetAddress" value="<?php echo isset($streetAddress) ? $streetAddress : '' ?>" placeholder="Street Address" required>
	</div>
	<div class="form-group">
		<input id="unit" type="text" class="form-control" name="unit" value="<?php echo isset($unit) ? $unit : '' ?>" placeholder="Apt/Unit #">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-4">
				<label>City <span class="ast">*</span></label>
				<input type="text" id="city" class="form-control" name="city" value="<?php echo isset($shipping_city) ? $shipping_city : '' ?>" placeholder="City Name" required>
			</div>
			<div class="col-sm-4">
				<?php
				$states = array(
					'AA' => 'AA',
					'AE' => 'AE',
					'AP' => 'AP',
					'AL' => 'Alabama',
					'AK' => 'Alaska',
					'AZ' => 'Arizona',
					'AR' => 'Arkansas',
					'CA' => 'California',
					'CO' => 'Colorado',
					'CT' => 'Connecticut',
					'DE' => 'Delaware',
					'DC' => 'District of Columbia',
					'FL' => 'Florida',
					'GA' => 'Georgia',
					'HI' => 'Hawaii',
					'ID' => 'Idaho',
					'IL' => 'Illinois',
					'IN' => 'Indiana',
					'IA' => 'Iowa',
					'KS' => 'Kansas',
					'KY' => 'Kentucky',
					'LA' => 'Louisiana',
					'ME' => 'Maine',
					'MD' => 'Maryland',
					'MA' => 'Massachusetts',
					'MI' => 'Michigan',
					'MN' => 'Minnesota',
					'MS' => 'Mississippi',
					'MO' => 'Missouri',
					'MT' => 'Montana',
					'NE' => 'Nebraska',
					'NV' => 'Nevada',
					'NH' => 'New Hampshire',
					'NJ' => 'New Jersey',
					'NM' => 'New Mexico',
					'NY' => 'New York',
					'NC' => 'North Carolina',
					'ND' => 'North Dakota',
					'OH' => 'Ohio',
					'OK' => 'Oklahoma',
					'OR' => 'Oregon',
					'PA' => 'Pennsylvania',
					'RI' => 'Rhode Island',
					'SC' => 'South Carolina',
					'SD' => 'South Dakota',
					'TN' => 'Tennessee',
					'TX' => 'Texas',
					'UT' => 'Utah',
					'VT' => 'Vermont',
					'VA' => 'Virginia',
					'WA' => 'Washington',
					'WV' => 'West Virginia',
					'WI' => 'Wisconsin',
					'WY' => 'Wyoming',
				);
				$payer_data = get_items_sync_dmez();
				
				?>
				<label>State <span class="ast">*</span></label>
				<select id="state" class="form-control" name="state" required>
				<?php foreach ($states as $key => $val) { 
						$selected = false;
						if (!empty($shipping_state) && $key == $shipping_state ) $selected = true;
						if (empty($shipping_state) && $key == "IN") $selected = true;
						?>
						<option value="<?php echo $key; ?>" <?php if ($selected) echo "selected"; ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Zip Code <span class="ast">*</span></label>
				<input id="postcode" type="text" class="form-control" name="postcode" value="<?php echo isset($shipping_postcode) ? $shipping_postcode : '' ?>" placeholder="Postcode" required>
			</div>
		</div>
	</div>
</div>