<div id="main-carousel" class="carousel slide fp" data-ride="carousel" data-interval="<?php _e($atts['interval']);?>">
	<div class="carousel-inner" role="listbox">
		<ol class="carousel-indicators">
		<?php
			$j = $query_carousel->post_count;
			for ($k = 0 ; $k < $j; $k++){ 
				if ($k == 0) { $active = 'active'; }
				else { $active = ''; }
				echo '<li data-target="#main-carousel" data-slide-to="'.$k.'" class="'.$active.'"></li>';
			}
		?>
		</ol>
		<?php
			$i = 0;
			while ( $query_carousel->have_posts() ) :
				$query_carousel->the_post();
				$linksto = get_post_meta( get_the_ID(), '_carousel_extra_boxes_url', true );
		?>
		<div class="item <?php if(!empty($linksto)) echo 'clickable '; if($i == 0) echo 'active' ; ?>">
			<?php if(!empty($linksto)) echo '<a href="'.$linksto.'" class="boxlink"></a>';?>
			<div class="row">
				<div class="col-sm-6">
					<div class="pic">
						<?php the_post_thumbnail( 'thumb-large' ); ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="text">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php $i++;endwhile; ?>
	</div>
	
</div>
		
