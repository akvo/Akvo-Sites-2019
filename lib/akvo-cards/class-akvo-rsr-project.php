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

    $akvo_ui = AKVO_UI::getInstance();

    _e( "<div class='akvo-rsr-full-report'>" );
    _e( "<h4 class='akvo-status-title'>Activity dates and status</h4>" );
    $status_items = array(
      'status_label'        => 'Status',
      'date_start_planned'  => 'Planned start date',
      'date_end_planned'    => 'Planned end date',
      'date_start_actual'   => 'Actual start date',
      'date_end_actual'     => 'Actual end date',
      'budget'              => 'Total Budget',
      'funds'               => 'Total Funds',
      'funds_needed'        => 'Funds Needed'
    );
    _e( "<div class='akvo-status-list'>" );
    foreach ( $status_items as $slug => $title ) {
      if( isset( $response->$slug ) ){
        $value = $response->$slug;
        if( in_array( $slug, array( 'budget', 'funds', 'funds_needed' ) ) ){
          $value = number_format( $response->$slug ) . ' ' . $response->currency;
        }
        $akvo_ui->status_item( $title, $value );
      }
    }
    _e( "</div>" );

    $items = array(
      'project_plan'          => 'Project Plan',
      'goals_overview'        => 'Goals Overview',
      'target_group'          => 'Target Group',
      'project_plan_summary'  => 'Summary of Project Plan',
      'background'            => 'Background',
      'sustainability'        => 'Sustainability'
    );


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
