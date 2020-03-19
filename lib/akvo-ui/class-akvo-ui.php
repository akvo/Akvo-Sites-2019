<?php


class AKVO_UI extends AKVO_BASE{

  function collapsible( $title, $subtitle, $description ){
    $id = md5( $title );
    include( 'templates/collapsible.php' );
  }

  function status_item( $label, $value ){
    include( 'templates/status.php' );
  }


}

AKVO_UI::getInstance();
