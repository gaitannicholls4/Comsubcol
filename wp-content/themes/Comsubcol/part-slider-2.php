<?php
$args = array(
	'posts_per_page' => 3,
	'post_type' => 'ultimate-auction',
	'post_status' => 'publish',
	'auction-status' => 'live',
	'ua-auction-category' => 'automoviles',
	'suppress_filters' => false
);
$wdm_auction_array = get_posts( $args );
foreach ( $wdm_auction_array as $wdm_single_auction ) {
	?>
	<div class="col-md-4">
		<a href="<?php echo get_permalink( $wdm_single_auction->ID ); ?>">
			<div class="thumb-item">
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
				<div class="top-content">
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
					<div class="span-bg"></div>
					<h2><?php echo $wdm_single_auction->post_title; ?></h2>
				</div>
				<div class="down-content">
					<p><?php echo $wdm_single_auction->post_excerpt ; ?></p>
				</div>
			</div>
		</a>
	</div>
<?php } ?>