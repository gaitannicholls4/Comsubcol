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
		<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEH_WCmITKJzkM2YOmD4b1mPAIqLejO8w"></script>
		<script>
			function initialize() {
				var mapCanvas = document.getElementById('map');
				var mapOptions = {
					center: new google.maps.LatLng(4.6688381, -74.1512065),
					zoom: 16,
					scrollwheel: false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				var map = new google.maps.Map(mapCanvas, mapOptions);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>-->
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: { lat: 4.6688381, lng: -74.1512065 },
					zoom: 16
				});
				var marker = new google.maps.Marker({
					position: { lat: 4.6688381, lng: -74.1512065 },
					map: map
				});
				attachSecretMessage( marker, 'Av. Centenario # 100 - 78' );
			}
			function attachSecretMessage( marker, secretMessage ) {
				var infowindow = new google.maps.InfoWindow({
					content: secretMessage
				});
				marker.addListener('click', function() {
					infowindow.open( marker.get('map'), marker );
				});
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEH_WCmITKJzkM2YOmD4b1mPAIqLejO8w&callback=initMap&signed_in=true" async defer></script>
	<!-- End Google Maps -->
<?php get_footer(); ?>