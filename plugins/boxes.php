<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool             True if metabox should show
 */
function yourprefix_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function yourprefix_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function yourprefix_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

/*
add_action( 'cmb2_init', 'map_option' );
function map_option() {
	$prefix = '_map_option_';

	$cmb_posts = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Google Map', 'cmb2' ),
		'object_types'  => array( 'post', 'page'), // Post type
		//'show_on_cb'    => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_posts->add_field( array(
		'name' => __( 'Google Map', 'cmb2' ),
		'desc' => __( 'Enter address or coordinates you would like to display on a map', 'cmb2' ),
		'id'   => $prefix . 'address',
		'type' => 'text',
	) );
}


add_action( 'cmb2_init', 'post_extra_boxes' );
function post_extra_boxes() {
	$prefix = '_post_extra_boxes_';

	$cmb_posts = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Additional fields', 'cmb2' ),
		'object_types'  => array( 'post', 'blog'), // Post type
		//'show_on_cb'    => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_posts->add_field( array(
		'name' 		=> __( 'Featured', 'cmb2' ),
		'desc' 		=> __( 'Make this a sticky item, displayed first on the archives page.', 'cmb2' ),
		'id'   		=> $prefix . 'checkbox',
		'type' 		=> 'select',
		'default'	=> 'off',
		'options'	=> array( 'on'	=> 'On', 'off'	=> 'Off' )
	) );
}
*/

