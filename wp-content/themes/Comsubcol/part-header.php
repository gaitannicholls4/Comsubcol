<header class="site-header">
	<div id="main-header" class="main-header header-sticky">
		<div class="inner-header container clearfix">
			<div class="logo">
				<a href="/comsubcol"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" title="<?php bloginfo(title); ?>" alt="<?php bloginfo(title); ?>"></a>
			</div>
			<div class="header-right-toggle pull-right hidden-md hidden-lg">
				<a href="javascript:void(0)" class="side-menu-button"><i class="fa fa-bars"></i></a>
			</div>
			<nav class="main-navigation text-left hidden-xs hidden-sm">
				<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
			</nav>
		</div>
	</div>
</header>