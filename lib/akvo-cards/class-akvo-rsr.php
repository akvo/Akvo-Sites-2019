<?php

	class AKVO_RSR{

		function __construct(){
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

		function get_data_feed_response( $atts, $api_key = false ){

			$data_feed_id = $atts['rsr-id'];

			$url = $this->get_data_feed_url( $data_feed_id );
			$url .= "&limit=" . $atts['posts_per_page']."&page=" . $atts['page'];

			$json_key = 'df'.$data_feed_id;
			$_json_expiration = 60 * 1; // 5 minutes
			$key = $json_key . md5( $url );

			$data = array();
			if ( ! ( $data = get_transient($key) ) ) {

				$args = array( 'headers' => array() );

				if( $api_key ){
					$args['headers'] = array(
						'Authorization' => 'Token ' . $api_key,
					);
				}

				$request = wp_remote_get( $url, $args );

				if( ! is_wp_error( $request ) ) {
					$body = wp_remote_retrieve_body( $request );

					// MORE OF YOUR CODE HERE
					$data = json_decode( $body );

					// IF IT IS NEW, SET THE TRANSIENT FOR NEXT TIME
					set_transient($key, $data, $_json_expiration);
				}
				else{
					// DISPLAYING THE ERROR
					print_r($request);
				}

			}

			return $data;

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
				$data['content'] = truncate( $rsr_obj->project_plan_summary, 130 );				/* rsr project summary */
			}
			elseif( $type == 'update' && isset( $rsr_obj->text ) ){
				$data['content'] = truncate( $rsr_obj->text, 130 );								/* rsr updates text */
			}
			/* RSR OBJECT CONTENT */

			/* RSR OBJECT IMAGE */
			if( $type == 'project' && isset( $rsr_obj->current_image ) ){
				$data['img'] = $base_url.$rsr_obj->current_image;
			}
			elseif( $type == 'update' && isset( $rsr_obj->photo ) ){
				if( isset( $rsr_obj->photo->original ) ){
					$data['img'] = $base_url.$rsr_obj->photo->original;
				}
				else{
					$data['img'] = $base_url.$rsr_obj->photo;
				}
			}
			/* RSR OBJECT IMAGE */

			return $data;

		}


	}

	global $akvo_rsr;
	$akvo_rsr = new AKVO_RSR;
