<?php


class FB_ADMIN extends SINGLETON{

	function __construct(){

		/*
		* TO APPEAR AN AN OPTION IN THE THEME SETTINGS 
		*/
		add_filter( 'akvo-settings-cpt-options', function( $custom_post_types ){
			$custom_post_types['fb-feeds'] = array(
				'plural_name' 	=> 'Facebook Feeds',
				'singular_name' => 'Facebook Feed',
				'icon' 					=> 'dashicons-location-alt'
			);
			return $custom_post_types;
		} );

		/*
		* ALLOW THE VISIBILITY OF FACEBOOK FEEDS IF IT IS ENABLED THROUGH THE THEME SETTINGS
		*/
		global $akvo;
	  $settings = $akvo->get_settings();
		if( in_array( 'fb-feeds', $settings['cpt'] ) ){
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
	}

	function admin_menu(){
		add_submenu_page(
			'edit.php?post_type=fb_post',
			__('FB Posts Settings', 'rushhour'),
			__('Settings', 'rushhour'),
			'manage_options',
			'settings',
			array( $this, 'settings_page' )
		);
	}

	function getSettingsOptions(){
		return array(
			'fbAccessToken' => 'Access Token',
			//'fbPageID'		=> 'Page ID'
		);
	}

	function settings_page(){
		include "templates/settings.php";
	}

	function init(){
		add_theme_support( 'post-thumbnails' );

		$args = array(
			'show_in_rest'                  => true, // Enable the REST API
			'labels'                        => array(
				'name'                          => _x('Facebook Posts', 'post type general name', 'Fb posts'),
				'singular_name'                 => _x('Facebook Post', 'post type singular name', 'Fb posts'),
			),
			'description'                   => __('Description.', 'Fb-posts'),
			'public'                        => true,
			'publicly_queryable'            => true,
			'show_ui'                       => true,
			'show_in_menu'                  => true,
			'show_in_nav_menus'             => true,
			'can_export'                    => true,
			'exclude_from_search'           => true,
			'menu_icon'                     => 'dashicons-facebook', // Set icon
			'query_var'                     => true,
			'rewrite'                       => array('slug' => 'fbfeed'),
			'capability_type'               => 'post',
			'has_archive'                   => true,
			'hierarchical'                  => false,
			'menu_position'                 => null,
			'supports'                      => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
			//'taxonomies'                    => array('category', 'post_tag'),
		);

		register_post_type('Fb_post', $args);
	}


}

FB_ADMIN::getInstance();
