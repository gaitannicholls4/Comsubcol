<?php get_header(); ?>
	<body>
		<div class="sidebar-menu-container" id="sidebar-menu-container">
			<div class="sidebar-menu-push">
				<div class="sidebar-menu-overlay"></div>
				<div class="sidebar-menu-inner">
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
					<div class="slider">
						<div class="fullwidthbanner-container">
							<div class="fullwidthbanner">
								<ul>
									<li class="first-slide" data-transition="fade" data-slotamount="10" data-masterspeed="300">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner_1.jpg" data-fullwidthcentering="on" alt="slide">
										<div class="tp-caption first-line lft tp-resizeme start" data-x="left" data-hoffset="0" data-y="160" data-speed="1000" data-start="200" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">Bienvenido a</div>
										<div class="tp-caption second-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="200" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0"><strong>Subastas</strong> Colombia</div>
										<div class="tp-caption third-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="280" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">Visite las diferentes <em>categorías</em> de subasta</div>
										<div class="tp-caption fourth-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="320" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0"><a href="#">Inmbuebles</a></div>
										<div class="tp-caption slider-thumb sfb tp-resizeme start container hidden-xs hidden-sm" data-x="center" data-hoffset="0" data-y="460" data-speed="1000" data-start="2200" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$22'000.000</span>
															<div class="span-bg"></div>
															<h2>Apartamento 120m<sup>2</sup></h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
														</div>
													</div>
												</a>
											</div>
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$32'000.000</span>
															<div class="span-bg"></div>
															<h2>Apartamento 210m<sup>2</sup></h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
														</div>
													</div>
												</a>
											</div>
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$44'000.000</span>
															<div class="span-bg"></div>
															<h2>Apartamento 410m<sup>2</sup></h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
														</div>
													</div>
												</a>
											</div>
										</div>
									</li>
									<li class="first-slide" data-transition="fade" data-slotamount="10" data-masterspeed="300">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner_2.jpg" data-fullwidthcentering="on" alt="slide">
										<div class="tp-caption first-line lft tp-resizeme start" data-x="left" data-hoffset="0" data-y="160" data-speed="1000" data-start="200" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">Bienvenido a</div>
										<div class="tp-caption second-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="200" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0"><strong>Subastas</strong> Colombia</div>
										<div class="tp-caption third-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="280" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">Visite las diferentes <em>categorías</em> de subasta</div>
										<div class="tp-caption fourth-line lfb tp-resizeme start" data-x="left" data-hoffset="0" data-y="320" data-speed="1000" data-start="800" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0"><a href="#">Automóviles y Motos</a></div>
										<div class="tp-caption slider-thumb sfb tp-resizeme start container hidden-xs hidden-sm" data-x="center" data-hoffset="0" data-y="460" data-speed="1000" data-start="2200" data-easing="Power4.easeOut" data-splitin="none" data-splitout="none" data-elementdelay="0" data-endelementdelay="0">
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$22'000.000</span>
															<div class="span-bg"></div>
															<h2>BMW X6 2015</h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
														</div>
													</div>
												</a>
											</div>
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$32'000.000</span>
															<div class="span-bg"></div>
															<h2>Renault Logan 2015</h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">	
														</div>
													</div>
												</a>
											</div>
											<div class="col-md-4">
												<a href="#">
													<div class="thumb-item">
														<div class="top-content">
															<span>$44'000.000</span>
															<div class="span-bg"></div>
															<h2>Ford Focus 2016</h2>
														</div>
														<div class="down-content">
															<p>Sed te idque graecis. Vel ne libris erer<br> dolores, mel graece mel viveo.</p>
															<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
														</div>
													</div>
												</a>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>

				<!--<div id="cta-1">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<p>Owners of salvage-title <em>vehicles</em> will encounter some unique issues.</p>
								<div class="advanced-button">
									<a href="listing-right.html">See all cars<i class="fa fa-car"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>-->

				<!--<section class="why-us">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<div class="left-content">
									<div class="heading-section">
										<h2>Why choose us?</h2>
										<span>Vivamus gravida magna massa in cursus mi vehicula at. Nunc sem quam suscipit</span>
										<div class="line-dec"></div>
									</div>
									<div class="services">
										<div class="col-md-6">
											<div class="service-item">
												<i class="fa fa-bar-chart-o"></i>
												<div class="tittle">
													<h2>Results of Drivers</h2>
												</div>
												<p>Integer nec posuere metus, at feugiat. Sed sodales venenat malesuada.</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="service-item">
												<i class="fa fa-gears"></i>
												<div class="tittle">
													<h2>upgrades performance</h2>
												</div>
												<p>Integer nec posuere metus, at feugiat. Sed sodales venenat malesuada.</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="service-item second-row">
												<i class="fa fa-pencil"></i>
												<div class="tittle">
													<h2>product sellers</h2>
												</div>
												<p>Integer nec posuere metus, at feugiat. Sed sodales venenat malesuada.</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="service-item second-row last-service">
												<i class="fa fa-wrench"></i>
												<div class="tittle">
													<h2>Fast Service</h2>
												</div>
												<p>Integer nec posuere metus, at feugiat. Sed sodales venenat malesuada.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="right-img">
									<img src="http://dummyimage.com/370x340/cccccc/fff.jpg" alt="">
									<div class="img-bg"></div>
								</div>
							</div>
						</div>
					</div>
				</section>-->

				<!--<section class="featured-listing">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="heading-section-2 text-center">
									<h2>Featured Cars Listing</h2>
									<span>Vivamus gravida magna massa in cursus mi vehicula at. Nunc sem quam suscipit</span>
									<div class="dec"><i class="fa fa-car"></i></div>
									<div class="line-dec"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div id="featured-cars">
								<div class="featured-item col-md-15 col-sm-6">
									<img src="http://dummyimage.com/310x210/cccccc/fff.jpg" alt="">
									<div class="down-content">
										<a href="single-list.html"><h2>Mercedes Amg 6.3</h2></a>
										<span>52,000</span>
										<div class="light-line"></div>
										<p>Donec eu nullas sapien pretium volutpat vel quis turpis. Donec vel risus lacinia euismod urna vel fringilla justo.</p>
										<div class="car-info">
											<ul>
												<li><i class="icon-gaspump"></i>Diesel</li>
												<li><i class="icon-car"></i>Sport</li>
												<li><i class="icon-road2"></i>12,000</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="featured-item col-md-15 col-sm-6">
									<img src="http://dummyimage.com/310x210/cccccc/fff.jpg" alt="">
									<div class="down-content">
										<a href="single-list.html"><h2>vw golf VII GTI</h2></a>
										<span>30,000</span>
										<div class="light-line"></div>
										<p>Donec eu nullas sapien pretium volutpat vel quis turpis. Donec vel risus lacinia euismod urna vel fringilla justo.</p>
										<div class="car-info">
											<ul>
												<li><i class="icon-gaspump"></i>Diesel</li>
												<li><i class="icon-car"></i>Sport</li>
												<li><i class="icon-road2"></i>12,000</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="featured-item col-md-15 col-sm-6">
									<img src="http://dummyimage.com/310x210/cccccc/fff.jpg" alt="">
									<div class="down-content">
										<a href="single-list.html"><h2>mercedes amg gt</h2></a>
										<span>65,000</span>
										<div class="light-line"></div>
										<p>Donec eu nullas sapien pretium volutpat vel quis turpis. Donec vel risus lacinia euismod urna vel fringilla justo.</p>
										<div class="car-info">
											<ul>
												<li><i class="icon-gaspump"></i>Diesel</li>
												<li><i class="icon-car"></i>Sport</li>
												<li><i class="icon-road2"></i>12,000</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="featured-item col-md-15 col-sm-6">
									<img src="http://dummyimage.com/310x210/cccccc/fff.jpg" alt="">
									<div class="down-content">
										<a href="single-list.html"><h2>bmw m4 430D</h2></a>
										<span>64,000</span>
										<div class="light-line"></div>
										<p>Donec eu nullas sapien pretium volutpat vel quis turpis. Donec vel risus lacinia euismod urna vel fringilla justo.</p>
										<div class="car-info">
											<ul>
												<li><i class="icon-gaspump"></i>Diesel</li>
												<li><i class="icon-car"></i>Sport</li>
												<li><i class="icon-road2"></i>12,000</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="featured-item col-md-15 hidden-sm">
									<img src="http://dummyimage.com/310x210/cccccc/fff.jpg" alt="">
									<div class="down-content">
										<a href="single-list.html"><h2>audi a6 s-line</h2></a>
										<span>48,000</span>
										<div class="light-line"></div>
										<p>Donec eu nullas sapien pretium volutpat vel quis turpis. Donec vel risus lacinia euismod urna vel fringilla justo.</p>
										<div class="car-info">
											<ul>
												<li><i class="icon-gaspump"></i>Diesel</li>
												<li><i class="icon-car"></i>Sport</li>
												<li><i class="icon-road2"></i>12,000</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>-->

				<!--<section class="blog-news">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="heading-section-2 text-center">
									<h2>Blog News</h2>
									<span>Vivamus gravida magna massa in cursus mi vehicula at. Nunc sem quam suscipit</span>
									<div class="dec"><i class="fa fa-file"></i></div>
									<div class="line-dec"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="left-video">
									<img src="http://dummyimage.com/570x390/cccccc/fff.jpg" alt="">
									<div class="video-content">
										<div class="inner-content">
											<i class="fa fa-play"></i>
											<div class="tittle">
												<a href="single-blog.html"><h2>Hella kogi whatever, small batch pickled</h2></a>
												<ul>
													<li>May 14, 2015</li>
													<li>Posted by <a href="#">Admin</a></li>
													<li>2 Comments</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="blog-item">
									<div class="up-content">
										<ul>
											<li>May 14, 2015</li>
											<li>Posted by <a href="#">Admin</a></li>
										</ul>
										<div class="tittle">
											<a href="single-blog.html"><h2>Normcore pour-over taxidermy twee</h2></a>
										</div>
									</div>
									<p>Praesent mollis at odio in aliquam. Morbi sit amet enim ante. Phasellus commodo urna sed laoreet mauris iaculis blandit. Nulla facilisi. Quisque blandit magna nec</p>
									<a href="single-blog.html">Read More</a>
								</div>
								<div class="blog-item">
									<div class="up-content">
										<ul>
											<li>May 14, 2015</li>
											<li>Posted by <a href="#">Admin</a></li>
										</ul>
										<div class="tittle">
											<a href="single-blog.html"><h2>Retro art party vinyl meditation</h2></a>
										</div>
									</div>
									<p>Praesent mollis at odio in aliquam. Morbi sit amet enim ante. Phasellus commodo urna sed laoreet mauris iaculis blandit. Nulla facilisi. Quisque blandit magna nec</p>
									<a href="single-blog.html">Read More</a>
								</div>
							</div>
						</div>
					</div>
				</section>-->

				<!--<section class="clients">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div id="owl-demo">
									<div class="item">
										<img src="assets/images/client-1.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-2.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-3.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-4.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-5.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-6.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-3.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-2.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-1.png" alt="">
									</div>
									<div class="item">
										<img src="assets/images/client-4.png" alt="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>-->

				<!--<div id="cta-2">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-sm-12">
								<div class="left-content">
									<h2>Subscribe to the auction</h2>
									<form method="get" id="subscribe" class="blog-search">
										<input type="text" class="blog-search-field" name="s" placeholder="E-mail Address" value="">
										<div class="simple-button">
											<a href="#">Subscribe</a>
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="right-content">
									<ul>
										<li><a href="#"><i class="fa fa-facebook"></i></a></li>
										<li><a href="#"><i class="fa fa-flickr"></i></a></li>
										<li><a href="#"><i class="fa fa-twitter"></i></a></li>
										<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
										<li><a href="#"><i class="fa fa-skype"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>-->

				<!--<footer>
					<div class="container">
						<div class="row">
							<div class="col-md-3">
								<div class="about-us">
									<img src="assets/images/logo-2.png" alt="">
									<p>Maecenas ne mollis orci. Phasell iacu sapie non aliquet ex euismo ac.</p>
									<ul>
										<li><i class="fa fa-map-marker"></i>Raver Croft Drive Knoxville, 37921</li>
										<li><i class="fa fa-phone"></i>+55 417-634-7071</li>
										<li><i class="fa fa-envelope-o"></i>contact@auction.com</li>
									</ul>
								</div>
							</div>
							<div class="col-md-3">
								<div class="featured-links">
									<h4>Featured Links</h4>
									<ul>
										<li><a href="#"><i class="fa fa-caret-right"></i>About Us</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Term &amp; Services</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Meet The Team</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Privacy Policy</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Company News</a></li>
									</ul>
									<ul>
										<li><a href="#"><i class="fa fa-caret-right"></i>Shop</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>New Vehicle</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Features</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Promotions</a></li>
										<li><a href="#"><i class="fa fa-caret-right"></i>Contact</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3">
								<div class="latest-news">
									<h4>Latest News</h4>
									<div class="latest-item">
										<img src="http://dummyimage.com/64x64/cccccc/fff.jpg" alt="">
										<a href="single-blog.html"><h6>Hella Kogi Whatever</h6></a>
										<ul>
											<li>24 Sep,2015</li>
											<li>2 comments</li>
										</ul>
									</div>
									<div class="latest-item">
										<img src="http://dummyimage.com/64x64/cccccc/fff.jpg" alt="">
										<a href="single-blog.html"><h6>Retro Art Party</h6></a>
										<ul>
											<li>21 Sep,2015</li>
											<li>2 comments</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="gallery">
									<h4>Gallery</h4>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
									<div class="gallery-item">
										<img src="http://dummyimage.com/60x60/cccccc/fff.jpg" alt="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</footer>-->

				<!--<div id="sub-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<p>Copyrights 2015 <em>Auction</em>. Developed by Robert</p>
							</div>
							<div class="col-md-6 col-sm-12">
								<ul>
									<li><a href="#">Home</a></li>
									<li><a href="#">About Us</a></li>
									<li><a href="#">Services</a></li>
									<li><a href="#">Shop</a></li>
									<li><a href="#">Pages</a></li>
									<li><a href="#">Contact</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>-->

				<a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

			</div>

		</div>

		<nav class="sidebar-menu slide-from-left">
			<div class="nano">
				<div class="content">
					<nav class="responsive-menu">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="about.html">About Us</a></li>
							<li><a href="services.html">Services</a></li>
							<li class="menu-item-has-children"><a href="#">Listing</a>
								<ul class="sub-menu">
									<li><a href="listing-right.html">Sidebar Right</a></li>
									<li><a href="listing-left.html">Sidebar Left</a></li>
									<li><a href="listing-grid.html">Grids System</a></li>
									<li><a href="single-list.html">Car Details</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children"><a href="#">Blog</a>
								<ul class="sub-menu">
									<li><a href="blog-right.html">Classic</a></li>
									<li><a href="blog-grid.html">Grids System</a></li>
									<li><a href="grid-right.html">Grids Sidebar</a></li>
									<li><a href="single-blog.html">Single Post</a></li>
								</ul>
							</li>
							<li><a href="about.html">About</a></li>
							<li><a href="contact.html">Contact</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</nav>

	</div>
<?php get_footer(); ?>