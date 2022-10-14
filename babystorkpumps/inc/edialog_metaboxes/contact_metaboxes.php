<?php

function edialoug_contact_metaboxes( ){
    $prefix       = 'contact_';
    $meta_boxes = array(
             'id'         => 'contact',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'contact Fields', 'your-prefix' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'post', 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		'fields' => array(
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Text', 'your-prefix' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}text",
				// Field description (optional)
				'desc'  => esc_html__( 'Text description', 'your-prefix' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => esc_html__( 'Default text value', 'your-prefix' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => true,
			),
			// CHECKBOX
			array(
				'name' => esc_html__( 'Checkbox', 'your-prefix' ),
				'id'   => "{$prefix}checkbox",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),
			// RADIO BUTTONS
			array(
				'name'    => esc_html__( 'Radio', 'your-prefix' ),
				'id'      => "{$prefix}radio",
				'type'    => 'radio',
				// Array of 'value' => 'Label' pairs for radio options.
				// Note: the 'value' is stored in meta field, not the 'Label'
				'options' => array(
					'value1' => esc_html__( 'Label1', 'your-prefix' ),
					'value2' => esc_html__( 'Label2', 'your-prefix' ),
				),
			),
			// SELECT BOX
			array(
				'name'        => esc_html__( 'Select', 'your-prefix' ),
				'id'          => "{$prefix}select",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'value1' => esc_html__( 'Label1', 'your-prefix' ),
					'value2' => esc_html__( 'Label2', 'your-prefix' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'value2',
				'placeholder' => esc_html__( 'Select an Item', 'your-prefix' ),
			),
			// HIDDEN
			array(
				'id'   => "{$prefix}hidden",
				'type' => 'hidden',
				// Hidden field must have predefined value
				'std'  => esc_html__( 'Hidden value', 'your-prefix' ),
			),
			// PASSWORD
			array(
				'name' => esc_html__( 'Password', 'your-prefix' ),
				'id'   => "{$prefix}password",
				'type' => 'password',
			),
		),
           'creiden_autohrize_only_on' => array( 'template' => array( 'page_contact.php' ) )
    );

    return $meta_boxes;
}
