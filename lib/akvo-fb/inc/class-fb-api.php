<?php

class FB_API extends SINGLETON{
	
	var $accessToken;
	
	function __construct(){
		
		$this->setAccessToken( get_option( 'fbAccessToken' ) );
		
		add_action( 'wp_ajax_fb_posts_import', array( $this, 'ajaxImport' ) );
		add_action( 'wp_ajax_nopriv_fb_posts_import', array( $this, 'ajaxImport' ) );
		
	}
	
	/* GETTER AND SETTER FUNCTIONS */
	function setAccessToken( $accessToken ){ $this->accessToken = $accessToken; }
	function getAccessToken(){ return $this->accessToken; }
	/* GETTER AND SETTER FUNCTIONS */
	
	/* EXTRACT POST ID FROM THE FACEBOOK ID WHICH IS PREPENDED WITH PAGE ID */
	function extractPostID( $fb_post_id ){
		
		if( strpos( $fb_post_id, '_') !== false ){
			$post_id = explode('_', $fb_post_id );
			if( is_array( $post_id ) && count( $post_id ) > 1 ){
				return $post_id[1];
			}
		}
		return $fb_post_id;
	}
	
	
	function ajaxImport(){
		
		if( isset( $_GET['fb_post_id'] ) ){
			
			//$fb_post_id = $this->extractPostID( $_GET['fb_post_id'] );
			
			$fb_post_id = $_GET['fb_post_id'];
			
			// FACEBOOK DB OBJECT
			$fb_db = FB_DB::getInstance();
			$post_id = $fb_db->importPost( $fb_post_id );
			
			if( $post_id > 0 ){
				echo "Post has been created from FB Post";
			}
			else{
				echo "Post Import did not work";
			}
			
		}
		
		wp_die();
		
	}
	
	
	
	function fbFields(){
		return "id,message,full_picture,picture,link,name,description,type,icon,created_time,from,object_id";
	}
	
	function graphAPI(){
		return "https://graph.facebook.com/v3.2/";
	}
	
	function fbPost( $post_id ){
		
		return $this->callAPI( $post_id."?fields=".$this->fbFields() );
		
	}
	
	function fbPagePosts(){
		
		$jsonData = $this->callAPI( "me/?fields=posts{".$this->fbFields()."}" );
		
		if( isset( $jsonData['posts'] ) ){
			return $jsonData['posts'];
		}
		
		return $jsonData;
		
	}
	
	function callAPI( $partialURL ){
		
		$partialURL .= "&access_token=".$this->getAccessToken();
		
		$transient = get_transient( $partialURL );
		
		if( ! empty( $transient ) ) {
    
			// The function will return here every time after the first time it is run, until the transient expires.
			return $transient;

			// Nope!  We gotta make a call.
		} else {
			
			// APPEND GRAPH API AND ACCESS TOKEN
			$apiLink = $this->graphAPI().$partialURL;
			
			$data = json_decode( file_get_contents( $apiLink ), true );
			
			// Save the API response so we don't have to call again until tomorrow.
			set_transient( $partialURL, $data, DAY_IN_SECONDS );
			
			return $data;
			
		}
		
	}
}

FB_API::getInstance();