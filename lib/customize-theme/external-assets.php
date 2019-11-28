<?php
	
	/* EXTERNAL ASSETS SECTION */
	add_action( 'customize_register', function($wp_customize){
	
		global $akvo_customize;
		
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_assets_section', 'External Assets', 'Load external scripts and styles');
		
		$text_el = array(
			'akvo_assets[header]' => array(	/* HEADER SECTION */
				'default' 	=> '',
				'label' 	=> 'Header Section',
			),
			'akvo_assets[footer]' => array(	/* FOOTER SECTION */
				'default' 	=> '',
				'label' 	=> 'Footer Section',
			),
		);
		
		foreach( $text_el as $id => $el ){
			$akvo_customize->textarea( $wp_customize, 'akvo_assets_section', $id, $el['label'], $el['default']);
		}
	
	} );
	
	
	add_action('wp_head', function(){
		
		$assets = get_option('akvo_assets');
		if(isset($assets['header'])){ echo $assets['header']; }
		
	});
	
	add_action('wp_footer', function(){
		
		$assets = get_option('akvo_assets');
		if(isset($assets['footer'])){ echo $assets['footer']; }
		
	});