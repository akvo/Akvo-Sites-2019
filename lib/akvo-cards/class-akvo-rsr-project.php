<?php

class AKVO_RSR_PROJECT extends AKVO_BASE{

  function __construct(){
    add_shortcode( 'akvo_rsr_project', array( $this, 'shortcode' ) );
  }

  function shortcode( $atts ){
    ob_start();

    $atts = shortcode_atts( array(
      'id'	  => '0',
      'tab'   => 'results'
    ), $atts, 'akvo_rsr_project' );

    $url = $this->getUrl( $atts );

    global $akvo_rsr;
    $response = $akvo_rsr->getAPIResponse( $url );

    switch( $atts['tab'] ){

      case 'full_report':
        $this->full_report( $response );
        break;

      case 'results':
        AKVO_RSR_RESULTS::getInstance()->html( $response->results );
        break;

      default:
        print_r( $response );
    }

    return ob_get_clean();
  }

  function full_report( $response ){

    $items = array(
      'project_plan'          => 'Project Plan',
      'goals_overview'        => 'Goals Overview',
      'target_group'          => 'Target Group',
      'project_plan_summary'  => 'Summary of Project Plan',
      'background'            => 'Background',
      'sustainability'        => 'Sustainability'
    );
    
    _e( "<div class='akvo-rsr-full-report'>" );
    foreach ( $items as $slug => $title ) {
      if( isset( $response->$slug ) ){
        AKVO_UI::getInstance()->collapsible( $title, '', $response->$slug );
      }
    }
    _e( "</div>" );
  }

  function getUrl( $atts ){
    $id = $atts['id'];
    switch( $atts['tab'] ){
      case 'full_report':
        return "https://rsr.akvo.org/rest/v1/project/$id/?format=json";
      case 'results':
        return "https://rsr.akvo.org/rest/v1/results_framework/?project=$id&format=json";
    }
  }

}

AKVO_RSR_PROJECT::getInstance();
