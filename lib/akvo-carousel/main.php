<?php
	
	add_shortcode( 'akvo-carousel', function(){
		
		$atts = get_option('sage_carousel_options');
		
		$args = array(
			'post_type' => 'carousel'
		);		
		
		$query_carousel = new WP_Query( $args);
		
		ob_start();
		if ( $query_carousel->have_posts() ){
			include "templates/carousel.php";
		}
		return ob_get_clean();
		
	} );
	
	
	