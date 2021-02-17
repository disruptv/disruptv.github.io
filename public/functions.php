<?php 
if( !function_exists('disruptv_setup') ) {
  function disruptv_setup() {
    load_theme_textdomain( 'disruptv' );

    add_theme_support( 'custom-logo' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-background' );
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

add_action( 'rest_api_init', 'register_rest_images' );
function register_rest_images() {
  register_rest_field( 
    array('post'), 
    'featured_image_url', 
    array(
      'get_callback'    =>  'get_rest_featured_image',
      'update_callback' =>  null,
      'schema'          => null
    ),
  );
}
function get_rest_featured_image( $object, $field_name, $request ) {
  if( $object['featured_media'] ) {
    $img = wp_get_attachment_image_src( 
      $object['featured_media'], 
      'full',
    );
    return $img;
  }

  return false;
}

add_action( 'rest_api_init', 'register_rest_menus' );
function register_rest_menus() {
  register_rest_route( 'wp/v2', '/menus', array(
    'methods' => 'GET',
    'callback' => 'get_rest_menus',
) );
}
function get_rest_menus( $request ) {
  $menus = get_registered_nav_menus();
  $locations = get_nav_menu_locations();

  foreach( $menus as $slug => $name ) {
    if (isset( $locations[$slug] )){
      $object = get_term( $locations[$slug], 'nav_menu' );
      $items = wp_get_nav_menu_items( $object );
      $menus[$slug] = $items;
    }
  }
  return $menus;
}

// TODO: Add custom logo to API