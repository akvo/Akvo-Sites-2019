<?php
	
	add_action( 'customize_register', function( $wp_customize ){
		
		global $akvo_customize;
		
		// ADD PANEL
		$akvo_customize->panel( $wp_customize, 'akvo_filter_panel', 'Akvo Custom Post Types' );
		
		/* LABELS SECTION */
		$akvo_customize->section( $wp_customize, 'akvo_filter_panel', 'akvo_filter_section', 'Labels', '');
		
		$text_el = array(
			'akvo_filter_btn_text' => array(
				'default' 	=> 'Apply Filters',
				'label' 	=> 'Text for apply filters button:',
			),
			'akvo_filter_default_text' => array(
				'default' 	=> 'Not Selected',
				'label' 	=> 'Text for filter - Not Selected:',
			),
		);
		
		foreach( $text_el as $id => $el){
			$akvo_customize->text( $wp_customize, 'akvo_filter_section', $id, $el['label'], $el['default']);	
		}
		
		
		$slugs = array('languages', 'countries', 'map-types', 'map-category', 'types', 'media-category', 'blog-category', 'news-category', 'testimonial-category', 'video-types', 'video-category');
		foreach($slugs as $slug){ /* LABEL FOR SLUGS */
			$akvo_customize->text( $wp_customize, 'akvo_filter_section', 'akvo_filter_label['.$slug.']', 'Label for '.$slug, '');	
		}
		/* END OF LABELS SECTION */
		
		
		
		$post_types = array(
			'map' 			=> array('languages', 'countries', 'map-types', 'map-category'), 
			'media'			=> array('languages', 'countries', 'types', 'media-category'), 
			'blog'			=> array('languages', 'countries', 'blog-category'), 
			'news'  		=> array('languages', 'countries', 'news-category'), 
			'testimonial'	=> array('languages', 'countries', 'testimonial-category'), 
			'video'			=> array('languages', 'countries', 'video-types', 'video-category')
		);
		
		/** LIST OF TEMPLATES */ 
      	$template_arr = array(
      		'card'	=> 'Card (Columns)',
      		'list'	=> 'List (Vertical)'
      	);
		
		$sorting_arr = array(
			'latest' 	=> 'Latest',
			'alpha' 	=> 'Alphabetically',
		);
		
		foreach($post_types as $post_type => $slugs){
			
			$section_id = 'akvo_filter_'.$post_type.'section';
			
			
			/* EACH SEPERATE SECTION FOR POST TYPE */
			$akvo_customize->section( $wp_customize, 'akvo_filter_panel', $section_id, 'Filters for '.$post_type, '');
			
			foreach($slugs as $slug){
				// FILTER OPTION FOR EACH CUSTOM POST TYPE				
				$akvo_customize->checkbox( $wp_customize, $section_id, 'akvo_filter['.$post_type.']['.$slug.']', "Enable ".$slug." for ".$post_type );
			}
			
			$akvo_customize->dropdown( $wp_customize, $section_id, 'akvo_filter['.$post_type.'][template]', 'Select Template', 'card', $template_arr );
			
			$akvo_customize->dropdown( $wp_customize, $section_id, 'akvo_filter['.$post_type.'][sorting]', 'Select Sorting', 'latest', $sorting_arr );
			
		}
		
		
		
      	
		
	} );
	