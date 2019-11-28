<?php
	
	class Akvo_Card extends AKVO_CARD_BASE{
		
		function __construct(){
			
			$this->shortcode_str 	= 'akvo-card';
			$this->shortcode_slug 	= 'akvo_card';
			$this->template 		= 'card';
			
			parent::__construct();
		}
		
		function get_default_atts(){
			return array(
				'title' 		=> 'Untitled',
				'content' 		=> '',
				'date' 			=> '',
				'type' 			=> 'project',
				'rsr-id' 		=> 'rsr', 
				'link' 			=> '',
				'img' 			=> '', 
				'type-text' 	=> '',
				'read_more_text'=> 'Read more',
				'posts_per_page' 	=> 1,
				'page'				=> 1
			);
		}
		
		function ajax(){
			
			$instance = wp_parse_args( (array) $_GET, $this->get_default_atts() );	/* init instance arguments */
			
			$data = $this->get_data_based_on_type( $instance );						/* GET DATA BASED IN TYPE OF DATA SELECTED */
			
			/* GET AKVO CARD FROM THE DATA */
			$akvo_card_atts = array();
			if( is_array( $data ) and count( $data ) ){
				$akvo_card_atts = $data[0];
			}
			
			$shortcode = $this->form_shortcode( $akvo_card_atts );		/* FORM THE SHORTCODE */
			
			echo do_shortcode( $shortcode );							/* PRINT THE SHORTCODE */
			
			wp_die();													/* kill the function after the processing is done */		
		}
		
	}
	
	global $akvo_card;
	$akvo_card = new Akvo_Card;