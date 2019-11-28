<?php
	
	add_action( 'widgets_init', create_function( '', 'register_widget("post_widget");' ) );
	
	class post_widget extends WP_Widget {

		/* Widget setup */
		function __construct() {
    		$widget_ops = array(
            	'classname' => 'single_post',
            	'description' => 'Displays a single post widget'
        	);
			parent::__construct( 'post_widget', 'Single Post Widget', $widget_ops );
		}

		/* How to display the widget on the screen */
		function widget( $args, $instance ) {
    
			extract( $args );
    
			static $counters = array();
			
			$label = $instance['type'].'-'.$instance['rsr-id'];
			
			
			
			/* reset offset counter if rsr-id or type has changed */
			if (!isset($counters[$label])) {
      			$counters[$label] = 0;
      		}
      		
      		
      		
      		if(!isset($instance['type-text'])){
    			$instance['type-text'] = '';
    		}
    		
    		$instance['offset'] = $counters[$label];
    		
    		/* get the ajax url for the card widget */
    		$akvo_card_obj = new Akvo_Card;
    		$url = $akvo_card_obj->get_ajax_url('akvo_card', $instance, array('panels_info'));
    		
    		
    		echo "<div data-behaviour='reload-html' data-url='".$url."'></div>";
			
    		$counters[$label]++;
		}

  		/* Update the widget settings */
  		function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
			
			/* Strip tags for title and name to remove HTML (important for text inputs). */
    		$instance['type'] = $new_instance['type'];
    		$instance['rsr-id'] = $new_instance['rsr-id'];
    		$instance['type-text'] = $new_instance['type-text'];
    		
			return $instance;
  		}

  		/**
   		* Displays the widget settings controls on the widget panel.
   		* Make use of the get_field_id() and get_field_name() function
   		* when creating your form elements. This handles the confusing stuff.
   		*/
		function form( $instance ) {
			/* Set up some default widget settings. */
    		$instance = wp_parse_args( (array) $instance, array( 'type' => 'news', 'rsr-id' => 'rsr', 'type-text' => '') ); 
			include "templates/single_post_widget.php";
		}
	}
	