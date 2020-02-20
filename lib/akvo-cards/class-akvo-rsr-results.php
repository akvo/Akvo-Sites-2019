<?php

class AKVO_RSR_RESULTS extends AKVO_BASE{

  function html( $results ){
    $i = 1;
    echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
    foreach ($results as $result) {
      $this->result_html( $result, $i );
      $i++;
    }
    echo "</div>";
  }

  function result_html( $result, $i ){
    $tot_indicators = count( $result->indicators );

    echo "<div class='panel panel-default'>";

    echo "<div class='panel-heading' role='tab' id='heading-$i'>";
    echo "<h4 class='panel-title'>";
    echo "<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse-$i' aria-expanded='true' aria-controls='collapse-$i' class='collapsed'>";
    echo $result->title;
    echo "<span class='open-icon pull-right'><i class='fa fa-plus'></i></span>";
    echo "<span class='closed-icon pull-right'><i class='fa fa-minus'></i></span>";
    echo "<span class='badge pull-right' style='margin-right:10px;margin-top: 5px;'> $tot_indicators Indicators</span>";
    echo "</a>";
    echo "</h4>";     // .panel-title
    echo "</div>";    // .panel-heading

    echo "<div id='collapse-$i' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading-$i' aria-expanded='true'>";
    echo "<div class='panel-body'>";
    foreach ($result->indicators as $indicator){
      $this->indicator_html( $indicator );
    }
    echo "</div>";    // .panel-body
    echo "</div>";    // .collapse

    echo "</div>";    // .panel
  }

  function indicator_html( $indicator ){

    $tot_periods = count( $indicator->periods );

    echo "<div class='akvo-rsr-box rsr-indicator'>";
    echo "<h5>".$indicator->title."&nbsp; <span class='badge'> $tot_periods Periods</h5>";
    echo "<p class='text-muted'>".$indicator->description."</p>";

    echo "<ul class='list-inline'>";
    echo "<li><span class='text-muted'>Baseline Year:</span> ".$indicator->baseline_year."</li>";
    echo "<li><span class='text-muted'>Baseline Value:</span> ".$indicator->baseline_value."</li>";
    echo "</ul>";

    $tot_target_value = 0;
    $tot_actual_value = 0;
    foreach ($indicator->periods as $period){
      $tot_target_value += floatval( $period->target_value );
      $tot_actual_value += floatval( $period->actual_value );
      $this->period_html( $period );
    }

    $percent = 0;

    if( $tot_target_value > 0 && $tot_actual_value > 0 ){
      $percent = ceil( ( $tot_actual_value / $tot_target_value ) * 100 );
    }


    if ( $percent > 100 ) { $percent = 100; }

    ?>

    <div class="progress-pie-chart" data-percent="<?php _e( $percent );?>">
      <div class="ppc-progress">
        <div class="ppc-progress-fill"></div>
      </div>
      <div class="ppc-percents">
        <div class="pcc-percents-wrapper">
          <span>%</span>
        </div>
      </div>
    </div>

    <?php


    //echo "<pre>";
    //unset( $indicator->periods );
    //print_r( $indicator );
    //echo "</pre>";

    echo "</div>";
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

    echo "<div class='akvo-rsr-box rsr-period'>";

    $phpstartdate = strtotime( $period->period_start );
    $phpenddate = strtotime( $period->period_end );

    echo "<ul class='list-inline'>";
    echo "<li class='rsr-period-date'>" . date("jS M Y", $phpstartdate) . " - " . date("jS M Y", $phpenddate) . "</li>";
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
    echo "<div class='akvo-rsr-box rsr-disaggregations'>";
    echo "<p class='text-muted'>".$dimension['title']."</p>";
    foreach ($dimension['items'] as $dimension_item) {
      $this->dimension_item_html( $dimension_item );
    }

    //echo "<pre>";
    //print_r( $dimension );
    //echo "</pre>";

    echo "</div>";
  }

  function dimension_item_html( $dimension_item ){
    echo "<div class='akvo-rsr-box rsr-dimension-item'>";
    echo "<p>".$dimension_item['label']." : ".$dimension_item['value']."</p>";
    echo "</div>";
  }


}
