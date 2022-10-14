<?php

/* ========================================================================================================================

  Creiden Framework include

  ======================================================================================================================== */

if ( ! function_exists( 'optionsframework_init' ) ) {
    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/creiden-framework/inc/' );
    require_once get_template_directory() . '/creiden-framework/inc/options-framework.php';
}

/*
 * Include Creiden Metabox Generator
 * 
 */
//
if ( ! function_exists( 'metaboxes_init' ) ) {
    define( 'METABOXES', get_template_directory_uri() . '/creiden-framework/theme-metaboxes/' );
    require_once get_template_directory() . '/creiden-framework/theme-metaboxes/inc/meta-box.php';
}