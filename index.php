<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'row' ); ?>>
	<header id="header" role="banner" data-magellan-expedition="fixed">
		<div class="small-10 small-centered columns">
			<h1 class="text-hide"><a id="homelink" href="<?php echo home_url(); ?>"><img class="branding" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" alt="Aaron Salley, web creative" /></a><?php bloginfo(); ?></h1>
			
			<?php wp_nav_menu(array(
				'theme_location' => 'primary',
				'container' => 'nav',
				'container_class' => 'right hide-for-small',
				'menu_class' => 'sub-nav inline-list',
				'walker' => new Magellan_Nav_Menu
			)); ?>
		</div>
	</header>

	<section id="hero" data-parallax="scroll" data-image-src="<?php background_image(); ?>">
	</section>

	<main id="main" class="small-10 small-centered columns" role="main">			
		<?php 
	    // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
	    // This code based on wp_nav_menu's code to get Menu ID from menu slug
	
	    $menu_name = 'primary';
	
	    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
		
			foreach ( (array) $menu_items as $key => $menu_item ) {
			    $page_query = new WP_Query(array(
				    'page_id' => $menu_item->object_id,
			    ));
			    
			    if( $page_query->have_posts() ) : while( $page_query->have_posts() ) : $page_query->the_post();
			    	
			    	has_post_thumbnail() ? $bg = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) : $bg='';
			    	$bg ? $bg_url = ' data-parallax="scroll" data-image-src="' . esc_url($bg[0]) . '"' : $bg_url = '';
			    
				    $classes = implode( ' ', get_post_class( 'row', get_the_id() ) );
				    
				    echo '<section id="' . $post->post_name . '" class="' . $classes . '" data-magellan-destination="' . $post->post_name . '"'. $bg_url . '>';
				    
					    get_template_part( 'content/content', $post->post_name );
				    
				    echo '</section>';
				    
			    endwhile; endif; wp_reset_postdata();
			}
		}
		?>
	</main>
	
	<footer id="footer">
	</footer>
	
	<?php wp_footer(); ?>
</body>
</html>