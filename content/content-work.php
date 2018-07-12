<h1 class="text-center"><?php the_title(); ?></h1>
<?php
$work_args = array(
	'post_type'	=> 'work',
	'posts_per_page' => -1
);
$work = new WP_Query( $work_args );

if( $work->have_posts() ) : ?>
<div id="projects" class="clearfix">
	<?php while( $work->have_posts() ) : $work->the_post(); ?>
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small' ); ?>
		<figure id="project-<?php the_ID();?>" class="project small-6 medium-3 columns">			
	        <a href="<?php the_permalink(); ?>">
				<div class="project-image" style="background-image:url(<?php echo $image[0]; ?>)"></div>
				
	            <figcaption class="project-caption">
	                <h2 class="text-hide"><?php the_title(); ?></h2>
	            </figcaption>
	        </a>
		</figure>
	<?php endwhile; ?> 
</div>
<?php endif; wp_reset_postdata(); ?>
