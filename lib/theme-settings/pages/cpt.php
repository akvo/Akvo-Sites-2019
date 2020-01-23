<?php

  global $akvo;
  $settings = $akvo->get_settings();

  if( $_POST ){
    $settings['cpt'] = isset( $_POST['cpt'] ) ? $_POST['cpt'] : array();
    $akvo->update_settings( $settings );

    // REDIRECT
    echo "<script>location.reload();</script>";
  }

  echo "<p class='help'>Select the ones that are required:</p>";

  echo "<form method='POST'>";

  foreach( $akvo->custom_post_types as $slug => $post_type ){
    $checked = false;
    if( in_array( $slug, $settings['cpt'] ) ){ $checked = true; }

    echo "<p>";
    echo "<input type='checkbox' name='cpt[]' value='$slug' ";
    if( $checked ){ echo "checked='checked'";}
    echo ">";
    echo "&nbsp;".$post_type['plural_name'];
    echo "</p>";
  }

  echo "<input type='hidden' name='hidden' value='1' />";
  echo "<p class='submit'><input type='submit' class='button button-primary' value='Save Changes' /></p>";

  echo "</form>";
