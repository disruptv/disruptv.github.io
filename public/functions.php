<?php 
if( !function_exists('disruptv_setup') ) {
  function disruptv_setup() {
    load_theme_textdomain( 'disruptv' );

    add_theme_support( 'custom-logo' );
    add_theme_support( 'title-tag' );
    // add_theme_support( 'custom-background' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'customize-selective-refresh-widgets' );  
    add_theme_support(
      'html5',
      array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
      )
    );  
  
    register_nav_menus([
      'site-nav'  => 'Site Nav',
      'social-links'  => 'Social Links',
    ]);
  }
}
add_action('after_setup_theme', 'disruptv_setup');

function disruptv_register_scripts() {
  wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/07e616e69d.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'disruptv_register_scripts');

// Add new rest routes
require_once( dirname(__FILE__) . '/admin/api/routes.php');

// Add admin extras
require_once( dirname(__FILE__) . '/admin/editor/index.php');
