<?php

	class AKVO_FONTS{

		function __construct(){

			add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts' ), 100 );

			add_action( 'customize_register', array( $this, 'customize_register' ) );

			add_action( 'akvo_sites_css', array( $this, 'css' ) );

		}

		function css(){

			$fonts = $this->customize_fonts();

			/* LIST OF ALL THE FONTS */
			$all_fonts = $this->fonts();

			// ADD FONT FACE FOR CUSTOM ONES
			foreach( $all_fonts as $font ){
				if( isset( $font['url'] ) && $font['url'] && ! ( strpos( $font['url'], 'google' ) !== false ) ) {
					_e("@font-face {	font-family: '".$font['name']."'; src: url('".$font['url']."');}");
					echo "\r\n";
				}
			}

			$items = array(
				array(
					'selector'	=> 'h1,h2,h3,h4,h5,h6',
					'styles'	=> array(
						'font-family'	=> 'head'
					)
				),
				array(
					'selector'	=> 'body',
					'styles'	=> array(
						'font-family'	=> 'body'
					)
				),
				array(
					'selector'	=> 'nav',
					'styles'	=> array(
						'font-family'	=> 'nav'
					)
				),

			);

			global $akvo;
			$akvo->print_css( $fonts, $items );

		}

		function load_fonts(){

			/* SELECTED FONTS FROM THE CUSTOMIZE */
			$font_face = $this->selected_fonts();

			/* LIST OF ALL THE FONTS */
			$google_fonts = $this->fonts();

			// ENQUEUE FONTS THAT ARE SELECTED
			foreach( $google_fonts as $google_font ){
				if( in_array( $google_font['name'], $font_face ) ){
					if( ( strpos( $google_font['url'], 'google' ) !== false ) ) {
						wp_enqueue_style( $google_font['slug'], $google_font['url'], false, null);
					}
				}
			}

		}

		function customize_fonts(){
			$fonts = array(
				'body'	=>  get_option('akvo_font') ? get_option('akvo_font') : ( get_theme_mod('akvo_font') ? get_theme_mod('akvo_font') : "Open Sans" ),
				'nav'	=> 	get_option('akvo_font_nav') ? get_option('akvo_font_nav') : ( get_theme_mod('akvo_font_nav') ? get_theme_mod('akvo_font_nav') : "Open Sans" ),
				'head'	=> 	get_option('akvo_font_head') ? get_option('akvo_font_head') : ( get_theme_mod('akvo_font_head') ? get_theme_mod('akvo_font_head') : "Open Sans" ),
			);

			return $fonts;
		}

		function selected_fonts(){

			// GET FONTS SELECTED THROUGH CUSTOMIZE
			$custom_akvo_fonts = $this->customize_fonts();

			$font_face = array();

			foreach( $custom_akvo_fonts as $font ){

				// CHECK IF FONT IS EMPTY
				if( $font ){ $font_face[] = $font; }

			}

			// DEFAULT FONT IF NONE IS SELECTED THROUGH CUSTOMIZE
			if( ! count( $font_face ) ){
				$font_face[] = "Open Sans";
			}

			return $font_face;
		}

		function fonts(){

			$fonts_arr = array(
  				array(
  					'slug'	=> 'opensans',
	  				'name'	=> 'Open Sans',
  					'url'	=> '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic'
  				),
  				array(
  					'slug'	=> 'roboto',
	  				'name'	=> 'Roboto',
  					'url'	=> '//fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic'
  				),
  				array(
  					'slug'	=> 'lora',
	  				'name'	=> 'Lora',
  					'url'	=> '//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic'
  				),
  				array(
  					'slug'	=> 'raleway',
	  				'name'	=> 'Raleway',
  					'url'	=> '//fonts.googleapis.com/css?family=Raleway:400,700'
  				),
	  			array(
  					'slug'	=> 'merriweather',
  					'name'	=> 'Merriweather',
  					'url'	=> '//fonts.googleapis.com/css?family=Merriweather:400,400italic,700,700italic'
	  			),
  				array(
  					'slug'	=> 'arvo',
  					'name'	=> 'Arvo',
  					'url'	=> '//fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic'
	  			),
  				array(
  					'slug'	=> 'muli',
  					'name'	=> 'Muli',
  					'url'	=> '//fonts.googleapis.com/css?family=Muli:400,400italic'
	  			),
  				array(
  					'slug'	=> 'nunito',
  					'name'	=> 'Nunito',
  					'url'	=> '//fonts.googleapis.com/css?family=Nunito:400,700'
  				),
	  			array(
  					'slug'	=> 'alegreya',
  					'name'	=> 'Alegreya',
  					'url'	=> '//fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700'
  				),
	  			array(
  					'slug'	=> 'exo2',
  					'name'	=> 'Exo 2',
  					'url'	=> '//fonts.googleapis.com/css?family=Exo+2:400,400italic,700,700italic'
	  			),
  				array(
  					'slug'	=> 'crimson',
  					'name'	=> 'Crimson Text',
  					'url'	=> '//fonts.googleapis.com/css?family=Crimson+Text:400,400italic,700,700italic'
	  			),
  				array(
  					'slug'	=> 'lobster',
  					'name'	=> 'Lobster Two',
  					'url'	=> '//fonts.googleapis.com/css?family=Lobster+Two:400,400italic,700,700italic'
  				),
	  			array(
  					'slug'	=> 'maven',
  					'name'	=> 'Maven Pro',
  					'url'	=> '//fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900'
  				),
	  		);

	  		$fonts_arr = apply_filters('akvo_fonts', $fonts_arr);

	  		return $fonts_arr;

		}

		function customize_register($wp_customize){

			global $akvo_customize;

			$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_font_section', 'Font Family', 'Select site typography');

			// FONT FAMILIES

			$google_fonts = $this->fonts();

			$fonts_arr = array();

			foreach( $google_fonts as $google_font ){
				$fonts_arr[$google_font['name']] = $google_font['name'];
			}


			$font_locations = array(
				'akvo_font_head'	=> 'Header Font',
				'akvo_font_nav'		=> 'Navigation Font',
				'akvo_font'			=> 'Body Font'
			);


			foreach( $font_locations as $location_id => $label ){
				$akvo_customize->ajax_dropdown( $wp_customize, 'akvo_font_section', $location_id, $label, 'Open Sans', $fonts_arr);
			}

			//$wp_customize->remove_section( 'nav');
			$wp_customize->remove_section( 'static_front_page');

		}

	}

	global $akvo_fonts;

	$akvo_fonts = new AKVO_FONTS;
