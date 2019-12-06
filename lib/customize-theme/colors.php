<?php

//include("color.php");
	use Mexitek\PHPColors\Color;


	add_action( 'customize_register', function($wp_customize){

		global $akvo_customize;

		/** MAIN AKVO PANEL */
		$akvo_customize->panel( $wp_customize, 'akvo_theme_panel', 'Theme Options' );

		/* All our sections, settings, and controls will be added here */

   		$akvo_customize->section( $wp_customize, 'akvo_theme_panel', 'akvo_color', 'Adjust Colors', '');

		$colors = array(
			'main_color' 		=> array(
				'default'		=> '#00a99d',
				'label'			=> 'Main Color'
			),
			'background'		=> array(
				'default'		=> '#ffffff',
				'label'			=> 'Background'
			),

			'grijs'				=> array(
				'default'		=> '#e6e6e6',
				'label'			=> 'Shades of grey'
			),
			'info_bar_blog'		=> array(
				'default'		=> '#a3d165',
				'label'			=> 'Blog Post'
			),
			'info_bar_news'		=> array(
				'default'		=> '#f9ba41',
				'label'			=> 'News Post'
			),
			'info_bar_video'	=> array(
				'default'		=> '#f47b50',
				'label'			=> 'Video Post'
			),
			'info_bar_update'	=> array(
				'default'		=> '#54bce8',
				'label'			=> 'Post Update'
			),
			'info_bar_page'		=> array(
				'default'		=> '#6d3a7d',
				'label'			=> 'Page Color'
			),
			'info_bar_project'	=> array(
				'default'		=> '#7381fa',
				'label'			=> 'Project Update'
			),
			'info_bar_map'		=> array(
				'default'		=> '#ad1c3c',
				'label'			=> 'Map'
			),
			'info_bar_testimonial'	=> array(
				'default'			=> '#007ba8',
				'label'				=> 'Testimonial'
			),
			'info_bar_flow'	=> array(
				'default'		=> '#54bce8',
				'label'			=> 'Flow'
			),
			'info_bar_media'		=> array(
				'default'		=> '#9d897b',
				'label'			=> 'Media Item'
			),
		);

		foreach( $colors as $color_id => $color ){

			$akvo_customize->color( $wp_customize, 'akvo_color', $color_id, $color['label'], $color['default'] );


		}

	} );




	add_action( 'akvo_sites_css', function(){

		/* MAIN COLOR */
		$main = get_option('main_color') ? get_option('main_color') : ( get_theme_mod('main_color') ? get_theme_mod('main_color') : '#00a99d' );

		$main2 = new Color("$main");
		$licht = '#'.$main2->mix('ffffff', 10);
		$donker = '#'.$main2->darken();

		/* SECONDARY COLOR */
		$grijs = get_option('grijs') ? get_option('grijs') : ( get_theme_mod('grijs') ? get_theme_mod('grijs') : '#e6e6e6');

		$grijs2 = new Color("$grijs");
		$lichtgrijs = '#'.$grijs2->lighten(5);
		$donkergrijs = '#'.$grijs2->darken(10);

		if($grijs == "#ffffff") $hovergrijs = "#e6e6e6";
		else $hovergrijs = $grijs;

		/* OPTIONS DATA */
		$options = array(
			'html_bg'			=> $donker,
			'light_html_bg'		=> $donkergrijs,
			'body_bg'			=> get_option('background') ? get_option('background') : ( get_theme_mod('background') ? get_theme_mod('background') : '#ffffff' ),
			'item_bg'			=> $licht,
			'item_bg_imp'		=> $licht." !important",
			'main_color'		=> $main,
			'light_bg'			=> $grijs,
			'lighter_bg'		=> $lichtgrijs,
			'hover_bg'			=> $hovergrijs,
			'card-blog'			=> get_option('info_bar_blog') ? get_option('info_bar_blog') : ( get_theme_mod('info_bar_blog') ? get_theme_mod('info_bar_blog') : '#a3d165' ),
			'card-video'		=> get_option('info_bar_video') ? get_option('info_bar_video') : ( get_theme_mod('info_bar_video') ? get_theme_mod('info_bar_video') : '#f47b50' ),
			'card-rsr-project'	=> get_option('info_bar_update') ? get_option('info_bar_update') : ( get_theme_mod('info_bar_update') ? get_theme_mod('info_bar_update') : '#54bce8' ),
			'card-page'			=> get_option('info_bar_page') ? get_option('info_bar_page') : ( get_theme_mod('info_bar_page') ? get_theme_mod('info_bar_page') : '#6d3a7d' ),
			'card-media'		=> get_option('info_bar_media') ? get_option('info_bar_media') : ( get_theme_mod('info_bar_media') ? get_theme_mod('info_bar_media') : '#9d897b' ),
			'card-map'			=> get_option('info_bar_map') ? get_option('info_bar_map') : ( get_theme_mod('info_bar_map') ? get_theme_mod('info_bar_map') : '#ad1c3c' ),
			'card-project'		=> get_option('info_bar_project') ? get_option('info_bar_project') : ( get_theme_mod('info_bar_project') ? get_theme_mod('info_bar_project') : '#7381fa' ),
			'card-testimonial'	=> get_option('info_bar_testimonial') ? get_option('info_bar_testimonial') : ( get_theme_mod('info_bar_testimonial') ? get_theme_mod('info_bar_testimonial') : '#007ba8' ),
			'card-flow'			=> get_option('info_bar_flow') ? get_option('info_bar_flow') : ( get_theme_mod('info_bar_flow') ? get_theme_mod('info_bar_flow') : '#54bce8' ),
			'card-news'			=> get_option('info_bar_news') ? get_option('info_bar_news') : ( get_theme_mod('info_bar_news') ? get_theme_mod('info_bar_news') : '#f9ba41' ),

		);

		$items = array(
			array(
				'selector'	=> 'html',
				'styles'	=> array(
					'background'	=> 'html_bg'
				)
			),
			array(
				'selector'	=> 'body',
				'styles'	=> array(
					'background'	=> 'body_bg'
				)
			),
			array(
				'selector'	=> '.carousel .text, nav ul.navbar-nav li.current-menu-item a, .carousel .carousel-indicators li.active',
				'styles'	=> array(
					'background'	=> 'item_bg'
				)
			),
			array(
				'selector'	=> 'nav .lang .fa-circle, nav ul.navbar-nav li i, .header4 .navbar-nav .dropdown-menu li a',
				'styles'	=> array(
					'color'	=> 'main_color'
				)
			),
			array(
				'selector'	=> '.btn-default, .filters #uwpqsf_id #uwpqsf_btn input, footer .custom',
				'styles'	=> array(
					'background'	=> 'main_color'
				)
			),
			array(
				'selector'	=> 'nav ul.navbar-nav li .fa-circle, a',
				'styles'	=> array(
					'color'	=> 'main_color'
				)
			),
			array(
				'selector'	=> 'a:hover',
				'styles'	=> array(
					'color'	=> 'html_bg'
				)
			),
			array(
				'selector'	=> '.btn-default:focus, .btn-default:hover, .filters #uwpqsf_id #uwpqsf_btn input:focus, .filters #uwpqsf_id #uwpqsf_btn input:hover, .comment-form footer .custom input[type=submit], .filters #uwpqsf_id #uwpqsf_btn footer .custom input, footer .custom .btn, footer .custom .comment-form input[type=submit], footer .custom .filters #uwpqsf_id #uwpqsf_btn input',
				'styles'	=> array(
					'background'	=> 'html_bg'
				)
			),
			array(
				'selector'	=> '.article .bg, article .bg, .filters, .breadcrumbs, .search-wrap',
				'styles'	=> array(
					'background'	=> 'lighter_bg'
				)
			),
			array(
				'selector'	=> 'nav ul.navbar-nav li, nav ul.navbar-nav .dropdown-menu li a',
				'styles'	=> array(
					'background'	=> 'light_bg'
				)
			),
			array(
				'selector'	=> '.clickable:hover .text',
				'styles'	=> array(
					'background'	=> 'main_color'
				)
			),
			array(
				'selector'	=> '.box-wrap:hover',
				'styles'	=> array(
					'background'	=> 'hover_bg'
				)
			),
			array(
				'selector'	=> '.search-wrap .input-group-btn .btn',
				'styles'	=> array(
					'color'	=> 'light_html_bg'
				)
			),
			array(
				'selector'	=> '.nav>li>a:focus, .nav>li>a:hover',
				'styles'	=> array(
					'background'	=> 'item_bg'
				)
			),
			array(
				'selector'	=> 'blockquote',
				'styles'	=> array(
					'border-color'	=> 'light_html_bg'
				)
			),
		);

		/* CARD TYPES - BACKGROUND */
		$akvo_card_obj = new Akvo_Card;
		$types = $akvo_card_obj->get_types();

		foreach($types as $type=>$label){

			$temp = array(
				'selector'	=> '.card.' . $type . ' .card-info',
				'styles'	=> array(
					'background'	=> 'card-'.$type
				)
			);

			array_push( $items, $temp );

		}


		global $akvo;
		$akvo->print_css( $options, $items );

		/* SMALL SCREEN CSS SELECTORS */
		$sm_items = array(
			array(
				'selector'	=> 'nav',
				'styles'	=> array(
					'background'	=> 'lighter_bg'
				)
			),
			array(
				'selector'	=> 'nav ul.navbar-nav li a:hover, nav ul.navbar-nav li:hover a',
				'styles'	=> array(
					'background'	=> 'item_bg'
				)
			),
			array(
				'selector'	=> 'nav ul.navbar-nav .dropdown-menu li a:hover, nav ul.navbar-nav .dropdown-menu li.current-menu-item a',
				'styles'	=> array(
					'background'	=> 'main_color'
				)
			),

		);

		$akvo->print_css( $options, $sm_items, '@media (min-width: 768px)' );

	});
