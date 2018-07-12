<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
	<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '278365669188300');
fbq('track', "PageView");
fbq('track', 'CompleteRegistration');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=278365669188300&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>

<body <?php body_class( 'site' ); ?>>
<div class="off-canvas-wrapper">
	<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<header class="site-header">
			<a href="<?php echo site_url(); ?>" class="design-logo" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/asdesign-logo.png" class="logo" alt="Aaron Salley Design logo" /></a>
			
			<button class="menu-icon" type="button" data-toggle="offCanvasRight"></button>
			
			<?php wp_nav_menu( array('theme_location'=>'main', 'container'=>'nav', 'container_class'=>'site-nav') ); ?>
			<?php wp_nav_menu( array('theme_location'=>'social',  'container_class'=>'social-links') ); ?>
		</header>
			
		<div class="off-canvas position-right" id="offCanvasRight" data-off-canvas data-position="right">
			<?php wp_nav_menu( array('theme_location'=>'main', 'container'=>'nav', 'container_class'=>'site-nav') ); ?>
			<?php wp_nav_menu( array('theme_location'=>'social',  'container_class'=>'social-links') ); ?>
		</div>

		<main class="site-content">
