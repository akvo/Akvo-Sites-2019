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

    global $akvo_rsr;

    switch( $atts['tab'] ){

      case 'full_report':
        $response = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], 'report' ) );
        $this->full_report( $response );
        break;

      case 'results':
        $response = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], $atts['tab'] ) );
        AKVO_RSR_RESULTS::getInstance()->html( $response->results );
        break;

      case 'finances':
        $budgetResponse = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], 'budget' ) );
        $partnershipResponse = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], 'partnership' ) );
        $projectResponse = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], 'report' ) );
        $transactionResponse = $akvo_rsr->getAPIResponse( $this->getUrl( $atts['id'], 'transaction' ) );
        AKVO_RSR_FINANCES::getInstance()->html( $budgetResponse, $partnershipResponse, $projectResponse, $transactionResponse );
        break;

      case 'updates':
        echo do_shortcode( "[akvo-cards template='card-featured' posts_per_page='4' rsr-id='' type='rsr' pagination=1 rsr-project='".$atts['id']."' pagination_style='pages']" );
        break;
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
          $value = $akvo_ui->amount_format( $response->$slug, $response->currency );
        }
        if( in_array( $slug, array( 'date_start_planned', 'date_end_planned', 'date_start_actual', 'date_end_actual' ) ) ){
          $value = $akvo_ui->date_format( $response->$slug );
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

  function getUrl( $project_id, $slug ){
    switch( $slug ){
      case 'budget':
        return "https://rsr.akvo.org/rest/v1/budget_item/?project=$project_id&format=json";
      case 'transaction':
        return "https://rsr.akvo.org/rest/v1/transaction/?project=$project_id&format=json";
      case 'updates':
        return "https://rsr.akvo.org/rest/v1/project_update/?format=json&project=$project_id&image_thumb_name=big";
      case 'partnership':
        return "https://rsr.akvo.org/rest/v1/partnership/?project=$project_id&format=json";
      case 'report':
        return "https://rsr.akvo.org/rest/v1/project/$project_id/?format=json";
      case 'results':
        return "https://rsr.akvo.org/rest/v1/results_framework/?project=$project_id&format=json";
    }
  }

}

AKVO_RSR_PROJECT::getInstance();
