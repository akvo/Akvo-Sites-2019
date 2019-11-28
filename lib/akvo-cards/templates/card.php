<?php 
	$akvo_card_options = $this->get_akvo_card_options();
			
	/* INCASE THE READ MORE TEXT HAS BEEN ADDED BY THE USER */
	if($akvo_card_options && array_key_exists('read_more_text', $akvo_card_options)){
		$atts['read_more_text'] = $akvo_card_options['read_more_text'];
	}
?>
<div class='card <?php _e(self::slugify($atts['type']));?>'>
	<div class='card-header'>
		<h3 class='card-title'>
			<a href="<?php _e($atts['link']);?>"><?php _e($atts['title']);?></a>	
		</h3>
		<div class="card-info <?php _e(self::slugify($atts['type']));?>">
			<span><i class="fa fa-calendar"></i>&nbsp;<?php _e($atts['date']);?></span><span class='pull-right'><?php if($atts['type-text']){_e($atts['type-text']);} else{_e($atts['type']);}?></span>
		</div>
		<div class='card-image' <?php if($atts['img']):?>style="background-image:url('<?php _e($atts['img']);?>');"<?php endif;?>></div>
	</div>
	<div class='card-content'>
		<?php //print_r($atts);?>
		<?php echo truncate($atts['content'], 130);?>
	</div>
	<a class="btn btn-default card-more pull-right" href="<?php _e($atts['link']);?>"><?php _e($atts['read_more_text']);?></a>
</div>	
