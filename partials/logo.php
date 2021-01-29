<?php


	$home_url = home_url('/');


	/*
	* SPECIAL USE CASE FOR AFRIALLIANCE AS THEY USE WPML
	*
	if ( is_multisite() ) {
		$current_site = get_current_site();
		if( ICL_LANGUAGE_CODE == 'fr' && isset($current_site->domain) && $current_site->domain == "afrialliance.org" ) {
			$home_url = 'http://afrialliance.org/';
		}
	}
	*/
?>



<a class="brand" href="<?php _e($home_url); ?>">
<?php if ( get_theme_mod( 'akvo_logo' ) ) :

	/* set the image url */
	$image_url = esc_url( get_theme_mod( 'akvo_logo' ) );

	/* store the image ID in a var */
	$image_id = pn_get_attachment_id_from_url($image_url);


	if( $image_id ){

		// echo $image_id;

		$akvo_logo_size = get_theme_mod( 'akvo_logo_size' ) ? 'large' : 'medium';

		// echo $akvo_logo_size;

    	/* retrieve the thumbnail size of our image */
		$image_thumb = wp_get_attachment_image_src($image_id, $akvo_logo_size);

		if( $image_thumb ){

			$image_url = $image_thumb[0];

		}

	}





?>
	<img src='<?php echo $image_url; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
<?php else : ?>
	<img src="<?php bloginfo('template_url'); ?>/dist/images/logo-sample.svg">
<?php endif; ?>
	<p><?php bloginfo('description');?></p>
</a>

<?php if ( is_active_sidebar( 'sub-header' ) ) : ?>
<div id="sub-header" class="clearfix"><?php dynamic_sidebar( 'sub-header' ); ?></div>
<?php endif; ?>
