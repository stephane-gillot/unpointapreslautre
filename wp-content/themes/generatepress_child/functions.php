<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file. 
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function generatepress_child_enqueue_scripts() {
	if ( is_rtl() ) {
		wp_enqueue_style( 'generatepress-rtl', trailingslashit( get_template_directory_uri() ) . 'rtl.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts', 100 );

function child_theme_enqueue_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/main.css?v=' . time(), array( 'parent-style' ), time() );

}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_style', 100 );

//++++++++++++++++++++
// Filters
//++++++++++++++++++++
add_filter( 'generate_copyright', 'upala_custom_copyright' );
function upala_custom_copyright() {
	return sprintf(
		'<span class="copyright">&copy; %1$s %2$s</span>',
		date( 'Y' ),
		get_bloginfo( 'name' )
	);
}
