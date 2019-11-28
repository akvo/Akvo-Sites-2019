<?php
	
	global $akvo_widgets_template;
	
	$shortcode_str = "[akvo_hero_section";
	
	if( isset( $instance['image'] ) && $instance['image'] ){
		$shortcode_str .= " url='".$akvo_widgets_template->get_image_url( $instance['image'] )."'";
	}
	
	if( isset( $instance['title'] ) ){
		$shortcode_str .= " title='".$instance['title']."'";
	}
	
	$shortcode_str .= "]";
	
	
	
	echo do_shortcode( $shortcode_str );
	
?>