	<footer class="content-info" role="contentinfo">
		<div class="twitter">
			<div class="container">
				<div class="row">
					<?php 
						
						global $akvo;
						
						/* GET THE SELECTED NUMBER OF COLUMNS */
						$footer_cols = 3; 
						$akvo_options = $akvo->get_option();
						if( isset( $akvo_options['footer'] ) && isset( $akvo_options['footer']['cols_num'] ) ){
							$footer_cols = $akvo_options['footer']['cols_num'];
						}
						/* GET THE SELECTED NUMBER OF COLUMNS */
						
						/* GET COLUMN CLASS BASED ON THE NUMBER OF COLUMNS SELECTED */
						$col_class='col-md-4';
						if( $footer_cols == 2 ){ $col_class = 'col-md-6';}
						elseif( $footer_cols == 1 ){ $col_class = 'col-md-12';}
						/* GET COLUMN CLASS BASED ON THE NUMBER OF COLUMNS SELECTED */
						
					?>	
					<?php for( $i=1; $i<=$footer_cols; $i++ ):?>
					<div class="<?php _e( $col_class );?>">
						<?php dynamic_sidebar( 'sidebar-footer-'.$i ); ?>
					</div>
					<?php endfor;?>
				</div>
			</div>
		</div>
		<div class="custom">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<?php dynamic_sidebar('sidebar-footer-4'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="fixed">
			<div class="container">
				<a href="http://www.akvo.org" target="_blank">Powered by akvo.org</a>
				<p class="small">some rights reserved</p>
			</div>
		</div>
	</footer>
	
</body>
</html>
<?php wp_footer();?>
<style>
	
	body.single-post.body-header5 #main-page-container{
		padding-left: 0;
		padding-right: 0;
	}
	
	.hero-image{
		background-repeat: repeat;
	}
	.hero-image .container{
		position: relative;
		height: 100vh;
	}
	.hero-image .caption{
		position: absolute;
		bottom: 10%;
		left: 0;
		box-sizing: border-box;
		z-index: 10;
	}
	.hero-image h1{
		padding-left: 5px;
		padding-right: 5px;
		font-size: 70px;
		line-height: 1.4;
		background: #fff;
	}
	
	.single .author-info{
		margin: 20px 0;
	}
	
	.single .post-content{
		padding: 20px 0;
	}
	
	.single .entry-content{
		padding: 15px 0;
	}
</style>