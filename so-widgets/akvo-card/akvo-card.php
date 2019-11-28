<?php
/*
	Widget Name: Akvo Card
	Description: Akvo Card Single Widget to pull RSR updates, projects or WP Post Types
	Author: Samuel Thomas, Akvo
	Author URI: 
	Widget URI: 
	Video URI: 
*/

class Akvo_Card_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'akvo-card',

			// The name of the widget for display purposes.
			__('Akvo Card Single', 'siteorigin-widgets'),

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Akvo Card Single Widget to pull RSR updates, projects or WP Post Types', 'siteorigin-widgets'),
				'help'        => '',
			),

			//The $control_options array, which is passed through to WP_Widget
			array(),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'type' => array(
					'type' => 'select',
					'label' => __( 'Type', 'siteorigin-widgets' ),
					'default' => 'news',
					'options' => $this->get_types(),
					'state_emitter' => array(
						'callback' 	=> 'select',
						'args' 		=> array( 'type' )
					),
				),
				'rsr-id' => array(
					'type' => 'text',
					'label' => __( 'RSR ID (from data-feed)', 'siteorigin-widgets' ),
					'default' => 'rsr',
					'state_handler' => array(
						'type[project]' 	=> array('show'),
						'type[rsr-project]' => array('show'),
						'_else[type]' 		=> array('hide'),
					),
				),
				'type-text' => array(
					'type' 		=> 'text',
					'label' 	=> __( 'Custom Tag', 'siteorigin-widgets' ),
					'default' 	=> '',
					'description'	=> 'To replace the default tags such as news, blog, etc'
				),
			),

			//The $base_folder path string.
			get_template_directory()."/so-widgets/akvo-card"
		);
	}
	
	function get_types(){
		global $akvo_card;
		return $akvo_card->get_types();
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
siteorigin_widget_register('akvo-card', __FILE__, 'Akvo_Card_Widget');