<?php get_header();?>
	<?php
		
		// BASED ON THE HEADER, CHOOSE THE THEME FOR SINGLE POST
		
		$header_option = get_option('sage_header_options');
		
		$header_type = 'header1';
		if( isset( $header_option['header_type'] ) ){
			$header_type = $header_option['header_type'];
		}
		
		if( $header_type == 'header4' || $header_type == 'header5' ){
			get_template_part('partials/single', 'modern');
		}
		else{
			get_template_part('partials/single', 'default');
		}
		 
		
	?>	
<?php get_footer();?>	
	
	