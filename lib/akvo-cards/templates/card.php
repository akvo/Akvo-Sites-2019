<?php
	$akvo_card_options = $this->get_akvo_card_options();

	/* INCASE THE READ MORE TEXT HAS BEEN ADDED BY THE USER */
	if($akvo_card_options && array_key_exists('read_more_text', $akvo_card_options)){
		$atts['read_more_text'] = $akvo_card_options['read_more_text'];
	}


?>
<div class='card <?php _e(self::slugify($atts['type']));?>'>
	<a class='card-link-parent' href="<?php _e($atts['link']);?>">
		<div class='card-image' <?php if($atts['img']):?>style="background-image:url('<?php _e($atts['img']);?>');"<?php endif;?>>
			<div class="card-tag"><?php if($atts['type-text']){_e($atts['type-text']);} else{_e($atts['type']);}?></div>
		</div>
		<div class='card-content'>
			<h3 class='card-title'>
				<?php _e( $atts['title'] );?>
			</h3>
			<div class="card-excerpt text-muted"><?php _e( $this->trimmed_text($atts['content'], 270 ) );?></div>
		</div>
	</a>
	<div class="card-date"><?php _e( 'Published on '. $atts['date'] );?></div>
</div>
