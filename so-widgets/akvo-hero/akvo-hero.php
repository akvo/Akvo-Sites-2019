<?php
/*
	Widget Name: Akvo Hero
	Description: Akvo Hero with cover image and caption
	Author: Samuel Thomas, Akvo
	Author URI: 
	Widget URI: 
	Video URI: 
*/

class Akvo_Hero_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'akvo-hero',

			// The name of the widget for display purposes.
			__('Akvo Hero', 'siteorigin-widgets'),

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Akvo Hero with cover image and caption', 'siteorigin-widgets'),
				'help'        => '',
			),

			//The $control_options array, which is passed through to WP_Widget
			array(),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'title' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'Title', 'siteorigin-widgets' ),
					'default' 		=> '',
					'description'	=> 'Title/Caption of the page'
				),
				'image' => array(
					'type' 		=> 'media',
					'label' 	=> __( 'Choose Image', 'siteorigin-widgets' ),
					'choose' 	=> __( 'Choose image', 'siteorigin-widgets' ),
					'update' 	=> __( 'Set image', 'siteorigin-widgets' ),
					'library' 	=> 'image',
					'fallback' 	=> false
				),
			),

			//The $base_folder path string.
			get_template_directory()."/so-widgets/akvo-hero"
		);
	}
	
	
	
	function get_template_name($instance) {
		return 'template';
	}

	function get_template_dir($instance) {
		return 'templates';
	}

    function get_style_name($instance) {
        return '';
    }
}
siteorigin_widget_register( 'akvo-hero', __FILE__, 'Akvo_Hero_Widget' );