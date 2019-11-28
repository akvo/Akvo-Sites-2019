<?php
	
	$screens = array(
		'general'	=> array(
			'label'		=> 'General Settings',
			'tab'		=> plugin_dir_path(__FILE__).'settings-general.php'
		),
		'import'	=> array(
			'label'		=> 'Import',
			'action'	=> 'import',
			'tab'		=> plugin_dir_path(__FILE__).'settings-import.php'
		),
	);
	
	$screens = apply_filters( 'orbit_admin_settings_screens', $screens );
	
	$active_tab = '';
?>
<div class="wrap">
	<h1>FB Posts Settings</h1>
	<h2 class="nav-tab-wrapper">
	<?php 
		foreach( $screens as $slug => $screen ){
			$url =  admin_url( 'edit.php?post_type=fb_post&page=settings' );
			if( isset( $screen['action'] ) ){
				$url =  esc_url( add_query_arg( array( 'action' => $screen['action'] ), admin_url( 'edit.php?post_type=fb_post&page=settings' ) ) );
			}
			
			$nav_class = "nav-tab";
			
			if( isset( $screen['action'] ) && isset( $_GET['action'] ) && $screen['action'] == $_GET['action'] ){
				$nav_class .= " nav-tab-active";
				$active_tab = $slug;
			}
			
			if( ! isset( $screen['action'] ) && ! isset( $_GET['action'] ) ){
				$nav_class .= " nav-tab-active";
				$active_tab = $slug;
			}
			
			echo '<a href="'.$url.'" class="'.$nav_class.'">'.$screen['label'].'</a>'; 
		}	
	?>
	</h2>
	<?php 
		
		if( file_exists( $screens[ $active_tab ][ 'tab' ] ) ){
			include( $screens[ $active_tab ][ 'tab' ] );
		}
		
	?>
</div>