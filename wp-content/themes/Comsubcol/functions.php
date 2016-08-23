<?php

/*

Functions for my template

*/

/*
* Function to add my styles files
*/
function my_styles_files() {
	wp_enqueue_style( 'montserrat-css', 'https://fonts.googleapis.com/css?family=Montserrat:400,700', false );
	wp_enqueue_style( 'roboto-css', 'https://fonts.googleapis.com/css?family=Roboto:400,300,500,700', false );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', false );
	wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/assets/css/animate.css', false );
	wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/assets/css/jquery-ui.css', false );
	wp_enqueue_style( 'simple-line-icons-css', get_template_directory_uri() . '/assets/css/simple-line-icons.css', false );
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome.min.css', false );
	wp_enqueue_style( 'icon-font-css', get_template_directory_uri() . '/assets/css/icon-font.css', false );
	wp_enqueue_style( 'auction-css', get_template_directory_uri() . '/assets/css/auction.css', false );
	wp_enqueue_style( 'rs-plugin-css', get_template_directory_uri() . '/assets/rs-plugin/css/settings.css', false );
	wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/assets/js/jquery/fancybox/jquery.fancybox.css', false );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'parent-css', trailingslashit( get_template_directory_uri() ) . 'style.css', false );
	}
	wp_enqueue_style( 'theme-css', get_stylesheet_uri(), false );
}
add_action( 'wp_enqueue_scripts', 'my_styles_files' );

/*
* Function to add my scripts files
*/
function my_scripts_files() {
	wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/assets/js/jquery-1.11.1.min.js', false );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', false );
	wp_enqueue_script( 'rs-plugin-1-js', get_template_directory_uri() . '/assets/rs-plugin/js/jquery.themepunch.tools.min.js', false );
	wp_enqueue_script( 'rs-plugin-2-js', get_template_directory_uri() . '/assets/rs-plugin/js/jquery.themepunch.revolution.min.js', false );
	wp_enqueue_script( 'plugin-js', get_template_directory_uri() . '/assets/js/plugins.js', false );
	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/assets/js/jquery/fancybox/jquery.fancybox.pack.js', false );
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', false );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_files' );

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
		$items .= '<li><a href="#"><i class="fa fa-star"></i></a></li>';
		$items .= '<li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>';
		$items .= '<li><a href="/comsubcol/categorias/wp-admin"><i class="fa fa-user"></i></a></li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'my_custom_menu_item', 10, 2 );