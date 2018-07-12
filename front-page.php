<?php get_header(); ?>
<section id="home">
	<div class="container">
		<div id="hero">
			<dl class="skill">
				<dt><?php _e( 'developer' ); ?></dt>
				<dd><?php _e( 'Front End Developer focused on lean, semantic storytelling through code.' ); ?></dd>
			</dl>
			<figure class="hero-image">
				<img src="<?php background_image(); ?>" />
			</figure>
			<dl class="skill">
				<dt><?php _e( 'Creative' ); ?></dt>
				<dd><?php _e( 'Multidisciplinary creative with a flare for beautiful, functional user interfaces & experiences.' ); ?></dd>
			</dl>
		</div>
		<?php $projects = array(
				'post_type' => 'work',
				'post__in' => get_option( 'sticky_posts' ),
				'posts_per_page' => 4
			);
		$projects = new WP_Query( $projects );
		if ( $projects -> have_posts() ) : ?>
		<div id="featured-projects" class="portfolio-items archive post-type-archive post-type-archive-work">
			<h2><?php _e( 'Featured Projects' ); ?></h2>
			<?php while ( $projects -> have_posts() ) : $projects -> the_post(); ?>
			<figure <?php post_class( 'portfolio-item' ); ?>>
				<a href="<?php the_permalink(); ?>">
					<div style="background-image: url('<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>');"></div>
					<figcaption><?php the_title(); ?></figcaption>
				</a>
			</figure>
			<?php endwhile; ?>
		</div>
		<?php endif; wp_reset_postdata(); ?>
	</div>
</section>
<?php get_footer(); ?>