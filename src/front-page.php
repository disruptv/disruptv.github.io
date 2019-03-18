<?php get_header(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  <div <?php post_class(); ?>>
    <?php the_content(); ?>
  </div>
    <?php $articles = new WP_Query( array(
                        'post_type'             =>  ['post', 'work'],
                        'ignore_sticky_posts'   =>  1,
                        'orderby'               =>  'date',
                        'order'                 =>  'DESC',
                      ));
      if( $articles -> have_posts() ) : ?>
      <div id="archive"><div class="grid-sizer section-title">Work.</div>
        <?php while( $articles -> have_posts() ) : $articles -> the_post();
              $background_image = get_post_thumbnail_id();
              $background_image = wp_get_attachment_url($background_image);
              $style = "background-image:url({$background_image})";
              $sticky = is_sticky() ? 'is-sticky' : '';
        ?>
          <article <?php post_class($sticky); ?>>
            <div class="image" style="<?php echo $style; ?>"><?php the_post_thumbnail(); ?></div>
            <header class="header">
              <h2 class="title"><?php the_title(); ?></h2>
              <div class="excerpt"><?php the_excerpt(); ?></div>
            </header>
          </article>
        <?php endwhile; ?>
      </div>
      <?php else: ?>
        Nothing found.
      <?php endif;
    wp_reset_postdata(); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
