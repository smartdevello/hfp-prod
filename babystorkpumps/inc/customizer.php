<?php

add_action('customize_register', function ( $wp_customize ) {
    
    $wp_customize->add_section( 'sendinblue' , array(
        'title'      => 'Sendinblue',
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'sendinblue_api_key' );

    $wp_customize->add_control( 'sendinblue_api_key',
        array(
            'label' => 'Sendinblue API v3 Key',
            'description' => 'Get your api key from <a href="https://account.sendinblue.com/advanced/api">here</a>',
            'section' => 'sendinblue',
            'settings' => 'sendinblue_api_key',
        ) );
    
} );
