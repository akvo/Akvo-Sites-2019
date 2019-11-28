<?php 
	global $akvo;
	$location = get_option( 'akvo_logo_location' );
	
	if( ! $location ){ $location = "left"; }
?>

<div class="row">
	
	<?php if( $location == 'left'): ?>
		<div class="col-sm-6 logo"><?php get_template_part('partials/logo');?></div>
	<?php endif;?>
	
	<div class="col-sm-6 wrap-search-menu">
		<?php if( $akvo->search_flag ):?>
		
		<div class="hidden-xs">
			<?php get_search_form();?>
			
			<?php if ( is_active_sidebar( 'sub-header-r' ) ) : ?>
			<div id="sub-header-r" class="clearfix"><?php dynamic_sidebar( 'sub-header-r' ); ?></div>
      		<?php endif; ?>
		
		</div>
		
		<?php else: ?>
			
			<?php if ( is_active_sidebar( 'replace-search' ) ){ dynamic_sidebar( 'replace-search' ); }?>
		
		<?php endif;?>
	
	</div>
	
	<?php if( $location == 'right'): ?>
		<div class="col-sm-6 logo text-right"><?php get_template_part('partials/logo');?></div>
	<?php endif;?>

</div>