<?php
namespace Disruptv;

add_action( 'rest_api_init', 'Disruptv\register_post_custom_fields' );
function register_post_custom_fields() {
  register_rest_field( 
    array('post'), 
    'custom_fields', 
    array(
      'get_callback'    =>  'Disruptv\get_post_custom_fields',
      'update_callback' =>  null,
      'schema'          => null
    ),
  );
}
function get_post_custom_fields( $object, $field_name, $request ) {
  $fields = get_post_meta($object['id']);
  $meta = [];

  foreach($fields as $field => $value) {
    if(substr($field, 0, 1) !== '_'){
      $meta[$field] = $value;
    }
  }

  return $meta;
}
