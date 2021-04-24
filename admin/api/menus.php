<?php
namespace Disruptv;

add_action( 'rest_api_init', 'Disruptv\register_rest_menus' );
function register_rest_menus() {
  register_rest_route( 'wp/v2', '/menus', array(
    'methods' => 'GET',
    'callback' => 'Disruptv\get_rest_menus',
    'permission_callback' => false,
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
