<?php
	
	add_action('customize_register', function($wp_customize){
		
		global $akvo_customize;
		
		$section = 'akvo_search_section';
		
		// ADD NEW SECTION
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', $section, 'Search Options', '');
		
		// OPTION TO HIDE SEARCH BAR
		$akvo_customize->checkbox( $wp_customize, $section, 'sage_header_options[hide_search]', 'Hide Search Bar' );
		
		// OPTION TO CHANGE PLACEHOLDER TEXT
		$akvo_customize->text( $wp_customize, $section, 'sage_header_options[search_text]', 'Text for Search Placeholder:', 'Search ' . get_bloginfo('name'));	
		   
		/** HEADER TYPE */
      	$search_style_arr = array(
			'default' 	=> 'Default',
			'icon-only' => 'Icon Only',
		);
    	$akvo_customize->dropdown( $wp_customize, $section, 'sage_header_options[search_style]', 'Search Style', 'default', $search_style_arr );	
		
      	
    }, 40);
	
	

  
  