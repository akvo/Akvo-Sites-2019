<?php get_header();?>
	<div class="container" id="main-page-container">
		<div class="row">	
			<?php if(have_posts()):?>
         		<?php while ( have_posts() ) : the_post();?>
         		<div class="col-md-4 eq">
        			<?php get_template_part( 'partials/post', 'card' ); ?>			
        		</div>	
            	<?php endwhile;?>
          	<?php endif;?>
        </div>
	</div><!-- End of Main Body Content -->
<?php get_footer();?>	
	
	