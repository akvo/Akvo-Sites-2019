<?php

	add_action('customize_register',  function( $wp_customize ){

		global $akvo_customize;

		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_carousel_section', 'Carousel', '');

		/** COLORS */
		$colors = array(
			'sage_carousel_options[bg_carousel]' => array(
				'default' 	=> '',
				'label' 	=> 'Background Carousel',
			),
			'sage_carousel_options[color_title_carousel]' => array(
				'default' 	=> '',
				'label' 	=> 'Color Title Carousel',
			),
			'sage_carousel_options[color_content_carousel]' => array(
				'default' 	=> '',
				'label' 	=> 'Color Content Carousel',
			)
		);

		foreach( $colors as $id => $color ){
			$akvo_customize->color( $wp_customize, 'akvo_carousel_section', $id, $color['label'], $color['default'] );
		}
		/** END OF COLORS */

		/* CAROUSEL INTERVAL */
		$akvo_customize->text( $wp_customize, 'akvo_carousel_section', 'sage_carousel_options[interval]', 'Carousel Interval:', '3000');


	}, 40);


  add_action( 'akvo_sites_css', function(){

  	$carousel_option = get_option('sage_carousel_options');

		$items = array(
			array(
				'selector'	=> '.carousel .text',
				'styles'	=> array(
					'background'	=> 'bg_carousel',
					'color'			=> 'color_content_carousel'
				)
			),
			array(
				'selector'	=> '.carousel .text h1',
				'styles'	=> array(
					'color'			=> 'color_title_carousel'
				)
			)
		);

		global $akvo;
		$akvo->print_css( $carousel_option, $items );

	} );
