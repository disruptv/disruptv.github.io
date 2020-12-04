<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function secure_wp_head(){
  remove_action( 'wp_head', 'rsd_link' ); // remove really simple discovery link
  remove_action( 'wp_head', 'wp_generator' ); // remove wordpress version
  function remove_wordpress_version_number() {
    return '';
  }
  add_filter( 'the_generator', 'remove_wordpress_version_number' );
    
  remove_action( 'wp_head', 'feed_links', 2 ); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
  remove_action( 'wp_head', 'feed_links_extra', 3 ); // removes all extra rss feed links
  
  remove_action( 'wp_head', 'index_rel_link' ); // remove link to index page
  remove_action( 'wp_head', 'wlwmanifest_link' ); // remove wlwmanifest.xml (needed to support windows live writer)
  
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // remove random post link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // remove parent post link
  remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // remove the next and previous post links
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  add_filter( 'emoji_svg_url', '__return_false' );

  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); // Remove shortlink
}
add_action( 'after_setup_theme', 'secure_wp_head' );

function remove_api_from_head(){
  // Remove the REST API lines from the HTML Header
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

  // Remove the REST API endpoint.
  remove_action( 'rest_api_init', 'wp_oembed_register_route' );

  // Turn off oEmbed auto discovery.
  add_filter( 'embed_oembed_discover', '__return_false' );

  // Don't filter oEmbed results.
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

  // Remove oEmbed discovery links.
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );

  // Remove all embeds rewrite rules.
  add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
  remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
}
add_action( 'after_setup_theme', 'remove_api_from_head');

function cleanup_qstring( $src ) {
  $parts = explode( '?ver', $src );
  return $parts[0];
}
add_filter( 'script_loader_src', 'cleanup_qstring', 15, 1 ); 
add_filter( 'style_loader_src', 'cleanup_qstring', 15, 1 );
