<?php


  

//Theme Settings Menu Page
add_action('admin_menu', function(){

  add_menu_page( 'Theme Settings', 'Theme Settings', 'manage_options', 'theme_settings', 'theme_settings_page', 'dashicons-buddicons-topics' );
}	);


function theme_settings_page(){
  include( plugin_dir_path(__FILE__).'theme-settings.php' );
}
