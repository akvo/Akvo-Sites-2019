<div class="container" id="main-page-container">
	<div class="row">
		<div class="col-md-12">
		<?php if(have_posts()):?>
			 <?php while ( have_posts() ) : the_post();?>
				<?php $type = get_post_type();?>
				<article>
				<?php
					/* SHOW YOUTUBE PICTURE */
					if (in_array($type, array('video','testimonial'), true )) :
						$url = convertYoutube(get_post_meta( get_the_ID(), '_video_extra_boxes_url', true ));
				?>
					<div class='embed-container'>
						<?php echo $url; ?>
					</div>
				<?php endif;?>
					<header><h3 class='text-center'><?php the_title();?></h3></header>
					<div class="meta">
						<div class="row">
							<div class="col-lg-12">
								<time class="updated date" datetime="<?php the_time('c'); ?>"><?php the_date(); ?></time>
								<span <?php post_class('type'); ?>><?php _e($type); ?></span>
								<div class="social">
									<?php if (function_exists('synved_social_share_markup')) echo synved_social_share_markup(); ?>
								</div>
							</div>
						</div>
					</div>
					<div class='content'>
						<?php the_content();?>
						<?php 
							if( $type == 'media' ){	
								get_template_part('partials/content', 'media');
							}
							elseif( $type == 'fb_post' ){
								get_template_part('partials/content', 'fb');
							}
						?>
					</div>	
					<div class="clearfix"></div>
					<?php if ($type == 'post' || $type == 'blog' || $type == 'news'){
						comments_template(); 
					} ?>
				</article>
			<?php endwhile;?>
		<?php endif;?>
		</div>
	</div>
</div><!-- End of Main Body Content -->