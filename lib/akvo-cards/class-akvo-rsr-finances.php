<?php

  class AKVO_RSR_FINANCES extends AKVO_BASE{

    function html( $budgetResponse, $partnershipResponse, $projectResponse, $transactionResponse ){

      $akvo_ui = AKVO_UI::getInstance();

      _e( "<div class='akvo-rsr-full-report row-col3'>" );

      $this->budgetHtml( $budgetResponse, $projectResponse->currency );

      $this->fundersHtml( $partnershipResponse, $projectResponse->currency );

      $this->fundingHtml( $projectResponse );

      $this->transactionHtml( $transactionResponse, $projectResponse->currency );

      _e( "</div>" ); // .row-col3

    }


    function budgetHtml( $budgetResponse, $currency ){
      if( isset( $budgetResponse->results ) && count( $budgetResponse->results ) ){
        $akvo_ui = AKVO_UI::getInstance();
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list akvo-budget-list'>" );
        _e( "<h4 class='akvo-status-title'>Project Budget</h4>" );
        $total = 0;
        foreach( $budgetResponse->results as $budget ){
          $title = $budget->label_label;
          if( $title == 'Other' && isset( $budget->other_extra ) && $budget->other_extra ){
            $title = $budget->other_extra;
          }
          $value = $akvo_ui->amount_format( $budget->amount, $currency );
          $akvo_ui->status_item( $title, $value );

          if( isset( $budget->period_start ) && $budget->period_start && isset( $budget->period_end ) && $budget->period_end ){
            $period = $akvo_ui->date_format( $budget->period_start ) . " to " . $akvo_ui->date_format( $budget->period_end );
            echo "<p class='small text-muted' style='margin-top:-10px;'>" . $period . "</p>";
          }
          echo "<br>";
          $total += $budget->amount;
        }
        if( count( $budgetResponse->results ) > 1 ){
          echo "<hr>";
          $akvo_ui->status_item( 'Total', $akvo_ui->amount_format( $total, $currency ) );
        }

        _e( "</div>" );
        _e( "</div>" );
      }
    }

    function fundersHtml( $partnershipResponse, $currency ){
      if( isset( $partnershipResponse->results ) && count( $partnershipResponse->results ) ){
        $akvo_ui = AKVO_UI::getInstance();
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list'>" );
        _e( "<h4 class='akvo-status-title'>Current Funders</h4>" );
        $total = 0;
        foreach( $partnershipResponse->results as $result ){
          if( $result->funding_amount_label && $result->organisation_name ){
            $akvo_ui->status_item( $result->organisation_name, $akvo_ui->amount_format( $result->funding_amount, $currency ) );
            $total += $result->funding_amount;
          }
        }
        echo "<hr>";
        $akvo_ui->status_item( 'Total', $akvo_ui->amount_format( $total, $currency ) );
        _e( "</div>" );
        _e( "</div>" );
      }
    }

    function fundingHtml( $projectResponse ){
      $akvo_ui = AKVO_UI::getInstance();
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
          $akvo_ui->status_item( $title, $akvo_ui->amount_format( $projectResponse->$slug, $projectResponse->currency ) );
        }
      }
      _e( "</div>" ); // .akvo-status-list
      _e( "</div>" ); // .col
    }

    function transactionHtml( $transactionResponse, $currency ){
      if( isset( $transactionResponse->results ) && count( $transactionResponse->results ) ){
        $akvo_ui = AKVO_UI::getInstance();
        _e( "<div class='col'>" );
        _e( "<div class='akvo-status-list'>" );
        _e( "<h4 class='akvo-status-title'>Project Transactions</h4>" );
        foreach( $transactionResponse->results as $transaction ){
          $akvo_ui->status_item( $transaction->transaction_type_label, $akvo_ui->amount_format( $transaction->value, $currency ) );
        }
        _e( "</div>" ); // .akvo-status-list
        _e( "</div>" ); // .col
      }
    }



  }

  AKVO_RSR_FINANCES::getInstance();
