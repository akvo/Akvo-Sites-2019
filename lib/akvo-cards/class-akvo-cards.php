<?php
	
	class AKVO_CARDS extends AKVO_CARD_BASE{
		
		function __construct(){
			
			$this->shortcode_str 	= 'akvo-cards';
			$this->shortcode_slug 	= 'akvo_cards';
			
			parent::__construct();
			
		}
		
		function get_default_atts(){
			return array( 
				'template'			=> 'card',
				'type' 				=> 'post', 
				'posts_per_page' 	=> 3,
				'rsr-id' 			=> 'rsr', 
				'type-text' 		=> '',
				'filter_by'			=> '',
				'page' 				=> 1,
				'pagination' 		=> 0
			); 
		}
		
		function ajax(){
			
			$atts = wp_parse_args( (array) $_GET, $this->get_default_atts() ); 		/* CREATE ATTS ARRAY FROM DEFAULT AND USER PARAMETERS IN GET */
			
			if(isset($_GET['akvo-paged'])){	$atts['page'] = $_GET['akvo-paged']; }	/* CHECK IF PAGINATION HAS BEEN INVOKED */

			$data = $this->get_data_based_on_type( $atts );							/* GET DATA BASED IN TYPE OF DATA SELECTED */
			
			$url = $this->get_ajax_url('akvo_cards', $atts);						/* GET AJAX URL */
			
			include "templates/cards.php";											/* TEMPLATING */
			
			wp_die();																/* kill the function after ajax processing */
			
		}
		
		function shortcode( $atts ){
			
			$atts = shortcode_atts( $this->get_default_atts(), $atts, $this->shortcode_slug );	/* CREATE ATTS ARRAY FROM DEFAULT AND USER PARAMETERS */
			
			ob_start();																			/* SAVE DISPLAYED HTML IN A TEMP VARIABLE */
			
			$url = $this->get_ajax_url( $this->shortcode_slug, $atts );							/* URL FUNCTION CAN BE FOUND IN THE AKVO_CARD_BASE CLASS */
			
			echo "<div data-behaviour='reload-html' data-url='".$url."'></div>";
			
			return ob_get_clean();
		}
		
	}
	
	global $akvo_cards;
	$akvo_cards = new AKVO_CARDS;