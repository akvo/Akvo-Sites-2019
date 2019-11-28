<?php 
	
	class AKVO_CARD_BASE{
		
		var $shortcode_str;
		var $shortcode_slug;
		var $template;
		var $counters;
		
		function __construct(){
			
			/* HANDLE AJAX */
			add_action( "wp_ajax_".$this->shortcode_slug, array( $this, "ajax" ) );
			add_action( "wp_ajax_nopriv_".$this->shortcode_slug, array( $this, "ajax" ) );
			
			/* HANDLE SHORTCODE */
			add_shortcode( $this->shortcode_str, array( $this, 'shortcode' ) );
			
			/* COUNTERS FOR INCREMENTING */
			$this->counters = array();
			
		}
		
		function get_counter( $label ){
			if( !isset($this->counters[$label]) ) { $this->counters[$label] = -1; }	/* reset offset counter if rsr-id or type has changed */
      		$this->counters[$label]++;
			return $this->counters[$label];
		}
		
		/* FUNCTION THAT HANDLES YOUR AJAX - TO BE IMPLEMENTED BY THE CHILD CLASSES */
		function ajax(){}
		/* FUNCTION THAT HANDLES YOUR AJAX - TO BE IMPLEMENTED BY THE CHILD CLASSES */
		
		/* SHORTCODE FUNCTIONALITY */
		function shortcode( $atts ){
			ob_start();																				/* STORE TEMPLATING INTO BUFFER */
			
			$atts = shortcode_atts( $this->get_default_atts(), $atts, $this->shortcode_slug );		/* SHORTCODE ATTRIBUTES */
			
			include "templates/".$this->template.".php";											/* TEMPLATE */
				
			return ob_get_clean();																	/* RETURN BUFFER TEMPLATING */	
		}
		
		
		/* GET DATA BASED ON TYPE OF DATA TO BE PULLED */
		function get_data_based_on_type( $instance ){
			
			$data = array();
			
			/* CHECK TYPE OF DATA */
			switch($instance['type']){
				
				case 'rsr-project': 
					$data = $this->rsr_query( $instance, 'project' );		/* RSR Project Card */
					break;
				
				case 'rsr':
					$data = $this->rsr_query( $instance, 'update' );		/* RSR Updates Card */
					break;
					
				case 'project': 
					$data = $this->rsr_query( $instance, 'update' );		/* RSR Updates Card */
					break;
				
				default:
					$data = $this->wp_query($instance);						/* WP QUERY OF CUSTOM POST TYPES */
			
			}
			
			return $data;
		}
		/* GET DATA BASED ON TYPE OF DATA TO BE PULLED */
		
		/* GET AJAX URL */
		function get_ajax_url($action, $atts, $dont_inc = array()){
			$url = admin_url('admin-ajax.php')."?action=".$action;
			foreach($atts as $key => $val){									/* ITERATE THROUGH ATTRIBUTES */
				if(!in_array($key, $dont_inc)){
					$url .= "&".$key."=".$val;
				}	
			}
			return $url;
		}
		
		
		/* RSR PROJECT OR RSR UPDATES */
		function rsr_query( $atts, $type = 'project' ){
			
			$akvo_card_options 	= $this->get_akvo_card_options();
			$akvo_date_format	= $this->get_date_format();
			
			global $akvo_rsr;
			
			$data = array();
			$jsondata = $akvo_rsr->get_json_data( $atts['rsr-id'] );														// GET JSON DATA FROM DATA FEED
			
			
			if( !isset( $jsondata->results ) ){																 
				/* SINGULAR DATA */
				$temp = $akvo_rsr->parse_rsr( $jsondata, $akvo_card_options, $akvo_date_format, $type );					// PARSE JSON 
				$temp = self::add_extra_params($temp, $atts);																// adding extra params 
				
				array_push($data, $temp);																					// ADD TO FINAL DATA 
			}
			else{																							
				/* MULTIPLE VALUES */
				$offset = self::get_offset( $atts );																		// GET OFFSET						
				
				for($i = $offset; $i < $offset+$atts['posts_per_page']; $i++){
					
					$temp = $akvo_rsr->parse_rsr( $jsondata->results[$i], $akvo_card_options, $akvo_date_format, $type ); 	// PARSE JSON 
					$temp = self::add_extra_params($temp, $atts);															// adding extra params 
					
					array_push($data, $temp);																				// ADD TO FINAL DATA 
				}
			}
			return $data;
		}
		
		/* GET AKVO CARD OPTIONS FROM CUSTOMISE */
		function get_akvo_card_options(){
			
			global $akvo;
			
			$akvo_card_options = array();
			
			$akvo_options = $akvo->get_option();				/* GLOBAL AKVO OPTIONS */
			
			if( isset( $akvo_options['card'] ) ){				/* CHECK IF THE CARD OPTIONS EXISTS IN GLOBAL */ 
				$akvo_card_options = $akvo_options['card'];
			}
			else{
				$akvo_card_options = get_option('akvo_card');	/* GET OPTIONS FROM AKVO CARD SETTINGS */
			}
			return $akvo_card_options;
		
		}
		
		
		/* PARSING WP POST - CUSTOM POST TYPE */
		function parse_post($post){
			
			$data = array();
			
			/* parsing post object */
			$data['post_id'] = $post->ID;
			$data['img'] 	 = akvo_featured_img( $post->ID );
			$data['title'] 	 = get_the_title( $post->ID );
			$data['date'] 	 = get_the_date( self::get_date_format(), $post->ID );
			$data['link'] 	 = get_the_permalink( $post->ID );
			$data['content'] = wp_trim_words( get_the_excerpt( $post->ID ) );
			
			return $data;	
		}
		
		
		/* TYPES OF INFOMATION - RSR AND WP CUSTOM POST TYPES */
		function get_types(){
			
			/* RSR INFORMATION */
			$post_type_arr = array(
				'project' 		=> 'RSR Updates',
				'rsr-project'	=> 'RSR Project',
			);
			
			/* WP CUSTOM POST TYPES */
			global $akvo;
			foreach( $akvo->custom_post_types as $slug => $post_type ){
				$post_type_arr[ $slug ] = $post_type['plural_name'];
			}
			
			return $post_type_arr;
		}
		
		/* PASS AN ARRAY TO CREATE ATTRIBUTES OF SHORTCODE */
		function form_shortcode( $data ){
			
        	$default_atts = $this->get_default_atts(); 				// GET DEFAULT ATTS OF THE SHORTCODE 
			
			$shortcode = '['.$this->shortcode_str.' ';				// SHORTCODE STRING START 
			
        	foreach( $data as $key => $val ){
        		
				/* ONLY ADD THOSE KEYS THAT ARE PART OF THE SHORTCODE */
				if( array_key_exists( $key, $default_atts ) ){
				
					$val = str_replace("[","&#91;",$val);
					$val = str_replace("]","&#93;",$val);
        			
					$shortcode .= $key.'="'.$val.'" ';				/* SHORTCODE STRING ADD ATTRIBUTES */
				}
        	}
        	$shortcode .= ']';										/* SHORTCODE STRING END */
        		
			return $shortcode;
		}
		
		/* add extra params from one array to another */
		function add_extra_params($data, $atts, $extras = array('type-text', 'type')){
			foreach($extras as $extra){
				if($atts[$extra]){
					$data[$extra] = $atts[$extra];
				}	
			}
			return $data;
		}	
		
		/* WP QUERY */
		function wp_query($atts){
			$data = array();
			
			$query_atts = array(
				'post_type' 		=> $atts['type'],
        		'posts_per_page' 	=> $atts['posts_per_page'],
        		'offset'			=> self::get_offset( $atts ),
			);
			
			/* TAXONOMY QUERY - CUSTOM TYPES AND TERMS */
			if( isset( $atts['filter_by'] ) ){
				$atts['filter_by'] = explode( ':',  $atts['filter_by'] );
				if( is_array( $atts['filter_by'] ) && ( count( $atts['filter_by'] ) > 1 ) ){
					$query_atts['tax_query'] = array(
						array(
							'taxonomy' => $atts['filter_by'][0],
							'field'    => 'slug',
							'terms'    => $atts['filter_by'][1],
						)
					);
				}
			}
			/* TAXONOMY QUERY - CUSTOM TYPES AND TERMS */
			
			$query = new WP_Query( $query_atts );
			if ( $query->have_posts() ) { 
				while ( $query->have_posts() ) {
					$query->the_post();
					
          			$temp = self::parse_post($query->post);				/* parse wp post into an array */
          			$temp = self::add_extra_params($temp, $atts);		/* adding extra params */
					
					array_push($data, $temp);							/* add to global data */
          		}
				wp_reset_postdata();
			}
			return $data;
		}
		
		/* GET DATE FORMAT */
		function get_date_format(){ return get_option('date_format'); }
		
		/* Iterate through RSR updates */
		function get_offset( $atts ){
			return (((int)$atts['page'] - 1) * (int)$atts['posts_per_page']) + (int)$atts['offset'];
		}
		
		/* SLUGIFY TEXT */
		function slugify( $text ){
			global $akvo;
			return $akvo->slugify( $text );
		}
		
		/* GET CUSTOM TAXONOMIES */
		function get_taxonomies(){
			global $akvo;
			return $akvo->custom_taxonomies;
		}
		
		/* GET DATA FEEDS FROM THE DATABASE */
		function get_data_feeds(){
			global $akvo_rsr;
			return $akvo_rsr->get_data_feeds();
		}
		
	}