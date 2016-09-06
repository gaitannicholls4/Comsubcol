<?php

/*

Template Name: Buscar

*/

?>
<?php get_header(); ?>
	<div id="page-heading" class="buscar">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center black">
					<h1>BUSCAR</h1>
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
						<?php
						if ( isset( $_POST[ 'item_subasta' ] ) ) {
							$item_subasta = $_POST[ 'item_subasta' ];
						} else {
							$item_subasta = '';
						}
						?>
						<h2><?php echo $item_subasta; ?></h2>
						<div class="dec"><i class="fa fa-search"></i></div>
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
								's' => $item_subasta,
								'posts_per_page' => 9,
								'post_type' => 'ultimate-auction',
								'post_status' => 'publish',
								'auction-status' => 'live',
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