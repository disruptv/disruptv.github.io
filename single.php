<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'portfolio-item' ); ?>>
	<header class="portfolio-item-header">
		<summary class="portfolio-item-summary">
			<h2 class="portfolio-item-title"><?php the_title(); ?></h2>
			<h3>
				<?php if ( get_post_meta( $post->ID, 'url', true) != '' ) { ?>
				<a href="<?php echo get_post_meta( $post->ID, 'url', true); ?>">
				<?php } ?>
					<?php echo get_post_meta( $post->ID, 'company', true); ?>
				<?php if ( get_post_meta( $post->ID, 'url', true) != '' ) { ?>
				</a>
				<?php } ?>
				<small><?php foreach( get_the_terms( $post->ID, 'work_role' ) as $term ){ $terms[] = $term->name; }; echo implode( ', ', $terms ); ?></small>
			</h3>
			
			<?php the_excerpt(); ?>
		</summary>
		<?php the_post_thumbnail( 'full' ); ?>
	</header>
	<?php the_content(); ?>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>