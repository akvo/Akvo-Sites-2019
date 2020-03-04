<a data-toggle="collapse" href="<?php _e( '#' . $collapse_id );?>" aria-expanded="false" aria-controls="<?php _e( $collapse_id );?>">
  <h5><?php echo $indicator->title;?> &nbsp; <span class='badge'><?php echo $tot_periods;?> Periods</h5>
  <p class='text-muted'><?php echo $indicator->description;?></p>
</a>
<div class="collapse" id="<?php _e( $collapse_id );?>">
  <ul class='list-inline'>
    <li><span class='text-muted'>Baseline Year:</span> <?php echo $indicator->baseline_year;?></li>
    <li><span class='text-muted'>Baseline Value:</span> <?php echo $indicator->baseline_value;?></li>
  </ul>
  <?php foreach ($indicator->periods as $period){
    $tot_target_value += floatval( $period->target_value );
    $tot_actual_value += floatval( $period->actual_value );
    $this->period_html( $period );
  }
  ?>
</div>
