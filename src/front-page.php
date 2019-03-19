<?php get_header(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  <div <?php post_class(); ?>>
    <?php the_content(); ?>
  </div>
  <?php get_template_part('template_parts/work','loop'); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
