<?php
  $options =  array(
                'post_type'             =>  ['post'],
                'ignore_sticky_posts'   =>  1,
                'orderby'               =>  'date',
                'order'                 =>  'DESC',
              );
  if ( is_single() ) {
    $options['posts_per_page'] = 2;
  }
  $articles = new WP_Query( $options );
  if( $articles -> have_posts() ) :
    $title = is_single() ? '<p>More</p> Work.' : 'Work.';
  ?>
  <div class="archive"><div class="grid-sizer section-title"><?php echo $title; ?></div>
    <?php while( $articles -> have_posts() ) : $articles -> the_post();
          $background_image = get_post_thumbnail_id();
          $background_image = wp_get_attachment_url($background_image);
          $style = "background-image:url({$background_image})";
          $sticky = is_sticky() ? 'is-sticky' : '';
    ?>
      <article <?php post_class($sticky); ?>>
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="<?php echo $style; ?>"><?php the_post_thumbnail(); ?></div>
          <div class="meta">
            <h2 class="title"><?php the_title(); ?></h2>
            <div class="excerpt"><?php the_excerpt(); ?></div>
          </div>
        </a>
      </article>
    <?php endwhile; ?>
  </div>
  <?php else: ?>
    Nothing found.
  <?php endif;
wp_reset_postdata(); ?>
