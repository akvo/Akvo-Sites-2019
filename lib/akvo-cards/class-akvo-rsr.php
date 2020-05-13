<?php

	class AKVO_RSR{

		function __construct(){

			//



			//add_shortcode( 'akvo_rsr_project_field', array( $this, 'display_project_field' ) );
		}



		function display_project_field( $atts ){
			$atts = shortcode_atts( array(
				'feed'	=> 'Sample',
				'field'	=> 'project_plan'
			), $atts, 'akvo_rsr_project_field' );

			$json_data = $this->get_data_feed_response( $atts['feed'] );

			$field = $atts['field'];

			if( isset( $json_data->$field ) ){
				return $json_data->$field;
			}
		}

		function get_json_data( $atts ){

			return $this->get_data_feed_response( $atts );

			/*
			$data_feed_id = $atts['rsr-id'];

			$shortcode_str = '[data_feed name="'.$data_feed_id.'"]';

			$data = do_shortcode( $shortcode_str ); 		// Dependancy on the Data Feed Plugin

			return json_decode( str_replace('&quot;', '"', $data) );
			*/


		}

		/* GET DATA FEEDS FROM THE DATABASE */
		function get_data_feeds(){
			global $wpdb;

			$data_feeds = array();

			$rows = $wpdb->get_results( 'SELECT df_name FROM ' . $wpdb->prefix . 'data_feeds' );

			foreach( $rows as $row ){
				$data_feeds[ $row->df_name ] = $row->df_name;
			}

			return $data_feeds;

		}

		/* GET DATA FEED URL FROM ID */
		function get_data_feed_url( $data_feed_id ){

			global $wpdb;

			$rows = $wpdb->get_results( "SELECT df_url FROM " . $wpdb->prefix . "data_feeds WHERE df_name='" . $data_feed_id . "' LIMIT 0,1;" );

			foreach( $rows as $row ){
				return $row->df_url;
			}

			return false;
		}

		function getAPIResponse( $url, $api_key = false, $cache_expiration = 600 ){
			$cache_key = md5( $url );

			$data = array();
			if ( ! ( $data = get_transient( $cache_key ) ) ) {
				$args = array( 'headers' => array() );
				if( $api_key ){
					$args['headers'] = array(
						'Authorization' => 'Token ' . $api_key,
					);
				}

				$request = wp_remote_get( $url, $args );
				if( ! is_wp_error( $request ) ) {
					$body = wp_remote_retrieve_body( $request );
					$data = json_decode( $body );
					set_transient( $cache_key, $data,  $cache_expiration );    // IF IT IS NEW, SET THE TRANSIENT FOR NEXT TIME
				}
				else{
					print_r($request);																// DISPLAYING THE ERROR
				}
			}
			return $data;
		}

		function get_data_feed_response( $atts, $api_key = false ){
			$url = "";
			// IF API URL IS PASSED THEN SET TO URL OR GET IT FROM DATA FEED ID
			if( isset( $atts['rsr-project'] ) && $atts['rsr-project'] && $atts['type'] == 'rsr' ){
				$url = AKVO_RSR_PROJECT::getInstance()->getUrl( $atts['rsr-project'], 'updates' );
			}
			else{
				$url = $this->get_data_feed_url( $atts['rsr-id'] );
			}
			// ADD PAGINATION PARAMETERS TO THE URL
			$url .= "&limit=" . $atts['posts_per_page']."&page=" . $atts['page'];

			$_json_expiration = 60 * 10; // 10 minutes
			//$key = $json_key . md5( $url );
			return $this->getAPIResponse( $url, $api_key, $_json_expiration );
		}

		function get_feed_api( $url ){

			$body = false;

			try{
				$request = wp_remote_get( $url );

				//print_r( $request );

				if( ! is_wp_error( $request ) ) {
					$body = wp_remote_retrieve_body( $request );
				}
			}catch( Exception $e ){
				print_r( $e );
			}
			return $body;
		}

		function get_base_url( $akvo_card_options ){
			$base_url = 'http://rsr.akvo.org';
			if($akvo_card_options && array_key_exists('akvoapp', $akvo_card_options)){
				$base_url = $akvo_card_options['akvoapp'];
			}
			return $base_url;
		}

		function parse_rsr( $rsr_obj, $akvo_card_options, $akvo_date_format, $type ){

			$data = array( 'type-text'	=> 'RSR Project' );
			if( $type == 'update' ){
				$data[ 'type-text' ] = 'RSR Updates';
			}

			$base_url = self::get_base_url( $akvo_card_options );								// GET BASE URL

			/* PARSING JSON OBJECT OF RSR PROJECT */

			/* COMMON RSR OBJECTS */
			if( isset( $rsr_obj->title ) ){
				$data['title'] = $rsr_obj->title;												/* rsr object title */
			}
			if( isset( $rsr_obj->created_at ) ){
				$data['date'] = date( $akvo_date_format, strtotime($rsr_obj->created_at) );		/* rsr object date */
			}
			if( isset( $rsr_obj->absolute_url ) ){
				$data['link'] = $base_url.$rsr_obj->absolute_url;								/* rsr absolute url */
			}
			/* COMMON RSR OBJECTS */

			/* RSR OBJECT CONTENT */
			if( $type == 'project' && isset( $rsr_obj->project_plan_summary ) ){
				$data['content'] = truncate( $rsr_obj->project_plan_summary, 270 );				/* rsr project summary */
			}
			elseif( $type == 'update' && isset( $rsr_obj->text ) ){
				$data['content'] = truncate( $rsr_obj->text, 270 );								/* rsr updates text */
			}
			/* RSR OBJECT CONTENT */

			/* RSR OBJECT IMAGE */
			if( $type == 'project' && isset( $rsr_obj->current_image ) ){
				$data['img'] = $this->getImageUrl( $rsr_obj->current_image, $base_url );
			}
			elseif( $type == 'update' && isset( $rsr_obj->photo ) ){
				if( isset( $rsr_obj->photo->original ) ){
					$data['img'] = $this->getImageUrl( $rsr_obj->photo->original, $base_url );
				}
				else{
					$data['img'] = $this->getImageUrl(  $rsr_obj->photo, $base_url );
				}
			}
			/* RSR OBJECT IMAGE */

			return $data;

		}

		function getImageUrl( $imageUrl, $baseUrl ){
			if( strpos( $imageUrl, 'https://' ) !== false ) {
    		return $imageUrl;
			}
			return $baseUrl.$imageUrl;
		}


	}

	global $akvo_rsr;
	$akvo_rsr = new AKVO_RSR;
