<?php get_header(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header class="header">
      <h2 class="description"><?php the_title(); ?></h2>
      <h3 class="company"><?php echo get_post_meta( get_the_ID(), 'company', true ); ?></h3>
    </header>
    <div class="content"><?php the_content(); ?></div>
  </article>
  <?php get_template_part('template_parts/work','loop'); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
