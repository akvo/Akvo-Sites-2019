<?php

  class AKVO_RSR_FINANCES extends AKVO_BASE{

    function html( $budgetResponse, $partnershipResponse, $projectResponse, $transactionResponse ){

      $akvo_ui = AKVO_UI::getInstance();

      _e( "<div class='akvo-rsr-full-report row-col3'>" );

      // BUDGET
      if( isset( $budgetResponse->results ) && count( $budgetResponse->results ) ){
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list akvo-budget-list'>" );
        _e( "<h4 class='akvo-status-title'>Project Budget</h4>" );
        $total = 0;
        foreach( $budgetResponse->results as $budget ){
          $title = $budget->label_label;
          if( $title == 'Other' && isset( $budget->other_extra ) && $budget->other_extra ){
            $title = $budget->other_extra;
          }
          $value = $this->format( $budget->amount, $projectResponse->currency );
          $akvo_ui->status_item( $title, $value );

          if( isset( $budget->period_start ) && $budget->period_start && isset( $budget->period_end ) && $budget->period_end ){
            $akvo_ui->status_item( '<span style="font-weight:normal;">Budget Period</span>', $budget->period_start . " to " . $budget->period_end );
          }
          echo "<br>";
          $total += $budget->amount;
        }
        if( count( $budgetResponse->results ) > 1 ){
          echo "<hr>";
          $akvo_ui->status_item( 'Total', $this->format( $total, $projectResponse->currency ) );
        }

        _e( "</div>" );
        _e( "</div>" );
      }


      // CURRENT FUNDERS
      if( isset( $partnershipResponse->results ) && count( $partnershipResponse->results ) ){
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list'>" );
        _e( "<h4 class='akvo-status-title'>Current Funders</h4>" );
        $total = 0;
        foreach( $partnershipResponse->results as $result ){
          if( $result->funding_amount_label && $result->organisation_name ){
            $akvo_ui->status_item( $result->organisation_name, $this->format( $result->funding_amount, $projectResponse->currency ) );
            $total += $result->funding_amount;
          }
        }
        echo "<hr>";
        $akvo_ui->status_item( 'Total', $this->format( $total, $projectResponse->currency ) );
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
          $akvo_ui->status_item( $title, $this->format( $projectResponse->$slug, $projectResponse->currency ) );
        }
      }
      _e( "</div>" ); // .akvo-status-list
      _e( "</div>" ); // .col

      if( isset( $transactionResponse->results ) && count( $transactionResponse->results ) ){
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list'>" );
        _e( "<h4 class='akvo-status-title'>Project Transactions</h4>" );
        foreach( $transactionResponse->results as $transaction ){
          $akvo_ui->status_item( $transaction->transaction_type_label, $transaction->value );
        }
        _e( "</div>" ); // .akvo-status-list
        _e( "</div>" ); // .col
      }


      _e( "</div>" ); // .row-col3



    }

    function format( $value, $currency ){ return number_format( $value ) . ' ' . $currency; }

  }

  AKVO_RSR_FINANCES::getInstance();
