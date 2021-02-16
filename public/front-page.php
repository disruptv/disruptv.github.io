<?php get_header(); ?>
<main <?php post_class('home--Splash'); ?>>
  <header class="home__Welcome">
    <h1>
      <small><?php _e('Hey there,'); ?></small>
      <?php the_title(); ?>
    </h1>
  </header>
  <section class="home__Content">
    <?php the_content(); ?>
  </section>
</main>
<?php
  $args = array(
    'post_type' => 'post',
  );
  $projects = new WP_Query( $args );

  if ( $projects -> have_posts() ) : 
?>
<section class="home__Features">
  <?php while ( $projects -> have_posts() ) : $projects -> the_post(); ?>
  <article <?php post_class(); ?>>
    <?php the_post_thumbnail(); ?>
    <h3><?php the_title(); ?></h3>
    <a href="<?php the_permalink(); ?>"></a>
  </article>
  <?php endwhile; wp_reset_postdata(); ?>
</section>
<?php endif; ?>
<a href="" class="home__More">
  <?php _e('Want to see more?'); ?>
</a>
<?php get_footer(); ?>