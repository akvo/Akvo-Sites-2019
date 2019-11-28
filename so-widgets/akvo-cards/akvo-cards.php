<?php
/*
	Widget Name: Akvo Cards
	Description: Akvo Cards Multiple Widget to pull RSR updates, projects or WP Post Types
	Author: Samuel Thomas, Akvo
	Author URI: 
	Widget URI: 
	Video URI: 
*/

class Akvo_Cards_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'akvo-cards',

			// The name of the widget for display purposes.
			__('Akvo Cards Multiple', 'siteorigin-widgets'),

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Akvo Cards Multiple Widget to pull RSR updates, projects or WP Post Types', 'siteorigin-widgets'),
				'help'        => '',
			),

			//The $control_options array, which is passed through to WP_Widget
			array(),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'template' => array(
					'type' 		=> 'select',
					'label' 	=> __( 'Choose Template', 'siteorigin-widgets' ),
					'default' 	=> 'news',
					'options' 	=> array(
						'card'	=> 'Card',
						'list'	=> 'List'
					)
				),
				'type' => array(
					'type' 			=> 'select',
					'label' 		=> __( 'Choose Type', 'siteorigin-widgets' ),
					'default' 		=> 'news',
					'state_emitter' => array(
						'callback' 	=> 'select',
						'args' 		=> array( 'type' )
					),
					'options' 		=> $this->get_types(),
					'description'	=> 'Choose from Data-Feeds or Wordpress Custom Post Types'
				),
				'pagination' => array(
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Load More Button', 'siteorigin-widgets' ),
					'default' 		=> false,
					'description'	=> 'Enable Lazy Loading / Pagination'
				),
				'posts_per_page' => array(
					'type' 			=> 'number',
					'label' 		=> __( 'Number of Items', 'siteorigin-widgets' ),
					'default' 		=> '3',
					'description'	=> 'Items per request to be shown'
				),
				'rsr-id' => array(
					'type' 			=> 'select',
					'label' 		=> __( 'Choose Data-Feed', 'siteorigin-widgets' ),
					'default' 		=> 'none',
					'state_handler' => array(
						'type[project]' 	=> array('show'),
						'type[rsr-project]' => array('show'),
						'_else[type]' 		=> array('hide'),
					),
					'options' => $this->get_data_feeds()
				),
				'type-text' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'Custom Tag', 'siteorigin-widgets' ),
					'default' 		=> '',
					'description'	=> 'To replace the default tags such as news, blog, etc'
				),
				'filter_taxonomy' => array(
					'type' 		=> 'select',
					'label' 	=> __( 'Filter by taxonomy', 'siteorigin-widgets' ),
					'default' 	=> 'none',
					'options' 	=> $this->get_taxonomies(),
					'state_handler' => array(
						'type[project]' 	=> array('hide'),
						'type[rsr-project]' => array('hide'),
						'_else[type]' 		=> array('show'),
					),
					'description'	=> 'Select custom wordpress taxonomy to be filtered'
				),
				'filter_value' => array(
					'type' 		=> 'text',
					'label' 	=> __( 'Filter by value', 'siteorigin-widgets' ),
					'default' 	=> '',
					'state_handler' => array(
						'type[project]' 	=> array('hide'),
						'type[rsr-project]' => array('hide'),
						'_else[type]' 		=> array('show'),
					),
					'description'	=> 'Select taxonomy term to be filtered'
				),
			),

			//The $base_folder path string.
			get_template_directory()."/so-widgets/akvo-cards"
		);
	}
	
	function get_taxonomies(){
		
		global $akvo_cards;
		
		$tax_arr = array('none' => 'None');
		
		$taxonomies = $akvo_cards->get_taxonomies();
			
		foreach( $taxonomies as $slug => $tax ){
			$tax_arr[ $slug ] = $slug;
		}
		
		return $tax_arr;
		
	}
	
	function get_types(){
		global $akvo_cards;
		return $akvo_cards->get_types();
	}
	
	function get_data_feeds(){
		global $akvo_cards;
		
		$data_feeds = $akvo_cards->get_data_feeds();
		
		$data_feeds['none'] = 'Select None';
		
		return $data_feeds;
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
siteorigin_widget_register('akvo-cards', __FILE__, 'Akvo_Cards_Widget');