<?php get_header(); ?>
<?php
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$pageName = $post->post_name;
	
	if ( locate_template( 'template-parts/content-' . $pageName . '.php' ) != '' ) {
		// yep, load the page template
		get_template_part( 'template-parts/content', $pageName );
	} else {
		// nope, load the content
		get_template_part( 'template-parts/content', 'page' );
	}
	
	endwhile; endif;
?>
<?php get_footer(); ?>