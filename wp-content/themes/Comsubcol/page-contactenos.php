<?php

/*

Template Name: Contactenos

*/

?>
<?php get_header(); ?>
	<div id="page-heading" class="contactenos">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>CONTÁCTENOS</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
<div id="map"></div>

				<div class="contact-form">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<div class="contact-form">
									<form id="contact_form" action="#" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-6 col-sm-12 col-xs-12">
												<input type="text" class="name" name="s" placeholder="First name" value="">
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<input type="text" class="email" name="s" placeholder="Email address" value="">
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<input type="text" class="site" name="s" placeholder="Phone" value="">
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<input type="text" class="phone" name="s" placeholder="Your website	" value="">
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<textarea id="message" class="message" name="message" placeholder="Write message"></textarea>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="advanced-button">
													<a href="#">Send Message<i class="fa fa-paper-plane"></i></a>
												</div>
											</div>
										</div>
									</form>		
								</div>
							</div>
							<div class="col-md-4">
								<div class="contact-info">
									<div class="phone">
										<h4>Phone</h4>
										<span>+33 20966400 1342</span>
									</div>
									<div class="fax">
										<h4>Fax</h4>
										<span>+33 20966400 1342</span>
									</div>
									<div class="email">
										<h4>Email</h4>
										<a href="#">info@auction.com</a>
									</div>
									<div class="address">
										<h4>Address</h4>
										<span>2855 Simpson Square<br>Coldwater, OK 67029</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<!-- Google Map Init-->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize() {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<?php get_footer(); ?>