<?php get_header();?>
<div class="container" id="main-page-container">
	<div class="row">
		<?php if( have_posts() ):?>
		<div class="col-sm-12">
			<?php while ( have_posts() ) : the_post();?>
				<?php global $post; $post_type = get_post_type( $post );?>
			<!-- POST ELEMENT -->
			<div class="post-item">
				<a href="<?php the_permalink();?>">
					<?php the_post_thumbnail('medium');?>
					<div class="post-desc">
	      		<h3><?php the_title();?></h3>
						<ul class="list-inline">
							<li class='post-date'>Published on <?php echo get_the_date();?></li>
							<li class="post-type"><?php echo $post_type;?></li>
						</ul>
						<div class="text-muted"><?php _e( akvo_get_excerpt( 50 ).'...' );?></div>
					</div>
				</a>
				<div class="clearfix"></div>
      </div><!-- POST ELEMENT -->
			<?php endwhile;?>
			<?php
				if( $wp_query->max_num_pages > 1 ){
					the_posts_pagination( array(
						'mid_size'  => 2,
						'prev_text' => __( 'Previous', 'textdomain' ),
						'next_text' => __( 'Next', 'textdomain' ),
					) );
				}
			?>
		</div><!-- col-sm-12 -->
		<?php else: ?>
			<!-- IF WP QUERY RETURNS NO RESULTS -->
			<div class="alert alert-warning">No results were found.</div>
			<!-- IF WP QUERY RETURNS NO RESULTS -->
    <?php endif;?>
	</div><!-- ROW -->
</div><!-- End of MAIN PAGE CONTAINER -->
<?php get_footer();?>
<style>
	.post-item{
		margin-bottom: 30px;
	}
	.post-item a[href]{
		text-decoration: none;
	}
	.post-item .wp-post-image{
		float: left;
		margin-right: 20px;
		max-width: 300px;
	}
	.post-item .post-desc{
		font-size: 14px;
	}
	.post-item .post-desc .list-inline{
		margin-bottom: 20px;
	}
	.post-item .post-date{
		color: #555;
		font-weight: bold;

	}
	.post-item .post-type{
		border: #333 solid 1px;
		background: #333;
		text-transform: capitalize;
		color: #fff;
	}
	@media( max-width: 768px ){
		.post-item .wp-post-image{ display: none; }
	}

</style>
