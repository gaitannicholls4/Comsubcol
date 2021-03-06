<!-- Begin Custom -->
	<?php
	ob_start();
	echo '<style> #comments { display: none; } </style>';
	$id = get_the_ID();
	global $wpdb;
	if ( !empty( $id ) ) {
		//if single auction page is found do the following
		$GLOBALS['gb_cat_args'] = $wdm_cat_args;
		/*
		 * Download Digital Product File if user authenticated
		 */
		$chk_watchlist = 'n';
		$currency_code = substr( get_option( 'wdm_currency' ), -3 );
		$currency_code_display = '';
		$currency_symbol = '';
		$reverse = '';
		$reverse_enable = apply_filters( 'ua_display_auc_field', $reverse );
		preg_match( '/-([^ ]+)/', get_option( 'wdm_currency' ), $matches );
		$end_time = get_post_meta( $id, 'wdm_listing_ends', true );
		$active_term = wp_get_post_terms( $id, 'auction-status', array( "fields" => "names" ) );
		if ( in_array( 'live', $active_term ) && time() >= strtotime( $end_time ) ) {
			$auto_renew_enable = get_post_meta( $id, 'wdm_enable_auto_renew', true );
			$flag = 0;
			if ( $auto_renew_enable == 1 ) {
				$auto_renew_hr = 0;
				$auto_renew_min = 0;
				$auto_renew_day = 0;
				$count_qry = "SELECT COUNT(bid) FROM {$wpdb->prefix}wdm_bidders WHERE auction_id =" . $id;
				$count_bid = $wpdb->get_var( $count_qry );
				if ( $count_bid <= 0 ) {
					$auto_renew_hr = (int)get_post_meta( $id, 'wdm_auto_renew_hr', true );
					$auto_renew_min = (int)get_post_meta( $id,'wdm_auto_renew_min', true );
					$auto_renew_day = (int)get_post_meta( $id,'wdm_auto_renew_day',true );
					$current_time = date( "Y-m-d H:i:s", time() );
					$new_end_time = date( 'Y-m-d H:i:s', strtotime( '+' . $auto_renew_day . ' days +' . $auto_renew_hr . ' hour +' . $auto_renew_min . ' minutes', strtotime( $current_time ) ) );
					update_post_meta( $id, 'wdm_listing_ends', $new_end_time );
					$wpdb->query( $wpdb->prepare("
						UPDATE {$wpdb->prefix}wdm_auctions_live
						SET end_date = %s
						WHERE auc_id =  %d",
						$new_end_time,
						$id
					) );
					$flag = 1;
				}
			}
			if ( !in_array( 'expired', $active_term ) && $flag == 0 ) {
				$check_tm = term_exists( 'expired', 'auction-status' );
				wp_set_post_terms( $id, $check_tm["term_id"], 'auction-status' );
				wdm_expire_auctions( $id, $end_time );
			}
		}
		if ( isset( $matches[ 1 ] ) ) {
			$currency_symbol = $matches[ 1 ];
		}
		if ( empty( $currency_symbol ) ) {
			$currency_symbol = $currency_code . ' ';
		} else {
			if ( $currency_symbol == '$' || $currency_symbol == 'kr' ) {
				$currency_code_display = $currency_code;
			}
		}
		if ( isset( $_GET[ 'rnr' ] ) && $_GET[ 'rnr' ] == 'shw') {
			require 'review-rating.php';
		} elseif ( is_user_logged_in() && isset( $_GET[ 'mt' ] ) && !empty( $_GET[ 'mt' ] ) ) {
			$wdm_auction = get_post( $id );
			if ( $wdm_auction ) {
				$curr_user = wp_get_current_user();
				$buyer_email = $curr_user->user_email;
				//$winner_name = $curr_user->user_login;
				$ret_url = get_permalink( $wdm_auction->ID );
				$check_method = get_post_meta( $id, 'wdm_payment_method', true );
				_e('Thank you for buying this product.', 'wdm-ultimate-auction');
				echo '<br /><br />';
				$auc_post = get_post( $id );
				$auction_author_id = $auc_post->post_author;
				$auction_author = new WP_User( $auction_author_id );
				if ( $check_method === 'method_wire_transfer' ) {
					$mthd = __('Wire Transfer', 'wdm-ultimate-auction');
					if ( in_array( 'administrator', $auction_author->roles ) ) {
						$det = get_option( 'wdm_wire_transfer' );
					} else {
						$det = get_user_meta( $auction_author_id, 'wdm_wire_transfer', true );
					}
				} elseif ( $check_method === 'method_mailing' ) {
					$mthd = __('Cheque', 'wdm-ultimate-auction');
					if ( in_array( 'administrator', $auction_author->roles ) ) {
						$det = get_option( 'wdm_mailing_address' );
					} else {
						$det = get_user_meta( $auction_author_id, 'wdm_mailing_address', true );
					}
				} elseif ( $check_method === 'method_cash' ) {
					$mthd = __('Cash', 'wdm-ultimate-auction');
					if ( in_array( 'administrator', $auction_author->roles ) ) {
						$det = get_option('wdm_cash');
					} else {
						$det = get_user_meta( $auction_author_id, 'wdm_cash', true );
					}
				}
				$mthd = '<strong>' . $mthd . '</strong>';
				printf( __('You can make the payment by %s', 'wdm-ultimate-auction'), $mthd );
				if ( !empty( $det ) ) {
					echo '<br /><br /><strong>' . __('Details') . ':</strong> <br/>' . $det;
				}
				echo '<br /><br /><a href="' . get_permalink( $wdm_auction->ID ) . '">' . __('Go Back', 'wdm-ultimate-auction') . '</a>';
				$buy_now_price = get_post_meta( $wdm_auction->ID, 'wdm_buy_it_now', true );
				ultimate_auction_email_template( $wdm_auction->ID, $buy_now_price, $buyer_email, $ret_url );
			}
		} else {
			//if single auction page is found do the following
			global $wpdb;
			$wpdb->hide_errors();
			$wdm_auction = get_post( $id );
			if ( $wdm_auction ) {
				$ret_url = get_permalink( $wdm_auction->ID );
				if ( is_user_logged_in() ) {
					$auction_to_watch = $id;
					$cur_usr_id = get_current_user_id();
					$watch_auctions = get_user_meta( $cur_usr_id, 'wdm_watch_auctions' );
					if ( isset( $watch_auctions[0] ) ) {
						$watch_arr = explode( ' ', $watch_auctions[ 0 ] );
						if ( in_array( $auction_to_watch, $watch_arr ) ) {
							$chk_watchlist = 'y';
						}
					}
				}
				if ( isset( $_GET[ 'add_to_watch' ] ) && $_GET[ 'add_to_watch' ] ) {
					if ( isset( $watch_auctions ) ) {
						if ( $chk_watchlist === 'n' ) {
							$arr = $watch_auctions[ 0 ] . ' ' . $auction_to_watch;
							update_user_meta( $cur_usr_id, 'wdm_watch_auctions', $arr );
							$chk_watchlist = 'y';
						}
					} else {
						update_user_meta( $cur_usr_id, 'wdm_watch_auctions', $auction_to_watch );
						$chk_watchlist = 'y';
					}
				}
				//get auction author    
				$auction_author_id = $wdm_auction->post_author;
				$auction_author = new WP_User( $auction_author_id );
				if ( in_array( 'administrator', $auction_author->roles ) ) {
					$auction_author_email = get_option( 'wdm_auction_email' );
				} else {
					$auction_author_email = $auction_author->user_email;
				}
				//update single auction page url on single auction page visit - if the permalink type is updated we should have appropriate url to be sent in email
				update_post_meta( $wdm_auction->ID, 'current_auction_permalink', get_permalink( $wdm_auction->ID ) );
				//check if start price/opening bid price is set
				$to_bid = get_post_meta( $wdm_auction->ID, 'wdm_opening_bid', true );
				//check if buy now price is set
				$to_buy = get_post_meta( $wdm_auction->ID, 'wdm_buy_it_now', true );
				//latest highest/current price
				$no_bid = 0;
				if ( $reverse_enable == 'no' ) {
					$query = 'SELECT MAX(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
					$curr_price = $wpdb->get_var( $query );
				} else {
					$query = 'SELECT MIN(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
					$curr_price = $wpdb->get_var( $query );
				}
				if ( empty( $curr_price ) ) {
					$curr_price = get_post_meta( $wdm_auction->ID, 'wdm_opening_bid', true );
					$no_bid = 1;
				}
				//total no. of bids
				$qry = 'SELECT COUNT(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
				$total_bids = $wpdb->get_var( $qry );
				//buy now price
				$buy_now_price = get_post_meta( $wdm_auction->ID, 'wdm_buy_it_now', true );
				$check_buy_now_enable = get_post_meta( $wdm_auction->ID, 'wdm_buy_now_auction', true );
				$bef_auc = '';
				$bef_auc = apply_filters( 'wdm_ua_before_single_auction', $bef_auc, $wdm_auction->ID );
				echo $bef_auc;
				?>
				<section class="car-details">
					<div class="container">
						<div class="row">
							<div id="single-car" class="col-md-8">
								<div class="up-content clearfix">
									<h2><?php echo $wdm_auction->post_title; ?></h2>
									<!--<span>$30.000</span>-->
								</div>
								<div class="flexslider">
								<div class="wdm-image-container">
									<?php
									$images = '';
									$ext_imgs = get_post_meta( $wdm_auction->ID, 'wdm_product_image_gallery', true );
									$ec = 0;
									$ec = count( explode( ',', $ext_imgs ) );
									$mnimg = get_post_meta( $wdm_auction->ID, 'wdm-main-image', true );
									$img_arr = array( 'png', 'jpg', 'jpeg', 'gif', 'bmp', 'ico' );
									$vid_arr = array( 'mpg', 'mpeg', 'avi', 'mov', 'wmv', 'wma', 'mp4', '3gp', 'ogm', 'mkv', 'flv' );
									$flg = 0;
									$images .= '<div class="bxslider">';
									for ( $c = 1; $c <= (4 + $ec); ++$c ) {
										if ( $mnimg === 'main_image_' . $c ) {
											$t_ar = array( 'ssn' => ($c - 1) );
											wp_localize_script( 'wdm-custom-js', 'ua_ss_num', $t_ar );
										}
										$imgURL = get_post_meta( $wdm_auction->ID, 'wdm-image-'.$c, true );
										$imgMime = wdm_get_mime_type( $imgURL );
										$img_ext = explode( '.', $imgURL );
										$img_ext = end( $img_ext );
										if ( strpos( $img_ext, '?' ) !== false ) {
											$img_ext = strtolower( strstr( $img_ext, '?', true ) );
										}
										if ( empty( $imgURL ) ) {
											$images .= '';
										} else {
											$flg = 1;
											$images .= '<div class="wdm-slides"><a href="' . get_post_meta( $wdm_auction->ID, 'wdm-image-' . $c, true ) . '" class="auction-main-img-a auction-main-img' . $c . '" rel="gallery">';
											if ( strstr( $imgMime, 'image/' ) || in_array( $img_ext, $img_arr ) ) {
												$images .= '<img class="auction-main-img" src="' . get_post_meta( $wdm_auction->ID, 'wdm-image-' . $c, true ) . '" />';
											} elseif ( strstr( $imgMime, 'video/' ) || in_array( $img_ext, $vid_arr ) ) {
												$images .= '<video class="auction-main-img" style="margin-bottom:0;" controls>
													<source src="' . get_post_meta( $wdm_auction->ID, 'wdm-image-' . $c, true ) . '">
													Your browser does not support the video tag.
													</video>';
											} elseif ( strstr( $imgURL, 'youtube.com' ) || strstr( $imgURL, 'vimeo.com' ) ) {
												$images .= '<img class="auction-main-img"  src="' . plugins_url( 'img/film.png', __FILE__ ) . '" />';
											} else {
												$images .= '<img class="auction-main-img"  src="' . wp_mime_type_icon( $imgMime ) . '" />';
											}
											$images .= '</a></div>';
										}
									}
									$images .= '</div>';
									if ( $flg == 0 ) {
										echo '<style> .wdm-image-container { display: none; } </style>';
									}
									$images .= '<div id="bx-pager">';
									$f = 0;
									$r = 1;
									for ( $c = 1; $c <= (4 + $ec); ++$c ) {
										$imgURL = get_post_meta( $wdm_auction->ID, 'wdm-image-' . $c, true );
										$imgMime = wdm_get_mime_type( $imgURL );
										$img_ext = explode( '.', $imgURL );
										$img_ext = end( $img_ext );
										if ( strpos( $img_ext, '?' ) !== false ) {
											$img_ext = strtolower( strstr( $img_ext, '?', true ) );
										}
										if ( empty( $imgURL ) ) {
											$images .= '';
											$f = 1;
										} else {
											if ( $f == 1 ) {
												$r = $r + 1;
											}
											$images .= '<a data-slide-index="' . ($c - $r) . '" href="">';
											if ( strstr( $imgMime, 'image/' ) || in_array( $img_ext, $img_arr ) ) {
												$images .= '<img class="auction-small-img auction-small-img' . $c . '" src="' . $imgURL . '" />';
											} elseif ( strstr( $imgMime, 'video/' ) || in_array( $img_ext, $vid_arr ) || strstr( $imgURL, 'youtube.com' ) || strstr( $imgURL, 'vimeo.com' ) ) {
												$images .= '<img class="auction-small-img auction-small-img' . $c . '" src="' . plugins_url( 'img/film.png', __FILE__ ) . '" />';
											} else {
												$images .= '<img class="auction-small-img auction-small-img' . $c . '" src="' . wp_mime_type_icon( $imgMime ) . '" />';
											}
											$images .= '</a>';
											$f = 0;
										}
									}
									$images .= '</div>';
									echo $images;
									?>
								</div>
								</div>
								<!--main forms container of single auction page-->
								<div class="wdm-ultimate-auction-container">
									<div class="wdm_single_prod_desc">
										<!--<div class="wdm-single-auction-title" style="float: left;">
											<?php echo $wdm_auction->post_title; ?>
										</div>--> <!--wdm-single-auction-title ends here-->
										<!--<div class="wdm-single-auction-author" style="float: right; padding-top: 5px;">
											<?php
											$author_ID = $wdm_auction->post_author;
											$author_auc = new WP_User( $author_ID );
											$reviews = get_user_meta( $author_ID, 'wdm_seller_review', false );
											//$e_count = count($reviews);
											$e_tot = 0;
											$e_cnt = 0;
											$e_count = 0;
											foreach ( $reviews as $rvs ) {
												$e_tot = $e_tot + $rvs[ 'r' ];
												++$e_cnt;
											}
											$e_count = $e_cnt;
											if ( $e_cnt == 0 ) {
												$e_cnt = 1;
											}
											$e_avg = ( $e_tot / $e_cnt );
											$e_avg = round( $e_avg, 1 );
											$on_wdt = ( $e_avg * 17 );
											$display_name = get_option( 'wdm_auction_uname' );
											if ( isset( $display_name ) && !empty( $display_name ) && $display_name == 'pname' ) {
												$dname = $author_auc->display_name;
											} else {
												$dname = $author_auc->user_login;
											}
											if ( is_user_logged_in() ) {
												$review_link = add_query_arg( array( 'rnr' => 'shw' ), get_permalink( $wdm_auction->ID ) );
												printf( "<span class='wdm_ua_rate_review_link'> " . __('by %s', 'wdm-ultimate-auction') . '</span>', '<a href="' . $review_link . '" title="' . __('Review this seller', 'wdm-ultimate-auction') . '" target="_blank">' . $dname . sprintf( '(' . _n('%s review', '%s reviews', $e_count, 'wdm-ultimate-auction') . ')', $e_count ) . '<br /><div class="ua_rpt ua_avg_rate_stars"><div class="ua_avg_rate_star" style="width: ' . $on_wdt . 'px;"></div><div class="ua_avg_rate_star_off"></div></div><br /></a>' );
											} else {
												printf( "<span class='wdm_ua_rate_review_link'> " . __('by %s', 'wdm-ultimate-auction') . '</span>', '<a href="#ua_login_popup_r" class="login_popup_boxer" title="' . __('Review this seller', 'wdm-ultimate-auction') . '" target="_blank">' . $dname . sprintf( '(' . _n('%s review', '%s reviews', $e_count, 'wdm-ultimate-auction') . ')', $e_count ) . '<br /><div class="ua_rpt ua_avg_rate_stars"><div class="ua_avg_rate_star" style="width: ' . $on_wdt . 'px;"></div><div class="ua_avg_rate_star_off"></div></div><br /></a>');
												echo wdm_ua_add_html_on_feed( 'review' );
											}
											?>
										</div>--> <!--wdm-single-auction-author ends here-->
										<?php
										$ext_html = '';
										$ext_html = apply_filters( 'wdm_ua_text_before_bid_section', $ext_html, $wdm_auction->ID );
										echo $ext_html;
										//get auction-status taxonomy value for the current post - live/expired
										$active_terms = wp_get_post_terms( $wdm_auction->ID, 'auction-status', array( 'fields' => 'names' ) );
										//incremented price value SA
										$reverse_enable = apply_filters( 'ua_display_auc_field', $reverse );
										$inc_price = $curr_price;
										if ( $reverse_enable == 'no' ) {
											$ua_inc_price = get_post_meta( $wdm_auction->ID, 'wdm_incremental_val', true );
											$is_inc_price_enable = get_post_meta( $wdm_auction->ID, 'wdm_enable_inc', true );
											if ( isset( $is_inc_price_enable ) && !empty( $is_inc_price_enable ) ) {
												if ( $ua_inc_price > 0 ) {
													$q = "SELECT MAX(bid) FROM " . $wpdb->prefix . "wdm_bidders WHERE auction_id =" . $wdm_auction->ID;
													$bid_exists = $wpdb->get_var( $q );
													if ( !empty( $bid_exists ) ) {
														$inc_price = $curr_price + $ua_inc_price;
													}
												}
											}
										} else {
											$q = "SELECT MIN(bid) FROM " . $wpdb->prefix . "wdm_bidders WHERE auction_id =" . $wdm_auction->ID;
											$bid_exists = $wpdb->get_var( $q );
											if ( !empty( $bid_exists ) ) {
												$inc_price = $bid_exists;
											}
										}
										$tax = 0;
										$tax_enable = get_option( "wdm_enable_tax" );
										if ( isset( $tax_enable ) && $tax_enable == '1' ) {
											$tax_amt = get_option( "wdm_tax_amt" );
											$tax_type = get_option( "wdm_tax_type" );
										}
										if ( $tax_amt > 0 ) {
											$tax = $winner_bid * ( $tax_amt/ 100 );
										}
										//if the auction has reached it's time limit, expire it
										if ( ( time() >= strtotime( get_post_meta( $wdm_auction->ID, 'wdm_listing_ends', true ) ) ) ) {
											if ( !in_array( 'expired', $active_terms ) ) {
												$check_term = term_exists( 'expired', 'auction-status' );
												wp_set_post_terms( $wdm_auction->ID, $check_term[ 'term_id' ], 'auction-status' );
											}
										}
										$now = time();
										$ending_date = strtotime( get_post_meta( $wdm_auction->ID, 'wdm_listing_ends', true ) );
										//display message for expired auction
										if ( ( time() >= strtotime( get_post_meta( $wdm_auction->ID, 'wdm_listing_ends', true ) ) ) || in_array( 'expired', $active_terms ) ) {
											$seconds = $now - $ending_date;
											$end_tm = 'end_time';
											$rem_tm = wdm_ending_time_calculator( $seconds, $end_tm );
											$auc_time = 'exp';
											?>
											<div class="wdm-auction-ending-time"><?php printf( __('Ended at', 'wdm-ultimate-auction') . ': ' . __('%s ago', 'wdm-ultimate-auction'), '<span class="wdm-single-auction-ending">' . $rem_tm . '</span>'); ?></div>
											<?php if ( !empty( $to_bid ) ) { ?>
											<div class="wdm_bidding_price" style="float: left;">
												<?php if ( $no_bid == 1 ) { ?>
												<strong><?php _e('No Bid', 'wdm-ultimate-auction'); ?></strong>
												<?php } else { ?>
												<strong><?php echo $currency_symbol . number_format( $curr_price, 2, '.', ',' ) . ' ' . $currency_code_display; ?></strong>
												<?php } ?>
											</div>
											<div id="wdm-auction-bids-placed" class="wdm_bids_placed" style="float: right;">
												<a href="#wdm-tab-anchor-id" id="wdm-total-bids-link">
													<?php
													echo $total_bids . ' ';
													echo ( $total_bids == 1 ) ? __('Bid', 'wdm-ultimate-auction') : __('Bids', 'wdm-ultimate-auction');
													?>
												</a>
											</div>
											<br />
											<?php
											}
											$bought = get_post_meta( $wdm_auction->ID, 'auction_bought_status', true );
											$paid_to_seller = get_post_meta( $wdm_auction->ID, 'ua_direct_pay_to_seller', true );
											$check_method = get_post_meta( $wdm_auction->ID, 'wdm_payment_method', true );
											$auth_key = get_post_meta( $wdm_auction->ID, 'wdm-auth-key', true );
											if ( is_user_logged_in() && $bought === 'bought' && isset( $_GET['wdm'] ) && $_GET['wdm'] === $auth_key ) {
												$product_type = get_post_meta( $wdm_auction->ID, 'wdm_product_type', true );
												if ( $product_type == 'digital' ) {
													$url = get_post_meta( $wdm_auction->ID, 'wdm-digital-product-file', true );
													$url = md5( $url );
													printf( '<div class="wdm-mark-red"><a href ="' . add_query_arg( array( 'url' => $url ), $ret_url ) . '">' . __('Click Here to Download the Product File', 'wdm-ultimate-auction') . '</a></div>');
												}
											}
											if ( $bought === 'bought' && $paid_to_seller != 'pay' ) {
												printf( '<div class="wdm-mark-red">' . __('This auction has been bought by paying Buy it Now price %s', 'wdm-ultimate-auction') . '</div>', '[' . $currency_symbol . number_format( $buy_now_price, 2, '.', ',' ) . ' ' . $currency_code_display . ']' );
											} elseif ( get_post_meta( $wdm_auction->ID, 'wdm_auction_expired_by', true ) == 'ua_best_offers' ) {
												$bo_sender_data = get_post_meta( $wdm_auction->ID, 'auction_winner_by_best_offer', true );
												if ( is_array( $bo_sender_data ) ) {
													reset( $bo_sender_data );
													$bo_sender_id = key( $bo_sender_data );
													$bo_sender = get_user_by( 'id', $bo_sender_id );
													$best_offer_price_row = ( isset( $bo_sender_data[ $bo_sender_id ][ 'offer_val' ])) ? $currency_code . ' ' . $bo_sender_data[ $bo_sender_id ][ 'offer_val' ] : '';
													echo "<div class='wdm-auction-bought wdm-mark-red'>" . sprintf( __('This auction has been sold to %s at %s', 'wdm-ultimate-auction'), $bo_sender->user_login, $best_offer_price_row ) . '</div>';
												}
											} else {
												$cnt_qry = 'SELECT COUNT(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
												$cnt_bid = $wpdb->get_var( $cnt_qry );
												if ( $cnt_bid > 0 ) {
													//  $res_price_met = get_post_meta($wdm_auction->ID, 'wdm_lowest_bid', true);
													$is_res_set = get_post_meta( $auc_id, 'wdm_enable_reserve',true );
													if ( isset( $is_res_set ) && $is_res_set == '1' ) {
														$res_price_met = get_post_meta( $wdm_auction->ID, 'wdm_lowest_bid', true );
													} else {
														$res_price_met = 0;
													}
													$win_bid = '';
													if ( $reverse_enable == 'no' ) {
														$bid_q = 'SELECT MAX(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
														if ( $win_bid >= $res_price_met ) {
															$check_winner =1;
														} else {
															$check_winner = 0;
														}
													} else {
														$bid_q = 'SELECT MIN(bid) FROM ' . $wpdb->prefix . 'wdm_bidders WHERE auction_id =' . $wdm_auction->ID;
														$check_winner = 1;
													}
													$win_bid = $wpdb->get_var( $bid_q );
													if ( $check_winner ) {
														$winner_name = '';
														$name_qry = 'SELECT name FROM ' . $wpdb->prefix . 'wdm_bidders WHERE bid =' . $win_bid . ' AND auction_id =' . $wdm_auction->ID . ' ORDER BY id DESC';
														$winner_name = $wpdb->get_var( $name_qry );
														printf( '<div class="wdm-mark-red">' . __('This auction has been sold to %1$s at %2$s.', 'wdm-ultimate-auction') . '</div>', $winner_name, $currency_symbol . number_format( $win_bid, 2, '.', ',' ) . ' ' . $currency_code_display );
													} else {
														echo '<div class="wdm-mark-red">' . __('Auction has expired without reaching its reserve price.', 'wdm-ultimate-auction') . '</div>';
													}
												} else {
													if ( empty( $to_bid ) ) {
														echo '<div class="wdm-mark-red">' . __('Auction has expired without buying.', 'wdm-ultimate-auction') . '</div>';
													} else {
														if ( $bought === 'bought' ) {
															printf( '<div class="wdm-mark-red">' . __('This auction has been bought by paying Buy it Now price %s', 'wdm-ultimate-auction') . '</div>', '[' . $currency_symbol.number_format( $buy_now_price, 2, '.', ',' ) . ' ' . $currency_code_display . ']' );
														} else {
															echo '<div class="wdm-mark-red">' . __('Auction has expired without any bids.', 'wdm-ultimate-auction') . '</div>';
														}
													}
												}
											}
										}
										//Hide text field and button for pending auctions
										elseif ( get_post_status( $wdm_auction->ID ) != 'publish' ) {
											?>
											<div id="wdm_place_bid_section">
												<div class="wdm_reserved_note wdm-mark-red" style="float: left;">
													<em><?php printf( __('Auction status is %s. You can not bid on this.', 'wdm-ultimate-auction'), get_post_status( $wdm_auction->ID ) ); ?></em>
												</div>
											</div>
											<br />
											<?php
										}
										//Hide text field and button for scheduled auctions
										elseif ( in_array( 'scheduled', $active_terms ) ) {
											?>
											<div id="wdm_place_bid_section">
												<div class="wdm_reserved_note wdm-mark-red" style="float: left;">
													<em><?php printf( __('Auction has not been started yet. It will start on %s.', 'wdm-ultimate-auction'), get_post_meta( $wdm_auction->ID, 'wdm_creation_time', true ) ); ?></em>
												</div>
											</div>
											<br />
											<?php
										} else {
											//prepare a format and display remaining time for current auction
											$seconds = $ending_date - $now;
											$end_tm = 'end_time';
											$rem_tm = wdm_ending_time_calculator( $seconds, $end_tm );
											$auc_time = 'live';
											if ( is_user_logged_in() ) {
												$curr_user = wp_get_current_user();
												$auction_bidder_name = $curr_user->user_login;
												$auction_bidder_id = get_current_user_id();
												$auction_bidder_email = $curr_user->user_email;
											}
											?>
											<!--form to place bids-->
											<div class="wdm-auction-ending-time">
												<?php printf( __('Finaliza en: %s', 'wdm-ultimate-auction'), '<span class="wdm-single-auction-ending">' . $rem_tm . '</span>'); ?>
											</div>
											<?php if ( !empty( $to_bid ) ) { ?>
											<div id="wdm_place_bid_section">
												<div class="wdm_bidding_price" style="float: left;">
													<?php if ( $no_bid == 1 ) { ?>
													<strong><?php _e('No Bid', 'wdm-ultimate-auction'); ?></strong>
													<?php } else { ?>
													<strong><?php echo $currency_symbol . number_format( $curr_price, 2, '.', ',' ) . ' ' . $currency_code_display; ?></strong>
													<?php } ?>
												</div>
												<div id="wdm-auction-bids-placed" class="wdm_bids_placed" style="float: right;">
													<a href="#wdm-tab-anchor-id" id="wdm-total-bids-link">
														<?php
														echo $total_bids . ' ';
														echo ( $total_bids == 1 ) ? __('Bid', 'wdm-ultimate-auction') : __('Bids', 'wdm-ultimate-auction');
														?>
													</a>
												</div>
												<?php
												$is_reserve_set = get_post_meta( $wdm_auction->ID, 'wdm_enable_reserve', true );
												if ( isset( $is_reserve_set ) && $is_reserve_set == '1' ) {
													if ( $curr_price >= get_post_meta( $wdm_auction->ID, 'wdm_lowest_bid', true ) ) {
														?>
														<br />
														<div class="wdm_reserved_note wdm-mark-green" style="float: left;">
															<em><?php _e('Reserve price has been met.', 'wdm-ultimate-auction'); ?></em>
														</div>
													<?php } else { ?>
														<div class="wdm_reserved_note wdm-mark-red" style="float: left;">
															<em><?php _e('Reserve price has not been met by any bid.', 'wdm-ultimate-auction'); ?></em>
														</div>
														<?php
													}
												}
												if ( is_user_logged_in() ) {
													wp_enqueue_script( 'place-bid', plugin_dir_url( __FILE__ ) . 'ajax-actions/place-bid.js' );
													wp_localize_script( 'place-bid', 'uabidobj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
														'amt_msg' => __("Please enter your Bid Amount", "wdm-ultimate-auction"),
														'amt_error_msg' => __("Please enter a numeric value", "wdm-ultimate-auction"),
														'another_bidder_msg' => __("Sorry, an another bidder has bid on the previous bid amount. Please enter a bid amount greater than or equal to ", "wdm-ultimate-auction"),
														'amt_greater_msg' =>  __("Please enter a bid amount greater than or equal to ", "wdm-ultimate-auction"),
														'bid_error_msg' =>  __("Please enter a bid amount greater than", "wdm-ultimate-auction"),
														'auc_exp_msg' => __("Sorry, this auction has been expired.", "wdm-ultimate-auction"),
														'bid_not_msg' => __("Sorry, your bid can not be placed. It seems that either a bidder has outbid you or the auction has been expired recently.", "wdm-ultimate-auction"),
														'won_msg' => __("Congratulations! You have won this auction since your bid value has reached the 'Buy it Now' price.", "wdm-ultimate-auction"),
														'bid_not_msg' => __("Sorry, your bid can not be placed. It seems that either a bidder has outbid you or the auction has been expired recently.", "wdm-ultimate-auction"),
														'outbid_msg' => __("Sorry, you have been outbid by the current highest bidder for 'Buy it now' price.", "wdm-ultimate-auction"),
														'autobid_msg' => __("You can be winner if your bid reaches 'Buy it now' price by automatic bidding.", "wdm-ultimate-auction"),
														'outbid_error_msg' => __("You have been outbid by the current highest bidder.", "wdm-ultimate-auction"),
														'bid_placed_msg' => __("Your Bid Placed Successfully!", "wdm-ultimate-auction"),
														'sorry_msg' => __("Sorry, your bid can not be placed", "wdm-ultimate-auction"),
														'auction_bidder_email' => $auction_bidder_email,
														'auction_bidder_name' => $auction_bidder_name,
														'auction_id' => $wdm_auction->ID,
														'auction_author_email' => $auction_author_email,
														'auction_bidder_id' => $auction_bidder_id,
														'buy_now_price' => $to_buy,
														'reverse_enable' => $reverse_enable
													) );
													if ( $curr_user->ID != $wdm_auction->post_author ) {
														?>
														<br />
														<form action="<?php echo dirname(__FILE__); ?>" style="margin-top: 20px;">
															<div class="wdm_bid_val" style="">
																<label for="wdm-bidder-bidval"><?php _e('Bid Value', 'wdm-ultimate-auction'); ?>: </label>
																<input type="text" id="wdm-bidder-bidval" style="width:85px;" placeholder="<?php printf( __('in %s', 'wdm-ultimate-auction'), $currency_code ); ?>" />
																<br />
																<span class="wdm_enter_val_text" style="float: left; width: 200px; height: 50px;">
																	<?php
																	if ( $reverse_enable == 'no' ) {
																		if ( !empty( $bid_exists ) && !empty( $is_inc_price_enable ) ) {
																			?>
																			<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter %.2f or more', 'wdm-ultimate-auction'), $inc_price ); ?>)</small>
																			<?php
																		} else {
																			if ( $no_bid == 1 && !empty( $is_inc_price_enable ) ) {
																				?>
																				<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter equal or more than %.2f', 'wdm-ultimate-auction'), $inc_price ); ?>)</small>
																			<?php } else { ?>
																				<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter more than %.2f', 'wdm-ultimate-auction'), $inc_price); ?>)</small>
																				<?php
																			}
																		}
																	} else { ?>
																		<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter less than %.2f', 'wdm-ultimate-auction'), $inc_price); ?>)</small>
																	<?php } ?>
																		<br />
																		<small>
																			<?php
																			$ehtml = '';
																			$ehtml = apply_filters( 'wdm_ua_text_after_bid_form', $ehtml, $wdm_auction->ID );
																			echo $ehtml;
																			?>
																		</small>
																</span>
															</div>
															<div class="wdm_place_bid" style="float: right;">
																<input type="submit" value="<?php _e('Place Bid', 'wdm-ultimate-auction'); ?>" id="wdm-place-bid-now" />
															</div>
														</form>
														<?php
														//require 'ajax-actions/place-bid.php'; //file to handle ajax requests related to bid placing form
													}
												} else {
													?>
													<br />
													<div class="wdm_bid_val" style="float: left;">
														<label for="wdm-bidder-bidval"><?php _e('Bid Value', 'wdm-ultimate-auction'); ?>: </label>
														<input type="text" id="wdm-bidder-bidval" style="width: 85px;" placeholder="<?php printf( __('in %s', 'wdm-ultimate-auction'), $currency_code ); ?>" />
														<br />
														<span class="wdm_enter_val_text" style="float: right;">
														<?php
														if ( $reverse_enable == 'no' ) {
															if ( !empty( $bid_exists ) && !empty( $is_inc_price_enable ) ) {
																?>
																<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter %.2f or more', 'wdm-ultimate-auction'), $inc_price ); ?>)</small>
																<?php
															} else {
																if ( $no_bid == 1 && !empty( $is_inc_price_enable ) ) {
																	?>
																	<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter equal or more than %.2f', 'wdm-ultimate-auction'), $inc_price ); ?>)</small>
																<?php } else { ?>
																	<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter more than %.2f', 'wdm-ultimate-auction'), $inc_price); ?>)</small>
																	<?php
																}
															}
														} else {
															?>
															<small class="wdm_inc_price" data-wdm-inc-price="<?php echo $inc_price; ?>" >(<?php printf( __('Enter less than %.2f', 'wdm-ultimate-auction'), $inc_price); ?>)</small>
														<?php } ?>
														</span>
													</div>
													<div class="wdm_place_bid" style="float: right; padding-top: 6px;">
														<a class="wdm-login-to-place-bid fancybox-login" href="/iniciar-sesion" data-fancybox-type="iframe"><?php _e('Place Bid', 'wdm-ultimate-auction'); ?></a>
													</div>
													<?php
												}
												?>
												<div class="csc_clear"></div>
											</div> <!--wdm_place_bid_section ends here-->
											<?php } ?>
											<br />
											<?php
											if ( $check_buy_now_enable === '1' ) {
												if ( !empty( $to_buy ) || $to_buy > 0 ) {
													$a_key = get_post_meta( $wdm_auction->ID, 'wdm-auth-key', true );
													$acc_mode = get_option( 'wdm_account_mode' );
													if ( $acc_mode == 'Sandbox' ) {
														$pp_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
													} else {
														$pp_link = 'https://www.paypal.com/cgi-bin/webscr';
													}
													if ( is_user_logged_in() ) {
														$check_method = get_post_meta( $wdm_auction->ID, 'wdm_payment_method', true );
														if ( $check_method == 'method_paypal' ) {
															$ret_url = get_permalink( $wdm_auction->ID );
															// auction owners PayPal email if commission is not set
															$comm_fees = get_option( 'wdm_manage_cm_fees_data' );
															$comm_inv = get_option( 'wdm_manage_comm_invoice' );
															$s_email = $author_auc->user_email;
															$a_email = get_option( 'wdm_auction_email' );
															//Author Paypal email address for embedded PayPal.
															if ( !in_array( 'administrator', $author_auc->roles ) ) {
																$author_paypal_email = get_user_meta( $author_ID, 'auction_user_paypal_email', true );
															} else {
																$author_paypal_email = get_option( 'wdm_paypal_address' );
															}
															$adaptive_payment = true;
															$buy_now_link = '';
															$auction_data = array(
																'auc_id' => $wdm_auction->ID,
																'auc_name' => $wdm_auction->post_title,
																'auc_desc' => $wdm_auction->post_content,
																'auc_bid' => $buy_now_price,
																'auc_tax' => $tax_amt,
																'auc_tax_type' => $tax_type,
																'auc_merchant' => get_option( 'wdm_paypal_address' ),
																'auc_seller' => $author_paypal_email/*$auc_rec_email*/,
																'auc_payer' => $auction_bidder_email,
																'auc_currency' => $currency_code,
																'auc_url' => add_query_arg( array( 'wdm' => $a_key, 'wdmpy' => 'adp' ), $ret_url ),
															);
															if ( $comm_inv == 'Yes' && ( !in_array( 'administrator', $auction_author->roles ) ) ) {
																$buy_now_link = apply_filters( 'ua_adaptive_buy_now_link', $buy_now_link, $auction_data );
															} else {
																unset( $auction_data['auc_merchant'] );
																$auction_data['pay_type'] = 'simple';
																$buy_now_link = apply_filters( 'ua_adaptive_buy_now_link', $buy_now_link, $auction_data );
															}
 															//disable parallel payment for admin
															if ( current_user_can( 'administrator' ) ) {
																unset( $auction_data['auc_merchant'] );
																$auction_data['pay_type'] = 'simple';
															}
															?>
															<!--buy now button-->
															<div id="wdm_buy_now_section">
																<?php if ( $curr_user->ID != $wdm_auction->post_author ) { ?>
																<div id="wdm-buy-line-above" >
																	<?php
																	if ( $adaptive_payment ) {
																		echo $buy_now_link;
																		wp_enqueue_script( 'buy-now-adaptive', plugin_dir_url( __FILE__ ) . 'ajax-actions/buy-now-adaptive.js');
																		wp_localize_script( 'buy-now-adaptive', 'uabuyobj', array( 'ajaxurl' => admin_url('admin-ajax.php'),
																			'auction_data' =>$auction_data,
																			'buy_now_msg' => __('Please wait, you will be redirected to PayPal now.', 'wdm-ultimate-auction')
																		) );
																	} else {
																		?>
																		<form action="<?php echo $pp_link; ?>" method="post" target="_top">
																			<input type="hidden" name="cmd" value="_xclick">
																			<input type="hidden" name="charset" value="utf-8" />
																			<?php if ( $payment_to_bidder ) { ?>
																			<input type="hidden" name="business" value="<?php echo $auc_rec_email; ?>">
																			<?php } else { ?>
																			<input type="hidden" name="business" value="<?php echo get_option( 'wdm_paypal_address' ); ?>">
																			<?php } ?>
																			<!--<input type="hidden" name="lc" value="US">-->
																			<input type="hidden" name="item_name" value="<?php echo $wdm_auction->post_title; ?>">
																			<input type="hidden" name="amount" value="<?php echo $buy_now_price; ?>">
																			<?php
																			$shipping_field = '';
																			echo apply_filters( 'ua_product_shipping_cost_field', $shipping_field, $wdm_auction->ID );
																			$bn_text = sprintf( __('Buy it now for %s%s %s', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price, 2, '.', ',' ), $currency_code_display );
																			$shipAmt = 0;
																			$shipAmt = apply_filters( 'ua_shipping_data_invoice', $shipAmt, $wdm_auction->ID, $auction_bidder_email );
																			if ( $shipAmt > 0 ) {
																				$bn_text = sprintf( __('Buy it now for %s%s %s + %s%s %s(shipping)', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price, 2, '.', ',' ), $currency_code_display, $currency_symbol, number_format( $shipAmt, 2, '.', '.' ), $currency_code_display );
																			}
																			?>
																			<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
																			<input type="hidden" name="return" value="<?php echo $ret_url; ?>">
																			<input type="hidden" name="button_subtype" value="services">
																			<input type="hidden" name="no_note" value="0">
																			<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
																			<input type="submit" value="<?php echo $bn_text; ?>" id="wdm-buy-now-button">
																		</form>
																	<?php } ?>
																</div>
																<?php } ?>
															</div> <!--wdm_buy_now_section ends here-->
															<?php
														} else {
															if ( $check_method === 'method_wire_transfer' ) {
																$mthd = __('Wire Transfer', 'wdm-ultimate-auction');
															} elseif ( $check_method === 'method_mailing' ) {
																$mthd = __('Cheque', 'wdm-ultimate-auction');
															} elseif ( $check_method === 'method_cash' ) {
																$mthd = __('Cash', 'wdm-ultimate-auction');
															}
															$bn_text = sprintf( __('Buy it now for %s%s %s', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price, 2, '.', ',' ), $currency_code_display );
															$shipAmt = 0;
															$shipAmt = apply_filters( 'ua_shipping_data_invoice', $shipAmt, $wdm_auction->ID, $auction_bidder_email );
															if ( $shipAmt > 0 ) {
																$bn_text = sprintf( __('Buy it now for %s%s %s + %s%s %s(shipping)', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price, 2, '.', ',' ), $currency_code_display, $currency_symbol, number_format( $shipAmt, 2, '.', ',' ), $currency_code_display );
															}
															?>
															<div id="wdm_buy_now_section">
																<?php if ( $curr_user->ID != $wdm_auction->post_author ) { ?>
																<div id="wdm-buy-line-above">
																	<form action="<?php echo add_query_arg( array( 'mt' => 'bn', 'wdm' => $a_key ), get_permalink( $wdm_auction->ID ) ); ?>" method="post">
																		<input type="submit" value="<?php echo $bn_text; ?>" id="wdm-buy-now-button">
																	</form>
																</div>
																<?php } ?>
															</div>
															<script type="text/javascript">
																jQuery( document ).ready( function ( $ ) {
																	$( "#wdm-buy-now-button" ).click( function () {
																		var bcnf = confirm( '<?php printf( __('You need to pay %s%s %s amount via %s to %s. If you choose OK, you will receive an email with payment details and auction will expire. Choose Cancel to ignore this buy now transaction.', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price + $shipAmt, 2, '.', ',' ), $currency_code_display, $mthd, $auction_author->user_login ); ?>' );
																		if ( bcnf == true ) {
																			return true;
																		}
																		return false;
																	} );
																} );
															</script>
															<?php
														}
													} else {
														?>
														<div id="wdm_buy_now_section">
															<div id="wdm-buy-line-above">
																<a class="wdm-login-to-buy-now fancybox-login" href="/iniciar-sesion" data-fancybox-type="iframe">
																	<?php printf( __('Buy it now for %s%s %s', 'wdm-ultimate-auction'), $currency_symbol, number_format( $buy_now_price, 2, '.', ',' ), $currency_code_display ); ?>
																</a>
															</div>
														</div>
														<?php
													}
												}
											}
											if ( is_user_logged_in() && $curr_user->ID == $wdm_auction->post_author ) {
												echo "<span style='float: left;'>" . __('Sorry, you can not bid on your own item.', 'wdm-ultimate-auction') . '</span>';
											}
											if ( is_user_logged_in() ) {
												?>
												<div class="wdm-clear">
													<?php if ( isset( $tax_enable ) && $tax_enable == '1' ) { ?>
													<div>
														<span class="wdm-single-auction-tax"><?php printf( __('Tax Rate (exclusive)', 'wdm-ultimate-auction').': ' . __('%s', 'wdm-ultimate-auction'), $tax_amt ); ?>%</span>
													</div>
													<?php
													}
													do_action( 'wdm_ua_ship_short_link', $wdm_auction->ID );
													if ( $chk_watchlist === 'n' ) {
														?>
														<div class="wdm_add_to_watch_div_lin" id="wdm_add_to_watch_div_lin">
															<a href="#" id="wdm_add_to_watch_lin" name="wdm_add_to_watch_lin"><?php _e('Add to Watchlist', 'wdm-ultimate-auction'); ?></a>
														</div>
														<div class="wdm_rmv_frm_watch_div_lin" id="wdm_rmv_frm_watch_div_lin" style="display:none;">
															<a href="#" id="wdm_rmv_frm_watch_lin" name="wdm_rmv_frm_watch_lin"><?php _e('Remove from Watchlist', 'wdm-ultimate-auction'); ?></a>
														</div>
													<?php } else { ?>
														<div class="wdm_add_to_watch_div_lin" id="wdm_add_to_watch_div_lin" style="display: none;">
															<a href="#" id="wdm_add_to_watch_lin" name="wdm_add_to_watch_lin"><?php _e('Add to Watchlist', 'wdm-ultimate-auction'); ?></a>
														</div>
														<div class="wdm_rmv_frm_watch_div_lin" id="wdm_rmv_frm_watch_div_lin">
															<a href="#" id="wdm_rmv_frm_watch_lin" name="wdm_rmv_frm_watch_lin"><?php _e('Remove from Watchlist', 'wdm-ultimate-auction'); ?></a>
														</div>
													<?php } ?>
												</div>
												<?php
											} else {
												echo wdm_ua_add_html_on_feed( 'bid' );
												?>
												<div class="wdm-clear">
													<?php if ( isset( $tax_enable ) && $tax_enable == '1' ) { ?>
													<div>
														<span class="wdm-single-auction-tax"><?php printf( __('Tax Rate (exclusive)', 'wdm-ultimate-auction') . ': ' . __('%s', 'wdm-ultimate-auction'), $tax_amt ); ?> </span>%
													</div>
													<?php
													}
													do_action( 'wdm_ua_ship_short_link', $wdm_auction->ID );
													?>
													<div class="wdm_add_to_watch_div_lout">
														<a href="/iniciar-sesion" class="fancybox-login" data-fancybox-type="iframe" id="wdm_add_to_watch_lout"  name="wdm_add_to_watch_lout" ><?php _e('Add to Watchlist', 'wdm-ultimate-auction'); ?></a>
														<?php echo wdm_ua_add_html_on_feed( 'watchlist' ); ?>
													</div>
												</div>
												<?php
											}
										}
										?>
									</div> <!--wdm_single_prod_desc ends here-->
								</div> <!--wdm-ultimate-auction-container ends here-->
								<div id="wdm_auction_desc_section">
									<div class="wdm-single-auction-description">
										<?php
										if ( is_user_logged_in() ) {
											$wdm_attach_file = get_post_meta( $wdm_auction->ID, 'wdm_product_attachment', true );
											$wdm_attach_file = preg_replace( '/\s+/', '', $wdm_attach_file );
											if ( !empty( $wdm_attach_file ) ) {
												$wdm_attach_lbl = get_post_meta( $wdm_auction->ID, 'wdm_product_attachment_label', true );
												if ( empty( $wdm_attach_lbl ) ) {
													$wdm_attach_lbl = $wdm_attach_file;
												}
												?>
												<a href="<?php echo $wdm_attach_file; ?>" download="<?php echo basename( $wdm_attach_file ); ?>" target="_blank"><img src="<?php echo plugins_url( 'img/pdf.jpg', __FILE__ ); ?>" style="height: 52px;"/></a>
												<?php
											}
										}
										?>
										<!--wdm_auction_desc_section ends here-->
										<?php
										require 'auction-description-tabs.php'; //file to display current auction description tabs section
										?>
										<!--script to show small images in main image container-->
            							<script type="text/javascript">
											jQuery( document ).ready( function ( $ ) {
												var eDays = jQuery( '#wdm_days' );
												var eHours = jQuery( '#wdm_hours' );
												var eMinutes = jQuery( '#wdm_minutes' );
												var eSeconds = jQuery( '#wdm_seconds' );
												var timer;
												timer = setInterval( function () {
													var vDays = parseInt( eDays.html(), 10 );
													var vHours = parseInt( eHours.html(), 10 );
													var vMinutes = parseInt( eMinutes.html(), 10 );
													var vSeconds = parseInt( eSeconds.html(), 10 );
													var ac_time = '<?php echo $auc_time; ?>';
													if ( ac_time == 'live' ) {
														vSeconds--;
														if ( vSeconds < 0 ) {
															vSeconds = 59;
															vMinutes--;
															if ( vMinutes < 0 ) {
																vMinutes = 59;
																vHours--;
																if ( vHours < 0 ) {
																	vHours = 23;
																	vDays--;
																}
															}
														} else {
															if ( vSeconds == 0 && vMinutes == 0 && vHours == 0 && vDays == 0 ) {
																clearInterval( timer );
																window.location.reload();
															}
														}
													}
													else if ( ac_time == 'exp' ) {
														vSeconds++;
														if ( vSeconds > 59 ) {
															vSeconds = 0;
															vMinutes++;
															if ( vMinutes > 59 ) {
																vMinutes = 0;
																vHours++;
																if ( vHours > 23 ) {
																	vHours = 0;
																	vDays++;
																}
															}
														} else {
															if ( vSeconds == 0 && vMinutes == 0 && vHours == 0 && vDays == 0 ) {
																clearInterval( timer );
																window.location.reload();
															}
														}
													}
													eSeconds.html( vSeconds );
													eMinutes.html( vMinutes );
													eHours.html( vHours );
													eDays.html( vDays );
													if ( vDays == 0 ) {
														eDays.hide();
														jQuery( '#wdm_days_text' ).html( ' ' );
													}
													else if ( vDays == 1 || vDays == -1 ) {
														eDays.show();
														jQuery( '#wdm_days_text' ).html( ' <?php _e('día', 'wdm-ultimate-auction'); ?> ' );
													}
													else {
														eDays.show();
														jQuery( '#wdm_days_text' ).html( ' <?php _e('días', 'wdm-ultimate-auction'); ?> ' );
													}
													if ( vHours == 0 ) {
														eHours.hide();
														jQuery( '#wdm_hrs_text' ).html( ' ' );
													}
													else if ( vHours == 1 || vHours == -1 ) {
														eHours.show();
														jQuery( '#wdm_hrs_text' ).html( ' <?php _e('hora', 'wdm-ultimate-auction'); ?> ' );
													}
													else {
														eHours.show();
														jQuery( '#wdm_hrs_text' ).html( ' <?php _e('horas', 'wdm-ultimate-auction'); ?> ' );
													}
													if ( vMinutes == 0 ) {
														eMinutes.hide();
														jQuery( '#wdm_mins_text' ).html( ' ' );
													}
													else if ( vMinutes == 1 || vMinutes == -1 ) {
														eMinutes.show();
														jQuery( '#wdm_mins_text' ).html( ' <?php _e('minuto', 'wdm-ultimate-auction'); ?> ' );
													}
													else {
														eMinutes.show();
														jQuery( '#wdm_mins_text' ).html( ' <?php _e('minutos', 'wdm-ultimate-auction'); ?> ' );
													}
													if ( vSeconds == 0 ) {
														eSeconds.hide();
														jQuery( '#wdm_secs_text' ).html( ' ' );
													}
													else if ( vSeconds == 1 || vSeconds == -1 ) {
														eSeconds.show();
														jQuery( '#wdm_secs_text' ).html( ' <?php _e('segundo', 'wdm-ultimate-auction'); ?>' );
													}
													else {
														eSeconds.show();
														jQuery( '#wdm_secs_text' ).html( ' <?php _e('segundos', 'wdm-ultimate-auction'); ?>' );
													}
												}, 1000 );
											} );
										</script>
									</div>
								</div>
							</div>
							<div id="left-info" class="col-md-4">
								<div class="details">
									<div class="head-side-bar">
										<h4>Detalles</h4>
									</div>
									<div class="list-info">
										<?php echo $wdm_auction->post_content; ?>
										<ul>
											<li><span>Marca:</span>Audi</li>
											<li><span>Año de Fabricación:</span>2015.6.17</li>
											<li><span>Tipo de Gasolina:</span>Corriente</li>
											<li><span>Engranajes:</span>5</li>
											<li><span>Transmisión:</span>Automática</li>
											<li><span>Color:</span>Azul</li>
											<li><span>Economía:</span>12l/City - 10l/hwy</li>
											<li><span>Capacidad Motor:</span>( 179KW / 400BHP )</li>
											<li><span>País de Origen:</span>Alemania</li>
										</ul>
									</div>
									<!--<div class="csc_time_bid">
										PRUEBA
									</div>-->
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}
		}
	}
	$content = ob_get_contents();
	ob_end_clean();
	?>
<!-- End Custom -->