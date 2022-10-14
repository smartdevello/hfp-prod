<?php

/**
 * variables home
 * 
 * getting image                       wp_get_attachment_image_src( 20, 'thumbnail' ) ;
 * getting meta by it's id          get_post_meta( $post_id, 'home_sec_1_status', true );
 * 
 *
 * ///////////////** section 1 ** ////////////////
 * section 1
 *      home_section_1_status
 *      home_section_1_background
 * 
 * text 1
 *      home_section_1_text_1
 *      home_section_1_text_1_text
 *      home_section_1_text_1_font
 *      home_section_1_text_1_color
 *
 * text 2
 *      home_section_1_text_2
 *      home_section_1_text_2_text
 *      home_section_1_text_2_font
 *      home_section_1_text_2_color
 * 
 * textarea 1
 *      home_section_1_textarea_1
 *      home_section_1_textarea_1_paragraph
 *      home_section_1_textarea_1_font
 *      home_section_1_textarea_1_color
 * 
 * button 1
 *     home_section_1_button_1
 *     home_section_1_button_1_script
 *     home_section_1_button_1_text
 *     home_section_1_button_1_font
 *     home_section_1_button_1_color
 * 
 * text 3
 *     home_section_1_text_3
 *     home_section_1_text_3_text
 *     home_section_1_text_3_font
 *     home_section_1_text_3_color
 * 
 *  ///////////////** section 2 ** ////////////////
 *      home_sec_2_background
 *      home_sec_2_status
 * 
 * text 1
 *      home_section_2_text_1_text
 *      home_section_2_text_1_font
 *      home_section_2_text_1_color
 * 
 * textarea 1
 *      home_section_2_textarea_1_text
 *      home_section_2_textarea_1_font
 *      home_section_2_textarea_1_color
 * 
 * text 2
 *      home_section_2_text_2_text
 *      home_section_2_text_2_font
 *      home_section_2_text_2_color
 * 
 * phone 1
 *      home_section_2_phone_1_text
 *      home_section_2_phone_1_font
 *      home_section_2_phone_1_color
 * 
 * button 1
 *      home_section_2_button_1_script
 * 
 * text 3
 *      home_section_2_text_3_text
 *      home_section_2_text_3_font
 *      home_section_2_text_3_color
 * 
 *  ///////////////** section 3 ** ////////////////
 *      home_sec_3_status
 *      home_sec_3_bg_color
 * 
 * text 1
 *      home_section_3_text_1_text
 *      home_section_3_text_1_font
 *      home_section_3_text_1_color
 * 
 * text 1
 *      home_section_3_text_2_text
 *      home_section_3_text_2_font
 *      home_section_3_text_2_color
 * 
 * button 1
 *      home_section_3_button_1_script
 * 
 */

