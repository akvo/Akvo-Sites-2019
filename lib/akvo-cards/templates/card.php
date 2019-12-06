<?php
	$akvo_card_options = $this->get_akvo_card_options();

	/* INCASE THE READ MORE TEXT HAS BEEN ADDED BY THE USER */
	if($akvo_card_options && array_key_exists('read_more_text', $akvo_card_options)){
		$atts['read_more_text'] = $akvo_card_options['read_more_text'];
	}
?>
<div class='card <?php _e(self::slugify($atts['type']));?>'>
	<div class='card-image' <?php if($atts['img']):?>style="background-image:url('<?php _e($atts['img']);?>');"<?php endif;?>>
		<div class="card-tag"><?php if($atts['type-text']){_e($atts['type-text']);} else{_e($atts['type']);}?></div>
	</div>
	<h3 class='card-title'>
		<a href="<?php _e($atts['link']);?>"><?php _e($atts['title']);?></a>
	</h3>
	<?php if( isset( $atts['content'] ) && strlen( $atts['content'] ) ):?>
	<div class='card-content text-muted'>
		<?php echo strlen( $atts['content'] );?>
		<?php echo truncate($atts['content'], 130);?>
	</div>
	<?php endif;?>
	<div class="card-date"><?php _e( 'Published on '. $atts['date'] );?></div>
</div>
