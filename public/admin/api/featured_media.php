<?php
namespace Disruptv;

add_action( 'rest_api_init', 'Disruptv\register_rest_images' );
function register_rest_images() {
  register_rest_field( 
    array('post'), 
    'featured_image_url', 
    array(
      'get_callback'    =>  'Disruptv\get_rest_featured_image',
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
