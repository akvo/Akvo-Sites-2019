<?php
/*
Plugin Name: Akvo Fb posts
Plugin URI: https://akvo.org
Description:  Allows user to retrieve posts from Facebook page in a list, where they can select a post and post it on their website.
Author: Samuel Thomas
Version: 1.0.0
Author URI: https://akvo.org
*/

$inc_files = array(
	'inc/class-singleton.php',
	'inc/class-fb-db.php',
	'inc/class-fb-api.php',
	'inc/class-fb-posts-list-table.php',
	'inc/class-fb-admin.php',
);

foreach( $inc_files as $inc_file ){
	require_once( $inc_file );
}



