<?php
	$widget_id = 'accordion-'.get_unique_id( $instance );
	$i = 0;
?>
<div class="panel-group" id="<?php _e( $widget_id );?>" role="tablist" aria-multiselectable="true">
	<?php foreach( $instance['accordions'] as $accordion ): ?>
	<?php
		$i++;
		$collapse_id = 'collapse-'.get_unique_id( $accordion );
		$heading_id = 'heading-'.get_unique_id( $accordion );
		$desc_id = 'desc-'.get_unique_id( $accordion );
	?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="<?php _e( $heading_id );?>">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" class="collapsed" data-parent="#<?php _e( $widget_id );?>" href="#<?php _e( $collapse_id );?>" aria-expanded="true" aria-controls="<?php _e( $widget_id );?>">
          <?php _e( $accordion['title'] );?>
					<span class='open-icon pull-right'><i class="fa fa-plus"></i></span>
					<span class='closed-icon pull-right'><i class="fa fa-minus"></i></span>
        </a>
      </h4>
    </div>
    <div id="<?php _e( $collapse_id );?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php _e( $heading_id );?>">
      <div class="panel-body">
        <?php echo siteorigin_panels_render( $desc_id, true, $accordion['desc'] );?>
      </div>
    </div>
  </div>
	<?php endforeach;?>
</div>
