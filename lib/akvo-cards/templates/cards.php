<div id="cards-list" data-target="<?php if( $atts['template'] == 'list' ){_e('.col-md-12');}else{_e('.col');}?>.eq" class="row-col3" data-url="<?php _e($url);?>" data-paged="akvo-paged">
	<?php foreach($data as $item):?>
	<div class="<?php if( $atts['template'] == 'list' ){_e('col-md-12');}else{_e('col');}?> eq">
	<?php

		/* FORM SHORTCODE */

		if( $atts['template'] == 'list' ){ $shortcode = '[akvo-list'; }		// choose shortcode based on the template that has been selected
		else{ $shortcode = '[akvo-card'; }

		foreach($item as $key=>$val){	/* ADD ATTRIBUTES TO THE SHORTCODE */
			$shortcode .= ' '.$key.'="'.$val.'"';
		}

		$shortcode .= ']';					// end shortcode

		/* FORM SHORTCODE */

		echo do_shortcode($shortcode);		// print shortcode
	?>
	</div>
	<?php endforeach;?>
</div>
<?php if( $atts['pagination'] && count( $data ) ): /* lazy loading pagination to be enabled only when it is set in the shortcode */ ?>
<div class="row" style="margin-bottom: 30px;">
	<div class="col-sm-12 text-center">
		<button data-behaviour='ajax-loading' data-list="#cards-list" class="btn btn-default">Load more&nbsp;<i class="fa fa-refresh"></i></button>
	</div>
</div>
<?php endif;?>
