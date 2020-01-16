<?php

	class AKVO{

		public $header_options;
		public $search_flag = true;
		public $header_container_class = 'container';

		public $text_domain = 'sage';

		public $options = array();

		public $custom_taxonomies = array();

		public $custom_post_types = array();


		function __construct(){

			$this->init_header_options();

			$this->options = get_option('akvo');

			add_filter( 'body_class', function( $classes ){

				$header_option = get_option('sage_header_options');
				if( isset($header_option['header_type']) ){
					$header_type = $header_option['header_type'];
					$classes[] = 'body-'.$header_type;
				}

				return $classes;
			});

			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 100 );

			add_action( 'init', array( $this, 'custom_posts' ) );

			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

			add_action( 'excerpt_more', array( $this, 'excerpt_more' ) );

			add_action( 'wp_head', array( $this, 'css' ) );

			$this->custom_taxonomies = array(
				'languages'	=> array(
					'plural_name'	=> 'Languages',
					'singular_name'	=> 'Language',
					'post_type'		=> array('map', 'media', 'blog', 'news', 'video', 'testimonial')
				),
				'countries'	=> array(
					'plural_name'	=> 'Locations',
					'singular_name'	=> 'Location',
					'post_type'		=> array('map', 'media', 'blog', 'news', 'video', 'testimonial')
				),
				'types'	=> array(
					'plural_name'	=> 'Types',
					'singular_name'	=> 'Type',
					'post_type'		=> array('media')
				),
				'map-types' => array(
					'plural_name' 	=> 'Types',
					'singular_name'	=> 'Type',
					'post_type'		=> array('map')
				),
				'video-types' => array(
					'plural_name'	=> 'Types',
					'singular_name'	=> 'Type',
					'post_type'		=> array('video')
				),
				'media-category' => array(
					'plural_name' 	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('media')
				),
				'map-category' => array(
					'plural_name'	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('map')
				),
				'blog-category' => array(
					'plural_name'	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('blog')
				),
				'news-category' => array(
					'plural_name'	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('news')
				),
				'video-category' => array(
					'plural_name'	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('video')
				),
				'testimonial-category' => array(
					'plural_name'	=> 'Categories',
					'singular_name'	=> 'Category',
					'post_type'		=> array('testimonial')
				)
			);

			$this->custom_post_types = array(

				'blog' => array(
					'plural_name' 	=> 'Blog posts',
					'singular_name'	=> 'Blog post',
					'icon'			=> 'dashicons-calendar-alt'
				),
				'news' => array(
					'plural_name' 	=> 'News',
					'singular_name'	=> 'News',
					'icon'			=> 'dashicons-format-aside'
				),
				'video' => array(
					'plural_name' 	=> 'Videos',
					'singular_name'	=> 'Video',
					'icon'			=> 'dashicons-media-video'
				),
				'media' => array(
					'plural_name' 	=> 'Media Library',
					'singular_name'	=> 'Media Item',
					'icon'			=> 'dashicons-book'
				),
				'testimonial' => array(
					'plural_name' 	=> 'Testimonials',
					'singular_name'	=> 'Testimonial',
					'icon'			=> 'dashicons-megaphone'
				),
				'map' => array(
					'plural_name' 	=> 'Maps',
					'singular_name'	=> 'Map',
					'icon'			=> 'dashicons-location-alt'
				),
				'carousel' => array(
					'plural_name' 	=> 'Carousel',
					'singular_name'	=> 'Carousel Slide',
					'icon'			=> 'dashicons-images-alt'
				),
				'flow' => array(
					'plural_name' 	=> 'Akvo Flow',
					'singular_name'	=> 'Flow item',
					'icon'			=> 'dashicons-welcome-widgets-menus'
				),

			);
		}

		function get_option(){
			return $this->options;
		}

		function css(){
			echo "<style type=\"text/css\">\r\n";
			do_action('akvo_sites_css');
			echo "<!-- OVERRIDING STYLES FROM CUSTOMIZE -->\r\n</style>\r\n";
		}

		function init_header_options(){

			// get header options
			$this->header_options = get_option('sage_header_options');

			if( ! is_array( $this->header_options ) ){

				$this->header_options = array();

			}

			// get search is enabled/disabled
			if($this->header_options && isset($this->header_options['hide_search']) && $this->header_options['hide_search']){
				$this->search_flag = false;
			}

			if($this->header_options && !isset($this->header_options['search_text'])){

				$this->header_options['search_text'] = "Search " . get_bloginfo("name");

			}

			if( $this->header_options && isset($this->header_options['header_stretch']) && $this->header_options['header_stretch'] ){
				$this->header_container_class = 'container-fluid';
			}

		}

		function after_setup_theme(){

			/* Make theme available for translation. Community translations can be found at https://github.com/roots/sage-translations */
			load_theme_textdomain($this->text_domain, get_template_directory() . '/lang');

			/* Enable plugins to manage the document title. http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag */
			add_theme_support('title-tag');

			/* Register wp_nav_menu() menus. http://codex.wordpress.org/Function_Reference/register_nav_menus */
  			register_nav_menus(['primary_navigation' => __('Primary Navigation', $this->text_domain)]);

			/* Add post thumbnails */
			add_theme_support('post-thumbnails');

			/* Add post formats */
  			add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

			/* Add HTML5 markup for captions */
			add_theme_support('html5', ['caption', 'comment-form', 'comment-list']);

			/* CUSTOM IMAGE SIZES */
			add_image_size( 'thumb-small', 224, 126, true ); // Hard crop to exact dimensions (crops sides or top and bottom)
    		add_image_size( 'thumb-medium', 320, 180, true );
    		add_image_size( 'thumb-large', 640, 360, true );
    		add_image_size( 'thumb-xlarge', 960, 540, true );
		}


		/* CUSTOM POST TYPES AND TAXONOMIES */
		function custom_posts(){

			foreach( $this->custom_taxonomies as $slug => $tax ){
				$this->register_taxonomy( $slug, $tax['plural_name'], $tax['singular_name'], $tax['post_type'] );
			}

			foreach( $this->custom_post_types as $slug => $post_type ){
				$this->register_post_type( $slug, $post_type['plural_name'], $post_type['singular_name'], $post_type['icon'] );
			}

		}

		function load_scripts(){

			/* FONTAWESOME STYLE */
			wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, null);

			/* AKVO SITES STYLESHEET */
			wp_enqueue_style( 'sage_css', get_template_directory_uri().'/dist/styles/main.css', false, time() );

			wp_enqueue_style( 'sow_css', get_template_directory_uri().'/dist/styles/sow.css', false, time() );

			/* COMMENTS REPLY JS */
			if (is_single() && comments_open() && get_option('thread_comments')) { wp_enqueue_script('comment-reply'); }

			/* BOOTSTRAP JS */
			wp_enqueue_script('bootstrap_js', get_template_directory_uri().'/dist/scripts/bootstrap.min.js', ['jquery'], '1.0.1', true);

			/* CUSTOM SCRIPT JS */
			wp_enqueue_script('akvo_js', get_template_directory_uri().'/dist/scripts/main.js', ['jquery'], "1.0.6", true);
		}


		function register_taxonomy($slug, $plural_label, $singular_label, $post_types){

			$args = array(
				'labels' => array(
					'name'                       => _x( $plural_label, 'Taxonomy General Name', $this->text_domain ),
					'singular_name'              => _x( $singular_label, 'Taxonomy Singular Name', $this->text_domain ),
					'menu_name'                  => __( $plural_label, $this->text_domain ),
					'all_items'                  => __( 'All Items', $this->text_domain ),
					'parent_item'                => __( 'Parent Item', $this->text_domain ),
					'parent_item_colon'          => __( 'Parent Item:', $this->text_domain ),
					'new_item_name'              => __( 'New Item Name', $this->text_domain ),
					'add_new_item'               => __( 'Add New Item', $this->text_domain ),
					'edit_item'                  => __( 'Edit Item', $this->text_domain ),
					'update_item'                => __( 'Update Item', $this->text_domain ),
					'view_item'                  => __( 'View Item', $this->text_domain ),
					'separate_items_with_commas' => __( 'Separate items with commas', $this->text_domain ),
					'add_or_remove_items'        => __( 'Add or remove items', $this->text_domain ),
					'choose_from_most_used'      => __( 'Choose from the most used', $this->text_domain ),
					'popular_items'              => __( 'Popular Items', $this->text_domain ),
					'search_items'               => __( 'Search Items', $this->text_domain ),
					'not_found'                  => __( 'Not Found', $this->text_domain ),
				),
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
			);
			register_taxonomy($slug, $post_types, $args );
		}

		function register_post_type($slug, $plural_label, $singular_label, $menu_icon, $exclude_from_search = false){

			register_post_type($slug, array(
      			'labels' => array('name' => __( $plural_label ), 'singular_name' => __( $singular_label )),
      			'public' 				=> true,
      			'has_archive' 			=> true,
      			'menu_position' 		=> 20,
      			'menu_icon' 			=> $menu_icon,
      			'exclude_from_search' 	=> $exclude_from_search,
      			'supports' 				=> array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    		));

		}

		function excerpt_more(){
			return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', $this->text_domain) . '</a>';
		}

		/* SLUGIFY TEXT */
		function slugify($text){

  			$text = preg_replace('~[^\pL\d]+~u', '-', $text);		// replace non letter or digits by -
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);	// transliterate
			$text = preg_replace('~[^-\w]+~', '', $text);			// remove unwanted characters
			$text = trim($text, '-');								// trim
			$text = preg_replace('~-+~', '-', $text);				// remove duplicate -
			$text = strtolower($text);								// lowercase

			if (empty($text)) {return 'n-a';}
			return $text;
		}

		/* PRINT STYLES FOR EACH TIME */
		function print_css_item( $item, $options ){
			$css = '';
			if( isset( $item['styles'] ) ){

				foreach( $item['styles'] as $style => $val ){
					if( isset( $options[ $val ] ) && $options[ $val ] ){

						$css .= $style .":"; //.$options[ $val ].";";

						if( 'font-family' == $style ){
							$css .= "'".$options[ $val ]."'";
						}
						elseif( 'background-image' == $style ){
							$css .= "url('".$options[ $val ]."')";
						}
						else{
							$css .= $options[ $val ];
						}

						$css .= ";";

					}
				}
			}

			return $css;
		}

		/* PRINT CSS FOR SELECTORS */
		function print_css( $options, $items, $media_query = false ){

			/* CHECK IF OPTIONS EXIST */
			if( $options != NULL ){

				/* PRINT THE MEDIA QUERY */
				if( $media_query ){
					_e( $media_query. "{" );
				}

				/* ITERATE THROUGH EACH SELECTOR */
				foreach( $items as $item ){

					$css_item = $this->print_css_item( $item, $options );

					if( isset( $item['selector'] ) && $item['selector'] && $css_item ){

						_e( $item['selector'] . "{" . $css_item . "}" );

						if( ! $media_query ){ echo "\r\n"; }
					}
				}

				/* CLOSE THE MEDIA QUERY */
				if( $media_query ){
					_e( "}" );
					echo "\r\n";
				}

			}


		}

		function nav_menu( $args = array() ){

			$args = wp_parse_args( $args, array(
				'menu'              => 'primary',
				'theme_location' 	=> 'primary_navigation',
				'walker'		 	=> new wp_bootstrap_navwalker(),
				'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
				'menu_class' 		=> 'nav navbar-nav'
			) );

			wp_nav_menu( $args );
		}

	}


	global $akvo;

	$akvo = new AKVO;
