<?php get_header(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  <?php the_content(); ?>
  <?php $articles = new WP_Query();
        if( $articles -> have_posts() ) : while( $articles -> have_posts() ) : $articles -> the_post(); ?>
          <article>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
          </article>
        <?php endwhile; endif; ?>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