add_action( 'cmb2_init', function(){
	$prefix = '_video_extra_boxes_';

	$cmb_vid = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Additional fields', 'cmb2' ),
		'object_types'  => array( 'video', 'testimonial'), // Post type
		//'show_on_cb'    => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	
	$cmb_vid->add_field( array(
		'name' => __( 'Youtube URL', 'cmb2' ),
		'desc' => __( 'Enter the Youtube video URL', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'oembed',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );
	
	
} );


/*
add_action( 'cmb2_init', 'flow_url' );
function flow_url() {
	$prefix = '_flow_url_';

	$cmb_vid = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Responsive iframe', 'cmb2' ),
		'object_types'  => array( 'flow','map','post','page'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$cmb_vid->add_field( array(
		'name' => __( 'Iframe URL', 'cmb2' ),
		'desc' => __( 'Enter the URL you wish to embed as an iframe below the content. This is a responsive iframe, javascript code is needed on the embedded page.', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
	) );
}

add_action( 'cmb2_init', 'iframe_url' );
function iframe_url() {
	$prefix = '_iframe_url_';

	$cmb_iframe = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Fixed height iframe', 'cmb2' ),
		'object_types'  => array( 'flow','map','post','page'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$cmb_iframe->add_field( array(
		'name' => __( 'Iframe URL', 'cmb2' ),
		'desc' => __( 'Enter the URL you wish to embed as an iframe below the content', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
	) );

	$cmb_iframe->add_field( array(
		'name' => __( 'Iframe height', 'cmb2' ),
		'desc' => __( 'Specify the iframe height in pixels. Eg. 400.', 'cmb2' ),
		'id'   => $prefix . 'pix',
		'type' => 'text',
	) );
}

add_action( 'cmb2_init', 'channels' );
function channels() {
	$prefix = '_channels_';

	$cmb_vid = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Youtube and Flickr channels', 'cmb2' ),
		'object_types'  => array('post','page','blog'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$cmb_vid->add_field( array(
		'name' => __( 'Youtube channel shortcode', 'cmb2' ),
		'desc' => __( 'Enter the shortcode as specced by the Youtube Channel plugin. Eg. [Youtube_Channel_Gallery user="Washalliance" videowidth="580" ratio="16x9" theme="light" color="white" autoplay="0" rel="0" showinfo="0" maxitems="16" thumb_width="125" thumb_ratio="16x9" thumb_columns_ld="4" promotion="0" pagination_show="0"]', 'cmb2' ),
		'id'   => $prefix . 'youtube',
		'type' => 'text',
	) );
	$cmb_vid->add_field( array(
		'name' => __( 'Flickr username', 'cmb2' ),
		'desc' => __( 'Enter the username containing the gallery you wish to show.', 'cmb2' ),
		'id'   => $prefix . 'flickr_handle',
		'type' => 'text',
	) );
	$cmb_vid->add_field( array(
		'name' => __( 'Flickr gallery ID', 'cmb2' ),
		'desc' => __( 'Enter the ID of the gallery you wish to show.', 'cmb2' ),
		'id'   => $prefix . 'flickr',
		'type' => 'text',
	) );
}

add_action( 'cmb2_init', 'carousel_extra' );
function carousel_extra() {
	$prefix = '_carousel_extra_boxes_';

	$cmb_vid = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Additional fields', 'cmb2' ),
		'object_types'  => array( 'carousel'), // Post type
		//'show_on_cb'    => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_vid->add_field( array(
		'name' => __( 'Linkthru URL', 'cmb2' ),
		'desc' => __( 'Enter url where this slide should link to', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
	) );
}
*/


add_action( 'cmb2_init', function(){
	
	$prefix = '_media_lib_';

	$cmb_media = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Additional fields', 'cmb2' ),
		'object_types'  => array( 'media'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$cmb_media->add_field( array(
		'name' => __( 'Author', 'cmb2' ),
		'desc' => __( 'Author name', 'cmb2' ),
		'id'   => $prefix . 'author',
		'type' => 'text',
		// 'repeatable' => true,
	) );

	$cmb_media->add_field( array(
		'name' => __( 'File 1', 'cmb2' ),
		'desc' => __( 'Upload the file', 'cmb2' ),
		'id'   => $prefix . 'file',
		'type' => 'file',
	) );
	$cmb_media->add_field( array(
		'name' => __( 'File 2', 'cmb2' ),
		'desc' => __( 'Upload another file', 'cmb2' ),
		'id'   => $prefix . 'file2',
		'type' => 'file',
	) );
	$cmb_media->add_field( array(
		'name' => __( 'File 3', 'cmb2' ),
		'desc' => __( 'Upload another file', 'cmb2' ),
		'id'   => $prefix . 'file3',
		'type' => 'file',
	) );
	$cmb_media->add_field( array(
		'name' => __( 'File 4', 'cmb2' ),
		'desc' => __( 'Upload another file', 'cmb2' ),
		'id'   => $prefix . 'file4',
		'type' => 'file',
	) );
	
} );



//add_action( 'cmb2_init', 'custom_boxes' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function custom_boxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_custom_boxes_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Additional fields', 'cmb2' ),
		'object_types'  => array( '', ), // Post type
		'show_on_cb'    => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Test Text', 'cmb2' ),
		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Small', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textsmall',
		'type' => 'text_small',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Medium', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmedium',
		'type' => 'text_medium',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Website URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Email', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'email',
		'type' => 'text_email',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Time', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'time',
		'type' => 'text_time',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Time zone', 'cmb2' ),
		'desc' => __( 'Time zone', 'cmb2' ),
		'id'   => $prefix . 'timezone',
		'type' => 'select_timezone',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date Picker', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate',
		'type' => 'text_date',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate_timestamp',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'datetime_timestamp',
		'type' => 'text_datetime_timestamp',
	) );

	// This text_datetime_timestamp_timezone field type
	// is only compatible with PHP versions 5.3 or above.
	// Feel free to uncomment and use if your server meets the requirement
	// $cmb_demo->add_field( array(
	// 	'name' => __( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
	// 	'desc' => __( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'datetime_timestamp_timezone',
	// 	'type' => 'text_datetime_timestamp_timezone',
	// ) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Money', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmoney',
		'type' => 'text_money',
		// 'before_field' => '£', // override '$' symbol if needed
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Color Picker', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'colorpicker',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea',
		'type' => 'textarea',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area Small', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textareasmall',
		'type' => 'textarea_small',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Text Area for Code', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea_code',
		'type' => 'textarea_code',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Title Weeeee', 'cmb2' ),
		'desc' => __( 'This is a title description', 'cmb2' ),
		'id'   => $prefix . 'title',
		'type' => 'title',
	) );

	$cmb_demo->add_field( array(
		'name'             => __( 'Test Select', 'cmb2' ),
		'desc'             => __( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => __( 'Option One', 'cmb2' ),
			'custom'   => __( 'Option Two', 'cmb2' ),
			'none'     => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => __( 'Test Radio inline', 'cmb2' ),
		'desc'             => __( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'radio_inline',
		'type'             => 'radio_inline',
		'show_option_none' => 'No Selection',
		'options'          => array(
			'standard' => __( 'Option One', 'cmb2' ),
			'custom'   => __( 'Option Two', 'cmb2' ),
			'none'     => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Radio', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => __( 'Option One', 'cmb2' ),
			'option2' => __( 'Option Two', 'cmb2' ),
			'option3' => __( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Radio', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'text_taxonomy_radio',
		'type'     => 'taxonomy_radio',
		'taxonomy' => 'category', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Select', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'taxonomy_select',
		'type'     => 'taxonomy_select',
		'taxonomy' => 'category', // Taxonomy Slug
	) );

	$cmb_demo->add_field( array(
		'name'     => __( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
		'desc'     => __( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'multitaxonomy',
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'post_tag', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Checkbox', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'checkbox',
		'type' => 'checkbox',
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test Multi Checkbox', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'multicheckbox',
		'type'    => 'multicheck',
		// 'multiple' => true, // Store values in individual rows
		'options' => array(
			'check1' => __( 'Check One', 'cmb2' ),
			'check2' => __( 'Check Two', 'cmb2' ),
			'check3' => __( 'Check Three', 'cmb2' ),
		),
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Test wysiwyg', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 5, ),
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Test Image', 'cmb2' ),
		'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'         => __( 'Multiple Files', 'cmb2' ),
		'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => $prefix . 'file_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'oEmbed', 'cmb2' ),
		'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'cmb2' ),
		'id'   => $prefix . 'embed',
		'type' => 'oembed',
	) );

	$cmb_demo->add_field( array(
		'name'         => 'Testing Field Parameters',
		'id'           => $prefix . 'parameters',
		'type'         => 'text',
		'before_row'   => 'yourprefix_before_row_if_2', // callback
		'before'       => '<p>Testing <b>"before"</b> parameter</p>',
		'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
		'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
		'after'        => '<p>Testing <b>"after"</b> parameter</p>',
		'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
	) );

}

//add_action( 'cmb2_init', 'yourprefix_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function yourprefix_register_theme_options_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$option_key = '_yourprefix_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}