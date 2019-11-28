<?php


class FB_DB extends SINGLETON{
	
	private $table;
	
	function __construct(){
		
		// SET TABLE SLUG
		$this->setTable( $this->getTablePrefix() . 'fb_posts' );
		
		$this->create();
		
		add_action( 'admin_init', function(){
			
			
			
			add_action( 'delete_post', array( $this, 'delete_row' ), 10 );
		} );
		
	}
	
	/* GETTER AND SETTER FUNCTIONS */
	function setTable( $table ){ $this->table = $table; }
	function getTable(){ return $this->table; }
	function getTablePrefix(){
		global $wpdb;
		return $wpdb->prefix; 
	}
	
	// WRAPPER AROUND WPDB->GET_CHARSET_COLLATE
	function get_charset_collate(){
		global $wpdb;
		return $wpdb->get_charset_collate();
	}
	
	function getPostsTable(){
		global $wpdb;
		return $wpdb->posts;
	}
	
	// WRAPPER AROUND WPDB->QUERY
	function query( $sql ){
		global $wpdb;
		return $wpdb->query( $sql );
	}
	
	// WRAPPER AROUND WPDB->PREPARE
	function prepare( $query, $args ){
		global $wpdb;
		return $wpdb->prepare( $query, $args );
	}
	
	// WRAPPER AROUND WPDB->INSERT
	function insert( $data ){
		global $wpdb;
		$wpdb->insert( $this->getTable(), $data );
		return $wpdb->insert_id;
	}
	
	// GET SINGLE ROW USING UNIQUE FB POST ID
	function get_row_by_fb( $fb_post ){
		global $wpdb;
		$table = $this->getTable();
		$query = "SELECT * FROM $table WHERE fb_post = $fb_post;"; 
		return $wpdb->get_row( $query );
	}
	
	// BOOLEAN FUNCTION THAT CHECKS IF THE FACEBOOK POST HAS BEEN IMPORTED
	function isFBPostImported( $fb_page_post_id ){
		
		
		$fb_api = FB_API::getInstance();
		$fb_post_id = $fb_api->extractPostID( $fb_page_post_id );
		
		$fbPostDB = $this->get_row_by_fb( $fb_post_id );
		if( $fbPostDB ) return true;
		return false;
	}
	
	// DELETE SPECIFIC ROW by WP POST ID
	function delete_row( $post_id ){
		$table = $this->getTable();
		$sql = "DELETE FROM $table WHERE wp_post = %d;";
		$this->query( $this->prepare( $sql, $post_id ) );
	}
	
	/*
	* CREATE FEATURED IMAGE FROM A URL
	* POST_ID
	* IMAGE_URL
	* IMAGE_NAME
	*/
	function addFeaturedImage( $post_id, $image_url ){
		
		// Add Featured Image to Post
		$upload_dir       = wp_upload_dir(); 														// Set upload folder
		$image_data       = file_get_contents( $image_url ); 										// Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], 'fb'.$post_id.'.jpg' ); 		// Generate unique name
		$filename         = basename( $unique_file_name ); 											// Create image file name

		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		// Create the image  file on the server
		file_put_contents( $file, $image_data );

		// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );

		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

		// Include image.php
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );

		// And finally assign featured image to post
		set_post_thumbnail( $post_id, $attach_id );
		
		
	}
	
	function importPost( $fb_page_post_id ){
		
		// MAKING FB API CALL
		$fb_api = FB_API::getInstance();
			
		$fb_post_id = $fb_api->extractPostID( $fb_page_post_id );
		
		if( ! $this->isFBPostImported( $fb_page_post_id ) ){
			
			$fbPost = $fb_api->fbPost( $fb_page_post_id );
			
			// CREATE ARRAY OF ARGS FROM THE FACEBOOK POST
			$args = array(
				'post_title'	=> isset( $fbPost['name'] ) ? $fbPost['name'] : '',
				'post_content'	=> isset( $fbPost['description'] ) ? $fbPost['description'] : ( isset( $fbPost['message'] ) ? $fbPost['message'] : '' ),
				'post_status'   => 'publish',
				'post_type'    	=> 'Fb_post',
				'post_date'		=> $fbPost['created_time']
			);
			if( !$args['post_title'] && $args['post_content'] ){
				$args['post_title'] = substr( $args['post_content'], 0, 20 );
			}
			//print_r( $args );
			// INSERT WP POST ONLY WHEN THE POST TITLE AND CONTENT ARE FILLED
			if( $args['post_title'] && $args['post_content'] ){
				
				// Insert the post into the database
				$post_id = wp_insert_post( $args );
				
				// INSERT INTO DB FOR CHECK LATER
				$this->insert( array(
					'fb_post'	=> $fb_post_id,
					'wp_post'	=> $post_id
				));
				
				if( isset( $fbPost['full_picture'] ) && $fbPost['full_picture'] ){
					$this->addFeaturedImage( $post_id, $fbPost['full_picture'] );
				}
				
				update_post_meta( $post_id, 'fb_post_id', $fb_post_id );
				
				return $post_id;
			}
			
		}
		
		return 0;
	}
	
	function create(){
		
		$postsTable = $this->getPostsTable();
		
		$table = $this->getTable();
		$charset_collate = $this->get_charset_collate();
			
		$sql = "CREATE TABLE IF NOT EXISTS $table ( 
			ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			fb_post BIGINT(20) NOT NULL,
			wp_post BIGINT(20) NOT NULL,
			PRIMARY KEY(ID)
		) $charset_collate;";
		
		return $this->query( $sql );
	}
	
}

FB_DB::getInstance();