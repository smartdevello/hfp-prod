<?php
/**
 * Template Name: Finish order
 **/
 // check the login status
 if( is_user_logged_in() ) {
     $user_id = get_current_user_id();
     $user = get_user_by( 'ID', $user_id );
     $free_product_acquired = get_user_meta( $user_id, 'free_product_acquired', true );
     $form_in_progress = get_user_meta( $user_id, 'form_in_progress', true ); // to check whether to redirect to the main form or the new facebook form
     // didn't get his free product
     if(empty($free_product_acquired)) {
         
         if( $form_in_progress == 1 ) { // main form
            $redirect = get_template_page_url  ( 'templates/page-multistepForm.php' );
            header("location: ".$redirect);
            exit();
         } elseif ( $form_in_progress == 2 ) { // new facebook form
            $redirect = get_template_page_url  ( 'templates/page-new-multistepForm.php' );
            header("location: ".$redirect);
            exit();
         }
         
     }
        
     // did get his free product
     else {
       // redirected to the home page
       $redirect = get_template_page_url  ( 'templates/page-home.php' );
       header("location: ".$redirect);
       exit();
     }
 }
 // the user isn't logged in
 else {
   // redirected to Login page
   $redirect = home_url() . '/wp-login.php';
   header("location: ".$redirect);
   exit();
 }


?>
