<?php

	$files_inc = array(
		'customize-theme/card.php',		/* CUSTOMIZE OPTIONS FOR CARD */
		'customize-theme/list.php',		/* CUSTOMIZE OPTIONS FOR LIST */
		'single-widget.php',					/* SINGLE WP WIDGET FOR CARD */
		'pin-widget.php',							/* CUSTOM WP WIDGET FOR CARD */
		'class-akvo-rsr-results.php',
		'class-akvo-rsr.php',
		'class-akvo-rsr-project.php',
		'class-akvo-card-base.php',
		'class-akvo-card.php',
		'class-akvo-list.php',
		'class-akvo-cards.php'
	);

	foreach($files_inc as $file){
		include $file;
	}
