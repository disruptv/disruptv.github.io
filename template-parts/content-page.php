<section id="<?php echo $post->post_name; ?>" <?php post_class(); ?>>
	<article>
		<?php the_post_thumbnail( 'full' ); ?>
		<?php the_content(); ?>
	</article>
</section>