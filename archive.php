<?php get_header();?>
<?php

	global $post, $post_id, $akvo_filters, $akvo_list, $wp_query;					// GLOBAL PARAMTERS

	$post_type = get_post_type( $post );																	// GET POST TYPE

	$template = $akvo_filters->get_template( $post_type );								// GET TEMPLATE SELECTED FROM THE CUSTOMISE SECTION

	/* COLUMN CLASS */
	$col_class = 'col';
	if( $template == 'list' ){ $col_class = 'col-md-12'; }

	$archives_class = 'col-md-12';
	if( $akvo_filters->is_active( $post_type ) ){ $archives_class = 'col-md-9'; }
	/* END OF COLUMN CLASS */

?>
	<div class="container" id="main-page-container">
		<div class="row">

			<!-- FILTER FORM STARTS HERE -->
			<?php  if( $akvo_filters->is_active( $post_type ) ) :?>
			<div class="col-md-3">
				<?php $akvo_filters->form( $post_type );?>
			</div>
			<?php endif;  ?>
			<!-- FILTER FORM ENDS HERE -->

			<div id="archives-container" class="<?php _e( $archives_class );?>">

			<?php if( have_posts() ):?>

				<div id="archives-list" class="row-col3" data-target="<?php _e( '#archives-list .'.$col_class.'.eq' );?>">

				<?php while ( have_posts() ) : the_post();?>

					<!-- POST ELEMENT -->
					<div class="<?php _e( $col_class." eq" );?> ">
         	<?php

						/* UPDATE STICKY OPTION TO OFF THAT DOES NOT HAVE THE POST META YET - what's the significance? */
						if( 'blog' == $post->post_type ){
							$sticky = get_post_meta( $post->ID, '_post_extra_boxes_checkbox', true ); 							// GET STICKY CUSTOM FIELD
							if( !$sticky ){ update_post_meta( $post->ID, '_post_extra_boxes_checkbox', 'off' ); }
						}


						/**
						* WHILE ITERATING THROUGH EACH POST, CREATE THE [AKVO _CARD] SHORTCODE TO DISPLAYS THE POST IN THE CARD FORMAT
						* SHORTCODE START
						*/
						if( $template == 'list' ){ $shortcode = '[akvo-list '; }
						else{ $shortcode = '[akvo-card '; }

							//$img = akvo_featured_img( $post_id );
        			if( $img = akvo_featured_img( $post_id ) ){ $shortcode .= 'img="'.$img.'" '; } 	// FEATURED IMAGE OF THE POST

							$title = get_the_title();
							$shortcode .= 'title="'.$title.'" ';					// POST TITLE
        			$shortcode .= 'date="'.get_the_date().'" ';						// POST DATE

							// #477 - removing html tags and shortcodes from the excerpt
							$excerpt = '';
							if( $post->post_excerpt ){
								$excerpt = $post->post_excerpt;
							}
							else{
								$text = get_the_content();
								$text = strip_shortcodes( $text );
								$text = excerpt_remove_blocks( $text );
								$text = apply_filters( 'the_content', $text );
        				$text = str_replace( ']]>', ']]&gt;', $text );
								$text = str_replace( ']', '', $text );
								$text = str_replace( '[', '', $text );
								$excerpt = wp_trim_words( $text, 270, '' );
							}

							//echo $excerpt;

							$shortcode .= 'content="'.$excerpt.'" ';			// POST EXCERPT
        			$shortcode .= 'link="'.get_the_permalink().'" ';			// POST PERMALINK

							/* UPDATE TYPES PARAMETER IN SHORTCODE */
							if( $template == 'list' && $post_type == 'media' ){
								$shortcode .= 'type="'.$akvo_list->get_media_term_types( $post_id ).'"';
							}
							else{
								$shortcode .= 'type="'.$post_type.'"';
							}

							$shortcode .= "]"; 																		// SHORTCODE END

							//echo $shortcode;

							echo do_shortcode( $shortcode );											// PRINT SHORTCODE
         		?>
         		</div><!-- POST ELEMENT -->
					<?php endwhile;?>
					</div> <!-- ARCHIVES LIST -->

					<?php if( $wp_query->max_num_pages > 1 ): ?>

						<?php
							the_posts_pagination( array(
    						'mid_size'  => 2,
    						'prev_text' => __( 'Previous', 'textdomain' ),
    						'next_text' => __( 'Next', 'textdomain' ),
							) );
						?>

						<?php /*

         	<!-- PAGINATION STARTS HERE -->
					<div class="row" style="margin-bottom: 30px;">
						<div class="col-sm-12 text-center">
							<button data-behaviour='ajax-loading' data-list="#archives-list" class="btn btn-default">Load more&nbsp;<i class="fa fa-refresh"></i></button>
						</div>
					</div>
					<!-- PAGINATION ENDS HERE -->
					*/
					?>
					<?php endif; ?>
			<?php else: ?>
				<!-- IF WP QUERY RETURNS NO RESULTS -->
				<div class="alert alert-warning">No results were found.</div>
				<!-- IF WP QUERY RETURNS NO RESULTS -->
      <?php endif;?>
			</div> <!-- ARCHIVES CONTAINER -->
		</div><!-- ROW -->
	</div><!-- End of MAIN PAGE CONTAINER -->
<?php get_footer();?>
