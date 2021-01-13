<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'DISRUPTV_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'DISRUPTV_VERSION', '4.7.1' );
}

if ( ! function_exists( 'disruptv_setup' ) ) :
	function disruptv_setup() {
    $GLOBALS['content_width'] = apply_filters( 'disruptv_content_width', 1440 );

		// Custom logo.
		$logo_width  = 120;
		$logo_height = 90;

		// If the retina setting is active, double the recommended width and height.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width * 2 );
			$logo_height = floor( $logo_height * 2 );
		}
		set_post_thumbnail_size( 1200, 9999 );
		add_image_size( 'disruptv-fullscreen', 1980, 9999 );
    load_theme_textdomain( 'disruptv', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'menus' );

		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'f5efe0',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => $logo_height,
				'width'       => $logo_width,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
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

		/*
		* Adds `async` and `defer` support for scripts registered or enqueued
		* by the theme.
		*/
		$loader = new Disruptv_Script_Loader();
		add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

	}
endif;
add_action( 'after_setup_theme', 'disruptv_setup' );

// Secure the WP frontend.
require get_template_directory() . '/inc/security.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-disruptv-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-disruptv-script-loader.php';

/**
 * Register and Enqueue Scripts.
 */
function disruptv_scripts() {

	wp_enqueue_style( 'disruptv-print', get_template_directory_uri() . '/assets/css/print.css', array(), DISRUPTV_VERSION, 'print' );
	wp_enqueue_style( 'disruptv-screen', get_template_directory_uri() . '/assets/css/screen.css', array(), DISRUPTV_VERSION, 'screen' );
	wp_enqueue_script( 'disruptv-scripts', get_template_directory_uri() . '/assets/js/vendors.js', array(), DISRUPTV_VERSION, true );

	wp_style_add_data( 'disruptv-screen', 'rtl', 'replace' );

	wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
}
add_action( 'wp_enqueue_scripts', 'disruptv_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function disruptv_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'disruptv_skip_link_focus_fix' );

/**
 * Add core support for Elementor
 */
function disruptv_register_elementor_locations( $elementor_theme_manager ) {

	$elementor_theme_manager->register_all_core_location();

}
add_action( 'elementor/theme/register_locations', 'disruptv_register_elementor_locations' );