function edialoug_home_metaboxes( ){
                    $prefix = "home_" ;
                    $meta_boxes = array(
                                            'id'         => 'home_f_s_metabox',
		// Meta box title - home_f_s_metabox abbreviation for home first meta box 
		'title'      => esc_html__( 'Home Fields', 'edialoug_meta_translation' ),
		// Post types, we only need page 
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		'fields' => array(
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                 //section one start
                                                                 // add dvider here 
                                                                  array(
				'id'	 => $prefix."section_1_divider",
				'name'	 => esc_html__( 'Section One Start', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			// show or hide section 1
                                                                array(
				'id'				 => $prefix."section_1_status",
				'name'				 =>  esc_html__( 'Show or hide this section', 'edialoug_meta_translation' ),
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),
                                                                array(
				'id'				 => $prefix."section_1_background",
				'name'				 => "Background Image",
				'type'				 => "image_advanced",
				'max_file_uploads'	 => '1'
			),
                                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first text 
                                                                array(
				'id'	 => $prefix."section_1_text_1",
				'name'	 => esc_html__( 'First Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_1_text_1_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_1_text_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ),
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_1_text_1_color",
				'type' => 'color',
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // second text 
                                                                array(
				'id'	 => $prefix."section_1_text_2",
				'name'	 => esc_html__( 'Second Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_1_text_2_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_1_text_2_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_1_text_2_color",
				'type' => 'color',
			),
                                                                
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first text area 
			 array(
				'id'	 => $prefix."section_1_textarea_1",
				'name'	 => esc_html__( 'Third Paragraph', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			array(
				'id'	 => $prefix."section_1_textarea_1_paragraph",
				'name'	 => esc_html__( 'Enter paragraph here', 'edialoug_meta_translation' ),
				'type'	 => 'textarea',
                                                                                    'placeholder' => 'Enter paragraph here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_1_textarea_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_1_textarea_1_color",
				'type' => 'color',
			),
                    
                    
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first button
			 array(
				'id'	 => $prefix."section_1_button_1",
				'name'	 => esc_html__( 'Button Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_1_button_1_text",
				'name'	 => esc_html__( 'Enter Button text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter Button text here'
			),
                                                                array(
				'id'	 => $prefix."section_1_button_1_script",
				'name'	 => esc_html__( 'Enter button script here', 'edialoug_meta_translation' ),
				'type'	 => 'textarea',
                                                                                    'placeholder' => 'Enter button text here'
			),
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_1_button_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_1_button_1_color",
				'type' => 'color',
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // third text 
                                                                array(
				'id'	 => $prefix."section_1_text_3",
				'name'	 => esc_html__( 'Fourth Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_1_text_3_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_1_text_3_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_1_text_3_color",
				'type' => 'color',
			),
                                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                 //section two start
                                                                 // add dvider here 
                                                                  array(
				'id'	 => $prefix."section_2_divider",
				'name'	 => esc_html__( 'Section Two Options Start', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
                                                                  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // show or hide section 2
                                                                array(
				'id'				 => $prefix."sec_2_status",
				'name'				 =>  esc_html__( 'Show or hide this section', 'edialoug_meta_translation' ),
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),
                                                                array(
				'id'				 => $prefix."sec_2_background",
				'name'				 => "Background Image",
				'type'				 => "image_advanced",
				'max_file_uploads'	 => '1'
			),
                                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first text 
                                                                array(
				'id'	 => $prefix."section_2_text_1",
				'name'	 => esc_html__( 'First Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_2_text_1_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_2_text_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ),
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_2_text_1_color",
				'type' => 'color',
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first textarea
                                                                array(
				'id'	 => $prefix."section_2_textarea_1",
				'name'	 => esc_html__( 'Second Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_2_textarea_1_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'textarea',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_2_textarea_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_2_textarea_1_color",
				'type' => 'color',
			),
                                                                
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // second text 
			 array(
				'id'	 => $prefix."section_2_text_2",
				'name'	 => esc_html__( 'Third text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			array(
				'id'	 => $prefix."section_2_text_2_text",
				'name'	 => esc_html__( 'Enter text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_2_text_2_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_2_text_2_color",
				'type' => 'color',
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first phone 
                                                                array(
				'id'	 => $prefix."section_2_phone_1",
				'name'	 => esc_html__( 'First Phone', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_2_phone_1_text",
				'name'	 => esc_html__( 'Enter phone here', 'edialoug_meta_translation' ),
				'type'	 => 'number',
                                                                                    'placeholder' => 'Enter phone here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_2_phone_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ),
                                                                array(
				'name' => esc_html__( 'Choose phone Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_2_phone_1_color",
				'type' => 'color',
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first button
			 array(
				'id'	 => $prefix."section_2_button_1",
				'name'	 => esc_html__( 'Button Script', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
                                                                array(
				'id'	 => $prefix."section_2_button_1_script",
				'name'	 => esc_html__( 'Enter button script here', 'edialoug_meta_translation' ),
				'type'	 => 'textarea',
                                                                                    'placeholder' => 'Enter button text here'
			),
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // third text 
                                                                array(
				'id'	 => $prefix."section_2_text_3",
				'name'	 => esc_html__( 'Fourth Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_2_text_3_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_2_text_3_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_2_text_3_color",
				'type' => 'color',
			),
                                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                 //section Three start
                                                                 // add dvider here 
                                                                  array(
				'id'	 => $prefix."section_3_divider",
				'name'	 => esc_html__( 'Section Three Options Start', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
                                                                  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // show or hide section 2
                                                                array(
				'id'				 => $prefix."sec_3_status",
				'name'				 =>  esc_html__( 'Show or hide this section', 'edialoug_meta_translation' ),
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),
                                                                array(
				'name' => esc_html__( 'Choose background Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."sec_3_bg_color",
				'type' => 'color',
			),
                                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first text 
                                                                array(
				'id'	 => $prefix."section_3_text_1",
				'name'	 => esc_html__( 'First Text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			
			array(
				'id'	 => $prefix."section_3_text_1_text",
				'name'	 => esc_html__( 'Enter Text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_3_text_1_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ),
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_3_text_1_color",
				'type' => 'color',
			),
                                                               
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // second text 
			 array(
				'id'	 => $prefix."section_3_text_2",
				'name'	 => esc_html__( 'Second text', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
			array(
				'id'	 => $prefix."section_3_text_2_text",
				'name'	 => esc_html__( 'Enter text here', 'edialoug_meta_translation' ),
				'type'	 => 'text',
                                                                                    'placeholder' => 'Enter text here'
			),
                                                                //SELECT BOX
			array(
				'name'        => esc_html__( 'Choose Font Family', 'edialoug_meta_translation' ),
				'id'          => $prefix."section_3_text_2_font",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => get_external_google_fonts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'default',
				'placeholder' => esc_html__( 'default',  'edialoug_meta_translation' ),
                                                                ) ,
                                                                array(
				'name' => esc_html__( 'Choose Text Color', 'edialoug_meta_translation' ),
				'id'   => $prefix."section_3_text_2_color",
				'type' => 'color',
			),
                                                               
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                // first button
			 array(
				'id'	 => $prefix."section_3_button_1",
				'name'	 => esc_html__( 'Button Script', 'edialoug_meta_translation' ),
				'type'	 => 'heading'
			),
                                                                array(
				'id'	 => $prefix."section_3_button_1_script",
				'name'	 => esc_html__( 'Enter button script here', 'edialoug_meta_translation' ),
				'type'	 => 'textarea',
                                                                                    'placeholder' => 'Enter button script here'
			),
			
                                                                
		),
                                            'creiden_autohrize_only_on' => array( 'template' => array( 'page_home.php' ) ),
	);
                    
    return $meta_boxes;
}
