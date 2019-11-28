<div class='list-widget'>
	<div class="row">
		<div class='col-sm-6'>
			<h3 class='list-title' style="margin-top: 0;"><a href="<?php _e($atts['link']);?>"><?php _e($atts['title']);?></a></h3>
			<p class="small"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php _e($atts['date']);?></p>
		</div>
		<div class='col-sm-6'>
			<div style="min-height: 50px;"><?php echo truncate($atts['content'], 130);?></div>
			<?php
				
				$atts['types'] = array();
				
				if( $atts['type'] == 'media' ){			/* ONLY FOR MEDIA POSTS, GET EXTRA TYPES FROM TAXONOMY */
					global $akvo_list;
					$atts['types'] = $akvo_list->get_media_term_types( $atts['post_id'] );	
				}
				else{
					$atts['types'] = $atts['type'];
				}
			?>
			<?php if( count( $atts['types'] ) && is_array( $atts['types'] ) ):?>
			<ul class="small list-inline">
				<?php foreach( $atts['types'] as $type ): ?>
				<li><span class='badge'><?php _e( $type );?></span></li>
				<?php endforeach;?>
			</ul>
			<?php endif; ?>
		</div>
	</div>	
</div>	

