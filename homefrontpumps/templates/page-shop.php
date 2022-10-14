<?php

/**
 * Template Name: Shop Page
 *
 * @package WordPress
 * @subpackage Home Front Pumps
 * @since Home Front Pumps 1.0
 */
get_header();
?>
<div class="container">
    <div class="hfp-shop-title">
        <h1 class="page-title">
            Products
        </h1>
    </div>

    <?php
    $args = array(
        'orderby' => 'title',
        'order' => 'ASC',
        'hide_empty' => true,
    );
    $product_categories = get_terms('product_cat', $args);
    $count = count($product_categories);
    if ($count > 0) {
        foreach ($product_categories as $product_category) { ?>
            <div class="section-container">
                <?php
                echo '<div class="section-title"><a class="hfp-categories-name" href="' . get_term_link($product_category) . '">' . $product_category->name . '</a></div>';
                $args = array(
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $product_category->slug
                        )
                    ),
                    'post_type' => 'product',
                    'orderby' => 'title,'
                );
                $products = new WP_Query($args); ?>
                <div class='items-parent even-items'>
                    <div class='items-row'>
                        <?php while ($products->have_posts()) {
                            $products->the_post();
                        ?>
                            <div class="item">
                                <a href="<?php the_permalink(); ?>" class="item-container">
                                    <div class="img-container">
                                        <img src="<?php the_post_thumbnail_url(); ?>" alt="">
                                    </div>
                                    <div class="title"><?php the_title(); ?></div>
                                    <div class="description">
                                        <?php
                                        $s = get_the_excerpt();

                                        $max_length = 57;

                                        if (strlen($s) > $max_length) {
                                            $offset = ($max_length - 3) - strlen($s);
                                            $s = substr($s, 0, strrpos($s, ' ', $offset)) . '...';
                                            echo $s;
                                        }
                                        echo $s;

                                        ?>

                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    <?php }
        wp_reset_postdata();
    } ?>
</div>
<?php get_footer(); ?>