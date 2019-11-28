<?php


	class AKVO_CUSTOMIZE{

		function __construct(){

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_control_js' ) );

			add_action( 'customize_register', array( $this, 'prefix_customize_register' ) );

			add_action( 'wp_ajax_export_customize', array( $this, 'export_customize' ) );
		}

		function export_customize(){
			global $akvo;

			$options = array(
				'akvo_article'					=> get_option('akvo_article'),
				'sage_carousel_options'	=> get_option('sage_carousel_options'),
				'akvo_events'						=> get_option('akvo_events'),
				'akvo_assets'						=> get_option('akvo_assets'),
				'akvo_options'					=> $akvo->get_option(),
				'sage_header_options'		=> get_option('sage_header_options'),
				'colors'								=> $this->get_colors()
			);

			echo "<pre>";
			print_r( $options );
			//echo wp_json_encode( $options );
			echo "</pre>";


			wp_die();
		}

		function get_colors(){

			$colors = array(
				'main_color' 						=> get_option('main_color') ? get_option('main_color') : ( get_theme_mod('main_color') ? get_theme_mod('main_color') : '#00a99d' ),
				'grijs'									=> get_option('grijs') ? get_option('grijs') : ( get_theme_mod('grijs') ? get_theme_mod('grijs') : '#e6e6e6'),
				'background'						=> get_option('background') ? get_option('background') : ( get_theme_mod('background') ? get_theme_mod('background') : '#ffffff' ),
				'info_bar_blog'					=> get_option('info_bar_blog') ? get_option('info_bar_blog') : ( get_theme_mod('info_bar_blog') ? get_theme_mod('info_bar_blog') : '#a3d165' ),
				'info_bar_video'				=> get_option('info_bar_video') ? get_option('info_bar_video') : ( get_theme_mod('info_bar_video') ? get_theme_mod('info_bar_video') : '#f47b50' ),
				'info_bar_update'				=> get_option('info_bar_update') ? get_option('info_bar_update') : ( get_theme_mod('info_bar_update') ? get_theme_mod('info_bar_update') : '#54bce8' ),
				'info_bar_page'					=> get_option('info_bar_page') ? get_option('info_bar_page') : ( get_theme_mod('info_bar_page') ? get_theme_mod('info_bar_page') : '#6d3a7d' ),
				'info_bar_media'				=> get_option('info_bar_media') ? get_option('info_bar_media') : ( get_theme_mod('info_bar_media') ? get_theme_mod('info_bar_media') : '#9d897b' ),
				'info_bar_map'					=> get_option('info_bar_map') ? get_option('info_bar_map') : ( get_theme_mod('info_bar_map') ? get_theme_mod('info_bar_map') : '#ad1c3c' ),
				'info_bar_project'			=> get_option('info_bar_project') ? get_option('info_bar_project') : ( get_theme_mod('info_bar_project') ? get_theme_mod('info_bar_project') : '#7381fa' ),
				'info_bar_testimonial'	=> get_option('info_bar_testimonial') ? get_option('info_bar_testimonial') : ( get_theme_mod('info_bar_testimonial') ? get_theme_mod('info_bar_testimonial') : '#007ba8' ),
				'info_bar_flow'					=> get_option('info_bar_flow') ? get_option('info_bar_flow') : ( get_theme_mod('info_bar_flow') ? get_theme_mod('info_bar_flow') : '#54bce8' ),
				'info_bar_news'					=> get_option('info_bar_news') ? get_option('info_bar_news') : ( get_theme_mod('info_bar_news') ? get_theme_mod('info_bar_news') : '#f9ba41' ),
			);

			return $colors;
		}

		function customize_control_js(){
			wp_enqueue_script( 'akvo_customizer_control', get_template_directory_uri() . '/dist/scripts/customizer-control.js', array( 'customize-controls', 'jquery' ), '1.0.2', true );
		}

		function prefix_customize_register( $wp_customize ) {
			// Define a custom control class, AKVO_CUSTOMIZE_DROPDOWN_CONTROL.
			// Register the class so that its JS template is available in the Customizer.
			$wp_customize->register_control_type( 'AKVO_CUSTOMIZE_DROPDOWN_CONTROL' );
		}

		function panel( $wp_customize, $id, $label){

			$wp_customize->add_panel($id, array(
				'priority' 		=> 30,
				'capability' 	=> 'edit_theme_options',
				'theme_supports'=> '',
				'title' 		=> $label,
				'description' 	=> '',
			) );

		}

		function section( $wp_customize, $panel, $id, $label, $desc){


			$wp_customize->add_section( $id , array(
	    		'title'       	=> __( $label, 'akvo' ),
		    	'priority'    	=> 30,
		    	'description' 	=> $desc,
		    	'panel'			=> $panel
			) );

		}



		function color( $wp_customize, $section, $id, $label, $default ){

			$this->add_setting( $wp_customize, $id, $default );

    		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
          		'label' => $label,
          		'section' => $section,
          		'settings' => $id,
    		)));




		}

		function checkbox( $wp_customize, $section, $id, $label ){

			$this->add_setting( $wp_customize, $id, $default );


			$wp_customize->add_control($id, array(
      			'settings' 	=> $id,
      			'label'    	=> __($label),
      			'section'  	=> $section,
      			'type'     	=> 'checkbox',
      			'std' 		=> 1
      		));


		}


		function text( $wp_customize, $section, $id, $label, $default){

			$this->add_setting( $wp_customize, $id, $default );

			$wp_customize->add_control($id, array(
				'settings' 	=> $id,
	    		'type' 		=> 'text',
    	    	'label' 	=> $label,
        		'section' 	=> $section,
	        ));

		}

		function textarea( $wp_customize, $section, $id, $label, $default){

			$this->add_setting( $wp_customize, $id, $default );

			$wp_customize->add_control($id, array(
				'settings' 	=> $id,
	    		'type' 		=> 'textarea',
    	    	'label' 	=> $label,
        		'section' 	=> $section,
	        ));

		}

		function dropdown( $wp_customize, $section, $id, $label, $default, $choices){

			$this->add_setting( $wp_customize, $id, $default );

			$wp_customize->add_control( $id, array(
				'type' 		=> 'select',
		    	'label'    	=> $label,
		    	'section'  	=> $section,
		    	'settings' 	=> $id,
		    	'choices' 	=> $choices
			));
		}

		function ajax_dropdown( $wp_customize, $section, $id, $label, $default, $choices){

			$this->add_setting( $wp_customize, $id, $default );

			$wp_customize->add_control( new AKVO_CUSTOMIZE_DROPDOWN_CONTROL(
				$wp_customize,
				$id,
				array(
					'label' 	=> $label,
					'section' 	=> $section,
					'settings' 	=> $id,
					'choices' 	=> array( 'url' => admin_url('admin-ajax.php?action=akvo_fonts') ),
				)
			) );

			/*
			$wp_customize->add_control( $id, array(
				'type' 		=> 'select',
		    	'label'    	=> $label,
		    	'section'  	=> $section,
		    	'settings' 	=> $id,
		    	'choices' 	=> $choices
			));
			*/
		}

		function image( $wp_customize, $section, $id, $label, $default){

			$this->add_setting( $wp_customize, $id, $default );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
          		'label' 	=> $label,
          		'section' 	=> $section,
          		'settings' 	=> $id,
			)));
		}

		function add_setting( $wp_customize, $id, $default ){

			$wp_customize->add_setting( $id, array(
				'default' 	=> $default,
				'transport' => 'refresh',
				'type' 		=> 'option'
			) );

		}

	}

	global $akvo_customize;

	$akvo_customize = new AKVO_CUSTOMIZE;
