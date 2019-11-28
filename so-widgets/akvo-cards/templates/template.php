<?php
	
	global $akvo_cards;
	
	if( isset( $instance['filter_value'] ) && $instance['filter_value'] && isset( $instance['filter_taxonomy'] )  && $instance['filter_taxonomy'] ){
		
		$instance['filter_by'] = $instance['filter_taxonomy'].":".$instance['filter_value'];
		
	}
	
	echo $akvo_cards->form_shortcode( $instance );
	
?>