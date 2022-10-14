<?php
/**
 * Template Name: About us page
 **/
get_header();
?>
<section class="hfp-about">
    <div class="hfp-about-container">
        <div class="row">
            <div class="col-md-6 hfp-about__text">
                <div class="hfp-about__text--semicircle">
                    <h1 class="hfp-about__text--title"><?php _e('About','hfp');?></h1>
                </div>
                <div class="hfp-about__text--logo">
                    <img src="<?php echo get_template_directory_uri();?>/assets/img/about/Logo.png"/>
                </div>
                <p class="hfp-about__text--paragraph">
                    Our goal at Homefront Pumps is to provide military families with the most successful breastfeeding journey possible. Working directly with Tricare insurance, Homefront Pumps ensures that the highest quality breastfeeding pumps and supplies are available at no cost and with no additional fees, so that our customers can choose what best fits their life and the needs of their growing family. <br/><br/>We pride ourselves on offering four-star customer service as well, with our support team professionally staffed by certified lactation consultants.
                </p>
                <div class="hfp-about__text--social">
                        <a class="hfp-about__text--social__item" href="https://facebook.com/homefrontpumpsllc">
                            <img src="<?php echo get_template_directory_uri();?>/assets/img/about/Icon-Facebook.png"/>
                        </a>
                        <a class="hfp-about__text--social__item" href="https://www.instagram.com/homefrontpumpsllc">
                            <img src="<?php echo get_template_directory_uri();?>/assets/img/about/Icon-Instagram.png"/>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
