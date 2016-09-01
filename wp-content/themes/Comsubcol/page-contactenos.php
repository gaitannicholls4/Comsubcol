<?php

/*

Template Name: Contactenos

*/

?>
<?php get_header(); ?>
	<div id="page-heading" class="contactenos">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center black">
					<h1>CONTÁCTENOS</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
	<div id="map"></div>
	<div class="contact-form">
		<div class="container">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</div>
	</div>
	<!-- Begin Google Maps -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEH_WCmITKJzkM2YOmD4b1mPAIqLejO8w"></script>
		<script>
			function initialize() {
				var mapCanvas = document.getElementById('map');
				var mapOptions = {
					center: new google.maps.LatLng(4.7271278, -74.029541),
					zoom: 16,
					scrollwheel: false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				var map = new google.maps.Map(mapCanvas, mapOptions);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	<!-- End Google Maps -->
<?php get_footer(); ?>