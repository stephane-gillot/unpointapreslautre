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
	wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/main.css?v=' . time(), [ 'parent-style' ], time() );

}

add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_style', 100 );

//++++++++++++++++++++
// Filters
//++++++++++++++++++++

/**
 * Remove the Generate press copyright
 *
 * @return string
 * @author Stéphane Gillot
 */
function upala_custom_copyright() {
	return sprintf(
		'<span class="copyright">&copy; %1$s %2$s</span>',
		date( 'Y' ),
		get_bloginfo( 'name' )
	);
}

add_filter( 'generate_copyright', 'upala_custom_copyright' );

//************************
// Patterns
//************************

function upala_register_my_patterns() {
	register_block_pattern(
		'upala/accordeon',
		[
			'title'   => 'Article Accordéon',
			'content' => '<!-- wp:getwid/accordion -->
<div class="wp-block-getwid-accordion has-icon-left" data-active-element="none"><!-- wp:getwid/accordion-item -->
<div class="wp-block-getwid-accordion__header-wrapper"><span class="wp-block-getwid-accordion__header"><a href="#"><span class="wp-block-getwid-accordion__header-title">Le texte japonais</span><span class="wp-block-getwid-accordion__icon is-active"><i class="fas fa-plus"></i></span><span class="wp-block-getwid-accordion__icon is-passive"><i class="fas fa-minus"></i></span></a></span></div><div class="wp-block-getwid-accordion__content-wrapper"><div class="wp-block-getwid-accordion__content"><!-- wp:paragraph {"placeholder":"Write text…"} -->
	                                                                                                 <p></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:getwid/accordion-item -->

<!-- wp:getwid/accordion-item -->
<div class="wp-block-getwid-accordion__header-wrapper"><span class="wp-block-getwid-accordion__header"><a href="#"><span class="wp-block-getwid-accordion__header-title">La transcription phonétique</span><span class="wp-block-getwid-accordion__icon is-active"><i class="fas fa-plus"></i></span><span class="wp-block-getwid-accordion__icon is-passive"><i class="fas fa-minus"></i></span></a></span></div><div class="wp-block-getwid-accordion__content-wrapper"><div class="wp-block-getwid-accordion__content"><!-- wp:paragraph {"placeholder":"Write text…"} -->
<p></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:getwid/accordion-item -->

<!-- wp:getwid/accordion-item -->
<div class="wp-block-getwid-accordion__header-wrapper"><span class="wp-block-getwid-accordion__header"><a href="#"><span class="wp-block-getwid-accordion__header-title">Notice</span><span class="wp-block-getwid-accordion__icon is-active"><i class="fas fa-plus"></i></span><span class="wp-block-getwid-accordion__icon is-passive"><i class="fas fa-minus"></i></span></a></span></div><div class="wp-block-getwid-accordion__content-wrapper"><div class="wp-block-getwid-accordion__content"><!-- wp:paragraph {"placeholder":"Write text…"} -->
<p></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:getwid/accordion-item --></div>
<!-- /wp:getwid/accordion -->',
		]
	);
}

add_action( 'init', 'upala_register_my_patterns' );
