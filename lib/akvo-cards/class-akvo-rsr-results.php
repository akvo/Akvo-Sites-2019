<?php

class AKVO_RSR_RESULTS extends AKVO_BASE{

  function __construct(){
    add_shortcode( 'akvo_rsr_results', array( $this, 'shortcode' ) );
  }

  function shortcode( $atts ){
    ob_start();

    $atts = shortcode_atts( array(
      'rsr-id'	=> 'results',
      'posts_per_page'	=> 10,
      'page'	=> 1
    ), $atts, 'akvo_rsr_results' );

    global $akvo_rsr;
    $response = $akvo_rsr->get_data_feed_response( $atts );
    $this->html( $response->results );

    return ob_get_clean();
  }

  function html( $results ){
    echo "<div class='panel-group rsr-results-group' id='accordion' role='tablist' aria-multiselectable='true'>";
    foreach ($results as $result) {
      $this->result_html( $result );
    }
    echo "</div>";
  }

  function result_html( $result ){

    ob_start();
    foreach ($result->indicators as $indicator){
      $this->indicator_html( $indicator );
    }
    $collapsed_html = ob_get_clean();

    $tot_indicators = count( $result->indicators );
    $title = "<span class='indicator-title'>" . $result->title . "</span><span class='badge'>" . $tot_indicators . " Indicators</span>";

    AKVO_UI::getInstance()->collapsible( $title, '', $collapsed_html );
  }

  function indicator_html( $indicator ){

    $tot_periods = count( $indicator->periods );

    $tot_target_value = 0;
    $tot_actual_value = 0;

    echo "<div class='akvo-rsr-box rsr-indicator'>";

    $title = $indicator->title . '&nbsp; <span class="badge">' . $tot_periods . ' Periods</span>';

    ob_start();
    _e( "<ul class='list-inline'>" );
    _e( "<li><span class='text-muted'>Baseline Year:</span> " . $indicator->baseline_year . "</li>" );
    _e( "<li><span class='text-muted'>Baseline Value:</span> " . $indicator->baseline_value . "</li>" );
    _e( "</ul>" );
    foreach ($indicator->periods as $period){
      $tot_target_value += floatval( $period->target_value );
      $tot_actual_value += floatval( $period->actual_value );
      $this->period_html( $period );
    }
    $description = ob_get_clean();

    AKVO_UI::getInstance()->collapsible( $title, $indicator->description, $description );

    $this->progress_html( $tot_target_value, $tot_actual_value );

    echo "</div>";
  }

  function progress_html( $tot_target_value, $tot_actual_value ){
    $percent = 0;
    if( $tot_target_value > 0 && $tot_actual_value > 0 ){ $percent = ceil( ( $tot_actual_value / $tot_target_value ) * 100 ); }
    if ( $percent > 100 ) { $percent = 100; }
    include( 'templates/results-progress.php' );
  }

  /*
  * [period_start]    => 2017-01-01
  * [period_end]      => 2017-03-31
  * [target_value]    =>
  * [target_comment]  =>
  * [actual_value]    =>
  * [actual_comment]  =>
  * [numerator]       =>
  * [denominator]     =>
  * [narrative]       =>
  * [indicator]       => 32784
  */
  function period_html( $period ){
    $akvo_ui = AKVO_UI::getInstance();

    echo "<div class='akvo-rsr-box rsr-period'>";

    echo "<ul class='list-inline'>";
    echo "<li class='rsr-period-date'>" . $akvo_ui->date_format( $period->period_start ) . " - " . $akvo_ui->date_format( $period->period_end ) . "</li>";
    echo "<li><span class='text-muted'>TARGET:</span> ".$period->target_value."</li>";
    echo "<li><span class='text-muted'>ACTUAL:</span> ".$period->actual_value."</li>";
    echo "</ul>";

    $this->disaggregations_html( $period->disaggregations );

    echo "</div>";
  }


  function disaggregations_html( $disaggregations ){

    $data = array();
    foreach ($disaggregations as $disaggregation) {
      $dimension_name_id = $disaggregation->dimension_name->id;
      if( !( isset( $data[ $dimension_name_id ] ) && isset( $data[ $dimension_name_id ][ 'items' ] ) && is_array( $data[ $dimension_name_id ][ 'items' ] ) ) ){
        $data[ $dimension_name_id ] = array(
          'title' => $disaggregation->dimension_name->name,
          'items' => array()
        );
      }
      array_push( $data[ $dimension_name_id ][ 'items' ],  array(
        'label' => $disaggregation->dimension_value->value,
        'value' => $disaggregation->value,
        'numerator' => $disaggregation->numerator,
        'denominator' => $disaggregation->denominator,
      ) );
    }

    /*
    echo "<pre>";
    print_r( $disaggregations );
    echo "</pre>";
    */

    if( count( $data ) ){
      echo "<div class='akvo-rsr-box rsr-disaggregations'>";
      echo "<p class='text-muted'>Disaggregations</p>";
      foreach ($data as $dimension) {
        $this->dimension_html( $dimension );
      }
      echo "</div>";
    }


  }

  function dimension_html( $dimension ){
    $akvo_ui = AKVO_UI::getInstance();
    echo "<div class='akvo-rsr-box rsr-disaggregations'>";
    echo "<p class='text-muted'>".$dimension['title']."</p>";
    foreach ($dimension['items'] as $dimension_item) {
      $akvo_ui->status_item( $dimension_item['label'], $dimension_item['value'] );
    }
    echo "</div>";
  }

}

AKVO_RSR_RESULTS::getInstance();
