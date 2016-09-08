<div class="csc_menu_categories">
	<div class="container">
		<div class="row">
			<div class="col-xs-1 text-center"><a class="btn prev">P</a></div>
			<div class="col-xs-10">
				<?php wp_nav_menu( array( 'theme_location' => 'categories-menu' ) ); ?>
			</div>
			<div class="col-xs-1 text-center"><a class="btn next">N</a></div>
		</div>
	</div>
</div>
<?php
function my_cat_results( $category, $menu ) {
	$my_query = new WP_Query();
	$my_query->query(array(
		'post_type' => 'ultimate-auction',
		'post_status' => 'publish',
		'auction-status' => 'live',
		'ua-auction-category' => $category
	));
	$count = $my_query->found_posts;
	$html = '<script> $( "#menu-item-' . $menu . ' a" ).append( " <strong>( ' . $count . ' )</strong>" ); </script>';
	echo $html;
}
my_cat_results( 'inmuebles', '1360' );
my_cat_results( 'vehiculos', '1361' );
my_cat_results( 'equipos-electronicos-y-de-comunicacion', '1363' );
my_cat_results( 'sector-petrolero', '2080' );
my_cat_results( 'inmobiliarios-oficina', '2084' );
my_cat_results( 'equipos-medicos', '1368' );
my_cat_results( 'maquinaria-y-equipos-especiales', '1364' );
my_cat_results( 'chatarra', '1366' );
my_cat_results( 'obras-de-arte', '2095' );
my_cat_results( 'joyas', '2101' );
my_cat_results( 'vip', '1369' );
?>