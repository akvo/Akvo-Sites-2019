<?php get_header();?>
	<div class="container" id="main-page-container">
		<div class="row">
			<div class="col-md-12">
				<?php if(have_posts()):?>
         			<?php while ( have_posts() ) : the_post();?>
         				<?php the_content();?>
            		<?php endwhile;?>
          		<?php endif;?>
         	</div>
		</div>
	</div><!-- End of Main Body Content -->
<?php get_footer();?>	
	
	