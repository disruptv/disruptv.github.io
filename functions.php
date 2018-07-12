<?php
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'design_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 */
function design_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Design, use a find and replace
	 * to change 'Design' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'design', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1492, 1065, true );

	/*
	 * Enable support for custom backgrounds.
	 */
	$defaults = array(
		'wp-head-callback' => null,
		'default-image' => get_template_directory_uri() . '/img/background.png',
	);
	add_theme_support( 'custom-background', $defaults );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'design' ),
		'social'  => __( 'Social Links Menu', 'design' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', design_fonts_url() ) );
	
	// Create Team post type
	new custom_post_type( 'work', 'work', null, array(
		'menu_icon'	=> 'dashicons-star-filled',
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields' ),
	) );
	new custom_taxonomy( 'work_platform', 'work', 'platforms', 'platform', array(
		'hierarchical' => true,
        'show_admin_column'  => true,
	) );
	new custom_taxonomy( 'work_role', 'work', 'roles', 'role', array(
        'show_admin_column'  => true,
	) );
	
	/*
	 * Register new posts statuses for 'Work' post type (future support).
	 */
	register_post_status( 'Concept' );
	register_post_status( 'In Progress' );
	register_post_status( 'Completed' );
}
endif; // design_setup
add_action( 'after_setup_theme', 'design_setup' );

if ( ! function_exists( 'design_fonts_url' ) ) :
/**
 * Register Google fonts for Theme.
 *
 *
 * @return string Google fonts URL for the theme.
 */
function design_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'design' ) ) {
		$fonts[] = 'Lato:300italic,100italic,300,100';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'design' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Theme 1.1
 */
function design_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'design_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 */
function design_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'design-fonts', design_fonts_url() );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/css/fonts/genericons/genericons.css' );

	// Add Socialico, used in the main stylesheet.
	wp_enqueue_style( 'socialico', get_template_directory_uri() . '/css/fonts/socialico/stylesheet.css' );

	// Load our main stylesheet.
	wp_enqueue_style( 'design-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet & scripts.
	wp_enqueue_style( 'design-ie', get_template_directory_uri() . '/css/ie.css', array( 'design-style' ) );
	wp_style_add_data( 'design-ie', 'conditional', 'lt IE 9' );
	
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/bower_components/modernizr/modernizr.js');
	wp_script_add_data( 'modernizr', 'conditional', 'lt IE 9' );
	
	wp_enqueue_script( 'respond-js', '//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js');
	wp_script_add_data( 'respond-js', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'design-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'design-style' ) );
	wp_style_add_data( 'design-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_style( 'slick', get_template_directory_uri() . '/bower_components/slick.js/slick/slick.css' );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/bower_components/slick.js/slick/slick.min.js', array(), null, true );

	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/bower_components/jquery.scrollTo/jquery.scrollTo.min.js', array(), null, true );

	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/bower_components/parallax.js/parallax.min.js', array(), null, true );

	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/bower_components/foundation/js/foundation.min.js', array(), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'design-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'design_scripts' );

/**
 * New post type class.
 *
 */
require_once 'inc/custom-post-types.php';

/**
 * Implement the Magellan menu.
 *
 */
require get_template_directory() . '/inc/magellan_nav_menu.php';

/*
 * AJAX functions for portfolio items and contact.
 *
 * @since
 */
function ajax_enqueue($hook) {
	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	wp_localize_script( 'design-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ajax_enqueue' );

function project_callback() {
    
	get_template_part( 'content/content', 'project' );
			
	die();
}
add_action( 'wp_ajax_project', 'project_callback' );
add_action( 'wp_ajax_nopriv_project', 'project_callback' );

/*
 * Design login page changes.
 *
 */
function design_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
	        width: 100%;
            background-image: url(<?php echo get_template_directory_uri(); ?>/img/design_monogram.png);
            background-size: contain;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'design_login_logo' );

function design_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'design_login_logo_url' );

function design_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'design_login_logo_url_title' );

/**
 * Returns the first image of a gallery in a content block.
 *
 * @since 4.1
 */
function get_gallery( $size = 'full' ) {
	global $post;
	$content = get_the_content();
	
	if ( has_shortcode( $content, 'gallery' ) ) {
		// Get the gallery from the appropriate content meta box
		preg_match_all('/'.get_shortcode_regex().'/s', $content, $matches);
	
		// Split the image ids into an array and abstract the first value
		preg_match_all('#ids=([\'"])(.+?)\1#is', $matches[0][0], $gallery);
		
		$gallery = explode( ',', $gallery[2][0]);
		
		foreach( $gallery as $image_id ){
			// Get image source and echo it
			$image[] = wp_get_attachment_image( $image_id, $size, false, array() );
		}
		
		$output = implode(' ', $image);
	}
	
	return $output;
}