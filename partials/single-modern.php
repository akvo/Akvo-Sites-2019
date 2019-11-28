<div class='container-fluid' id="main-page-container">
	<?php if( have_posts() ): while( have_posts() ) : the_post();?>
	<?php
		
		$url = get_bloginfo('template_directory')."/dist/images/brushrepeat.jpg";
		
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $image_size );
		if( is_array( $thumbnail ) ){
			$url = $thumbnail[0];
		}
		
		echo do_shortcode("[akvo_hero_section url='".$url."' title='".get_the_title()."']");
	
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class='post-content'>
					<div class='author-info'>Written by <?php the_author();?> on <?php the_date();?></div>
					<?php the_content();?>
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile; endif; ?>
</div>
