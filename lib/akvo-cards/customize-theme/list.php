<?php
	
	add_action( 'customize_register', function( $wp_customize ){
		
		global $akvo_customize;
		
		$panel = 'akvo_list_panel';
		
		
		
		$akvo_customize->panel( $wp_customize, $panel, 'Akvo List Widget' );

		
		/* GENERAL THEME SECTION */
		
		$akvo_customize->section( $wp_customize, $panel, 'akvo_list_section', 'General Theme', 'Customize background and foreground color for list widget');
		
		$colors = array(
			'akvo[list][bg]' 			=> array(
				'default' 				=> '#EEEEEE',
				'label'					=> 'Background'
			),
			'akvo[list][title_color]' 	=> array(
				'default' 				=> '#333333',
				'label'					=> 'Title Color'
			),
			'akvo[list][content_color]' 	=> array(
				'default' 				=> '#333333',
				'label'					=> 'Content Color'
			),
			'akvo[list][border_color]' 	=> array(
				'default' 				=> '#CCCCCC',
				'label'					=> 'Border Color'
			),
			'akvo[list][badge_bg]' 		=> array(
				'default' 				=> '#CCCCCC',
				'label'					=> 'Background of Badge'
			),
			'akvo[list][badge_color]' 	=> array(
				'default' 				=> '#FFF',
				'label'					=> 'Color of Badge'
			),
		);
		
		foreach( $colors as $color_id => $color ){
			$akvo_customize->color( $wp_customize, 'akvo_list_section', $color_id, $color['label'], $color['default'] );
		}
		
		/* END OF THEME SECTION */
		
		/* FONT SIZES */
		$akvo_customize->section( $wp_customize, $panel, 'akvo_list_font_section', 'Font Sizes', 'Customize font sizes for list widget');
		
		$text_el = array(
			'akvo[list][title_font_size]' => array(
				'default' 	=> '24px',
				'label' 	=> 'Font size of title:',
			),
			'akvo[list][content_font_size]' => array(
				'default' 	=> '14px',
				'label' 	=> 'Font size of content:',
			),
			'akvo[list][meta_font_size]' => array(
				'default' 	=> '10px',
				'label' 	=> 'Font size of meta:',
			),	
		);
		
		foreach( $text_el as $id => $el){
			$akvo_customize->text( $wp_customize, 'akvo_list_font_section', $id, $el['label'], $el['default']);	
		}
		/* END OF FONT SIZES */
		
		/* EXTRAS */
		$akvo_customize->section( $wp_customize, $panel, 'akvo_list_extras_section', 'Extras', '');
		
		$text_el = array(
			'akvo[list][margin_bottom]' => array(
				'default' 	=> '0px',
				'label' 	=> 'Margin Bottom:',
			),
			'akvo[list][border_radius]' => array(
				'default' 	=> '0px',
				'label' 	=> 'Border radius of list:',
			),
			'akvo[list][padding]' => array(
				'default' 	=> '20px',
				'label' 	=> 'Padding of list:',
			),
			'akvo[list][border_radius_badge]' => array(
				'default' 	=> '10px',
				'label' 	=> 'Border radius of badge:',
			),			
		);
		
		foreach( $text_el as $id => $el){
			$akvo_customize->text( $wp_customize, 'akvo_list_extras_section', $id, $el['label'], $el['default']);	
		}
		
		/* EXTRAS */
		
		
	} );

	
	/** ADD CUSTOMISE CSS */
	add_action( 'akvo_sites_css', function(){
		
		global $akvo;
		$akvo_options = $akvo->get_option();
		
		if( isset( $akvo_options['list'] ) ){
			
			$akvo_list = $akvo_options['list'];
			
			$items = array(
				array(
					'selector'	=> '.list-widget',
					'styles'	=> array(
						'background'	=> 'bg',
						'border-radius'	=> 'border_radius',
						'color'			=> 'content_color',
						'border-color'	=> 'border_color',
						'font-size'		=> 'content_font_size',
						'margin-bottom'	=> 'margin_bottom',
						'padding'		=> 'padding'
					)
				),
				array(
					'selector'	=> '.list-widget .small',
					'styles'	=> array(
						'font-size'		=> 'meta_font_size'
					)
				),
				array(
					'selector'	=> '.list-widget .badge',
					'styles'	=> array(
						'background'	=> 'badge_bg',
						'color'			=> 'badge_color',
						'border-radius'	=> 'border_radius_badge'
					)
				),
				array(
					'selector'	=> '.list-widget .list-title a[href]',
					'styles'	=> array(
						'color'			=> 'title_color',
						'font-size'		=> 'title_font_size'
					)
				),
			);
			
			
			$akvo->print_css( $akvo_list, $items );
			
		}
		
	});

