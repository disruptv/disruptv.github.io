<?php 
class custom_post_type {

    public function __construct( $post_type, $plural, $singular, $args = array()){
        $this->post_type = $post_type;
        $this->plural = $plural;
        $this->singular = $singular;
        $this->args = $args;
        
        add_action( 'init', array( $this, 'post_type_init' ) );
		add_action( 'after_switch_theme', array( $this, 'rewrite_flush' ) );
    }
    
    public function post_type_init() {
    	if ( ! $this->plural ) {
    		$plural = str_replace( '_', ' ', $this->post_type ) . 's';
    	} else {
    		$plural = $this->plural;
    	};

    	if ( ! $this->singular ) {
    		$singular = str_replace( '_', ' ', $this->post_type );
    	} else {
    		$singular = $this->singular;
    	};

        $labels = array(
            'name'               => _x( ucwords( $plural ), 'post type general name' ),
            'singular_name'      => _x( ucwords( $singular ), 'post type singular name' ),
            'menu_name'          => _x( ucwords( $plural ), 'admin menu' ),
            'add_new'            => _x( 'Add New ', ucwords( $singular ) ),
            'add_new_item'       => __( 'Add New ' . ucwords( $singular ) ),
            'new_item'           => __( 'New ' . ucwords( $singular ) ),
            'edit_item'          => __( 'Edit ' . ucwords( $singular ) ),
            'view_item'          => __( 'View ' . ucwords( $singular ) ),
            'all_items'          => __( 'All ' . ucwords( $plural ) ),
            'search_items'       => __( 'Search ' . ucwords( $plural ) ),
            'parent_item_colon'  => __( 'Parent ' . ucwords( $plural ) . ':' ),
            'not_found'          => __( 'No ' . $plural . ' found.' ),
            'not_found_in_trash' => __( 'No ' . $plural . 's found in Trash.' ),
        );

        $defaults = array(
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => null,
            'rewrite'            => array( 'slug' => $plural, 'with_front' => false, ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
        );
        
        $args = wp_parse_args( $this->args, $defaults );
        
        register_post_type( $this->post_type, $args );
    }

	public function rewrite_flush() {
	
		flush_rewrite_rules();
	
	}
}

class custom_taxonomy {

    public function __construct( $taxonomy, $object_type, $plural, $singular, $args = array()){
        $this->taxonomy = $taxonomy;
		$this->object_type = $object_type;
        $this->plural = $plural;
        $this->singular = $singular;
        $this->args = $args;
        
        add_action( 'init', array( $this, 'taxonomy_init' ) );
		add_action( 'after_switch_theme', array( $this, 'rewrite_flush' ) );
    }
    
    public function taxonomy_init() {
    	if ( ! $this->plural ) {
    		$plural = str_replace( '_', ' ', $this->taxonomy ) . 's';
    	} else {
    		$plural = $this->plural;
    	};

    	if ( ! $this->singular ) {
    		$singular = str_replace( '_', ' ', $this->taxonomy );
    	} else {
    		$singular = $this->singular;
    	};

        $labels = array(
            'name'               => _x( ucwords( $plural ), 'post type general name' ),
            'singular_name'      => _x( ucwords( $singular ), 'post type singular name' ),
            'menu_name'          => _x( ucwords( $plural ), 'admin menu' ),
            'all_items'          => __( 'All ' . ucwords( $plural ) ),
            'edit_item'          => __( 'Edit ' . ucwords( $singular ) ),
            'view_item'          => __( 'View ' . ucwords( $singular ) ),
            'update_item'        => __( 'Update ' . ucwords( $singular ) ),
            'add_new_item'       => __( 'Add New ' . ucwords( $singular ) ),
            'new_item_name'      => __( 'New ' . ucwords( $singular ) ),
            'parent_item'		 => _x( 'Parent ', ucwords( $singular ) ),
            'parent_item_colon'  => __( 'Parent ' . ucwords( $plural ) . ':' ),
            'search_items'       => __( 'Search ' . ucwords( $plural ) ),
            'popular_items'      => __( 'Popular ' . ucwords( $plural ) ),
            'separate_items_with_commas'       => __( 'Separate ' . ucwords( $plural ) . ' with commas' ),
            'add_or_remove_items'       => __( 'Add or remove ' . ucwords( $plural ) ),
            'choose_from_most_used'       => __( 'Choose from the most used ' . ucwords( $plural ) ),
            'not_found'          => __( 'No ' . $plural . ' found.' ),
        );

        $defaults = array(
            'labels'             => $labels,
            'public'             => true,
            'show_admin_column'  => false,
            'hierarchical'       => false,
            'rewrite'            => array( 'slug' => $this->taxonomy . 's', 'with_front' => false, ),
        );
        
        $args = wp_parse_args( $this->args, $defaults );
        
        register_taxonomy( $this->taxonomy, $this->object_type, $args );
    }

	public function rewrite_flush() {
	
		flush_rewrite_rules();
	}
}