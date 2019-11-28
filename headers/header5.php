<?php global $akvo;?>
<header role="banner" class="header5">
	<div class="logobrand">
		<?php get_template_part('partials/logo');?>
	</div>	
	<button type="button" class="navbar-toggle" data-toggle="modal" data-target="#header5-modal">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
</header>

<div id="header5-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
				<?php if( has_nav_menu( 'primary_navigation' ) ){ $akvo->nav_menu(); } ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->	

<style>
	.body-header5 #main-page-container{
		margin-top: 0;
	}
</style>