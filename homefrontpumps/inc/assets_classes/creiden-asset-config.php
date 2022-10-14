<?php
define( 'EDIALOUGE_THEME_DIR', get_template_directory_uri() );
return array(
	/* ======================================================================= *
	 *                                  ASSETS                                 *
	 * ======================================================================= */
	'assets'		 => array(
		/* --------------------------- SCRIPTS ------------------------------- */
		'scripts' => array(
			'app' => array(
				'src'		 =>  EDIALOUGE_THEME_DIR. 'assets/site.js',
				'conditions' => array( ! is_admin() ),
				'deps'		 => array( 'jquery' ),
			),
		),


		/* --------------------------- STYLES -------------------------------- */
		'styles'	 => array(
			'main'	 => array(
				'src'		 => EDIALOUGE_THEME_DIR. '/style.css',
				'deps'		 => array( 'wp-mediaelement' ),
				'conditions' => array( ! is_admin() ),
				'extra'		 => array(
					'rtl'	 => 'replace',
					'suffix' => '.min',
				),
			),
			'font'	 => array(
				'src' => 'http://fonts.googleapis.com/css?family=Lato:300,400',
				'src' => 'http://fonts.googleapis.com/earlyaccess/droidarabickufi.css',
				'conditions' => array( ! is_admin() ),
			),
		),
	),
);
