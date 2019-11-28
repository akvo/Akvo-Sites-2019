<?php
	
	/* EVENTS SECTION */
	
	add_action( 'customize_register', function($wp_customize){
		
		global $akvo_customize;
		
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_events_section', 'Events', 'Customize templates for events');
		
		/** TEXT ELEMENTS */
		$text_el = array(
			'akvo_events[title_font_size]'	=> array(
				'default' => '16px',
				'label'    => 'Title: Font size'
			),
			'akvo_events[btn_text]'	=> array(
				'default' => 'View All Events',
				'label'   => 'Button Text',	
			),
			'akvo_events[btn_font_size]' => array(
				'default' => '14px',
				'label'   => 'Button: Font size',
			),
			'akvo_events[meet_text]' => array(
				'default' => 'Meet:',
				'label'   => 'Text for event partners',
			),
		);
		
		foreach( $text_el as $id => $el ){
			$akvo_customize->text( $wp_customize, 'akvo_events_section', $id, $el['label'], $el['default']);
		}
		
		
		$colors = array(
			'akvo_events[title_color]'	=> array(
				'default'	=> '#000000',
				'label'		=> 'Color of Title:'
			),
			'akvo_events[btn_bg_color]'	=> array(
				'default' 	=> '#000000',
				'label'		=> 'Button: BG Color',
			),
			'akvo_events[btn_color]'	=> array(
				'default' 	=> '#000000',
				'label' 	=> 'Button: Color',
			)
		);
		
		foreach( $colors as $color_id => $color ){
			$akvo_customize->color( $wp_customize, 'akvo_events_section', $color_id, $color['label'], $color['default'] );
		}
		
		
		
		
		
	} );
	
	
	add_action( 'akvo_sites_css', function(){
		
		$akvo_events = get_option('akvo_events');
		
		$items = array(
			array(
				'selector'	=> '.tribe-events-list-widget h3.widget-title',
				array(
					'font-size'	=> 'title_font_size',
					'color'		=> 'title_color'
				)
			),
			array(
				'selector'	=> '.tribe-events-list-widget .btn.btn-default',
				array(
					'font-size'			=> 'btn_font_size',
					'background-color'	=> 'btn_bg_color',
					'color'				=> 'btn_color'
				)
			)
		);
		
		global $akvo;
		$akvo->print_css( $akvo_events, $items );
		
	});
	
