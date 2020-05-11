<?php
/*
Widget Name: Akvo Tabs
Description: Akvo Tabs widget with layout builder
Author: Samuel Thomas, Akvo
Author URI:
Widget URI:
Video URI:
*/

class Akvo_Tabs extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'akvo-tabs',

			// The name of the widget for display purposes.
			__('Akvo Tabs', 'siteorigin-widgets'),

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Akvo Tabs widget with layout builder', 'siteorigin-widgets'),
				'help'        => '',
			),

			//The $control_options array, which is passed through to WP_Widget
			array(),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'akvo_tabs_repeater' => array(
					'type' 	=> 'repeater',
					'label' => __( 'Akvo Tabs Repeater' , 'siteorigin-widgets' ),
          'item_name'  => __( 'Add Tab', 'siteorigin-widgets' ),
          'item_label' => array(
  					'selector' => "[id*='tab_title']",
  					'update_event' => 'change',
  					'value_method' => 'val'
  				),
					'fields' => array(
            'tab_title' => array(
  						'type' => 'text',
  						'label' => __( 'Title', 'siteorigin-widgets' ),
  					),
  					'tab_content' => array(
              'type' => 'builder',
              'label' => __( 'Tab Content', 'siteorigin-widgets'),
  					),
					)
				),
			),

			//The $base_folder path string.
			get_template_directory()."/so-widgets/akvo-tabs"
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

siteorigin_widget_register('akvo-tabs', __FILE__, 'Akvo_Tabs');
