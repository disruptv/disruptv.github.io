<?php
/**
 * Template for display HTML email newsletter pages/posts
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 *
 */

if ( have_posts() ) : the_post();

	$category = get_the_category(); 
	$single_cat = $category[0]->slug;

	if ( $single_cat !== 'newsletters' ) :
		get_template_part( 'newsletter/newsletter', $single_cat );
	
	else:
		
		get_template_part( 'newsletter/newsletter' );
	
	endif;
endif;