<?php /* Template Name: reorder-template */

if (!is_user_logged_in()){
	wp_redirect( get_home_url() );
}

get_header(); ?>
<div class="hfp-multisptep-container">
    <form id="reorderForm" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>"
          enctype="multipart/form-data">
        <label>Choose your breast pump <span class="ast">*</span></label>
		<?php
		// Get products
		$args     = array(
			'category' => array( 'pumps' ),
		);
		$products = wc_get_products( $args );
		?>
        <select name="productChoose" class="form-control" id="productChoose">
            
                    <?php
                    foreach ( $products as $product ) {
                        
                            // Get product variations
                            $args = [
                                'post_type'     => 'product_variation',
                                'post_parent'   => $product->get_id()
                                ];
                            $variations = get_posts( $args );
                            
                            if ( !empty( $variations ) ) { // This product has variations
                                ?>
                                <option value="<?php echo $product->get_id() ?>" disabled> <?php echo $product->get_name() ?> </option>
                                <?php
                                foreach ( $variations as $variation ) {
                                   ?>
                                   <option value="<?php echo $variation->ID ?>"> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $variation->post_title ?> </option>
                                   <?php
                                }
                            } else { // Simple product
                                ?>
                                <option value="<?php echo $product->get_id() ?>"> <?php echo $product->get_name() ?> </option>
                                <?php
                            }
                    }
                    ?>
                    <option value="0">No Pump</option>
        </select>

        <div class="form-group" id="fooby">
            <label>Tricare will pay for 90 breastmilk storage bags to get you started. Select from below:</label>
			<?php
			// Get products
			$args     = array(
				'category' => array( 'bags' ),
			);
			$products = wc_get_products( $args );
			?>
            <select name="fooby" class="form-control">
<!--                <option value="">select</option>-->
				<?php
				foreach ( $products as $product ) {
					$default_bag_selection = $product->get_name() == 'Kiinde TWIST Top Breast Milk Storage Pouches' ? 'selected' : '';
					?>
                    <option value="<?php echo $product->get_id() ?>" <?php echo $default_bag_selection ?>> <?php echo $product->get_name() ?> </option>
					<?php
				}
				?>
            </select>
        </div>
        <!--begin: Form Actions -->
        <div class="action-buttons">
            <div class="btn btn-brand btn-md btn-tall btn-wide action-button" id="action-submit">
                <button class="hfp-multi-step-form__submit" type="submit"><?php _e( 'Submit', 'hfp' ); ?></button>
                <input type="hidden" name="action" value="my_reorder_form"/>
            </div>
        </div>
    </form>
	</div>
<?php
// get_sidebar();
get_footer();
