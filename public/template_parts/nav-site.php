<?php
if ( !class_exists('Disruptv_Walker_Nav_Menu') ) :

class Disruptv_Walker_Nav_Menu extends Walker {

	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$classes = array( 'dropdown-menu' );

		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "<ul$class_names>";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$item_classes   = array();
		$item_classes[] = in_array( 'menu-item-has-children', $item->classes ) ? 'nav-item' : 'nav-item';
		$item_classes[] = in_array( 'current_page_item', $item->classes ) ? 'active' : '';

		$link_classes[] = in_array( 'menu-item-has-children', $item->classes ) ? 'dropdown-item' : 'nav-link';

		$atts                 = array();
		$atts['class']        = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $link_classes ) ) );
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['title']        = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']       = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel']        = 'noopener';
		} else {
			$atts['rel']        = $item->xfn;
		}
		$atts['aria-current'] = $item->current ? 'page' : '';
		$atts                 = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$class_names  = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $item_classes ) ) );
		$class_names  = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= '<li' . $class_names . '>';
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

endif;

$args = array(
  'container'       => null,
  'menu_class'      => 'Nav--site nav align-content-center',
  'theme_location'  => 'site-nav',
  'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
  'walker'          => new Disruptv_Walker_Nav_Menu(),
);
wp_nav_menu($args);