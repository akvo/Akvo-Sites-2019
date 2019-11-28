<?php global $akvo;?>
<header class="banner header3" role="banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-3 logo">
				<?php get_template_part('partials/logo');?>
			</div>
			<div class="col-sm-9 wrap-search-menu">
				<?php if( $akvo->search_flag ):?><div class="hidden-xs" style="margin-bottom: 10px;"><?php get_search_form();?></div><?php endif;?>
                <nav class="navbar-collapse collapse" role="navigation" aria-expanded="true" style="">
				<?php if( has_nav_menu( 'primary_navigation' ) ){ $akvo->nav_menu(); } ?>
				<?php
					/*
					* UNIQUE CASE
					* CHECK IF GOOGLE-WEBSITE-TRANSLATOR PLUGIN IS ACTIVE AND USER SHOULD NOT BE LOGGED IN
					* IF ACTIVE THEN ENABLE THE FOLLOWING SNIPPET OF THE SHORTCODE
					* 
					*/
					if ( is_plugin_active( 'google-website-translator/google-website-translator.php' ) && !is_user_logged_in() ) : ?>
					<div style="display:none;"><?php echo do_shortcode('[prisna-google-website-translator]'); ?></div>
				<?php endif;?>
				</nav>
				<div class="navbar-header menu-mobile">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<i class="fa fa-bars fa-2x"></i>
					</button>
					<?php if( $akvo->search_flag ):?>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".search-collapse">
						<span class="sr-only">Toggle search</span>
						<i class="fa fa-search fa-2x"></i>
					</button>
					<?php endif;?>
				</div>
					
      		</div>
        </div>
		<div class="row">
			<div class="col-md-12 navi">
				<?php if( $akvo->search_flag ):?>
				<div class="collapse search-collapse">
					<?php get_search_form();?>	
				</div>
				<?php endif;?>
			</div>
		</div>
			
		<?php if ( !is_front_page() && function_exists('bcn_display')): ?> 
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<?php bcn_display();?>
				</div>
			</div>
		</div>
		<?php endif;?>
	</div>
</header>