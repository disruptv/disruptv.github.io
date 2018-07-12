<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 */

get_header(); ?>


	<div id="primary" class="content-area">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not Found', 'design' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'design' ); ?></p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->

	</div><!-- #primary -->

<?php
get_footer();
