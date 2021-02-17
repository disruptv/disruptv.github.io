      <footer class="SiteFooter">
        <div class="SiteFooter__wrapper">
          <div>
            <button><?php _e('Get in Touch'); ?></button>
            <span class="spacer"></span>
            <section>
              <?php the_custom_logo(); ?>
              <address>
                <strong>New York</strong>
                28-07 Jackson Ave, 5th Fl</br>
                Long Island City, NY  11101
              </address>
            </section>
          </div>
          <div>
            <?php get_template_part( 'template_parts/nav', 'site' ); ?>
            <span class="spacer"></span>
            <small>© Copyright Disruptv LLC <?php echo wp_date('Y'); ?></small>
            <?php get_template_part( 'template_parts/nav', 'social' ); ?>
          </div>
        </div>
      </footer>
      </div> <!-- #root -->
    <%= htmlWebpackPlugin.tags.bodyTags %>
    <?php wp_footer(); ?>
  </body>
</html>
