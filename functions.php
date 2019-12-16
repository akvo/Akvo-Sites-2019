<?php

	$sage_includes = [
  		'lib/akvo/main.php',				// Akvo Class
  		'lib/conditional-tag-check.php', 	// ConditionalTagCheck class
  		'lib/config.php',                	// Configuration
  		'lib/extras.php',                	// Custom functions
  		'lib/custom-widgets.php',        	// Custom widgets G!
  		'lib/bootstrap-nav-walker.php',    	// BS Nav walker
  		'plugins/boxes.php',        		// Custom input fields
  		'plugins/related.php',        		// Related posts
  		'lib/color.php',					// COLOR
  		'lib/customize-theme/main.php',		// Library of theme customisation
  		'lib/akvo-cards/main.php',        	// Cards
  		'lib/akvo-carousel/main.php',     	// Carousel
  		'lib/akvo-filters/main.php',      	// Filters for post types
			'lib/policy.php',										// privacy policy
		'lib/akvo-fb/akvo-fb.php'			// Import facebook posts to CPT
	];

	foreach ($sage_includes as $file) {
    	if (!$filepath = locate_template($file)) {
    	  	trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    	}
		require_once $filepath;
	}
	unset($file, $filepath);

	/* ALLOW TO UPLOAD CSV FILES */
	add_filter( 'mime_types', function( $mimes ){
		$mimes['csv'] = 'text/csv';
		return $mimes;

	} );


	// HIDE ADMIN BAR ON THE FRONT END
	add_filter('show_admin_bar', '__return_false');

	/* ADD PREDEFINED LAYOUTS */
	add_filter( 'siteorigin_panels_local_layouts_directories', function( $layout_folders ){
		$layout_folders[] = get_template_directory() . '/lib/layouts';
		return $layout_folders;
	} );

	add_action('siteorigin_widgets_widget_folders', function( $folders ){
		$folders[] = get_template_directory() . '/so-widgets/';
		return $folders;
	});

  	function akvo_featured_img( $post_id ){

		/* GET POST TYPE */
  		$post_type = get_post_type( $post_id );

		/* GET FEATURED IMAGE OF THE POST */
		$img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

		if(!$img && $post_type == 'video'){
    		/* featured image is not selected and the type is video */
        	$img = convertYoutubeImg(get_post_meta( get_the_ID(), '_video_extra_boxes_url', true ));
		}

		return $img;
  	}


	add_action( 'admin_head', function(){
		echo '<style>
 			.siteorigin-panels-builder .so-builder-toolbar .so-switch-to-standard[style] { display: none !important; }
 		</style>';
	} );

	/* REMOVE UNNECESSARY ASSETS -- START */
 	remove_action('wp_head', 'rest_output_link_wp_head', 10);				/* Disable REST API link tag */
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);			/* Disable oEmbed Discovery Links */
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);	/* Disable REST API link in HTTP headers */
 	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );			/* Diable wp emoji */
 	remove_action( 'wp_print_styles', 'print_emoji_styles' );
 	/* REMOVE UNNECESSARY ASSETS -- END */



 	/* ALLOW IFRAME TAGS WITHIN EDITOR */
	add_filter('wp_kses_allowed_html', function( $multisite_tags ){

		$multisite_tags['iframe'] = array(
			'src' 				=> true,
			'width' 			=> true,
			'height' 			=> true,
			'align' 			=> true,
			'class' 			=> true,
			'name' 				=> true,
			'id' 				=> true,
			'frameborder' 		=> true,
			'seamless' 			=> true,
			'srcdoc' 			=> true,
			'sandbox' 			=> true,
			'allowfullscreen' 	=> true,
			'scrolling'			=> true
		);
		return $multisite_tags;

	}, 1);



	function convertYoutubeImg($string) {
  		return preg_replace(
    		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
    		"http://i1.ytimg.com/vi/$2/mqdefault.jpg",
    		$string
  		);
	}

	function convertYoutube($string) {
  		return preg_replace(
      		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
      		"<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
      		$string
    	);
	}

	function truncate($string, $length, $stopanywhere=false) {
    	//truncates a string to a certain char length, stopping on a word if not specified otherwise.
    	if (strlen($string) > $length) {
        	//limit hit!
        	$string = substr($string,0,($length -3));
        	if ($stopanywhere) {
            	//stop anywhere
            	$string .= '...';
        	} else{
            	//stop on a word.
            	$string = substr($string,0,strrpos($string,' ')).'...';
        	}
    	}
    	return $string;
	}

	function show_flickr($id,$handle) {
  		$output = "<style>.embed-container { position: relative; padding-bottom: 56.25%; padding-top: 30px; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style>";
  		$output .= "<div class='flickr'><div class='embed-container'><iframe src='https://www.flickr.com/photos/";
  		$output .= $handle;
  		$output .= "/sets/";
  		$output .= $id;
  		$output .= "/player/' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe></div></div>";
  		return $output;
	}

	function title() {
		if (is_home()) {
    		if (get_option('page_for_posts', true)) {
      			return get_the_title(get_option('page_for_posts', true));
    		}
	    	else {
    	  		return __('Latest Posts', 'sage');
    		}
  		}
	  	elseif (is_archive()) {
    		return get_the_archive_title();
  		}
	  	elseif (is_search()) {
    		return sprintf(__('Search Results for %s', 'sage'), get_search_query());
  		}
	  	elseif (is_404()) {
    		return __('Not Found', 'sage');
	  	}
  		else {
    		return get_the_title();
  		}
	}


	// retrieves the attachment ID from the file URL
	function pn_get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' == $attachment_url )
			return;

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

		}

		return $attachment_id;
	}

	add_action( 'wp_ajax_akvo_fonts', function(){

		global $akvo_fonts;

		$google_fonts = $akvo_fonts->fonts();

		$fonts_arr = array();

		foreach( $google_fonts as $google_font ){
			$fonts_arr[$google_font['name']] = $google_font['name'];
		}

		echo wp_json_encode( $fonts_arr );

		wp_die();
	} );


	add_shortcode( 'akvo_hero_section', function( $atts ){

		$atts = shortcode_atts( array(
			'url' 	=> get_bloginfo('template_directory')."/dist/images/brushrepeat.jpg",
			'title'	=> 'TITLE'
		), $atts, 'akvo_hero_section' );

		_e( "<div class='hero-image' style='background-image:url(".$atts['url']." )'>" );
		_e( "<div class='container'><div class='caption'>" );
		_e( "<h1>".$atts['title']."</h1>");
		_e( "</div></div>" );
		_e( "</div>" );


	});

	add_action( 'network_admin_menu', function(){
		add_menu_page(
        "Export Customize",
        "Export Customize",
        'manage_options',
        'export_customize',
        'network_menu_item'
    	);
	} );

	function network_menu_item(){
		echo "hi";
	}

	//Theme Settings Menu Page
	add_action('admin_menu', function(){
    add_menu_page(
			'Theme Settings',
			'Theme Settings',
			'manage_options',
			'theme_settings',
			'theme_settings_page',
			'dashicons-buddicons-topics'
		);
	}	);


	function theme_settings_page(){
    include( plugin_dir_path(__FILE__).'theme-settings/theme-settings.php' );
	}

	function covert_post_to_akvo_card_shortcode(){

		global $post;

		$post_type = get_post_type( $post );		

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
		if( $img = akvo_featured_img( $post->ID ) ){ $shortcode .= 'img="'.$img.'" '; } 	// FEATURED IMAGE OF THE POST

		$title = get_the_title();
		$shortcode .= 'title="'.$title.'" ';					// POST TITLE
		$shortcode .= 'date="'.get_the_date().'" ';						// POST DATE

		// #477 - removing html tags and shortcodes from the excerpt
		$excerpt = '';
		if( $post->post_excerpt ){ $excerpt = $post->post_excerpt; }
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
		if( $template == 'list' && $post_type == 'media' ){ $shortcode .= 'type="'.$akvo_list->get_media_term_types( $post_id ).'"'; }
		else{ $shortcode .= 'type="'.$post_type.'"'; }

		$shortcode .= "]"; 																		// SHORTCODE END

		return $shortcode;
	}
