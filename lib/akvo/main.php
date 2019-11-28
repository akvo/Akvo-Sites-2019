<?php
	
	$inc_files = array(
		'class-akvo.php',
		'class-akvo-customize-dropdown-control.php',
		'class-akvo-customize.php',
		'class-akvo-fonts.php',
		'class-akvo-admin.php',
	);
	
	foreach($inc_files as $inc_file){
		include( $inc_file );
	}