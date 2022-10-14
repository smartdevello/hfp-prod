<?php

/**
 * get back ground image for a section 
 * @param type $post_id 
 * @param type $field meta to get it
 * @param type $image_type thumbnail , high , low
 * @param type $src do you want the source or the hole array
 * @return string
 */
function get_background_image_for_section( $post_id , $field ,$image_type=NULL , $src=false ){
    $section_one_background = get_post_meta( $post_id , $field , true);
    if($image_type == NULL){
        $image_array = wp_get_attachment_image_src( $section_one_background, 'thumbnail' ) ;
    }else{
        $image_array = wp_get_attachment_image_src( $section_one_background, $image_type ) ;
    }
        
    if( ! empty( $image_array ) ){
        if( $src ){
            return $image_array[0];
        }else{
            return $image_array ;
        }
    }else{
        return 'no image added';
    }
}


/**
 * return font family allowed in the site
 * @return type
 */
function font_familys_allowed(){
            $fonts = creiden_google_fonts_concat(true);
            if( ! empty ( $fonts ) ){
                        $fonts_array = array();
                        foreach ( $fonts as $index=>$font ){
                                $fonts[$index]  = str_replace( '+',  ' ',  $fonts[$index] );
                                $fonts_array[ $font ] = $fonts[ $index ] ;
                       }
            }else{
                    return array("default"=>"default");
            }
            return $fonts_array ;
}



/**
 * return font familys by adding +
 * @return type
 */
function font_family_changer($font){
            $font  = str_replace( ' ',  '+',  $font );
            return $font ;
}

 // Google fonts
    /**
     * concatenates google fonts to one single link
     * @return string concatenated google fonts link
     */
    function creiden_google_fonts_concat($array = false) {
            $fonts = explode( "\n", cr_get_option( 'google_fonts' ,'' ) );
            $google_fonts = array();
            foreach ( $fonts as $font ) {
                    $match = array();
                    preg_match( '/family=(?P<fonts>(?:[\w+:,]+\|?)+)/', $font, $match );
                    if ( empty( $match ) ) {
                            continue;
                    }
                    $google_fonts[] = $match['fonts'];
            }
            if( $array ){
                      return $google_fonts ;
            }
            return ! empty( $google_fonts ) ? 'https://fonts.googleapis.com/css?family=' . implode( '|', $google_fonts ) : '';
    }
