<!-- AKVO TABS-->
<div class="row akvo-sow-tabs">
	<div class="col-sm-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php foreach ( $instance['akvo_tabs_repeater'] as $i => $tab ) :  ?>
			<li role="presentation" class="<?php echo $i == 0 ? 'active' : ''; ?>">
				<a href="#<?php echo sanitize_title_with_dashes( $tab['tab_title'] ); ?>" aria-controls="<?php echo sanitize_title_with_dashes( $tab['tab_title'] ); ?>" role="tab" data-toggle="tab">
					<?php _e( $tab['tab_title'] );?>
				</a>
			</li>
		<?php endforeach;?>
		</ul>
		<!-- Nav tabs -->
		<!-- Tab panes -->
		<div class="tab-content" style="margin-top: 20px;">
			<?php foreach ( $instance['akvo_tabs_repeater'] as $i => $tab ) :  ?>
			<div role="tabpanel" class="tab-pane <?php echo $i == 0 ? 'active' : ''; ?>" id="<?php echo sanitize_title_with_dashes( $tab['tab_title'] ); ?>">
				<?php
					echo siteorigin_panels_render( 'tab' , true, $tab['tab_content'] );
				?>
			</div>
		<?php endforeach;?>
		</div>
		<!-- Tab panes -->
	</div>
</div>
<!-- AKVO TABS-->
