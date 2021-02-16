<?php
if ( !class_exists() ) :
class Disruptv_Walker_Social_Menu extends Walker {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$atts                 = array();
		$atts['title']        = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']       = '_blank';
		$atts['rel']        	= 'noopener';
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts                 = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$icon = apply_filters( 'the_title', $item->title, $item->ID );
		$icon = strtolower( $icon );
		$icon = explode('.', $icon);
		$icon = "<i class='fab fa-$icon[0]'></i>";

		$item_output .= '<a' . $attributes . '>';
		$item_output .= $icon;
		$item_output .= '</a>';

		$output .= '<li class="Nav--social__item">';
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function enqueue_script(){	
	echo '<script src="https://kit.fontawesome.com/07e616e69d.js" crossorigin="anonymous"></script>';
}
add_action( 'wp_footer', 'enqueue_script' );

endif;

$args = array(
  'container'       => null,
  'menu_class'      => 'Nav--social',
  'theme_location'  => 'social-links',
  'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
  'walker'          => new Disruptv_Walker_Social_Menu(),
);
wp_nav_menu($args);