<?php

/*
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

require_once dirname( __FILE__ ) . './../facebook/src/Facebook/autoload.php';
require_once dirname( __FILE__ ) . './../facebook/src/Facebook/Exceptions/FacebookResponseException.php';
require_once dirname( __FILE__ ) . './../facebook/src/Facebook/Exceptions/FacebookSDKException.php';
require_once dirname( __FILE__ ) . './../facebook/src/Facebook/Helpers/FacebookRedirectLoginHelper.php';
*/


/*
* EAAGQHDGms1ABAAFsvVI4jHPEIgYwl05XUAOqV41ZCYGSZChGkx3kbxZBtcEF1kaJfZBV5yoeZCO7fIzDTZBpyIce0pH05jIZB1zIZAUwL4QcZAchcV6SwDdlF0iOUrs7gx0u3h0bk93LbQkJZBp4GBToO1ZBNfqw079IgCwOJUjTyWtrwZDZD
* 1048509591976007
*/


try {
	
	$fb_api = new FB_API;
	
	/*
	$data = $fb_api->getPagePosts( "1048509591976007" );
	
	echo '<pre>';
	print_r( $data );
	echo '</pre>';
	
	wp_die();
	*/
	
}catch( Exception $e ){
	
} 


/*

//function Fb_insert_post( $postData ){
//Insert data in Fb-posts and Db
    if (count($postData) > 0) {
        foreach ($postData as $Fb_posts) {
            $args = array(
                'ID'                    => $Fb_posts ['id'],
                'post_title'            => $Fb_posts ['message'],
                'post_content'          => $Fb_posts ['message'],
                'post_type'             => 'Fb_post',
                //'post_status'           => 'publish',
                //'tax_input'             => array('post_format' => 'post-format-quote')
                //'post_image'          => $Fb_posts ['picture'],
            );
            // Insert the post into the database
            wp_insert_post($args);

            //var_dump($args);
        }

        //wp_die();
}
*/