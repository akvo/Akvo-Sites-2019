<?php
	
	add_action('customize_register', function($wp_customize){
		
		global $akvo_customize;
		
		$section = 'sage_header_scheme';
		
		/* MAIN MENU */
		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', $section, 'Main Menu', '');
		
		
		
		$colors = array(
			'sage_header_options[bg_menu]' => array(
				'default'	=> '#ffffff',
				'label'		=> 'Background Item Menu'
			),
			'sage_header_options[color_menu]' => array(
				'default'	=> '#000000',
				'label' 	=> 'Color Item Menu',	
			),
			'sage_header_options[bg_parent_menu]' => array(
				'default'	=> '#000000',
				'label' 	=> 'Background Active Item Menu Parent',	
			),
			'sage_header_options[color_parent_menu]' => array(
				'default'	=> '#ffffff',
				'label' 	=> 'Color Active Item Menu Parent',	
			),
			'sage_header_options[bg_child_menu]' => array(
				'default'	=> '#000000',
				'label' 	=> 'Background Active Item Menu Children',
			),
			'sage_header_options[color_child_menu]' => array(
				'default'	=> '#ffffff',
				'label' 	=> 'Color Active Item Menu Children',
			),
		);
		
		foreach( $colors as $id => $color ){
			$akvo_customize->color( $wp_customize, $section, $id, $color['label'], $color['default'] );
		}
		
		$akvo_customize->text( $wp_customize, $section, 'sage_header_options[menu_font_size]', 'Font Size', '14px' );
		
	}, 40);
	
	
	add_action( 'akvo_sites_css', function(){
		
		$header_option = get_option('sage_header_options');
		
		//print_r( $header_option );
		
		$menus = array(
			array(
				'selector'	=> '#menu-main-nav .menu-item .current-menu-item a, #menu-main-nav .menu-item .menu-item a:hover',
				'styles'	=> array(
					'background'	=> 'bg_child_menu',
					'color'			=> 'color_child_menu'
				)
			),
			array(
				'selector'	=> 'ul.navbar-nav li a, #header5-modal .navbar-nav a',
				'styles'	=> array(
					'background'	=> 'bg_menu',
					'color'			=> 'color_menu',
					'font-size'		=> 'menu_font_size',
				)
			),
			array(
				'selector'	=> 'nav ul.navbar-nav li:hover a,nav ul.navbar-nav li a:focus,nav ul.navbar-nav li.current-menu-item a',
				'styles'	=> array(
					'background'	=> 'bg_parent_menu',
					'color'			=> 'color_parent_menu'
				)
			),
		);
		
		global $akvo;
		$akvo->print_css( $header_option, $menus );
		
		/* SMALL SCREEN CSS SELECTORS */
		$sm_items = array(
			array(
				'selector'	=> 'nav ul.navbar-nav .dropdown-menu li a:hover, nav ul.navbar-nav .dropdown-menu li.current-menu-item a',
				'styles'	=> array(
					'background'	=> 'bg_parent_menu',
					'color'			=> 'color_parent_menu'
				)
			),
			
		);
		
		$akvo->print_css( $header_option, $sm_items, '@media (min-width: 768px)' );
		
	} );
	

  
  