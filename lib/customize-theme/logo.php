<?php
	
	/*
	*	CUSTOMIZE THEME OPTIONS
	*	UPLOAD LOGO
	*	OPTION TO USE ORIGINAL LOGO SIZE
	*	LOCATION OF THE LOGO										(MIGHT GET REMOVED)
	*	TYPE OF HEADER - DEFINES THE NAVIGATION MENU TYPE
	*	OPTION TO STRETCH HEADER 									(MIGHT GET REMOVED)
	*/
	
	add_action( 'customize_register', function($wp_customize){
		
		global $akvo_customize;
		
		$section = 'akvo_logo_section';
		
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', $section, 'Logo & Header Type', 'Upload your logo');
		
		
		/** LOGO IMAGE */ 
		$wp_customize->add_setting( 'akvo_logo' );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'akvo_logo', array(
	    	'label'    => __( 'Logo', 'sage' ),
	    	'section'  => $section,
	   		'settings' => 'akvo_logo',
		) ) );

		/** LOGO SIZE */ 
      	$wp_customize->add_setting( 'akvo_logo_size' );
		
		$wp_customize->add_control('akvo_logo_size', array(
      		'settings' => 'akvo_logo_size',
      		'label'    => __('Use Original Logo Size'),
      		'section'  => $section,
      		'type'     => 'checkbox',
      		'std' => 1
      	));
      	
      	/** LOGO LOCATION */ 
      	$logo_location_arr = array(
      		'left'	=> 'Left',
      		'right'	=> 'Right'
      	);
      	$akvo_customize->dropdown( $wp_customize, $section, 'akvo_logo_location', 'Logo Location', 'left', $logo_location_arr);
      	
      	
      	
      	/** HEADER TYPE */
      	$headers_arr = array(
			'header1' => 'Default',
			'header2' => 'Sticky',
			'header3' => 'Narrow Single Row',
			'header4' => 'Dark Sticky Menu',
			'header5' => 'Sticky Solid Logo & Menu'	
	    );
    	$akvo_customize->dropdown( $wp_customize, $section, 'sage_header_options[header_type]', 'Header Type', 'header1', $headers_arr);
		
		/* STRECTH HEADER OPTION */
		$akvo_customize->checkbox( $wp_customize, $section, 'sage_header_options[header_stretch]', 'Stretch Header' );
    	
      	
	} );
	
	
	add_action( 'akvo_sites_css', function(){
		
		$header_option = get_option('sage_header_options');
		
		/* FOR STICKY HEADER */
		if($header_option && isset($header_option['header_type']) && 'header2' == $header_option['header_type']){
			
			$options = array(
				'zero'	=> '0px',
				'height'=> '600px'
			);
			
			$items = array(
				array(
					'selector'	=> '.banner',
					'styles'	=> array(
						'margin-bottom'	=> 'zero'
					)
				),
				array(
					'selector'	=> '#main-page-container',
					'styles'	=> array(
						'margin-top'	=> 'zero'
					)
				)
			);
			
			global $akvo;
			
			$akvo->print_css( $options, $items );
			
			$sm_items = array(
				array(
					'selector'	=> '#main-page-container',
					'styles'	=> array(
						'min-height'	=> 'height'
					)
				)
			);
			
			$akvo->print_css( $options, $sm_items, '@media(min-width: 960px)' );
			
				
			
		}
		
		
		
	});
