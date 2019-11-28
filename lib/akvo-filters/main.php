<?php
	
	
	include "customize-theme.php";
	
	
	class AKVO_FILTERS{
		
		function __construct(){
			
			add_action('pre_get_posts', array( $this, 'query' ), 1 );
		}
			
		function get_option(){
			return get_option('akvo_filter');
		}
		
		function get_template( $post_type ){
			
			$akvo_filters = $this->get_option();
			
			if( is_array( $akvo_filters ) && isset( $akvo_filters[ $post_type ] ) && isset( $akvo_filters[ $post_type ]['template']	) && $akvo_filters[ $post_type ]['template'] ){
				return $akvo_filters[ $post_type ]['template'];
			}
			
			return 'card';
			
		}
		
		function is_term_slug( $slug ){
			
			$terms = array('languages', 'countries', 'map-types', 'map-category', 'types', 'media-category', 'blog-category', 'news-category', 'testimonial-category', 'video-types', 'video-category');
			
			if( in_array( $slug, $terms) ) return true;
			
			return false;
			
		}
		
		function init( $requests ){
			$akvo_filter_label = get_option('akvo_filter_label');
			if($requests){
				foreach($requests as $slug => $arr){
					if(!is_array($arr) && $arr){
						$requests[$slug] = array();
						
						$requests[$slug]['slug'] = $slug;
						
						/* setting the label of the filter */
						if(isset($akvo_filter_label[$slug])){
							$requests[$slug]['label'] = $akvo_filter_label[$slug];
						}
						else{
							$taxonomy = get_taxonomy($slug);
							if($taxonomy){
								$requests[$slug]['label'] = $taxonomy->labels->name;
							}
						}
						
						if(isset($_REQUEST['akvo_'.$slug])){
							$val = $_REQUEST['akvo_'.$slug];
							if($val){
								$requests[$slug]['id'] = $val;
							}
						}
						
					}
					elseif(!$arr){
						unset($requests[$slug]);
					}
				}
			}
			return $requests;
		}
		
		function terms_dropdown( $arr ){	
			$terms = get_terms(array('taxonomy' => $arr['slug'], 'hide_empty' => false));
			if($terms){
				include "templates/dropdown.php";
			}	
		}
		
		/* TO CHECK IF FILTERS ARE ACTIVE FOR THE PARTICULAR POST TYPE */
		function is_active( $post_type ){
			$akvo_filters = $this->get_option();
			if(isset($akvo_filters[$post_type]) and is_array($akvo_filters[$post_type])){
				foreach($akvo_filters[$post_type] as $slug){
					if( $slug && $this->is_term_slug( $slug ) )
						return true;
				}
				
			}
			return false;
		}
		
		/* DISPLAY THE FORM */
		function form( $post_type ){
			//global $post_type;
			$akvo_filters = $this->get_option();
			if(isset($akvo_filters[$post_type])){
				$akvo_filters[$post_type] = $this->init($akvo_filters[$post_type]);
				include "templates/form.php";
			}
		}
		
		/* MANIPULATE QUERY */
		function query( $query ){
			$akvo_filters = $this->get_option();
			
			
			
			/* IF ARRAY FILTERS ARE NOT SELECTED OR THE QUERY IS BEING EXECUTED IN THE BACKEND */
			if( ( ! is_array( $akvo_filters ) ) || ( is_admin() ) ){
				return $query;
			}
			
			/* SET POST TYPE */
			$post_type = '';
			if( isset($query->query['post_type']) && !is_array( $query->query['post_type'] ) ){
				$post_type = $query->query['post_type'];
			}
			
			/* SORTING STARTS */ 
			
			/* DEFAULT SORT BY STICKY POSTS, CAN BE OVERRIDEEN LATER */
			if( $query->is_main_query() && isset( $query->query ) && isset( $query->query['post_type'] ) && ('blog' == $query->query['post_type']) ){
				$query->set('orderby', 'meta_value date');	
				$query->set('meta_key', '_post_extra_boxes_checkbox');	 
				$query->set('order', 'DESC'); 
			}
			
			/* SORT ALPHABETICALLY WHEN ASKED FOR, OTHERWISE DEFAULT IS BY LAST DATE */
			if( $post_type && isset( $akvo_filters[ $post_type ] ) && isset( $akvo_filters[ $post_type ]['sorting'] ) && ( 'alpha' == $akvo_filters[ $post_type ]['sorting'] ) ){
				$query->set('orderby', 'post_title');
				$query->set('order', 'ASC'); 	
			}
			
			/* SORTING GETS OVER */
			
			/* init the request values into the array */
			if( $post_type && isset( $akvo_filters[ $post_type ] ) ){
				$akvo_filters[$post_type] = $this->init($akvo_filters[$post_type]);
			}
			
			/* check if filtering is even required */
			if(!$post_type || !isset($akvo_filters[$post_type]) || !isset($_REQUEST['akvo-search'])){
				return $query;
			}
			
			
			$args = array();
			
			foreach($akvo_filters[$post_type] as $slug => $arr){
				if(isset($arr['id'])){
					$temp_args = array(
						'taxonomy' => $slug,
						'field' => 'id',
						'terms' => array($arr['id'])
					);
					array_push($args, $temp_args);	
				}
			}
			
			
			
			
			$query->set('tax_query', $args);
			return $query;
		}
		
	}
	global $akvo_filters;
	$akvo_filters = new AKVO_FILTERS;
	
	

	
	
	
	
	
	
	
	
	
	