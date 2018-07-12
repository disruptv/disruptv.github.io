<?php if ( have_posts() ) : ?>
<?php $terms = get_terms( array(
		'taxonomy' => 'work_platform'
	));
	if ( $terms ) : ?>
<div class="filters">
<?php foreach ( $terms as $term ) { ?>
	<button id="<?php echo $term->slug; ?>" class="button filter"><?php echo $term->name; ?></button>
<?php } ?>
</div>
<?php endif; ?>
<section id="<?php echo $menu_item -> post_name; ?>" class="portfolio-items">
	<?php while ( have_posts() ) : the_post(); ?>
	<figure <?php post_class( 'portfolio-item' ); ?>>
		<a href="<?php the_permalink(); ?>">
			<div style="background-image: url('<?php echo get_the_post_thumbnail_url( $post->ID, array(265,425) ); ?>');"></div>
			<figcaption><?php the_title(); ?></figcaption>
		</a>
	</figure>
	<?php endwhile; ?>
</section>
<?php endif; wp_reset_postdata(); ?>

<?php
/*
//Behance way
$portfolio_items = get_behance( 'aaronsalley' );

print_r($portfolio_items);

if ( $portfolio_items ) : ?>
<section id="<?php echo $menu_item -> post_name; ?>" class="portfolio-items behance">
	<?php foreach ($portfolio_items as $portfolio_item): ?>
	<figure <?php post_class(); ?> style="background-image: url('<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>');">
		<figcaption><?php the_title(); ?></figcaption>
	</figure>
	<?php endforeach; ?>
</section>
<?php endif; ?>