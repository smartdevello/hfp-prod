<!-- Begin: Home products -->
<section class="hfp-home-products">
    <h2 class="hfp-home-products__title"><?php _e('Best Accessories','hfp');?></h2>
    <?php
        $products = wc_get_products(array(
            'tag' => 'home-carousel'
        ));
        if (isset($products) && !empty($products)) :
    ?>
    <!-- Begin: Carousel -->
    <div class="owl-carousel js-homeProducts">
        <?php foreach($products as $product_id) :
            $product = wc_get_product( $product_id );
        ?>            

        <div class="hfp-home-products__item item">
            <a class="hfp-home-products__thumb" href="<?php echo get_permalink( $product->get_id() ); ?>">
                <div class="hfp-home-products__img">
                    <img src="<?php echo get_the_post_thumbnail_url( $product->get_id(), 'full' );?>"/>
                </div>
                <h5 class="hfp-home-products__name"><?php echo $product->get_name();?></h5>
                <p class="hfp-home-products__text"><?php echo $product->get_short_description();?></p>
            </a>
        </div>
        <?php endforeach;?>
    </div>
    <!-- End: Carousel -->
    <?php endif;?>
</section>
<!-- End: Home products -->
