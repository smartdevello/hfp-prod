<?php
// this file holds the metaboxes and manage the configiration for metaboxes 
/**
 * this function created to hold the data rather than calling font_familys_allowed() and call database each time 
 * @return type
 */
function get_external_google_fonts(){
    global $google_fonts ;
    
    if( empty( $google_fonts ) ){
            $edialoug_google_fonts = font_familys_allowed() ;        
            $google_fonts = $edialoug_google_fonts ;
            return $edialoug_google_fonts ;
    }else{
        return $google_fonts ;
    }
}

require_once get_template_directory() . '/inc/edialog_metaboxes/home_metaboxes.php';
require_once get_template_directory() . '/inc/edialog_metaboxes/contact_metaboxes.php';
require_once get_template_directory() . '/inc/edialog_metaboxes/about_metaboxes.php';
 require_once get_template_directory() . '/inc/edialog_metaboxes/faq_metaboxes.php';

function creiden_check_page_template($meta_boxes) {
        
        // home meta boxes
          $metaboxes = array();
          $metaboxes[] =  edialoug_home_metaboxes();
          $metaboxes[] = edialoug_about_metaboxes();
          $metaboxes[] = edialoug_contact_metaboxes();
          $metaboxes[] = edialoug_faq_metaboxes();
          
              
            foreach ( $metaboxes as $meta_box_index => $meta_box )
            {
                    if ( isset( $meta_box['creiden_autohrize_only_on'] ) && ! creiden_maybe_include( $meta_box['creiden_autohrize_only_on'] ) )
                    {
                                unset( $metaboxes[$meta_box_index] );
                    }
            }
            return $metaboxes ;
}

add_action( 'rwmb_meta_boxes', 'creiden_check_page_template' );

function creiden_maybe_include($conditions ){
	if ( ! is_admin() )
	{
		return true;
	}
	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
	{
		return true;
	}
	if ( isset( $_GET['post'] ) )
	{
		$post_id = intval( $_GET['post'] );
	}
	elseif ( isset( $_POST['post_ID'] ) )
	{
		$post_id = intval( $_POST['post_ID'] );
	}
	else
	{
		$post_id = false;
	}
	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

                    foreach ( $conditions as $cond => $v )
	{
		// Catch non-arrays and i transform theme to array
		switch ( $cond )
		{
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) )
				{
					return true;
				}
				break;
		}
	}
	// If no condition matched
	return false;
}


/* Enqueue New Google Fonts */

function load_google_fonts() {
            wp_register_style('googleFontsAbel','http://fonts.googleapis.com/css?family=Abel');
            wp_enqueue_style( 'googleFontsAbel'); 

            wp_register_style('googleFontsOldStandardTT','http://fonts.googleapis.com/css?family=Old+Standard+TT');
            wp_enqueue_style( 'googleFontsOldStandardTT');

}
add_action('wp_print_styles', 'load_google_fonts');
