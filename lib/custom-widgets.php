<?php

	class Akvo_Widgets{
		
		/** Register sidebars */
		function register_sidebar($sidebar){
			register_sidebar([
        		'name' 			=> __( $sidebar['name'], 'akvo-sites' ),
          		'id' 			=> $sidebar['id'],
          		'description' 	=> __($sidebar['desc'], 'akvo-sites' ),
          		'before_widget' => '<div id="%1$s" class="widget %2$s">',
          		'after_widget'  => '</div>',
          		'before_title'  => '<h2 class="widgettitle">',
          		'after_title'   => '</h2>',
    		]);	
		}
		
		function setup_sidebars(){
					
			$sidebars = array(
				array(
					'id'	=> 'sidebar-footer-1',
					'name'	=> 'Footer Col-1',
					'desc'	=> 'Footer Column 1'
				),
				array(
					'id'	=> 'sidebar-footer-2',
					'name'	=> 'Footer Col-2',
					'desc'	=> 'Footer Column 2'
				),
				array(
					'id'	=> 'sidebar-footer-3',
					'name'	=> 'Footer Col-3',
					'desc'	=> 'Footer Column 3'
				),
				array(
					'id'	=> 'sidebar-footer-4',
					'name'	=> 'Footer Last',
					'desc'	=> 'Footer Bottom'
				),
				array(
					'id'	=> 'sub-header',
					'name'	=> 'Sub Header (Left)',
					'desc'	=> 'Widgets on the Header under the logo'
				),
				array(
					'id'	=> 'sub-header-r',
					'name'	=> 'Sub Header (Right)',
					'desc'	=> 'Widgets on the Header under the search bar (Only if the search bar is shown)'
				),
				array(
					'id'	=> 'replace-search',
					'name'	=> 'Replace Search Bar',
					'desc'	=> 'Widgets to be shown when the search bar is hidden'
				),
			);
			
			foreach( $sidebars as $sidebar ){
				$this->register_sidebar($sidebar);
			}
			
		}
		
		function remove_default_widgets() {
     		
     		unregister_widget('WP_Widget_Pages');
     		unregister_widget('WP_Widget_Calendar');
     		unregister_widget('WP_Widget_Archives');
     		unregister_widget('WP_Widget_Links');
     		unregister_widget('WP_Widget_Meta');
     		unregister_widget('WP_Widget_Search');
     		//unregister_widget('WP_Widget_Text');
     		unregister_widget('WP_Widget_Categories');
     		unregister_widget('WP_Widget_Recent_Posts');
     		unregister_widget('WP_Widget_Recent_Comments');
     		unregister_widget('WP_Widget_RSS');
     		unregister_widget('WP_Widget_Tag_Cloud');
     		unregister_widget('WP_Nav_Menu_Widget');
	

	 	}
	 	
	 	function init(){
	 		
	 		$this->setup_sidebars();
	 		$this->remove_default_widgets();
	 		
	 	}
		
	}
	
	add_action('widgets_init', function(){
		$widgets = new Akvo_Widgets;
		$widgets->init();
	});
