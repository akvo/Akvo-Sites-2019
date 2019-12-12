<div class="container" id="main-page-container">
	<div class="row">
		<div class="col-md-12">
		<?php if(have_posts()): while ( have_posts() ) : the_post();?>
			<?php $type = get_post_type();?>
			<div class="row">
				<div class="col-sm-5"><?php the_post_thumbnail();?></div>
				<div class="col-sm-7">
					<h1><?php the_title();?></h1>
					<br>
					<p><?php the_date(); ?></p>
					<p class="text-muted" style="text-transform:capitalize;"><?php _e($type); ?></p>
				</div>
			</div>
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
					<div class='content' style="margin-top: 30px;margin-bottom: 30px;">
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
