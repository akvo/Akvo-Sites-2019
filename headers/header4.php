<?php global $akvo;?>
<header role="banner" class="header4">
	<nav class="navbar navbar-fixed-top">
		<div class="container navbar-container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="logobrand">
					<?php get_template_part('partials/logo');?>
				</div>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<?php if( has_nav_menu( 'primary_navigation' ) ){ $akvo->nav_menu(); } ?>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#search-modal"><i class="fa fa-search" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div><!-- /.container -->
	</nav><!-- /.navbar -->
</header>

<div id="search-modal">
	<button type="button" class="close">×</button>
	<form>
        <input type="search" value="" placeholder="type keyword(s) here">
        <button type="submit" class="btn btn-primary searchbutton">Search</button>
    </form>
</div>

<progress value="0" id="progressBar">
	<div class="progress-container">
		<span class="progress-bar"></span>
	</div>		
</progress>
