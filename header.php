<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 *
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo home_url();?>" />
    <meta property="og:image" content="<?php echo get_background_image(); ?>" />
    <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
    <meta property="og:description" content="<?php bloginfo( 'description' ); ?>" />
    
	<title><?php wp_title( '|', true, 'right' ); ?></title>
    
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri() . '/img/favicon.png'; ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php get_background_image(); ?>>
<div id="site-body" class="site">
	<?php if ( is_front_page() && have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="leader" <?php post_class(); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->
    </article><!-- #leader -->
    <?php endwhile; endif; ?>
	<header id="site-header" class="site-header" role="banner">
    	<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
        
        <nav class="site-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'depth'=> 1, 'walker'=> new anchors ) ); ?>
        </nav>
    </header><!-- #site-header -->
    
    <div id="site-content" class="site-content">
