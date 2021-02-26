<?php
namespace Disruptv;

class CV {
  public $fields = [
    'company'     => 'string',
    'location'    => 'string',
    'job_title'   => 'string',
    'start_date'  => 'string',
    'end_date'    => 'string',
  ];

  function __construct() {
    add_action('init', [$this, 'register_fields']);

    add_action('load-post.php', [$this, 'cv_in_post_editor']);
    add_action('load-post-new.php', [$this, 'cv_in_post_editor']);
  }

  function register_fields() {  
    foreach( $this->fields as $field => $type ){
      register_meta( 'post', 'disruptv_' . $field, array(
        'type'  => $type,
        'single'  => true,
        'default' => '',
        'sanitize_callback' => false,
        'show_in_rest'  => 'true',
      ));
    }
  }

  function cv_in_post_editor() {
    add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
    add_action('save_post', [$this, 'store_on_save'], 10, 2);
  }

  function add_meta_boxes() {
    add_meta_box(
      'disruptv-CV-box',
      esc_html__( 'CV Fields', 'disruptv' ),
      [$this, 'cv_meta_box_fields'],
      'post',
      'side',
      'high',
    );
  }

  function cv_meta_box_fields($post) { 
    $output = "";

    foreach($this->fields as $key => $value){
      wp_nonce_field( basename( __FILE__ ), 'cv_fields_nonce' );

      $title = ucwords(str_replace("_", " ", $key));
      $key = 'disruptv_' . $key;
      $label = "<label for='$key'>$title</label><br />";

      in_array($key, [
        'disruptv_start_date', 'disruptv_end_date'
      ]) ? $type = 'date' : $type = 'text';

      $field_classes = 'widefat';
      $field = "<input class='$field_classes' type='$type'";
      $field .= "name='$key' id='$key'";
      $field .= "value='" . esc_attr( get_metadata( 'post', $post->ID, $key, true ) ) . "'";
      $field .= "/>";

      $output .= "<p>" . $label . $field . "<p>";
    }
    
    echo $output;
  }

  function store_on_save($post_id, $post) {
    if ( !isset( $_POST['cv_fields_nonce'] ) || !wp_verify_nonce( $_POST['cv_fields_nonce'], basename( __FILE__ ) ) )
      return $post_id;

    $post_type = get_post_type_object( $post->post_type );

    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
      return $post_id;

    foreach( $this->fields as $key => $value){
      $key = 'disruptv_' . $key;

      /* Get the posted data and sanitize it. */
      $input = ( isset( $_POST[$key] ) ? sanitize_text_field( $_POST[$key] ) : ’ );

      /* Get the meta value of the custom field key. */
      $value = get_post_meta( $post_id, $key, true );

      /* If a new meta value was added and there was no previous value, add it. */
      if ( $input && '' == $value )
        add_post_meta( $post_id, $key, $input, true );

      /* If the new meta value does not match the old value, update it. */
      elseif ( $input && $input != $value )
        update_post_meta( $post_id, $key, $input );

      /* If there is no new meta value but an old value exists, delete it. */
      elseif ( '' == $input && $value )
        delete_post_meta( $post_id, $key, $value ); 
    }   
  }
}

$cv = new CV();

