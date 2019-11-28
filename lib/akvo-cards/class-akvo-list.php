<?php
	
	class AKVO_LIST extends AKVO_CARD_BASE{
		
		function __construct(){
			
			$this->shortcode_str 	= 'akvo-list';
			$this->shortcode_slug 	= 'akvo_list';
			$this->template 		= 'list';
			
			parent::__construct();
			
		}
		
		function get_default_atts(){
			return array(
				'post_id'		=> 0,
				'title' 		=> 'Untitled',
				'content' 		=> '',
				'date' 			=> '',
				'type' 			=> 'Blog',
				'link' 			=> '',
				'img' 			=> '', 
				'type-text' 	=> '',
				'read_more_text'=> 'Read more'
			);
		}
		
		/* FOR MEDIA TYPE, ADD EXTRA TYPES FROM TAXONOMY */
		function get_media_term_types( $post_id ){
			$types = array();
			$term_types = get_the_terms( $post_id, 'types' );
			if( is_array( $term_types ) && count( $term_types ) ){
				foreach( $term_types as $term_type ){
					array_push( $types, $term_type->name );
				}
			}
			return $types;
		}
		
	}
	
	global $akvo_list;
	$akvo_list = new AKVO_LIST;