<?php

$screens = array(
	'cpt' => array(
		'label' => 'Custom Post Types',
		'tab' => plugin_dir_path(__FILE__) . 'pages/cpt.php',
	),
	/*
	'sample-two' => array(
		'label' => 'Sample two',
		'tab' => plugin_dir_path(__FILE__) . 'pages/sample-two.php',
		'action' => 'sample-two',
	),
	'sample-three' => array(
		'label' => 'Sample Three',
		'tab' => plugin_dir_path(__FILE__) . 'pages/sample-three.php',
		'action' => 'sample-three',
	),
	*/
);

$active_tab = '';
?>
<div class="wrap">
	<h1>Theme Settings</h1>
	<h2 class="nav-tab-wrapper">
	<?php
		foreach ($screens as $slug => $screen) {
			$url = admin_url('admin.php?page=theme_settings');
			if (isset($screen['action'])) {
				$url = esc_url(add_query_arg(array('action' => $screen['action']), admin_url('admin.php?page=theme_settings')));
			}

			$nav_class = "nav-tab";

			if (isset($screen['action']) && isset($_GET['action']) && $screen['action'] == $_GET['action']) {
				$nav_class .= " nav-tab-active";
				$active_tab = $slug;
			}

			if (!isset($screen['action']) && !isset($_GET['action'])) {
				$nav_class .= " nav-tab-active";
				$active_tab = $slug;
			}

			echo '<a href="' . $url . '" class="' . $nav_class . '">' . $screen['label'] . '</a>';
		}
	?>

	</h2>

	<?php

		if (file_exists($screens[$active_tab]['tab'])) {
			include $screens[$active_tab]['tab'];
		}
	?>

</div>
