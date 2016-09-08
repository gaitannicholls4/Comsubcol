<?php

/*

Template Name: Categoria

*/

?>
<?php get_header(); ?>
	<?php
	$post_id = get_the_ID();
	$post = get_post( $post_id );
	$slug = $post->post_name;
	switch ( $slug ) {
		default: $sfx = ''; $icon = 'fa-shopping-cart'; break;
		case 'inmuebles': $sfx = '_inmuebles'; $icon = 'fa-home'; break;
		case 'vehiculos': $sfx = '_vehiculos'; $icon = 'fa-car'; break;
		case 'camiones': $sfx = '_camiones'; $icon = 'fa-car'; break;
		case 'camionetas-y-camperos': $sfx = '_camionetas_y_camperos'; $icon = 'fa-car'; break;
		case 'automoviles': $sfx = '_automoviles'; $icon = 'fa-car'; break;
		case 'buses': $sfx = '_buses'; $icon = 'fa-car'; break;
		case 'motos': $sfx = '_motos'; $icon = 'fa-car'; break;
		case 'equipos-electronicos-y-de-comunicacion': $sfx = '_equipos_electronicos_y_de_comunicacion'; $icon = 'fa-desktop'; break;
		case 'sector-petrolero': $sfx = '_sector_petrolero'; $icon = 'fa-industry'; break;
		case 'inmobiliarios-oficina': $sfx = '_inmobiliarios_oficina'; $icon = 'fa-briefcase'; break;
		case 'equipos-medicos': $sfx = '_equipos_medicos'; $icon = 'fa-medkit'; break;
		case 'maquinaria-y-equipos-especiales': $sfx = '_maquinaria_y_equipos_especiales'; $icon = 'fa-truck'; break;
		case 'chatarra': $sfx = '_chatarra'; $icon = 'fa-cog'; break;
		case 'obras-de-arte': $sfx = '_obras_de_arte'; $icon = 'fa-picture-o'; break;
		case 'joyas': $sfx = '_joyas'; $icon = 'fa-spinner'; break;
		case 'vip': $sfx = '_vip'; $icon = 'fa-star'; break;
	}
	?>
	<div id="page-heading" class="categorias<?php echo $sfx; ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center black">
					<h1>CATEGORÍAS</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
	<?php get_template_part( 'part', 'categorias-menu' ); ?>
	<div class="csc_title_categories">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-section-2 text-center">
						<h2><?php the_title(); ?></h2>
						<div class="dec"><i class="fa <?php echo $icon; ?>"></i></div>
						<div class="line-dec"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="listing-grid">
		<div class="container">
			<div class="row">
				<div id="listing-cars" class="col-md-12">
					<div id="featured-cars">
						<div class="row">
							<?php
							$args = array(
								'posts_per_page' => 9,
								'post_type' => 'ultimate-auction',
								'post_status' => 'publish',
								'auction-status' => 'live',
								'ua-auction-category' => $slug,
								'suppress_filters' => false
							);
							$wdm_auction_array = get_posts( $args );
							foreach ( $wdm_auction_array as $wdm_single_auction ) {
								global $wpdb;
								$act_trm = wp_get_post_terms( $wdm_single_auction->ID, 'auction-status', array("fields" => "names") );
								$query = "SELECT MAX(bid) FROM " . $wpdb->prefix . "wdm_bidders WHERE auction_id =" . $wdm_single_auction->ID;
								$curr_price = $wpdb->get_var( $query );
								?>
							<div class="featured-item col-md-4">
								<?php
								$vid_arr = array('mpg', 'mpeg', 'avi', 'mov', 'wmv', 'wma', 'mp4', '3gp', 'ogm', 'mkv', 'flv');
								$auc_thumb = get_post_meta( $wdm_single_auction->ID, 'wdm_auction_thumb', true );
								$imgMime = wdm_get_mime_type( $auc_thumb );
								$img_ext = explode( ".", $auc_thumb );
								$img_ext = end( $img_ext );
								if ( strpos( $img_ext, '?' ) !== false )
									$img_ext = strtolower( strstr( $img_ext, '?', true ) );
								if ( strstr( $imgMime, "video/" ) || in_array( $img_ext, $vid_arr ) || strstr( $auc_thumb, "youtube.com" ) || strstr( $auc_thumb, "vimeo.com" ) ) {
									$auc_thumb = plugins_url( 'img/film.png', __FILE__ );
								}
								if ( empty( $auc_thumb ) ) {
									$auc_thumb = plugins_url( 'img/no-pic.jpg', __FILE__ );
								}
								?>
								<img src="<?php echo $auc_thumb; ?>" title="<?php echo $wdm_single_auction->post_title; ?>" alt="<?php echo $wdm_single_auction->post_title; ?>" />
								<div class="down-content">
									<a href="<?php echo get_permalink( $wdm_single_auction->ID ); ?>"><h2><?php echo $wdm_single_auction->post_title; ?></h2></a>
									<span>
										<?php
										$currency_symbol = '$';
										$ob = get_post_meta( $wdm_single_auction->ID, 'wdm_opening_bid', true );
										$bnp = get_post_meta( $wdm_single_auction->ID, 'wdm_buy_it_now', true );
										if ( ( !empty( $curr_price ) || $curr_price > 0 ) && !empty( $ob ) )
											echo $currency_symbol . number_format( $curr_price, 2, '.', ',' ) . " " . $currency_code_display;
										elseif ( !empty( $ob ) )
											echo $currency_symbol . number_format( $ob, 0, '.', ',' )/* . " " . $currency_code_display*/;
										elseif ( empty( $ob ) && !empty( $bnp ) )
											printf( __('Buy at %s%s %s', 'wdm-ultimate-auction'), $currency_symbol, number_format( $bnp, 2, '.', ',' ), $currency_code_display );
										?>
									</span>
									<div class="light-line"></div>
									<p><?php echo $wdm_single_auction->post_excerpt ; ?></p>
								</div>
								<?php
								if ( isset( $_GET['listing'] ) && $_GET['listing'] == 'sold' ) {
									echo "";
								} else {
								?>
								<a href="<?php echo get_permalink( $wdm_single_auction->ID ); ?>" class="csc_buttom_bid"><?php ( empty( $ob ) && !empty( $bnp ) ) ? _e('Comprar Ahora', 'wdm-ultimate-auction'): _e('Ofertar en Línea', 'wdm-ultimate-auction') ; ?></a>
								<?php } ?>
								<div class="csc_clear"></div>
								<div class="csc_time_bid">
									<?php
									$now = time();
									$ending_date = strtotime( get_post_meta( $wdm_single_auction->ID, 'wdm_listing_ends', true ) );
									$seconds = $ending_date - $now;
									if ( in_array( 'expired', $act_trm ) ) {
										$seconds = $now - $ending_date;
										$ending_tm = '';
										$ended_at = wdm_ending_time_calculator( $seconds, $ending_tm );
										echo "<span class='wdm-mark-normal'>" . sprintf( __('%s ago', 'wdm-ultimate-auction'), $ended_at ) . "</span>";
									}
									elseif ( $seconds > 0 && !in_array( 'expired', $act_trm ) ) {
										$ending_tm = '';
										$ending_in = wdm_ending_time_calculator( $seconds, $ending_tm );
										echo "<div class='wdm-mark-normal wdm_auc_mid'>" . $ending_in . "</div>";
									}
									else {
										$seconds = $now - $ending_date;
										$ending_tm = '';
										$ended_at = wdm_ending_time_calculator( $seconds, $ending_tm );
										echo "<div class='wdm-mark-normal wdm_auc_mid'>" . sprintf( __('%s ago', 'wdm-ultimate-auction'), $ended_at ) . "</div>";
									}
									?>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>