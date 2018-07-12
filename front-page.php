<?php
/**
 * The front page template file
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
        <?php 
        $menu_name = 'primary';
        
        if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
            
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            $ID = array();
            
            foreach( $menu_items as $item ) {
                    $ID[] = $item->object_id;
            }
        
        $args = array( 
            'post_type' => array( 'post', 'page' ),
            'post__in' => $ID, 
            'posts_per_page' => count($ID), 
            'orderby' => 'post__in' );
        $the_query = new WP_Query( $args );
        }
        
        if ( $the_query->have_posts() ) : ?>
        
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
			global $more;
			$more = 0;
			//The code must be inserted ahead of the call the_content, but AFTER the_post()
			
            $about = get_page_by_title( 'About' );
            if ( is_tree( $about->ID ) ) : ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'child' ); ?>>
            <?php else : ?>
            <article id="<?php echo $post->post_name ?>" <?php post_class(); ?>>
            <?php endif; ?>
                <header class="entry-header">
                    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <a href="<?php the_permalink(); ?>"><h1 class="entry-title"><?php the_title(); ?></h1></a>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content( '', FALSE ); ?>
                    
                    <?php if ( $post->post_name == 'work' ) {
                        $posts_args = array(
                            'post_type' => array( 'post' ),
                            'category_name' => 'work',
                            'posts_per_page' => 8,
                            'order_by' => 'modified'
                        );
                        $posts_query = new WP_Query ( $posts_args );
                        
                        if ( $posts_query->have_posts() ) :
                        echo '<ul class="masonry">';
                            /* The loop */
                            while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
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
                            wp_reset_postdata();
                        echo '</ul>';
                        endif;
                    } ?>
                </div><!-- .entry-content -->
            </article><!-- #post -->

        <?php endwhile; ?>
        
        <?php wp_reset_postdata(); ?>
        
        <?php endif; ?>

    </div><!-- #primary -->

<?php get_footer(); ?>