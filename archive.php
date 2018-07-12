<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">

			<?php 
			$posttags = get_the_tags();
			$get_post_tags = '';
			if ($posttags) { foreach($posttags as $tag) { $get_post_tags .= $tag->slug .= ', '; }};

			$query = new WP_Query( array( 
								   'nopaging' => true,
								   //'tag_slug__in' => array($get_post_tags)
			 ) );
			if ( $query->have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title">
					<?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'design' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'design' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'design' ) ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'design' ), get_the_date( _x( 'Y', 'yearly archives date format', 'design' ) ) );

						else :
							single_cat_title();

						endif;
					?>
				</h2>
			</header><!-- .page-header -->

			<ul class="masonry">
			<?php
			
			$query = new WP_Query( array( 
								   'nopaging' => true,
								   'tag_slug__in' => single_cat_title( '', false )
			 ) );
					// Start the Loop.
					while ( $query->have_posts() ) : $query->the_post(); ?>

                            <li id="post-<?php the_ID(); ?>" <?php post_class( 'brick' ); ?>>
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                                    <div class="entry-thumbnail">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                    <?php endif; ?>
                            
                                    <h3 class="entry-title">
                                        <?php the_title(); ?>
                                    </h3>
                                </a>
                            </li><!-- #post -->
					
					<?php endwhile;
				echo "</ul>";

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content/content', 'none' );

				wp_reset_postdata();

				endif;
			?>
	</section><!-- #primary -->

<?php
get_footer();
