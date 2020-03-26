<?php

  class AKVO_RSR_FINANCES extends AKVO_BASE{

    function html( $partnershipResponse, $projectResponse ){

      _e( "<div class='akvo-rsr-full-report row-col3'>" );

      if( isset( $partnershipResponse->results ) ){
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list'>" );
        _e( "<h4 class='akvo-status-title'>Current Funders</h4>" );
        foreach( $partnershipResponse->results as $result ){
          if( $result->funding_amount_label && $result->organisation_name ){
            $akvo_ui = AKVO_UI::getInstance();
            $akvo_ui->status_item( $result->organisation_name, $result->funding_amount_label );
          }
        }
        _e( "</div>" );
        _e( "</div>" );
      }

      $status_items = array(
        'budget'              => 'Total Budget',
        'funds'               => 'Total Funds',
        'funds_needed'        => 'Funds Needed'
      );
      _e( "<div class='col'>" );

      _e( "<div class='akvo-status-list'>" );
      _e( "<h4 class='akvo-status-title'>Project Funding</h4>" );
      foreach ( $status_items as $slug => $title ) {
        if( isset( $projectResponse->$slug ) ){
          $value = number_format( $projectResponse->$slug ) . ' ' . $projectResponse->currency;
          $akvo_ui->status_item( $title, $value );
        }
      }
      _e( "</div>" ); // .akvo-status-list
      _e( "</div>" ); // .col

      _e( "</div>" ); // .row-col3



    }

  }

  AKVO_RSR_FINANCES::getInstance();
