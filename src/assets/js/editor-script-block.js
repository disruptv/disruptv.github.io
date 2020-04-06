/**
 * Remove squared button style
 *
 * @since Disruptv 4.5.0
 */
/* global wp */
wp.domReady(function() {
  wp.blocks.unregisterBlockStyle('core/button', 'squared');
});
