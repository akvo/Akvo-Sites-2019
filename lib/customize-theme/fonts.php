<?php
	
	/*
	* PROVISION TO ADD GOOGLE FONTS THAT ARE NOT THERE IN THE LIST
	* ONCE ADDED THROUGH THESE FIELDS, THEY WILL BE AVAILABLE IN /lib/akvo/class-akvo-fonts.php 
	*/
	
	
	/* CUSTOM FONTS */
	add_action( 'customize_register', function($wp_customize){
	
		// Fonts
		global $akvo_customize;
		
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_fonts_section', 'Google Fonts', 'Additional google fonts (max of 3)');
		
		for( $i = 1; $i <= 3; $i++ ){
			$akvo_customize->text( $wp_customize, 'akvo_fonts_section', 'akvo_fonts[font'.$i.'][url]', 'URL for font '.$i, '');
		}
		
        /* END OF FONTS SECTION */
	
	} );
	
	add_filter( 'akvo_fonts', function( $fonts ){
		
		$akvo_fonts = get_option('akvo_fonts');
		
		if( is_array( $akvo_fonts ) ){
			foreach( $akvo_fonts as $font ){
				
				/* EXTRACT LABEL FROM URL */
				$parts = explode('family=', $font['url']);
				if( count( $parts ) > 1 ){
					$font['label'] = str_replace('+', ' ', $parts[1]);
				}
				
				if( isset( $font['label'] ) && isset( $font['url'] ) ){
				
					$fonts[] = array(
						'slug'	=> sanitize_title( $font['label'] ),
						'name'	=> $font['label'],
						'url'	=> $font['url']
					);
				}
					
			}
		}
		
		return $fonts;
		
	});
	