<?php
/**
 * design functions and definitions
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 */

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'design_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features.
 */
function design_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'design', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu().
	register_nav_menus( array(
		'main' => __( 'Primary Navigation Menu' ),
		'social'  => __( 'Social Links Menu' ),
	) );
	
	// Footer widget area.
	register_sidebar( array(
		'name' => __( 'Footer Widgets', 'design' ),
		'id' => 'footer'
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	//add_theme_support( 'custom-header', array( 'width' => 1200, 'height' => 800, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'custom-background', array( 'wp-head-callback' => function() { return false; } ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Create Work post type
	new custom_post_type( 'work', 'work', null, array(
		'menu_icon'	=> 'dashicons-star-filled',
        'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false, ),
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields', 'excerpt' ),
	) );
	new custom_taxonomy( 'work_platform', 'work', 'platforms', 'platform', array(
		'hierarchical' => true,
        'show_admin_column'  => true,
	) );
	new custom_taxonomy( 'work_role', 'work', 'roles', 'role', array(
        'show_admin_column'  => true,
	) );
}
endif; // design_setup
add_action( 'after_setup_theme', 'design_setup' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function design_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'design_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 */
function design_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'design-fonts', get_template_directory_uri() . '/fonts/fonts.css', array( 'design-style' ) );

	// Theme stylesheet.
	wp_enqueue_style( 'design-style', get_stylesheet_uri() );

	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/bower_components/foundation-sites/dist/foundation.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'mititup', get_template_directory_uri() . '/bower_components/mixitup/build/jquery.mixitup.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/bower_components/jquery.scrollTo/jquery.scrollTo.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'design-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'design_scripts' );

require get_template_directory() . '/etc/custom-post-types.php';
require get_template_directory() . '/etc/behance.php';
//require get_template_directory() . '/bower_components/behance-api/dist/behance.php';
