<?php
	
	require_once('class-list-table.php');
	
	class FB_POSTS_LIST_TABLE extends LIST_TABLE{ 
		
		var $singular_edit_page;
		
		function __construct(){
			
			$this->singular_edit_page = 'fb_posts';
			
			$this->screen = get_current_screen();
			
			parent::__construct( array(
				'singular'  => 'survey',     //singular name of the listed records
				'plural'    => 'surveys',    //plural name of the listed records
				'ajax'      => false 
			) );
		}
		
		function column_default( $item, $column_name ) {
			switch( $column_name ) {
				case 'name':
					$name = isset( $item['name'] ) ? $item['name'] : 'Untitled';
					return $name;
				case 'desc':
					$desc = isset( $item['description'] ) ? $item['description'] : $item['message'];
					return $desc;
				case 'post-date':
					$post_date = strtotime( $item['created_time'] );
					return date("D, d-m-Y", $post_date);
				case 'image':
					
					$img = "";
					if( isset( $item['picture'] ) && $item['picture'] ){
						$img = "<img width='100' src='".$item['picture']."' />";
					}
					return $img;
				default:
					return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
			}
		}
		
		/**
		* Decide which columns to activate the sorting functionality on
		* @return array $sortable, the array of columns that can be sorted by the user
		*/
		public function get_sortable_columns() {
			$sortable_columns = array(
				'survey'  => array('survey',true),
			); 
			return $sortable_columns;
		}
		
		function get_columns(){
			$columns = array(
				'cb'		=> '<input type="checkbox" />',
				'name' 		=> 'Title',
				'image'		=> 'Image',
				'post-date'	=> 'Date',
				'desc'    	=> 'Description',
				
			);
			return $columns;
		}
		
		function column_cb( $item ) {
			
			$fb_db = FB_DB::getInstance();
			
			if( $fb_db->isFBPostImported( $item['id'] ) ){
				return '<input type="checkbox" disabled="disabled" name="fb[]" value="'.$item['id'].'" />';
			}
			return '<input type="checkbox" name="fb[]" value="'.$item['id'].'" />';
		}
		
		function prepare_items() {
			$columns = $this->get_columns();
			
			$hidden = $this->get_hidden_columns();
			
			$sortable = $this->get_sortable_columns();
			
			$this->_column_headers = array($columns, $hidden, $sortable);
			
			$per_page = 10;
			$page = isset( $_GET['paged'] ) ? $_GET['paged'] : 1;
			
			$fb = FB_API::getInstance();
			$data = $fb->fbPagePosts();
			$this->items = $data['data'];
			
			//print_r( $this->items );
			
			//$survey_db = SPACE_DB_SURVEY::getInstance();
			//$data = $survey_db->results( $page, $per_page );
			//$this->items = $data['results'];
			
			/*
			$this->set_pagination_args( array(
				'total_items'	=> 120,
				'per_page'		=> $per_page
			) );
			*/
			
			
		}
		
		// Setup Hidden columns and return them
		public function get_hidden_columns(){
			return array();
		}
		/*
		function column_survey($item) {
			
			$actions = array(
				'edit'	=> sprintf('<a href="?page=%s&ID=%s">Edit</a>', $this->singular_edit_page, $item->ID ),
				'trash'	=> sprintf('<a href="?page=%s&action=trash&ID=%s">Trash</a>', $this->singular_edit_page, $item->ID ),
			);
			return sprintf('%1$s %2$s', $item['name'], $this->row_actions( $actions ) );
		}
		*/
		
		function get_bulk_actions(){
			$actions = array(
				'import'    => 'Import'
			);
			return $actions;
		}
		public function process_bulk_action(){
			if ('import' === $this->current_action()) {
				
				if( isset( $_POST['fb'] ) && is_array( $_POST['fb'] ) ){
					
					foreach( $_POST['fb'] as $fb_id ){
						
						$fb_db = FB_DB::getInstance();
						$post_id = $fb_db->importPost( $fb_id );
						
					}
					
				}
				
				
				
			}
		}
		
		function get_primary_column_name() {
			return 'ID';
		}
		
		
	}