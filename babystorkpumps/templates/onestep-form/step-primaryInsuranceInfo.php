<div class="primaryInsuranceInfo_tab">
	<div class="step-heading">Primary Insurance Information</div>

	<div class="form-group">
		<label>Primary Insurance <span class="ast">*</span></label>

		<?php 

		$primaryInsurance      = get_user_meta($user->ID, 'primaryInsurance', true);
		?>
		<select name="primaryInsurance" class="form-control" id="primaryInsurance" required>
		<option value="" disabled selected>select</option>
		<?php
			foreach($payer_data as $payer) {
				$savedprimaryInsurance = isset($primaryInsurance) && ($primaryInsurance == $payer->name) ? 'selected' : '';
				?>
				<option value="<?php echo $payer->name; ?>" <?php echo $savedprimaryInsurance ?> data-payer-id="<?php echo $payer->id; ?>" > <?php echo $payer->name; ?> </option>
				<?php
			}					
		?>
		</select>
	</div>

	
	<div class="form-group">
		<label class="sponsorRelationship_label">Relationship to sponsor</label>

		<select name="sponsorRelationship" class="form-control" id="sponsorRelationship">
			<option value="" disabled>select</option>

			<?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Self') ? 'selected' : ''; ?>
			<option value="Self" <?php echo $savedSponsorRelationship ?>>Self</option>
			<?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Spouse') ? 'selected' : ''; ?>
			<option value="Spouse" <?php echo $savedSponsorRelationship ?>>Spouse</option>
			<?php $savedSponsorRelationship = isset($sponsorRelationship) && ($sponsorRelationship == 'Parent') ? 'selected' : ''; ?>
			<option value="Parent" <?php echo $savedSponsorRelationship ?>>Parent</option>
		</select>
	</div>

	<div class="form-group">
		<label class="sponsorName_label">Sponsor Name</label>
		<input id="sponsorName" type="text" class="form-control" name="sponsorName" placeholder="Sponsor Name" value="<?php echo isset($sponsorName) ? $sponsorName : '' ?>">
	</div>
	<div class="form-group">
		<label class="dodNumber_label">DoD Benefits Number (DBN) <span class="ast">*</span></label>
		<span class="form-text">
			<a class="howtofinddbn"  target="_blank" href="https://www.tricare.mil/Plans/Eligibility/IDCards/ShowingYourID#:~:text=The%20DoD%20Benefits%20Number%20(DBN,to%20use%20to%20file%20claims">How to find your DBN</a>
		</span>

		<input id="dodNumber" type="text" class="form-control" name="dodNumber" placeholder="Benefits Number" required />
		<p class="dbn_position">
			<span class="form-text">11-digit number on back of card</span>
		</p>
	</div>

	<div class="form-group">
		<label>Have you received a breast pump for this birth? <span class="ast">*</span></label>
		<select name="receptionConfirmation" class="form-control" id="receptionConfirmation" required>
			<option value="" disabled selected>select</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		</select>
	</div>
	<div class="authorize" id="productReceived" style="display: none"> Tricare insurance only covers one breast pump per birth or adoption. Contact Baby Stork Pumps customer service for more information: info@babystorkpumps.com</div>
	<div class="form-group" id="productChoose" style="display: none">
		<label>Choose your breast pump <span class="ast">*</span></label>
		<?php
		// Get products
		$args = array(
			'category' => array('pumps'),
			'limit' => -1
		);
		$products = wc_get_products($args);
		?>
		<select name="productChoose" class="form-control" id="productChoose">
			<option value="" disabled selected>select</option>
			<?php
			foreach ($products as $product) {
				// Get product variations
				$args = [
					'post_type'     => 'product_variation',
					'post_parent'   => $product->get_id()
				];
				$variations = get_posts($args);

				if (!empty($variations)) { // This product has variations
			?>
					<option  value="<?php echo $product->get_id() ?>"  data-sku="<?php echo $product->get_sku(); ?>"  disabled> <?php echo $product->get_name() ?> </option>
					<?php
					foreach ($variations as $variation) {
					?>
						<option    value="<?php echo $variation->ID ?>" data-sku="<?php echo $product->get_sku(); ?>" > &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $variation->post_title ?> </option>
					<?php
					}
				} else { // Simple product
					?>
					<option  value="<?php echo $product->get_id() ?>" data-sku="<?php echo $product->get_sku(); ?>"  > <?php echo $product->get_name() ?> </option>
			<?php
				}
			}
			?>
		</select>
	</div>
	<div class="form-group" id="fooby">
		<label>Choose Breast Milk Storage Bags</label>
		<?php
		// Get products
		$args = array(
			'category' => array('bags'),
			'limit' => -1
		);
		$products = wc_get_products($args);
		?>
		<select name="fooby" class="form-control" required>
			<option value="" disabled selected>select</option>

            <?php
            foreach( $products as $product ) {
                $default_bag_selection = $product->get_name() == 'Kiinde TWIST Top Breast Milk Storage Pouches' ? 'selected' : '';
                ?>
                <option value="<?php echo $product->get_id() ?>" data-sku="<?php echo $product->get_sku(); ?>" > <?php echo $product->get_name() ?> </option>
            <?php
            }
            ?>
			<option value="-1" <?php echo $default_bag_selection ?>> No pouches needed </option>                
		</select>
	</div>

</div>

<script>var payer_data = (<?php echo json_encode($payer_data);?>);</script>

