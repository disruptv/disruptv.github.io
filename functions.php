<?php 
/**
 * Aaron Salley Design functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see design_content_width()
 *
 * @since Aaron Salley Design 2014 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 880;
}

if ( ! function_exists( 'design_setup' ) ) :
/**
 * Aaron Salley Design setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Aaron Salley Design 2014 1.0
 */
function design_setup() {

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', design_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'design' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'design_custom_background_args', array(
		'default-color' => 'EAEEEF',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'design_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // design_setup
add_action( 'after_setup_theme', 'design_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return void
 */
function design_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 880;
	}
}
add_action( 'template_redirect', 'design_content_width' );

/**
 * Walker menu for single page display with anchor links.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return void
 */

class anchors extends Walker_Nav_Menu{
	  function start_el( &$output, $item, $depth, $args ){
		   global $wp_query;
		   $indent = ( $depth ) ? str_repeat( "	", $depth ) : '';
		   $class_names = $value = '';
		   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		   $class_names = ' class="'. esc_attr( $class_names ) . '"';
		   $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		   $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		   $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$varpost = get_post( $item->object_id );
				if( is_home() ){
				  $attributes .= ' href="#post-' . $varpost->ID . '"';
				} elseif ( $varpost->post_name == 'contact' ) {
				  $attributes .= ' href="'.home_url().'/#site-footer"';
				} else {
				  $attributes .= ' href="'.home_url().'/#' . $varpost->post_name . '"';
				}
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	 }
}

/** 
 * Creates a tree of child pages for a given ID
 *
 * @since Aaron Salley Design 2014 1.0
 */
function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
	global $post;         // load details about this page
	if( is_page() && ( $post->post_parent == $pid||is_page( $pid ) ) ) 
			   return true;   // we're at the page or at a sub page
	else 
			   return false;  // we're elsewhere
};

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return array An array of WP_Post objects.
 */
function design_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Aaron Salley Design.
	 *
	 * @since Aaron Salley Design 2014 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'design_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return bool Whether there are featured posts.
 */
function design_has_featured_posts() {
	return ! is_paged() && (bool) design_get_featured_posts();
}

/**
 * Register Aaron Salley Design widget areas.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return void
 */
function design_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Aaron_Salley_Design_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'design' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'design' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'design_widgets_init' );

/**
 * Register Lato Google font for Aaron Salley Design.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return string
 */
function design_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'design' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:100,300,400,700,900,100italic,300italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return void
 */
function design_scripts() {
	// Load our reset stylesheet.
	wp_enqueue_style( 'reset-style', get_template_directory_uri(). '/css/reset.css', array() );

	// Add Lato font, used in the main stylesheet.
	wp_register_style( 'Lato-font', design_font_url() );
	wp_enqueue_style( 'Lato-font' );

	// Load our main stylesheet.
	wp_enqueue_style( 'design-style', get_stylesheet_uri(), '', '', 'screen' );
	wp_enqueue_style( 'iOS-style', get_template_directory_uri() . '/css/iOS.css', '', '', 'handheld' );
	
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'design-ie', get_template_directory_uri() . '/css/ie.css', array( 'design-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'design-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'design-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'design-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'design' ),
			'nextText' => __( 'Next', 'design' )
		) );
	}

	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'affix-script', get_template_directory_uri() . '/js/affix.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'localscroll-script', get_template_directory_uri() . '/js/localScroll.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'scrollTo-script', get_template_directory_uri() . '/js/scrollTo.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'init-script', get_template_directory_uri() . '/js/init.js', array( 'jquery' ), '', true );

}
add_action( 'wp_enqueue_scripts', 'design_scripts' );

if ( ! function_exists( 'design_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @return void
 */
function design_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Aaron Salley Design attachment size.
	 *
	 * @since Aaron Salley Design 2014 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'design_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Presence of header image.
 * 2. Index views.
 * 3. Presence of footer widgets.
 * 4. Single views.
 * 5. Featured content layout.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function design_body_classes( $classes ) {
	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'design_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function design_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'design_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Aaron Salley Design 2014 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function design_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'design' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'design_wp_title', 10, 2 );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}



function get_custom_cat_template($single_template) {
     global $post;

       if ( in_category( 'newsletters' )) {
          $single_template = get_template_directory() . '/single-newsletters.php';
     }
     return $single_template;
}

add_filter( "single_template", "get_custom_cat_template" ) ;

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
