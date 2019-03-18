<?php
/**
 * Disruptv functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Disruptv
 * @since 1.0.0
 */

/**
 * Disruptv only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'disruptv_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function disruptv_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Disruptv, use a find and replace
		 * to change 'disruptv' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'disruptv', get_template_directory() . '/languages' );

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
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'disruptv' ),
				'footer' => __( 'Footer Menu', 'disruptv' ),
				'social' => __( 'Social Links Menu', 'disruptv' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => true,
				'flex-height' => false,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'disruptv' ),
					'shortName' => __( 'S', 'disruptv' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'disruptv' ),
					'shortName' => __( 'M', 'disruptv' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'disruptv' ),
					'shortName' => __( 'L', 'disruptv' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'disruptv' ),
					'shortName' => __( 'XL', 'disruptv' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'disruptv' ),
					'slug'  => 'primary',
					// 'color' => disruptv_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
				),
				array(
					'name'  => __( 'Secondary', 'disruptv' ),
					'slug'  => 'secondary',
					// 'color' => disruptv_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'disruptv' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'disruptv' ),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __( 'White', 'disruptv' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Create Work post type
		new custom_post_type( 'work', 'work', null, array(
			'menu_icon'	=> 'dashicons-star-filled',
	        'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false, ),
	        'hierarchical' => true,
	        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields', 'excerpt' ),
		) );
		new custom_taxonomy( 'work_platform', 'work', 'platforms', 'platform', array(
			'hierarchical' => true,
	        'show_admin_column'  => true,
		) );
		new custom_taxonomy( 'work_role', 'work', 'roles', 'role', array(
	        'show_admin_column'  => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'disruptv_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function disruptv_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'disruptv' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'disruptv' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'disruptv_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function disruptv_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'disruptv_content_width', 640 );
}
add_action( 'after_setup_theme', 'disruptv_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function disruptv_scripts() {
	wp_enqueue_style( 'disruptv-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_style_add_data( 'disruptv-style', 'rtl', 'replace' );

	wp_enqueue_style( 'disruptv-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	wp_enqueue_script( 'disruptv-scripts', get_template_directory_uri() . '/assets/js/vendors.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	// wp_enqueue_script( 'react', 'https://unpkg.com/react@16/umd/react.production.min.js', array(), '16', true );
	// wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array(), '16', true );
	// wp_enqueue_script( 'react-app', get_template_directory_uri() . '/assets/js/react.js', array(
	// 	'react',
	// 	'react-dom',
	// ), wp_get_theme()->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'disruptv_scripts' );

require get_template_directory() . '/assets/classes/custom-post-type.php';
