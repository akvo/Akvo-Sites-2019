<section>
	<?php

		if( $atts['template'] == 'card-featured' && count( $data ) ){

			echo '<div class="row-col1" style="margin-bottom:30px;"><div class="col">';

			$shortcode = '[akvo-card';

			foreach($data[0] as $key=>$val){	/* ADD ATTRIBUTES TO THE SHORTCODE */
				$shortcode .= ' '.$key.'="'.$val.'"';
			}

			$shortcode .= ']';					// end shortcode

			echo do_shortcode($shortcode);		// print shortcode

			echo '</div></div>';

			unset( $data[0] );
		}

	?>
	<div id="cards-list" data-target="<?php if( $atts['template'] == 'list' ){_e('.col-md-12');}else{_e('.col');}?>.eq" class="row-col3 cards-list" data-url="<?php _e($url);?>" data-paged="akvo-paged">
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
		<?php if( 'lazy' == $atts['pagination_style'] ):?>
		<div class="row" style="margin-bottom: 30px;">
			<div class="col-sm-12 text-center">
				<button data-behaviour='ajax-loading' data-list="#cards-list" class="btn btn-default">Load more&nbsp;<i class="fa fa-refresh"></i></button>
			</div>
		</div>
		<?php else:?>
			<?php $this->pagination( $this->get_count_based_on_type( $atts ), $atts['posts_per_page'], $atts['page'] );?>
		<?php endif;?>
	<?php endif;?>
</section>
