<div class='panel panel-default'>
  <div class='panel-heading' role='tab' id='<?php _e( "heading-$i" );?>'>
    <h4 class='panel-title'>
      <a role='button' data-toggle='collapse' data-parent='#accordion' href='<?php _e( "#collapse-$i" );?>' aria-expanded='true' aria-controls='<?php _e( "collapse-$i" );?>' class='collapsed'>
        <span class='indicator-title'><?php echo $result->title;?></span>
        <span class='open-icon pull-right'><i class='fa fa-plus'></i></span>
        <span class='closed-icon pull-right'><i class='fa fa-minus'></i></span>
        <span class='badge pull-right' style='margin-right:10px;margin-top: 5px;'> <?php echo "$tot_indicators Indicators";?></span>
      </a>
    </h4>
  </div>
  <div id='<?php _e( "collapse-$i" );?>' class='panel-collapse collapse' role='tabpanel' aria-labelledby='<?php echo "heading-$i";?>' aria-expanded='true'>
    <div class='panel-body'>
      <?php
        $j = 1;
        foreach ($result->indicators as $indicator){
          $this->indicator_html( $indicator, $j );
          $j++;
        }
      ?>
    </div>
  </div>
</div>
