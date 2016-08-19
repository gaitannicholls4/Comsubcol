<?php

/*

Functions for my template

*/

/*
* Function to register my menus
*/
function register_my_menus() {
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
			'categories-menu' => __( 'Categories Menu' )
		)
	);
}
add_action( 'init', 'register_my_menus' );

/*
* Function to add my custom menu item
*/
function my_custom_menu_item( $items, $args ) {
	if ( $args->theme_location == 'main-menu' ) {
		$items .= '<li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'my_custom_menu_item', 10, 2 );