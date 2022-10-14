<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = 'rojo';
	$themename = preg_replace("/\W/", "_", strtolower($themename));

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
function optionsframework_options() {

	global $fonts_global_array;

	$args = array(
			'post_type' => 'ml-slider',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => -1
	);

	$the_query = new WP_Query($args);

	while ($the_query->have_posts()) {
		$the_query->the_post();
		$sliders[$the_query->post->ID] = get_the_title();
	}
	if(!isset($sliders)) {
		$sliders = array();
	}
	array_key_exists(0, $sliders) ? $sliders[$the_query->post->ID + 1] = 'ultimate' : $sliders['ultimate'] = 'ultimate' ;
	array_key_exists(1, $sliders) ? $sliders[$the_query->post->ID + 2] = 'posts' : $sliders['posts'] = 'posts' ;
	array_key_exists(2, $sliders) ? $sliders[$the_query->post->ID + 3] = '3D Slider' : $sliders['3D'] = '3D Slider' ;
	array_key_exists(3, $sliders) ? $sliders[$the_query->post->ID + 4] = 'Elastic Slider' : $sliders['Elastic'] = 'Elastic Slider' ;
	// Background Defaults
	$background_defaults = array(
			'color' => '',
			'image' => '',
			'repeat' => 'repeat',
			'position' => 'top center',
			'attachment' => 'scroll');

	// Typography Defaults
	$typography_defaults = array(
			'size' => '16px',
			'face' => 'Arial',
			'style' => 'Normal',
			'color' => '#bada55');

	// Typography Options
	$my_fonts = array(
	'OpenSansSemibold' => 'OpenSansSemibold',
	'BebasNeueRegular' => 'BebasNeueRegular',
	'OpenSansLight' => 'OpenSansLight',
	'OpenSansRegular' => 'OpenSansRegular',
	'OpenSansBold' => 'OpenSansBold',
	'OpenSansSemiboldItalic' => 'OpenSansSemiboldItalic',
	'OpenSansExtrabold' => 'OpenSansExtrabold',
	'visitortt1brkRegular' => 'visitortt1brkRegular',
	'PTSerifItalic' => 'PTSerifItalic',
	'Arial' => 'Arial',
	'Times New Roman' => 'Times New Roman',
	'Droid Arabic Kufi' => 'Droid Arabic Kufi',
	'OpenSansItalic' => 'OpenSansItalic'
	);
	$typography_options = array(
			'sizes' => range(6, 71),
			'faces' =>  array_merge($my_fonts , $fonts_global_array),
			'styles' => array('Normal' => 'Normal','Italic' => 'Italic'),
			'weights' => array('Normal' => 'Normal','Bold' => 'Bold'),
			'color' => TRUE
	);

	//side bars array
	$sideBarsArray = array();
	$side_bars = cr_get_option("sidebars");
	if(isset($side_bars) && is_array($side_bars)) {
		foreach ($side_bars as $sidebar) {
			$sideBarsArray[$sidebar] = $sidebar;
		}
	}
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	// Get all posts in the website
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	wp_reset_postdata();

	$pages = get_pages();

	if(isset($pages)&& is_array($pages)){
		foreach ( $pages as $page ) {
			$pagesList[$page->ID]=$page->post_title;
		}
	}
	wp_reset_postdata();

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ($options_tags_obj as $tag) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath = get_template_directory_uri() . '/creiden-framework/images/';
	$imagepathinc = get_template_directory_uri() . '/creiden-framework/inc/images/';
	$options = array();

/* ========================================================================================================================

Start of Options

======================================================================================================================== */

/* ========================================================================================================================

General Settings

======================================================================================================================== */


			/* ========================================================================================================================

			Header Options

			======================================================================================================================== */
			$options[] = array(
				'name' => __('Header Settings', 'options_framework_theme'),
				'icon_name' => $imagepathinc . 'sub.png',
				'type' => 'heading'
			);

			$options[] = array(
				'name' => __('Header Logo', 'options_framework_theme'),
				'desc' => __('Add header dark logo that will appear in the mobile header before opening the menu', 'options_framework_theme'),
				'id' => 'header_dark_logo',
				'std' => get_template_directory_uri() .'/assets/img/logo_big.png',
				'class' => '',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Header Light Logo', 'options_framework_theme'),
				'desc' => __('Add header ligh logo that will appear in the mobile header after opening the menu', 'options_framework_theme'),
				'id' => 'header_light_logo',
				'std' => get_template_directory_uri() .'/assets/img/logo_small.png',
				'class' => '',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Header User Text', 'options_framework_theme'),
				'desc' => __('This text will appear in the burger menu content in mobile view', 'options_framework_theme'),
				'id' => 'header_user_text',
				'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
				'class' => 'mini',
				'type' => 'text');

			$options[] = array(
				'name' => __('Register link', 'options_framework_theme'),
				'desc' => __('Insert register url here', 'options_framework_theme'),
				'id' => 'header_register',
				'std' => site_url() . '/register',
				'class' => 'mini',
				'type' => 'text');

			$options[] = array(
				'name' => __('Login link', 'options_framework_theme'),
				'desc' => __('Insert login url here', 'options_framework_theme'),
				'id' => 'header_login',
				'std' => site_url() . '/login',
				'class' => 'mini',
				'type' => 'text');

			$options[] = array(
				'name' => __('My account link', 'options_framework_theme'),
				'desc' => __('Insert my account page url here', 'options_framework_theme'),
				'id' => 'header_myaccount',
				'std' => site_url() . '/my-account',
				'class' => 'mini',
				'type' => 'text');




			/* ========================================================================================================================

			Footer Options

			======================================================================================================================== */

			$options[] = array(
					'name' => __('Footer Settings', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => __('Copy Rights Text', 'options_framework_theme'),
					'desc' => __('Enter the text you want to show in your footer here', 'options_framework_theme'),
					'id' => 'copy_rights_text',
					'std' => 'All rights Reserved',
					'type' => 'text'
			);
			
			
			/* ========================================================================================================================

			Footer Options

			======================================================================================================================== */

			$options[] = array(
					'name' => __('Contact GM', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => __('image', 'options_framework_theme'),
					'desc' => __('Enter the Image General Manager', 'options_framework_theme'),
					'id' => 'img_gm',
					'std' => '',
					'type' => 'upload'
			);
			
			$options[] = array(
					'name' => __('Name', 'options_framework_theme'),
					'desc' => __('Enter the Name General manager', 'options_framework_theme'),
					'id' => 'name_gm',
					'std' => '',
					'type' => 'text'
			);
			
			$options[] = array(
					'name' => __('description', 'options_framework_theme'),
					'desc' => __('Enter the description General Manager', 'options_framework_theme'),
					'id' => 'desc_gm',
					'std' => '',
					'type' => 'textarea'
			);

			/* ========================================================================================================================

			Logo Builder

			======================================================================================================================== */

			$options[] = array(
					'name' => __('Logo and favicon', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);
			$options[] = array(
					'name' => __('Logo Builder', 'options_framework_theme'),
					'desc' => __('Preferred Logo Size is 270px X 137px ', 'options_framework_theme'),
					'id' => 'theme_logo',
					'std' => '',
					'class' => 'theme_logo',
					'type' => 'upload');

			$options[] = array(
					'name' => __('Preview Logo Position and Size', 'options_framework_theme'),
					'desc' => __('Check here', 'options_framework_theme'),
					'id' => 'logoWrapper',
					'class' => 'builder',
					'type' => 'logo_builder');

			$options[] = array(
					'id' => 'logo_width',
					'class' => 'mini',
					'placeholder' => 'Width',
					'std' => '270',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_height',
					'class' => 'mini',
					'placeholder' => 'Height',
					'std' => '137',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_top',
					'class' => 'mini',
					'placeholder' => 'Top',
					'std' => '0',
					'type' => 'text');

			$options[] = array(
					'id' => 'logo_left',
					'class' => 'mini',
					'placeholder' => 'Left',
					'std' => '0',
					'type' => 'text');

			$options[] = array(
					'desc' => __('Aspect Ratio', 'options_framework_theme'),
					'id' => 'logo_aspectRatio',
					'class' => 'mini',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
					'id' => 'resetLogoSize',
					'text' => 'Reset Size',
					'type' => 'button'
			);

			/* ========================================================================================================================

			Logo, Favicon and Post Image

			======================================================================================================================== */

			$options[] = array(
					'name' => __('General Options', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);
			$options[] = array(
					'name' => __('Light Logo', 'options_framework_theme'),
					'desc' => __('Preferred Logo Size is 263 x 44 ', 'options_framework_theme'),
					'id' => 'light_logo',
					'std' => '',
					'type' => 'upload');
    
            $options[] = array(
					'name' => __('Dark Logo', 'options_framework_theme'),
					'desc' => __('Preferred Logo Size is 263 x 44 ', 'options_framework_theme'),
					'id' => 'dark_logo',
					'std' => '',
					'type' => 'upload');
            

			$options[] = array(
					'name' => __('Logo Height', 'options_framework_theme'),
					'desc' => __("Enter the header's height, preferred to be 40px bigger than the logo height"),
					'id' => 'header-height',
					'std' => '44',
					'type' => 'text'
			);

			$options[] = array(
				'name' => __('Default Post Image', 'options_framework_theme'),
				'desc' => __('Used for posts without a thumbnaill, minimum Size is 410 x 410 ', 'options_framework_theme'),
				'id' => 'default_post_image',
				'std' => '',
				'type' => 'upload');
	
			$options[] = array(
					'name' => __('Favicon', 'options_framework_theme'),
					'desc' => __('Upload your favicon here (Please use *.ico file type only)', 'options_framework_theme'),
					'id' => 'favicon',
					'std' => '',
					'type' => 'upload');




			/* ========================================================================================================================

			Footer Options

			======================================================================================================================== */

			$options[] = array(
					'name' => __('Footer Settings', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => __('Copy Rights Text', 'options_framework_theme'),
					'desc' => __('Enter the text you want to show in your footer here', 'options_framework_theme'),
					'id' => 'copy_rights_text',
					'std' => '(c) 2015 Jacaranda Apps Pty Limited - Developed by Creiden',
					'type' => 'text'
			);
    
    
            $options[] = array(
					'name' => __('Terms and Conditions', 'options_framework_theme'),
					'desc' => __('Enter Terms and Conditions Link', 'options_framework_theme'),
					'id' => 'terms',
					'std' => '',
					'type' => 'text');
    
    
            $options[] = array(
					'name' => __('Privacy Policy', 'options_framework_theme'),
					'desc' => __('Enter Privacy Policy Link', 'options_framework_theme'),
					'id' => 'privacy',
					'std' => '',
					'type' => 'text');
    
    
			/* ========================================================================================================================

																	Social Icons

			======================================================================================================================== */


			$options[] = array(
					'name' => __('Social Icons', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);

			$options[] = array(
					'name' => __('Facebook', 'options_framework_theme'),
					'desc' => __('Enter Facebook Link', 'options_framework_theme'),
					'id' => 'fb',
					'std' => '',
					'type' => 'text');


			$options[] = array(
					'name' => __('Twitter', 'options_framework_theme'),
					'desc' => __('Enter Twitter Link', 'options_framework_theme'),
					'id' => 'twitter',
					'std' => '',
					'type' => 'text');


			$options[] = array(
					'name' => __('Tumblr', 'options_framework_theme'),
					'desc' => __('Enter Tumbr Link', 'options_framework_theme'),
					'id' => 'tumblr',
					'std' => '',
					'type' => 'text');

			$options[] = array(
					'name' => __('Google+', 'options_framework_theme'),
					'desc' => __('Enter Google+ Link', 'options_framework_theme'),
					'id' => 'gplus',
					'std' => '',
					'type' => 'text');

			$options[] = array(
					'name' => __('Youtube', 'options_framework_theme'),
					'desc' => __('Enter Youtube Link', 'options_framework_theme'),
					'id' => 'youtube',
					'std' => '',
					'type' => 'text');

			$options[] = array(
					'name' => __('Vimeo', 'options_framework_theme'),
					'desc' => __('Enter Vimeo Link', 'options_framework_theme'),
					'id' => 'vimeo',
					'std' => '',
					'type' => 'text');
	
	
			/* ========================================================================================================================

			Advanced Options

			======================================================================================================================== */

			$options[] = array(
					'name' => __('Advanced', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);
			
			
			$options[] = array(
					'name' => __('Default Post image', 'options_framework_theme'),
					'desc' => __('The image to show if post has no thumbnail (this will only work if post type is not none)', 'options_framework_theme'),
					'id' => 'post_default',
					'std' => $imagepathinc . 'defaultImage.png',
					'class' => 'theme_logo',
					'type' => 'upload');

			$options[] = array(
					'name' => __('Custom CSS Code', 'options_framework_theme'),
					'desc' => __('Paste any CSS rules that you want to add to the theme here.', 'options_framework_theme'),
					'id' => 'custom_css',
					'std' => '',
					'type' => 'textarea');

			$options[] = array(
					'name' => __('Customs Java Script code', 'options_framework_theme'),
					'desc' => __('Paste any JS that you want to add to the theme here.', 'options_framework_theme'),
					'id' => 'custom_js',
					'std' => '',
					'type' => 'textarea');

			$options[] = array(
					'name' => __('Login Page Logo', 'options_framework_theme'),
					'desc' => __('Upload your preferred image for Wordpress Login page here (preferred size 274x63 pixels)', 'options_framework_theme'),
					'id' => 'login_image',
					'type' => 'upload');



/* ========================================================================================================================

														404 PAGE

======================================================================================================================== */


			$options[] = array(
					'name' => __('404 page', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);
			
			$options[] = array(
					'name' => __('facebook', 'options_framework_theme'),
					'desc' => __('Enter Facebook Link', 'options_framework_theme'),
					'id' => 'fb',
					'std' => '',
					'type' => 'text');
			
			
			$options[] = array(
					'name' => __('twitter', 'options_framework_theme'),
					'desc' => __('Enter Twitter Link', 'options_framework_theme'),
					'id' => 'twitter',
					'std' => '',
					'type' => 'text');
					
					
			$options[] = array(
					'name' => __('dribble', 'options_framework_theme'),
					'desc' => __('Enter Dribble Link', 'options_framework_theme'),
					'id' => 'dribble',
					'std' => '',
					'type' => 'text');
					
			$options[] = array(
					'name' => __('linkedIn', 'options_framework_theme'),
					'desc' => __('Enter linkedIn Link', 'options_framework_theme'),
					'id' => 'linkedin',
					'std' => '',
					'type' => 'text');

/* ========================================================================================================================

														404 PAGE

======================================================================================================================== */


			$options[] = array(
					'name' => __('Contact Details', 'options_framework_theme'),
					'icon_name' => $imagepathinc . 'sub.png',
					'type' => 'heading'
			);
			
			$options[] = array(
					'name' => __('Title', 'options_framework_theme'),
					'desc' => __('Enter Text on the top ', 'options_framework_theme'),
					'id' => 'title_call',
					'std' => '',
					'type' => 'text');
					
			
			$options[] = array(
					'name' => __('Phone Number', 'options_framework_theme'),
					'desc' => __('Enter Phone Number', 'options_framework_theme'),
					'id' => 'phone_number',
					'std' => '',
					'type' => 'text');
					
					
			$options[] = array(
					'name' => __('E-Mail', 'options_framework_theme'),
					'desc' => __('Enter E-Mail', 'options_framework_theme'),
					'id' => 'mail',
					'std' => '',
					'type' => 'text');
					
			$options[] = array(
					'name' => __('Text Button', 'options_framework_theme'),
					'desc' => __('Enter Text Button', 'options_framework_theme'),
					'id' => 'text_button',
					'std' => '',
					'type' => 'text');
			$options[] = array(
					'name' => __('Button Link', 'options_framework_theme'),
					'desc' => __('Enter Button Link', 'options_framework_theme'),
					'id' => 'button_link',
					'std' => '',
					'type' => 'text');

/* ========================================================================================================================

Maintainance Tab

======================================================================================================================== */
			$options[] = array(
				'name' => __('Maintainance Page', 'options_framework_theme'),
				'icon_name' => $imagepathinc . 'contact.png',
				'type' => 'heading'
			);
			$options[] = array(
					'name' => __('Maintainance Logo Uploader', 'options_framework_theme'),
					'desc' => __('Upload your Maintainance Logo here', 'options_framework_theme'),
					'id' => 'maintainance_logo',
					'std' => '',
					'type' => 'upload'
			);
			$options[] = array(
					'name' => __('Maintainance Background Uploader', 'options_framework_theme'),
					'desc' => __('Upload your Maintainance Background here', 'options_framework_theme'),
					'id' => 'maintainance_background',
					'std' => '',
					'type' => 'upload'
			);
			$options[] = array(
				'name' => __('Maintainance Page Bold Title', 'options_framework_theme'),
				'desc' => __('Enter the title of the maintanance page', 'options_framework_theme'),
				'std'=> 'Stay tuned ! ',
				'id' => 'maintainance_page_title_bold',
				'type' => 'text'
			);
			$options[] = array(
				'name' => __('Maintainance Page Title', 'options_framework_theme'),
				'desc' => __('Enter the title of the maintanance page', 'options_framework_theme'),
				'std'=> 'Few days to be launched !',
				'id' => 'maintainance_page_title',
				'type' => 'text'
			);
			$options[] = array(
				'name' => __('Subscribe Title', 'options_framework_theme'),
				'desc' => __('Enter Subscribe Title', 'options_framework_theme'),
				'std'=> 'Subscribe Now to know when we’re ready',
				'id' => 'maintainance_page_subs_title',
				'type' => 'text'
			);
			$options[] = array(
				'name' => __('Wysija Shortcode', 'options_framework_theme'),
				'desc' => __('Enter Wysija Shortcode', 'options_framework_theme'),
				'std'=> '[mc4wp_form]',
				'id' => 'maintainance_page_wysija',
				'type' => 'text'
			);

/* ========================================================================================================================

														USERVOICE

======================================================================================================================== */


	$options[] = array(
		'name'		 => __( 'UserVoice', 'options_framework_theme' ),
		'icon_name'	 => $imagepathinc . 'importexport.png',
		'type'		 => 'heading'
	);

	$options[] = array(
		'name'	 => __( 'UserVoice JavaScript API Key', 'options_framework_theme' ),
		'desc'   => 'UserVoice admin console > settings > widgets > Advanced',
		'id'	 => 'uservoice_sdk',
		'std'	 => '',
		'type'	 => 'text',
	);

//	$options[] = array(
//		'name'	 => __( 'UserVoice Widget', 'options_framework_theme' ),
//		'id'	 => 'uservoice_widget',
//		'desc'   => 'UserVoice admin console > settings > widgets > Classic Widget Popup'
//				  . 'copy and paste the widget link from the embed code',
//		'std'	 => '',
//		'type'	 => 'textarea',
//	);


	/* ========================================================================================================================

Backup & Restore Tab

======================================================================================================================== */

	$options[] = array(
			'name' => __('Backup & Restore', 'options_framework_theme'),
			'icon_name' => $imagepathinc . 'importexport.png',
			'type' => 'heading'
	);
	$backup = get_option('rojo_backups', array());
	$backup_log = isset($backup['backup_log']) ? $backup['backup_log'] : 'no backup available';
	$options[] = array(
			'id' => 'backup-options',
			'text' => 'Backup',
			'desc' => "<p id='backup_log'>" . $backup_log . "</p>",
			'type' => 'button'
	);

	$options[] = array(
			'id' => 'restore-options',
			'text' => 'Restore',
			'type' => 'button'
	);

	$options[] = array(
			'name' => __('Export Options', 'options_framework_theme'),
			'id' => 'export_data',
			'type' => 'export-options'
	);
	$options[] = array(
			'name' => __('Import Options', 'options_framework_theme'),
			'id' => 'import_data',
			'type' => 'import_options'
	);
	return apply_filters('creiden_theme_options', $options);
}

/* ========================================================================================================================

End of Options

======================================================================================================================== */


add_action( 'admin_enqueue_scripts', 'of_static_pagebuilder' );

function of_static_pagebuilder($screen_hook) {
	if(!preg_match('/^(appearance_page_options-framework|post\.php|post-new\.php)$/', $screen_hook)) return;
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	$categoriesHTML ='';
	foreach ($options_categories as $catID => $catName) {
		$categoriesHTML .= '<option value="' . $catID . '">' . $catName .'</option>' ;
	}
	$postsHTML='';
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	foreach ($postNames as $postID => $value) {
		$postsHTML.= '<option value="' . $postID . '">' . $value .'</option>' ;
	}
	wp_reset_postdata();

	$args = array(
			'post_type' => 'ml-slider',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => -1
	);
	$get_sliders = get_posts($args);
	foreach ($get_sliders as $key => $post) {
		$sliders[$post->ID] = $post->post_title;
	}
	if(!isset($sliders)) {
		$sliders = array();
	}
	array_key_exists(0, $sliders) ? $sliders[$post->ID + 1] = 'ultimate' : $sliders['ultimate'] = 'ultimate' ;
	array_key_exists(1, $sliders) ? $sliders[$post->ID + 2] = 'posts' : $sliders['posts'] = 'posts' ;
	array_key_exists(2, $sliders) ? $sliders[$post->ID + 3] = '3D Slider' : $sliders['3D'] = '3D Slider' ;
	array_key_exists(3, $sliders) ? $sliders[$post->ID + 4] = 'Elastic Slider' : $sliders['Elastic'] = 'Elastic Slider' ;
	$slidersHTML='';
	foreach ($sliders as $id => $value) {
		$slidersHTML.= '<option value="' . $id . '">' . $value .'</option>' ;
	}
	$carousel_posts_area =
	'<li class="carousel_posts_area" style="width: 846px;">
		<div class="widget-head">
			Posts Carousel <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
			<span class="plus-icon" style="display: none;"></span>
			<span class="minus-icon" style=""></span>
			<span class="remove-icon"></span>
		</div>
		<div class="widget-content" style="display: none;">
			<div class="option_container" style="">
				<h4 class="heading">Posts Type</h4>
					<select class="of-input" name="rojo[pagebuilder][carousel0][home_carousel_posts_type]" id="home_carousel_posts_type" style="">
						<option value="latest">Latest Posts</option><option value="pop">Popular Posts</option><option value="selected">Selected Posts</option>
					</select>
				<label class="explain" for="home_carousel_posts_type">Select the type of posts to show in the Carousel Area</label>
			</div>
			<div class="option_container" style="display: block;">
				<h4 class="heading">Selected Categories</h4>
				<select name="rojo[pagebuilder][carousel0][carousel_selected_cat][]" id="carousel_selected_cat" multiple="" class="uniform-multiselect">
				'.$categoriesHTML.'
				</select>
				<label class="explain" for="carousel_selected_cat">Select the categories you want</label>
			</div>
			<div class="option_container" style="display: none;">
				<h4 class="heading">Selected Posts</h4>
				<select name="rojo[pagebuilder][carousel0][carousel_selected_posts][]" id="carousel_selected_posts" multiple="" class="uniform-multiselect">
					'.$postsHTML.'
				</select>
				<label class="explain" for="carousel_selected_posts">Select the Posts you want</label>
			</div>
			<div class="option_container" style="display: block;">
				<h4 class="heading">Number of Posts</h4>
				<input id="carousel_number_of_posts" placeholder="" class="of-input" name="rojo[pagebuilder][carousel0][carousel_number_of_posts]" type="text" value="4">
				<label class="explain" for="carousel_number_of_posts">Enter the number of posts you want to show (-1 for unlimited)</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][carousel0][width]" value="100">
		</div>
	</li>';

	$home_slider =
	'<li class="home_slider" style="width: 846px;">
		<div class="widget-head">
			Home Slider <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
			<span class="plus-icon" style="display: none;"></span>
			<span class="minus-icon" style=""></span>
			<span class="remove-icon"></span>
		</div>
		<div class="widget-content" style="">
			<div class="option_container" style="">
				<h4 class="heading">Select Slider</h4>
					<select class="of-input" name="rojo[pagebuilder][homeSlider0][home_select_slider]" id="home_select_slider" style="">
						'.$slidersHTML.'
					</select>
				<label class="explain" for="home_select_slider">Select the Slider that you want in this place</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][homeSlider0][width]" value="100">
		</div>
	</li>';

	$vertical_posts_area =
	'<li class="vertical_posts_area" style="width: 846px;">
		<div class="widget-head">
			Vertical Area <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
			<span class="plus-icon" style="display: none;"></span>
			<span class="minus-icon" style=""></span>
			<span class="remove-icon"></span>
		</div>
		<div class="widget-content" style="">
			<div class="option_container" style="">
				<h4 class="heading">Posts Type</h4>
					<select class="of-input" name="rojo[pagebuilder][verticalPosts0][home_vertical_posts_type]" id="home_vertical_posts_type" style="">
						<option value="latest">Latest Posts</option><option value="pop">Popular Posts</option>
					</select>
				<label class="explain" for="home_vertical_posts_type">Select the type of posts to show in the Vertical Posts Area</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Selected Categories</h4>
				<select name="rojo[pagebuilder][verticalPosts0][vertical_area_selected_cat][]" id="vertical_area_selected_cat" multiple="" class="uniform-multiselect">
					'.$categoriesHTML.'
				</select>
				<label class="explain" for="vertical_area_selected_cat">Select the categories you want</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][verticalPosts0][width]" value="100">
		</div>
	</li>';

	$twitter_area =
	'<li class="twitter_area" style="width: 846px;">
		<div class="widget-head">
			Separator <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

			<span class="remove-icon"></span>
		</div>
		<div class="widget-content" style="">
			<div class="option_container">
				<h4 class="heading">Separator Content</h4>
				<ul class="radioButtonWrapper">
					<li>
						<label><input class="of-input of-radio" type="radio" name="rojo[pagebuilder][separator][separator_radio]" id="rojo-separator_radio-twitter" value="twitter" checked="checked">
						Twitter</label>
					</li>
					<li>
						<label><input class="of-input of-radio" type="radio" name="rojo[pagebuilder][separator][separator_radio]" id="rojo-separator_radio-text" value="text">
						Text</label>
					</li>
				</ul>
				<label class="explain" for="separator_radio">Select the content of the separator</label>
			</div>
			<div class="option_container" style="display: none;">
				<h4 class="heading">Separator Text</h4>
				<input id="separator_text" placeholder="" class="of-input" name="rojo[pagebuilder][separator][separator_text]" type="text" value="Welcome to Rojo Template !">
				<label class="explain" for="separator_text">Enter your Separator Text</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Twitter Username</h4>
				<input id="twitter_username" placeholder="" class="of-input" name="rojo[pagebuilder][separator][twitter_username]" type="text" value="creiden">
				<label class="explain" for="twitter_username">Enter your twitter username</label>
			</div>
			<div class="option_container" style="display: none;">
				<h4 class="heading">Button Text</h4>
				<input id="separator_button_text" placeholder="" class="of-input" name="rojo[pagebuilder][separator][separator_button_text]" type="text" value="Purchase Now">
				<label class="explain" for="separator_button_text">Enter the text of the button (Leave Empty to disable showing the button) Works only for custom text case</label>
			</div>
			<div class="option_container" style="display: none;">
				<h4 class="heading">Button Link</h4>
				<input id="separator_button_link" placeholder="" class="of-input" name="rojo[pagebuilder][separator][separator_button_link]" type="text" value="http://www.creiden.com">
				<label class="explain" for="separator_button_link">Enter the URL Destination (works only in case of using custom text not twitter)</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Button Shape</h4>
					<select class="of-input" name="rojo[pagebuilder][separator][sep_button_shape]" id="sep_button_shape" style="">
						<option value="0">Boxed</option><option value="1">Rounded</option><option value="2">Rounded Lite</option>
					</select>
				<label class="explain" for="sep_button_shape">Select the shape of the button, check the documentation to know more.</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Button Size</h4>
					<select class="of-input" name="rojo[pagebuilder][separator][sep_button_size]" id="sep_button_size" style="">
						<option value="0">Large</option><option value="1">Small</option>
					</select>
				<label class="explain" for="sep_button_size">Select the size of the button, check the documentation to know more.</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Button Color</h4>
					<select class="of-input" name="rojo[pagebuilder][separator][sep_button_color]" id="sep_button_color" style="">
						<option value="red">red</option><option value="violet">violet</option><option value="pink">pink</option><option value="yellow">yellow</option><option value="orange">orange</option><option value="grey">grey</option><option value="lightGreen">lightGreen</option><option value="green">green</option><option value="heavyGreen">heavyGreen</option><option value="lightBlue">lightBlue</option><option value="blue">blue</option><option value="heavyBlue">heavyBlue</option>
					</select>
				<label class="explain" for="sep_button_color">Select the size of the button, check the documentation to know more.</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Button Icon</h4>
					<select class="of-input" name="rojo[pagebuilder][separator][sep_button_icon]" id="sep_button_icon" style="">
						<option value="0">no icon</option><option value="add">add</option><option value="add2">add2</option><option value="alert">alert</option><option value="alert2">alert2</option><option value="audio">audio</option><option value="cancel">cancel</option><option value="cancel2">cancel2</option><option value="cancel3">cancel3</option><option value="check">check</option><option value="check2">check2</option><option value="check3">check3</option><option value="download">download</option><option value="droid">droid</option><option value="image">image</option><option value="link">link</option><option value="lock">lock</option><option value="mail">mail</option><option value="movie">movie</option><option value="paperPin">paperPin</option><option value="pin">pin</option><option value="plane">plane</option><option value="redo">redo</option><option value="redo2">redo2</option><option value="settings">settings</option><option value="settings2">settings2</option><option value="smallPin">smallPin</option><option value="smile">smile</option><option value="sub">sub</option><option value="sub2">sub2</option><option value="undo">undo</option><option value="undo2">undo2</option><option value="upload">upload</option><option value="zoom">zoom</option>
					</select>
				<label class="explain" for="sep_button_icon">Select the icon of the button, check the documentation to know more.</label>
			</div>
			<div class="option_container">
				<h4 class="heading">URL opens in a new Tab</h4>
				<div class="checker" id="uniform-button_newtab">
					<span>
						<input id="button_newtab" class="checkbox of-input" type="checkbox" name="rojo[pagebuilder][separator][button_newtab]">
					</span>
				</div><label class="explain" for="button_newtab">Would you like to open the link in a new tab when the button is clicked?</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][separator][width]" value="100">
		</div>
	</li>';

	$tabbed_categories_area =
	'<li class="tabbed_categories_area" style="width: 846px;">
		<div class="widget-head">
			Tabbed Categories <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

			<span class="remove-icon"></span>
		</div>
		<div class="widget-content">
			<div class="option_container">
				<h4 class="heading">Selected Categories</h4>
				<select name="rojo[pagebuilder][tabbed_categories0][tabbed_area_selected_cat][]" id="tabbed_area_selected_cat" multiple="" class="uniform-multiselect">
					'.$categoriesHTML.'
				</select>
				<label class="explain" for="tabbed_area_selected_cat">Select the categories you want (please make sure that the categories you select here are not selected in other Tabbed OR Masonry section)</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Posts View</h4>
				<ul class="radioButtonWrapper">
					<li>
						<label><input class="of-input of-radio" type="radio" name="rojo[pagebuilder][tabbed_categories0][tabbed_cat_radio]" id="rojo-tabbed_cat_radio-list" value="list">
						List View</label>
					</li>
					<li>
						<label><input class="of-input of-radio" type="radio" name="rojo[pagebuilder][tabbed_categories0][tabbed_cat_radio]" id="rojo-tabbed_cat_radio-grid" value="grid">
						Grid View</label>
					</li>
					<li>
						<label><input class="of-input of-radio" type="radio" name="rojo[pagebuilder][tabbed_categories0][tabbed_cat_radio]" id="rojo-tabbed_cat_radio-both" value="both" checked="checked">
						Both View</label>
					</li>
				</ul>
				<label class="explain" for="tabbed_cat_radio">Select how you want to display the posts here</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Number of List Posts</h4>
				<input id="list_posts_number" placeholder="" class="of-input" name="rojo[pagebuilder][tabbed_categories0][list_posts_number]" type="text" value="2">
				<label class="explain" for="list_posts_number">Enter the number of posts to display as List</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Number of Grid Posts</h4>
				<input id="grid_posts_number" placeholder="" class="of-input" name="rojo[pagebuilder][tabbed_categories0][grid_posts_number]" type="text" value="4">
				<label class="explain" for="grid_posts_number">Enter the number of posts to display as Grid (preferred to be even number)</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][tabbed_categories0][width]" value="100">
		</div>
	</li>';

	$selected_categories_area =
	'<li class="selected_categories_area" style="width: 846px;">
		<div class="widget-head">
			Selected Catgeory <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

			<span class="remove-icon"></span>
		</div>
		<div class="widget-content" style="">
			<div class="option_container">
				<h4 class="heading">Posts View</h4>
				<ul class="radioButtonWrapper">
					<li>
						<label>
							<input class="of-input of-radio" type="radio" name="rojo[pagebuilder][selected_category0][selected_category_radio]" id="rojo-selected_category_radio-thumb" value="thumb">
							Thumbnail View
						</label>
					</li>
					<li>
						<label>
							<input class="of-input of-radio" type="radio" name="rojo[pagebuilder][selected_category0][selected_category_radio]" id="rojo-selected_category_radio-grid" value="grid">
							Grid View
						</label>
					</li>
					<li>
						<label>
							<input class="of-input of-radio" type="radio" name="rojo[pagebuilder][selected_category0][selected_category_radio]" id="rojo-selected_category_radio-both" value="both" checked="checked">
							Both View
						</label>
					</li>
				</ul>
				<label class="explain" for="selected_category_radio">Select how you want to display the posts here:</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Number of thumbnail Posts</h4>
				<input id="thumb_posts_number" placeholder="" class="of-input" name="rojo[pagebuilder][selected_category0][thumb_posts_number]" type="text" value="5">
				<label class="explain" for="thumb_posts_number">Enter the number of posts to display as Thumbs</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Number of Grid Posts</h4>
				<input id="grid_posts_number" placeholder="" class="of-input" name="rojo[pagebuilder][selected_category0][grid_posts_number]" type="text" value="6">
				<label class="explain" for="grid_posts_number">Enter the number of posts to display as Grid (preferred to be even number)</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Posts Type</h4>
					<select class="of-input" name="rojo[pagebuilder][selected_category0][selected_category_type]" id="selected_category_type" style="">
						<option value="latest">Latest Posts</option><option value="pop">Popular Posts</option>
					</select>
				<label class="explain" for="selected_category_type">Select which posts you want to display</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Title of selected category area</h4>
				<input id="selected_category_title" placeholder="" class="of-input" name="rojo[pagebuilder][selected_category0][selected_category_title]" type="text" value="Top Category News">
				<label class="explain" for="selected_category_title">Enter the title of selected category area</label>
			</div>
			<div class="option_container" style="">
				<h4 class="heading">Selected Category</h4>
					<select class="of-input" name="rojo[pagebuilder][selected_category0][selected_cat]" id="selected_cat" style="">
						'.$categoriesHTML.'
					</select>
				<label class="explain" for="selected_cat">Select the category you want</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][selected_category0][width]" value="100">
		</div>
	</li>';

	$masonry_layout_builder =
	'<li class="masonry_posts_area" style="width: 846px;">
		<div class="widget-head">
			Masonry Posts <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

			<span class="remove-icon"></span>
		</div>
		<div class="widget-content">
			<div class="option_container">
				<h4 class="heading">Selected Categories</h4>
				<select name="rojo[pagebuilder][masonry_layout][masonry_selected_categories][]" id="masonry_selected_categories" multiple="" class="uniform-multiselect">
					'.$categoriesHTML.'
				</select>
				<label class="explain" for="masonry_selected_categories">Select the categories you want to show in Masonry area</label>
			</div>
			<div class="option_container">
				<h4 class="heading">Number of Posts</h4>
				<input id="masonry_posts_number" placeholder="" class="of-input" name="rojo[pagebuilder][masonry_layout][masonry_posts_number]" type="text" value="10">
				<label class="explain" for="masonry_posts_number">Enter the number of posts to be displayed in Masonry Layout</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][masonry_layout][width]" value="100">
		</div>
	</li>';

	$advertisementArea =
	'<li class="advertisement_area" style="width: 846px;">
	<div class="widget-head">
		Advertisement <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

		<span class="plus-icon" style="display:none;"></span><span class="minus-icon"></span><span class="remove-icon"></span>
	</div>
	<div class="widget-content">
		<div class="option_container">
			<h4 class="heading">Advertisment Type</h4>
			<ul class="radioButtonWrapper">
				<li>
					<label>
						<input class="of-input of-radio" type="radio" name="rojo[pagebuilder][ad2][ad_type]" id="rojo-ad_type-image" value="image" checked="checked">
						Image and Link</label>
				</li>
				<li>
					<label>
						<input class="of-input of-radio" type="radio" name="rojo[pagebuilder][ad2][ad_type]" id="rojo-ad_type-script" value="script">
						Custom</label>
				</li>
			</ul>
			<label class="explain" for="ad_type">Select the type of afvertisment</label>
		</div>
		<div class="option_container" style="display: none;">
			<h4 class="heading">Custom Advertisment script</h4>
			<textarea id="ad_script" class="of-input" name="rojo[pagebuilder][ad2][ad_script]" rows="8"></textarea>
			<label class="explain" for="ad_script">Enter the script here</label>
		</div>
		<div class="option_container" style="display: block;">
			<input id="adv_image_url2" class="upload" type="text" name="rojo[pagebuilder][ad2][adv_image_url]" value="" placeholder="No file chosen">
			<input id="upload-adv_image_url2" class="upload-button button" type="button" value="Upload">
			<div class="screenshot" id="adv_image_url2-image"></div>
			<label class="explain" for="adv_image_url-image">Paste the image URL your prefer here</label>
		</div>
		<div class="option_container" style="display: block;">
			<h4 class="heading">Advertisement Taget URL</h4>
			<input id="adv_target_url" placeholder="" class="of-input" name="rojo[pagebuilder][ad2][adv_target_url]" type="text" value="">
			<label class="explain" for="adv_target_url">Paste the URL that you want the user to be directed to it when the advertisement is clicked. Dont Forget to type HTTP://</label>
		</div>
		<input type="hidden" class="list_width" name="rojo[pagebuilder][ad2][width]" value="100">
	</div>
	</li>';

	$dividerArea =
	'<li class="divider_area" style="width: 846px;">
		<div class="widget-head">
			Divider <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>

			<span class="remove-icon"></span>
		</div>
		<div class="widget-content">
			<div class="option_container">
				<h4 class="heading">Divider Height</h4>
				<input id="divider_height" placeholder="" class="of-input" name="rojo[pagebuilder][divider0][divider_height]" type="text" value="">
				<label class="explain" for="divider_height">Type the divider height in pixels</label>
			</div>
			<input type="hidden" class="list_width" name="rojo[pagebuilder][divider0][width]" value="100">
		</div>
	</li>';
	// Enqueue custom option panel JS
	wp_enqueue_script( 'options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'js/options-custom.js', array( 'jquery','wp-color-picker' ) );
	if(is_admin()){
		wp_enqueue_style( 'options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'css/meta.css');
	}
	wp_localize_script('options-custom', 'creiden_admin',array(
	'carousel_posts_area' => $carousel_posts_area,
	'home_slider' => $home_slider,
	'vertical_posts_area' => $vertical_posts_area,
	'twitter_area' => $twitter_area,
	'tabbed_categories_area' => $tabbed_categories_area,
	'selected_categories_area' => $selected_categories_area,
	'masonary_layout_area' => $masonry_layout_builder,
	'adv_area' => $advertisementArea,
	'divider_area' => $dividerArea,
	'template_directory' => get_template_directory_uri()
	));
}
/*
 * This is an example of how to add custom scripts to the options panel.
* This example shows/hides an option when a checkbox is clicked.
*/

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() {


	?>

<script type="text/javascript">
        jQuery(document).ready(function($) {
			/************************************************/
            $('#blog_count').click(function() {
                $('#section-blog_radio_count').fadeToggle(400);
            });

            if ($('#blog_count:checked').val() !== undefined) {
                $('#section-blog_radio_count').show();
            }
            else{
            	$('#section-blog_radio_count').hide();
            }
           /************************************************/
            $('#tags_count').click(function() {
                $('#section-tags_radio_count').fadeToggle(400);
            });

            if ($('#tags_count:checked').val() !== undefined) {
                $('#section-tags_radio_count').show();
            }
            else{
            	$('#section-tags_radio_count').hide();
            }
           /************************************************/
            $('#category_count').click(function() {
                $('#section-category_radio_count').fadeToggle(400);
            });

            if ($('#category_count:checked').val() !== undefined) {
                $('#section-category_radio_count').show();
            }
            else{
            	$('#section-category_radio_count').hide();
            }
           /************************************************/
            $('#search_count').click(function() {
                $('#section-search_radio_count').fadeToggle(400);
            });

            if ($('#search_count:checked').val() !== undefined) {
                $('#section-search_radio_count').show();
            }
            else{
            	$('#section-search_radio_count').hide();
            }
            /************************************************/
            $('#breaking_area').click(function() {
            	$('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').fadeToggle(400);
            });
            if ($('#breaking_area:checked').val() !== undefined) {
               $('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').show();
            }
            else{
            	$('#section-breaking_title, #section-breaking_content, #section-number_breaking_posts, #section-breaking_selected_category, #section-custome_breaking').hide();
            }
           /************************************************/
            $('#seo_enabled').click(function() {
            	$('#section-meta_description, #section-meta_keys').fadeToggle(400);
            });
            if ($('#seo_enabled:checked').val() !== undefined) {
               $('#section-meta_description, #section-meta_keys').show();
            }
            else{
            	$('#section-meta_description, #section-meta_keys').hide();
            }
           /************************************************/
			if ($('#rojo-separator_radio-text').is(':checked')){
				$('#separator_text, #separator_button_text, #separator_button_link').parent().show();
				$('#twitter_username').parent().hide();
			}
			else if($('#rojo-separator_radio-twitter').is(':checked')){
				$('#separator_text, #separator_button_text, #separator_button_link').parent().hide();
				$('#twitter_username').parent().show();
			}

			$('#section-pagebuilder').on('click', '#rojo-separator_radio-twitter', function(){
				$('#separator_text, #separator_button_text, #separator_button_link').parent().hide();
				$('#twitter_username').parent().show();
			})
			$('#section-pagebuilder').on('click', '#rojo-separator_radio-text', function(){
				$('#separator_text, #separator_button_text, #separator_button_link').parent().show();
				$('#twitter_username').parent().hide();
			})
			/************************************************/
			$('.advertisement_area').each(function(){
				if($(this).find('#rojo-ad_type-image').attr('checked') == 'checked'){
					$(this).find('#ad_script').parent().hide();
					$(this).find('.remove-file').parent().show();
					$(this).find('.upload-button').parent().show();
					$(this).find('#adv_target_url').parent().show();
				}
				else if($(this).find('#rojo-ad_type-script').attr('checked') == 'checked'){
					$(this).find('#ad_script').parent().show();
					$(this).find('.remove-file').parent().hide();
					$(this).find('.upload-button').parent().hide();
					$(this).find('#adv_target_url').parent().hide();
				}
			});
			$('#section-pagebuilder').on('click', '#rojo-ad_type-image', function(){
				$(this).parents('.widget-content').find('#ad_script').parent().hide();
				$(this).parents('.widget-content').find('.remove-file').parent().show();
				$(this).parents('.widget-content').find('.upload-button').parent().show();
				$(this).parents('.widget-content').find('#adv_target_url').parent().show();
			})
			$('#section-pagebuilder').on('click', '#rojo-ad_type-script', function(){
				$(this).parents('.widget-content').find('#ad_script').parent().show();
				$(this).parents('.widget-content').find('.remove-file').parent().hide();
				$(this).parents('.widget-content').find('.upload-button').parent().hide();
				$(this).parents('.widget-content').find('#adv_target_url').parent().hide();
			})
			/************************************************/
			if ($('#rojo-post_sidebars_option-meta').is(':checked')){
				$('#section-post_sidebar, #section-post_layout').hide();
			}
			else if($('#rojo-post_sidebars_option-global').is(':checked')){
				$('#section-post_sidebar, #section-post_layout').show();
			}

			$('.postpage').on('click', '#rojo-post_sidebars_option-meta', function(){
				$('#section-post_sidebar, #section-post_layout').fadeToggle(400);
			})
			$('.postpage').on('click', '#rojo-post_sidebars_option-global', function(){
				$('#section-post_sidebar, #section-post_layout').fadeToggle(400);
			})
        });
    </script>
<?php
}