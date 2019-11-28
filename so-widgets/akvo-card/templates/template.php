<?php
	
	global $akvo_card;
	
	$label = $instance['type'].'-'.$instance['rsr-id'];
	$instance['offset'] = $akvo_card->get_counter( $label );
	
	$url = $akvo_card->get_ajax_url('akvo_card', $instance, array('panels_info', '_sow_form_id', '_sow_form_timestamp'));
	
	echo "<div data-behaviour='reload-html' data-url='".$url."'></div>";
	
?>