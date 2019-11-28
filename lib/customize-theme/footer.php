<?php

	add_action( 'customize_register', function($wp_customize){
		
		global $akvo_customize;
		
		/* All our sections, settings, and controls will be added here */
   		
		$section = 'akvo_footer';
		
   		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', $section, 'Footer', '');
		
		$colors = array(
			'akvo[footer][cols_bg]'		=> array(
				'default'		=> '#ffffff',
				'label'			=> 'Background for Footer Columns'
			),
			'akvo[footer][cols_color]'	=> array(
				'default'		=> '#000000',
				'label'			=> 'Color for Footer Columns'
			),
			'akvo[footer][fixed_bg]'		=> array(
				'default'		=> '#004d48',
				'label'			=> 'Background for Copyright'
			),
			'akvo[footer][fixed_color]'	=> array(
				'default'		=> '#BBBBBB',
				'label'			=> 'Color for Copyright'
			),
		);
		
		foreach( $colors as $color_id => $color ){
			$akvo_customize->color( $wp_customize, $section, $color_id, $color['label'], $color['default'] );
		}
		
		/** NUMBER OF COLUMNS */
      	$cols_num_arr = array(
			'1' => '1',
			'2' => '2',
			'3' => '3'
	    );
    	$akvo_customize->dropdown( $wp_customize, $section, 'akvo[footer][cols_num]', 'Number of columns', '3', $cols_num_arr );
		
	} );




	add_action( 'akvo_sites_css', function(){
		
		global $akvo;
		$akvo_options = $akvo->get_option();
		
		if( isset( $akvo_options['footer'] ) ){
			
			$items = array(
				array(
					'selector'	=> 'footer .twitter',
					'styles'	=> array(
						'background'	=> 'cols_bg',
						'color'			=> 'cols_color',
					)
				),
				array(
					'selector'	=> 'footer .fixed',
					'styles'	=> array(
						'background'	=> 'fixed_bg',
						'color'			=> 'fixed_color',
					)
				),
			);
			
			
			$akvo->print_css( $akvo_options['footer'], $items );
			
		}
		
		
	});
