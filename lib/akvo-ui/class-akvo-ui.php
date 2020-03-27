<?php


class AKVO_UI extends AKVO_BASE{

  function collapsible( $title, $subtitle, $description ){
    $id = md5( $title );
    include( 'templates/collapsible.php' );
  }

  function status_item( $label, $value ){
    include( 'templates/status.php' );
  }

  function amount_format( $value, $currency ){ return number_format( $value ) . ' ' . $currency; }

  function date_format( $value, $date_format = 'jS M, Y' ){
    return date( $date_format, strtotime( $value ) );
  }

}

AKVO_UI::getInstance();
