<?php $project = new WP_Query( array( 'post_type' => 'work', 'p' => $_POST[ 'project_id' ] ) );
if( $project->have_posts() ) :	while( $project->have_posts() ) : $project->the_post(); ?>
	<div id="project-gallery" class="medium-8 columns">
		<?php echo get_gallery(); ?>
	</div>
	
	<section class="medium-4 columns text-right">
		<h2 class="project-title"><?php the_title(); ?></h2>
		<div class="project-meta">
			<h3><?php echo get_post_meta( get_the_ID(), 'company' ) ? 'Company: ' . get_post_meta( get_the_ID(), 'company', true ) : ''; ?></h3>
			<h3><?php the_terms( get_the_ID(), 'work_role', 'Role: ', ', '); ?></h3>
			<h3><?php the_terms( get_the_ID(), 'work_platform', 'Platforms: ', ', '); ?></h3>
			<?php if( get_post_meta( get_the_ID(), 'url', true ) ) : ?>
			<a class="button radius" href="<?php echo get_post_meta( get_the_ID(), 'url', true ); ?>" target="_blank" title="Visit site">Visit site</a>
			<?php elseif( get_post_meta( get_the_ID(), 'demo', true ) ) : ?>
			<a class="button radius" href="<?php echo get_post_meta( get_the_ID(), 'demo', true ); ?>" target="_blank" title="Visit site">View demo</a>
			<?php endif; ?>
		</div>
		<div class="project-description">
			<?php 
				preg_match_all('/'.get_shortcode_regex().'/s', get_the_content(), $matches);
				echo apply_filters( 'the_content', str_replace ( $matches[0][0], '', get_the_content() ) );
			?>
		</div>
		<?php edit_post_link(); ?>
		<a class="back" href="#">back</a>
	</section>
<?php endwhile; endif; wp_reset_postdata(); ?>