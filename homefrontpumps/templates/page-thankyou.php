<?php
/**
 * Template Name: Thank you page
 **/
get_header();

global $wp;
$url = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
if ($_GET['primaryInsurance']) {
    ?>
        <section class="hfp-thankyou-content"><span class="subcontent">
        Thank you for registering with Homefront Pumps. We would love to help you with your breastfeeding journey. At this time we are only accepting patients with Tricare as their primary insurance. If you are covered by Tricare, please update your profile and upload a picture of the front and back of your military ID to verify your insurance. Please let us know if you have any questions </span></section>   
    <?php
} else {
    ?>
        <section class="hfp-thankyou-bg"></section>
        <section class="hfp-thankyou-content">Thank you!<br/><span class="subcontent">Your submission has been received<br>
        We will be in touch within the next few business days to process your order. </span></section>    
    <?php
}
get_footer(); ?>
