<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.0
 */
?>
    </div><!-- #site-content -->
    
    <footer id="site-footer" class="site-footer">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) {  ?>
        <div id="sidebar-1" class="footer-sidebar footer-widget-area widget-area">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div><!-- #footer-sidebar -->
    
    <?php }; ?>
    	<a class="top-link" href="#site-header"><?php _e("ˆ"); ?></a>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>