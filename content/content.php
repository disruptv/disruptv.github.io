<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 * 
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.1
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php design_post_thumbnail(); ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="content-wrapper">
        <div class="entry-content">
            <?php
                the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'design' ) );
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'design' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
            ?>
        <?php if ( is_single() ) : 
        	echo '<span class="disclaimer">*Disclaimer: Content updates are the responsibility of the End User unless otherwise specified.</span>';
        endif; ?>
        </div><!-- .entry-content -->
    
        <div class="entry-meta">
            <?php the_tags('<ul class="services"><h1>Services</h1><li class="service">','</li><li class="service">','</li></ul>'); ?>
            <?php if ( get_post_meta( $post->ID, 'url', true ) || get_post_meta( $post->ID, 'URL', true ) != "" ) :?>
            	<a href="<?php echo get_post_meta( $post->ID, "url", true ); ?>" target="new" class="button">View Website</a>
        	<?php endif; ?>
        </div><!-- #content-sidebar -->
	</div>
	<?php endif; ?>

</article><!-- #post-## -->
